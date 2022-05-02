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

$query = new query();
$q = "select* from barbers_services b, services s where b.service_id = s.service_id and barber_id = '$_GET[b]'";
$services = $query->fetchAssoc($q);

$type = query::returnSingleValue('salon', 'type', 'salon_id = ' . $_GET['i']);

$address = query::returnSingleValue('barbers', 'address', 'barber_id = ' . $_GET['b']);

$radius = query::returnSingleValue('barbers', 'radius', 'barber_id = ' . $_GET['b']);


$service_ar = $query->extractArrayFromQuery('barbers_services', 'type', 'barber_id = ' . $_GET['b']);

setTempCookie('/shortcuts', 'localhost');

if (isset($_SESSION['username'])) {

    $user_id = users::getUserID();

    $user_address = $query->fetchAssoc("select * from user_address where user_id = '$user_id'");

    $address_count = query::numRows("select * from user_address where user_id = '$user_id'");

    $address_ar = $query->extract2DArrayFromQuery("user_address", ['address', 'zip', 'city'], 'user_id = ' . $user_id);
}





?>

<!DOCTYPE HTML>

<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="viewport" content="width=device-width, user-scalable=no" , viewport-fit=cover" />

    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <meta name="apple-mobile-web-app-capable" content="yes">

    <title>Eazy Mobile | HTML, CSS & JS Mobile Template | Epsilon X </title>

    <!-- Don't forget to update PWA version (must be same) in pwa.js & manifest.json -->


    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="styles/style.css">

    <link rel="stylesheet" type="text/css" href="styles/framework.css">


    <link rel="stylesheet" type="text/css" href="fonts/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="styles/store.css">

    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


    <script type="text/javascript" src="scripts/plugins.js"></script>


    <script type="text/javascript" src="scripts/custom.js"></script>
    <script defer src="https://maps.googleapis.com/maps/api/js?libraries=places&language=en&key=AIzaSyDmhyiVkQ3SPYUemjGdP4-5xu-pMDgSvOs" type="text/javascript"></script>
   

</head>



<body class="theme-light" data-highlight="blue2">






    <div id="page">

        <!-- header !-->

        <?php
        include('header.php');

        ?>

        <!-- header end !-->


        <!-- content !-->

        <?php

        include('select_service.php');
        ?>

        <!-- content end !-->






        <div class="menu-hider"></div>

    </div>








</body>