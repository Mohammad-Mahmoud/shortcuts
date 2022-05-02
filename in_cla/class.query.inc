<?php

class query {
	
	public $result = array();
	
	public $langs;
	 
	static $num;
	

	
	public static function insert($table,$ar=array()) {
		
		$z = implode("','"  , $ar);
		
		$z = str_pad($z,strlen($z)+1,"'",STR_PAD_LEFT);
		
		$z = $z."'";
		
		$db = new Database();
		$mysqli = $db->getConnection();
		
		$q = "insert into ".$table." values(".$z.")";
		$result = $mysqli->query($q);
		
		if(!$result) {
			echo $mysqli->error;
		}
	
	}
	
	
	public static function delete($table,$field,$op,$val,$ad='') {
		
		$db = new Database();
		$mysqli = $db->getConnection();
		
		$q = "delete from ".$table." where ".$field." ".$op." ".$val." ".$ad;
		$res = $mysqli->query($q);
		
		if(!$res) {
			echo $mysqli->error;
		}	
		
	}
	
	public function fetchAssoc($q) {
		
		$db = new Database();
		$mysqli = $db->getConnection();
		
		$this->result = $mysqli->query($q);
		
		return $this->result;
		
	}
	
	public function __construct() {
		
		$this->langs = $this->fetchAssoc('select * from langs');
		
		
		
	}
	
	public static function update($q) {
		
		$db = new Database();
		$mysqli = $db->getConnection();
			
		$result = $mysqli->query($q);
		
		if(!$result) {
			echo $mysqli->error;
		}	
	}
	
	
	public static function numRows($q) {
		
		$db = new Database();
		$mysqli = $db->getConnection();
		
		$result = $mysqli->query($q);	
		
		if(!$result) {
			echo $mysqli->error;
		} else {
			self::$num = $result->num_rows;
		}
	}
		
	
}


?>