<?php

/**
 * This is the model class for table "Session".
 *
 * The followings are the available columns in table 'Session':
 * @property integer $id
 * @property string $sessionId
 * @property string $timeIni
 * @property string $timeEnd
 * @property string $ip
 * @property integer $person
 * @property integer $activitySet
 *
 * The followings are the available model relations:
 * @property Person $person0
 * @property ActivitySet $activitySet0
 */
class Session extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Session';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, sessionId, timeIni, person', 'required'),
			array('id, person, activitySet', 'numerical', 'integerOnly'=>true),
			array('sessionId, ip', 'length', 'max'=>45),
			array('timeEnd', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sessionId, timeIni, timeEnd, ip, person, activitySet', 'safe', 'on'=>'search'),
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
			'person0' => array(self::BELONGS_TO, 'Person', 'person'),
			'activitySet0' => array(self::BELONGS_TO, 'ActivitySet', 'activitySet'),
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
			'person' => 'Person',
			'activitySet' => 'Activity Set',
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
		$criteria->compare('person',$this->person);
		$criteria->compare('activitySet',$this->activitySet);

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
