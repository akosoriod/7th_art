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

		$this->errorCode = self::ERROR_NONE;
		if ($this->username != '' && $this->password != '') {

			//connect to the first available domain controller in our list
			$bind = false;
			foreach ($options['servers'] as $server) {
				
				// Se establece la conexión con el servidor LDAP.
				$connection = ldap_connect($server);
				
				if ($connection) {
					ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);
					ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);

					foreach ($options['oSede'] as $o) {
						foreach ($options['ou'] as $ou) {
							$uid = "uid={$this->username}";
							$rdn = "ou={$ou},o={$o},o={$options['oUNal']}";
							
							//$bind = @ldap_bind($connection, "uid=pperezp,ou=people,o=bogota,o=unal.edu.co", 'secretPwd')
							$bind = @ldap_bind($connection, $uid.','.$rdn, $this->password);
							if ($bind) {

								// La búsqueda se hace a través del atributo uid (login del usuario)
								$sr = ldap_search($connection, $rdn, $uid);  
								$info = ldap_get_entries($connection, $sr);

								for ($i=0; $i<$info["count"]; $i++) {
									// Se obtienen los datos del usuario del directorio LDAP.
									$_cn = $info[$i]["cn"][0];
									$_uid = $info[$i]["uid"][0];
									$_givenName = $info[$i]["givenname"][0];
									$_sn = $info[$i]["sn"][0];
									$_employeeNumber = $info[$i]["employeenumber"][0];
									$_mail = $info[$i]["mail"][0];
									
									// Los datos se almacenan en la sesión del usuario.
									$this->setState('_cn', $_cn);
									$this->setState('_uid', $_uid);
									$this->setState('_givenName', $_givenName);
									$this->setState('_sn', $_sn);
									$this->setState('_employeeNumber', $_employeeNumber);
									$this->setState('_mail', $_mail);
									
								}

								break 3; //we connected to one successfully
							}
						}
					}
				}
			}

			if (!$bind) {
				$this->errorCode = self::ERROR_PASSWORD_INVALID;
			} else {
				ldap_unbind($connection);
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