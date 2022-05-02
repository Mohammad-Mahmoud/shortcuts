<script>
    var allow = 0;
    var is_address = 0;
    var duration_ar = [];
    var hidden_ar = [];
    var u_address = '';

    function getLocation() {

        navigator.geolocation.getCurrentPosition(geoSuccess, geoError);


    }

    var geoSuccess = function(position) {

        const origin1 = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

        const service = new google.maps.DistanceMatrixService();

        const latlng = {lat: position.coords.latitude, lng: position.coords.longitude}


        const matrixOptions = {
            origins: [origin1], // technician locations
            destinations: ["<?= $address ?>"], // customer address
            travelMode: 'DRIVING',
            unitSystem: google.maps.UnitSystem.METRIC
        };
        //console.log(pos);
        // Call Distance Matrix service

        service.getDistanceMatrix(matrixOptions, callback);

        // Callback function used to process Distance Matrix response
        function callback(response, status) {
            if (status !== "OK") {
                alert("Error with distance matrix");
                return;
            }
            var dis = Math.round(response.rows[0].elements[0].distance.value / 1000);
            var t_duration = Math.round(response.rows[0].elements[0].duration.value / 60);

            if (dis > <?= $radius ?>) {
                $("#stat").css("color", "red");
                $("#stat").html('You are ' + dis + ' KM away from the barber, the barber only offer <?= $radius ?> KM radius for home cut, this service is not availble from your location');
                $("#adrs_btn").css("display", "block");


            } else {
                new google.maps.Geocoder().geocode({location: latlng}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        $("#stat1").html
                        ('<span style="color:#000;">Your address:</span> <br> <span style="font-weigh:bold; font-size:14px;">' + results[0].formatted_address + '</span><br><span style="color:#000;"></span>');
                        $("#stat2").html(
                            '<span style="color:#000;">If your address is not correct please enter your address here</span>'
                        )
                        $("#other_address").val(results[0].formatted_address);

                    }
                });
                $("#stat").html('You are ' + dis + ' KM away from the barber, the barber  offer <?= $radius ?> KM radius for home cut, this service is available for you');

                $("#stat").css("color", "green");
                //$("[id^=check]").remove();
                //$("[id^=allow]").html("Service available");
                $("#adrs_btn").css("display", "block");
                $("#save_address").css("display", "block");

                
                //allow = 1;
                $("#dur").val(t_duration)


            }


            //console.log(response);   
        }



    };


    var geoError = function(error) {

        // The user didn't accept the callout
        $("#stat").css("color", "red");
        $("#stat").html("You need to allow us to use your location, so we can determine if the service is available for you, or you can enter your address here");
        $("#new_address").css("display", "block");

    };
</script>

<div class="page-content top-90">
<div id="warning" class="alert alert-small alert-round-medium bg-yellow1-dark" style="display:none;">
                <i class="fa fa-exclamation-triangle" ></i>
                <span>Please Choose at least one service</span>
                <i class="fa fa-times" style="color:black;"></i>
</div> 

<div id="warning1" class="alert alert-small alert-round-medium bg-yellow1-dark" style="display:none;">
                <i class="fa fa-exclamation-triangle"></i>
                <span>You need to check home service before proccesing</span>
                <i class="fa fa-times" style="color:black;"></i>
