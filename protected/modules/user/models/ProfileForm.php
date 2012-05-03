<?php
class ProfileForm extends CFormModel
{
	public function rules()
	{
		return ProfileField::model()->rules();
	}
	
	public function attributeLabels()
	{
		return ProfileField::model()->attributeLabels();
	}
	
	public function __get($name)
	{
		return ProfileField::model()->__get($name);
	}
	
	public function __set($name, $value)
	{
		// To extract variables from an associative array
		// User ' extract ' function. See http://us.php.net/extract
		return ProfileField::model()->__set($name, $value);
	}
	
	public function getAllFieldTypes()
	{
		return ProfileField::model()->getAllFieldTypes();
	}
}
