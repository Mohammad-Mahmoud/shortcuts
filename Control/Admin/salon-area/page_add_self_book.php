<?php

$barber = $_POST['barber'];
$date = $_POST['date'];
$barb_ser_id = $_POST['service'];
$hour = $_POST['hour'];
$cut_dur = $_POST['dur'];
$type = $_POST['type'];
$address = $_POST['address'];
$email = $_POST['email'];
$name = $_POST['name'];
$phone = $_POST['phone'];
if($type == 'salon') {
    $dur = 0;
} else {
    $dur = 20;
}
$end = strtotime($hour) + $cut_dur*60;
$end = date('G:i:s', $end);

if($_GET['u'] == 'guest') {
    $guest = 1;
    $user_id = md5(query::generateSN());
    query::update("insert into actual_booking values (actual_booking_id, '$barb_ser_id', '$user_id','$type',
                   '','','$address','$dur','$barber','$hour','$date','$cut_dur','$end','$guest', NOW(), 0)");
    query::update("insert into guest values(guest_id, '$user_id','$name','$address','$phone','$email')");
} else if($_GET['u'] == 'user') {
    $guest = 0;
    $user_id = $_GET['i'];
    query::update("insert into actual_booking values (actual_booking_id, '$barb_ser_id', '$user_id','$type',
                   '','','$address','$dur','$barber','$hour','$date','$cut_dur','$end','$guest', NOW(), 0)");
}
