<?php

/**
 * This is the model class for table "ActivitySet".
 *
 * The followings are the available columns in table 'ActivitySet':
 * @property integer $id
 * @property string $title
 * @property string $status
 * @property string $publication
 * @property string $tagline
 * @property string $director
 * @property integer $year
 * @property integer $operator
 * @property integer $soundtrack
 * @property integer $image
 *
 * The followings are the available model relations:
 * @property Operator $operator0
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
		return 'ActivitySet';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, title, status, operator', 'required'),
			array('id, year, operator, soundtrack, image', 'numerical', 'integerOnly'=>true),
			array('title, status, publication, director', 'length', 'max'=>45),
			array('tagline', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, status, publication, tagline, director, year, operator, soundtrack, image', 'safe', 'on'=>'search'),
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
			'operator0' => array(self::BELONGS_TO, 'Operator', 'operator'),
			'image0' => array(self::BELONGS_TO, 'Image', 'image'),
			'soundtrack0' => array(self::BELONGS_TO, 'Audio', 'soundtrack'),
			'genres' => array(self::MANY_MANY, 'Genre', 'Genre_ActivitySet(activitySet, genre)'),
			'sections' => array(self::HAS_MANY, 'Section', 'activity'),
			'sessions' => array(self::HAS_MANY, 'Session', 'activitySet'),
			'users' => array(self::MANY_MANY, 'User', 'User_ActivitySet(activity, user)'),
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
			'operator' => 'Operator',
			'soundtrack' => 'Soundtrack',
			'image' => 'Image',
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
		$criteria->compare('operator',$this->operator);
		$criteria->compare('soundtrack',$this->soundtrack);
		$criteria->compare('image',$this->image);

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
