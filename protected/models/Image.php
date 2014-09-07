<?php

/**
 * This is the model class for table "image".
 *
 * The followings are the available columns in table 'image':
 * @property integer $id
 * @property string $path
 * @property string $copyright
 * @property integer $file_type_id
 *
 * The followings are the available model relations:
 * @property ActivitySet[] $activitySets
 * @property Exercise[] $exercises
 * @property FileType $fileType
 * @property Object[] $objects
 * @property Prize[] $prizes
 */
class Image extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'image';
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
			array('copyright', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, path, copyright, file_type_id', 'safe', 'on'=>'search'),
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
			'activitySets' => array(self::HAS_MANY, 'ActivitySet', 'image_id'),
			'exercises' => array(self::MANY_MANY, 'Exercise', 'exercise_image(image_id, exercise_id)'),
			'fileType' => array(self::BELONGS_TO, 'FileType', 'file_type_id'),
			'objects' => array(self::MANY_MANY, 'Object', 'object_image(image_id, object_id)'),
			'prizes' => array(self::HAS_MANY, 'Prize', 'image_id'),
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
			'copyright' => 'Copyright',
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
		$criteria->compare('copyright',$this->copyright,true);
		$criteria->compare('file_type_id',$this->file_type_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Image the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
