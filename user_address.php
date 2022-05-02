<div class="content top-100">
    <div class="content accordion-style-1 accordion-round-medium">
        <a href="add_new_address.php" class="round-tiny shadow-medium bg-facebook top-30 bottom-30">+ <?=lang::getKeyword('Add new address')?></a>
        <h2 class="center-text ultrabold font-700"><?=lang::getKeyword('My addresses')?></h2>
        <?php
        $count = 0;
        while($row = $address->fetch_assoc()){
            $count++;
            if($row['main'] == 1) {
                $primary = lang::getKeyword('Primary');
            } else {
                $primary =  '';
            }
        ?>

        <a data-accordion="accordion-content-<?=$count?>" href="#" class="bg-highlight">
            <?=$row['name']?>
            <span style="color:yellow; margin-left:10px;"><?=$primary?></span>
            <i class="accordion-icon-right fa fa-angle-down"></i>
        </a>
        <div id="accordion-content-<?=$count?>" class="accordion-content bottom-10" style="background-color:#E4E4F8;">
            <div style="padding:20px;">
            <span><?=$row['address']?></span>
            <br>
            <span><?=$row['zip']?> <?=$row['city']?></span>
            <br>
            <a href="edit_address.php?i=<?=$row['user_address_id']?>" style="color: blue;"><?=lang::getKeyword('Edit')?></a>
            </div>
        </div>
        <?php
        }
        ?>

        
    </div>

</div>