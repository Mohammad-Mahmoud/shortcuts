<?php

function disLangs()
{
	query::numRows("select * from lang");
	if (query::$num > 0) {
		$query = new query();
		while ($row = $query->langs->fetch_assoc()) {
			print ('<a href="index.php?lang=' . $row['code'] . '">' . $row['lang_name'] . '</a>') . "\r\n";
		}
	}
}

function setUserLang($lang)
{
	query::numRows("select * from lang where code = '$lang'");
	$is_lang = query::$num;
	if ($is_lang != 0) {
		setcookie("userLang", $lang, time() + (10 * 365 * 24 * 60 * 60));
	}
}

function getContant()
{
	$query = new query();
	$content = $query->fetchAssoc("select * from contact where contact_id = 1");
	$contact = $content->fetch_assoc();
	return $contact['contact_desc_' . lang::getUserLang()];
}

function disPage($id)
{
	$query = new query();
	$content = $query->fetchAssoc("select * from contact where contact_id = '$id'");
	$contact = $content->fetch_assoc();
	return $contact['contact_desc_' . lang::getUserLang()];
}

function sendMessage()
{
	if ($_GET['q']) {
		$query = new query();
		query::checkGet("select * from product where md5(product_id) = '$_GET[q]'");
		$product_info = $query->fetchAssoc("select * from product where md5(product_id) = '$_GET[q]'");
		$product_details = $product_info->fetch_assoc();
		$text = "You have a question about a product" . "\r\n";
		$text = $text . "Product name :" . $product_details['product_name_' . lang::getUserLang()] . "\r\n";
		$text = $text . "Product SN :" . $product_details['SN'] . "\r\n" . "<br>";
		$text = $text . "<b>User Message</b>" . "\r\n";
	} else {
		$text = '';
	}
	$message = "New message";

	$text1 = $text . htmlspecialchars($_POST['message']);

	$headers = 'From: <info@mooihair.com>' . "\r\n";
	$headers .= "Content-Type: text/plain; charset=utf-8\r\n";
	mail('info@tp-auto.dk', 'You have a new message', $message, $headers);
	query::update("insert into messages values(messages_id, '$_POST[name]','$_POST[email]','','$text1',NOW(),0)");
	echo '
			<script language=javascript>
				alert("' . lang::getKeyword('Your message is send, thank you for contacting us') . '");
				location.replace("contactus.php");
			</script>';
}

function regSalon()
{
	if (isset($_POST['name']) && isset($_POST['email'])) {
		$email = query::numRows("select email from salon where email = '$_POST[email]'");
        $address = query::numRows("select address from salon where email = '$_POST[email]'");
        if ($email !== 0) {
			echo '<script>
				$("#l1").css("color","red");
				$("#l1").html("' . lang::getKeyword('This email already used, please use another email') . '");
			  </script>';
		} elseif ($address !== 0) {
            echo '<script>
				$("#l1").css("color","red");
				$("#l1").html("' . lang::getKeyword('This address already used, please use another address') . '");
			  </script>';
        }
        else {
            $home_address = $_POST['home_address'].', '.$_POST['home_zip'].' '.$_POST['home_city'];
            $salon_address = $_POST['salon_address'].', '.$_POST['salon_zip'].' '.$_POST['salon_city'];
			query::update("insert into salon_req values(
			req_id, '$_POST[name]','$_POST[email]',
			'$home_address','$_POST[phone]',
			'$_POST[notes]','$_POST[rad]','$_POST[salon_name]','$salon_address',curdate(),0,0)");
            sendMailToSalon($_POST['email']);
			echo '<script>
				$("#l1").css("color","green");
				$("#l1").html("' . lang::getKeyword('Your application sent, we will contact you soon') . '");
			  </script>';
		}
	}
}

function setTempCookie($path,$domain) {
	$value = session_id() . rand(0, 999999);
    $name = 'temp_user_id';
    
    $expire = time() + 60 * 60 * 24 * 30;
    $httponly = true;
	if(!isset($_COOKIE['temp_user_id'])) {
		setcookie($name, $value, $expire, $path, $domain);
	}
}

function regUser() {
    if(isset($_POST['email'])) {
        $email = query::numRows("select email from users where email = '$_POST[email]'");

        if ($email !== 0) {
            echo '<script>
				$("#l1").css("color","red");
				$("#l1").html("' . lang::getKeyword('This email already used, please use another email') . '");
			  </script>';
        } else {
            query::update("insert into users values(user_id,'$_POST[first_name]','$_POST[last_name]', '$_POST[phone]','$_POST[email]',
                         'md5($_POST[password])', '$_POST[birthday]','',curdate(),'')");
            echo '<script>
				$("#l1").css("color","green");
			    $("#l1").html("You have successfully registered, you will be redirect to login");

				var delay = 4000; 
                setTimeout(function(){ window.location = "login.php"; }, delay);
			  </script>';
        }

    }
}

function sendMailToSalon($email) {
    $to_email = $email;
    $subject = 'SHORTCUTS - We have received your request';
    $message = '
        <html><head>
        <style>
        .button {display: block;width: 115px;height: 25px;background: #4E9CAF;
                padding: 10px;text-align: center;border-radius: 5px;color: white;font-weight: bold;
                line-height: 25px;}
        </style>
        </head>
        <body>
        <p>Thanks for your request, your request has been recieved.</p>
        <p>We will replay to you soon.</p>
 
        </body>
        </html>
        ';
    $headers = "From: noreply@barberlab95.dk\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    mail($to_email,$subject,$message,$headers);
}

function sendReceipt($email, $order_id, $date) {
    $to_email = $email;
    $subject = 'SHORTCUTS - Thanks for your booking';
    $message = '
        <html><head>
        <style>
        .button {display: block;width: 115px;height: 25px;background: #4E9CAF;
                padding: 10px;text-align: center;border-radius: 5px;color: white;font-weight: bold;
                line-height: 25px;}
        </style>
        </head>
        <body>
        <p>Thanks for your booking with shortcuts.</p>
        <br><b>Booking information</b>
        <br>Order number: '.$order_id.'
        <br>Booking date: '.$date.'
 
        </body>
        </html>
        ';
    $headers = "From: noreply@barberlab95.dk\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    mail($to_email,$subject,$message,$headers);
}

function sendReceiptToBarber($email, $order_id, $date, $name) {
    $to_email = $email;
    $subject = 'SHORTCUTS - New booking';
    $message = '
        <html><head>
        <style>
        .button {display: block;width: 115px;height: 25px;background: #4E9CAF;
                padding: 10px;text-align: center;border-radius: 5px;color: white;font-weight: bold;
                line-height: 25px;}
        </style>
        </head>
        <body>
        <p>A customer booked new date.</p>
        <br><b>Booking information</b>
        <br>Order number: '.$order_id.'
        <br>Booking date: '.$date.'
        <br>Customer: '.$name.'
 
        </body>
        </html>
        ';
    $headers = "From: noreply@barberlab95.dk\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    mail($to_email,$subject,$message,$headers);
}
