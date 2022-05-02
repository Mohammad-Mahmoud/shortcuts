<?php
query::update("delete from messages where messages_id='$_GET[i]'");
admin::showMessage("Message deleted succesfully");
admin::timer("home.php?art=messages");
?>