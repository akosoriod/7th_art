<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $name
 * @property string $lastname
 * @property string $username
 * @property string $password
 * @property string $active
 * @property string $auth_type
 * @property string $email
 * @property integer $entries
 * @property integer $last_step_id
 *
 * The followings are the available model relations:
 * @property ActivitySet[] $activitySets
 * @property Answer[] $answers
 * @property AuthItem[] $authItems
 * @property Comment[] $comments
 * @property Session[] $sessions
 * @property UserParameter[] $userParameters
 * @property Role[] $roles
 * @property Step[] $steps
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, lastname, username, password', 'required'),
			array('entries, last_step_id', 'numerical', 'integerOnly'=>true),
			array('name, lastname, username, password, active, auth_type', 'length', 'max'=>45),
			array('email', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, lastname, username, password, active, auth_type, email, entries, last_step_id', 'safe', 'on'=>'search'),
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
			'activitySets' => array(self::MANY_MANY, 'ActivitySet', 'user_activity_set(user_id, activity_set_id)'),
			'answers' => array(self::HAS_MANY, 'Answer', 'user_id'),
			'authItems' => array(self::MANY_MANY, 'AuthItem', 'auth_assignment(userid, itemname)'),
			'comments' => array(self::HAS_MANY, 'Comment', 'user_id'),
			'sessions' => array(self::HAS_MANY, 'Session', 'user_id'),
			'userParameters' => array(self::HAS_MANY, 'UserParameter', 'user_id'),
			'roles' => array(self::MANY_MANY, 'Role', 'user_role(user_id, role_id)'),
			'authAssignment' => array(self::HAS_ONE, 'AuthAssignment', 'userid'),
			'steps' => array(self::MANY_MANY, 'Step', 'user_step(user_id, step_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Nombres',
			'lastname' => 'Apellidos',
			'username' => 'Login',
			'password' => 'Contrase&ntilde;a',
			'active' => 'Estado',
			'auth_type' => 'Tipo de Autenticación',
			'email' => 'Correo Electr&oacute;nico',
			'entries' => 'Entries',
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
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('auth_type',$this->auth_type,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('entries',$this->entries);
                $criteria->compare('last_step_id',$this->last_step_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * Returns the current user
         * @return User User object currently connected
         */
        public static function getCurrentUser(){
            try{
                $username=Yii::app()->user->_uid;
            } catch (Exception $ex) {
                $username=Yii::app()->user->name;
            }
            $user=self::model()->find(
                'username=:username',
                array(':username'=>$username)
            );
            return $user;
        }
        
        /**
	 * Retrieves an array of User of a user type
         * @param Int $role_id Role id of the user
	 * @return Array an array of TaxiModel.
	 */
	public static function getUserSelect($role_id=2){
            $array=array();
            foreach (self::model()->findAll() as $user){
                if($user->roles[0]->id==$role_id){
                    $array[$user->id]=$user->name." ".$user->lastname;
                }
            }
            return $array;
	}
        
        /**
	 * Retorna un usuario a partir de su nombre de usuario
         * @param string $username Nombre de usuario para verificar
	 * @return User Objeto de tipo User
	 */
	public static function getByUsername($username){
            return User::model()->findByAttributes(
                array('username'=>$username)
            );
	}
        
        /**
         * Crea un usuario en la base de datos que ha sido previamente cargado 
         * por LDAP
         * @param string $name Nombres del nuevo usuario
         * @param string $lastname Apellidos del nuevo usuario
         * @param string $username Nombre de usuario del nuevo usuario
         * @param string $email Email del nuevo usuario
         */
        public static function createLDAPUser($name,$lastname,$username,$email){
            $user=new User();
            $user->name=$name;
            $user->lastname=$lastname;
            $user->username=$username;
            $user->password=md5(rand(1000,10000000));
            $user->active=true;
            $user->auth_type='LDAP';
            $user->email=$email;
            $user->entries=0;
            $user->save();
            //Crea la relación entre el usuario LDAP y el rol
            $userRole=new UserRole();
            $userRole->role_id=3;
            $userRole->user_id=$user->id;
            $userRole->save();
            //Asocia al usuario con los permisos para acceder la aplicación
            $authAssignment=new AuthAssignment();
            $authAssignment->itemname='user';
            $authAssignment->userid=$user->id;
            $authAssignment->data='N;';
            $authAssignment->save();
        }
		
        /**
         * This method is invoked before saving a record (after validation, if any).
         * You may override this method to do any preparation work for record saving.
         * Use isNewRecord to determine whether the saving is for inserting or updating record.
         * Make sure you call the parent implementation so that the event is raised properly.
         */
        public function beforeSave() {
                if($this->isNewRecord){
                        $hash = md5($this->password);
                        $this->password = $hash;
                }
                return parent::beforeSave();
        }
        
        /**
         * Retorna el avance total de una persona en todos los sets de actividades
         * @return float Porcentaje total
         */
        public function totalPercent(){
            $percent=0;
            $total=0;
            $countActivitySets=0;
            foreach (ActivitySet::model()->findAll() as $activitySet){
                if(intval($activitySet->status_id)===3){
                    $total+=$activitySet->percent($this);
                    $countActivitySets++;
                }
            }
            if($countActivitySets>0){
                $percent=$total/$countActivitySets;
            }
            return $percent;
        }
        
        /**
         * Retorna los primeros 6 usuarios para el ranking
         */
        public static function getTopRanking(){
            $ranking=array(
                array("id"=>false,"fullname"=>false,"percent"=>0),
                array("id"=>false,"fullname"=>false,"percent"=>0),
                array("id"=>false,"fullname"=>false,"percent"=>0),
                array("id"=>false,"fullname"=>false,"percent"=>0),
                array("id"=>false,"fullname"=>false,"percent"=>0),
                array("id"=>false,"fullname"=>false,"percent"=>0)
            );
            $users=User::model()->findAllByAttributes(array('auth_type'=>"LDAP"));
            foreach ($users as $user){
                $percent=$user->totalPercent();
                foreach ($ranking as $key => $row) {
                    if(!$row["id"]||$percent>$row["percent"]){
                        $ranking[$key]["id"]=$user->id;
                        $ranking[$key]["fullname"]=$user->name." ".$user->lastname;
                        $ranking[$key]["percent"]=$percent;
                        break;
                    }
                }
            }
            return $ranking;
        }
}
