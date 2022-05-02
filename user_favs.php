

<div class="page-content top-100">



    <div class="content">

        <h2 class="bold center-text">Your favourite hair salons</h2>
    </div>


    <div class="content">

        <?php
        $n = 0;
        while($row = $salons->fetch_assoc()) {
            $review = query::returnSingleValue("reviews","ROUND(avg(stars))", "salon_id=".$row['salon_id'] );

            $n++;
            if($n % 2){
                $c = '';
                $d = '';
            }else{
                $c =  'last-column';
                $d = '<div class="divider clear"></div>';
            }
            ?>

            <div class="one-half <?=$c?>">

                <a href="salon.php?i=<?=$row['salon_id']?>">

                    <img data-src="img/<?=$row['logo']?>" src="images/empty.png" alt="img" class="preload-image responsive-image round-small shadow-large bottom-20">

                </a>

                <h5><?=$row['name']?></h5>

                <div class="review-stars">

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

                </div>

                <p>

                    <?=$row['address']?>

                </p>

            </div>
            <?=$d?>
            <?php
        }
        ?>





    </div>


</div>
