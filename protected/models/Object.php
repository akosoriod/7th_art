<?php

/**
 * This is the model class for table "object".
 *
 * The followings are the available columns in table 'object':
 * @property integer $id
 * @property string $text
 * @property integer $left
 * @property integer $top
 * @property integer $height
 * @property integer $width
 * @property string $background
 * @property string $border
 * @property integer $font_size
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
			array('left, top, height, width, font_size, object_list_id', 'numerical', 'integerOnly'=>true),
			array('background, border', 'length', 'max'=>45),
			array('text', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, text, left, top, height, width, background, border, font_size, object_list_id', 'safe', 'on'=>'search'),
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
			'text' => 'Text',
			'left' => 'Left',
			'top' => 'Top',
			'height' => 'Height',
			'width' => 'Width',
			'background' => 'Background',
			'border' => 'Border',
			'font_size' => 'Font Size',
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
		$criteria->compare('text',$this->text,true);
		$criteria->compare('left',$this->left);
		$criteria->compare('top',$this->top);
		$criteria->compare('height',$this->height);
		$criteria->compare('width',$this->width);
		$criteria->compare('background',$this->background,true);
		$criteria->compare('border',$this->border,true);
		$criteria->compare('font_size',$this->font_size);
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
                <div class="object" data-id="'.$this->id.'" data-left="'.$this->left.'" data-top="'.$this->top.'" data-height="'.$this->height.'" data-width="'.$this->width.'" data-background="'.$this->background.'" data-border="'.$this->border.'" data-font-size="'.$this->font_size.'">
                    <div class="text">'.$this->text.'</div>
                </div>
            ';
            return $html;
        }
}
