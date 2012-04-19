<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	const ERROR_STATUS_NOTACTIVE = 4;
	const ERROR_STATUS_BLOCKED = 5;
	const ERROR_EMAIL_INVALID = 1;
	const ERROR_USERNAME_INVALID = 2;
	const ERROR_PASSWORD_INVALID = 3;
	private $_userId;
	
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
		$user = User::model()->getIndexedSlices('username', $username);
		if ($user === null)
		{
			$user = User::model()->getIndexedSlices('email', $username);
			if ($user === null)
				$this->errorCode = self::ERROR_USERNAME_INVALID;
		}
		if ($user !== null)
		{
			if (!$user->validatePassword($this->password))
				$this->errorCode = self::ERROR_PASSWORD_INVALID;
			else
			{
				$this->_userId = $user->getPrimaryKey();
				$this->username = $user->username;
				if (!$user->active || $user->blocked === true)
				{
					if (!$user->active)
						$this->errorCode = self::ERROR_STATUS_NOTACTIVE;
					else
						$this->errorCode = self::ERROR_STATUS_BLOCKED;
				}
				else
					$this->errorCode = self::ERROR_NONE;
			}
		}
		return !$this->errorCode;
	}
	
	public function getId()
	{
		return $this->_userId;
	}
}