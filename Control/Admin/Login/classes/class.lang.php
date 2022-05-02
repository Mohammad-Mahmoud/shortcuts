<?php
class lang {
	
	static $nameLangArray = array('keyword');
	
	static $descLangArray = array('contact');
	
	
	public static function addLang() {
		
		$db = new Database();
		$mysqli = $db->getConnection();
		
		$query = new query;
		$langs = $query->fetchAssoc("select code from lang");
		
		while($row = $langs->fetch_assoc()) {
			if($_POST['code'] == $row['code']) {
				admin::showError("Language already exist !");
				exit();
			}
		}
		
		foreach (self::$descLangArray as $val) {
			
			$colName = $val.'_desc_'.$_POST['code'];
			
			$q1 = "ALTER TABLE  `$val` ADD  `$colName` TEXT NOT NULL";
			
			$alter1 = $mysqli->query($q1);

			if(!$alter1) { die($mysqli->error); }
			
		}
		
		foreach (self::$nameLangArray as $val) {
			
			$colName = $val.'_name_'.$_POST['code'];
			
			$q = "ALTER TABLE  `$val` ADD  `$colName` VARCHAR( 255 ) NOT NULL";
			
			$alter = $mysqli->query($q);

			if(!$alter) { die($mysqli->error); }
			
		}
		
		//$colName = 'slides_link_desc_'.$_POST['code'];
		//$q2 = "ALTER TABLE  `slides` ADD  `$colName` TEXT NOT NULL";
		
		//$alter2 = $mysqli->query($q2);

		//if(!$alter2) { die($mysqli->error); }
		
		
		
		
		query::update("insert into lang values(lang_id,'$_POST[lang_name]',0,'$_POST[code]')");
		
		admin::showMessage('Language added successfully');
		
		
		
		
			
	}
	
	
	public static function deleteLang() {
		
		$db = new Database();
		$mysqli = $db->getConnection();
		
		$query = new query();
		
		$lang_code = $query->fetchAssoc('select code from lang where lang_id ='.$_GET['i']);
		
		$row = $lang_code->fetch_assoc();
		
		if($_GET['i'] == 1) {
			admin::showError("Cannot delete primary language");
			exit();
		}
				
		foreach (self::$nameLangArray as $val) {
			
			$col = $val.'_name_'.$row['code'];
			
			$q = "ALTER TABLE  `$val` DROP  `$col`";
			
			$alter = $mysqli->query($q);

			if(!$alter) { die($mysqli->error); }
			
		}
		
		
		foreach (self::$descLangArray as $val) {
			
			$col = $val.'_desc_'.$row['code'];
			
			$q1 = "ALTER TABLE  `$val` DROP  `$col`";
			
			$alter1 = $mysqli->query($q1);

			if(!$alter1) { die($mysqli->error); }
			
		}
		
		$col = 'slides_link_desc_'.$row['code'];
		
		$q2 = "ALTER TABLE  `slides` DROP  `$col`";
		
		$alter2 = $mysqli->query($q2);

		if(!$alter2) { die($mysqli->error); }
		
		query::delete('lang','lang_id','=',$_GET[i],"");
		admin::showMessage("Language deleted Successfully");
		
				
	}
	
	

	public function getLangRow($row) {
		
		$query = new query();
		
		$rows = $query->fetchAssoc("select * from lang where lang_id='$_GET[i]'");
		
		$data = $rows->fetch_assoc();
		
		$lang_row = $data[$row];
		
		return $lang_row;
	}
	
	static function updateLang() {
		
		query::update("update lang set lang_name = '$_POST[name]' where lang_id = '$_GET[i]'");
		
		query::update("update lang set code = '$_POST[code]' where lang_id = '$_GET[i]'");
	}


}
?>