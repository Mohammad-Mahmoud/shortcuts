<div class="top-100" >

    <div class="content">
        <div class="tab-controls tab-animated tabs-large tabs-rounded" data-tab-items="2" data-tab-active="bg-green1-dark">
            <a href="#" data-tab-active="" data-tab="tab-8" class="bg-green1-dark color-white no-click" style="width: 50%;">Upcomming</a>
            <a href="#" data-tab="tab-9" class="" style="width: 50%;">Completed</a>
        </div>
        <div class="clear bottom-15"></div>
        <div class="tab-content" id="tab-8" style="display: block;">
            <?php
            if($up_count ==0) {
                echo 'You have no upcoming bookings';
            }
            while($row = $upcomming_bookings->fetch_assoc()) {
                $barber = $query::returnSingleValue('barbers','name', 'barber_id = '.$row['barber_id']);
                $salon_id = $query::returnSingleValue('barbers','salon_id', 'barber_id = '.$row['barber_id']);
                $service = $query::returnSingleValue('barbers_services b, services s','name', 's.service_id = b.service_id and barb_ser_id = '.$row['barb_ser_id']);
                $date = strtotime($row['date'].' '.$row['hour']);
                $hour = ($date - $cur_date)/(60*60);

                ?>
                <div class="content content-box shadow-large" style="background-color:#E6E6FA;">
                    <h4 class="bold top-10" style="color:darkslategray;"> <?=date('d F Y, l',strtotime($row['date']))?></h4>
                    <p class="bottom-10">
                        <h5><a href="salon.php?i=<?=$salon_id?>" style="color:darkslategray;"> <?=$barber?> </a></h5>

                        <b><?=$service?></b> <br>
                        <?=$row['hour']?> - <?=$row['end']?>
                     </p>
                    <div class="divider" style="margin-top:10px;"></div>
                    <?php
                    if($hour < 12) {
                        if($hour < 12 && $hour > 2) {
                            $refund = '50%';
                        } else if($hour <= 2) {
                            $refund = '0';
                        }
                        if($row['status'] == 0) {
                            echo '<a href="#" class="button button-m shadow-small button-round-small bg-red1-light" data-menu="menu-confirm' . $row['actual_booking_id'] . '">Cancel Booking</a>';
                        } else {
                            echo '<h3 style="color: red;">Booking canceled</h3>';
                        }
                    } else
                    {
                        if($row['status'] == 0) {
                            echo '<a href="#" class="button button-m shadow-small button-round-small bg-red1-light" data-menu="confirm' . $row['actual_booking_id'] . '">Cancel Booking</a>';
                        } else {
                            echo '<h3 style="color: red;">Booking canceled</h3>';
                        }
                    ?>
                        <div id="menu-confirm<?=$row['actual_booking_id']?>"
                             class="menu menu-box-modal round-medium"
                             data-menu-height="210"
                             data-menu-width="310"
                             data-menu-effect="menu-over">
                            <h1 class="center-text uppercase ultrabold top-30">Are you sure?</h1>
                            <p class="boxed-text-large">
                                You will only refund <?=$refund?>, are you sure you want to cancel booking.
                            </p>
                            <div class="content left-20 right-20">
                                <div class="one-half">
                                    <a href="cancel_booking.php?i=<?=$row['actual_booking_id']?>"  class="button button-center-large button-s shadow-large button-round-small bg-green1-dark">Accept</a>
                                </div>
                                <div class="one-half last-column">
                                    <a href="#" class="close-menu button button-center-large button-s shadow-large button-round-small bg-red1-dark">REJECT</a>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div id="confirm<?=$row['actual_booking_id']?>"
                             class="menu menu-box-modal round-medium"
                             data-menu-height="210"
                             data-menu-width="310"
                             data-menu-effect="menu-over">
                            <h1 class="center-text uppercase ultrabold top-30">Are you sure?</h1>
                            <p class="boxed-text-large">
                                Are you sure you want to cancel this booking?
                            </p>
                            <div class="content left-20 right-20">
                                <div class="one-half">
                                    <a href="cancel_booking.php?i=<?=$row['actual_booking_id']?>"  class="button button-center-large button-s shadow-large button-round-small bg-green1-dark">Yes</a>
                                </div>
                                <div class="one-half last-column">
                                    <a href="#" class="close-menu button button-center-large button-s shadow-large button-round-small bg-red1-dark">No</a>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="tab-content" id="tab-9" style="display: none;">
            <?php
            if($completed_count == 0) {
                echo 'You have no bookings';
            }
            while($row = $completed_bookings->fetch_assoc()) {
                $barber = $query::returnSingleValue('barbers','name', 'barber_id = '.$row['barber_id']);
                $salon_id = $query::returnSingleValue('barbers','salon_id', 'barber_id = '.$row['barber_id']);
                $service = $query::returnSingleValue('barbers_services b, services s','name', 's.service_id = b.service_id and barb_ser_id = '.$row['barb_ser_id']);

                ?>
                <div class="content content-box shadow-large" style="background-color: #E6E6FA;">
                    <h4 class="bold top-10" style="color:darkslategray;"> <?=date('d F Y, l',strtotime($row['date']))?></h4>
                    <p class="color-white bottom-10">
                    <h5><a href="salon.php?i=<?=$salon_id?>" style="color:darkslategray;""> <?=$barber?> </a></h5>

                    <b><?=$service?></b> <br>
                    <?=$row['hour']?> - <?=$row['end']?>
                    </p>
                    <div class="divider" style="margin-top:10px;"></div>

                    <a href="cancel_booking.php?i=<?=$row['actual_booking_id']?>&t=d" class="button button-m shadow-small button-round-small bg-red1-light">Delete</a>
                </div>

                <?php
            }
            ?>
        </div>
        </div>
    </div>
</div>

<div id="menu-confirm"
     class="menu menu-box-modal round-medium"
     data-menu-height="210"
     data-menu-width="310"
     data-menu-effect="menu-over">
    <h1 class="center-text uppercase ultrabold top-30">Are you sure?</h1>
    <p class="boxed-text-large">
        You can even use these boxes for confirmations.
    </p>
    <div class="content left-20 right-20">
        <div class="one-half">
            <a href="#" onclick="return true;" class="button button-center-large button-s shadow-large button-round-small bg-green1-dark">Accept</a>
        </div>
        <div class="one-half last-column">
            <a href="#" class="close-menu button button-center-large button-s shadow-large button-round-small bg-red1-dark">REJECT</a>
        </div>
        <div class="clear"></div>
    </div>
</div>
