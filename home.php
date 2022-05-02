<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
function getData() {
    $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyC1y5bZPJv7dEB4EQZDukXO3IeCsUkkNFo', function (data) {
        return data.results[0].geometry.location.lat;
    });
}
</script>



<div class="page-content margin-top-10">


    <script>
        function showWarning() {
            document.getElementById("warning").style.display = "block";
        }
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
            }, function() {
               showWarning();
            });
        }
    </script>

    <div class="search-box search-color bg-dark1-dark shadow-tiny round-medium bottom-20" style="margin: 10px; margin-top: 80px;">

        <i class="fa fa-search"></i>

        <input type="text" placeholder="Search here.. - try the word demo " data-search>

    </div>


    <div class="responsive-iframe bottom-0 add-iframe">

        <iframe class="location-map" src='xml/index.html'></iframe>

    </div>
    <div id="warning" class="alert alert-large alert-round-medium bg-yellow1-dark" style="display: none;">
        <i class="fa fa-exclamation-triangle"></i>
        <strong class="uppercase ultrabold">Location service is disabled</strong>
        <span>Turn on location service to get all salons near by you.</span>
        <i class="fa fa-times"></i>
    </div>

    <div class="divider divider-margins"></div>



    <div class="content">

        <h2 class="bold center-text">Featured hair salons</h2>
        <script>
           console.log(getData());
        </script>

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
        $logo = $row['logo'] == '' ? 'no-logo.png' : $row['logo'];
    ?>

        <div class="one-half <?=$c?>">

            <a href="salon.php?i=<?=$row['salon_id']?>">

                <img data-src="img/<?=$logo?>" src="images/empty.png" alt="img" class="preload-image responsive-image round-small shadow-large bottom-20">

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
