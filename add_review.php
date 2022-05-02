<?php
session_start();
//error_reporting(E_ERROR | E_PARSE);

include('in_cla/class.Database.php');
include('in_cla/class.query.php');
include('in_cla/class.lang.php');
include('in_cla/funcs.php');
if (isset($_GET['lang'])) {
    setUserlang($_GET['lang']);
    header('Location: index.php');
}
$salon_name = query::returnSingleValue('salon','name','salon_id = '.$_GET['i']);
?>


<!DOCTYPE HTML>

<html lang="en">

<head>
    <style>
        * {
            -webkit-box-sizing:border-box;
            -moz-box-sizing:border-box;
            box-sizing:border-box;
        }

        *:before, *:after {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .clearfix {
            clear:both;
        }

        .text-center {text-align:center;}

        a {
            color: tomato;
            text-decoration: none;
        }

        a:hover {
            color: #2196f3;
        }

        pre {
            display: block;
            padding: 9.5px;
            margin: 0 0 10px;
            font-size: 13px;
            line-height: 1.42857143;
            color: #333;
            word-break: break-all;
            word-wrap: break-word;
            background-color: #F5F5F5;
            border: 1px solid #CCC;
            border-radius: 4px;
        }




        .header h2 {
            font-size:3em;
            font-weight:300;
            margin-bottom:0.2em;
        }
        .header p {
            font-size:14px;
        }

        #a-footer {
            margin: 20px 0;
        }
        .rating-stars ul {
            list-style-type:none;
            padding:0;

            -moz-user-select:none;
            -webkit-user-select:none;
        }
        .rating-stars ul > li.star {
            display:inline-block;

        }

        /* Idle State of the stars */
        .rating-stars ul > li.star > i.fa {
            font-size:2.5em; /* Change the size of the stars */
            color:#ccc; /* Color on idle state */
        }

        /* Hover state of the stars */
        .rating-stars ul > li.star.hover > i.fa {
            color:#FFCC36;
        }

        /* Selected state of the stars */
        .rating-stars ul > li.star.selected > i.fa {
            color:#FF912C;
        }

    </style>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="viewport" content="width=device-width, user-scalable=no, viewport-fit=cover" />

    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <meta name="apple-mobile-web-app-capable" content="yes">

    <title>Eazy Mobile | HTML, CSS & JS Mobile Template | Epsilon X </title>

    <!-- Don't forget to update PWA version (must be same) in pwa.js & manifest.json -->

    <link rel="manifest" href="_manifest.json" data-pwa-version="set_by_pwa.js">

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

        <h4 class="text-center "><span style="color: #0e90d2"><?=$salon_name?> - </span><?= lang::getKeyword('Add review') ?></h4>



        <div class="contact-form" style="margin:20px;">

            <div class="formSuccessMessageWrap" id="formSuccessMessageWrap">

                <div class="bg-green1-dark">

                    <div class="notification-icon"><i class="fa fa-check notification-icon"></i></div>

                    <h1 class="uppercase ultrabold"><?= lang::getKeyword('Review sent') ?></h1>



                </div>

            </div>

            <form action="send_review.php?i=<?=$_GET['i']?>" method="post" class="contactForm" id="contactForm">
                <div class="review-stars">

                <input type="hidden" name="start_count" id="start_count">

                    <section class='rating-widget'>

                        <!-- Rating Stars Box -->
                        <div class='rating-stars text-center'>
                            <ul id='stars'>
                                <li class='star' title='Poor' data-value='1'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='Fair' data-value='2'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='Good' data-value='3'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='Excellent' data-value='4'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='WOW!!!' data-value='5'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                            </ul>
                        </div>




                </div>


                <fieldset>

                    <div class="formValidationError bg-red2-dark" id="contactNameFieldError">

                        <span class="center-text uppercase color-white ultrabold"><?= lang::getKeyword('Name is required') ?></span>

                    </div>

                    <div class="formValidationError bg-red2-dark" id="contactTitleFieldError">

                        <span class="center-text uppercase color-white ultrabold"><?= lang::getKeyword('Title is required') ?></span>

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

                    <?php
                    if(!isset($_SESSION['username'])) {
                    ?>
                    <div class="form-field form-name">

                        <label class="contactNameField color-theme" for="contactNameField"><?= lang::getKeyword('Your name') ?>:<span><?= lang::getKeyword('Required') ?></span></label>

                        <input type="text" name="contactNameField" value="" class="contactField requiredField" id="contactNameField" />

                    </div>
                    <?php
                    }
                    ?>

                    <div class="form-field form-name">

                        <label class="contactNameField color-theme" for="contactTitleField"><?= lang::getKeyword('Title') ?>:<span><?= lang::getKeyword('Required') ?></span></label>

                        <input type="text" name="contactTitleField" value="" class="contactField requiredField" id="contactTitleField" />

                    </div>

                    <div class="form-field form-text">

                        <label class="contactMessageTextarea color-theme" for="contactMessageTextarea"><?= lang::getKeyword('Message') ?>: <span><?= lang::getKeyword('Required') ?></span></label>

                        <textarea maxlength="1000" name="contactMessageTextarea" class="contactTextarea requiredField" id="contactMessageTextarea"></textarea>

                    </div>

                    <div class="form-button">

                        <input id="submit_btn" type="submit" class="button bg-highlight button-m button-full round-tiny contactSubmitButton" value="Send" data-formId="contactForm" />

                    </div>

                </fieldset>

            </form>

        </div>



    </div>



    <div class="menu-hider"></div>

</div>




<script type="text/javascript" src="scripts/jquery.js"></script>

<script type="text/javascript" src="scripts/plugins.js"></script>

<script type="text/javascript" src="scripts/custom.js"></script>

<script>
    $("#submit_btn").click(function(event) {
        if($("#start_count").val() === '') {
            alert("Select review first");
            return false;
        }
    })
    $(document).ready(function(){

        /* 1. Visualizing things on Hover - See next part for action on click */
        $('#stars li').on('mouseover', function(){
            var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

            // Now highlight all the stars that's not after the current hovered star
            $(this).parent().children('li.star').each(function(e){
                if (e < onStar) {
                    $(this).addClass('hover');
                }
                else {
                    $(this).removeClass('hover');
                }
            });

        }).on('mouseout', function(){
            $(this).parent().children('li.star').each(function(e){
                $(this).removeClass('hover');
            });
        });


        /* 2. Action to perform on click */
        $('#stars li').on('click', function(){
            var onStar = parseInt($(this).data('value'), 10); // The star currently selected
            var stars = $(this).parent().children('li.star');

            for (i = 0; i < stars.length; i++) {
                $(stars[i]).removeClass('selected');
            }

            for (i = 0; i < onStar; i++) {
                $(stars[i]).addClass('selected');
            }

            // JUST RESPONSE (Not needed)
            var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);

            $("#start_count").val(ratingValue);


        });




    });



</script>


</body>