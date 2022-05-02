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
$ar = [];
$count = 0;
$query = new query();
$query2 = new query();
$temp_count = query::numRows("select * from temp_cart where temp_user_id = '$_COOKIE[temp_user_id]'");
$user_id = users::getUserID();

$u_id = isset($_SESSION['username']) ? $user_id : $_COOKIE['temp_user_id'];

$guest = isset($_SESSION['username']) ? 0 : 1;
if($temp_count == 0){
    $q = "SELECT *, u.type as u_type, bs.type as b_type, u.barber_id as barber, 
    u.dur as c_dur, h.dur as cut_dur
    from user_cart u,barbers_services bs, services s, booked_hours h where
    bs.barb_ser_id = u.barb_ser_id and bs.service_id = s.service_id
    and u.user_cart_id = h.cart_id
    and h.cart_type = 'user'
    and u.user_id = '$u_id'";

    $items=  $query->fetchAssoc($q);
    $items2 = $query2->fetchAssoc($q);

} else {

    $q = "SELECT *, u.type as u_type, bs.type as b_type, u.barber_id as barber,
    u.dur as c_dur, h.dur as cut_dur
    from temp_cart u,barbers_services bs, services s, booked_hours h where
    bs.barb_ser_id = u.barb_ser_id and bs.service_id = s.service_id
    and u.temp_cart_id = h.cart_id
    and h.cart_type = 'temp'
    and u.temp_user_id = '$u_id'";

    $items = $query->fetchAssoc($q);
    $items2 = $query2->fetchAssoc($q);


}
while ($row = $items->fetch_assoc()) {

    $barber_actual_booking = $query->extract2DArrayFromQuery('barbers_bookings_hours',['date','start'],'barber_id = '.$row['barber']);
    //print_r($barber_actual_booking);
    array_push($ar, array($row['date'], $row['hour']));
    $n = array_merge($ar, $barber_actual_booking);
    //print_r($n);

}
$arr = [];
foreach ($n as $current_key => $current_array) {
    $search_key = array_search($current_array, $n);

    if ($current_key != $search_key) {
        //echo "duplicate found for item $current_key\n";
        print_r($current_array);
        $count++;
        array_push($arr, $current_array);
    }

}

if($count == 0) {
    while($row = $items2->fetch_assoc()) {
        $end = strtotime($row['hour']) + $row['cut_dur']*60;
        $end = date('G:i:s', $end);
        if (!isset($_SESSION['username'])) {
            $address = $row['address'];
        } else {
            $add = query::returnSingleValue('user_address', 'address', 'user_id = ' . $user_id);
            $city = query::returnSingleValue('user_address', 'city', 'user_id = ' . $user_id);
            $zip = query::returnSingleValue('user_address', 'zip', 'user_id = ' . $user_id);
            $address = $add . ', ' . $zip . ' ' . $city;
        }


        query::update("insert into actual_booking values(actual_booking_id,'$row[barb_ser_id]',
            '$u_id', '$row[u_type]', '$row[lat]', '$row[lng]', '$address', '$row[c_dur]', '$row[barber]',
            '$row[hour]', '$row[date]', '$row[cut_dur]', '$end', '$guest', NOW(),0,0,0,0)");
        query::update("insert into barbers_bookings_hours values(barbers_bookings_hours_id, '$row[date]',
                      '$row[barber]','$row[hour]','$end')");
        if(!isset($_SESSION['username'])) {
            $guest_count = query::numRows("select * from guest where temp_user_id = '$u_id'");
            $name = $_POST['first_name'].' '.$_POST['last_name'];
            $address = $_POST['address'].', '.$_POST['zip'].', '.$_POST['city'];
            if($guest_count == 0) {
                query::update("insert into guest values(guest_id, '$u_id','$name','$address','$_POST[phone]','$_POST[email1]')");
            } else {
                query::update("update guest set name = '$name' where temp_user_id = '$u_id'");
                query::update("update guest set address = '$address' where temp_user_id = '$u_id'");
                query::update("update guest set email = '$_POST[email1]' where temp_user_id = '$u_id'");
                query::update("update guest set phone = '$_POST[phone]' where temp_user_id = '$u_id'");


            }
        }
        if(isset($_SESSION['username'])) {
            $email = $query::returnSingleValue('users','email', 'user_id = '.$user_id);
            $acutal = $query->fetchAssoc("select max(actual_booking_id) as max from actual_booking where user_id = '$user_id'");
            $acutal_booking_id = $acutal->fetch_assoc();
            $order_id = $acutal_booking_id['max'];
            $date = $query::returnSingleValue('actual_booking','date', 'actual_booking_id = '.$order_id);
            $hour = $query::returnSingleValue('actual_booking','hour', 'actual_booking_id = '.$order_id);
            $full_date = $date.' '.$hour;
            $barber_id = $query::returnSingleValue('actual_booking','barber_id', 'actual_booking_id = '.$order_id);
            $barber_email = $query::returnSingleValue('barbers','email', 'barber_id = '.$barber_id);
            $f_name = $query::returnSingleValue('users','first_name', 'user_id = '.$user_id);
            $l_name = $query::returnSingleValue('users','last_name', 'user_id = '.$user_id);
            $full_name = $f_name.' '.$l_name;
            sendReceipt($email, $order_id, $full_date);
            sendReceiptToBarber($barber_email, $order_id, $full_date, $full_name);

        } else {
            $email = $_POST['email1'];
            $acutal = $query->fetchAssoc("select max(actual_booking_id) as max from actual_booking where user_id = '$u_id'");
            $acutal_booking_id = $acutal->fetch_assoc();
            $order_id = $acutal_booking_id['max'];
            $date = $query::returnSingleValue('actual_booking','date', 'actual_booking_id = '.$order_id);
            $hour = $query::returnSingleValue('actual_booking','hour', 'actual_booking_id = '.$order_id);
            $full_date = $date.' '.$hour;
            $barber_id = $query::returnSingleValue('actual_booking','barber_id', 'actual_booking_id = '.$order_id);
            $barber_email = $query::returnSingleValue('barbers','email', 'barber_id = '.$barber_id);
            $full_name = $_POST['first_name'].' '.$_POST['last_name'];
            sendReceipt($email, $order_id, $full_date);
            sendReceiptToBarber($barber_email, $order_id, $full_date, $full_name);

        }
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

    <?php
    if($count == 0) {
        include('view_receipt.php');
    } else {
        include('booking_error.php');
    }
    ?>


    <!-- content end !-->






    <div class="menu-hider"></div>

</div>









</body>

