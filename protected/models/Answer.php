<?php

/**
 * This is the model class for table "Answer".
 *
 * The followings are the available columns in table 'Answer':
 * @property integer $id
 * @property string $text
 * @property integer $correct
 * @property string $defaultText
 * @property integer $exercise
 *
 * The followings are the available model relations:
 * @property Exercise $exercise0
 * @property Relation[] $relations
 * @property UserExercise[] $userExercises
 */
class Answer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Answer';
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
			array('id, correct, exercise', 'numerical', 'integerOnly'=>true),
			array('text, defaultText', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, text, correct, defaultText, exercise', 'safe', 'on'=>'search'),
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
			'exercise0' => array(self::BELONGS_TO, 'Exercise', 'exercise'),
			'relations' => array(self::HAS_MANY, 'Relation', 'answer'),
			'userExercises' => array(self::MANY_MANY, 'UserExercise', 'User_Exercise_Answer(answer, user_exercise)'),
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
			'correct' => 'Correct',
			'defaultText' => 'Default Text',
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
		$criteria->compare('text',$this->text,true);
		$criteria->compare('correct',$this->correct);
		$criteria->compare('defaultText',$this->defaultText,true);
		$criteria->compare('exercise',$this->exercise);

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
