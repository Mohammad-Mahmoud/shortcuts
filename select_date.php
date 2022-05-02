<div class="page-content top-90">
<div id="warning" class="alert alert-small alert-round-medium bg-yellow1-dark" style="display:none;">
                <i class="fa fa-exclamation-triangle" ></i>
                <span>You need to book date first</span>
                <i class="fa fa-times" style="color:black;"></i>
</div>
    <div class="content">
    <?php
    if($cart_count != 0) {
    while($row = $items->fetch_assoc()) {
        if($row['u_type'] == '') {
            switch($row['b_type']) {
                case 'home':
                    $type = 'Home';
                    $g_type = 'home';
                    $price = $row['price_home'];
                break;
                case 'salon':
                    $type = 'Salon';
                    $g_type = 'salon';
                    $price = $row['price_salon'];
                break;
            }
        } else {
            switch($row['u_type']) {
                case 'home':
                    $type = 'Home';
                    $g_type = 'home';
                    $price = $row['price_home'];
                break;
                case 'salon':
                    $type = 'Salon';
                    $g_type = 'salon';
                    $price = $row['price_salon'];
                break;
            }
        }
        $total += $price;
        $booked_date = query::returnSingleValue('booked_hours','date','cart_type = "'.$table.'" and cart_id = '.$row[$table.'_cart_id']);
        $booked_hour = query::returnSingleValue('booked_hours','hour','cart_type = "'.$table.'" and cart_id = '.$row[$table.'_cart_id']);
        $barber = query::returnSingleValue("barbers","name","barber_id = ".$row['barber']);
        if(!isset($_SESSION['username'])){
            $address = $row['address'];
        } else {
            $user_id = users::getUserID();
            $add = query::returnSingleValue('user_address','address','user_id = '.$user_id);
            $city = query::returnSingleValue('user_address','city','user_id = '.$user_id);
            $zip = query::returnSingleValue('user_address','zip','user_id = '.$user_id);
            $address = $add.', '.$zip.' '.$city;
        }
    ?>
        <div class="store-cart-1">
            <img class="preload-image" src="icons/<?=$row['icon']?>" data-src="icons/<?=$row['icon']?>" alt="img">
            <strong style="margin-left: 5px; color:blue;"><?=$row['name']?></strong>
            <strong style="font-weight:normal; font-size:11px;"><b>Service type:</b> <?=$type?></strong>
            <strong style="font-weight:normal; font-size:11px;"><b>Barber:</b> <?=$barber?></strong>
            <?php 
            if($type == 'Home') {
            ?>
            <strong style="font-weight:normal; font-size:11px;"><b>Your address:</b> <?=$address?></strong>
            <?php
            }
            ?>


            <span style="line-height: 2px; margin:0;"><b>Booked time:</b> 
            <?php
                if($booked_date != '') {
                    echo $booked_date.' '.$booked_hour;

                } else {
                    echo 'No date booked yet';
                }
            ?>
            </span>
            
            <em style="font-size: 12px;"><?=$price?> DKK</em>
            <div class="store-cart-qty">
            
                <a target="_blank" href="booking.php?i=<?=$row['barb_ser_id']?>&type=<?=$g_type?>&b=<?=$row['barber']?>&c=<?=$row[$id]?>">
               
               <?php echo  $booked_date !='' ? 'Change date' : 'Choose date'; ?>

                </a>
               

            </div>
            <a href="remove_from_cart.php?i=<?=$row[$id]?>&t=<?=$table?>&b=<?=$_GET['b']?>" class="store-cart-1-remove color-orange-dark ">Remove </a>
        </div>
        <div class="divider top-30"></div>
        <?php
        }
        ?>
    </div>

    <div class="content">
            
            <div class="store-cart-total bottom-20">
                <strong class="uppercase ultrabold">Total</strong>
                <span class="uppercase ultrabold"><?=$total?> DKK</span>
                <div class="clear"></div>
            </div>
            <div class="divider"></div>
            <a href="#" id="proc" class="button bg-highlight button-round-small shadow-large button-full button-s">Proceed to Checkout</a>
        </div>
    </div>
<?php
} else {
        ?>
<div class="alert alert-small alert-round-medium bg-yellow1-dark" >
    <i class="fa fa-exclamation-triangle" ></i>
    <span>Your cart is empty</span>
    <i class="fa fa-times" style="color:black;"></i>
</div>
<?php
}
?>
<script>
    $("#proc").click(function() {
        if(<?=$booked_date_count?> === 0) {
            $("#warning").css("display","block");
            return false;
        }
        if(<?=$booked_date_count?> !== <?=$cart_items?>) {
            if(confirm('You did not book date for all your items! continue anyway?')) {
                location.replace("pay.php?b=<?=$_GET['b']?>");
            } else {
                return false;
            }
        } else {
            location.replace("pay.php?b=<?=$_GET['b']?>");
        }
    })
</script>
