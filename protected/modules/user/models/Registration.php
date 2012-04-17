<?php
/**
 * Registration class.
 * Registration is the data structure for keeping
 * user registration form data. It is used by the 'registration' action of 'UserController'.
 */
class Registration extends CFormModel
{
	public $email;
	public $username;
	public $password;
	public $password_repeat;
	public $verification_code;
	public $isNewRecord = true;
	
	public function rules()
	{
		/*$rules = parent::rules();
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'registration-form') 
			return $rules;
		else
			array_push($rules,
				array('verification_code', 'captcha', 'allowEmpty' => !UserModule::doCaptcha('registration')),
				array('password_repeat', 'compare', 'compareAttribute' => 'passowrd'),
				array('password_repeat', 'required')
			);
		return $rules;*/
		return array(
			array(
				'email, password, password_repeat',
				'required'
			),
			array(
				'username',
				'length',
				'max' => 50,
				'min' => 6, // Username both have at least 6 characters
				'message' => UserModule::t('Username must be between 6 and 50 characters in length.')
			),
			array(
				'email',
				'length',
				'max' => 50,
				'message' => UserModule::t('Email address cannot have more than 50 characters.')
			),
			array(
				'email',
				'email',
				'message' => UserModule::t('Provided email address is not valid.')
			),
			array(
				'password',
				'length',
				'max' => 255,
				'min' => 8 // Password has at least 8 characters.
			),
			array(
				'username',
				'lzUnique',
				'message' => UserModule::t('This username is already registered.'),
				'modelClass' => 'User'
			),
			array(
				'email',
				'lzUnique',
				'message' => UserModule::t('This email address is already registered.'),
				'modelClass' => 'User'
			),
			array(
				'username',
				'match',
				'pattern' => "/^[A-Za-z0-9_]+$/u",
				'message' => 'Only Latin alphabetical characters and numerics are allowed.'
			),
			array(
				'password_repeat',
				'compare',
				'compareAttribute' => 'password'
			),
			array(
				'verification_code',
				'captcha',
				'allowEmpty' => !UserModule::doCaptcha('registration')
			)
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => UserModule::t('User ID'),
			'username' => UserModule::t('Username'),
			'email' => UserModule::t('Email'),
			'password' => UserModule::t('Password'),
			'password_repeat' => UserModule::t('Retype password')
		);
	}
}
