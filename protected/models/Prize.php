<?php

/**
 * This is the model class for table "prize".
 *
 * The followings are the available columns in table 'prize':
 * @property integer $id
 * @property string $name
 * @property double $required_percent
 * @property integer $image_id
 *
 * The followings are the available model relations:
 * @property Image $image
 * @property UserActivitySetPrize[] $userActivitySetPrizes
 */
class Prize extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'prize';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, required_percent, image_id', 'required'),
			array('image_id', 'numerical', 'integerOnly'=>true),
			array('required_percent', 'numerical'),
			array('name', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, required_percent, image_id', 'safe', 'on'=>'search'),
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
			'image' => array(self::BELONGS_TO, 'Image', 'image_id'),
			'userActivitySetPrizes' => array(self::HAS_MANY, 'UserActivitySetPrize', 'prize_id'),
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
			'required_percent' => 'Required Percent',
			'image_id' => 'Image',
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
		$criteria->compare('required_percent',$this->required_percent);
		$criteria->compare('image_id',$this->image_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Prize the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
