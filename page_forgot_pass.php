<div class="top-100" style="padding:30px;">
    <h1 class=" center-text uppercase ultrabold bottom-100"><?=lang::getKeyword('Forgot password?')?></h1>
    <?php
            if(isset($_POST['email'])) {
                users::resetPassword();
            }
        ?>
    <p id="l1" class="center-text bottom-10" style="color: red;"></p>

    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <div class="input-style input-style-2 input-required">
            <span>Email</span>
            <em>(<?= lang::getKeyword('Required') ?>)</em>
            <input type="text" placeholder="" id="email" name="email">
        </div>
        
        <div class="one-half">
            <a href="login.php" class="font-11  opacity-50">Log in</a>
        </div>
        
        <input type="submit" style="width:100%; height:50px;" value="Send" class="top-20 button button-s button-round-large shadow-medium bg-highlight">
        
    </form>
</div>

<script>
    $("form").submit(function(event) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var emailaddressVal = $("#email").val();

       
        if ($("#email").val() === "" ) {
            $("#l1").html("<?= lang::getKeyword('All fields are required') ?>");
            event.preventDefault();
        }
        if (!emailReg.test(emailaddressVal)) {
            $("#l1").html("<?= lang::getKeyword('Email address is not valid') ?>");
            event.preventDefault();
        }


    });
</script>