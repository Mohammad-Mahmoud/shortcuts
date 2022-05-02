<?php
session_start();
error_reporting(E_ERROR | E_PARSE);

include('in_cla/class.Database.php');
include('in_cla/class.query.php');
include('in_cla/class.lang.php');
include('in_cla/funcs.php');
include("in_cla/class.users.php");

$query = new query;

$user_id = users::getUserID();

if (isset($_GET['lang'])) {
    setUserlang($_GET['lang']);
    header('Location: index.php');
}

$salon_id = query::returnSingleValue('barbers', 'salon_id', 'barber_id = ' . $_GET['b']);
$dur = query::returnSingleValue('barbers_services', 'dur', 'barb_ser_id = ' . $_GET['i']);

if (isset($_SESSION['username'])) {
    $cart_dur = query::returnSingleValue('user_cart', 'dur', 'user_cart_id = ' . $_GET['c']);
} else {
    $cart_dur = query::returnSingleValue('temp_cart', 'dur', 'temp_cart_id = ' . $_GET['c']);
}

if ($_GET['type'] == 'salon') {
    $duration = $dur;
} else {
    $duration = $dur + 20 + $cart_dur;
}


$black_dates = $query->extractArrayFromQuery('closing_days', 'date', 'salon_id = ' . $salon_id);

$salon_type = query::returnSingleValue('salon', 'type', 'salon_id = ' . $salon_id);
if ($salon_type == 'self') {
    $open = strtotime(query::returnSingleValue('opening_hours', 'open', 'salon_id = ' . $salon_id));
    $close = strtotime(query::returnSingleValue('opening_hours', 'close', 'salon_id = ' . $salon_id));
} else {
    $open = strtotime(query::returnSingleValue('opening_hours', 'open', 'salon_id = ' . $salon_id . ' and type="' . $_GET['type'] . '"'));
    $close = strtotime(query::returnSingleValue('opening_hours', 'close', 'salon_id = ' . $salon_id . ' and type="' . $_GET['type'] . '"'));
}

$total_opening_min = ($close - $open) / 60;

$times = $query->fetchAssoc("SELECT date,sum(TIMESTAMPDIFF(MINUTE,start,end)) as total FROM barbers_bookings_hours where barber_id = '$_GET[b]' GROUP by date ");
while ($row = $times->fetch_assoc()) {

    if ($row['total'] == $total_opening_min) {
        array_push($black_dates, $row['date']);
    }
    if (($total_opening_min - $row['total']) < $duration) {
        array_push($black_dates, $row['date']);
    }
}


//cart
$user_id = isset($_SESSION['username']) ? users::getUserID() : $_COOKIE['temp_user_id'];
$times1 = $query->fetchAssoc("SELECT date,sum(dur) as total FROM booked_hours where user_id = '$user_id' and barber_id = '$_GET[b]' GROUP by date ");
while ($row = $times1->fetch_assoc()) {
        if ($row['total'] == $total_opening_min) {
            array_push($black_dates, $row['date']);
        }
        if (($total_opening_min - $row['total']) < $duration) {
            array_push($black_dates, $row['date']);
        }
    
}
//



$booked_dates = $query->extractArrayFromQuery('barbers_bookings_hours', 'date', 'date >= CURDATE() AND barber_id = ' . $_GET['b'] . ' GROUP BY date');
$days_count = [];
$hours_count = [];

foreach ($booked_dates as $val) {

    $days_count[$val] = query::numRows("select * from barbers_bookings_hours where barber_id = '$_GET[b]' and date = '$val'");
}



//cart
$booked_dates1 = $query->extractArrayFromQuery('booked_hours', 'date', 'date >= CURDATE() AND user_id = "' . $user_id . '" GROUP BY date');
$days_count1 = [];
$hours_count1 = [];

foreach ($booked_dates1 as $val) {

    $days_count1[$val] = query::numRows("select * from booked_hours where user_id = '$user_id' and date = '$val'");
}
//

$ar = $ar1 = $ar2 = $a_r = [];
$co = $co1 = -1;
$nt = $nt1 =  -1;

