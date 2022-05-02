<?php

class lang {
	
	static $userLang;
	
	public function __construct() {
		if($_COOKIE['userLang']) {
			self::$userLang = self::getUserLang();
		} else {
			setcookie("userLang", self::getDefaultLang(), time() + (10 * 365 * 24 * 60 * 60));
			self::$userLang = self::getUserLang();
		}
	}
	
	static function getDefaultLang() {
		$query = new query();
		$default_lang = $query->fetchAssoc("select code from lang where is_default = 1");
		$row = $default_lang->fetch_assoc();
		return $row['code'];
	
	}
	
	static function getUserLang() {
		if($_COOKIE['userLang']) {
			self::$userLang = $_COOKIE['userLang'];
		} else {
			self::$userLang = self::getDefaultLang();
		}
		return self::$userLang;
	}
	
	
	
	static function getKeyword($string) {
		$string = strtolower($string);
		$query = new query();
		$keyword = $query->fetchAssoc("select keyword_name_".self::getUserLang()." from keyword where lower(keyword_name_en) = '$string'");
		$keyword_s = $keyword->fetch_array(MYSQLI_NUM);
		return $keyword_s[0];
	}
				
	
	
}

$lang = new lang();


?>