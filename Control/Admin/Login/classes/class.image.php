<?php
class image {
	
	public $imgUrl;
	
	public $heigh;
	
	public $width;
	
		
	public function setImageName() {
		
		$name = $_FILES['Filedata']['name'];
		
		$ext = strtolower(substr($name,-3));
		
		$rand_name = rand(1023444,12039393);
		
		$file_name = md5($rand_name).'.'.$ext;
		
		$this->imgUrl = $file_name;
	} 
	
	
	
	public function uploadPic($uploadDir,$q) {
		
		$uploadfile = $uploadDir . $this->imgUrl;
		
		
		if (move_uploaded_file($_FILES['Filedata']['tmp_name'], $uploadfile)) {
			if(!empty($q)) {
				$db = new Database();
				$mysqli = $db->getConnection();
			
				$result = $mysqli->query($q);
				if(!$result) {
					echo $mysqli->error;
				}
			}
			
		} else {
		
			echo "Error: image didn't upload, try again";
	
		}
		
	}
	static function createThumb($img,$path) {
		$image = imagecreatefromjpeg($img);
		$filename = $path;
		$thumb_width = 400;
		$thumb_height = 400;
		$width = imagesx($image);
		$height = imagesy($image);
		$original_aspect = $width / $height;
		$thumb_aspect = $thumb_width / $thumb_height;
		if ( $original_aspect >= $thumb_aspect )
		{
   
   			$new_height = $thumb_height;
   			$new_width = $width / ($height / $thumb_height);
		}
		else
		{
   			$new_width = $thumb_width;
   			$new_height = $height / ($width / $thumb_width);
		}
		$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
		imagecopyresampled($thumb,
                   $image,
                   0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
                   0 - ($new_height - $thumb_height) / 2, // Center the image vertically
                   0, 0,
                   $new_width, $new_height,
                   $width, $height);
		imagejpeg($thumb, $filename, 80);
	}

}