<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	const ERROR_STATUS_NOTACTIVE = 0;
	const ERROR_STATUS_BLOCKED = 1;
	const ERROR_EMAIL_INVALID = 0;
	private $_user_id;
	
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
		$username = strtolower($this->username);
		//$user = User::model()->find('username = ?', array($username));
		//Yii::log('user identity ' . $username, 'error', 'system.web.CController');
		$user = User::model()->getIndexedSlices('username', $username);
		if ($user === null)
		{
			/*$user = User::model()->find('email = ?', array($username));
			if ($user === null)*/
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}
		if ($user !== null)
		{
			if (!$user->validatePassword($this->password))
				$this->errorCode = self::ERROR_PASSWORD_INVALID;
			else
			{
				$this->_user_id = $user->user_id;
				$this->username = $user->username;
				if ($user->active !== 1)
					$this->errorCode = self::ERROR_STATUS_NOTACTIVE;
				elseif ($user->blocked === 1)
					$this->errorCode = self::ERROR_STATUS_BLOCKED;
				else
					$this->errorCode = self::ERROR_NONE;
			}
		}
		return !$this->errorCode;
	}
	
	public function getId()
	{
		return $this->_user_id;
	}
}