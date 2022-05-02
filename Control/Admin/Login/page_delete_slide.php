<?php
$query = new query();
$img = $query->fetchAssoc("select img_url from slides where slides_id = '$_GET[i]'");
$img_url = $img->fetch_assoc();
$url = $img_url['img_url'];
$url = '../../../img/'.$url;
unlink($url);
slides::deleteSlide();
admin::showMessage("slide deleted succesfully");
admin::timer("home.php?art=slides");
?>