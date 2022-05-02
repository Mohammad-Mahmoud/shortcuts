<div class="content top-100">
    <?php
    if (isset($_POST['old_pass']) && isset($_POST['new_pass']) && isset($_POST['renew_pass'])) {
        users::updateUserPassword();
    }

    if (!isset($_SESSION['username'])) {
        die("You're not logged in");
    }

    ?>
    <h3 class="bolder"><?= lang::getKeyword("Change password") ?></h3>

    <p id="l1" class="center-text bottom-10" style="color: red;"></p>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

        <div class="input-style input-style-2 input-required">

            <span><?= lang::getKeyword("Password") ?></span>
            <em>(<?= lang::getKeyword('Required') ?>)</em>
            <input type="password" id="old_pass" name="old_pass">
        </div>
        <div class="input-style input-style-2 input-required">
            <span><?= lang::getKeyword("New password") ?></span>
            <em>(<?= lang::getKeyword('Required') ?>)</em>
            <input type="password" id="new_pass" name="new_pass">
        </div>
        <div class="input-style input-style-2 input-required">
            <span><?= lang::getKeyword("Re-enter new password") ?></span>
            <em>(<?= lang::getKeyword('Required') ?>)</em>
            <input type="password" id="renew_pass" name="renew_pass">
        </div>






        <input type="submit" style="width:100%; height:50px;" value="<?= lang::getKeyword('Save') ?>" class="top-20 button button-s button-round-large shadow-medium bg-highlight">


    </form>


</div>


<script>
    $("form").submit(function(event) {
        var old_pass = $("#password").val();
        var new_pass = $("#new_pass").val();
        var re_new_pass = $("#renew_pass").val()
            


        if (old_pass === "" || new_pass === "" || re_new_pass === "") {
            $("#l1").html("<?= lang::getKeyword('All fields are required') ?>");
            event.preventDefault();
        } else if (new_pass !== re_new_pass) {
            $("#l1").html("<?= lang::getKeyword('Passwords did not match') ?>");
            event.preventDefault();
        } else if(new_pass.length < 6 || re_new_pass < 6) {
            $("#l1").html("<?= lang::getKeyword('Password must be at least 6 characters') ?>");
            event.preventDefault();
        }
         

    });
</script>