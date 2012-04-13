<?php

class LoginController extends Controller
{
	public function actionIndex()
	{
		$formModel = new Login();
		if (Yii::app()->user->isGuest)
		{
			if (isset($_POST['Login']))
			{
				$formModel->username = $_POST['Login']['username'];
				$formModel->password = $_POST['Login']['password'];
				$formModel->rememberMe = $_POST['Login']['rememberMe'];
				//Yii::log('AAAAAAA prepare to validate', 'warning', 'system.web.CController');
				if ($formModel->validate())
				{
					//Yii::log('form model validated', 'warning', 'system.web.CController');
					//$user = User::model()->findbyPk(Yii::app()->user->getId());
					$user = User::model()->get(Yii::app()->user->getId());
					$user->logSession();
					if (strpos(Yii::app()->user->returnUrl, 'index.php') !== false)
						$this->redirect(Yii::app()->controller->module->returnUrl);
					else
						$this->redirect(Yii::app()->user->returnUrl);
				}
			}
			$formModel->password = '';
			$this->render('login', array('model' => $formModel));
		}
		else
			$this->redirect(Yii::app()->controller->module->returnUrl);
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