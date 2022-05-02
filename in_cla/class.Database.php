<?php
class Database {
	
	private $_connection;
	private static $_instance;
	
	public static function getInstance() {
		if(self::$_instance) {
			self::$_instnce = new self();
		}
		return self::$_instance;
	}
	
	public function __construct() {
		
		$this->_connection=new mysqli ('localhost','root','','shortcuts');
		
		if(mysqli_connect_error()) {
			trigger_error('Failed to connect to database: '. mysqli_connect_error(),E_USER_E_ALL);
		}
	}
	
	private function __clone() {}
	
	public function getConnection() {
		return $this->_connection;
	}
}

$db = new Database();
$mysqli = $db->getConnection();
		
foreach ($_POST as $key => $val) {
			
	$_POST[$key] = $mysqli->real_escape_string($_POST[$key]);
}

foreach ($_GET as $key => $val) {
			
	$_GET[$key] = $mysqli->real_escape_string($_GET[$key]);
}



?>