foreach ($days_count as $key => $value) {
    $co++;
    $a_r[$co] = [];

    $dates_time_array[$key] = array();
}


//cart
$a_r1 = [];
$arr = $arr1 = $arr2  = [];
foreach ($days_count1 as $key => $value) {
    $co1++;
    $a_r1[$co1] = [];

    $dates_time_array1[$key] = array();
}
//


foreach ($days_count as $key => $value) {
    $nt++;

    $total = query::returnSingleValue("barbers_bookings_hours", "sum(TIMESTAMPDIFF(MINUTE,start,end))", "barber_id=" . $_GET['b'] . " and date = '" . $key . "'");

    $max_end = query::returnSingleValue("barbers_bookings_hours", "max(end)", "barber_id=" . $_GET['b'] . " and date = '" . $key . "'");
    $min_start = query::returnSingleValue("barbers_bookings_hours", "min(start)", "barber_id=" . $_GET['b'] . " and date = '" . $key . "'");

    $ar1[$key] = $total;
    $ar[$key] = $max_end;
    $ar2[$key] = $min_start;


    for ($i = 0; $i <= $value - 2; $i++) {
        $time_end = query::returnSingleValue('barbers_bookings_hours', 'end', 'date = "' . $key . '" and barber_id = ' . $_GET['b'] . '  order by start ASC limit ' . $i . ',1');
        $z = $i + 1;
        $time_start = query::returnSingleValue('barbers_bookings_hours', 'start', 'date = "' . $key . '" and barber_id = ' . $_GET['b'] . '  order by start ASC limit ' . $z . ',1');

        $end = strtotime($time_end);
        $start = strtotime($time_start);
        $diff   = ($start - $end) / 60;


        $total_diff += count($diff);

        if ($total_diff <= $value - 1) {

            array_push($a_r[$nt], $diff);
            $dates_time_array[$key] = $a_r[$nt];
        } else if ($total_diff > $value - 1) {

            array_push($a_r[$nt], $diff);
            $dates_time_array[$key] = $a_r[$nt];
        }
    }
}


//cart

foreach ($days_count1 as $key => $value) {
    $nt1++;

    $total1 = query::returnSingleValue("booked_hours", "sum(TIMESTAMPDIFF(MINUTE,hour,end))", "user_id='" . $user_id . "' and date = '" . $key . "' and barber_id = ".$_GET['b']);

    $max_end1 = query::returnSingleValue("booked_hours", "max(end)", "user_id='" . $user_id . "' and date = '" . $key . "' and barber_id = ".$_GET['b']);
    $min_start1 = query::returnSingleValue("booked_hours", "min(hour)", "user_id='" . $user_id . "' and date = '" . $key . "' and barber_id = ".$_GET['b']);

    $arr1[$key] = $total1;
    $arr[$key] = $max_end1;
    $arr2[$key] = $min_start1;


    for ($i = 0; $i <= $value - 2; $i++) {
        $time_end1 = query::returnSingleValue('booked_hours', 'end', 'date = "' . $key . '" and user_id = "' . $user_id . '" and barber_id = '.$_GET['b'].'  order by hour ASC limit ' . $i . ',1');
        $z = $i + 1;
        $time_start1 = query::returnSingleValue('booked_hours', 'hour', 'date = "' . $key . '" and user_id = "' . $user_id . '" and barber_id = '.$_GET['b'].'  order by hour ASC limit ' . $z . ',1');

        $end1 = strtotime($time_end1);
        $start1 = strtotime($time_start1);
        $diff1   = ($start1 - $end1) / 60;


        $total_diff1 += count($diff1);

        if ($total_diff1 <= $value - 1) {

            array_push($a_r1[$nt1], $diff1);
            $dates_time_array1[$key] = $a_r1[$nt1];
        } else if ($total_diff1 > $value - 1) {

            array_push($a_r1[$nt1], $diff1);
            $dates_time_array1[$key] = $a_r1[$nt1];
        }
    }
}


//

foreach ($ar1 as $key =>  $val) {

    $dates_time_array[$key]['total'] = $val;
}

