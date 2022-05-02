<?php
session_start();
include('in_cla/class.Database.php');
include('in_cla/class.query.php');
include('in_cla/class.users.php');
users::addNewAddress();
?>