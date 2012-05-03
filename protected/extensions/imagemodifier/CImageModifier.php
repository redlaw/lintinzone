<?php
/**
 * @author Egor Saveiko aka GOsha
 * @license GPL
 * @version 1.0
 */

class CImageModifier extends CApplicationComponent
{
    /**
     * Language name in 'en_EN' format
     * @var string
     */
    private $_language;

    /**
     * init function
     */
    public function init()
    {
        parent::init();
        if(empty($this->_language))
            $this->setLanguage(Yii::app()->language);
        
        $dir = dirname(__FILE__);
        $alias = md5($dir);
        Yii::setPathOfAlias($alias,$dir);
        Yii::import($alias.'.upload');
    }

    /**
     * Language set function
     * @param string $lang
     */
    public function setLanguage($lang)
    {
        $this->_language = $lang;
    }

    /**
     * Main extension loader
     * @param (string||$_FILE) $image
     * @return upload
     */
    public function load($image)
    {
        return new upload($image, $this->_language);
    }
 

}



?>