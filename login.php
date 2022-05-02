<?php
Session_start();
//error_reporting(E_ERROR | E_PARSE);

include('in_cla/class.Database.php');
include('in_cla/class.query.php');
include('in_cla/class.lang.php');
include('in_cla/funcs.php');
include("in_cla/class.users.php");

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



</head> 

    

<body class="theme-light" data-highlight="blue2">

    

<div id="page-preloader">

    <div class="loader-main"><div class="preload-spinner border-highlight"></div></div>

</div>

    

<div id="page">

    <!-- header !-->

    <?php
   include('header.php');
    ?>
    
    <!-- header end !-->


    <!-- content !-->
    
    <?php
    include('page_login.php');
    ?>
    
    <!-- content end !-->

    


        

    <div class="menu-hider"></div>

</div>






<script type="text/javascript" src="scripts/plugins.js"></script>

<script type="text/javascript" src="scripts/custom.js"></script>



</body>

