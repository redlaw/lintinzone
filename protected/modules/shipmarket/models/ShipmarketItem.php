<?php

/**
 * This is the model class for table "{{shipmarket_item}}".
 *
 * The followings are the available columns in table '{{shipmarket_item}}':
 * @property string $id
 * @property string $name
 * @property string $size
 * @property string $weight
 * @property string $get_before
 * @property string $description
 * @property integer $country_id
 * @property integer $owner_id
 * @property string $creation_date
 * @property string $status
 */
class ShipmarketItem extends CActiveRecord
{
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return ShipmarketItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shipmarket_item}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('owner_id, creation_date, name,price', 'required'),
			array('country_id, owner_id', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('name', 'length', 'max'=>255),
			array('size', 'length', 'max'=>150),
			array('weight', 'length', 'max'=>4),
			array('status', 'length', 'max'=>6),
			array('get_before, description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, size, weight, get_before, description, country_id, owner_id, creation_date, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'owner'=>array(self::BELONGS_TO,'User','owner_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'size' => 'Size',
			'weight' => 'Weight',
			'get_before' => 'Get Before',
			'description' => 'Description',
			'country_id' => 'Country',
			'owner_id' => 'Owner',
			'creation_date' => 'Creation Date',
			'status' => 'Status',
			
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('size',$this->size,true);
		$criteria->compare('weight',$this->weight,true);
		$criteria->compare('get_before',$this->get_before,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('owner_id',$this->owner_id);
		$criteria->compare('creation_date',$this->creation_date,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getReadableFileSize($retstring = null) {
		// adapted from code at http://aidanlister.com/repos/v/function.size_readable.php
		$sizes = array('bytes', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

		if ($retstring === null) { $retstring = '%01.2f %s'; }

		$lastsizestring = end($sizes);

		foreach ($sizes as $sizestring) {
			if ($this->size < 1024) { break; }
			if ($sizestring != $lastsizestring) { $this->size /= 1024; }
		}
		if ($sizestring == $sizes[0]) { $retstring = '%01d %s'; } // Bytes aren't normally fractional
		return sprintf($retstring, $this->size, $sizestring);
	}
}