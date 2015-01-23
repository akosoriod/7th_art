<?php

/**
 * This is the model class for table "exercise".
 *
 * The followings are the available columns in table 'exercise':
 * @property integer $id
 * @property integer $exercise_type_id
 * @property integer $exercise_id
 * @property integer $step_id
 * @property string $question
 *
 * The followings are the available model relations:
 * @property ExerciseType $exerciseType
 * @property Exercise $exercise
 * @property Exercise[] $exercises
 * @property Step $step
 * @property Image[] $images
 * @property Object[] $objects
 */
class Exercise extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'exercise';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('exercise_type_id, step_id', 'required'),
			array('exercise_type_id, exercise_id, step_id', 'numerical', 'integerOnly'=>true),
			array('question', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, exercise_type_id, exercise_id, step_id, question', 'safe', 'on'=>'search'),
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
			'exerciseType' => array(self::BELONGS_TO, 'ExerciseType', 'exercise_type_id'),
			'exercise' => array(self::BELONGS_TO, 'Exercise', 'exercise_id'),
			'exercises' => array(self::HAS_MANY, 'Exercise', 'exercise_id'),
			'step' => array(self::BELONGS_TO, 'Step', 'step_id'),
			'images' => array(self::MANY_MANY, 'Image', 'exercise_image(exercise_id, image_id)'),
			'objects' => array(self::HAS_MANY, 'Object', 'exercise_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'exercise_type_id' => 'Exercise Type',
			'exercise_id' => 'Exercise',
			'step_id' => 'Step',
			'question' => 'Question',
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
		$criteria->compare('exercise_type_id',$this->exercise_type_id);
		$criteria->compare('exercise_id',$this->exercise_id);
		$criteria->compare('step_id',$this->step_id);
		$criteria->compare('question',$this->question,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Exercise the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
