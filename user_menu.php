<?php
session_start();
include('in_cla/class.Database.php');
include('in_cla/class.query.php');
include('in_cla/class.lang.php');
include('in_cla/funcs.php');
if (isset($_SESSION['username'])) {
?>

    <div class="nav nav-medium">

        <div class="divider"></div>



        <a id="page-home" href="profile.php">

            <i class="fa fa-user-alt color-green1-dark"></i><span><?= lang::getKeyword('My profile') ?></span>
        </a>
        <a id="page-components" href="favourits.php">

            <i class="fa fa-heart color-red1-dark"></i><span><?= lang::getKeyword('Favourites') ?></span>

        </a>
        <a id="page-components" href="address.php">

            <i class="fas fa-address-card color-pink1-dark"></i></i><span><?= lang::getKeyword('My addresses') ?></span>

        </a>
        <a href="#" id="page-components" onclick="location.replace('mybookings.php')">

            <i class="fas fa-calendar color-blue1-dark"></i></i><span><?= lang::getKeyword('My bookings') ?></span>

        </a>
        <a id="page-components" href="book.php">

            <i class="fas fa-shopping-cart color-brown1-dark"></i><span>My Cart</span>

        </a>
        <a id="page-components" href="change_password.php">

            <i class="fas fa-key color-brown1-dark"></i><span><?= lang::getKeyword('Change password') ?></span>

        </a>

        </a>
        <a id="page-components" href="logout.php">

            <i class="fa fa-sign-out-alt color-yellow1-dark"></i><span><?= lang::getKeyword('Logout') ?></span>

        </a>




    </div>
<?php
} else {
?>





    <div class="nav nav-medium">

        <div class="divider"></div>

        <a id="page-home" href="book.php">

            <i class="fas fa-shopping-cart color-brown1-dark"></i><span>My Cart</span>

        </a>
        <div class="divider"></div>

        <a id="page-home" href="login.php">

            <i class="fa fa-sign-in-alt color-green1-dark"></i><span>Login</span>

        </a>
        <div class="divider"></div>


        <a id="page-components" href="#">

            <span><?= lang::getKeyword("Don\'t have an account?") ?></span>

        </a>
        <a id="page-components" href="signup.php">

            <i class="fa fa-user-plus color-magenta2-dark"></i><span>Sign up</span>

        </a>




    </div>

<?php
}
?>