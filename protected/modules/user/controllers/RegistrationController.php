<?php

class RegistrationController extends Controller
{
	public $defaultAction = 'register';
	
	public function actionRegister()
	{
		$model = new Registration();

		// $this->performAjaxValidation($model);
		if(isset($_POST['Registration']))
		{
			//$model->attributes = $_POST['Registration'];
			// Set attributes
			/*$model->username = $_POST['Registration']['username'];
			$model->email = $_POST['Registration']['email'];
			$model->password = $_POST['Registration']['password'];
			$model->password_repeat = $_POST['Registration']['password_repeat'];
			$model->verification_code = $_POST['Registration']['verification_code'];*/
			//if ($model->save())
			if ($model->insert(CassandraUtil::uuid1(), array(
					'email' => $_POST['Registration']['email'],
					'username' => $_POST['Registration']['username'],
					'password' => User::encryptPassword($_POST['Registration']['password']),
					'password_repeat' => User::encryptPassword($_POST['Registration']['password_repeat']),
					'verification_code' => $_POST['Registration']['verification_code'],
					'active' => 0,
					'blocked' => 0
				)))
			{
				//Yii::log('user created', 'warning', 'system.web.CController');
				if (!User::sendRegisterVerification($model->email, $model->username))
					Yii::app()->user->setFlash('registration', UserModule::t('We experienced some problems to send you a verification account. Make sure that your email address is valid! If it is, an email will be sent again soon.'));
					//Yii::log('failed to send mail', 'warning', 'system.web.CController');
				else
					Yii::app()->user->setFlash('registration', UserModule::t('Thank you for your registration! Please check your mail inbox.'));
					//Yii::log('send successfully', 'warning', 'system.web.CController');
				$this->redirect(array('index'));
				//$this->refresh();
			}
		}

		$this->render('register',array(
			'model' => $model,
		));
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
}
