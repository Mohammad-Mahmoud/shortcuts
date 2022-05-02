<?php
session_start();
error_reporting(E_ERROR | E_PARSE);

include('in_cla/class.Database.php');
include('in_cla/class.query.php');
include('in_cla/class.lang.php');
include('in_cla/funcs.php');
include("in_cla/class.users.php");

if(isset($_GET['lang'])) {
    setUserlang($_GET['lang']);
    header('Location: index.php');
}


?>

<!DOCTYPE HTML>

<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="viewport" content="width=device-width, user-scalable=no", viewport-fit=cover" />

    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <meta name="apple-mobile-web-app-capable" content="yes">

    <title>Eazy Mobile | HTML, CSS & JS Mobile Template | Epsilon X </title>

    <!-- Don't forget to update PWA version (must be same) in pwa.js & manifest.json -->


    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="styles/style.css">

    <link rel="stylesheet" type="text/css" href="styles/framework.css">

    <link rel="stylesheet" type="text/css" href="fonts/css/fontawesome-all.min.css">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="scripts/plugins.js"></script>

    <script type="text/javascript" src="scripts/custom.js"></script>



</head>



<body class="theme-light" data-highlight="blue2">






<div id="page">

    <!-- header !-->

    <?php
    include('header.php');

    ?>

    <!-- header end !-->


    <!-- content !-->

    <div class="content top-100">
        <h4 style="margin-bottom: 20px;">What's wrong with review?</h4>
        <form action="report_review.php?i=<?=query::encryptGet($_GET['i'])?>" method="post">
            <div class="checkboxes-demo">
                <div class="fac fac-radio fac-blue bottom-10"><span></span>
                    <input id="box2-fac-radio" type="radio" name="rad" value="This review is not relevant">
                    <label for="box2-fac-radio">This review is not relevant</label>
                </div>

                <div class="fac fac-radio fac-blue bottom-10"><span></span>
                    <input id="radio1" type="radio" name="rad" value="Conflict of interest">
                    <label for="radio1">Conflict of interest</label>
                </div>
                <div class="fac fac-radio fac-blue bottom-10"><span></span>
                    <input id="radio2" type="radio" name="rad" value="Offensive or sexually explicit">
                    <label for="radio2">Offensive or sexually explicit</label>
                </div>
                <div class="fac fac-radio fac-blue bottom-10"><span></span>
                    <input id="radio3" type="radio" name="rad" value="Privacy concern">
                    <label for="radio3">Privacy concern</label>
                </div>
                <div class="fac fac-radio fac-blue bottom-10"><span></span>
                    <input id="radio4" type="radio" name="rad" value="Legal issue">
                    <label for="radio4">Legal issue</label>
                </div>
            </div>
            <input type="submit" style="width:100%; height:50px;" value="Send" class="top-20 button button-s button-round-large shadow-medium bg-highlight">

        </form>
    </div>


    <!-- content end !-->






    <div class="menu-hider"></div>

</div>









</body>