</div>   




    <div class="content">
        <?php
        $ad = implode('", "', array_map(function ($entry) {
            return $entry[0] . ', ' . $entry[1] . ', ' . $entry[2];
        }, $address_ar));

        $ad1 = '"' . $ad . '"';


        ?>
        <div class="divider divider-margins bottom-20"></div>

        <div class="content" id="ser">
            <h5>Select Service</h5>
            <div class="divider divider-margins bottom-20"></div>
            <?php
            while ($row = $services->fetch_assoc()) {
                switch ($row['type']) {
                    case 'salon':
                        $status = 'Only offer salon service';
                        $display = "display:none;";
                        $hid = '';
                        break;
                    case 'home':
                        $status = 'only offer home service';
                        $display = "display:block;";
                        break;
                        $hid = 'home';
                    default:
                        $status = '';
                        $display = "display:none;";
                        $hid = '';
                }

            ?>
                <script>
                    $(function() {


                        $("#mycheckbox<?= $row['barb_ser_id'] ?>").change(function() {
                            if (this.checked) {
                                <?php
                                if ($row['type'] == 'home') {
                                ?>
                                    $("#hid<?= $row['barb_ser_id'] ?>").val("home");
                                    hidden_ar.push('home');
                                    //console.log('hid<?= $row['barb_ser_id'] ?>= ' + $("#hid<?= $row['barb_ser_id'] ?>").val());
                                <?php
                                }
                                ?>
                                $("#s<?= $row['barb_ser_id'] ?>").css("display", "block");
                                if ($('#salon<?= $row['barb_ser_id'] ?>').is(':checked')) {
                                    var cur_total = Number($("#total").html());
                                    var val = Number($("#price_salon<?= $row['barb_ser_id'] ?>").html());
                                    $("#total").html(cur_total + val);
                                } else if ($('#home<?= $row['barb_ser_id'] ?>').is(':checked')) {
                                    var cur_total = Number($("#total").html());
                                    var val = Number($("#price_home<?= $row['barb_ser_id'] ?>").html());
                                    $("#total").html(cur_total + val);
                                } else {
                                    var cur_total = Number($("#total").html());
                                    var val = Number($("#c_price<?= $row['barb_ser_id'] ?>").html());
                                    $("#total").html(cur_total + val);
                                }

                            }
                            if (this.checked == false) {

                                $("#hid<?= $row['barb_ser_id'] ?>").val("");
                                hidden_ar.pop();

                                $("#s<?= $row['barb_ser_id'] ?>").css("display", "none");

                                if ($('#salon<?= $row['barb_ser_id'] ?>').is(':checked')) {
                                    var cur_total = Number($("#total").html());
                                    var val = Number($("#price_salon<?= $row['barb_ser_id'] ?>").html());
                                    $("#total").html(cur_total - val);
                                } else if ($('#home<?= $row['barb_ser_id'] ?>').is(':checked')) {
                                    var cur_total = Number($("#total").html());
                                    var val = Number($("#price_home<?= $row['barb_ser_id'] ?>").html());
                                    $("#total").html(cur_total - val);
                                } else {
                                    var cur_total = Number($("#total").html());
                                    var val = Number($("#c_price<?= $row['barb_ser_id'] ?>").html());
                                    $("#total").html(cur_total - val);
                                }

                                $("#home<?= $row['barb_ser_id'] ?>").prop("checked", false);
                                $("#salon<?= $row['barb_ser_id'] ?>").prop("checked", true);

                            }
                        });

                        $('input[type=radio][name=ser<?= $row['barb_ser_id'] ?>]').change(function() {
                            if (this.value == 'salon') {
                                var cur_total = Number($("#total").html());
                                $("#radius<?= $row['barb_ser_id'] ?>").css("display", "none");
                                var val_s = Number($("#price_salon<?= $row['barb_ser_id'] ?>").html());
                                var val_h = Number($("#price_home<?= $row['barb_ser_id'] ?>").html());
                                $("#total").html((cur_total - val_h) + val_s);
                            }
                            else if (this.value == 'home') {
                                $("#radius<?= $row['barb_ser_id'] ?>").css("display", "block");
                                var val_s = Number($("#price_salon<?= $row['barb_ser_id'] ?>").html());
                                var val_h = Number($("#price_home<?= $row['barb_ser_id'] ?>").html());
                                var cur_total = Number($("#total").html());
                                $("#total").html((cur_total - val_s) + val_h);
                            }
                        });


                    })
                </script>
                <form method="post">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="c<?= $row['barb_ser_id'] ?>" id="mycheckbox<?= $row['barb_ser_id'] ?>" value="<?= $row['barb_ser_id'] ?>">
                            <strong><?= $row['name'] ?></strong>
                        </label>
                    </div>


                    <div class="store-slide-2" id="s<?= $row['barb_ser_id'] ?>" style="display: none;">

                        <a href="#" class="store-slide-image">

                            <img src="icons/<?= $row['icon'] ?>">

                        </a>


                        <div class="store-slide-title">

                            <em class="color-gray-dark"><?= $row['description'] ?></em>

                        </div>

                        <div class="store-slide-button">
                            <?php
                            if ($row['type'] == 'both') {
                            ?>

                                <div class="radio">
                                    <label>
                                        <input type="radio" id="salon<?= $row['barb_ser_id'] ?>" value="salon" name="ser<?= $row['barb_ser_id'] ?>" checked>
                                        <b>Salon: </b> <span id="price_salon<?= $row['barb_ser_id'] ?>"><?= $row['price_salon'] ?></span> DKK
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" value="home" id="home<?= $row['barb_ser_id'] ?>" name="ser<?= $row['barb_ser_id'] ?>">
                                        <b> Home: </b><span id="price_home<?= $row['barb_ser_id'] ?>"><?= $row['price_home'] ?></span> DKK
                                    </label>
                                </div>


                            <?php
                            } else {
                            ?>
                                <p style="margin-bottom: 3px; color:black;"><b>Price: </b><span id="c_price<?= $row['barb_ser_id'] ?>"><?= $row['price_' . $row['type']] ?></span> DKK</p>
                                <input class="h_con" type="hidden" id="hid<?= $row['barb_ser_id'] ?>" vlaue="">
                            <?php
                            }
                            ?>
                            <p style="margin-bottom: 3px; color:black;"><b>Duration: </b><?= $row['dur'] ?> Minuets</p>
                            <p style="margin-bottom: 3px; color:brown;"><?= $status ?></p>
                            <?php
                            if ($row['type'] != 'salon') {
                            ?>

                                <div id="radius<?= $row['barb_ser_id'] ?>" style="<?= $display ?>">
                                    <p style="margin-bottom: 3px; color:black;"><b>Radius: </b><?= $radius ?> KM</p>
                                    <p style="margin-bottom: 3px;">
                                        <span id="allow" style="color:green;"></span>
                                        <?php
                                        if (!isset($_SESSION['username'])) {
                                        ?>
                                            <a style="font-weight: bold; font-size:14px; color:blue;" id="check<?= $row['barb_ser_id'] ?>" href="#" data-menu="menu-share-thumbs"> Check availablity</a>
                                        <?php
                                        } else {
                                        ?>
                                            <a style="font-weight: bold; font-size:14px; color:blue;" id="get_address" href="#" data-menu="menu-share-thumbs1"> Check</a>
                                        <?php
                                        }
                                        ?>


                                    </p>
                                </div>
                            <?php
                            }
                            ?>



                        </div>

                    </div>


                <?php
            }
                ?>

        </div>




    </div>



    <div class="content">


        <div class="store-cart-total bottom-20">
            <strong class="uppercase ultrabold"> Total</strong>
            <span class="uppercase ultrabold" id="total">0</span>
            <span>DKK&nbsp;</span>
            <div class="clear"></div>
        </div>
        <div class="divider"></div>
        <a href="#" id="next" class="button bg-highlight button-round-small shadow-large button-full button-s">Proceed to Checkout</a>
    </div>