foreach ($ar as $key =>  $val) {

    $dates_time_array[$key]['max'] = $val;
}

foreach ($ar2 as $key =>  $val) {

    $dates_time_array[$key]['min'] = $val;
}

//cart

foreach ($arr1 as $key =>  $val) {

    $dates_time_array1[$key]['total'] = $val;
}

foreach ($arr as $key =>  $val) {

    $dates_time_array1[$key]['max'] = $val;
}

foreach ($arr2 as $key =>  $val) {

    $dates_time_array1[$key]['min'] = $val;
}


//



foreach ($dates_time_array as $key => $value) {

    $end_time_limit = ($close - strtotime($dates_time_array[$key]['max'])) / 60;
    $start_time_limit = (strtotime($dates_time_array[$key]['min']) - $open) / 60;

    $max = max(array_slice($dates_time_array[$key], 0, -3, true));



    if (($total_opening_min - $dates_time_array[$key]['total']) > $duration) {

        if (($max < $duration) && ($end_time_limit < $duration) && ($duration > $start_time_limit)) {
            array_push($black_dates, $key);
        }
    }
}


// cart

foreach ($dates_time_array1 as $key => $value) {

    $end_time_limit1 = ($close - strtotime($dates_time_array1[$key]['max'])) / 60;
    $start_time_limit1 = (strtotime($dates_time_array1[$key]['min']) - $open) / 60;

    $max1 = max(array_slice($dates_time_array1[$key], 0, -3, true));

    if (($total_opening_min - $dates_time_array1[$key]['total']) > $duration) {

        if (($max1 < $duration) && ($end_time_limit1 < $duration) && ($duration > $start_time_limit1)) {
            array_push($black_dates, $key);
        }
    }
}
//

//cart
foreach($dates_time_array as $key => $val) {

   if( $dates_time_array[$key]['total'] + $dates_time_array1[$key]['total'] == $total_opening_min) {
    array_push($black_dates, $key);
   }


}

$black_dates_ar = '"' . implode('", "', $black_dates) . '"';

//print_r($dates_time_array1);
//print_r($dates_time_array);


$working_days = $query->fetchAssoc("select day from working_days where salon_id = '$salon_id' and active = 0");

$working_days_ar = [];

while ($row = $working_days->fetch_assoc()) {
    switch ($row['day']) {
        case 'Sunday':
            $sunday = 0;
            array_push($working_days_ar, $sunday);
            break;
        case 'Monday':
            $monday = 1;
            array_push($working_days_ar, $monday);
            break;
        case 'Tuesday':
            $teusday = 2;
            array_push($working_days_ar, $teusday);
            break;
        case 'Wedensday':
            $wedensday = 3;
            array_push($working_days_ar, $wedensday);
            break;
        case 'Thursday':
            $thursday = 4;
            array_push($working_days_ar, $thursday);
            break;
        case 'Friday':
            $friday = 5;
            array_push($working_days_ar, $friday);
            break;
        case 'Saturday':
            $saturday = 6;
            array_push($working_days_ar, $saturday);
            break;
    }
}
$inactive_days = implode(', ', $working_days_ar);

?>

<!DOCTYPE HTML>

