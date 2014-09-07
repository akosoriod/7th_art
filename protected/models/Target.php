<?php

/**
 * This is the model class for table "target".
 *
 * The followings are the available columns in table 'target':
 * @property integer $id
 * @property string $previous_text
 * @property string $id_div
 * @property integer $exercise_id
 *
 * The followings are the available model relations:
 * @property Exercise $exercise
 */
class Target extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'target';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('exercise_id', 'required'),
			array('exercise_id', 'numerical', 'integerOnly'=>true),
			array('id_div', 'length', 'max'=>45),
			array('previous_text', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, previous_text, id_div, exercise_id', 'safe', 'on'=>'search'),
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
			'exercise' => array(self::BELONGS_TO, 'Exercise', 'exercise_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'previous_text' => 'Previous Text',
			'id_div' => 'Id Div',
			'exercise_id' => 'Exercise',
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
		$criteria->compare('previous_text',$this->previous_text,true);
		$criteria->compare('id_div',$this->id_div,true);
		$criteria->compare('exercise_id',$this->exercise_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Target the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
