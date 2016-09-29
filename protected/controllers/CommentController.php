<?php

class CommentController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    /**
     * Find comments by category
     */
    public function actionCreate() {

        $model = new Comment;
        $this->performAjaxValidation($model);

        if (isset($_POST['Comment'])) {

            $model->attributes = $_POST['Comment'];

            // Validate only comment field
            // Ref: http://stackoverflow.com/questions/12912853/yii-validation-of-a-specific-field
            try {
                $valid = $model->validate(array('comment'));

                if ($valid) {

                    $model->date = new CDbExpression('NOW()');

                    $category = Yii::app()->session['tabid'] + 1;
                    $model->category_id = $category;
                    
                    $currentUser = User::getCurrentUser();
                    $model->user_id = $currentUser->id;
                    $status = $model->save() ? 'success' : 'error';
                    print CJSON::encode(array('status' => $status));
                    Yii::app()->end();
                } 
//                else {
//                    $error = CActiveForm::validate($model, array('comment'));
//                    if ($error != '[]') {
//                        echo $error;
//                    }
//                    Yii::app()->end();
//                }
            } catch (Exception $e) {
                echo 'Excepción capturada: ', $e->getMessage(), "\n";
            }
        }
    }

    public function actionShowCommentsOnTab() {
        $category = Yii::app()->getRequest()->getQuery('tab');
        $model = new Comment;
        $this->renderPartial('/wall/_listComments', array('model' => $model,
            'comments' => $model->with('user')->findAllByAttributes(
                    array('category_id' => $category), array('order' => 'date DESC')
            ),
            'category' => $category
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'wall-form') {
            echo CActiveForm::validate($model, array('comment'));
            Yii::app()->end();
        }
    }

    // Ref: http://www.bsourcecode.com/2012/11/how-to-handle-cjuitabs-in-yii/
    /**
     * Set the tab id into session.
     */
    public function actionTabidsession() {
        Yii::app()->session['tabid'] = isset($_GET['tab']) && is_numeric($_GET['tab']) ? $_GET['tab'] : 0;
        return;
    }

}