<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />

    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <meta name="apple-mobile-web-app-capable" content="yes">

    <title>Eazy Mobile | HTML, CSS & JS Mobile Template | Epsilon X </title>



    <link rel="stylesheet" type="text/css" href="styles/style.css">

    <link rel="stylesheet" type="text/css" href="styles/framework.css">

    <link rel="stylesheet" type="text/css" href="fonts/css/fontawesome-all.min.css">

    <link rel="stylesheet" type="text/css" href="styles/store.css">



    <!-- Don't forget to update PWA version (must be same) in pwa.js & manifest.json -->


    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">


    <script src="https://code.jquery.com/jquery-latest.min.js"></script>

    <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.css" />

    <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.js"></script>

    <script type="text/javascript" src="src/js/external/widgetLib.js"></script>

    <script type="text/javascript" src="src/js/baseObject.js"></script>

    <script type="text/javascript" src="src/js/lib/dateEnhance.js"></script>

    <script type="text/javascript" src="src/js/lib/dateFormatter.js"></script>

    <script type="text/javascript" src="src/js/lib/dateLimit.js"></script>

    <script type="text/javascript" src="src/js/lib/dateParser.js"></script>

    <script type="text/javascript" src="src/js/lib/eventHandler.js"></script>

    <script type="text/javascript" src="src/js/lib/offset.js"></script>

    <script type="text/javascript" src="src/js/lib/public.js"></script>

    <script type="text/javascript" src="src/js/lib/shortUtil.js"></script>

    <script type="text/javascript" src="src/js/lib/standardControls.js"></script>

    <script type="text/javascript" src="src/js/lib/widgetCreate.js"></script>

    <script type="text/javascript" src="src/js/lib/widgetOpen.js"></script>

    <script type="text/javascript" src="src/js/lib/widgetClose.js"></script>

    <script type="text/javascript" src="src/js/lib/widgetDestroyEnableDisable.js"></script>

    <script type="text/javascript" src="src/js/lib/positioning.js"></script>

    <script type="text/javascript" src="src/js/framework/jqm.js"></script>

    <script type="text/javascript" src="src/js/modes/datebox.js"></script>

    <script type="text/javascript" src="src/js/modes/flipbox.js"></script>

    <script type="text/javascript" src="src/js/modes/calbox.js"></script>

    <script type="text/javascript" src="src/js/modes/slidebox.js"></script>

    <script type="text/javascript" src="src/js/widgetBinding.js"></script>

    <script type="text/javascript" src="src/js/autoInit.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/jtsage-datebox-i18n/jtsage-datebox.i18n.da.utf8.js" type="text/javascript"></script>


    <script type="text/javascript">
        $(document).ready(function() {

            $("#next").prop("disabled", true);

        });


        jQuery.extend(jQuery.jtsage.datebox.prototype.options, {

            /* Mode */

            //buttonIcon : '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 1C9.79 1 8 2.31 8 3.92C8 5.86 8.5 6.95 8 10C8 5.5 5.23 3.66 4 3.66C4.05 3.16 3.52 3 3.52 3C3.52 3 3.3 3.11 3.22 3.34C2.95 3.03 2.66 3.07 2.66 3.07L2.53 3.65C2.53 3.65 0.7 4.29 0.68 6.87C0.88 7.2 2.21 7.47 3.15 7.3C4.04 7.35 3.82 8.09 3.62 8.29C2.78 9.13 2 8 1 8C0 8 0 9 1 9C2 9 2 10 4 10C0.91 11.2 4 14 4 14H3C2 14 2 15 2 15C2 15 6 15 8 15C11 15 13 14 13 11.53C13 10.68 12.57 9.74 12 9C10.89 7.54 12.23 6.32 13 7C13.77 7.68 16 8 16 5C16 2.79 14.21 1 12 1ZM2.5 6C2.22 6 2 5.78 2 5.5C2 5.22 2.22 5 2.5 5C2.78 5 3 5.22 3 5.5C3 5.78 2.78 6 2.5 6Z" fill="#1B1F23"/></svg>',

            mode: "calbox",



            /* Display */

            displayMode: "drinlinopdown",


            // hideInput   : true,



            displayDropdownPosition: "centerMiddle",

            // displayInlinePosition   : "left",

            // defaultValue : new Date(2001, 0, 1),

            // useHeader : false,

            /* Input control */

            // showInitialValue : true,

            //useImmediate     : true,

            //useFocus         : true,

            // lockInput : true,

            // useButton : false,


            /* Linked fields */

            //linkedField: false,

            /* Callbacks */

            // beforeOpenCallbackArgs : [ "hi", "bye"],

            //beforeOpenCallback     :function() { $('#sel').prop('disabled', true);},



            closeCallback: function() {

                if ($('#db').val() != '') {



                    //$("#ser").css("visibility", 'visible');

                    var val = $('#db').val();

                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("what").innerHTML = this.responseText;
                        }
                    };
                    xmlhttp.open("GET", "get_hours.php?q=" + $('#db').val() + "&b=<?= $_GET['b'] ?>&d=<?= $duration ?>&type=<?= $_GET['type'] ?>&c=<?= $_GET['c'] ?>", true);
                    xmlhttp.send();

                    $('#next').prop("disabled", false);

                }
            },

            // openCallbackArgs : [ "hi", "bye"],

            //openCallback     : function() { $('#sel').prop('disabled', true);},

            // calBeforeAppendFunc : function( myObject ) { console.log( myObject.dateObj ); return myObject; },

            // calFormatter : function( date )  { return ( date.get(2) < 10 ) ? "<span style='color:red'>" + date.get(2) + "</span>" : date.get(2); },

            /* Limits */

            blackDates: [<?= $black_dates_ar ?>],

            // blackDatesRec : [ [-1,0,1], [-1,11,31], [-1,11,25], [-1,11,24] ],

            blackDays: [<?= $inactive_days ?>],

            //blackDatesPeriod: ["2020-05-17", 7],

            // enableDates : ["2001-01-01", "2000-12-31", "2000-12-25", "2000-12-24"],

            // validHours  : [ 9, 10, 11, 12, 13, 14, 15, 16, 17 ],



            //highDatesAlt : ["2020-07-14", "2000-12-31", "2000-12-25", "2000-12-24"],

            // highDates    : ["2000-12-31", "2000-12-25", "2000-12-24"],

            // highDatesRec : [ [-1,0,1], [-1,11,31], [-1,11,25], [-1,11,24] ],

            //highDays     : [ 0, 6 ],

            //calDateList     : [ ["1980-04-25", "JT's Date of Birth"], ["1809-02-12", "Lincoln's Birthday"] ],

            //calShowDateList : true,

            //slideDateList     : [ ["1980-04-25", "JT's Date of Birth"], ["1809-02-12", "Lincoln's Birthday"] ],

            //slideShowDateList : true,

            afterToday: true,
            //whiteDates  : ["2020-07-14", "2000-12-31", "2000-12-25", "2000-12-24"],

            //beforeToday : true,

            //notToday    : true,

            // minDays : 10,

            maxDays: 15,

            // minDur : 34652,

            // maxDur : 34700,

            // minHour : 9,

            // maxHour : 5,

            // minTime : "9:00",

            // maxTime : "17:00",

            // minYear : 2001,

            // maxYear : 2020,

            /* CSS */

            // breakpointWidth : "600px",

            // controlWidth    : "290px",

            /* calbox Mode */

            // calHighOutOfBounds : false,

            // calHighPick        : false,

            // calHighToday       : true,

            // calNoHeader        : true,

            calOnlyMonth: true,

            // calShowDays        : false,

            calShowWeek: true,

            //overrideCalStartDay : 1,

            //calUsePickers: false,

            // calYearPickMax      : 2050,

            // calYearPickMin      : 1950,

            // calYearPickRelative : false,

            /* slidebox Mode */

            // slideHighPick        : false,

            // slideHighToday       : false,,

            // slideNoHeader        : true,

            //slideUsePickers: false,

            // slideYearPickMax      : 2050,

            // slideYearPickMin      : 1950,

            // slideYearPickRelative : false,

            /* Steppers */

            // durationStep : 2,

            // minuteStep   : 2,

            /* flipBox Mode */

            // flipboxAdjustLens : 12,

            /* Control Buttons */

            // closeTodayButton    : true,

            // closeTomorrowButton : true,

            useCancelButton: false,

            useClearButton: false,

            // useSetButton        : false,

            //useTodayButton: true,

            // useTomorrowButton   : true,

            // useCollapsedBut     : true,

        });
    </script>

</head>

<body class="theme-light" data-highlight="blue2">


    <div id="page-preloader">

        <div class="loader-main">

            <div class="preload-spinner border-highlight"></div>

        </div>

    </div>



    <div id="page">
        <?php
        include('header.php');


        include('cal.php');
        ?>



    </div>



    <script type="text/javascript" src="scripts/plugins.js"></script>

    <script type="text/javascript" src="scripts/custom.js"></script>

</body>