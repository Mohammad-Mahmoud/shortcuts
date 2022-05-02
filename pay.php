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
$query = new query;
$t_ar = [];

//delete all records in cart and in the booked hours when date is less than current date
$current_date = date("Y-m-d");
$cart_ids = $query->extractArrayFromQuery("booked_hours", "cart_id", "date < '" . $current_date . "'");
$cart_id_s = implode(', ', $cart_ids);
query::update("delete from booked_hours where date < '$current_date'");
if (count($cart_ids) > 0) {
    query::update("delete from temp_cart where temp_cart_id in (" . $cart_id_s . ")");
    query::update("delete from user_cart where user_cart_id in (" . $cart_id_s . ")");
}


$temp_count = query::numRows("select * from temp_cart where temp_user_id = '$_COOKIE[temp_user_id]'");

$barb_ser_ar = $query->extractArrayFromQuery("barbers_services", 'barb_ser_id', 'barber_id = ' . $_GET['b']);

$temp_ser_ar = $query->extractArrayFromQuery("temp_cart", 'temp_user_id');
$temp_ser_id = $query->extractArrayFromQuery("temp_cart", 'barb_ser_id', 'temp_user_id = "' . $_COOKIE['temp_user_id'] . '"');

if (isset($_SESSION['username'])) {
    $user_id = users::getUserID();
    $user_ser_ar = $query->extractArrayFromQuery("user_cart", 'user_id');
    $user_ser_id = $query->extractArrayFromQuery("user_cart", 'barb_ser_id', 'user_id = ' . $user_id);
}



foreach ($barb_ser_ar as $key => $value) {


    $id =  $_POST['c' . $value];
    $type = $_POST['ser' . $value];

    if (in_array($id, $barb_ser_ar)) {
        array_push($t_ar, $id);
    }


    if ($temp_count > 0) {
        if (in_array($_COOKIE['temp_user_id'], $temp_ser_ar) && in_array($id, $barb_ser_ar)) {
            query::update("update temp_cart set type='$type'
            where barb_ser_id='$id'
            and temp_user_id = '$_COOKIE[temp_user_id]'");

            query::update("update temp_cart set lat='$_GET[lat]'
            where barb_ser_id='$id'
            and temp_user_id = '$_COOKIE[temp_user_id]'");

            query::update("update temp_cart set lng='$_GET[lng]'
            where barb_ser_id='$id'
            and temp_user_id = '$_COOKIE[temp_user_id]'");

            query::update("update temp_cart set address='$_POST[other_address]'
            where barb_ser_id='$id'
            and temp_user_id = '$_COOKIE[temp_user_id]'");

            query::update("update temp_cart set dur='$_POST[dur]'*2
            where barb_ser_id='$id'
            and temp_user_id = '$_COOKIE[temp_user_id]'");
       }
    } else {
        if (in_array($user_id, $user_ser_ar) && in_array($id, $barb_ser_ar)) {
            query::update("update user_cart set type='$type'
            where barb_ser_id='$id'
            and user_id = '$user_id'");

            query::update("update user_cart set lat='$_GET[lat]'
            where barb_ser_id='$id'
            and user_id = '$user_id'");

            query::update("update user_cart set lng='$_GET[lng]'
            where barb_ser_id='$id'
            and user_id = '$user_id'");

            query::update("update user_cart set address='$_POST[selected_address]'
            where barb_ser_id='$id'
            and user_id = '$user_id'");

            query::update("update user_cart set dur='$_POST[dur]'*2
            where barb_ser_id='$id'
            and user_id = '$user_id'");
        }
    }
}
foreach ($t_ar as $val) {
    if ($temp_count > 0) {
        if (!in_array($val, $temp_ser_id)) {

            $type = $_POST['ser' . $val];

            query::update("insert into temp_cart values
        (temp_cart_id,'$val','$_COOKIE[temp_user_id]','$type','$_GET[lat]',
        '$_GET[lng]','$_POST[other_address]','$_POST[dur]'*2,'$_GET[b]')");
        }
    } else {
        if (!in_array($val, $user_ser_id)) {

            $type = $_POST['ser' . $val];

            query::update("insert into user_cart values
        (user_cart_id,'$val','$user_id','$type','$_GET[lat]',
        '$_GET[lng]','$_POST[selected_address]','$_POST[dur]'*2,'$_GET[b]')");
        }
    }
}





// = query::returnSingleValue('barbers', 'salon_id', 'barber_id = ' . $_GET['b']);



if ($temp_count == 0) {
    $cart_count = query::numRows("SELECT * from user_cart where user_id = '$user_id'");

    $q = "SELECT *, u.type as u_type, bs.type as b_type, u.barber_id as barber from user_cart u,
    barbers_services bs, services s, booked_hours h where
    bs.barb_ser_id = u.barb_ser_id and bs.service_id = s.service_id
    and u.user_cart_id = h.cart_id
    and h.cart_type = 'user'
    and u.user_id = '$user_id'";

    $items = $query->fetchAssoc($q);

    $id_ar = $query->extractArrayFromQuery("user_cart u,barbers_services bs, services s", "user_cart_id", "bs.barb_ser_id = u.barb_ser_id and bs.service_id = s.service_id
   and u.user_id =" . $user_id);

    $id_ar_s = implode(",", $id_ar);

    $id = 'user_cart_id';
    $table = 'user';
} else {
    $cart_count = query::numRows("SELECT * from temp_cart where temp_user_id = '$_COOKIE[temp_user_id]'");

    $q = "SELECT *, u.type as u_type, bs.type as b_type, u.barber_id as barber from temp_cart u,
    barbers_services bs, services s, booked_hours h where
    bs.barb_ser_id = u.barb_ser_id and bs.service_id = s.service_id
    and u.temp_cart_id = h.cart_id
    and h.cart_type = 'temp'
    and u.temp_user_id = '$_COOKIE[temp_user_id]'";

    $items = $query->fetchAssoc($q);

    $id_ar = $query->extractArrayFromQuery("temp_cart u,barbers_services bs, services s", "temp_user_id", "bs.barb_ser_id = u.barb_ser_id and bs.service_id = s.service_id
   and u.temp_user_id ='" . $_COOKIE['temp_user_id'] . "'");

    $id_ar_s = implode(",", $id_ar);

    $id = 'temp_cart_id';
    $table = 'temp';

}

// check if user has booked dates for all cart items

$user_id = $temp_count == 0 ? users::getUserID() : $_COOKIE['temp_user_id'];
$col = $temp_count == 0 ? 'user_id' : 'temp_user_id';
$table1 = $table.'_cart';
$booked_date_count = query::numRows("select * from booked_hours where user_id = '$user_id'");
$cart_items = query::numRows("select * from $table1 where $col = '$user_id' ");

/*$user_id = $_COOKIE['temp_user_id'];
$col = 'temp_user_id';
$table1 = $table.'_cart';
$booked_date_count = query::numRows("select * from booked_hours where user_id = '$user_id'");
$cart_items = query::numRows("select * from $table1 where $col = '$user_id' ");
*/

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

        include('order_info.php');
        ?>

        <!-- content end !-->






        <div class="menu-hider"></div>

    </div>








</body>