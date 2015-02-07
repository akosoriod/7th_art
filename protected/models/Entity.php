<?php

/**
 * This is the model class for table "entity".
 *
 * The followings are the available columns in table 'entity':
 * @property integer $id
 * @property integer $exercise_id
 * @property integer $optional
 * @property integer $countable
 * @property double $weight
 * @property integer $parent_id
 * @property integer $entity_type_id
 *
 * The followings are the available model relations:
 * @property Answer[] $answers
 * @property Exercise $exercise
 * @property Entity $parent
 * @property Entity[] $entities
 * @property EntityType $entityType
 * @property EntityState[] $entityStates
 */
class Entity extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'entity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('exercise_id, entity_type_id', 'required'),
			array('exercise_id, optional, countable, parent_id, entity_type_id', 'numerical', 'integerOnly'=>true),
			array('weight', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, exercise_id, optional, countable, weight, parent_id, entity_type_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'answers' => array(self::HAS_MANY, 'Answer', 'entity_id'),
			'exercise' => array(self::BELONGS_TO, 'Exercise', 'exercise_id'),
			'parent' => array(self::BELONGS_TO, 'Entity', 'parent_id'),
			'entities' => array(self::HAS_MANY, 'Entity', 'parent_id'),
			'entityType' => array(self::BELONGS_TO, 'EntityType', 'entity_type_id'),
			'entityStates' => array(self::HAS_MANY, 'EntityState', 'entity_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'exercise_id' => 'Exercise',
			'optional' => 'Optional',
			'countable' => 'Countable',
			'weight' => 'Weight',
			'parent_id' => 'Parent',
			'entity_type_id' => 'Entity Type',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('exercise_id',$this->exercise_id);
		$criteria->compare('optional',$this->optional);
		$criteria->compare('countable',$this->countable);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('entity_type_id',$this->entity_type_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Entity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * Returns the object in HTML format
         * @return string The Object in HTML Format
         */
        public function getHtml(){
            $html='
                <div class="object" data-id="'.$this->id.'" data-left="'.$this->left.'" data-top="'.$this->top.'" data-height="'.$this->height.'" data-width="'.$this->width.'" style="'.$this->css.'">
                    <div class="text">'.$this->content.'</div>
                </div>
            ';
            return $html;
        }
        
        /**
         * Retorna una lista de objetos a partir de una Sección
         * @param Section $section Objeto de tipo Section
         * @return Object[] Lista de Objetos de la Sección
         */
//        public static function getObjectsBySection($section){
//            $objectList=array();
//            foreach ($section->versions as $version) {
//                foreach ($version->activities as $activity) {
//                    foreach ($activity->steps as $step) {
//                        $stepObjects=self::getObjectsByStep($step);
//                        if(is_array($stepObjects)){
//                            $objectList=array_merge(self::getObjectsByStep($step),$objectList);
//}
//                    }
//                }
//            }
//            return $objectList;
//        }
//        
        /**
         * Retorna una lista de entidades a partir de un paso
         * @param Paso $step Objeto de tipo Paso
         * @return Entity[] Lista de Entidades del Paso
         */
        public static function getEntitiesByStep($step){
            $entities=array();
            foreach ($step->exercises as $exercise) {
                foreach ($exercise->entities as $entity) {
                    $entities[]=$entity;
                }
            }
            return $entities;
        }
}
