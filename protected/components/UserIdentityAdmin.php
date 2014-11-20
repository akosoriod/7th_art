<?php

/**
 * UserIdentityAdmin represents the data needed to identity a user (admin and oper).
 * It contains the authentication method that checks if the provided
 * data can identity the user (admin and oper).
 */
class UserIdentityAdmin extends CUserIdentity {

	/**
	 * Authenticates a user (admin and oper).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {
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

		return !$this->errorCode;
	}

}