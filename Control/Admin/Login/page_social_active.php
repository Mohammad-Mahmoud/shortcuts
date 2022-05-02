<?php
contact::changeSocialActivity($_GET['active']);
admin::showMessage("Social updated succesfully");
admin::timer("home.php?art=social");
?>