<div class="content top-100">
<?php
    if(isset($_POST['first_name']) && isset($_POST['last_name'])) {
        users::updateUserInfo();
        header('Location: profile.php');
    }
  
    if(!isset($_SESSION['username'])) {
        die("You're not logged in");       
    }
    
?>
    <h3 class="bolder"><?=lang::getKeyword("Edit your profile")?></h3>
    
    <p id="l1" class="center-text bottom-10" style="color: red;"></p>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">

    <div class="input-style has-icon input-style-1 input-required">
        <span class="input-style-1-inactive"><?=lang::getKeyword("First name")?></span>
        <em>(<?= lang::getKeyword('Required') ?>)</em>
        <input type="text" placeholder="<?=lang::getKeyword("First name")?>" id="fname" name="first_name" value="<?=$user_data['first_name']?>">
    </div>

    <div class="input-style has-icon input-style-1 input-required">
        <span class="input-style-1-inactive"><?=lang::getKeyword("Last name")?></span>
        <em>(<?= lang::getKeyword('Required') ?>)</em>
        <input type="text" placeholder="<?=lang::getKeyword("Last name")?>" id="lname" name="last_name" value="<?=$user_data['last_name']?>">
    </div>

    <div class="input-style has-icon input-style-1">
        <span class="input-style-1-inactive"><?=lang::getKeyword("Phone")?></span>
        <input type="tel" placeholder="<?=lang::getKeyword("Phone")?>" id="phone" name="phone" value="<?=$user_data['phone']?>">
    </div>


    <div class="input-style input-style-1">
        <span class=""><?=lang::getKeyword("Gender")?></span>
        <select name="gender">
            <?php
            if($user_data['gender'] == 'm') {
                echo '
                <option value="m">'.lang::getKeyword("Male").'</option>
                <option value="f">'.lang::getKeyword("Female").'</option>
                <option value="">'.lang::getKeyword("Do not specify").'</option>
                ';
            } else if($user_data['gender'] == 'f') {
                echo '
                <option value="f">'.lang::getKeyword("Female").'</option>
                <option value="m">'.lang::getKeyword("Male").'</option>
                <option value="">'.lang::getKeyword("Do not specify").'</option>
                ';
            } else {
                echo '
                <option value="">'.lang::getKeyword("Do not specify").'</option>
                <option value="f">'.lang::getKeyword("Female").'</option>
                <option value="m">'.lang::getKeyword("Male").'</option>
                ';
            }
            ?>
        </select>
    </div>


    <div class="input-style input-style-1 input-required">
        <span class="input-style-1-active input-style-1-inactive"><?=lang::getKeyword("Birthdate")?></span>
        <em><i class="fa fa-angle-down"></i></em>
        <input type="date" id="birthdate" name="birthday">
    </div>

    <input type="submit" style="width:100%; height:50px;" value="<?=lang::getKeyword('Save')?>" class="top-20 button button-s button-round-large shadow-medium bg-highlight">


    </form>

    
</div>

<script>
    $(document).ready(function() {
        $('#birthdate').val("<?=$user_data['birthday']?>");
    });
</script>
<script>


    $("form").submit(function(event) {
        var phone = $("#phone").val(),
            intRegex = /[0-9 -()+]+$/;

        
        if ($("#fname").val() === "" || $("#lname").val() === "") {
            $("#l1").html("<?= lang::getKeyword('All fields are required') ?>");
            event.preventDefault();
        }
        
       else if (!intRegex.test(phone)) {
            $("#l1").html("<?= lang::getKeyword('Phone number is not valid') ?>");
            event.preventDefault();
        }

        else {
            alert('<?=lang::getKeyword("Your information has been updated")?>');
        }

    });

</script>