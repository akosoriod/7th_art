<?php

/**
 * This is the model class for table "User".
 *
 * The followings are the available columns in table 'User':
 * @property integer $id
 * @property integer $secondsToCheck
 * @property integer $person
 * @property double $fontSize
 * @property integer $blackAndWhite
 *
 * The followings are the available model relations:
 * @property Comment[] $comments
 * @property Person $person0
 * @property ActivitySet[] $activitySets
 * @property UserExercise[] $userExercises
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'User';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, person', 'required'),
			array('id, secondsToCheck, person, blackAndWhite', 'numerical', 'integerOnly'=>true),
			array('fontSize', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, secondsToCheck, person, fontSize, blackAndWhite', 'safe', 'on'=>'search'),
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
			'comments' => array(self::HAS_MANY, 'Comment', 'user'),
			'person0' => array(self::BELONGS_TO, 'Person', 'person'),
			'activitySets' => array(self::MANY_MANY, 'ActivitySet', 'User_ActivitySet(user, activity)'),
			'userExercises' => array(self::HAS_MANY, 'UserExercise', 'user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'secondsToCheck' => 'Seconds To Check',
			'person' => 'Person',
			'fontSize' => 'Font Size',
			'blackAndWhite' => 'Black And White',
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
		$criteria->compare('secondsToCheck',$this->secondsToCheck);
		$criteria->compare('person',$this->person);
		$criteria->compare('fontSize',$this->fontSize);
		$criteria->compare('blackAndWhite',$this->blackAndWhite);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
