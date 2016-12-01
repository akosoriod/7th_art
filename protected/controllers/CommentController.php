<?php

class CommentController extends Controller {
//    public function accessRules() {
//        return array(
//            array('allow', // allow authenticated user to perform 'create' and 'update' actions
//                'actions' => array(
//                    'index',
//                    'createCommentByAjax', "Juanca"
//                ),
//                'users' => array('@'),
//            ),
//            array('deny', // deny all users
//                'users' => array('*'),
//            ),
//        );
//    }

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
        try {
            $model = new Comment;

            $model->category_id = 1;
            $model->comment = "Prueba" + new CDbExpression('NOW()');
            $model->step_id = 2;
            $model->parent_id = 1;
            $model->date = new CDbExpression('NOW()');
            $currentUser = User::getCurrentUser();
            $model->user_id = $currentUser->id;
            $model->insert();
            print CJSON::encode(array('status' => "success", 'comment' => $model));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            print CJSON::encode(array('status' => "error", 'exp' => $exc));
        }
    }

    public function actionJuanca($Comment) {
        print "Extremoduro";
        print $Comment;
//        print JSON::encode(array('status' => "success", 'exp' => "Acá llegó algo"));
    }

    public function actionIndex() {
        print "Hey, listen";
    }

    public function actionCreateCommentByAjax() {
        try {
//            print_r($_POST);
            $c = $_POST['comentario'];
            $model = new Comment;

            $model->category_id = Yii::app()->session['tabid'];
            $model->step_id = $_POST['stepid'];
            $model->parent_id = null;
            $model->date = new CDbExpression('NOW()');
            $currentUser = User::getCurrentUser();
            $model->user_id = $currentUser->id;
            $model->comment = $c . "";
            $model->insert();
            // ------------------------------
            $c = array('comment' => $model->comment,
                'date' => date("Y-m-d H:i:s"),
                'user' => $model['user']->name . " " . $model['user']->lastname,
                'id' => $model->id,
                'own' => true
            );

            print CJSON::encode(array('status' => "success", 'comment' => $c));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            print CJSON::encode(array('status' => "error", 'exp' => $exc));
        }
    }

    public function actionShowCommentsOnTab() {
        $category = Yii::app()->getRequest()->getQuery('tab');
        $model = new Comment;
        $this->renderPartial('/wall/_listComments', array('model' => $model,
            'comments' => $model->with('user')->findAllByAttributes(
                    array('category_id' => $category, 'step_id' => 2), array('order' => 'date DESC')
            ),
            'category' => $category
        ));
    }

    public function actionShowCommentsOnTabByAjax() {
        $limit = false;
        $category = $_POST['tab'];
        $stepid = $_POST['stepid'];

        $paginacion = 20;
        $pagina = intval($_POST['page']);
        $user = User::getCurrentUser();
        $comments = Comment::model()->with('user')->findAllByAttributes(array(
            'category_id' => intval($category),
            'step_id' => intval($stepid)
                ), array('order' => 'date desc',
            'limit' => $paginacion,
            'offset' => $pagina * $paginacion
                )
        );


        $result = array();
        $limit = count($comments) < $paginacion;

        for ($i = 0; $i < count($comments); $i++) {
            $comment = $comments[$i];
            $c = array('comment' => $comment->comment,
                'date' => $comment->date,
                'user' => $comment['user']->name . " " . $comment['user']->lastname,
                'id' => $comment->id,
                'own' => $comment['user']->id == $user->id
            );
            $result[$i] = $c;
        }
        print CJSON::encode(array('status' => "OK", 'comments' => $result, 'limit' => $limit));
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

    public function actionloadTemplate() {
        print $this->renderPartial('/wall/_view');
    }

    public function actionloadNoCommentsBlock() {
        print $this->renderPartial('/wall/_noComments');
    }

    public function actionBorrarComentario() {
        $id = $_POST['id'];
        print Comment::model()->deleteByPk($id);
    }

}
