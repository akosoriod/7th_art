<?php

/**
 * This is the model class for table "file_type".
 *
 * The followings are the available columns in table 'file_type':
 * @property integer $id
 * @property string $name
 * @property string $extension
 * @property string $mime
 * @property integer $max_size
 *
 * The followings are the available model relations:
 * @property Audio[] $audios
 * @property Image[] $images
 */
class FileType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'file_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, extension, mime, max_size', 'required'),
			array('max_size', 'numerical', 'integerOnly'=>true),
			array('name, mime', 'length', 'max'=>45),
			array('extension', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, extension, mime, max_size', 'safe', 'on'=>'search'),
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
			'audios' => array(self::HAS_MANY, 'Audio', 'file_type'),
			'images' => array(self::HAS_MANY, 'Image', 'file_type_id'),
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
			'extension' => 'Extension',
			'mime' => 'Mime',
			'max_size' => 'Max Size',
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
		$criteria->compare('extension',$this->extension,true);
		$criteria->compare('mime',$this->mime,true);
		$criteria->compare('max_size',$this->max_size);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FileType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
