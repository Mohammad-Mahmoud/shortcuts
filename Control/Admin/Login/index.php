<?php
session_start();

error_reporting(E_ERROR | E_PARSE);


require('classes/class.Database.php');

require('classes/class.admin.php');






admin::indexPage();
?>