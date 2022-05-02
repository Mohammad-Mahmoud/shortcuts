<?php
session_start();
//error_reporting(E_ERROR | E_PARSE);

include('in_cla/class.Database.php');
include('in_cla/class.query.php');
include('in_cla/class.lang.php');
include('in_cla/funcs.php');
include("in_cla/class.users.php");

if(isset($_GET['lang'])) {
	setUserlang($_GET['lang']);
	header('Location: index.php');
}

if($_GET['t'] == 'user'){
    $table = 'user_cart';
    $id = 'user_cart_id';
} else {
    $table = 'temp_cart';
    $id = 'temp_cart_id';
}

query::update("delete from $table where $id = '$_GET[i]' ");
query::update("delete from booked_hours where cart_id = '$_GET[i]' and cart_type = '$_GET[t]'");


header('Location: book.php?b='.$_GET['b']);