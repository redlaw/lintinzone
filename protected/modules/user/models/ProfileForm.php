<?php
class ProfileForm extends CFormModel
{
	public function rules()
	{
		return ProfileField::model()->rules();
	}
	
	public function attributeLabels()
	{
		return ProfileField::model()->attributesLabel();
	}
}
