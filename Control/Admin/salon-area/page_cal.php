
<?php
$salon_id = admin::getSalonData('salon_id');

$q = "SELECT * FROM actual_booking a, barbers b where 
                    a.barber_id = b.barber_id and b.salon_id = '$salon_id'";
$query = new query();
$query1 = new query();
$bookings = $query->fetchAssoc($q);
$working_days = $query1->fetchAssoc("select day from working_days where salon_id = '$salon_id' and active = 1");
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
$active_days = implode(', ', $working_days_ar);

?>
<section class="card">

    <div class="card-block">
        <div class="example-calendar-block"></div>
    </div>
</section>
<!-- END: components/calendar -->

<!-- START: page scripts -->
<script>

    $(function() {
        var today = new Date();

        $('.example-calendar-block').fullCalendar({
            //aspectRatio: 2,
            height: 800,

            header: {
                left: 'prev, next',
                center: 'title',
                right: 'month, agendaWeek, agendaDay'
            },
            buttonIcons: {
                prev: 'none fa fa-arrow-left',
                next: 'none fa fa-arrow-right',
                prevYear: 'none fa fa-arrow-left',
                nextYear: 'none fa fa-arrow-right'
            },
            defaultDate: today,
            businessHours: {
                // days of week. an array of zero-based day of week integers (0=Sunday)
                daysOfWeek: [ <?=$active_days?>]

            },
            editable: false,
            eventLimit: true, // allow "more" link when too many events
            viewRender: function(view, element) {
                if (!('ontouchstart' in document.documentElement) && jQuery().jScrollPane) {
                    $('.fc-scroller').jScrollPane({
                        autoReinitialise: true,
                        autoReinitialiseDelay: 100
                    });
                }
            },
            events: [
                <?php
                while($row = $bookings->fetch_assoc()) {
                $service = $query::returnSingleValue('barbers_services','service_id','barb_ser_id='.$row['barb_ser_id']);
                $service_name = $query::returnSingleValue("services","name","service_id ='".$service."'");
                if($row['type'] == '') {
                    $type = $query::returnSingleValue('barbers_services','type','barb_ser_id='.$row['barb_ser_id']);
                } else {
                    $type = $row['type'];
                }
                if($row['guest'] == 1){
                    $user_details = $query->extract2DArrayFromQuery('guest', ['name','phone','email'],'temp_user_id ="'.$row['user_id'].'"');
                    $name = $user_details['name'];
                } else {
                    $user_details = $query->extract2DArrayFromQuery('users', ['first_name','last_name','phone','email'],'user_id = '.$row['user_id']);
                    $name = $user_details['first_name'].' '.$user_details['last_name'];;
                }
                    ?>
                {
                    barber: '<?=$row["name"]?>',
                    title: '<?=$row["name"]?>',
                    service: '<?=$service_name?>',
                    user: '<?=$name?>',
                    start: '<?=$row["date"]?> <?=$row["hour"]?>',
                    end: '<?=$row["date"]?> <?=$row["end"]?>',
                    type: '<?=$type?>',
                    phone: '<?=$user_details['phone']?>',
                    email: '<?=$user_details['email']?>',
                    address: '<?=$row['address']?>',
                    booking: '<?=$row['hour']?> - <?=$row['end']?>'

                },
                <?php } ?>

            ],
            eventClick: function(info) {
                $("#user").html("<b>Barber: </b>"+info.barber+"<br><b>Service name: </b>"+info.service+"<br>" +
                    "<b>Service Type:</b> "+info.type+"<br><b>Booking time: </b>" +info.booking+
                    "<hr><b>Customer Details </b><br><b>Name: </b>"+info.user + "<br><b>Phone: </b>"+info.phone+
                "<br><b>Email: </b>"+info.email+"<br><b>Address: </b>"+info.address);
                $("#d").dialog();
               // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
               // alert('View: ' + info.view.type);

                // change the border color just for fun
               // info.el.style.borderColor = 'red';
            }
            /*eventClick: function(calEvent, jsEvent, view) {
                if (!$(this).hasClass('event-clicked')) {
                    $('.fc-event').removeClass('event-clicked');
                    $(this).addClass('event-clicked');
                }
            }*/
        });

    });

</script>
<!-- END: page scripts -->

<div id="d" title="Event Details">
    <p id="user"></p>
</div>