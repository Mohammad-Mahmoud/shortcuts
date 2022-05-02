<?php
query::update("delete from salon_req where req_id='$_GET[i]'");
admin::showMessage("Request deleted succesfully");
admin::timer("home.php?art=requests");
?>