<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property integer $seconds_to_check
 * @property integer $person_id
 * @property double $font_size
 * @property integer $black_and_white
 *
 * The followings are the available model relations:
 * @property Comment[] $comments
 * @property Person $person
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, person_id', 'required'),
			array('id, seconds_to_check, person_id, black_and_white', 'numerical', 'integerOnly'=>true),
			array('font_size', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, seconds_to_check, person_id, font_size, black_and_white', 'safe', 'on'=>'search'),
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
			'comments' => array(self::HAS_MANY, 'Comment', 'user_id'),
			'person' => array(self::BELONGS_TO, 'Person', 'person_id'),
			'activitySets' => array(self::MANY_MANY, 'ActivitySet', 'user_activity_set(user_id, activity_id)'),
			'userExercises' => array(self::HAS_MANY, 'UserExercise', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'seconds_to_check' => 'Seconds To Check',
			'person_id' => 'Person',
			'font_size' => 'Font Size',
			'black_and_white' => 'Black And White',
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
		$criteria->compare('seconds_to_check',$this->seconds_to_check);
		$criteria->compare('person_id',$this->person_id);
		$criteria->compare('font_size',$this->font_size);
		$criteria->compare('black_and_white',$this->black_and_white);

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
