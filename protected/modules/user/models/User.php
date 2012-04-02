<?php

/**
 * This is the model class for table "{{users}}".
 *
 * The followings are the available columns in table '{{users}}':
 * @property integer $user_id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property integer $active
 * @property integer $online
 * @property integer $blocked
 * @property string $created_date
 * @property string $modified_date
 * @property string $last_visited_date
 * @property string $last_visited_ip
 * @property integer $last_visited_loc_id
 */
class User extends CActiveRecord
{
	const STATUS_NOTACTIVE = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_BLOCKED = 1;
	const STATUS_NOTBLOCK = 0;
	//protected $password_repeat; // -> can't let it protected or private
	public $password_repeat;
	//public $rememberMe;
	
	//private $_identity;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'syii_users';
	}

	/**
	 * Rules the input.
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		if (Yii::app()->getModule('user')->isAdmin()) // Admin
		{
			return array(
				array(
					'email, password, password_repeat',
					'required',
					'on' => 'register'
				),
				array(
					'username, password',
					'required',
					'on' => 'login'
				),
				array(
					'username', // field
					'length', // validator
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
		 			'password',
		 			'compare'
		 		),
				array(
					'username',
					'unique',
					'message' => UserModule::t('This username is already registered.')
				),
				array(
					'email',
					'unique',
					'message' => UserModule::t('This email address is already registered.')
				),
				array(
					'username',
					'match',
					'pattern' => "/^[A-Za-z0-9_]+$/u",
					'message' => 'Only Latin alphabetical characters and numerics are allowed.'
				),
				array(
					'active',
					'in',
					'range' => array(self::STATUS_NOTACTIVE, self::STATUS_ACTIVE)
				),
				array(
					'blocked',
					'in',
					'range' => array(self::STATUS_NOTBLOCK, self::STATUS_BLOCKED)
				),
				array(
					'active, blocked',
					'numerical',
					'integerOnly' => true
				),
				array(
					'password_repeat',
					'safe'
				),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('user_id, username, email, active, online, created_date, modified_date, last_visited_date, last_visited_ip, last_visited_loc_id', 'safe', 'on'=>'search'),
			);
		}
		// Guest
		elseif  (Yii::app()->user->isGuest)
		{
			return array(
				array(
					'email, password, password_repeat',
					'required'/*,
					'on' => 'register'*/
				),
				array(
					'username, password',
					'required'/*,
					'on' => 'login'*/
				),
				/*array(
					'rememberMe',
					'boolean',
					'on' => 'login'
				),*/
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
					'password',
					'compare'/*,
					'on' => 'register'*/
				),
				array(
					'username',
					'unique',
					//'on' => 'register',
					'message' => UserModule::t('This username is already registered.')
				),
				array(
					'email',
					'unique',
					'message' => UserModule::t('This email address is already registered.')
				),
				array(
					'username',
					'match',
					'pattern' => "/^[A-Za-z0-9_]+$/u",
					//'on' => 'register',
					'message' => 'Only Latin alphabetical characters and numerics are allowed.'
				),
				array(
					'password_repeat',
					'safe'
				)/*,
				array(
					'password',
					'authenticate',
					'on' => 'login'
				)*/
			);
		}
		// Member
		return array();
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
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
			'active' => UserModule::t('Active'),
			'online' => UserModule::t('Online'),
			'blocked' => UserModule::t('Blocked'),
			'created_date' => UserModule::t('Registration Date'),
			'modified_date' => UserModule::t('Last Modified Date'),
			'last_visited_date' => UserModule::t('Last Visited Date'),
			'last_visited_ip' => UserModule::t('Last Visited Ip'),
			'last_visited_loc_id' => UserModule::t('Last Visited Location'),
			'password_repeat' => UserModule::t('Retype password'),
			'rememberMe' => UserModule::t('Remember me next time')
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		//$criteria->compare('password',$this->password,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('online',$this->online);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('modified_date',$this->modified_date,true);
		$criteria->compare('last_visited_date',$this->last_visited_date,true);
		$criteria->compare('last_visited_ip',$this->last_visited_ip,true);
		$criteria->compare('last_visited_loc_id',$this->last_visited_loc_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	protected function beforeValidate()
	{
		if ($this->isNewRecord)
		{
			$this->created_date = new CDbExpression('NOW()');
			//$this->created_date = time();
			$this->modified_date = $this->created_date;
			$this->username = strtolower($this->username);
		}
		else
		{
			$this->modified_date = new CDbExpression('NOW()');
		}
		return parent::beforeValidate();
	}
	
	protected function afterValidate()
	{
		parent::afterValidate();
		$this->password = self::encryptPassword($this->password);
	}
	
	public function validatePassword($password)
	{
		return self::encryptPassword($password) === $this->password;
	}
	
	/**
	 * Encrypts the password using sha1.
	 * @param string $password
	 * @return string
	 */
	public static function encryptPassword($password)
	{
		return sha1(Yii::app()->params['saltPassword'] . $password);
	}
	
	/**
	 * Authenticates user login.
	 */
	/*public function authenticate($attribute, $params)
	{
		// Ensure the input to be authenticated is valid.
		if (!$this->hasErrors())
		{
			$this->_identity = new UserIdentity($this->username, $this->password);
			$this->_identity->authenticate();
			switch ($this->_identity->errorCode)
			{
				case UserIdentity::ERROR_NONE:
					//$duration = $this->rememberMe ? 3600 * 24 * 30 : 0;
					$duration = 0;
					Yii::app()->user->login($this->_identity, $duration);
					return true;
				case UserIdentity::ERROR_EMAIL_INVALID:
				case UserIdentity::ERROR_USERNAME_INVALID:
				case UserIdentity::ERROR_PASSWORD_INVALID:
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
	}*/
	
	public function logSession()
	{
		
	}
}