<?php
/**
 * This class has the exact job as the unique validator.
 */
class lzUnique extends CValidator
{
	/**
	 * The exact filename of the model to retrieve data.
	 * For example, User.
	 */
	public $modelClass;
	
	/**
	 * Validates the attribute of the object.
	 * If there is any error, the error message is added to the object.
	 * @param CModel $object the object being validated
	 * @param string $attribute the attribute being validated
	 * @return true|false
	 */
	protected function validateAttribute($object, $attribute)
	{
		if (empty($this->modelClass))
			$this->modelClass = get_class($object);
		$tmpObj = ECassandraCF::model($this->modelClass)->getIndexedSlices($attribute, $object->$attribute);
		// No record found
		if ($tmpObj === null)
			return true;
		// A record existed
		if (empty($this->message))
			$this->message = 'This value is not unique';
		$this->addError($object, $attribute, $this->message);
		return false;
	}
}
