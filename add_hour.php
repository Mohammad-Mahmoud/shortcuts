<?php
session_start();
error_reporting(E_ERROR | E_PARSE);

include('in_cla/class.Database.php');
include('in_cla/class.query.php');
include('in_cla/class.lang.php');
include('in_cla/funcs.php');
include("in_cla/class.users.php");

if (isset($_GET['lang'])) {
    setUserlang($_GET['lang']);
    header('Location: index.php');
}

switch ($_GET['d']) {
    case ($_GET['d'] > 0 && $_GET['d'] <= 30):
        $duration = 30;
        break;
    case ($_GET['d'] > 30 && $_GET['d'] <= 60):
        $duration = 60;
        break;
    case ($_GET['d'] > 60 && $_GET['d'] <= 90):
        $duration = 90;
        break;
    case ($_GET['d'] > 90 && $_GET['d'] <= 120):
        $duration = 120;
        break;
    case ($_GET['d'] > 120 && $_GET['d'] <= 150):
        $duration = 150;
        break;
    case ($_GET['d'] > 150 && $_GET['d'] <= 180):
        $duration = 180;
        break;
    case ($_GET['d'] > 180 && $_GET['d'] <= 210):
        $duration = 210;
        break;
    case ($_GET['d'] > 210 && $_GET['d'] <= 240):
        $duration = 240;
        break;
}

$cart_type = isset($_SESSION['username']) ? 'user' : 'temp';

$user_id = isset($_SESSION['username']) ? users::getUserID() : $_COOKIE['temp_user_id'];

$date = date("Y-m-d", strtotime($_GET['date']));  

$is_booked = query::numRows("select * from booked_hours where cart_id = '$_GET[c]' and cart_type = '$cart_type'");
$time = strtotime($_GET['h']);
$end = date("H:i", strtotime($duration.' minutes', $time));

if($is_booked == 0) {
    
    query::update("insert into booked_hours values (booked_hours_id,'$_GET[c]','$user_id','$cart_type','$_GET[h]','$date','$duration','$end','$_GET[b]')");
} else {
    query::update("update booked_hours set hour = '$_GET[h]' where cart_id = '$_GET[c]' and cart_type = '$cart_type'");
    query::update("update booked_hours set date = '$date' where cart_id = '$_GET[c]' and cart_type = '$cart_type'");
    query::update("update booked_hours set end = '$end' where cart_id = '$_GET[c]' and cart_type = '$cart_type'");

}

header('Location: book.php?b='.$_GET['b']);



