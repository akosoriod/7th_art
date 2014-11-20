<?php

/**
 * This is the model class for table "object".
 *
 * The followings are the available columns in table 'object':
 * @property integer $id
 * @property string $content
 * @property string $css
 * @property integer $left
 * @property integer $top
 * @property integer $height
 * @property integer $width
 * @property integer $object_list_id
 *
 * The followings are the available model relations:
 * @property Exercise[] $exercises
 * @property ObjectList $objectList
 * @property Image[] $images
 * @property Relation[] $relations
 */
class Object extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'object';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('left, top, height, width, object_list_id', 'numerical', 'integerOnly'=>true),
			array('content, css', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, content, css, left, top, height, width, object_list_id', 'safe', 'on'=>'search'),
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
			'exercises' => array(self::MANY_MANY, 'Exercise', 'exercise_object(object_id, exercise_id)'),
			'objectList' => array(self::BELONGS_TO, 'ObjectList', 'object_list_id'),
			'images' => array(self::MANY_MANY, 'Image', 'object_image(object_id, image_id)'),
			'relations' => array(self::MANY_MANY, 'Relation', 'object_relation(object_id, relation_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'content' => 'Content',
			'css' => 'Css',
			'left' => 'Left',
			'top' => 'Top',
			'height' => 'Height',
			'width' => 'Width',
			'object_list_id' => 'Object List',
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
		$criteria->compare('content',$this->content,true);
		$criteria->compare('css',$this->css,true);
		$criteria->compare('left',$this->left);
		$criteria->compare('top',$this->top);
		$criteria->compare('height',$this->height);
		$criteria->compare('width',$this->width);
		$criteria->compare('object_list_id',$this->object_list_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Object the static model class
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
        public static function getObjectsBySection($section){
            $objectList=array();
            foreach ($section->versions as $version) {
                foreach ($version->activities as $activity) {
                    foreach ($activity->steps as $step) {
                        $stepObjects=self::getObjectsByStep($step);
                        if(is_array($stepObjects)){
                            $objectList=array_merge(self::getObjectsByStep($step),$objectList);
                        }
                    }
                }
            }
            return $objectList;
        }
        
        /**
         * Retorna una lista de objetos a partir de un paso
         * @param Paso $step Objeto de tipo Paso
         * @return Object[] Lista de Objetos del Paso
         */
        public static function getObjectsByStep($step){
            $objects=array();
            foreach ($step->exercises as $exercise) {
                foreach ($exercise->objectLists as $objectList) {
                    foreach ($objectList->objects as $object) {
                        $objects[]=$object;
                    }
                }
            }
            return $objects;
        }
}
