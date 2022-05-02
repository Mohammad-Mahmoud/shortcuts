

<div id="menu-cart" class="menu menu-box-bottom" data-menu-height="375" data-menu-effect="menu-over">

    <div class="content">

    <?php
    while($row = $items->fetch_assoc()) {
    ?>

        <div class="menu-cart-item">

            <img class="preload-image" src="icons/<?=$row['icon']?>" data-src="icons/<?=$row['icon']?>" alt="img">

            <strong><?=$row['name']?></strong>

            <span>Traditional straight razor shaves, hot towels, and balm treatment</span>

            <em>300 DKK </em>

            <a href="#" class="color-red1-dark"><i class="fa fa-times"></i> Remove item</a>

        </div>
    <?php
    }
    ?>



        

        <div class="divider bottom-20"></div>

        <div class="menu-cart-total">

            <h5 class="float-left">Total</h5>

            <h5 class="uppercase float-right">400 DKK</h5>

            <div class="clear"></div>

            <a href="checkout.html" style="color:#fff;" class="button button-full button-s top-20 button-round-small shadow-large bg-highlight bottom-0">Proceed
                to Checkout</a>

        </div>

    </div>

</div>