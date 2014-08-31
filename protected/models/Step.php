<?php

/**
 * This is the model class for table "step".
 *
 * The followings are the available columns in table 'step':
 * @property integer $id
 * @property string $instruction
 * @property integer $activity_id
 * @property integer $css_id
 *
 * The followings are the available model relations:
 * @property Exercise[] $exercises
 * @property Activity $activity
 * @property Css $css
 */
class Step extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'step';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('activity_id, css_id', 'required'),
			array('activity_id, css_id', 'numerical', 'integerOnly'=>true),
			array('instruction', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, instruction, activity_id, css_id', 'safe', 'on'=>'search'),
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
			'exercises' => array(self::HAS_MANY, 'Exercise', 'step_id'),
			'activity' => array(self::BELONGS_TO, 'Activity', 'activity_id'),
			'css' => array(self::BELONGS_TO, 'Css', 'css_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'instruction' => 'Instruction',
			'activity_id' => 'Activity',
			'css_id' => 'Css',
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
		$criteria->compare('instruction',$this->instruction,true);
		$criteria->compare('activity_id',$this->activity_id);
		$criteria->compare('css_id',$this->css_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Step the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
