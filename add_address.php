<div class="content top-100">
    <?php

    if (!isset($_SESSION['username'])) {
        die("You're not logged in");
    }

    ?>
    <h3 class="bolder"><?= lang::getKeyword("Add a new address") ?></h3>

    <p id="l1" class="center-text bottom-10" style="color: red;"></p>
    <form action="add_user_address.php" method="post">

    
        <div class="input-style has-icon input-style-1 input-required">
            <span class="input-style-1-inactive"><?=lang::getKeyword("Title")?></span>
            <em>(<?= lang::getKeyword('Required') ?>)</em>
            <input type="text" placeholder="<?= lang::getKeyword("Title") ?>" id="name" name="name" value="<?=lang::getKeyword("My new address")?>">
        </div>
        
        <div class="input-style has-icon input-style-1 input-required">
            <span class="input-style-1-inactive"><?= lang::getKeyword("Address") ?></span>
            <em>(<?= lang::getKeyword('Required') ?>)</em>
            <input type="text" placeholder="<?= lang::getKeyword("Address") ?>" id="address" name="address" ">
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

        <div class="fac fac-checkbox fac-default"><span></span>
            <input id="box1-fac-checkbox" type="checkbox" name="main" value="1">
            <label for="box1-fac-checkbox"><?= lang::getKeyword('Make primary') ?></label>
        </div>

        <input type="submit" style="width:100%; height:50px;" value="<?= lang::getKeyword('Add') ?>" class="top-20 button button-s button-round-large shadow-medium bg-highlight">


    </form>


</div>


<script>
    $("form").submit(function(event) {
        var zip = $("#zip").val(),
            intRegex = /[0-9]+$/;


        if ($("#address").val() === "" || $("#city").val() === "" || $("#zip").val() === "" || $("#name").val() === "") {
            $("#l1").html("<?= lang::getKeyword('All fields are required') ?>");
            event.preventDefault();
        } else if (!intRegex.test(zip) || zip.length != 4) {
            $("#l1").html("<?= lang::getKeyword('Zip code is not valid') ?>");
            event.preventDefault();
        } else {
            alert('<?= lang::getKeyword("The address has been added") ?>');
        }


    });
</script>