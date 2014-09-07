<?php

/**
 * This is the model class for table "exercise_object".
 *
 * The followings are the available columns in table 'exercise_object':
 * @property integer $exercise_id
 * @property integer $object_id
 * @property integer $match
 * @property integer $target_id
 */
class ExerciseObject extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'exercise_object';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('exercise_id, object_id, target_id', 'required'),
			array('exercise_id, object_id, match, target_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('exercise_id, object_id, match, target_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'exercise_id' => 'Exercise',
			'object_id' => 'Object',
			'match' => 'Match',
			'target_id' => 'Target',
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

		$criteria->compare('exercise_id',$this->exercise_id);
		$criteria->compare('object_id',$this->object_id);
		$criteria->compare('match',$this->match);
		$criteria->compare('target_id',$this->target_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ExerciseObject the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
