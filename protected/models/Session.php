<?php

/**
 * This is the model class for table "session".
 *
 * The followings are the available columns in table 'session':
 * @property integer $id
 * @property string $sessionId
 * @property string $timeIni
 * @property string $timeEnd
 * @property string $ip
 * @property integer $activity_set_id
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property ActivitySet $activitySet
 * @property User $user
 */
class Session extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'session';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sessionId, timeIni, user_id', 'required'),
			array('activity_set_id, user_id', 'numerical', 'integerOnly'=>true),
			array('sessionId, ip', 'length', 'max'=>45),
			array('timeEnd', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sessionId, timeIni, timeEnd, ip, activity_set_id, user_id', 'safe', 'on'=>'search'),
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
			'activitySet' => array(self::BELONGS_TO, 'ActivitySet', 'activity_set_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sessionId' => 'Session',
			'timeIni' => 'Time Ini',
			'timeEnd' => 'Time End',
			'ip' => 'Ip',
			'activity_set_id' => 'Activity Set',
			'user_id' => 'User',
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
		$criteria->compare('sessionId',$this->sessionId,true);
		$criteria->compare('timeIni',$this->timeIni,true);
		$criteria->compare('timeEnd',$this->timeEnd,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('activity_set_id',$this->activity_set_id);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Session the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