</div>
<input type="hidden" id="other_address" name="other_address" value="">
<input type="hidden" name="selected_address" id="selected_address" value="">
<input type="hidden" name="dur" id="dur" value="">


</form>






<div id="menu-share-thumbs" class="menu menu-box-modal round-medium" data-menu-height="610" data-menu-width="90%" data-menu-effect="menu-over">
    <h1 class="center-text uppercase ultrabold top-30 bottom-10">Checking distance </h1>
    <p class="" id="stat" style="font-weight: bold; padding:10px; margin-bottom:0;"></p>
    <div class="divider divider-margins" style="margin-bottom:0 ;"></div>
    <p class="" id="stat1" style="font-weight: bold; padding:10px; color:darkblue; margin-bottom:10px;"></p>
    
    <p id="save_address" style=" text-align:center; display:none;">
        <input type="button" id="save_adrs" style="width:70%; height:50px;" value="Save this address" class="close-menu button button-s button-round-large shadow-medium bg-highlight">
    </p>
    <div class="divider divider-margins" style="margin-bottom:0 ;"></div>

    <p class="" id="stat2" style="font-weight: bold; padding:10px;"></p>
    
    <p id="adrs_btn" style="display: none; text-align:center;">
        <input type="button" id="choose" style="width:70%; height:50px;" value="Choose another address" class=" button button-s button-round-large shadow-medium bg-highlight">
    </p>
    <div id="new_address" style="display: none; padding:10px;">
        <div class="input-style has-icon input-style-1 input-required">
            <span class="input-style-1-inactive"><?= lang::getKeyword("Address") ?></span>
            <em>(<?= lang::getKeyword('Required') ?>)</em>
            <input type="text" placeholder="<?= lang::getKeyword("Address") ?>" id="address" name="address">
        </div>

        <div class=" input-style has-icon input-style-1 input-required">
            <span class="input-style-1-inactive"><?= lang::getKeyword("City") ?></span>
            <em>(<?= lang::getKeyword('Required') ?>)</em>
            <input type="text" placeholder="<?= lang::getKeyword("City") ?>" id="city" name="city">
        </div>

        <div class="input-style has-icon input-style-1">
            <span class="input-style-1-inactive"><?= lang::getKeyword("Zip code") ?></span>
            <em>(<?= lang::getKeyword('Required') ?>)</em>
            <input type="tel" placeholder="<?= lang::getKeyword("Zip code") ?>" id="zip" name="zip">
        </div>

        <input type="button" id="chck_adrs" style="width:100%; height:50px;" value="Check" class="top-20 button button-s button-round-large shadow-medium bg-highlight">


    </div>

    <div class="clear"></div>
    <a href="#" id="back" class="close-menu button button-center-medium button-s button-round-small bg-green color-black"></a>

