<?php
$query = new query();
$product = $query->fetchAssoc("select * from product where product_id = '$_GET[i]'");
$sproduct = $product->fetch_assoc();
$url = $sproduct['product_pic'];
$url = '../../../img/'.$url;
unlink($url);
product::deleteProduct();
admin::redirect("home.php?art=products_b");
?>