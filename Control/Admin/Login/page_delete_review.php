<?php
query::update("delete from reviews where review_id='$_GET[i]'");
query::update("delete from reports where report_id='$_GET[r]'");
admin::showMessage("Review deleted succesfully");
admin::timer("home.php?art=reports");
?>