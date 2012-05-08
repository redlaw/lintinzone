<?php
/**
 * This is the model class for table "{{PROFILE_INFO}}"
 */
class Profile extends ECassandraCF
{
	/**
	 * The ID of the object.
	 * @var string
	 */
	private $_objectId;
	
	/**
	 * The type of the object, for example, user_
	 * @var string
	 */
	private $_objectType;
	
	/**
	 * Array of profile fields.
	 * @var array
	 */
	private $_fields;
	
	/**
	 * List of instances that hold data for objects.
	 * @var array
	 */
	private static $_instances;
	
	public function __construct($objectId, $objectType, $scenario = 'insert')
	{
		$this->_objectId = $objectId;
		$this->_objectType = $objectType;
		parent::__construct($scenario);
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $objectId The ID of the target object
	 * @param string $objectType The type of the target object plus the underscore (_), for example, user_
	 * @param string $className active record class name
	 * @return User the static model class
	 */
	public static function model($objectId, $objectType, $className = __CLASS__)
	{
		if (empty($objectId))
		{
			$userId = Yii::app()->user->getId();
			if (!empty($userId))
				$objectId = CassandraUtil::import($userId)->__toString();
			else
				throw new InvalidArgumentException('Object ID is empty');
		}
		else
		{
			$objectId = CassandraUtil::import($objectId)->__toString();
		}
		if (empty($objectType))
			$objectType = User::PREFIX;
		// If there is an instance of this object, return it.
		if (isset(self::$_instances[$objectType . $objectId]))
			return self::$_instances[$objectType . $objectId];
		// If not, create one. Save it.
		else
		{
			$newInstance = new Profile($objectId, $objectType);
			self::$_instances[$objectType . $objectId] = $newInstance;
			return $newInstance;
		}
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
		//return Profile::model()->rules();
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
	 * Note, this function does not use cache data.
	 * Use this function to refresh the data.
	 * @param string $fieldName the name of the field to get (for example, first_name, last_name...)
	 * @return array
	 */
	public function getFieldInfo($fieldName)
	{
		if (empty($fieldName))
			return null;
		
		// Get the whole profile info.
		$profileValues = $this->get($this->_objectType . $this->_objectId, array($fieldName));
		// Return null if the profile of the given object cannot be found.
		if (empty($profileValues))
		{
			if (isset($this->_fields[$fieldName]))
				unset($this->_fields[$fieldName]);
			return null;
		}
		$this->_fields[$fieldName] = $profileValues[$fieldName];
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
	public function setFieldInfo($fieldName, $fieldValue)
	{
		if (empty($fieldName))
			return false;
		
		// If field value is left as null, the column will be removed.
		if (empty($fieldValue))
		{
			$this->delete($objectType . $objectId, array($fieldName));
			if (isset($this->_fields[$fieldName]))
				unset($this->_fields[$fieldName]);
			return true;
		}
		return $this->insert($this->_objectType . $this->_objectId, array($fieldName => $fieldValue));
	}
	
	/**
	 * Gets all profile info of an object.
	 * @return array
	 */
	public function getProfileInfo()
	{
		$data = $this->get($this->_objectType . $this->_objectId);
		return $data;
		$fields = array();
		foreach ($data as $fieldName => $fieldValue)
		{
			$fields[$fieldName] = $fieldValue;
		}
		$this->_fields = $fields;
		return $this->_fields;
	}
	
	/**
	 * Sets the fields value of an object.
	 * @param array $fields an associative array of (field_name => field_value)
	 * @return true|false
	 */
	public function setProfileFields(array $fields)
	{
		if (empty($fields))
			return false;
		
		foreach ($fields as $fieldName => $fieldValues)
		{
			if (empty($fieldValues['value']))
			{
				$this->setFieldInfo($fieldName, '');
				unset($fields[$fieldName]);
			}
			else
			{
				if ($this->getFieldInfo($fieldName) === null)
					$fields['verified'] = array('value' => false);
			}
		}
		return $this->insert($this->_objectType . $this->_objectId, $fields);
	}
	
	/**
	 * Returns a value of a field.
	 * @param string $name Name of the field to get value
	 * @return mixed field's value | null if such field has not existed
	 */
	public function __get($name)
	{
		if (isset($this->_fields[$name]))
			return $this->_fields[$name];
		return null;
	}
	
	/**
	 * Sets value of a field.
	 * @param string $name Name of the field to set value
	 * @param mixed $value The value to set
	 * @return true set value successfully | false
	 */
	public function __set($name, $value)
	{
		$this->initFields();
		if (isset($this->_fields[$name]))
		{
			$this->_fields[$name] = $value;
			return true;
		}
		return false;
	}
}
