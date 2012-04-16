<?php

/**
 * This is the model class for table "{{PROFILE_INFO}}"
 */
class Profile extends ECassandraCF
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
		return '{{PROFILE_INFO}}'; // case sensitive
	}
	
	public function rules()
	{
		return array();
	}
}
