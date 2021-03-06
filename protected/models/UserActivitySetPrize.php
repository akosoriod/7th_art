<?php

/**
 * This is the model class for table "user_activity_set_prize".
 *
 * The followings are the available columns in table 'user_activity_set_prize':
 * @property integer $user_id
 * @property integer $activity_id
 * @property integer $prize_id
 *
 * The followings are the available model relations:
 * @property UserActivitySet $user
 * @property UserActivitySet $activity
 * @property Prize $prize
 */
class UserActivitySetPrize extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_activity_set_prize';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, activity_id, prize_id', 'required'),
			array('user_id, activity_id, prize_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, activity_id, prize_id', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'UserActivitySet', 'user_id'),
			'activity' => array(self::BELONGS_TO, 'UserActivitySet', 'activity_id'),
			'prize' => array(self::BELONGS_TO, 'Prize', 'prize_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'activity_id' => 'Activity',
			'prize_id' => 'Prize',
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
		$criteria->compare('activity_id',$this->activity_id);
		$criteria->compare('prize_id',$this->prize_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserActivitySetPrize the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
