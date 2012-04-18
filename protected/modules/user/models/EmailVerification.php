<?php

/**
 * This is the model class for table "{{email_verification}}".
 *
 * The followings are the available columns in table '{{email_verification}}':
 * @property string $email
 * @property string $verification_key
 * @property string $sent_date
 * @property integer $verified
 * @property string $verified_date
 * @property integer $active
 * @property string $modified_date
 */
class EmailVerification extends ECassandraCF
{
	const CONFIRM_ALREADY_ACTIVE = 1;
	const CONFIRM_INVALID_KEY = 2;
	const CONFIRM_KEY_NOT_ACTIVE = 3;
	const CONFIRM_ERROR = 4;
	const CONFIRM_SUCCESS = 5;
	const CONFIRM_USER_BLOCKED = 6;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EmailVerification the static model class
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
		return '{{EMAIL_VERIFICATION}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, verification_key', 'required'),
			array('email, verification_key', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('email, verification_key, sent, verified, verified, active', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'email' => UserModule::t('Email'),
			'verification_key' => UserModule::t('Verification Key'),
			'sent' => UserModule::t('Sent'),
			'verified' => UserModule::t('Verified'),
			'active' => UserModule::t('Active')
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

		$criteria->compare('email', $this->email,true);
		$criteria->compare('verification_key', $this->verification_key,true);
		$criteria->compare('sent_date', $this->sent_date,true);
		$criteria->compare('verified', $this->verified);
		//$criteria->compare('verified_date', $this->verified_date,true);
		$criteria->compare('active', $this->active);
		//$criteria->compare('modified_date', $this->modified_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Confirms an email address.
	 * @param string $email The email to confirm
	 * @param string $key The confirmation key
	 * @return int
	 */
	public function confirm($email, $key)
	{
		$emailVerify = $this->get($email);
		$user = User::model()->getIndexedSlices('email', $email);
		$userId = $user->getPrimaryKey();
		// If this account is blocked
		if ($user->blocked === true)
			return self::CONFIRM_USER_BLOCKED;
		// If this email has already been verified
		if ($user->active === true)
			return self::CONFIRM_ALREADY_ACTIVE;
		// If the verification key does not match
		if ($emailVerify->verification_key !== $key)
			return self::CONFIRM_INVALID_KEY;
		// If this key is not active
		if ($emailVerify->active == false)
			return self::CONFIRM_KEY_NOT_ACTIVE;
		// After all, update the database
		$verifyData = array(
			'active' => false,
			'verified' => true
		);
		if ($emailVerify->sent == false)
			$verifyData['sent'] = true;
		// Mark this key as verified
		if ($this->insert($email, $verifyData) !== true)
			return self::CONFIRM_ERROR;
		// Mark this account as activated
		if (User::model()->insert($userId, array('active' => true)) === true)
			return self::CONFIRM_SUCCESS;
		return self::CONFIRM_ERROR;
	}

	/*protected function beforeValidate()
	{
		$this->modified_date = new CDbExpression('NOW()');
		return parent::beforeValidate();
	}*/
}