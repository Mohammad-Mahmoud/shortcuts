<?php
class slides {
	public static function addSlide() {
		
		$image = new image;
		$image->setImageName();
		
		$db = new Database();
		$mysqli = $db->getConnection();
		
		$query = new query();
		
		$ar = array();
		
		while($row = $query->langs->fetch_assoc()) {
			array_push($ar,$_POST['slides_desc_'.$row['code']]);
			array_push($ar,$_POST['slides_name_'.$row['code']]);
			array_push($ar,$_POST['slides_link_desc_'.$row['code']]);
		}
			
		$z = implode("','"  , $ar);
		$z = str_pad($z,strlen($z)+1,"'",STR_PAD_LEFT);
		$z = $z."'";
		
		$q = "insert into slides values('slides_id','$image->imgUrl','$_POST[link]',".$z.")";
					
		$image->uploadPic('../../../img/',$q);
	}
	
	public static function changeSlideImage() {
		
		$image = new image;
		$image->setImageName();
		
		$q = "update slides set img_url ='$image->imgUrl' where slides_id = '$_GET[i]'";
					
		$image->uploadPic('../../../img/',$q);
		
	}
	
	public static function updateSlide() {
		
		while(list($name,$value) = each($_POST)) {
			query::update("update slides set $name = '$value' where slides_id = '$_GET[i]'");
		}
		
	}
	
	public static function deleteSlide() {
		$query = new query();
		$slide = $query->fetchAssoc("select img_url from slides where slides_id = '$_GET[i]'");
		$url = $slide->fetch_assoc();
		$url = '../../../img/'.$url;
		unlink($url);
		query::delete('slides','slides_id','=',$_GET[i],"");
		admin::redirect('home.php?art=slides');
	}

}
?>