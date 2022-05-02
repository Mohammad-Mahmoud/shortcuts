<div class="top-100" >

    <div class="content content-box bg-gradient-orange shadow-large">
        <p><i class="fa fa-2x fa-exclamation-triangle color-white"></i></p>
        <h4 class="color-white bold top-10">Error</h4>
        <p class="color-white bottom-10">
            Some of your bookings has already taken. Please choose another dates.
        </p>
    </div>
</div>
<a href="book.php" style="color: #fff;" class="button bg-highlight button-full button-round-small shadow-large button-s top-30">Return to your booking</a>
<?php
print_r($arr);
foreach($arr as $val) {
    foreach($val as  $value) {

            $date = $val[0];



            $hour = $val[1];

        query::update("delete from booked_hours where date = '$date' and hour = '$hour' and user_id = '$u_id'");
    }
}