</div>
<?php
if (isset($_SESSION['username'])) {
?>

    <div id="menu-share-thumbs1" class="menu menu-box-modal round-medium" data-menu-height="410" data-menu-width="90%" data-menu-effect="menu-over">
        <h1 class="center-text uppercase ultrabold top-30 bottom-10">Checking your addresses </h1>
        <p class="boxed-text-large under-heading bottom-40 " id="stat" style="font-weight: bold;"></p>

        <div id="new_address" style="padding:20px;">

            <div class="checkboxes-demo">
                <p id="hhh"></p>
                <?php
                $count = -1;
                while ($row = $user_address->fetch_assoc()) {
                    $count++;
                ?>
                    <div id="rad_c<?= $count ?>" class=""><span></span>
                        <input type="radio" id="adrs<?= $count ?>" name="user_adrs" value="<?= $row['user_address_id'] ?>">
                        <label for="adrs<?= $count ?>"><?= $row['address'] . ', ' . $row['zip'] . ' ' . $row['city'] ?><span id="ava<?= $count ?>"></span></label>
                    </div>
                    <script>
                        $("#adrs<?= $count ?>").click(function() {
                            $("#selected_address").val($(this).val());
                            $("#dur").val(duration_ar[<?= $count ?>]);
                        })
                    </script>

                <?php
                }
                ?>

            </div>

            <input type="button" id="select" style="width:100%; height:50px;" value="Choose" class="close-menu top-20 button button-s button-round-large shadow-medium bg-highlight">


        </div>

        <div class="clear"></div>
        <a href="#" id="back1" class="close-menu button button-center-medium button-s button-round-small bg-green color-black">Go Back</a>

    </div>
<?php
}
?>


<div class="menu-hider"></div>



