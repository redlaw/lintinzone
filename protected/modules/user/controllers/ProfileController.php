<?php

class ProfileController extends Controller
{
	public function actionIndex()
	{
		if (Yii::app()->user->isGuest)
			$this->redirect($this->createUrl('/'));
		$profile = Profile::getProfileInfo(Yii::app()->user->getId(), 'user_');
		$this->render('index', array('profile' => $profile));
	}
	
	public function actionUpdate()
	{
		$formModel = new ProfileForm();
		if (isset($_POST['ProfileForm']))
		{
			$allFieldTypes = $formModel->getAllFieldTypes();
			foreach ($allFieldTypes as $fieldName => $fieldType)
			{
				$formModel->$fieldName = $_POST['ProfileForm'][$fieldName];
			}
			if ($formModel->validate())
			{
				$model = new Profile();
				$data = array();
				foreach ($allFieldTypes as $fieldName => $fieldType)
				{
					$data[$fieldName] = array(
						'value' => $formModel->$fieldName
					);
				}
				$model->setProfileFields(CassandraUtil::import(Yii::app()->user->getId())->__toString(), User::PREFIX, $data);
			}
		}
		$this->render('update', array('model' => $formModel));
	}
	
	public function actionPicture()
	{
		$formModel = new PictureForm();
		$img = ProfilePicture::getPictureInfo('', 'thumb.profile');
		$this->render('picture', array(
			'model' => $formModel,
			'img' => $img
		));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}