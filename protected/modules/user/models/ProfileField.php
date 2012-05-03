<?php
class ProfileField extends ECassandraCF
{
	/**
	 * Array of rules.
	 * @var array
	 */
	private static $_rules;
	
	/**
	 * Array of profile fields.
	 * @var array
	 */
	private $_fields;
	
	/**
	 * List of available profile fields.
	 * @var RangeColumnFamilyIterator
	 */
	private static $_data;
	
	/**
	 * List of field types
	 * @var array
	 */
	 private static $_types;
	
	/**
	 * Flags
	 * @var boolean
	 */
	private static $_refresh = true;
	private static $_refreshRules = true;
	private static $_refreshFields = true;
	private static $_refreshTypes = true;
	
	protected function initFields()
	{
		if (empty($this->_fields) || self::$_refreshFields === true)
		{
			self::$_refreshFields = false;
			$this->_fields = array();
			$this->getAllFieldsMetadata();
			foreach (self::$_data as $fieldName => $metadata)
			{
				//array_push($this->_fields, $fieldName);
				$this->_fields[$fieldName] = '';
			}
		}
	}
	
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
		return '{{PROFILE_FIELDS}}'; // case sensitive
	}

	/**
	 * Rules the input.
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		if (empty(self::$_rules) || self::$_refreshRules === true)
		{
			self::$_rules = array();
			self::$_refreshRules = false;
			$fieldMetadata = $this->getAllFieldsMetadata();
			/*
			List of validators
			 * boolean  * captcha  * compare  * date  * default
			 * email  * exist  * file  * filter  * in
			 * length  * numerical  * match  * required  * safe
			 * type  * unique  * unsafe  * url  * lz_unique
			*/
			foreach ($fieldMetadata as $fieldName => $metadata)
			{
				foreach ($metadata as $validator => $validatorAttributes)
				{
					if ($validator !== 'not_validator')
					{
						$temp = array($fieldName);
						switch ($validator)
						{
							// CBooleanValidator
							case 'boolean':
								/*
								 * Attributes:
								 *  - allowEmpty: whether the attribute value can be null or empty (the default is true)
								 *  - falseValue: the value representing the false status (0)
								 *  - strict: whether the comparison to trueValue and falseValue is strict (false)
								 *  - trueValue: the value representing the true status (1)
								 * Cassandra databases does not need these attributes.
								*/
								$temp[1] = 'boolean';
								$temp['falseValue'] = false;
								$temp['trueValue'] = true;
								break;
							// CCompareValidator
							case 'compare':
								/*
								 * Attributes:
								 *  - allowEmpty
								 *  - compareAttribute: the name of the attribute to be compared with
								 *  - compareValue: the constant value to be compared with
								 *  - operator: the operator for comparison (==)
								 *  - strict: whether the comparison is strict (both value and type must be the same) (false)
								*/
								$temp[1] = 'compare';
								if (is_array($validatorAttributes))
								{
									if (isset($validatorAttributes['compareAttribute']))
										$temp['compareAttribute'] = $validatorAttributes['compareAttribute'];
									elseif (isset($validatorAttributes['compareValue']))
										$temp['compareValue'] = $validatorAttributes['compareValue'];
									if (isset($validatorAttributes['operator']))
										$temp['operator'] = $validatorAttributes['operator'];
									if (isset($validatorAttributes['strict']))
										$temp['strict'] = $validatorAttributes['strict'];
								}
								break;
							// CDateValidator
							case 'date':
								/*
								 * Attributes:
								 *  - allowEmpty
								 *  - format: the format pattern that the date value should follow. This can be either a string or an array representing multiple formats. The formats are described in CDateTimeParser API ('MM/dd/yyyy')
								 *  - timestampAttribute: name of the attribute that will receive date parsing result (null)
								*/
								$temp[1] = 'date';
								if (is_array($validatorAttributes))
								{
									if (isset($validatorAttributes['format']))
										$temp['format'] = $validatorAttributes['format'];
									if (isset($validatorAttributes['timestampAttribute']))
										$temp['timestampAttribute'] = $validatorAttributes['timestampAttribute'];
								}
								break;
							// CDefaultValueValidator
							case 'default':
								/*
								 * Attributes:
								 *  - setOnEmpty: whether to set the default value only when the attribute value is null or empty string (true)
								 *  - value: the default value to be set to the specified attributes
								*/
								$temp[1] = 'default';
								if (is_array($temp['default']))
								{
									if (isset($validatorAttributes['value']))
										$temp['value'] = $validatorAttributes['value'];
									if (isset($validatorAttributes['setOnEmpty']))
										$temp['setOnEmpty'] = $validatorAttributes['setOnEmpty'];
								}
								break;
							// CEmailValidator
							case 'email':
								/*
								 * Attributes:
								 *  - allowEmpty
								 *  - allowName: whether to allow name in the email address (false)
								 *  - checkMX: whether to check the MX record for the email address (false)
								 *  - checkPort: whether to check port 25 for the email address (false)
								 *  - fullPattern: the regular expression used to validate email addresses with the name part. Requires that the property "allowname" is on
								 *  - pattern: the regular expression used to validate the attribute value
								*/
								$temp[1] = 'email';
								if (is_array($validatorAttributes))
								{
									if (isset($validatorAttributes['allowName']))
										$temp['allowName'] = $validatorAttributes['allowName'];
									if (isset($validatorAttributes['checkMX']))
										$temp['checkMX'] = $validatorAttributes['checkMX'];
									if (isset($validatorAttributes['checkPort']))
										$temp['checkPort'] = $validatorAttributes['checkPort'];
									if (isset($validatorAttributes['fullPattern']))
										$temp['fullPattern'] = $validatorAttributes['fullPattern'];
									if (isset($validatorAttributes['pattern']))
										$temp['pattern'] = $validatorAttributes['pattern'];
								}
								break;
							// CRangeValidator
							case 'in':
								/*
								 * Attributes:
								 *  - allowEmpty
								 *  - not: whether to invert the validation logic. Since Yii 1.1.5 (false)
								 *  - range: list of valid values that the attribute value should be among
								 *  - strict: whether the comparison is strict (both type and value must be the same) (false)
								*/
								$temp[1] = 'in';
								if (is_array($validatorAttributes))
								{
									if (isset($validatorAttributes['not']))
										$temp['not'] = $validatorAttributes['not'];
									if (isset($validatorAttributes['range']))
										$temp['range'] = $validatorAttributes['range'];
									if (isset($validatorAttributes['strict']))
										$temp['strict'] = $validatorAttributes['strict'];
								}
								break;
							// CStringValidator
							case 'length':
								/*
								 * Attributes:
								 *  - allowEmpty
								 *  - encoding: string encoding (null, meaning unchecked)
								 *  - is: exact length (null, meaning no limit)
								 *  - max: maximum length (null, meaning no limit)
								 *  - min: minimum length (null, meaning no limit)
								 *  - tooLong: user-defined error message used when the value is too long
								 *  - tooShort: user-defined error message used when the value is too short
								*/
								$temp[1] = 'length';
								if (is_array($validatorAttributes))
								{
									if (isset($validatorAttributes['encoding']))
										$temp['encoding'] = $validatorAttributes['encoding'];
									if (isset($validatorAttributes['is']))
										$temp['is'] = $validatorAttributes['is'];
									if (isset($validatorAttributes['max']))
										$temp['max'] = $validatorAttributes['max'];
									if (isset($validatorAttributes['min']))
										$temp['min'] = $validatorAttributes['min'];
									if (isset($validatorAttributes['tooLong']))
										$temp['tooLong'] = $validatorAttributes['tooLong'];
									if (isset($validatorAttributes['tooShort']))
										$temp['tooShort'] = $validatorAttributes['tooShort'];
								}
								break;
							// lz_unique
							case 'lz_unique':
								/*
								 * Attribute:
								 *  - modelClass: class name of the model to check
								*/
								$temp[1] = 'lz_unique';
								if (is_array($validatorAttributes)
									&& isset($validatorAttributes['modelClass']))
									$temp['modelClass'] = $validatorAttributes['modelClass'];
								break;
							// CNumberValidator
							case 'numerical':
								/*
								 * Attributes:
								 *  - allowEmpty
								 *  - integerOnly: whether the attribute value can only be an integer (false)
								 *  - max: upper limit of the number (null, meaning no limit)
								 *  - min: lower limit of the number (null, meaning no limit)
								 *  - tooBig: user-defined error message used when the value is too big
								 *  - tooSmall: user-defined error message used when the value is too small
								*/
								$temp[1] = 'numerical';
								if (is_array($validatorAttributes))
								{
									if (isset($validatorAttributes['integerOnly']))
										$temp['integerOnly'] = $validatorAttributes['integerOnly'];
									if (isset($validatorAttributes['max']))
										$temp['max'] = $validatorAttributes['max'];
									if (isset($validatorAttributes['min']))
										$temp['min'] = $validatorAttributes['min'];
									if (isset($validatorAttributes['tooBig']))
										$temp['tooBig'] = $validatorAttributes['tooBig'];
									if (isset($validatorAttributes['tooSmall']))
										$temp['tooSmall'] = $validatorAttributes['tooSmall'];
								}
								break;
							// CRegularExpressionValidator
							case 'match':
								/*
								 * Attributes:
								 *  - allowEmpty
								 *  - not: whether to invert the validation logic. Since Yii 1.1.5. (false)
								 *  - pattern: the regular expression to be matched with
								*/
								$temp[1] = 'match';
								if (is_array($validatorAttributes))
								{
									if (isset($validatorAttributes['not']))
										$temp['not'] = $validatorAttributes['not'];
									if (isset($validatorAttributes['pattern']))
										$temp['pattern'] = $validatorAttributes['pattern'];
								}
								break;
							// CRequiredValidator
							case 'required':
								/*
								 * Attributes:
								 *  - requiredValue: the desired value that the attribute must have (null)
								 *  - strict: whether the comparison to "requiredValue" is strict (false)
								*/
								$temp[1] = 'required';
								if (is_array($validatorAttributes))
								{
									if (isset($validatorAttributes['requiredValue']))
										$temp['requiredValue'] = $validatorAttributes['requiredValue'];
									if (isset($validatorAttributes['strict']))
										$temp['strict'] = $validatorAttributes['strict'];
								}
								break;
							// CUrlValidator
							case 'url':
								/*
								 * Attributes:
								 *  - allowEmpty
								 *  - defaultScheme: the default URI scheme. It will be prepended to the input, if the input doesn't contain one
								 *  - pattern: the regular expression used to validates the attribute value
								 *  - validSchemes: the allowed URI scheme. (array('http', 'https'))
								*/
								$temp[1] = 'url';
								if (is_array($validatorAttributes))
								{
									if (isset($validatorAttributes['defaultScheme']))
										$temp['defaultScheme'] = $validatorAttributes['defaultScheme'];
									if (isset($validatorAttributes['pattern']))
										$temp['pattern'] = $validatorAttributes['pattern'];
									if (isset($validatorAttributes['validSchemes']))
										$temp['validSchemes'] = $validatorAttributes['validSchemes'];
								}
								break;
						} // endswitch
						// Check common attributes
						if (is_array($validatorAttributes))
						{
							if (isset($validatorAttributes['message']))
								$temp['message'] = $validatorAttributes['message'];
							if (isset($validatorAttributes['on']))
								$temp['on'] = $validatorAttributes['on'];
							if (isset($validatorAttributes['enableClientValidation']))
								$temp['enableClientValidation'] = $validatorAttributes['enableClientValidation'];
						} // endif
						array_push(self::$_rules, $temp);
					} // endif
				} // endforeach
			}// endforeach
		}
		return self::$_rules;
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
		$fieldMetadata = $this->getAllFieldsMetadata();
		$labels = array();
		foreach ($fieldMetadata as $fieldName => $metadata)
		{
			array_push($labels, UserModule::t($metadata['not_validator']['field_title']));
		}
		return $labels;
	}
	
	/**
	 * Gets metadata of a field.
	 * @param string $fieldName name of the field to get
	 * @return array
	 */
	public function getFieldMetadata($fieldName)
	{
		/*if (empty($fieldName))
			return null;
		return $this->get($fieldName);*/
		$this->getAllFieldsMetadata();
		return self::$_data[$fieldName];
	}
	
	/**
	 * Gets metadata of all fields.
	 * @return array
	 */
	public function getAllFieldsMetadata()
	{
		if (self::$_data === null
			|| self::$_refresh === true)
		{
			self::$_data = $this->getRange();
			self::$_refresh = false;
		}
		return self::$_data;
	}
	
	/**
	 * Refreshes the data. Call this function after you updated the profile fields metadata.
	 */
	public function refresh()
	{
		self::$_refresh = true;
		self::$_refreshFields = true;
		self::$_refreshRules = true;
		self::$_refreshTypes = true;
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
	
	/**
	 * Gets all field types.
	 * @return array
	 */
	public function getAllFieldTypes()
	{
		/*
		 * List of field types:
		 *  - checkBox
		 *  - checkBoxList
		 *  - dropDownList
		 *  - fileField
		 *  - passwordField
		 *  - radioButton
		 *  - radioButtonList
		 *  - textArea
		 *  - textField
		 */
		if (empty(self::$_types) || self::$_refreshTypes === true)
		{
			self::$_refreshTypes = false;
			$fieldMetadata = $this->getAllFieldsMetadata();
			self::$_types = array();
			foreach ($fieldMetadata as $fieldName => $metadata)
			{
				self::$_types[$fieldName] = UserModule::t($metadata['not_validator']['field_type']);
			}
			return self::$_types;
		}
	}
}