<script>
    $("[id^=check]").click(function() {
        getLocation();
    });

    $("#back").click(function() {
        $("#new_address").css("display", "none");
    });

    $("#choose").click(function() {
        $("#new_address").css("display", "block");
        $("#adrs_btn").css("display", "none");
        $("#save_address").css("display", "none");
        $("#stat").html("");

    });

    $("#chck_adrs").click(function() {

        const adrs = $("#address").val();
        const zip = $("#zip").val();
        const city = $("#city").val();

        const address = '"' + adrs + ', ' + zip + ', ' + city + '"';
        const other_address = adrs + ', ' + zip + ', ' + city;

        const service = new google.maps.DistanceMatrixService();
        const origin1 = new google.maps.LatLng(address);

        const matrixOptions = {
            origins: [address], // technician locations
            destinations: ["<?= $address ?>"], // customer address
            travelMode: 'DRIVING',
            unitSystem: google.maps.UnitSystem.METRIC
        };
        //console.log(pos);
        // Call Distance Matrix service

        service.getDistanceMatrix(matrixOptions, callback);

        // Callback function used to process Distance Matrix response
        function callback(response, status) {
            if (status !== "OK") {
                alert("Error with distance matrix");
                return;
            }
            //console.log(response);

            var distance = Math.round(response.rows[0].elements[0].distance.value / 1000);
            var dur = Math.round(response.rows[0].elements[0].duration.value / 60);


            if (distance > <?= $radius ?>) {
                $("#stat").css("color", "red");
                $("#stat").html('You are ' + distance + ' KM away from the barber, the barber only offer <?= $radius ?> KM radius for home cut');
                $("#adrs_btn").css("display", "block");
                $("#new_address").css("display", "none");


            } else {
                $("#stat").css("color", "green");
                $("#stat").html('You are ' + distance + ' KM away from the barber, the barber  offer <?= $radius ?> KM radius for home cut, this service is available for you');
                $("#new_address").css("display", "none");
                $("[id^=check]").remove();
                $("[id^=allow]").html("Service available");
                allow = 1;
                is_address = 1;
                $("#other_address").val(other_address);
                $("#dur").val(dur);
                $("#stat1").html("<span style='color:#000;'> Selected address</span><br>" + other_address);
                $("#stat2").css("display", "none");
                $("#save_address").css("display", "block");
            }
        }

    });



    $("[id^=get_address]").click(function() {



        const address = [<?= $ad1 ?>];


        const service = new google.maps.DistanceMatrixService();

        const matrixOptions = {
            origins: address, // technician locations
            destinations: ["<?= $address ?>"], // customer address
            travelMode: 'DRIVING',
            unitSystem: google.maps.UnitSystem.METRIC
        };
        //console.log(pos);
        // Call Distance Matrix service

        service.getDistanceMatrix(matrixOptions, callback);

        // Callback function used to process Distance Matrix response
        function callback(response, status) {
            if (status !== "OK") {
                alert("Error with distance matrix");
                return;
            }
            //console.log(response);
            //console.log(response.rows[2].elements[0].distance.value);

            var distance = [];
            var duration = [];

            var min = [];



            for (i = 0; i <= response.rows.length - 1; i++) {
                //console.log(i);

                distance[i] = Math.round(response.rows[i].elements[0].distance.value / 1000);
                duration[i] = Math.round(response.rows[i].elements[0].duration.value / 60);

                duration_ar.push(duration[i]);

                if (distance[i] > <?= $radius ?>) {
                    $("#ava" + [i]).html(" Not Available (" + distance[i] + " KM)");
                    $("#adrs" + [i]).prop("disabled", "true");
                    $("#rad_c" + [i]).addClass("fac fac-radio fac-red");
                    $("#ava" + [i]).css("color", "red");



                } else {
                    var close = distance[i] / <?= $radius ?>;
                    min.push(close);
                    if (Math.min.apply(Math, min) === close) {
                        $("#adrs" + [i]).prop("checked", true);
                        $("#selected_address").val($("#adrs" + [i]).val());
                    }
                    $("#rad_c" + [i]).addClass("fac fac-radio fac-green");


                    $("#ava" + [i]).html(" Available (" + distance[i] + " KM)");
                    $("#ava" + [i]).css("color", "green");

                }
                var min_dur = Math.min.apply(Math, duration_ar);

                $("#dur").val(min_dur);

            }


            var green_items = $('.fac-green').length;
            if (green_items > 0) {

                $("#select").css("display", "block");
                $("#back1").css("display", "none");

            } else {
                $("#select").css("display", "none");
            }

            console.log($("#selected_address").val());
            console.log($("#dur").val());




        }

    });

   


    $("#next").click(function() {

        


        var total = $('[id^=mycheckbox]:checked').length;
        var home = hidden_ar.includes('home');

       


        if (total === 0) {
            $('#warning').css('display','block');
            //event.preventDefault();
            return false;
        }
       
       if(home == true && total > 0 && allow === 0) {
        $('#warning1').css('display','block');
            //event.preventDefault();
            return false;
        }

        

        if ($('[id^=home]').is(':checked')  && total > 0 && allow === 0) {
            $('#warning1').css('display','block');
            //event.preventDefault();
            return false;
        }
        /* if (total > 0 && $('[id^=hid]').val() === 'home' && allow === 0) {
             alert("You need to check home service before proccesing");
             //event.preventDefault();
             return false;
         }*/


        <?php
        if (in_array("home", $service_ar) || in_array("both", $service_ar)) {
        ?>
            if (is_address === 0 && allow === 1) {
                if ($('[id^=home]').is(':checked') || home == true) {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            var lat = position.coords.latitude;
                            var lng = position.coords.longitude;
                            $("form").attr("action", "book.php?lat=" + lat + "&lng=" + lng + "&b=<?= $_GET['b'] ?>");
                            $("form").submit();
                        })

                    }
                }
            } else {
                $("form").attr("action", "book.php?b=<?= $_GET['b'] ?>");
                $("form").submit();
            }
        <?php
        } else {
        ?>

            $("form").attr("action", "book.php?b=<?= $_GET['b'] ?>");
            $("form").submit();
        <?php
        }
        ?>



    })


    $("#select").click(function() {

        allow = 1;
        is_address = 1;
        $("[id^=get_address]").remove();
        $("[id^=allow]").html("Service available");


    })

    $("#save_adrs").click(function(){
        $("[id^=check]").remove();
        $("[id^=allow]").html("Service available");
        allow = 1;

    })
</script>

