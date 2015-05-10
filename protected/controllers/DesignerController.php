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
                        'saveEntitiesByAjax','loadEntitiesByAjax',
                        'createStepByAjax','deleteStepByAjax','updateStepInstructionByAjax',
                        'savePointsByAjax'
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
            $this->redirect((array('site/admin')));
        }
    }
        
    /**
    * Guarda un conjunto de entidades en un paso
    */
    public function actionSaveEntitiesByAjax(){
        $success=true;
        $parentTables=array();  //Tabla para almacenar los id antiguos y nuevos de las entidades
        //Get the client data
        $dataEntities=json_decode($_POST['entities']);
        $stepId=intval($_POST['stepId']);
        $step=Step::model()->findByPk($stepId);
        foreach ($step->entities as $prevEntity){
            $this->deleteEntity($prevEntity);
        }
        foreach ($dataEntities as $dataEntity){
            $entity=new Entity();
            $entity->step_id=$step->id;
            $entity->optional=$dataEntity->optional;
            $entity->countable=$dataEntity->countable;
            $entity->weight=intval($dataEntity->weight);
            if(property_exists($dataEntity,'type')){
                $entityTypeName=$dataEntity->type;
            }else{
                $entityTypeName="basic";
            }
            $entity->entity_type_id=EntityType::getByName($entityTypeName)->id;
            $entity->insert();
            $parentTables[$dataEntity->id]=$entity->id;
            foreach ($dataEntity->states as $dataState) {
                $state=new EntityState();
                $state->left=intval($dataState->pos->left);
                $state->top=intval($dataState->pos->top);
                $state->height=intval($dataState->size->height);
                $state->width=intval($dataState->size->width);
                $state->content=$dataState->content;
                $state->css=$dataState->css;
                $state->hidden=$dataState->hidden;
                $state->value=$dataState->value;
                $state->zindex=intval($dataState->zindex);
                $state->entity_state_type_id=EntityStateType::getByName($dataState->type)->id;
                $state->entity_id=$entity->id;
                if(property_exists($dataState,'valueType')){
                    $valueType=ValueType::getByName($dataState->valueType)->id;
                }else{
                    $valueType=ValueType::getByName('null')->id;
                }
                $state->value_type_id=$valueType;
                $state->insert();
            }
        }
        
        //Actualiza los valores de parent
        foreach ($dataEntities as $dataEntityForParents){
            if($dataEntityForParents->parent){
                $childId=$parentTables[$dataEntityForParents->id];
                $parentId=$parentTables[intval($dataEntityForParents->parent)];
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
    * Retorna la lista de entidades de un paso
    * @param JSONAjax $schedule JSON with the schedule by ajax
    */
    public function actionLoadEntitiesByAjax(){
        $list=array();
        //Get the client data
        $stepId=intval($_POST['stepId']);
        $step=Step::model()->findByPk($stepId);
        $user=User::getCurrentUser();
        $user->last_step_id=$stepId;
        $user->update();
        foreach ($step->entities as $entity) {
            $states=array();
            foreach ($entity->entityStates as $state) {
                $states[$state->entityStateType->name]=array(
                    'pos'=>array(
                        'left'=>intval($state->left),
                        'top'=>intval($state->top)
                    ),
                    'size'=>array(
                        'height'=>intval($state->height),
                        'width'=>intval($state->width)
                    ),
                    'content'=>$state->content,
                    'css'=>$state->css,
                    'hidden'=>$state->hidden,
                    'value'=>$state->value,
                    'zindex'=>intval($state->zindex),
                    'type'=>$state->entityStateType->name,
                    'valueType'=>$state->valueType->name
                );
            }
            $parent=false;
            if($entity->parent){
                $parent=intval($entity->parent->id);
            }
            $list[]=array(
                'id'=>intval($entity->id),
                'parent'=>$parent,
                'optional'=>$entity->optional,
                'countable'=>$entity->countable,
                'weight'=>intval($entity->weight),
                'type'=>$entity->entityType->name,
                'states'=>$states
            );
        }
        //Retorna los objetos que se hayan encontrado
        echo json_encode(array("entities"=>$list));
    }
    
    /**
    * Retorna la lista de entidades de un paso
    * @param JSONAjax $schedule JSON with the schedule by ajax
    */
    public function actionCreateStepByAjax(){
        $success=false;
        //Get the client data
        $activityId=intval($_POST['activityId']);
        $activity=Activity::model()->findByPk($activityId);
        if($activity){
            //Crea un paso
            $step=new Step();
            $step->instruction="";
            $step->activity_id=$activity->id;
            $step->css="";
            $step->insert();
            $success=true;
            $stepData=array(
                'stepId'=>intval($step->id),
                'stepName'=>"Paso ".(count($step->activity->steps)),
                'activityId'=>intval($step->activity->id),
                'activityName'=>"Actividad ".count($step->activity->version->activities),
                'versionId'=>intval($step->activity->version_id),
                'versionName'=>$step->activity->version->name,
                'sectionId'=>intval($step->activity->version->section_id),
                'sectionName'=>$step->activity->version->section->sectionType->label,
                'activitySetId'=>intval($step->activity->version->section->activity_set_id),
                'activitySetTitle'=>$step->activity->version->section->activitySet->title,
                'countSteps'=>count($step->activity->steps)+1,
                'countActiviySets'=>count($step->activity->version->section->activitySet->sections),
                'instruction'=>""
            );
        }
        //Retorna los objetos que se hayan encontrado
        echo json_encode(array("success"=>$success,"stepData"=>$stepData));
    }
    
    /**
    * Retorna la lista de entidades de un paso
    * @param JSONAjax $schedule JSON with the schedule by ajax
    */
    public function actionDeleteStepByAjax(){
        $success=false;
        //Get the client data
        $stepId=intval($_POST['stepId']);
        $step=Step::model()->findByPk($stepId);
        if($step){
            foreach ($step->entities as $entity) {
                $entity->remove();
                $entity->delete();
            }
            $step->delete();
            $success=true;
        }
        //Retorna los objetos que se hayan encontrado
        echo json_encode(array("success"=>$success));
    }
    
    /**
    * Retorna la lista de entidades de un paso
    * @param JSONAjax $schedule JSON with the schedule by ajax
    */
    public function actionUpdateStepInstructionByAjax(){
        $success=false;
        //Get the client data
        $stepId=intval($_POST['stepId']);
        $instruction=$_POST['instruction'];
        $step=Step::model()->findByPk($stepId);
        if($step){
            $step->instruction=$instruction;
            $step->update();
            $success=true;
        }
        //Retorna los objetos que se hayan encontrado
        echo json_encode(array("success"=>$success));
    }
    
    /**
    * Guarda el puntaje para un paso del usuario actual
    */
    public function actionSavePointsByAjax(){
        $success=true;
        //Get the client data
        $stepId=intval($_POST['stepId']);
        $points=intval($_POST['points']);
        $step=Step::model()->findByPk($stepId);
        if($step){
            $step->setPoints(User::getCurrentUser(),$points);
        }else{
            $success=false;
        }
        //Return the result of save schedule
        echo json_encode(array("success"=>$success));
    }
}
