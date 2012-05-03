<?php
/**
 * This is the model class for table "{{STORAGE}}"
 */
class Storage extends ECassandraCF
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
		return '{{STORAGE}}'; // case sensitive
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
			'storage_path' => 'Path',
			'mime_type' => 'Type',
			'title' => 'Title',
			'description' => 'Description',
			'user_id' => 'User ID',
			'extension' => 'Extension'
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
	 * Processes the uploaded file.
	 * @param CUploadedFile $uploadedFile The uploaded file
	 * @param string $title The title of this file (optional)
	 * @param string $description The description of this file (optional)
	 * @param string $albumName The name of the album, used for images (optional)
	 * @return string The ID of new uploaded file | false
	 */
	public function save($uploadedFile, $title = '', $description = '', $ablumName = '')
	{
		switch ($uploadedFile->getType())
		{
			case 'image/jpeg':
			case 'image/png':
			case 'image/gif':
				return $this->saveImg($uploadedFile, $title, $description);
				break;
			default:
				return false;
		}
	}
	
	/**
	 * Processes the uploaded image.
	 * @param CUploadedFile $uploadedImg The uploaded image
	 * @param string $title The title (or caption) of this image (optional)
	 * @param string $description The detailed description of this image (optional)
	 * @param string $albumName The name of the album to put the image in (optional)
	 * @return string The ID of new uploaded image | false
	 */
	private function saveImg($uploadedImg, $title = '', $description = '', $albumName = '')
	{
		// Key
		$key = Yii::app()->user->getId() . '_' . CassandraUtil::uuid1();
		
		// Path
		$path = Yii::app()->params['storagePath'] . DIRECTORY_SEPARATOR . Yii::app()->user->getId();
		if(!is_dir($path))
			mkdir($path, 0775);
		if (!empty($albumName))
			$path .= DIRECTORY_SEPARATOR . $albumName;
		if(!is_dir($path))
			mkdir($path, 0775);
		
		// Save the image information before processing the image
		$data = array(
			'storage_path' => $uploadedImg->getTempName(), // temporarily store the path of the temporary image
			'mime_type' => $uploadedImg->getType(),
			'extension' => $uploadedImg->getExtensionName(),
			'user_id' => Yii::app()->user->getId()
		);
		if (!empty($title))
			$data['title'] = $title;
		if (!empty($description))
			$data['description'] = $description;
		if ($this->insert($key, $data) === false)
		{
			$uploadedImg->clean();
			return false;
		}
		
		// Render this image into different versions
		$photoTypes = Setting::model()->photo_types;
		// Get list of image types in JSON format. Decode it.
		$photoTypes = json_decode($photoTypes);
		$img = Yii::app()->imagemod->load($data['storage_path']);
		$convertedImgs = array();
		foreach ($photoTypes as $type => $config)
		{
			$img->image_convert = 'jpg';
			$img->image_resize = true;
			$img->image_ratio = true;
			$img->image_x = $config['width'];
			$img->image_y = $config['height'];
			if (isset($config['suffix']))
				 $img->file_safe_name = $key . $config['suffix'] . '.jpg';
			else
				$img->file_safe_name = $key . '.jpg';
			$img->process($path);
			if (!$img->processed)
			{
				// Delete the original image
				$uploadedImg->clean();
				// Delete the record in db
				$this->delete($key);
				// Log the error
				Yii::log('Cannot resize the image ' . $data['storage_path'] . ' to ' . $path . '/' . $img->file_safe_name, 'error', 'application.modules.storage.Storage');
				// Delete all converted images
				foreach ($convertedImgs as $imgType => $imgPath)
					unlink($imgPath);
				// Return false
				return false;
			}
			else
				// Remember the path of converted image
				$convertedImgs[$type] = $img->file_dst_path;
			// Update the database
			$data = array(
				'storage_path' => $convertedImgs['original'],
				'mime_type' => 'image/jpeg',
				'extension' => 'jpg',
			);
			unset($convertedImgs['original']);
			$data = array_merge($data, $convertedImgs);
			if ($this->insert($key, $data) === false)
			{
				// Delete the original image
				$uploadedImg->clean();
				// Delete the record in db
				$this->delete($key);
				// Log the error
				Yii::log('Cannot resize the image ' . $data['storage_path'] . ' to ' . $path . '/' . $img->file_safe_name, 'error', 'application.modules.storage.Storage');
				// Delete all converted images
				unlink($data['storage_path']);
				foreach ($convertedImgs as $imgType => $imgPath)
					unlink($imgPath);
				// Return false
				return false;
			}
		}
		
		// Delete the temporary image
		$uploadedImg->clean();
		return $key;
	}
}
