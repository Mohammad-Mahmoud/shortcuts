<?php
admin::changeSocialActivity($_GET['active']);
//admin::showMessage("Social updated succesfully");
admin::redirect("home.php?art=social");
?>