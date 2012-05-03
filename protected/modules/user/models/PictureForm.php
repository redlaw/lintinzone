<?php
/**
 * PictureForm is used to render the form that allow users to change their profile pictures.
 */
class PictureForm extends CFormModel
{
	public $picture;
	public $title;
	public $description;
	
	/**
	 * Declares the validation rules.
	 * @return array Rules
	 */
	public function rules()
	{
		return array(
			array(
				'picture',
				'file',
				'allowEmpty' => false,
				'maxSize' => 4 * 1024 * 1024,
				'tooLarge' => UserModule::t('Size of the image cannot exceed 4MB.'),
				'types' => 'jpg, jpeg, png, gif',
				'wrongType' => UserModule::t('Only jpg, png and gif images can be uploaded'),
				'message' => UserModule::t('No file selected')
			),
			array(
				'title',
				'length',
				'max' => 50,
				'tooLong' => UserModule::t('The caption length is 50 characters at max.')
			),
			array(
				'description',
				'length',
				'max' => 1000,
				'tooLong' => UserModule::t('The caption length is 1000 characters at max.')
			)
		);
	}
	
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'picture' => UserModule::t('Select an image on your computer (4MB)'),
			'title' => UserModule::t('Caption'),
			'description' => UserModule::t('Description')
		);
	}
}
