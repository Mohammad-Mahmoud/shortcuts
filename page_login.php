<div class="top-100" style="padding:30px;">
    <h1 class=" center-text uppercase ultrabold fa-4x bottom-100">LOGIN</h1>
    <p id="l1" class="center-text bottom-10" style="color: red;"></p>

    <form action="login.php" method="post">
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
        <div class="one-half">
            <a href="signup.php" class="font-11  opacity-50">Sign Up</a>
        </div>
        <div class="one-half last-column">
            <a href="forgot_pass.php" class="text-right font-11  opacity-50"><?= lang::getKeyword('Forgot password?') ?></a>
        </div>
        <input type="submit" style="width:100%; height:50px;" value="Login" class="top-20 button button-s button-round-large shadow-medium bg-highlight">
        <?php
        $user = new users();
        $user->login();
        ?>
    </form>
</div>

<script>
    $("form").submit(function(event) {
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