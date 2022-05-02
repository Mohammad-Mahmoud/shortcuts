<?php
error_reporting(E_ERROR | E_PARSE);

include('in_cla/class.Database.php');
include('in_cla/class.query.php');
include('in_cla/class.lang.php');
include('in_cla/funcs.php');
if (isset($_GET['lang'])) {
    setUserlang($_GET['lang']);
    header('Location: index.php');
}
$query = new query();
$content = $query->fetchAssoc("select * from contact where contact_id = 1");
$about_us = $content->fetch_assoc();
$social = $query->fetchAssoc("select * from social where active = 1");

?>


<!DOCTYPE HTML>

<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="viewport" content="width=device-width, user-scalable=no, viewport-fit=cover" />

    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <meta name="apple-mobile-web-app-capable" content="yes">

    <title>Eazy Mobile | HTML, CSS & JS Mobile Template | Epsilon X </title>

    <!-- Don't forget to update PWA version (must be same) in pwa.js & manifest.json -->


    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="styles/style.css">

    <link rel="stylesheet" type="text/css" href="styles/framework.css">

    <link rel="stylesheet" type="text/css" href="fonts/css/fontawesome-all.min.css">

    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=false&sensor=false&key=AIzaSyC1y5bZPJv7dEB4EQZDukXO3IeCsUkkNFo"></script>



</head>



<body class="theme-light" data-highlight="blue2">



    <div id="page-preloader">

        <div class="loader-main">
            <div class="preload-spinner border-highlight"></div>
        </div>

    </div>



    <div id="page">

        <?php
        include('header.php');
        ?>

        <div class="page-content top-100">

            <h4 class="text-center "><?= lang::getKeyword('Write to us') ?></h4>



            <div class="contact-form" style="margin:20px;">

                <div class="formSuccessMessageWrap" id="formSuccessMessageWrap">

                    <div class="bg-green1-dark">

                        <div class="notification-icon"><i class="fa fa-check notification-icon"></i></div>

                        <h1 class="uppercase ultrabold"><?= lang::getKeyword('Message sent') ?></h1>

                        <p><?= lang::getKeyword('We will reply soon') ?></p>


                    </div>

                </div>

                <form action="send_message.php" method="post" class="contactForm" id="contactForm">

                    <fieldset>

                        <div class="formValidationError bg-red2-dark" id="contactNameFieldError">

                            <span class="center-text uppercase color-white ultrabold"><?= lang::getKeyword('Name is required') ?></span>

                        </div>

                        <div class="formValidationError bg-red2-dark" id="contactEmailFieldError">

                            <span class="center-text uppercase color-white ultrabold"><?= lang::getKeyword('Email is required') ?></span>

                        </div>

                        <div class="formValidationError bg-red2-dark" id="contactEmailFieldError2">

                            <span class="center-text uppercase color-white ultrabold"><?= lang::getKeyword('Email is not valid') ?></span>

                        </div>

                        <div class="formValidationError bg-red2-dark" id="contactMessageTextareaError">

                            <span class="center-text uppercase color-white ultraboldite"><?= lang::getKeyword('Message is required') ?></span>

                        </div>

                        <div class="form-field form-name">

                            <label class="contactNameField color-theme" for="contactNameField"><?= lang::getKeyword('Name') ?>:<span><?= lang::getKeyword('Required') ?></span></label>

                            <input type="text" name="contactNameField" value="" class="contactField requiredField" id="contactNameField" />

                        </div>

                        <div class="form-field form-email">

                            <label class="contactEmailField color-theme" for="contactEmailField">Email: <span><?= lang::getKeyword('Required') ?></span></label>

                            <input type="text" name="contactEmailField" value="" class="contactField requiredField requiredEmailField" id="contactEmailField" />

                        </div>

                        <div class="form-field form-text">

                            <label class="contactMessageTextarea color-theme" for="contactMessageTextarea"><?= lang::getKeyword('Message') ?>: <span><?= lang::getKeyword('Required') ?></span></label>

                            <textarea maxlength="1000" name="contactMessageTextarea" class="contactTextarea requiredField" id="contactMessageTextarea"></textarea>

                        </div>

                        <div class="form-button">

                            <input type="submit" class="button bg-highlight button-m button-full round-tiny contactSubmitButton" value="Send" data-formId="contactForm" />

                        </div>

                    </fieldset>

                </form>

            </div>



            <div class="contact-information last-column" style="margin:20px;">

                <div class="container no-bottom">

                    <h2 class="bolder"><?= lang::getKeyword('Contact Us') ?></h2>

                    <p class="contact-information">

                        <?= getContant() ?>
                    </p>



                    <div class="divider bottom-0"></div>
                    <h4 class="text-center bottom-10"><?= lang::getKeyword('Find us on') ?></h4>
                    <div class="footer-socials">
                        <?php
                        while ($row = $social->fetch_assoc()) {
                        ?>
                            <a href="https://<?= $row['link'] ?>" class="round-tiny shadow-medium bg-<?= $row['icon'] ?>"><i class="fab fa-<?= $row['icon'] ?>"></i></a>
                        <?php } ?>
                    </div>
                </div>

            </div>

            <div class="divider"></div>



        </div>



        <div class="menu-hider"></div>

    </div>





    <script type="text/javascript" src="scripts/jquery.js"></script>

    <script type="text/javascript" src="scripts/plugins.js"></script>

    <script type="text/javascript" src="scripts/custom.js"></script>

</body>