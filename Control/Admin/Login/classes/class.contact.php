<?php
class contact {
	
	public static function updateContact() {
		while(list($name,$value) = each($_POST)) {
			query::update("update contact set $name = '$value' where contact_id = '$_GET[i]'");
		}
	}
	
	public static function addSocial() {
		
		$image = new image;
		$image->setImageName();
		
		$q = "insert into social values('social_id','$_POST[name]','$image->imgUrl','$_POST[link]')";
					
		$image->uploadPic('../img/',$q);
	}
	
	public static function changeIcon() {
		
		$image = new image;
		$image->setImageName();
		
		$q = "update social set icon ='$image->imgUrl' where social_id = '$_GET[i]'";
					
		$image->uploadPic('../img/',$q);
		
	}
	
	public static function updateSocial() {
		
		while(list($name,$value) = each($_POST)) {
			query::update("update social set $name = '$value' where social_id = '$_GET[i]'");
		}
	}

	public static function changeSocialActivity($status) {
		
		query::update("update social set active = '$status' where social_id = '$_GET[i]'");
	}
	
	public static function deleteSocial() {
		query::delete('social','social_id','=',$_GET[i],"");
	}
}