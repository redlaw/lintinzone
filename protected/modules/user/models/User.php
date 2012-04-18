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
 * @property string $last_visited_ip
 * @property integer $last_visited_location
 */
class User extends ECassandraCF
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{USERS}}'; // case sensitive
	}

	/**
	 * Rules the input.
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
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
			'last_visited_ip' => UserModule::t('Last Visited Ip'),
			'last_visited_location' => UserModule::t('Last Visited Location')
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
	
	/*protected function beforeValidate()
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
	
	public function onBeforeSave()
	{
		parent::onBeforeSave();
		$this->password = self::encryptPassword($this->password);
	}*/
	
	public function validatePassword($password)
	{
		/*var_dump($this->password);
		var_dump(self::encryptPassword($password)); die;*/
		return self::encryptPassword($password) === $this->password;
	}
	
	/**
	 * Encrypts the password using sha1.
	 * @param string $password
	 * @return string
	 */
	public static function encryptPassword($password)
	{
		if (empty($password))
			return null;
		return sha1(Yii::app()->params['saltPassword'] . $password);
	}
	
	/**
	 * Logs info when user logs in.
	 * @return true
	 */
	public function logSession()
	{
		$this->last_visited_ip = Yii::app()->request->getUserHostAddress();
		$this->insert($this->getPrimaryKey(), array(
			'last_visited_ip' => $this->last_visited_ip
		));
		//TODO: Detect user's location
		//TODO: Insert a record into '{{login_history}}' table
		return true;
	}
	
	public static function sendRegisterVerification($email, $username)
	{
		if (empty($email))
			return false;
		$key = sha1(uniqid(rand()));
		$data = array(
			'verification_key' => $key
		);
		$model = EmailVerification::model()->get($email);
		if ($model === null)
		{
			/*$model = new EmailVerification();
			$model->email = $email;
			$model->verification_key = $key;*/
			$mailParams = array(
				'from' => Yii::app()->params['adminEmail'],
				'fromName' => 'LintinZone',
				'to' => $email,
				'subject' => 'LintinZone ' . UserModule::t('Xác nhận đăng ký thành viên'),
				'body' => array(
					'{receiver}' => (empty($username)) ? UserModule::t('my friend') : $username, // username
					'{confirm_link}' => Yii::app()->createAbsoluteUrl('user/registration/confirm', array('key' => $key, 'email' => $email)),
					'{support_link}' => Yii::app()->createAbsoluteUrl('site/contact', array('email' => $email)),
					'{home_link}' => Yii::app()->createAbsoluteUrl('')
				)
			);
			if (MailSender::sendSMTP($mailParams, 'register', 'text/html'))
			{
				/*$model->sent_date = new CDbExpression('NOW()');
				$model->save();*/
				$data['sent'] = true;
				$data['active'] = true;
				$data['verified'] = false;
				EmailVerification::model()->insert($email, $data);
				return true;
			}
			//$model->save();
			$data['sent'] = false;
			$data['active'] = true;
			$data['verified'] = false;
			EmailVerification::model()->insert($email, $data);
			return false;
		}
		else
		{
			if (!$model->verified)
			{
				//$model->verification_key = $key;
				$mailParams = array(
					'from' => Yii::app()->params['adminEmail'],
					'fromName' => 'LintinZone',
					'to' => $email,
					'subject' => 'LintinZone ' . UserModule::t('Xác nhận đăng ký thành viên'),
					'body' => array(
						'{receiver}' => (empty($username)) ? UserModule::t('my friend') : $username, // username
						'{confirm_link}' => Yii::app()->createAbsoluteUrl('user/registration/confirm', array('key' => $key, 'email' => $email)),
						'{support_link}' => Yii::app()->createAbsoluteUrl('site/contact', array('email' => $email)),
						'{home_link}' => Yii::app()->createAbsoluteUrl('')
					)
				);
				if (MailSender::sendSMTP($mailParams, 'register', 'text/html'))
				{
					$data['sent'] = true;
					$data['active'] = true;
					$data['verified'] = false;
					EmailVerification::model()->insert($email, $data);
					return true;
				}
				$data['sent'] = false;
				$data['active'] = true;
				$data['verified'] = false;
				EmailVerification::model()->insert($email, $data);
				return false;
			}
			else
				return true;
		}
	}
}