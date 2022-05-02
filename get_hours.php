<?php
session_start();
?>

<!DOCTYPE HTML>

<html lang="en">

<head>
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>

    <style>
        .select-css {
            display: block;
            font-size: 16px;
            font-family: sans-serif;
            font-weight: 700;
            color: #444;
            line-height: 1.3;
            padding: .6em 1.4em .5em .8em;
            width: 100%;
            max-width: 100%;
            /* useful when width is set to anything other than 100% */
            box-sizing: border-box;
            margin: 0;
            border: 1px solid #aaa;
            box-shadow: 0 1px 0 1px rgba(0, 0, 0, .04);
            border-radius: .5em;
            -moz-appearance: none;
            -webkit-appearance: none;
            appearance: none;
            background-color: #fff;
            /* note: bg image below uses 2 urls. The first is an svg data uri for the arrow icon, and the second is the gradient. 
        for the icon, if you want to change the color, be sure to use `%23` instead of `#`, since it's a url. You can also swap in a different svg icon or an external image reference
        
    */
            background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23007CB2%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'),
                linear-gradient(to bottom, #ffffff 0%, #e5e5e5 100%);
            background-repeat: no-repeat, repeat;
            /* arrow icon position (1em from the right, 50% vertical) , then gradient position*/
            background-position: right .7em top 50%, 0 0;
            /* icon size, then gradient */
            background-size: .65em auto, 100%;
        }

        /* Hide arrow icon in IE browsers */
        .select-css::-ms-expand {
            display: none;
        }

        /* Hover style */
        .select-css:hover {
            border-color: #888;
        }

        /* Focus style */
        .select-css:focus {
            border-color: #aaa;
            /* It'd be nice to use -webkit-focus-ring-color here but it doesn't work on box-shadow */
            box-shadow: 0 0 1px 3px rgba(59, 153, 252, .7);
            box-shadow: 0 0 0 3px -moz-mac-focusring;
            color: #222;
            outline: none;
        }

        /* Set options to normal weight */
        .select-css option {
            font-weight: normal;
        }

        /* Support for rtl text, explicit support for Arabic and Hebrew */
        *[dir="rtl"] .select-css,
        :root:lang(ar) .select-css,
        :root:lang(iw) .select-css {
            background-position: left .7em top 50%, 0 0;
            padding: .6em .8em .5em 1.4em;
        }

        /* Disabled styles */
        .select-css:disabled,
        .select-css[aria-disabled=true] {
            color: graytext;
            background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22graytext%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'),
                linear-gradient(to bottom, #ffffff 0%, #e5e5e5 100%);
        }

        .select-css:disabled:hover,
        .select-css[aria-disabled=true] {
            border-color: #aaa;
        }


        body {
            margin: 2rem;
        }
    </style>


</head>

<body>
    Select time
    <select class="select-css" id="select-css">
        <?php
        
        //error_reporting(E_ERROR | E_PARSE);

        include('in_cla/class.Database.php');
        include('in_cla/class.query.php');
        include('in_cla/class.lang.php');
        include('in_cla/funcs.php');
        include("in_cla/class.users.php");
        if (isset($_GET['lang'])) {
            setUserlang($_GET['lang']);
            header('Location: index.php');
        }



        $date = date("Y-m-d", strtotime($_GET['q']));
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

        $user_id = isset($_SESSION['username']) ? users::getUserID() : $_COOKIE['temp_user_id'];

        $all_ser_count = query::numRows("select * from booked_hours where user_id like '$user_id' and date like '$date'");
        $cart_ids = $query->extractArrayFromQuery('booked_hours','cart_id','user_id like "'.$user_id.'" and date like "'.$date.'" and barber_id = '.$_GET['b']);
        $booked_times = $query->fetchAssoc("select * from booked_hours where user_id like '$user_id' group by date");
        $booked_hours = $query->extractArrayFromQuery('booked_hours','hour','user_id like "'.$user_id.'" and date like "'.$date.'" and barber_id = '.$_GET['b'].' and cart_id != '.$_GET['c']);

       if(in_array($_GET['c'], $cart_ids)) {
            $v = 'do nothing';
       } else {
          foreach($booked_hours as $val) {
              array_push($blocked_hours, date('G', strtotime($val)));
          }
       }
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

        $salon_id = query::returnSingleValue('barbers', 'salon_id', 'barber_id = ' . $_GET['b']);

        $salon_type = query::returnSingleValue('salon', 'type', 'salon_id = ' . $salon_id);


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

</body>

<?php
//print_r($start_ar);


