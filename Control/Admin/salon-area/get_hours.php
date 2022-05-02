<?php
session_start();
?>

    <div class="form-group">
        <label>Select Hour</label>
        <select class="form-control" name="services" id="hour">


<?php
require('classes/class.Database.php');

require('classes/class.query.php');

require('classes/class.admin.php');

$date = $_GET['q'];
$b = $_GET['b'];


//$duration = 60;
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

$h = 3600;


$query = new query;

$times_ar = $start_ar = $end_ar = $dates_ar = $hours_ar = $blocked_hours =  [];



/*while($row = $booked_times->fetch_assoc()) {
    $date_ar[ $row['date']] = [];

}
    while($row = $booked_times->fetch_assoc()) {

            echo $row['hour'];

    }
    $date_ar['date'] = $hours_ar;


if($all_ser_count > 0){
    if(count($cart_ids) > 1 && !in_array($_GET['c'],$cart_ids)) {

    }
}*/
$salon_id = admin::getSalonData('salon_id');

$salon_type = admin::getSalonData('type');



$count = query::numRows("select * from barbers_bookings_hours where barber_id = '$b' and date = '$date'");
if ($salon_type == 'self') {
    $open = strtotime(query::returnSingleValue('opening_hours', 'open', 'salon_id = ' . $salon_id));
    $close = strtotime(query::returnSingleValue('opening_hours', 'close', 'salon_id = ' . $salon_id));
} else {
    $open = strtotime(query::returnSingleValue('opening_hours', 'open', 'salon_id = ' . $salon_id.' and  type="'.$_GET['type'].'"'));
    $close = strtotime(query::returnSingleValue('opening_hours', 'close', 'salon_id = ' . $salon_id.' and  type="'.$_GET['type'].'"'));
}

$total_opening_min = ($close - $open) / 60;

$total = query::returnSingleValue("barbers_bookings_hours", "sum(TIMESTAMPDIFF(MINUTE,start,end))", "barber_id=" . $b . " and date = '" . $date . "'");


$open_h = date('G', $open);
$close_h = date('G', $close);

$current_hour = date('G', time());
$current_date = date('Y-m-d', time());

if($current_date == $date) {
    if($current_hour < $open_h ) {
        $booking_start_hour = $open_h;
    } else {
        $booking_start_hour = $current_hour + 1;
    }
} else {
    $booking_start_hour = $open_h;
}


$booked_times = $query->fetchAssoc("select start, end from barbers_bookings_hours where date = '$date' and barber_id = '$_GET[b]' order by start asc");

while ($row = $booked_times->fetch_assoc()) {
    array_push($start_ar, $row['start']);
    array_push($end_ar, $row['end']);
}

$times_ar['start'] = $start_ar;
$times_ar['end'] = $end_ar;

if ($count == 0) {

    for ($i = $booking_start_hour; $i <= $close_h - ceil($duration / 60); $i++) {
        $leading = ($i < 10 ? 0 : '');

        if(!in_array($i, $blocked_hours)) {
            echo '<option>' . $leading . $i . ':00:00</option>';
        }
    }

} else {
    $min_time = strtotime(query::returnSingleValue("barbers_bookings_hours", "min(start)", " barber_id = " . $_GET['b'] . " and date= '" . $date . "' group by date"));
    $min_time_h = date('G', $min_time);
    $max_end = strtotime(query::returnSingleValue("barbers_bookings_hours", "max(end)", "barber_id=" . $_GET['b'] . " and date = '" . $date . "'"));
    $max_time_m = date('i', $max_end);
    $max_time_h = date('G', $max_end);
    if($max_time_m !== '00') {
        $max_time_h += 1;
    } else {
        $max_time_h = $max_time_h;
    }
    $m_x = $max_time_h.":00:00";
    if(in_array($m_x,$times_ar['start'])) {
        $max_time_h = $max_time_h+1;
    }
    if($current_date == $date) {
        if($current_hour < $max_time_h ) {
            $booking_start_hour1 = $max_time_h;
        } else {
            $booking_start_hour1 = $current_hour + 1;
        }
    } else {
        $booking_start_hour1 = $max_time_h;
    }

    $diff = ($min_time  -  $open) / 60;
    $diff1 = ($close - $max_end) / 60;
    if (($diff >= $duration) && ($total_opening_min - $total) > $duration) {
        for ($f = $booking_start_hour; $f < $min_time_h; $f++) {
            $leading = ($f < 10 ? 0 : '');
            if(!in_array($f, $blocked_hours)) {

                echo '<option>' . $leading . $f . ':00:00</option>';
            }
        }
    }
    if (($diff1 >= $duration) && ($total_opening_min - $total) > $duration) {
        for ($g = $booking_start_hour1; $g < $close_h; $g++) {
            $leading = ($g < 10 ? 0 : '');
            if(!in_array($g, $blocked_hours)) {
                echo '<option>' . $leading . $g . ':00:00</option>';
            }
        }
    }

    for ($i = 0; $i <= count($times_ar['start']) - 2; $i++) {
        $z =  $i + 1;
        $time_diff = (strtotime($times_ar['start'][$z]) - strtotime($times_ar['end'][$i])) / 60;
        $period = floor($time_diff / $duration) - 1;
        if ($time_diff >= $duration) {
            echo '<option>' . $times_ar['end'][$i] . '</option>';
            if ($period >= 1) {
                for ($j = 0; $j <= $period - 1; $j++) {

                    $timestamp = strtotime($times_ar['end'][$i]) + $h;
                    $h += 3600;
                    $time = date('H:i', $timestamp);
                    echo '<option>' . $time .  ':00</option>';
                }
            }
        }
    }

    // }
}

?>

        </select>
    </div>

<?php
