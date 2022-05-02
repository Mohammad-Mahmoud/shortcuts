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
query::checkGet("select * from salon where salon_id = '$_GET[i]'");
$query = new query();
$salon = $query->fetchAssoc("select * from salon where salon_id = '$_GET[i]'");
$salon_data = $salon->fetch_assoc();

$barbers = $query->fetchAssoc("select * from barbers where salon_id = '$_GET[i]'");

$is_porto = query::numRows("select * from slides where salon_id = '$_GET[i]'");
$porto = $query->fetchAssoc("select * from slides where salon_id = '$_GET[i]'");

$is_social = query::numRows("select * from salon_social where active = 1 and salon_id = '$_GET[i]'");
$social = $query->fetchAssoc("select *, c.link as url from social s, salon_social c where s.social_id = c.social_id
                            and c.salon_id = '$_GET[i]' and c.active = 1 ");

$user_id = users::getUserID();

$fav = query::numRows("select * from user_favs where salon_id = '$_GET[i]' and user_id ='$user_id'");
$review = $query::returnSingleValue("reviews","ROUND(avg(stars))", "salon_id=".$_GET['i'] );
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
    
    <?php
    
    include('view_salon.php');
    ?>
    
    <!-- content end !-->

    


        

    <div class="menu-hider"></div>

</div>









</body>

