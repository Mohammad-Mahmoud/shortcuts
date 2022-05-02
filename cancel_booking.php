<?php
session_start();
error_reporting(E_ERROR | E_PARSE);

include('in_cla/class.Database.php');
include('in_cla/class.query.php');
include('in_cla/class.lang.php');
include('in_cla/funcs.php');
include("in_cla/class.users.php");

if(isset($_GET['lang'])) {
    setUserlang($_GET['lang']);
    header('Location: index.php');
}
$user_id = users::getUserID();
$id = $_GET['i'];
$query = new query();
$date = $query::returnSingleValue('actual_booking', 'date', 'actual_booking_id = '.$id);
$hour = $query::returnSingleValue('actual_booking', 'hour', 'actual_booking_id = '.$id);
$barber_id = $query::returnSingleValue('actual_booking', 'barber_id', 'actual_booking_id = '.$id);
if(!isset($_GET['t'])) {
    $s = 'canceled';
    $query::update("update actual_booking set status = 1 where actual_booking_id = " . $id);
    $query::update("delete from barbers_bookings_hours where date = '$date' and start = '$hour' and barber_id = '$barber_id' ");
} else {
    if($_GET['t'] == 'd') {
        $s = 'deleted';
        $query::update("update actual_booking set hidden_user = 1 where actual_booking_id = " . $id);
    }

}


?>

<!DOCTYPE HTML>

<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="viewport" content="width=device-width, user-scalable=no", viewport-fit=cover" />

    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <meta name="apple-mobile-web-app-capable" content="yes">

    <title>Eazy Mobile | HTML, CSS & JS Mobile Template | Epsilon X </title>

    <!-- Don't forget to update PWA version (must be same) in pwa.js & manifest.json -->


    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="styles/style.css">

    <link rel="stylesheet" type="text/css" href="styles/framework.css">

    <link rel="stylesheet" type="text/css" href="fonts/css/fontawesome-all.min.css">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="scripts/plugins.js"></script>

    <script type="text/javascript" src="scripts/custom.js"></script>



</head>



<body class="theme-light" data-highlight="blue2">






<div id="page">

    <!-- header !-->

    <?php
    include('header.php');

    ?>

    <!-- header end !-->


    <!-- content !-->
    <div class="top-100" >

        <div class="content">
            <h1 class="center-text uppercase  top-30">Your booking has been <?=$s?></h1>

        </div>
    </div>


    <!-- content end !-->






    <div class="menu-hider"></div>

</div>









</body>

