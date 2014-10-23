<?php
class DesignerController extends Controller {
    
    /**
    * Specifies the access control rules.
    * This method is used by the 'accessControl' filter.
    * @return array access control rules
    */
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                    'actions'=>array(
                        'index',
                        'saveObjectsByAjax'
                    ),
                    'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                    'actions'=>array('admin','delete'),
                    'users'=>array('admin'),
            ),
            array('deny',  // deny all users
                    'users'=>array('*'),
            ),
        );
    }
    
    /**
     * Default action for DesignerController
     */
    public function actionIndex() {
        if(Yii::app()->user->checkAccess('designer')){
            $this->render('index');
        }else{
            $this->redirect((array('site/index')));
        }
    }
    
    
    /**
    * Saves a schedule in database by ajax. Returns true if success
    * @param JSONAjax $schedule JSON with the schedule by ajax
    */
    public function actionSaveObjectsByAjax(){
        $success=true;
        //Get the client data
        $dataObjects=$_POST['objects'];
        $prevObjects=Object::model()->findAll();
        foreach ($prevObjects as $prevObject) {
            $prevObject->delete();
        }
        foreach ($dataObjects as $dataObject) {
            $object=new Object();
            $object->text=$dataObject['text']['content'];
            $object->left=intval($dataObject['left']);
            $object->top=intval($dataObject['top']);
            $object->height=intval($dataObject['height']);
            $object->width=intval($dataObject['width']);
            $object->background=$dataObject['background'];
            $object->border=$dataObject['border'];
            $object->font_size=intval($dataObject['font_size']);
            $object->object_list_id=1;
            $object->save();
        }
        //Return the result of save schedule
        echo json_encode(array("success"=>$success));
    }
}
