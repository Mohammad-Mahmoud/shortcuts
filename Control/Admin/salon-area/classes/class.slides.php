<?php
class slides {
	public static function addSlide() {
		
		$image = new image;
		$image->setImageName();

		$salon_id = admin::getSalonData('salon_id');
		
		$q = "INSERT into slides values('slides_id','$salon_id','$_POST[name]','$image->imgUrl')";
					
		$image->uploadPic('../../../img/',$q);
	}
	
	public static function changeSlideImage() {
		
		$image = new image;
		$image->setImageName();
		
		$q = "update slides set url ='$image->imgUrl' where slide_id = '$_GET[i]'";
					
		$image->uploadPic('img/',$q);
		
	}
	
	public static function updateSlide() {
		
		while(list($name,$value) = each($_POST)) {
			query::update("update slides set $name = '$value' where slide_id = '$_GET[i]'");
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