<?php
class keyword {
	
	public static function addKeyword() {
		
		$db = new Database();
		$mysqli = $db->getConnection();
			
		$z = implode("','"  , $_POST);
		
		$z = str_pad($z,strlen($z)+1,"'",STR_PAD_LEFT);
		
		$z = $z."'";
		
		$q = "insert into keyword values(keyword_id,".$z.")";
		
		$result = $mysqli->query($q);
		
		if(!$result) {
			echo $mysqli->error;
		}			
		
	}
	
	public static function updateKeyword() {
		
		while(list($name,$value) = each($_POST)) {
			query::update("update keyword set $name = '$value' where keyword_id = '$_GET[i]'");
		}
		admin::showMessage("Keyword updated succefully");
	}
	
	public static function deleteKeyword() {
		query::delete('keyword','keyword_id','=',$_GET[i],"");
		admin::redirect('home.php?art=keywords');
	}
}