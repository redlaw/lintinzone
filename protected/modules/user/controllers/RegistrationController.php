<?php

class RegistrationController extends Controller
{
	public $defaultAction = 'register';
	
	public function actionRegister()
	{
		$model = new Registration();

		//$this->performAjaxValidation($model);
		if(isset($_POST['Registration']))
		{
			$model->email = $_POST['Registration']['email'];
			$model->username = $_POST['Registration']['username'];
			$model->password = $_POST['Registration']['password'];
			$model->password_repeat = $_POST['Registration']['password_repeat'];
			$model->verification_code = $_POST['Registration']['verification_code'];
			if ($model->validate())
			{
				//Yii::trace('password ' . $_POST['Registration']['password'], 'system.web.CController');
				if ($model->insert(CassandraUtil::uuid1(), array(
						'email' => $_POST['Registration']['email'],
						'username' => $_POST['Registration']['username'],
						'password' => User::encryptPassword($_POST['Registration']['password']),
						'active' => false,
						'blocked' => false
					)) === true)
				{
					
					/*if (!User::sendRegisterVerification($model->email, $model->username))
						Yii::app()->user->setFlash('registration', UserModule::t('We experienced some problems to send you a verification account. Make sure that your email address is valid! If it is, an email will be sent again soon.'));
					else
						Yii::app()->user->setFlash('registration', UserModule::t('Thank you for your registration! Please check your mail inbox.'));*/
					$this->redirect(array('user/profile'));
				}
			}
		}

		$this->render('register',array(
			'model' => $model,
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
}
