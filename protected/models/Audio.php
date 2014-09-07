<?php

/**
 * This is the model class for table "audio".
 *
 * The followings are the available columns in table 'audio':
 * @property integer $id
 * @property string $path
 * @property string $voiced_by
 * @property integer $file_type_id
 *
 * The followings are the available model relations:
 * @property ActivitySet[] $activitySets
 * @property FileType $fileType
 * @property Comment[] $comments
 */
class Audio extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'audio';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('path, file_type_id', 'required'),
			array('file_type_id', 'numerical', 'integerOnly'=>true),
			array('path', 'length', 'max'=>45),
			array('voiced_by', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, path, voiced_by, file_type_id', 'safe', 'on'=>'search'),
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
			'activitySets' => array(self::HAS_MANY, 'ActivitySet', 'soundtrack_id'),
			'fileType' => array(self::BELONGS_TO, 'FileType', 'file_type_id'),
			'comments' => array(self::HAS_MANY, 'Comment', 'audio_id'),
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
			'voiced_by' => 'Voiced By',
			'file_type_id' => 'File Type',
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
		$criteria->compare('voiced_by',$this->voiced_by,true);
		$criteria->compare('file_type_id',$this->file_type_id);

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
