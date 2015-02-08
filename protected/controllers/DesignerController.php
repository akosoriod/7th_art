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
        $parentTables=array();  //Tabla para almacenar los id antiguos y nuevos de las entidades
        //Get the client data
        $dataEntities=$_POST['entities'];
        $stepId=intval($_POST['stepId']);
        $step=Step::model()->findByPk($stepId);
        foreach ($step->entities as $prevEntity){
            $this->deleteEntity($prevEntity);
        }
        foreach ($dataEntities as $dataEntity){
            $entity=new Entity();
            $entity->step_id=$step->id;
            $entity->optional=boolval($dataEntity['optional']);
            $entity->countable=boolval($dataEntity['countable']);
            $entity->weight=intval($dataEntity['weight']);
            if(array_key_exists('entityType',$dataEntity)){
                $entityTypeName=$dataEntity['entityType'];
            }else{
                $entityTypeName="basic";
            }
            $entity->entity_type_id=EntityType::getByName($entityTypeName)->id;
            $entity->insert();
            $parentTables[$dataEntity['id']]=$entity->id;
            
            foreach ($dataEntity['states'] as $dataState) {
                $state=new EntityState();
                $state->left=$dataState['pos']['left'];
                $state->top=$dataState['pos']['top'];
                $state->height=$dataState['size']['height'];
                $state->width=$dataState['size']['width'];
                $state->content=$dataState['content'];
                $state->css=$dataState['css'];
                $state->hidden=$dataState['hidden'];
                $state->value=$dataState['value'];
                $state->zindex=$dataState['zindex'];
                $state->entity_state_type_id=EntityStateType::getByName($dataState['type'])->id;
                $state->entity_id=$entity->id;
                if(array_key_exists('valueType',$dataState)){
                    $valueType=ValueType::getByName($dataState['valueType'])->id;
                }else{
                    $valueType=ValueType::getByName($dataState['null'])->id;
                }
                $state->value_type_id=$valueType;
                $state->insert();
            }
        }
        
        //Actualiza los valores de parent
        foreach ($dataEntities as $dataEntity){
            if($dataEntity["parent"]!=="false"){
                $childId=$parentTables[$dataEntity['id']];
                $parentId=$parentTables[intval($dataEntity["parent"])];
                $child=Entity::model()->findByPk($childId);
                $child->parent_id=$parentId;
                $child->update();
            }
        }
        //Return the result of save schedule
        echo json_encode(array("success"=>$success));
    }
    
    /**
     * Elimina una entidad, sus estados y sus subentidades de la base de datos
     * @param Entoty $entity Entidad a borrar
     */
    private function deleteEntity($entity){
        //Elimina las subentidades
        foreach ($entity->entities as $subentity) {
            $this->deleteEntity($subentity);
        }
        //Elimina los estados
        foreach ($entity->entityStates as $state) {
            $state->delete();
        }
        //Elimina la entidad
        $entity->delete();
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
