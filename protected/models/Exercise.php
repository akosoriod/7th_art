<?php

/**
 * This is the model class for table "Exercise".
 *
 * The followings are the available columns in table 'Exercise':
 * @property integer $id
 * @property string $question
 * @property integer $exerciseType
 * @property integer $depends
 * @property integer $step
 *
 * The followings are the available model relations:
 * @property Answer[] $answers
 * @property ExerciseType $exerciseType0
 * @property Exercise $depends0
 * @property Exercise[] $exercises
 * @property Step $step0
 * @property Image[] $images
 * @property Object[] $objects
 * @property ObjectList[] $objectLists
 * @property StepAnswer[] $stepAnswers
 * @property Target[] $targets
 * @property UserExercise[] $userExercises
 */
class Exercise extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Exercise';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, exerciseType, depends, step', 'required'),
			array('id, exerciseType, depends, step', 'numerical', 'integerOnly'=>true),
			array('question', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, question, exerciseType, depends, step', 'safe', 'on'=>'search'),
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
			'answers' => array(self::HAS_MANY, 'Answer', 'exercise'),
			'exerciseType0' => array(self::BELONGS_TO, 'ExerciseType', 'exerciseType'),
			'depends0' => array(self::BELONGS_TO, 'Exercise', 'depends'),
			'exercises' => array(self::HAS_MANY, 'Exercise', 'depends'),
			'step0' => array(self::BELONGS_TO, 'Step', 'step'),
			'images' => array(self::MANY_MANY, 'Image', 'Exercise_Image(exercise, image)'),
			'objects' => array(self::MANY_MANY, 'Object', 'Exercise_Object(exercise, object)'),
			'objectLists' => array(self::HAS_MANY, 'ObjectList', 'exercise'),
			'stepAnswers' => array(self::HAS_MANY, 'StepAnswer', 'step'),
			'targets' => array(self::HAS_MANY, 'Target', 'exercise'),
			'userExercises' => array(self::HAS_MANY, 'UserExercise', 'exercise'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'question' => 'Question',
			'exerciseType' => 'Exercise Type',
			'depends' => 'Depends',
			'step' => 'Step',
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
		$criteria->compare('question',$this->question,true);
		$criteria->compare('exerciseType',$this->exerciseType);
		$criteria->compare('depends',$this->depends);
		$criteria->compare('step',$this->step);

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
