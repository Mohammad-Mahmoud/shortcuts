<?php
session_start();
require("in_cla/class.Database.php");
require("in_cla/class.query.php");
require("in_cla/class.users.php");

// variables start
$full_name = users::getUserData('first_name').' '.users::getUserData('last_name');
$name = (isset($_SESSION['username']) ? $full_name:trim($_POST['contactNameField']));
$message =  trim($_POST['contactMessageTextarea']);
// variables end

query::update("insert into reviews values(review_id, '$name','$_POST[start_count]','$_POST[contactTitleField]','$_GET[i]','$message',curdate())");

// email address starts
$emailAddress = '';
// email address ends

$subject = "Message From: $name";
$message = "<strong>From:</strong> $name <br/><br/> <strong>Message:</strong> $message";

$headers .= 'From: '. $name . '<' . $email . '>' . "\r\n";
$headers .= 'Reply-To: ' . $email . "\r\n";

$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

//send email function starts
mail($emailAddress, $subject, $message, $headers);
//send email function ends
?>


