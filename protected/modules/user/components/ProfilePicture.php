<?php
class ProfilePicture
{
	/**
	 * Gets the profile picture for a specifc user.
	 * @param string $userId The Id of the user to get profile picture. If this is empty, the current user's avatar will be returned.
	 * @param string $type The type of picture to return (original, thumb.profile, thumb.feed, thumb.icon)
	 * @return array The picture info (path, alt, title, width, height)
	 */
	public static function getPictureInfo($userId = '', $type = 'orginal')
	{
		if (empty($userId))
		{
			$userId = Yii::app()->user->getId();
			if (empty($userId))
				return null;
		}
		$pictureId = Profile::model()->getFieldInfo($userId, User::PREFIX, 'picture');
		if ($pictureId === null)
			return self::getDefaultPicture($userId, $type);
		$pictureInfo = Storage::model()->get($pictureId);
		// Alt and title
		$info = array(
			'alt' => $pictureInfo['title'] . ' - ' . $pictureInfo['description'],
			'title' => $pictureInfo['title']
		);
		// Path
		if ($type === 'original')
			$info['path'] = $pictureInfo['storage_path'];
		else
		{
			if (isset($pictureInfo[$type]))
				$info['path'] = $pictureInfo[$type];
			else
			{
				$info['path'] = Yii::app()->getBaseUrl(true) . '/files/images/error.jpg';
				$info['width'] = $info['height'] = 160;
			}
		}
		// Size
		if (!isset($info['width']))
		{
			$imageInfo = getimagesize($info['path']);
			$info['width'] = $imageInfo[0];
			$info['height'] = $imageInfo[1];
		}
		return $info;
	}
	
	/**
	 * Gets the default profile picture for a specifc user.
	 * @param string $userId The Id of the user to get profile picture. If this is empty, the current user's avatar will be returned.
	 * @param string $type The type of picture to return (original, thumb.profile, thumb.feed, thumb.icon)
	 * @return array The picture info (path, alt, title, width, height)
	 */
	public static function getDefaultPicture($userId = '', $type = 'original')
	{
		if (empty($userId))
		{
			$userId = Yii::app()->user->getId();
			if (empty($userId))
				return null;
		}
		// Detect user's gender to decide which avatar should be chosen
		$gender = Profile::model()->getFieldInfo($userId, User::PREFIX, 'gender');
		if ($gender['value'] === 'male')
			$info['path'] = Yii::app()->getBaseUrl(true) . '/files/images/default-avatar-male.jpg';
		else
			$info['path'] = Yii::app()->getBaseUrl(true) . '/files/images/default-avatar-female.jpg';
		// Alt and title
		$info['alt'] = $info['title'] = UserModule::t('Default Avatar');
		// Get size
		//Yii::app()->getModule('system'); // Get module 'system'
		$photoTypes = Setting::model()->get('photo_types', array('value'));
		/*var_dump($photoTypes->value);
		var_dump($photoTypes['value']); die;*/
		$photoTypes = json_decode($photoTypes['value'], true); // true indicates that the object will be converted to associative arrays
		if (!isset($photoTypes[$type]))
		{
			$info['width'] = 160;
			$info['height'] = 160;
		}
		else
		{
			$info['width'] = $photoTypes[$type]['width'];
			$info['height'] = $photoTypes[$type]['height'];
		}
		return $info;
	}
}
