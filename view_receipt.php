<?php
session_start();
$link = isset($_SESSION['username']) ? 'mybookings.php' : 'index.php';
$text = isset($_SESSION['username']) ? 'Go to bookings' : 'Return home';
?>
<div class="top-100" >

    <div class="content content-box bg-mint-dark shadow-large">
        <p><i class="fa fa-2x fa-check-circle"></i></p>
        <h4 class="color-white bold top-10">Successful</h4>
        <p class="color-white bottom-10">
            Thanks for booking with us. We've sent you an email with order details.
        </p>
    </div>
</div>
<a href="<?=$link?>" style="color: #fff;" class="button bg-highlight button-full button-round-small shadow-large button-s top-30"><?=$text?></a>
<?php
query::update("delete from booked_hours where user_id = '$u_id'");
if (isset($_SESSION['username'])) {
    query::update("delete from user_cart where user_id = '$u_id'");
} else {
    query::update("delete from temp_cart where temp_user_id = '$u_id'");
}
?>