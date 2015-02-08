<?php

/**
 * This is the model class for table "section".
 *
 * The followings are the available columns in table 'section':
 * @property integer $id
 * @property integer $section_type_id
 * @property integer $activity_set_id
 *
 * The followings are the available model relations:
 * @property SectionType $sectionType
 * @property ActivitySet $activitySet
 * @property Version[] $versions
 */
class Section extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'section';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('section_type_id, activity_set_id', 'required'),
			array('section_type_id, activity_set_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, section_type_id, activity_set_id', 'safe', 'on'=>'search'),
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
			'sectionType' => array(self::BELONGS_TO, 'SectionType', 'section_type_id'),
			'activitySet' => array(self::BELONGS_TO, 'ActivitySet', 'activity_set_id'),
			'versions' => array(self::HAS_MANY, 'Version', 'section_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'section_type_id' => 'Section Type',
			'activity_set_id' => 'Activity Set',
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
		$criteria->compare('section_type_id',$this->section_type_id);
		$criteria->compare('activity_set_id',$this->activity_set_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Section the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * Retorna una sección de un set de actividades
         * @param ActivitySet $activitySet Description
         * @param string $sectionName Nombre de la sección
         * @return Section Objeto de tipo Section
         */
        public static function getByName($activitySet,$sectionName){
            $output=false;
            $sections=$activitySet->sections;
            foreach ($sections as $section) {
                if($section->sectionType->name==$sectionName){
                    $output=$section;
                    break;
                }
            }
            return $output;
        }
        
        /**
         * Retorna una versión publicable de la Sección, si encuentra más de una
         * devuelve la primera, si no encuentra ninguna, retorna false
         * @return Version Versión conestado 3 => publucado
         */
        public function publishedVersion(){
            $published=false;
            foreach ($this->versions as $version) {
                if(intval($version->status_id)===3){
                    $published=$version;
                    break;
                }
            }
            return $published;
        }
}
