<?php

/**
 * This is the model class for table "activity_set".
 *
 * The followings are the available columns in table 'activity_set':
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $publication
 * @property string $tagline
 * @property string $director
 * @property integer $year
 * @property string $poster
 * @property string $background
 * @property string $paralax_1
 * @property string $paralax_2
 * @property string $paralax_3
 * @property string $soundtrack
 * @property integer $operator_id
 * @property integer $status_id
 *
 * The followings are the available model relations:
 * @property User $operator
 * @property Status $status
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
			array('name, title, operator_id, status_id', 'required'),
			array('year, operator_id, status_id', 'numerical', 'integerOnly'=>true),
			array('name, title, publication, director', 'length', 'max'=>45),
			array('tagline', 'length', 'max'=>100),
                        array('poster', 'file', 'types'=>'jpg, gif, png','allowEmpty' => true),
                        array('background', 'file', 'types'=>'jpg, gif, png','allowEmpty' => true),
                        array('paralax_1', 'file', 'types'=>'jpg, gif, png','allowEmpty' => true),
                        array('paralax_2', 'file', 'types'=>'jpg, gif, png','allowEmpty' => true),
                        array('paralax_3', 'file', 'types'=>'jpg, gif, png','allowEmpty' => true),
                        array('soundtrack', 'file', 'types'=>'ogg','allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, title, publication, tagline, director, year, poster, operator_id, status_id', 'safe', 'on'=>'search'),
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
			'operator' => array(self::BELONGS_TO, 'User', 'operator_id'),
			'status' => array(self::BELONGS_TO, 'Status', 'status_id'),
			'genres' => array(self::MANY_MANY, 'Genre', 'genre_activity_set(activity_set_id, genre_id)'),
			'sections' => array(self::HAS_MANY, 'Section', 'activity_set_id'),
			'sessions' => array(self::HAS_MANY, 'Session', 'activity_set_id'),
			'users' => array(self::MANY_MANY, 'User', 'user_activity_set(activity_set_id, user_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Nombre',
			'title' => 'Título',
			'publication' => 'Publicación',
			'tagline' => 'Tagline',
			'director' => 'Director',
			'year' => 'Año',
			'poster' => 'Póster',
                        'background' => 'Fondo',
			'paralax_1' => 'Paralax 1',
			'paralax_2' => 'Paralax 2',
			'paralax_3' => 'Paralax 3',
			'soundtrack' => 'Soundtrack',
			'operator_id' => 'Operador',
			'status_id' => 'Estado',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('publication',$this->publication,true);
		$criteria->compare('tagline',$this->tagline,true);
		$criteria->compare('director',$this->director,true);
		$criteria->compare('year',$this->year);
		$criteria->compare('poster',$this->poster,true);
                $criteria->compare('background',$this->background,true);
		$criteria->compare('paralax_1',$this->paralax_1,true);
		$criteria->compare('paralax_2',$this->paralax_2,true);
		$criteria->compare('paralax_3',$this->paralax_3,true);
		$criteria->compare('soundtrack',$this->soundtrack,true);
		$criteria->compare('operator_id',$this->operator_id);
		$criteria->compare('status_id',$this->status_id);

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
        
        /**
         * Retorna el estado del activitySet en Español
         * @return string Status en español
         */
        public function statusSpanish(){
            $status="";
            switch ($this->status->name) {
                case "editing":
                    $status="editando";
                    break;
                case "revised":
                    $status="revisado";
                    break;
                case "published":
                    $status="publicado";
                    break;
            }
            return $status;
        }
        
        /**
         * Returns the ActivitySet from the name
         * @param string $name Name of the ActivitySet
         * @return ActivitySet ActivitySet object
         */
        public static function getByName($name){
            $object=self::model()->find(
                'name=:name',
                array(':name'=>$name)
            );
            return $object;
        }
        
        /**
         * Retorna los activitySets que están publicados
         * @return ActivitySet[] Array de ActivitySets
         */
        public static function getPublished(){
            $list=self::model()->findAll(
                'status_id=:statusId',
                array(':statusId'=>3)
            );
            return $list;
        }
}
