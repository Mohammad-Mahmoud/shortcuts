<?php
contact::updateContact();
admin::showMessage("Page content updated succesfully");
admin::timer("home.php?art=contact&i=".$_GET['i']);
?>