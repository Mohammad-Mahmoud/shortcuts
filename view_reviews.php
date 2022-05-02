<div class="content top-100">
    <h4 class="text-center "><?=$salon_name?> </h4>
    <div class="divider"></div>

    <?php
    if($review_count == 0){
        echo '<p class="text-center">No review yet for this hair salon<br>
                <a href="add_review.php?i='.$_GET['i'].'">Add review</a>
        </p>';
    } else {
    while($row = $salon_reviews->fetch_assoc()) {
    ?>
<div class="review-1">

    <em><?=$row['name']?></em>

    <u class="opacity-50"><?=$row['date']?></u>
    <strong class="regular-bold font-13"><?=$row['title']?></strong>
                <span>
                    <?php
                    for($i=0; $i<$row['stars']; $i++){
                        ?>
                        <i class="fa fa-star color-yellow1-dark"></i>
                        <?php
                    }
                    for($i=0; $i<5-$row['stars']; $i++){
                        ?>
                        <i class="far fa-star"></i>
                        <?php
                    }
                    ?>
                </span>
    <p>
        <?=$row['text']?>
    </p>
    <p><a href="report.php?i=<?=$row['review_id']?>"> Report Review</a></p>
</div>
        <div class="divider"></div>
    <?php
    }
    }
    ?>
</div>