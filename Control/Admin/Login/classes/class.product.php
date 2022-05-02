<?php
class product {

	public static function addProduct() {
		
		
		$image = new image;
		$image->setImageName();
		
		$db = new Database();
		$mysqli = $db->getConnection();
		
		
		$query = new query();	
		
		$ar = array();
		
		while($row = $query->langs->fetch_assoc()) {
			array_push($ar,$_POST['product_desc_'.$row['code']]);
			array_push($ar,$_POST['product_name_'.$row['code']]);
		}
		$z = implode("','"  , $ar);
		$z = str_pad($z,strlen($z)+1,"'",STR_PAD_LEFT);
		$z = $z."'";
	
		$sn = query::generateSN();
		
		$current_sn = $query->fetchAssoc("select sn from serials");
		
		while($row = $current_sn->fetch_assoc()) {
			
			if($row['sn'] == $sn) {
				$sn = query::generateSN();
				break;
			} else {
				$sn = $sn;
			}
		}
		
		$q = "insert into product values('product_id','$image->imgUrl','$_POST[target]','$_POST[price]','$sn',CURDATE(),".$z.")";
					
		$image->uploadPic('../../../img/',$q);
		
		image::createThumb($image->imgUrl,'../../../img/thumb/'.$image->imgUrl);
		
		$q1 = "insert into serials values('serials_id','$sn')";
					
		query::update($q1);
	}
	
	public static function changeProductPic() {
		
		$image = new image;
		$image->setImageName();
		
		$q = "update product set product_pic ='$image->imgUrl' where product_id = '$_GET[i]'";
					
		$image->uploadPic('../../../img/',$q);
		
	}
	
	public static function updateProduct() {
		while(list($name,$value) = each($_POST)) {
			query::update("update product set $name = '$value' where product_id = '$_GET[i]'");
		}
	}
	
	public static function deleteProduct() {
		
		query::delete('product','product_id','=',$_GET[i],"");
		
		
	}
	


}

?>