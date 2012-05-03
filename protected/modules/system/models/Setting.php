<?php
/**
 * This is the model class for table "{{SETTINGS}}"
 */
class Setting extends ECassandraCF
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
		return '{{SETTINGS}}'; // case sensitive
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
			'attribute' => 'Attribute',
			'value' => 'Value',
			'timestamp' => 'Last modified date'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
	}
	
	/**
	 * Gets a setting variable.
	 * @param string $name The variable name to get
	 * @return mixed The variable value
	 */
	public function __get($name)
	{
		$value = parent::__get($name);
		if ($value === null)
		{
			$value = $this->get($name);
			if ($value === null)
				return null;
			parent::__set($name, $value);
		}
		return $value;
	}
	
	/**
	 * Sets a setting variable.
	 * @param string $name The variable name
	 * @param mixed $value The variable value
	 * @return true
	 */
	public function __set($name, $value)
	{
		parent::__set($name, $value);
		return $this->insert($name, array('value' => $value));
	}
}
