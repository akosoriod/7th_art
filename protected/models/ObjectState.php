<?php

/**
 * This is the model class for table "object_state".
 *
 * The followings are the available columns in table 'object_state':
 * @property integer $id
 * @property integer $left
 * @property integer $top
 * @property integer $height
 * @property integer $width
 * @property string $content
 * @property string $css
 * @property integer $hidden
 * @property string $value
 * @property integer $zindex
 * @property integer $object_state_type_id
 * @property integer $object_id
 * @property integer $value_type_id
 *
 * The followings are the available model relations:
 * @property ObjectStateType $objectStateType
 * @property Object $object
 * @property ValueType $valueType
 */
class ObjectState extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'object_state';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('object_state_type_id, object_id, value_type_id', 'required'),
			array('left, top, height, width, hidden, zindex, object_state_type_id, object_id, value_type_id', 'numerical', 'integerOnly'=>true),
			array('css', 'length', 'max'=>45),
			array('content, value', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, left, top, height, width, content, css, hidden, value, zindex, object_state_type_id, object_id, value_type_id', 'safe', 'on'=>'search'),
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
			'objectStateType' => array(self::BELONGS_TO, 'ObjectStateType', 'object_state_type_id'),
			'object' => array(self::BELONGS_TO, 'Object', 'object_id'),
			'valueType' => array(self::BELONGS_TO, 'ValueType', 'value_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'left' => 'Left',
			'top' => 'Top',
			'height' => 'Height',
			'width' => 'Width',
			'content' => 'Content',
			'css' => 'Css',
			'hidden' => 'Hidden',
			'value' => 'Value',
			'zindex' => 'Zindex',
			'object_state_type_id' => 'Object State Type',
			'object_id' => 'Object',
			'value_type_id' => 'Value Type',
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
		$criteria->compare('left',$this->left);
		$criteria->compare('top',$this->top);
		$criteria->compare('height',$this->height);
		$criteria->compare('width',$this->width);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('css',$this->css,true);
		$criteria->compare('hidden',$this->hidden);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('zindex',$this->zindex);
		$criteria->compare('object_state_type_id',$this->object_state_type_id);
		$criteria->compare('object_id',$this->object_id);
		$criteria->compare('value_type_id',$this->value_type_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ObjectState the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
