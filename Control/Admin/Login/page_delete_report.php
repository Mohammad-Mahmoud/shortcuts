<?php
query::update("delete from reports where report_id='$_GET[i]'");
admin::showMessage("Report deleted succesfully");
admin::timer("home.php?art=reports");
?>