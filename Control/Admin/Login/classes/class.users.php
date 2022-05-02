<?php
class users {
	
	static function addUser(){
		
		$db = new Database();
		$mysqli = $db->getConnection();
		
		$query = new query;
		$users = $query->fetchAssoc("select email from users");
		
		while($row = $users->fetch_assoc()) {
			if($_POST['email'] == $row['email']) {
				admin::showError("User already exist !");
				exit();
			}
		}
		
		$date = $_POST['birthday'];
		$pass = md5($_POST['password']);
		
		query::update("insert into users values(user_id,'$_POST[first_name]','$_POST[last_name]','$_POST[phone]','$_POST[email]','$pass','$date','',curdate())");
		
		//admin::showMessage('User added successfully');
		
	}
	static function updateUser() {

		while(list($name,$value) = each($_POST)) {
			query::update("update users set $name = '$value' where user_id = '$_GET[i]'");
		}
		
	}
	static function deleteUser() {
		
	}
	
}