<?php

/**
 * This is the model class for table "{{storage_files}}".
 *
 * The followings are the available columns in table '{{storage_files}}':
 * @property string $file_id
 * @property string $parent_file_id
 * @property string $type
 * @property string $parent_type
 * @property string $parent_id
 * @property string $user_id
 * @property string $create_time
 * @property string $modify_time
 * @property string $storage_path
 * @property string $extension
 * @property string $name
 * @property string $mime_type
 * @property string $size
 */
class Storage_File extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Storage_Files the static model class
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
		return '{{storage_files}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, modify_time, storage_path, extension, mime_type, size', 'required'),
			array('parent_file_id, parent_id, user_id', 'length', 'max'=>11),
			array('type', 'length', 'max'=>16),
			array('parent_type', 'length', 'max'=>32),
			array('storage_path, name', 'length', 'max'=>255),
			array('extension', 'length', 'max'=>8),
			array('mime_type', 'length', 'max'=>64),
			array('size', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('file_id, parent_file_id, type, parent_type, parent_id, user_id, create_time, mofify_time, storage_path, extension, name, mime_type, size', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'file_id' => 'File',
			'parent_file_id' => 'Parent File',
			'type' => 'Type',
			'parent_type' => 'Parent Type',
			'parent_id' => 'Parent',
			'user_id' => 'User',
			'create_time' => 'Creation Date',
			'modify_time' => 'Modified Date',
			'storage_path' => 'Storage Path',
			'extension' => 'Extension',
			'name' => 'Name',
			'mime_type' => 'Mime Type',
			'size' => 'Size',
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

		$criteria->compare('file_id',$this->file_id,true);
		$criteria->compare('parent_file_id',$this->parent_file_id,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('parent_type',$this->parent_type,true);
		$criteria->compare('parent_id',$this->parent_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('modify_time',$this->modify_time,true);
		$criteria->compare('storage_path',$this->storage_path,true);
		$criteria->compare('extension',$this->extension,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('mime_type',$this->mime_type,true);
		$criteria->compare('size',$this->size,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getUrl(){
		return Yii::app()->getBaseUrl().'/'.$this->storage_path;
	}
}