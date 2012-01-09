<?php
class Country {
	public static  $COUNTRY_LIST = array('1'=>"Mỹ",'2'=>'Anh','3'=>'Thái Lan','4'=>'Singapor','5'=>'Trung Quốc','6' =>'Úc');
	
	public static function getCountryList(){
		return Country::$COUNTRY_LIST;	
	}
	
	public static function getCountryName($id){
		return Country::$COUNTRY_LIST[$id];
	}
}
?>