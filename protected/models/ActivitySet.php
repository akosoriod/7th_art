<?php

/**
 * This is the model class for table "activity_set".
 *
 * The followings are the available columns in table 'activity_set':
 * @property integer $id
 * @property string $title
 * @property string $status
 * @property string $publication
 * @property string $tagline
 * @property string $director
 * @property integer $year
 * @property integer $soundtrack
 * @property integer $image
 * @property integer $operator_id
 *
 * The followings are the available model relations:
 * @property Operator $operator
 * @property Image $image0
 * @property Audio $soundtrack0
 * @property Genre[] $genres
 * @property Section[] $sections
 * @property Session[] $sessions
 * @property User[] $users
 */
class ActivitySet extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'activity_set';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, status, operator_id', 'required'),
			array('year, soundtrack, image, operator_id', 'numerical', 'integerOnly'=>true),
			array('title, status, publication, director', 'length', 'max'=>45),
			array('tagline', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, status, publication, tagline, director, year, soundtrack, image, operator_id', 'safe', 'on'=>'search'),
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
			'operator' => array(self::BELONGS_TO, 'Operator', 'operator_id'),
			'image0' => array(self::BELONGS_TO, 'Image', 'image'),
			'soundtrack0' => array(self::BELONGS_TO, 'Audio', 'soundtrack'),
			'genres' => array(self::MANY_MANY, 'Genre', 'genre_activity_set(activity_set_id, genre_id)'),
			'sections' => array(self::HAS_MANY, 'Section', 'activity_id'),
			'sessions' => array(self::HAS_MANY, 'Session', 'activity_set'),
			'users' => array(self::MANY_MANY, 'User', 'user_activity_set(activity_id, user_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'status' => 'Status',
			'publication' => 'Publication',
			'tagline' => 'Tagline',
			'director' => 'Director',
			'year' => 'Year',
			'soundtrack' => 'Soundtrack',
			'image' => 'Image',
			'operator_id' => 'Operator',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('publication',$this->publication,true);
		$criteria->compare('tagline',$this->tagline,true);
		$criteria->compare('director',$this->director,true);
		$criteria->compare('year',$this->year);
		$criteria->compare('soundtrack',$this->soundtrack);
		$criteria->compare('image',$this->image);
		$criteria->compare('operator_id',$this->operator_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ActivitySet the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
