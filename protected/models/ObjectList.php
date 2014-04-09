<?php

/**
 * This is the model class for table "ObjectList".
 *
 * The followings are the available columns in table 'ObjectList':
 * @property integer $id
 * @property integer $static
 * @property integer $connected
 * @property integer $exercise
 *
 * The followings are the available model relations:
 * @property Object[] $objects
 * @property Exercise $exercise0
 */
class ObjectList extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ObjectList';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, exercise', 'required'),
			array('id, static, connected, exercise', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, static, connected, exercise', 'safe', 'on'=>'search'),
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
			'objects' => array(self::HAS_MANY, 'Object', 'objectList'),
			'exercise0' => array(self::BELONGS_TO, 'Exercise', 'exercise'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'static' => 'Static',
			'connected' => 'If the objects in the list are changeable with other lists',
			'exercise' => 'Exercise',
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
		$criteria->compare('static',$this->static);
		$criteria->compare('connected',$this->connected);
		$criteria->compare('exercise',$this->exercise);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ObjectList the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
