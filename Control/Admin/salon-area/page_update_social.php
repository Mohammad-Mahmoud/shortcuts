<?php
query::update("update salon_social set link = '$_POST[link]' where salon_social_id = '$_GET[i]'");
admin::showMessage("Social updated succesfully");
admin::timer("home.php?art=social");
?>