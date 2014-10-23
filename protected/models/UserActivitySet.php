<?php

/**
 * This is the model class for table "user_activity_set".
 *
 * The followings are the available columns in table 'user_activity_set':
 * @property integer $user_id
 * @property integer $activity_set_id
 * @property integer $score
 * @property string $rating
 *
 * The followings are the available model relations:
 * @property UserActivitySetPrize[] $userActivitySetPrizes
 * @property UserActivitySetPrize[] $userActivitySetPrizes1
 */
class UserActivitySet extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_activity_set';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, activity_set_id', 'required'),
			array('user_id, activity_set_id, score', 'numerical', 'integerOnly'=>true),
			array('rating', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, activity_set_id, score, rating', 'safe', 'on'=>'search'),
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
			'userActivitySetPrizes' => array(self::HAS_MANY, 'UserActivitySetPrize', 'user_id'),
			'userActivitySetPrizes1' => array(self::HAS_MANY, 'UserActivitySetPrize', 'activity_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'activity_set_id' => 'Activity Set',
			'score' => 'Score',
			'rating' => 'Rating',
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('activity_set_id',$this->activity_set_id);
		$criteria->compare('score',$this->score);
		$criteria->compare('rating',$this->rating,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserActivitySet the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
