<?php
/**
 * This is the model class for table "{{PROFILE_INFO}}"
 */
class Profile extends ECassandraCF
{
	/**
	 * The temporary data
	 */
	//private static $_tempData = array();
	
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

	/**
	 * Rules the input.
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array();
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
			'field_name' => UserModule::t('Name'),
			'field_title' => UserModule::t('Title'),
			'default' => UserModule::t('Default value'),
			'field_size_max' => UserModule::t('Max length'),
			'field_size_min' => UserModule::t('Min length'),
			'required' => UserModule::t('Required'),
			'error_message' => UserModule::t('Error message'),
			'position' => UserModule::t('Position'),
			'visible' => UserModule::t('Visibility'),
			'widget' => UserModule::t('Widget'),
			'widget_params' => UserModule::t('Widget params'),
			'field_value' => UserModule::t('Value'),
			'note' => UserModule::t('Note'),
			'verified' => UserModule::t('Verified'),
			'privacy' => UserModule::t('Privacy'),
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

		/*$criteria = new CDbCriteria;

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
		));*/
	}
	
	/**
	 * Gets value of a specific profile field.
	 * @param string $objectId the row key of the object to get info
	 * @param string $objectType type of the object (for example, user, trip...) plus the underscore (_)
	 * @param string $fieldName the name of the field to get (for example, first_name, last_name...)
	 * @return array
	 */
	public function getFieldInfo($objectId, $objectType, $fieldName)
	{
		if (empty($objectId)
			|| empty($fieldName))
			return null;
			
		if (empty($objectType))
			$objectType = User::PREFIX;
			
		//TODO: Improve the performance by caching data.
		/*if (!isset(self::$_tempData[$objectType . '_' . $objectId]))
			self::$_tempData[$objectType . '_' . $objectId] = array(
				'data' => $this->get($objectType . '_' . $objectId),
				'createdTime' => time(),
				'lastAccessTime' => time()
			);
		else
		{
			return self::$_tempData[$objectType . '_' . $objectId]['data'][$fieldName];
		}*/
		
		// Get the whole profile info.
		$profileValues = $this->get($objectType . $objectId);
		// Return null if the profile of the given object cannot be found.
		if (empty($profileValues))
			return null;
		// Return null if such given field cannot be found.
		if (!isset($profileValues[$fieldName]))
			return null;
		return $profileValues[$fieldName];
	}
	
	/**
	 * Sets a value of a specific profile field.
	 * @param string $objectId the row key of the object to get info
	 * @param string $objectType type of the object (for example, user, trip...) plus the underscore (_)
	 * @param string $fieldName the name of the field to get (for example, first_name, last_name...)
	 * @param mixed $fieldValue the value to set. Note, leave this value as null will result in this column to be removed
	 * @return true|false
	 */
	public function setFieldInfo($objectId, $objectType, $fieldName, $fieldValue)
	{
		if (empty($objectId)
			|| empty($fieldName))
			return false;
			
		if (empty($objectType))
			$objectType = User::PREFIX;
		
		// If field value is left as null, the column will be removed.
		if ($fieldValue === null)
		{
			$this->delete($objectType . $objectId, array($fieldName));
			return true;
		}
		return $this->insert($objectType . $objectId, array($fieldName => $fieldValue));
	}
	
	/**
	 * Gets all profile info of an object.
	 * @param string $objectId the row key of the object to get info
	 * @param string $objectType type of the object (for example, user, trip...) plus the underscore (_)
	 * @return array
	 */
	public function getProfileInfo($objectId, $objectType)
	{
		if (empty($objectId)
			|| empty($fieldName))
			return null;
			
		if (empty($objectType))
			$objectType = User::PREFIX;
		
		// Get the whole profile info.
		return $this->get($objectType . $objectId);
	}
	
	/**
	 * Sets the fields value of an object.
	 * @param string $objectId the row key of the object to get info
	 * @param string $objectType type of the object (for example, user, trip...) plus the underscore (_)
	 * @param array $fields an associative array of (field_name => field_value)
	 * @return true|false
	 */
	public function setProfileFields($objectId, $objectType, array $fields)
	{
		if (empty($objectId)
			|| empty($fieldName)
			|| empty($fields))
			return false;
			
		if (empty($objectType))
			$objectType = User::PREFIX;
		
		return $this->insert($objectType . $objectId, $fields);
	}
}
