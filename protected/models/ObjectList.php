<?php

/**
 * This is the model class for table "object_list".
 *
 * The followings are the available columns in table 'object_list':
 * @property integer $id
 * @property integer $static
 * @property integer $connected
 * @property integer $exercise_id
 *
 * The followings are the available model relations:
 * @property Object[] $objects
 * @property Exercise $exercise
 */
class ObjectList extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'object_list';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('exercise_id', 'required'),
			array('static, connected, exercise_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, static, connected, exercise_id', 'safe', 'on'=>'search'),
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
			'objects' => array(self::HAS_MANY, 'Object', 'object_list_id'),
			'exercise' => array(self::BELONGS_TO, 'Exercise', 'exercise_id'),
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
			'connected' => 'Connected',
			'exercise_id' => 'Exercise',
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
		$criteria->compare('exercise_id',$this->exercise_id);

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
