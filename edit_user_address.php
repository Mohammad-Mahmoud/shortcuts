<div class="content top-100" >
<?php
    if(isset($_POST['address']) && isset($_POST['city']) && isset($_POST['zip'])  && isset($_POST['name'])) {
        users::updateUserAddress();

        header('Location: address.php');
    }
  
    if(!isset($_SESSION['username'])) {
        die("You're not logged in");       
    }
    
?>
    <h3 class="bolder"><?=lang::getKeyword("Edit your address")?></h3>
    
    <p id="l1" class="center-text bottom-10" style="color: red;"></p>
    <form action="<?=$_SERVER['PHP_SELF']?>?i=<?=$_GET['i']?>" method="post">

    <div class="input-style has-icon input-style-1 input-required">
        <span class="input-style-1-inactive"><?=lang::getKeyword("Title")?></span>
        <em>(<?= lang::getKeyword('Required') ?>)</em>
        <input type="text" placeholder="<?=lang::getKeyword("Title")?>" id="name" name="name" value="<?=$address_data['name']?>">
    </div>

    <div class="input-style has-icon input-style-1 input-required">
        <span class="input-style-1-inactive"><?=lang::getKeyword("Address")?></span>
        <em>(<?= lang::getKeyword('Required') ?>)</em>
        <input type="text" placeholder="<?=lang::getKeyword("Address")?>" id="address" name="address" value="<?=$address_data['address']?>">
    </div>

    <div class="input-style has-icon input-style-1 input-required">
        <span class="input-style-1-inactive"><?=lang::getKeyword("City")?></span>
        <em>(<?= lang::getKeyword('Required') ?>)</em>
        <input type="text" placeholder="<?=lang::getKeyword("City")?>" id="city" name="city" value="<?=$address_data['city']?>">
    </div>

    <div class="input-style has-icon input-style-1">
        <span class="input-style-1-inactive"><?=lang::getKeyword("Zip code")?></span>
        <em>(<?= lang::getKeyword('Required') ?>)</em>  
        <input type="tel" placeholder="<?=lang::getKeyword("Zip code")?>" id="zip" name="zip" value="<?=$address_data['zip']?>">
    </div>
    <?php
        if($address_data['main'] == 0) {
    ?>
    <div class="fac fac-checkbox fac-default"><span></span>
            <input id="box1-fac-checkbox" type="checkbox" name="main" value="1">
            <label for="box1-fac-checkbox"><?= lang::getKeyword('Make primary') ?></label>
    </div>
    <?php
        }
    ?>  


    


    <input type="submit" style="width:100%; height:50px;" value="<?=lang::getKeyword('Save')?>" class="top-20 button button-s button-round-large shadow-medium bg-highlight">


    </form>

    
</div>


<script> 
    $("form").submit(function(event) {
        var zip = $("#zip").val(),
            intRegex = /[0-9]+$/;

        
        if ($("#address").val() === "" || $("#city").val() === "" || $("#zip").val() === "" || $("#name").val() === "") {
            $("#l1").html("<?= lang::getKeyword('All fields are required') ?>");
            event.preventDefault();
        }
        
        else if (!intRegex.test(zip) || zip.length != 4) {
            $("#l1").html("<?= lang::getKeyword('Zip code is not valid') ?>");
            event.preventDefault();
        }

       else {
           alert('<?=lang::getKeyword("Address has been updated")?>');
       }


    });
</script>