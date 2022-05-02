<div class="top-80" >

    <div class="page-content">

        <form action="signup.php" method="post">
        <div data-height="cover" class="caption bottom-0" style="height: 812px;">
            <div class="caption-center">

                <div class="left-50 right-50 top-60">
                    <h1 class="center-text uppercase ultrabold fa-3x">REgister</h1>
                    <p class="center-text color-highlight font-11 under-heading bottom-30">
                        Don't have an account? Register here.
                    </p>
                    <p id="l1" class="center-text" style="color: red;"></p>

                    <div class="input-style has-icon input-style-1 input-required">
                        <i class="input-icon fa fa-user font-11"></i>
                        <span class="input-style-1-inactive">First name</span>
                        <em>(<?= lang::getKeyword('Required') ?>)</em>
                        <input type="name" name="first_name" id="first_name" placeholder="First name">
                    </div>
                    <div class="input-style has-icon input-style-1 input-required">
                        <i class="input-icon fa fa-user font-11"></i>
                        <span class="input-style-1-inactive">Last name</span>
                        <em>(<?= lang::getKeyword('Required') ?>)</em>
                        <input type="name" name="last_name" id="last_name" placeholder="Last name">
                    </div>
                    <div class="input-style has-icon input-style-1 input-required">
                        <i class="input-icon fa fa-at"></i>
                        <span class="input-style-1-inactive">Email</span>
                        <em>(<?= lang::getKeyword('Required') ?>)</em>
                        <input name="email" id="email" type="email" placeholder="Email">
                    </div>
                    <div class="input-style has-icon input-style-1 input-required">
                        <i class="input-icon fa fa-phone"></i>
                        <span class="input-style-1-inactive">Phone</span>
                        <em>(<?= lang::getKeyword('Required') ?>)</em>
                        <input name="phone" id="phone" type="phone" placeholder="<?=lang::getKeyword('Phone')?>">
                    </div>
                    <div class="input-style has-icon input-style-1 input-required">
                        <i class="input-icon fa fa-lock font-11"></i>
                        <span>Password</span>
                        <em>(<?= lang::getKeyword('Required') ?>)</em>
                        <input name="password" id="password" type="password" placeholder="Choose a Password">
                    </div>
                    <div class="input-style has-icon input-style-1 input-required">
                        <i class="input-icon fa fa-lock font-11"></i>
                        <span class="input-style-1-inactive">Password</span>
                        <em>(<?= lang::getKeyword('Required') ?>)</em>
                        <input name="re_password" id="re_password" type="password" placeholder="Confirm your Password">
                    </div>
                    <div class="input-style input-style-1 input-required">
                        <span class="input-style-1-active input-style-1-inactive"><?=lang::getKeyword("Birthdate")?> (<?= lang::getKeyword('Required') ?>)</span>
                        <em><i class="fa fa-angle-down"></i></em>
                        <input type="date" id="birthdate" name="birthday">
                    </div>
                    <div class="top-20 bottom-20">
                        <a href="login.php"  class="center-text font-11 color-gray2-dark">Already Registered? Sign In Here.</a>
                    </div>
                    <div class="clear"></div>
                    <input type="submit" style="width:100%; height:50px;" value="Sign up" class="top-20 button button-s button-round-large shadow-medium bg-highlight">
                </div>
                <?php regUser(); ?>


            </div>
        </div>

        </form>


    </div>

</div>

<script>
    function diff_years(dt2, dt1)
    {
        var diff =(dt2.getTime() - dt1.getTime()) / 1000;
        diff /= (60 * 60 * 24);
        return Math.round(diff/365.25);
    }
    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();
    var output = d.getFullYear() + '-' +
        (month<10 ? '0' : '') + month + '-' +
        (day<10 ? '0' : '') + day;



    $("form").submit(function(event) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var emailaddressVal = $("#email").val();
        dt1 = new Date(output.toString());
        dt2 = new Date($('#birthdate').val());

        var phone = $("#phone").val(),
            intRegex = /[0-9 -()+]+$/;


        if ($("#email").val() === "" || $("#first_name").val() === "" || $("#last_name").val() === "" ||
            $("#password").val() === "" || $("#re_password").val() === "" || $("#birthdate").val() === "" ||
            $("#phone").val() === ""
        )
        {
            $("#l1").html("<?= lang::getKeyword('All fields are required') ?>");
            event.preventDefault();
        }

        else if (!emailReg.test(emailaddressVal)) {
            $("#l1").html("<?= lang::getKeyword('Email address is not valid') ?>");
            event.preventDefault();
        }
        else if($("#password").val().length < 6) {
            $("#l1").html("Password must be at least 6 characters");
            event.preventDefault();
        }
       else if($("#password").val() !== $("#re_password").val()) {
            $("#l1").html("Passwords do not match");
            event.preventDefault();
        }
        else if(diff_years(dt1,dt2) < 16 ) {
            $("#l1").html("You must be at least 16 years old");
            event.preventDefault();
        }
        else if (!intRegex.test(phone)) {
            $("#l1").html("<?= lang::getKeyword('Phone number is not valid') ?>");
            event.preventDefault();
        }




    });

</script>