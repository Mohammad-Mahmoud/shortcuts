<div class="page-content top-90">
    <div class="content">
        <h2 class="bolder">Order Info</h2>
        <?php

        while ($row = $items->fetch_assoc()) {
            if ($row['u_type'] == '') {
                switch ($row['b_type']) {
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
                switch ($row['u_type']) {
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
            $booked_date = query::returnSingleValue('booked_hours', 'date', 'cart_type = "' . $table . '" and cart_id = ' . $row[$table . '_cart_id']);
            $booked_hour = query::returnSingleValue('booked_hours', 'hour', 'cart_type = "' . $table . '" and cart_id = ' . $row[$table . '_cart_id']);
            $barber = query::returnSingleValue("barbers", "name", "barber_id = " . $row['barber']);
            if (!isset($_SESSION['username'])) {
                $address = $row['address'];
            } else {
                $user_id = users::getUserID();
                $add = query::returnSingleValue('user_address', 'address', 'user_id = ' . $user_id);
                $city = query::returnSingleValue('user_address', 'city', 'user_id = ' . $user_id);
                $zip = query::returnSingleValue('user_address', 'zip', 'user_id = ' . $user_id);
                $address = $add . ', ' . $zip . ' ' . $city;
            }
        ?>
            <div class="store-cart-1">
                <img class="preload-image" src="icons/<?= $row['icon'] ?>" data-src="icons/<?= $row['icon'] ?>" alt="img">
                <strong style="margin-left: 5px; color:blue;"><?= $row['name'] ?></strong>
                <strong style="font-weight:normal; font-size:11px;"><b>Service type:</b> <?= $type ?></strong>
                <strong style="font-weight:normal; font-size:11px;"><b>Barber:</b> <?= $barber ?></strong>
                <?php
                if ($type == 'Home') {
                ?>
                    <strong style="font-weight:normal; font-size:11px;"><b>Your address:</b> <?= $address ?></strong>
                <?php
                }
                ?>


                <span style="line-height: 2px; margin:0;"><b>Booked time:</b>
                    <?php
                    if ($booked_date != '') {
                        echo $booked_date . ' ' . $booked_hour;
                    } else {
                        echo 'No date booked yet';
                    }
                    ?>
                </span>

                <em style="font-size: 12px;"><?= $price ?> DKK</em>
                <div class="store-cart-qty">

                    

                </div>
                <a href="remove_from_cart.php?i=<?= $row[$id] ?>&t=<?= $table ?>&b=<?= $_GET['b'] ?>" class="store-cart-1-remove color-orange-dark ">Remove </a>
            </div>
            <div class="divider top-30"></div>
        <?php
        }
        ?>
    </div>
    <div class="content">

<div class="store-cart-total bottom-20">
    <strong class="uppercase ultrabold">Total</strong>
    <span class="uppercase ultrabold"><?= $total ?> DKK</span>
    <div class="clear"></div>
</div>
<div class="divider"></div>

<?php
if(!isset($_SESSION['username'])) {
?>
    <p id="l1" class="center-text bottom-10" style="color: red;"></p>
    <h3>Already a member?</h3>
    <b>Sign in</b>
    

    <form action="pay.php?b=<?=$_GET['b']?>" method="post" id="form1">
        <div class="input-style input-style-2 input-required">
            <span>Email</span>
            <em>(<?= lang::getKeyword('Required') ?>)</em>
            <input type="text" placeholder="" id="email" name="email">
        </div>
        <div class="input-style input-style-2 input-required">
            <span><?= lang::getKeyword('Password') ?></span>
            <em>(<?= lang::getKeyword('Required') ?>)</em>
            <input type="password" placeholder="" id="password" name="password">
        </div>
      
        <p style="line-height: 4px; margin-right:4px;">
            <a href="forgot_pass.php" class="text-right font-11  opacity-50"><?= lang::getKeyword('Forgot password?') ?></a>
        </p>
        <input type="submit" style="width:100%; height:50px;" value="Login" class="top-20 button button-s button-round-large shadow-medium bg-highlight">
        <?php
        $user = new users();
        $user->login("pay.php?b=".$_GET['b']);
        ?>
    </form>
</div>

<script>
    $("#form1").submit(function(event) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var emailaddressVal = $("#email").val();

        if ($("#password").val().length < 6) {
            $("#l1").html('<?= lang::getKeyword("Password must be at least 6 characters") ?>');
            event.preventDefault();
        }
        if ($("#email").val() === "" || $("#password").val() === "") {
            $("#l1").html("<?= lang::getKeyword('All fields are required') ?>");
            event.preventDefault();
        }
        if (!emailReg.test(emailaddressVal)) {
            $("#l1").html("<?= lang::getKeyword('Email address is not valid') ?>");
            event.preventDefault();
        }


    });
</script>

    <div class="content" id="info">

        <h2 class="bolder">Or continue as a guest</h2>
        <p id="l2" class="center-text bottom-10" style="color: red;"></p>
<form action="receipt.php" method="post" id="from2">
        <div class="one-half">

            <div class="input-style has-icon input-style-1 input-required bottom-30">

                <i class="input-icon fa fa-user"></i>

                <span>First Name</span>

                <input type="name" name="first_name" id="first_name" placeholder="First Name">

            </div>

        </div>

        <div class="one-half last-column">

            <div class="input-style has-icon input-style-1 input-required bottom-30">

                <i class="input-icon fa fa-user"></i>

                <span>Last Name</span>

                <input type="name" name="last_name" id="last_name" placeholder="Last Name">

            </div>

        </div>

        <div class="clear"></div>





        <div class="one-half ">

            <div class="input-style has-icon input-style-1 input-required bottom-30">

                <i class="input-icon fa fa-globe"></i>

                <span>Zip Code</span>

                <input type="tel" name="zip" id="zip" placeholder="Zip Code">

            </div>

        </div>

        <div class="one-half last-column">

            <div class="input-style has-icon input-style-1 input-required bottom-30">

                <i class="input-icon fa fa-map-marker"></i>

                <span>City</span>

                <input type="name" name="city" id="city" placeholder="City">

            </div>

        </div>

        <div class="clear"></div>



        <div class="input-style has-icon input-style-1 input-required bottom-30">

            <i class="input-icon fa fa-map"></i>

            <span>Full Address</span>

            <input type="name" name="address" id="address" placeholder="Full Address">

        </div>

        <div class="one-half">

            <div class="input-style has-icon input-style-1 input-required">

            <i class="input-icon fa fa-phone"></i>

            <span>Phone</span>

            <input type="tel" name="phone" id="phone" placeholder="Contact Phone Number">

            </div>
        </div>

        <div class="one-half last-column">

            <div class="input-style has-icon input-style-1 input-required">

                <i class="input-icon fa fa-envelope"></i>

                <span>Email</span>

                <input type="email" name="email1" id="email1" placeholder="Email">

            </div>
        </div>



        <div class="clear"></div>



    <input type="submit" id="but" style="width:100%; height:50px;" value="Submit" class="top-20 button button-s button-round-large shadow-medium bg-highlight">

    </div>

   
</div>
</form>
<script>
    $("#but").click(function(event) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var emailaddressVal = $("#email1").val();

        var phone = $("#phone").val(),
            intRegex = /[0-9 -()+]+$/;


        if ($("#email1").val() === "" || $("#first_name").val() === "" || $("#last_name").val() === "" ||
            $("#city").val() === "" || $("#zip").val() === "" || $("#address").val() === "" ||
            $("#phone").val() === ""
        )
        {
            $("#l2").html("<?= lang::getKeyword('All fields are required') ?>");
            event.preventDefault();
        }

        else if (!emailReg.test(emailaddressVal)) {
            $("#l2").html("<?= lang::getKeyword('Email address is not valid') ?>");
            event.preventDefault();
        }

        else if (!intRegex.test(phone)) {
            $("#l2").html("<?= lang::getKeyword('Phone number is not valid') ?>");
            event.preventDefault();
        }




    });

</script>

<?php
} else {
?>

<div class="content" id="info">

        <h2 class="bolder bottom-20">Your Info</h2>

        <p style="line-height: 5px;"><b>Name: </b><?=users::getUserData('first_name')?> <?=users::getUserData('last_name')?></p>
        <p style="line-height: 5px;"><b>Tel: </b><?=users::getUserData('phone')?></p>
        <p style="line-height: 5px;"><b>Address: </b>
        <?=query::returnSingleValue("user_address","address","main = 1 and user_id = ".users::getUserID())?>, 
        <?=query::returnSingleValue("user_address","zip","main = 1 and user_id = ".users::getUserID())?> 
        <?=query::returnSingleValue("user_address","city","main = 1 and user_id = ".users::getUserID())?>
        </p>

        


        <div class="clear"></div>



        <a href="#" onclick="location.replace('receipt.php')" style="color: #fff;" class="button bg-highlight button-full button-round-small shadow-large button-s top-30">Submit Order</a>

    </div>
<?php
}
?>

