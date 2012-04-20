<?php

class RegistrationController extends Controller
{
	public $layout='//layouts/noNavigation';
		
	public $defaultAction = 'register';
	
	public function actionRegister()
	{
		$formModel = new Registration();

		//$this->performAjaxValidation($formModel);
		if(isset($_POST['Registration']))
		{
			$formModel->email = $_POST['Registration']['email'];
			$formModel->username = $_POST['Registration']['username'];
			$formModel->password = $_POST['Registration']['password'];
			$formModel->password_repeat = $_POST['Registration']['password_repeat'];
			$formModel->verification_code = $_POST['Registration']['verification_code'];
			if ($formModel->validate())
			{
				$model = new User();
				//Yii::trace('password ' . $_POST['Registration']['password'], 'system.web.CController');
				if ($model->insert(CassandraUtil::uuid1(), array(
						'email' => $_POST['Registration']['email'],
						'username' => $_POST['Registration']['username'],
						'password' => User::encryptPassword($_POST['Registration']['password']),
						'active' => false,
						'blocked' => false
					)) === true)
				{
					//Yii::trace('Model email ' . $model->email . ' && username ' . $model->username, 'system.web.CController');
					echo 'Model email ' . $formModel->email . ' && username ' . $formModel->username;
					if (!User::sendRegisterVerification($formModel->email, $formModel->username))
					{
						//Yii::trace('Failed to send mail to ' . $model->email, 'system.web.CController');
						echo 'failed';
						//Yii::app()->user->setFlash('registration', UserModule::t('We experienced some problems to send you a verification account. Make sure that your email address is valid! If it is, an email will be sent again soon.'));
					}
					else
					{
						//Yii::trace('Mail sent successfully to ' . $model->email, 'system.web.CController');
						echo 'done';
						//Yii::app()->user->setFlash('registration', UserModule::t('Thank you for your registration! Please check your mail inbox.'));
					}
					die;
					//$this->redirect(array('user/profile'));
				}
			}
		}

		$this->render('register',array(
			'model' => $formModel,
		));
	}

	protected function performAjaxValidation($model)
	{
	    if(isset($_POST['ajax']) && $_POST['ajax'] === 'registration-form')
	    {
	        echo CActiveForm::validate($model);
	        Yii::app()->end();
	    }
	}

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
	}*/

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'registration-form')
			return array();
		return array(
			'captcha' => array(
				'class' => 'CCaptchaAction',
				'backColor' => 0xFFFFFF,
			),
		);
	}
	
	public function actionConfirm()
	{
		if (!isset($_GET['email']) && !isset($_GET['key']))
			$this->redirect(array('index/index'));
		switch (EmailVerification::model()->confirm($_GET['email'], $_GET['key']))
		{
			case EmailVerification::CONFIRM_ALREADY_ACTIVE:
				echo UserModule::t('This email address has already been verified. Thank you!');
				break;
			case EmailVerification::CONFIRM_INVALID_KEY:
				echo UserModule::t('The confirmation key is invalid!');
				break;
			case EmailVerification::CONFIRM_KEY_NOT_ACTIVE:
				echo UserModule::t('This key is no longer active');
				break;
			case EmailVerification::CONFIRM_USER_BLOCKED:
				echo UserModule::t('This account is currently blocked');
				break;
			case EmailVerification::CONFIRM_SUCCESS:
				echo UserModule::t('This email is now verified. You can log in your account using this email. Thank you!');
				break;
			case EmailVerification::CONFIRM_ERROR:
			default:
				echo UserModule::t('Oops, an error has occurred! Please try again.');
		}
	}
}
