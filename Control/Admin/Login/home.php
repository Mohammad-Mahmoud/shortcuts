<?php

session_start();

error_reporting(E_ERROR | E_PARSE);


require('classes/class.Database.php');

require('classes/class.query.php');

require('classes/class.admin.php');
require('classes/class.lang.php');
require('classes/class.keyword.php');
require('classes/class.image.php');
require('classes/class.slides.php');
require('classes/class.contact.php');
require('classes/class.product.php');
require('classes/class.users.php');




admin::checkSession('username');


?>
