<?php

/**
 * This is the model class for table "step".
 *
 * The followings are the available columns in table 'step':
 * @property integer $id
 * @property string $instruction
 * @property string $css
 * @property integer $activity_id
 * @property integer $qualifiable
 *
 * The followings are the available model relations:
 * @property Entity[] $entities
 * @property Activity $activity
 * @property User[] $users
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
			array('activity_id', 'required'),
			array('activity_id, qualifiable', 'numerical', 'integerOnly'=>true),
			array('instruction, css', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, instruction, css, activity_id, qualifiable', 'safe', 'on'=>'search'),
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
			'entities' => array(self::HAS_MANY, 'Entity', 'step_id'),
			'activity' => array(self::BELONGS_TO, 'Activity', 'activity_id'),
			'users' => array(self::MANY_MANY, 'User', 'user_step(step_id, user_id)'),
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
			'css' => 'Css',
			'activity_id' => 'Activity',
			'qualifiable' => 'Qualifiable',
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
		$criteria->compare('css',$this->css,true);
		$criteria->compare('activity_id',$this->activity_id);
		$criteria->compare('qualifiable',$this->qualifiable);

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
        
        /**
         * Retorna los puntos de un usuario en el paso actual
         * @param User $user Usuario del que se quieren obtener los puntos
         * @return int Puntos del usuario en el paso actual
         */
        public function getPoints($user){
            $points=0;
            $userStep=UserStep::model()->findByAttributes(array(
                'user_id'=>intval($user->id),
                'step_id'=>intval($this->id)
            ));
            if($userStep){
                $points=$userStep->score;
            }
            return $points;
        }
        
        /**
         * Actualiza los puntos de un usuario en el paso actual
         * @param User $user Usuario para actualizar los puntos
         * @param int $points Puntos del usuario en el paso actual
         */
        public function setPoints($user,$points){
            $userStep=UserStep::model()->findByAttributes(array(
                'user_id'=>intval($user->id),
                'step_id'=>intval($this->id)
            ));
            if($userStep){
                $userStep->score=intval($points);
                $userStep->update();
            }else{
                $newUserStep=new UserStep();
                $newUserStep->user_id=intval($user->id);
                $newUserStep->step_id=intval($this->id);
                $newUserStep->score=intval($points);
                $newUserStep->save();
            }
        }
}
