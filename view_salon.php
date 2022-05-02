<div class="content top-100">


    <div class="profile-header" style="margin-top:20px;">

        <div class="profile-left">

            <b><?= $salon_data['name'] ?></b>
            <div class="review-stars">

                <span>

                    <?php
                    for($i=0; $i<$review; $i++){
                    ?>
                    <i class="fa fa-star color-yellow1-dark"></i>
                    <?php
                    }
                    for($i=0; $i<5-$review; $i++){
                    ?>
                    <i class="far fa-star"></i>
                    <?php
                    }
                    ?>

                </span>

            </div>

            <p>
                <?= $salon_data['address'] ?>
            </p>
            <p>
                <a href="reviews.php?i=<?=$_GET['i']?>">View reviews</a>
            </p>
        </div>
        <?php
        if ($salon_data['logo'] != '') {
        ?>

            <div class="profile-right">

                <a href="#"><img src="img/<?= $salon_data['logo'] ?>"></a>
            </div>

    </div>
<?php
        } else {

?>
    <div class="profile-right">

        <a href="#"><img src="img/no-logo.png"></a>
    </div>
    <?php
}
    ?>
<div class="divider divider-margins"></div>
<div class="content">

    <p><?= $salon_data['info'] ?></p>


</div>



<div class="content bottom-0">

    <div class="one-half">

        <a onclick=location.replace("add_review.php?i=<?=$_GET['i']?>") class="button button-xs button-circle bg-highlight button-full bottom-30">Add Review</a>

    </div>

    <div class="one-half last-column">
        <?php
        if($fav == 0) {
        ?>
        <a href="add_to_favorite.php?i=<?=$_GET['i']?>&type=add" class="button button-xs button-circle button-border button-full border-highlight color-highlight bg-transparent bottom-0">Add to favorites</a>
        <?php
        } else {
        ?>
        <a href="add_to_favorite.php?i=<?=$_GET['i']?>&type=remove" class="button button-xs button-circle button-border button-full border-highlight color-highlight bg-transparent bottom-0">Remove favorites</a>
        <?php
        }
        ?>
    </div>

    <div class="clear"></div>

</div>



<div class="divider divider-margins bottom-10"></div>



<div class="content">

    <h4 class="bolder bottom-10 color-highlight"><?= lang::getKeyword('Barbers') ?></h4>

    <div class="divider divider-margins bottom-10"></div>

    <?php
    $count = 0;
    while ($row = $barbers->fetch_assoc()) {

        $services = $query->fetchAssoc("select name, description
         from services s, barbers_services b
          where s.service_id = b.service_id and barber_id = '$row[barber_id]'");
       
        if ($salon_data['type'] == 'self') {
            $img = $salon_data['logo'] == '' ? 'no-logo.png' : $salon_data['logo'];
        } else {
            $img = $row['profile_img'] == '' ? 'no-image.jpg' : $row['profile_img'];
        }
    ?>

        <div class="user-slider owl-carousel  bottom-0">

            <div class="user-list-left">

                <img src="img/<?= $img ?>" alt="img" class="shadow-small">

                <h4 style="font-size: 12px;"><?= $row['name'] ?></h4>
                <?php

                if ($row['birthday'] != '0000-00-00') {

                    $cur_year = date('Y');
                    $date = DateTime::createFromFormat("Y-m-d", $row['birthday']);
                    $b_year = $date->format("Y");
                    $birth_year = $cur_year - $b_year;

                    echo '<p class="color-highlight">' . $birth_year . ' ' . lang::getKeyword('years old') . '</p>';
                }
                ?>

                <a href="#" class="next-slide-user bg-highlight">TAP FOR MORE</a>

            </div>

            <div class="user-list-right">

                <h4 style="font-size: 12px;"><?= $row['name'] ?></h4>

                <a href="tel:22580460" class="float-right icon icon-xxs icon-circle shadow-large bg-phone left-5"><i class="fa fa-phone"></i></a>

                <a target="_blank" href="services.php?i=<?=$_GET['i']?>&b=<?=$row['barber_id']?>" class="float-right icon icon-xxs icon-circle shadow-large bg-twitter left-5"><i class="fas fa-calendar-plus"></i></a>

                <a href="#" data-menu="menu<?=$row['barber_id']?>" class="float-right icon icon-xxs icon-circle shadow-large bg-twitter left-5"><i class="fas fa-info"></i></a>



            </div>

        </div>
        <div id="menu<?=$row['barber_id']?>" class="menu menu-box-bottom" data-menu-height="92%" data-menu-effect="menu-over">

            <div class="gallery gallery-thumbs gallery-round" style="padding: 20px;">

                <img src="img/<?=$img?>" class="preload-image responsive-image" alt="img">

            </div>



            <h3 class="center-text uppercase bolder top-30"><?=$row['name']?></h3>

            <h3 class="center-text "><?=$row['info']?></h3>



            <h4 class="center-text uppercase bolder top-30">Services</h4>


            <?php
            while($row1 = $services->fetch_assoc()) {
            ?>
            <p class="boxed-text-large">

                <strong><?=$row1['name']?></strong> <?=$row1['description']?>

            </p>
            <?php
            }
            ?>

            

            <a href="#" class="close-menu button button-center-medium button-s shadow-large button-round-small bg-green1-dark">Close</a>

        </div>

    <?php
    }
    ?>


</div>





<?php
if($is_porto != 0) {

?>

<div class="content gallery-view-controls bottom-30">

    <div class="divider divider-margins bottom-10"></div>

    <h4 class="bolder bottom-10 color-highlight">PORTOFOLIO</h4>



    <a href="#" class="color-highlight gallery-view-2-activate"><i class="fa fa-th-large"></i></a>

    <a href="#" class="gallery-view-3-activate"><i class="fa fa-bars"></i></a>

</div>



<div class="content bottom-10 " style="margin-top: 50px;">

    <div class="gallery-views gallery-view-2">
        <?php
        while($row = $porto->fetch_assoc()) {

       ?>
        <a data-lightbox="gallery-1" class="show-gallery" href="img/<?=$row['url']?>" title="<?=$row['name']?>">

            <img src="images/empty.png" data-src="img/<?=$row['url']?>" class="preload-image responsive-image" alt="img">

            <div class="caption">

                <h4 class="bottom-0 color-theme"><?=$row['name']?></h4>



                <div class="divider bottom-0"></div>

            </div>

        </a>
        <?php
        }
        ?>

        

    </div>

    <div class="clear"></div>

</div>
<?php
}
?>




<div class="divider clear"></div>



<?php
if($is_social > 0) {
?>
<div class="footer">

    <a href="#" class="footer-title" style="font-size: 14px;"><?=$salon_data['name']?></a>

    
    <div class="footer-socials" style="padding: 20px;">
    <?php
    while($row = $social->fetch_assoc()) {
    ?>
        <a href="https://<?=$row['url']?>" class="round-tiny shadow-medium bg-<?=$row['name']?>"><i class="fab fa-<?=$row['icon']?>"></i></a>

        <?php
        } 
        ?>
        <div class="clear"></div>

    </div>

</div>
<?php

}
?>





<div class="menu-hider"></div>

</div>





<script type="text/javascript" src="scripts/jquery.js"></script>

<script type="text/javascript" src="scripts/plugins.js"></script>

<script type="text/javascript" src="scripts/custom.js"></script>

</body>