<?php

class UserModule extends CWebModule
{
	public $registrationUrl = array("/user/create");
	public $recoveryUrl = array("/user/recovery/recovery");
	public $loginUrl = array("/user/login");
	public $logoutUrl = array("/user/logout");
	public $profileUrl = array("/user/profile");
	public $returnUrl = array("/user/profile");
	public $returnLogoutUrl = array("/user/login");
	
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'user.models.*',
			'user.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	
	public static function isAdmin()
	{
		return false;
	}
	
	/**
	 * Translates a string to specific language.
	 * @param string $string
	 * @param array $params
	 * @param string $dictionary
	 */
	public static function t($string, $params = array(), $dictionary = 'user')
	{
		return Yii::t('UserModule.' . $dictionary, $string, $params);
	}
	
	/**
	 * Returns safe user data.
	 * @param user id not required
	 * @return user object or false
	 */
	public static function user($id = 0)
	{
		// Get the user by id
		if ($id)
			return User::model()->active->findbyPk($id);
		else
		{
			// Return false if user is guest
			if (Yii::ap()->user->isGuest)
				return false;
			else
				return User::model()->active->findbyPk(Yii::app()->user->id);
		}
	}
}
