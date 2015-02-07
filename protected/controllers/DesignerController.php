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
                        'saveEntitiesByAjax'
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
            if(array_key_exists('activitySet',$_GET)){
                $activitySet=ActivitySet::getByName($_GET['activitySet']);
                if($activitySet){
                    $this->render('index',array(
                        'activitySet'=>$activitySet
                    ));
                }
            }
        }else{
            $this->redirect((array('site/index')));
        }
    }
    
    
    /**
    * Guarda un conjunto de entidades en un paso
    */
    public function actionSaveEntitiesByAjax(){
        $success=true;
        //Get the client data
        $dataEntities=$_POST['entities'];
        $stepId=intval($_POST['stepId']);
        
//        print_r($dataEntities);
        
        $step=Step::model()->findByPk($stepId);
        $prevEntities=Entity::getEntitiesByStep($step);
        foreach ($prevEntities as $prevEntity) {
            $prevEntity->delete();
        }
        foreach ($dataEntities as $dataEntity) {
            $entity=new Entity();
//            $entity->content=$dataEntity['content'];
//            $entity->css=$dataEntity['css'];
//            $entity->left=intval($dataEntity['left']);
//            $entity->top=intval($dataEntity['top']);
//            $entity->height=intval($dataEntity['height']);
//            $entity->width=intval($dataEntity['width']);
//            $entity->object_list_id=$objectListId;
            $entity->save();
        }
        //Return the result of save schedule
        echo json_encode(array("success"=>$success));
    }
    
    /**
    * Saves a schedule in database by ajax. Returns true if success
    * @param JSONAjax $schedule JSON with the schedule by ajax
    */
    public function actionLoadStepByAjax(){
        $list=array();
        //Get the client data
        $stepId=intval($_POST['stepId']);
        $step=Step::model()->findByPk($stepId);
        $objects=Object::getObjectsByStep($step);
        foreach ($objects as $object) {
            $list[]=array(
                "id"=>intval($object->id),
                "text"=>array(
                    "content"=>$object->content
                ),
                "css"=>$object->css,
                "left"=>intval($object->left),
                "top"=>intval($object->top),
                "height"=>intval($object->height),
                "width"=>intval($object->width)
            );
        }
        //Retorna los objetos que se hayan encontrado
        echo json_encode(array("objects"=>$list));
    }
}
