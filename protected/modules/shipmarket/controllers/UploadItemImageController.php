<?php
Yii::import("ext.xupload.models.XUploadForm");
class UploadItemImageController extends Controller{
	
    public function actionUpload(){
    	// path to store images
    	$relativePath = "public/shipmarketitem/images";
    	$path = Yii::app()->getBasePath();
    	$path = str_replace("protected", "", $path); 
    	$path = $path.$relativePath;
    	$realpath = realpath($path);
    	if(!is_dir($realpath)){
			throw new CHttpException(500, "{$this->path} does not exists.");
		}else if(!is_writable($realpath)){
			throw new CHttpException(500, "{$this->path} is not writable.");
		}
		
		//get subfolder
    	$subfolder = Yii::app()->request->getQuery('parent_id', date("mdY"));
    	
    	$model = new ItemImageForm();
		$model->file = CUploadedFile::getInstance($model, 'file');
		$model->mime_type = $model->file->getType();
		$model->size = $model->file->getSize();
		$model->name = $model->file->getName();

		if ($model->validate()) {
			$realpath = $realpath."/".$subfolder."/";
			$relativePath = $relativePath."/".$subfolder."/";
			if(!is_dir($realpath)){
				mkdir($realpath);
			}
			// save file to folder
			$model->file->saveAs($realpath.$model->name);
			
			// store file info to database
			$file_info = new Storage_File;
			$now = time();
			$file_info->attributes = array(
				'parent_type'=>'shipmarketitem',
				'parent_id' => $subfolder,
				'user_id'=> Yii::app()->user->id,
				'create_time'=>$now,
				'modify_time'=>$now,
				'name'=> $model->name,
				'storage_path'=> $relativePath.$model->name,
				'extension'=>$model->file->getExtensionName(),
				'mime_type'=>$model->file->getType(),
				'size'=>$model->file->getSize(),
			);
			$file_info->save();
			
			// generateb thum
			
			
			$img = Yii::app()->imagemod->load($realpath.$model->name);
			$img->image_resize          = true;
			$img->image_ratio_y         = true;
			$img->image_x               = 100;
			$img->file_new_name_body = $img->file_src_name.'_thumb';
			$img->process($realpath);
			if ($img->processed) {
			    //$img->clean();
			} else {
			    echo 'error : ' . $img->error;
			}
			
			//storage file info to database
			$thumb_file_info = new Storage_File();
			$thumb_file_info->attributes = array(
				'parent_type'=>'shipmarketitem',
				'parent_id' => $subfolder,
				'parent_file_id'=>$file_info->file_id,
				'type'=>'thumb',
				'user_id'=> Yii::app()->user->id,
				'create_time'=>$now,
				'modify_time'=>$now,
				'name'=> $model->name,
				'storage_path'=> $relativePath.$img->file_dst_name,
				'extension'=>$model->file->getExtensionName(),
				'mime_type'=>$model->file->getType(),
				'size'=>$model->file->getSize(),
			);
			$thumb_file_info->save();
			
			echo json_encode(array("name" => $model->name,"type" => $model->mime_type,"size"=> $model->getReadableFileSize(),'url'=>$file_info->getUrl(),'file_id'=>$file_info->file_id));
		} else {
			echo CVarDumper::dumpAsString($model->getErrors());
			Yii::log("UploadAction: ".CVarDumper::dumpAsString($model->getErrors()), CLogger::LEVEL_ERROR, "application.modules.shipmarket.UploadItemImageController");
			throw new CHttpException(500, "Could not upload file");
		}
    }
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{		
		
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$model = new ItemImageForm;
		$this->render('index', array(
			'model' => $model,
		));
	}

	/**
	 * Single queued file upload
	 */
	public function actionQueue(){
		$model = new ItemImageForm;
		$this->render('queue', array(
			'model' => $model,
		));
	}

	/**
	 * Single queued file upload
	 */
	public function actionMultiple(){
		$model = new ItemImageForm;
		$this->render('multiple', array(
			'model' => $model,
		));
	}
	
		/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}
	
	
}
