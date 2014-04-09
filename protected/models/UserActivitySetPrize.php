<?php

/**
 * This is the model class for table "User_ActivitySet_Prize".
 *
 * The followings are the available columns in table 'User_ActivitySet_Prize':
 * @property integer $user
 * @property integer $activity
 * @property integer $prize
 *
 * The followings are the available model relations:
 * @property UserActivitySet $user0
 * @property UserActivitySet $activity0
 * @property Prize $prize0
 */
class UserActivitySetPrize extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'User_ActivitySet_Prize';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user, activity, prize', 'required'),
			array('user, activity, prize', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user, activity, prize', 'safe', 'on'=>'search'),
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
			'user0' => array(self::BELONGS_TO, 'UserActivitySet', 'user'),
			'activity0' => array(self::BELONGS_TO, 'UserActivitySet', 'activity'),
			'prize0' => array(self::BELONGS_TO, 'Prize', 'prize'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user' => 'User',
			'activity' => 'Activity',
			'prize' => 'Prize',
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

		$criteria->compare('user',$this->user);
		$criteria->compare('activity',$this->activity);
		$criteria->compare('prize',$this->prize);

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
