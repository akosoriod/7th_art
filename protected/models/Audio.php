<?php

/**
 * This is the model class for table "Audio".
 *
 * The followings are the available columns in table 'Audio':
 * @property integer $id
 * @property string $path
 * @property string $voicedBy
 * @property integer $fileType
 *
 * The followings are the available model relations:
 * @property ActivitySet[] $activitySets
 * @property FileType $fileType0
 * @property Comment[] $comments
 */
class Audio extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Audio';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, path, fileType', 'required'),
			array('id, fileType', 'numerical', 'integerOnly'=>true),
			array('path', 'length', 'max'=>45),
			array('voicedBy', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, path, voicedBy, fileType', 'safe', 'on'=>'search'),
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
			'activitySets' => array(self::HAS_MANY, 'ActivitySet', 'soundtrack'),
			'fileType0' => array(self::BELONGS_TO, 'FileType', 'fileType'),
			'comments' => array(self::HAS_MANY, 'Comment', 'audio'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'path' => 'Path',
			'voicedBy' => 'Voiced By',
			'fileType' => 'File Type',
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
		$criteria->compare('path',$this->path,true);
		$criteria->compare('voicedBy',$this->voicedBy,true);
		$criteria->compare('fileType',$this->fileType);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Audio the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
