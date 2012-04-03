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
class EmailVerification extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EmailVerification the static model class
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
		return '{{email_verification}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, verification_key, modified_date', 'required'),
			array('verified, active', 'numerical', 'integerOnly'=>true),
			array('email, verification_key', 'length', 'max'=>50),
			array('sent_date, verified_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('email, verification_key, sent_date, verified, verified_date, active, modified_date', 'safe', 'on'=>'search'),
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
			'email' => 'Email',
			'verification_key' => 'Verification Key',
			'sent_date' => 'Sent Date',
			'verified' => 'Verified',
			'verified_date' => 'Verified Date',
			'active' => 'Active',
			'modified_date' => 'Modified Date',
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

		$criteria=new CDbCriteria;

		$criteria->compare('email',$this->email,true);
		$criteria->compare('verification_key',$this->verification_key,true);
		$criteria->compare('sent_date',$this->sent_date,true);
		$criteria->compare('verified',$this->verified);
		$criteria->compare('verified_date',$this->verified_date,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('modified_date',$this->modified_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeValidate()
	{
		$this->modified_date = new CDbExpression('NOW()');
		return parent::beforeValidate();
	}
}