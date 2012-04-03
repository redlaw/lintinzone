<?php
/**
 * Registration class.
 * Registration is the data structure for keeping
 * user registration form data. It is used by the 'registration' action of 'UserController'.
 */
class Registration extends User
{
	public $verification_code;
	
	public function rules()
	{
		$rules = parent::rules();
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'registration-form') 
			return $rules;
		else
			array_push($rules, array('verification_code', 'captcha', 'allowEmpty' => !UserModule::doCaptcha('registration')));
		return $rules;
	}
}
