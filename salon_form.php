<div class="top-100" style="padding:30px;">
    <h5 class=" center-text uppercase   bottom-10"><?=lang::getKeyword("Register as barber or hair salon")?></h5>
    <p id="l1" class="center-text bottom-10" style="color: red;"></p>

    <form action="reg_salon.php" method="post">
        <div class="input-style input-style-2 input-required">
            <span><?=lang::getKeyword('Your name')?></span>
            <em>(<?= lang::getKeyword('Required') ?>)</em>
            <input type="text" placeholder="" id="name" name="name">
        </div>

        <div class="input-style input-style-2 input-required">
            <span>Email</span>
            <em>(<?= lang::getKeyword('Required') ?>)</em>
            <input type="text" placeholder="" id="email" name="email">
        </div>
        <div class="input-style input-style-2 input-required">
            <span><?=lang::getKeyword('Your address')?></span>
            <em>(<?= lang::getKeyword('Required') ?>)</em>
            <input type="text" placeholder="" id="home_address" name="home_address">
        </div>
        <div class="input-style input-style-2 input-required">
            <span><?=lang::getKeyword('Zip code')?></span>
            <em>(<?= lang::getKeyword('Required') ?>)</em>
            <input type="text" placeholder="" id="home_zip" name="home_zip">
        </div>
        <div class="input-style input-style-2 input-required">
            <span><?=lang::getKeyword('City')?></span>
            <em>(<?= lang::getKeyword('Required') ?>)</em>
            <input type="text" placeholder="" id="home_city" name="home_city">
        </div>
        <div class="input-style input-style-2 input-required">
            <span><?=lang::getKeyword('Phone')?></span>
            <em>(<?= lang::getKeyword('Required') ?>)</em>
            <input type="tel" placeholder="" id="phone" name="phone">
        </div>
        <div class="input-style input-style-1 ">
            <span class="input-style-1-inactive"><?=lang::getKeyword('Additional information')?></span>
            <textarea placeholder="<?=lang::getKeyword('Additional information')?>" name="notes" id="notes"></textarea>
        </div>
        <div class="checkboxes-demo">
            <div class="fac fac-radio fac-blue bottom-10"><span></span>
                <input id="box2-fac-radio" type="radio" name="rad" value="0" checked>
                <label for="box2-fac-radio"><?=lang::getKeyword('Self employed?')?></label>

            </div>


            <div class="fac fac-radio fac-blue bottom-10"><span></span>
                <input id="radio1" type="radio" name="rad" value="1">
                <label for="radio1"><?=lang::getKeyword('Have a hair salon?')?></label>
            </div>
            <div class="input-style input-style-2 input-required" id="s_n" style="display: none;">
                <span><?=lang::getKeyword('Salon name')?></span>
                <em>(<?= lang::getKeyword('Required') ?>)</em>
                <input type="name" placeholder="" id="salon_name" name="salon_name">
            </div>
            <div class="input-style input-style-2 input-required" style="display: none;" id="s_a">
                <span><?=lang::getKeyword('Salon address')?></span>
                <em>(<?= lang::getKeyword('Required') ?>)</em>
                <input type="name" placeholder="" id="salon_address" name="salon_address">
            </div>
            <div class="input-style input-style-2 input-required" style="display: none;" id="s_z">
                <span><?=lang::getKeyword('Zip code')?></span>
                <em>(<?= lang::getKeyword('Required') ?>)</em>
                <input type="name" placeholder="" id="salon_zip" name="salon_zip">
            </div>
            <div class="input-style input-style-2 input-required" style="display: none;" id="s_c">
                <span><?=lang::getKeyword('City')?></span>
                <em>(<?= lang::getKeyword('Required') ?>)</em>
                <input type="name" placeholder="" id="salon_city" name="salon_city">
            </div>
        </div>


        <input type="submit" style="width:100%; height:50px;" value="Send" class="top-20 button button-s button-round-large shadow-medium bg-highlight">
        <?php
            regSalon();

        ?>
    </form>
</div>

<script>
    $("form").submit(function(event) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var emailaddressVal = $("#email").val();
        var phone = $("#phone").val(),
            intRegex = /[0-9 -()+]+$/;


        if ($("#email").val() === "" || $("#name").val() === "" || $("#home_address").val() === "" ||
            $("#phone").val() === "" || $("#home_zip").val() === "" || $("#home_city").val() === "")
        {
            $("#l1").html("<?= lang::getKeyword('All fields are required') ?>");
            event.preventDefault();
        }
        if ($('#radio1').is(':checked')) {
            if ($("#salon_name").val() === "" || $("#salon_address").val() === "" || $("#salon_zip").val() === ""
                || $("#salon_city").val() === "") {
                $("#l1").html("<?= lang::getKeyword('All fields are required') ?>");
                event.preventDefault();
            }
        }
        if (!emailReg.test(emailaddressVal)) {
            $("#l1").html("<?= lang::getKeyword('Email address is not valid') ?>");
            event.preventDefault();
        }

        if (!intRegex.test(phone)) {
            $("#l1").html("<?= lang::getKeyword('Phone number is not valid') ?>");
            event.preventDefault();
        }


    });
    $('input[type=radio][name=rad]').change(function() {
        if (this.value == 0) {
            $("#s_n").css("display", "none");
            $("#s_a").css("display", "none");
            $("#s_z").css("display", "none");
            $("#s_c").css("display", "none");
        } else if (this.value == 1) {
            $("#s_n").css("display", "block");
            $("#s_a").css("display", "block");
            $("#s_z").css("display", "block");
            $("#s_c").css("display", "block");

        }
    });
</script>