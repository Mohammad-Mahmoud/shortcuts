<?php
$query = new query();
$salon_id = admin::getSalonData('salon_id');
$working_days = $query->fetchAssoc("select day from working_days where salon_id = '$salon_id' and active = 0");
$working_days_ar = [];
$barber =  $_GET['b'];
$barb_ser_id = $_POST['services'];

if($barb_ser_id[0] == 'h') {
    $type = 'home';
} else if($barb_ser_id[0] == 's') {
    $type = 'salon';
}
$b_ser_id = substr($barb_ser_id, 1);


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
$black_dates = $query->extractArrayFromQuery('closing_days', 'date', 'salon_id = ' . $salon_id);

$dur = query::returnSingleValue('barbers_services', 'dur', 'barb_ser_id = ' . $b_ser_id);
$dur += 20;
$salon_type = query::returnSingleValue('salon', 'type', 'salon_id = ' . $salon_id);
if ($salon_type == 'self') {
    $open = strtotime(query::returnSingleValue('opening_hours', 'open', 'salon_id = ' . $salon_id));
    $close = strtotime(query::returnSingleValue('opening_hours', 'close', 'salon_id = ' . $salon_id));
} else {
    $open = strtotime(query::returnSingleValue('opening_hours', 'open', 'salon_id = ' . $salon_id . ' and type="' . $type . '"'));
    $close = strtotime(query::returnSingleValue('opening_hours', 'close', 'salon_id = ' . $salon_id . ' and type="' . $type . '"'));
}

$total_opening_min = ($close - $open) / 60;

$times = $query->fetchAssoc("SELECT date,sum(TIMESTAMPDIFF(MINUTE,start,end)) as total FROM barbers_bookings_hours where barber_id = '$barber' GROUP by date ");
while ($row = $times->fetch_assoc()) {

    if ($row['total'] == $total_opening_min) {
        array_push($black_dates, $row['date']);
    }
    if (($total_opening_min - $row['total']) < $dur) {
        array_push($black_dates, $row['date']);
    }
}


$black_dates_ar = '"' . implode('", "', $black_dates) . '"';
?>
<p><b>Select Date</b></p>
<div class="form-group">
    <label class="input-group datepicker-only-init">
        <input id="date" type="text" class="form-control" placeholder="Select Date">
        <span class="input-group-addon">
                                <i class="icmn-calendar"></i>
        </span>
    </label>
</div>

<script>
    $(function(){
        var today = new Date();

        $(".datepicker-only-init").on("dp.change", function (e) {
            var cur_date = e.date.toISOString().split('T')[0]
            $("#next").prop("disabled", false);

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("what").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "get_hours.php?q=" + cur_date + "&b=<?=$barber?>&d=<?=$dur?>&type=<?=$type?>", true);
            xmlhttp.send();
        });

        $('.datepicker-only-init').datetimepicker({
            widgetPositioning: {
                horizontal: 'left'
            },
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                previous: 'fa fa-arrow-left',
                next: 'fa fa-arrow-right'
            },
            format: 'YYYY-MM-DD',
            minDate: today,
            daysOfWeekDisabled: [<?=$inactive_days?>],
            disabledDates: [<?=$black_dates_ar?>],
            useCurrent: false





        });

        $('.timepicker-init').datetimepicker({
            widgetPositioning: {
                horizontal: 'left'
            },
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                previous: 'fa fa-arrow-left',
                next: 'fa fa-arrow-right'
            },
            format: 'LT'
        });

        $('.datepicker-inline-init').datetimepicker({
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                previous: 'fa fa-arrow-left',
                next: 'fa fa-arrow-right'
            },
            inline: true,
            sideBySide: false
        });

        $('.timepicker-inline-init').datetimepicker({
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                previous: 'fa fa-arrow-left',
                next: 'fa fa-arrow-right'
            },
            format: 'LT',
            inline: true,
            sideBySide: false
        });

    })
</script>


<div id="what">


</div>

<BUTTON class="btn btn-primary" id="next">Next</BUTTON>
<script>
    $(document).ready(function() {

        $("#next").prop("disabled", true);



    });


</script>

<script>


    $("#next").click(function() {

        var val = $("#hour").val();
        var date = $("#date").val();
        alert(val);

        location.replace("home.php?art=add_self_booking&b=<?=$_GET['b']?>&h="+val+"&c=<?=$b_ser_id?>&d=<?=$dur?>&type=<?=$type?>&date="+date);
    })
</script>
