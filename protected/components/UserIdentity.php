<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	// Ref: https://www.exchangecore.com/blog/yii-active-directory-useridentity-login-authentication/
    const ERROR_INVALID_CREDENTIALS = 1001; // could not bind with user's credentials

    private $_options;

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$userList=User::model()->findAll();
                foreach ($userList as $user) {
                    $users[$user->username]=$user->password;
                }
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($users[$this->username]!==md5($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else {
			$this->errorCode=self::ERROR_NONE;
			return !$this->errorCode;
		}
		
		// Autenticaci&oacute;n LDAP
		// Ref: https://www.exchangecore.com/blog/yii-active-directory-useridentity-login-authentication/
		// Inicio autenticaci&oacute;n LDAP
		/**/
        $options = Yii::app()->params['ldap'];
		$dc_string = "dc=" . implode(",dc=",$options['dc']);
        
		$this->errorCode = self::ERROR_NONE;
        if($this->username != '' && $this->password != '') {

            //connect to the first available domain controller in our list
            foreach($options['servers'] as $server) {
                $connection = ldap_connect($server);
                ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
                if($connection) {
                    foreach($options['ou'] as $ou) {
                        if ( $bind = @ldap_bind($connection, "uid={$this->username},ou={$ou},{$dc_string}", $this->password) ) {
                            break; //we connected to one successfully
                        }
                    }
                }
            }
            
            if(!$bind) {
				$this->errorCode = self::ERROR_PASSWORD_INVALID;
			} else {
				$this->errorCode = self::ERROR_NONE;
			}
            
        } else {
            //if username or password is blank don't even try to authenticate
            $this->errorCode = self::ERROR_INVALID_CREDENTIALS;
        }
		/**/
		// Fin autenticaci&oacute;n LDAP
		
		return !$this->errorCode;
	}
}