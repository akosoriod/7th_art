<?php

/**
 * This is the model class for table "Person".
 *
 * The followings are the available columns in table 'Person':
 * @property integer $id
 * @property string $name
 * @property string $lastname
 * @property string $username
 * @property string $password
 * @property integer $active
 * @property string $authType
 *
 * The followings are the available model relations:
 * @property Administrator[] $administrators
 * @property Operator[] $operators
 * @property Session[] $sessions
 * @property User[] $users
 */
class Person extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Person';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, username, password', 'required'),
			array('id, active', 'numerical', 'integerOnly'=>true),
			array('name, lastname, username, password', 'length', 'max'=>45),
			array('authType', 'length', 'max'=>4),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, lastname, username, password, active, authType', 'safe', 'on'=>'search'),
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
			'administrators' => array(self::HAS_MANY, 'Administrator', 'person'),
			'operators' => array(self::HAS_MANY, 'Operator', 'person'),
			'sessions' => array(self::HAS_MANY, 'Session', 'person'),
			'users' => array(self::HAS_MANY, 'User', 'person'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'lastname' => 'Lastname',
			'username' => 'Username',
			'password' => 'Password',
			'active' => 'Active',
			'authType' => 'Auth Type',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('authType',$this->authType,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Person the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
