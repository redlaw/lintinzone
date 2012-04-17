<?php
/**
 * Login class is the data structure for keeping user login form data.
 */
class Login extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe = false;
	
	//private $_identity;
	
	/**
	 * Declares the validation rules.
	 * The rules state that email (or username) and password are required.
	 * Password needs to be authenticated.
	 * User can either uses his email address or username to login.
	 * @return array Rules
	 */
	public function rules()
	{
		return array(
			array('username, password', 'required'),
			array('password', 'authenticate'),
			array('rememberMe', 'boolean'),
			array('username', 'length', 'max' => 50, 'min' => 6),
			array('password', 'length', 'max' => 255, 'min' => 8)
		);
	}
	
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'username' => UserModule::t('Email address or Username'), // UserModule::t -> multilingual purpose
			'password' => UserModule::t('Password'),
			'rememberMe' => UserModule::t('Remember me next time')
		);
	}
	
	/**
	 * Authenticates the user's credentials.
	 * @return true|false
	 */
	public function authenticate($attribute, $params)
	{
		// Ensure the input to be authenticated is valid.
		if (!$this->hasErrors())
		{
			$identity = new UserIdentity($this->username, $this->password);
			$identity->authenticate();
			switch ($identity->errorCode)
			{
				case UserIdentity::ERROR_NONE:
					//$duration = $this->rememberMe ? 3600 * 24 * 30 : 0;
					$duration = 0;
					Yii::app()->user->login($identity, $duration);
					return true;
				case UserIdentity::ERROR_EMAIL_INVALID:
				case UserIdentity::ERROR_USERNAME_INVALID:
				case UserIdentity::ERROR_PASSWORD_INVALID:
					Yii::trace('Error codeeee: ' . $identity->errorCode, 'system.db.ar.CActiveRecord');
					$this->addError('username', UserModule::t('Incorrect username or password.'));
					return false;
				case UserIdentity::ERROR_STATUS_NOTACTIVE:
					$this->addError('active', UserModule::t('Your account is not activated yet. Make sure you confirm your email address before logging in.'));
					return false;
				case UserIdentity::ERROR_STATUS_BLOCKED:
					$this->addError('blocked', UserModule::t('Your account is blocked.'));
					return false;
			}
		}
	}
}
