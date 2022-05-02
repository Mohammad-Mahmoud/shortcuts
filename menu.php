<?php
include ('in_cla/class.Database.php');
include('in_cla/class.query.php');
$q = new query();
$userLang = $_COOKIE['userLang'];

$langs = $q->fetchAssoc("select * from lang where code != '$userLang'");


?>
<a style="margin-left: 60px;" href="index.php" class="nav-title color-theme"><img src="images/logo-01.png" style="width:100px; height: auto;"></a>




<div class="nav nav-medium">

    <div class="divider"></div>

        

    <a id="page-home" href="index.php">

        <i class="fa fa-home color-green1-dark"></i><span>Home</span><i class="fa fa-angle-right"></i>

    </a>    

    <a id="page-contact" href="contact.php">

        <i class="fa fa-envelope color-blue2-dark"></i><span>Contact</span><i class="fa fa-angle-right"></i>

    </a>

    <a id="page-components" href="reg_salon.php">

        <i class="fa fa-user-plus color-magenta2-dark"></i><span>Register as hair salon</span><i class="fa fa-angle-right"></i>

    </a>  

         

      

    <a id="page-pageapps" href="page.php?i=3">

        <i class="fa fa-info-circle color-green1-dark"></i><span>About Us</span><i class="fa fa-angle-right"></i>

    </a>  
    <a id="page-pageapps" href="page.php?i=5">

        <i class="far fa-file-alt color-blue"></i><span>Terms</span><i class="fa fa-angle-right"></i>

    </a> 
    <a id="page-pageapps" href="page.php?i=4">

        <i class="fas fa-ban color-yellow1-dark"></i><span>Privacy policy</span><i class="fa fa-angle-right"></i>

    </a>


    <a id="page-pageapps" href="#" onclick="location.reload();">

        <i class="fa fa-info-circle color-red1-dark"></i><span>Reload</span><i class="fa fa-angle-right"></i>

    </a>   

    

    <!--<div class="divider top-15"></div>

    <p>Copyright <span class="copyright-year"></span> - Enabled. All rights Reserved.</p>!-->

</div>

<p style="margin-left: 26px;">

    <i class="fas fa-globe color-black"></i><span style="margin-left: 10px;">Choose Language</span>
    <br>
    <?php
    while($row = $langs->fetch_assoc()) {
    ?>
        <span style="margin-left: 26px;"><a style="color: #000;" href="index.php?lang=<?=$row['code']?>"><?=$row['lang_name']?></a></span>
    <br>

    <?php
    }
    ?>
</p>


