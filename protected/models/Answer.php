<?php

/**
 * This is the model class for table "answer".
 *
 * The followings are the available columns in table 'answer':
 * @property integer $id
 * @property string $value
 * @property integer $user_id
 * @property integer $entity_id
 * @property integer $value_type_id
 *
 * The followings are the available model relations:
 * @property User $user
 * @property ValueType $valueType
 * @property Entity $entity
 */
class Answer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'answer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, entity_id, value_type_id', 'required'),
			array('user_id, entity_id, value_type_id', 'numerical', 'integerOnly'=>true),
			array('value', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, value, user_id, entity_id, value_type_id', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'valueType' => array(self::BELONGS_TO, 'ValueType', 'value_type_id'),
			'entity' => array(self::BELONGS_TO, 'Entity', 'entity_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'value' => 'Value',
			'user_id' => 'User',
			'entity_id' => 'Entity',
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
		$criteria->compare('value',$this->value,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('entity_id',$this->entity_id);
		$criteria->compare('value_type_id',$this->value_type_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Answer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
