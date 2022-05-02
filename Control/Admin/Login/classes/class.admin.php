<?php
class admin {

	public $userName;

	public $passWord;
		
	public static $searchQuery;
	
	

	public static function indexPage() {
		
		if(!isset($_SESSION['username'])) {
			include('login.php');
		}
		else {
			header('Location: home.php');
		}
	}

	public function login() {
	
		$db = new Database();
	
		$mysqli = $db->getConnection();
	
		if(isset($_POST['username']) || isset($_POST['password'])){	
			$username=$_POST['username'];
		
			$password=$_POST['password'];
		
			$useridusername_query="select admin_id from admin where email like '$username'";
	
			$useridusername_result = $mysqli->query($useridusername_query);
	
			if(!$useridusername_result) {
				die ($mysqli->error);
			}
			else {
				$row = $useridusername_result->fetch_assoc();
				$this->userName = $row['admin_id'];
			}
		
			$useridpassword_query = "select admin_id from admin where password like md5('$password') and email like '$username'";
	
			$useridpassword_result = $mysqli->query($useridpassword_query);
	
			if(!$useridpassword_result) {
				die($mysqli->error);
			}
			else {
				$row=$useridpassword_result->fetch_assoc();
				$this->passWord=$row['admin_id'];
			}
		 
			if($this->userName <> 0 && $this->userName == $this->passWord) {
				$query = $mysqli->query("select lang_name from lang order by lang_id  ASC limit 1");
		
				$_SESSION['username'] = $username;
		
				echo "<script>window.location.replace('home.php');</script>";
			}
			else {
				print('<script> $("#l1").css("visibility","visible"); $("#l1").text("Invalid email or password");</script>');
			}
		}
	}
	
	static function checkSession($t) {
		
		if(!isset($_SESSION[$t])) {
			echo('<p align="center"><label id=l1>Du er ikke logget ind</label></p>');
			echo "<br>";
			include('page_index.php');
		}
		else {
			include('page_main.php');
			
		}
	}
	
	static function definePage() {
		$page='page_'.$_GET['art'].'.php';
		
		if(isset($_GET['art'])) {
			include($page);
		} else {
			include('page_home.php');
		}
	}
	
	public static function setSearch($ar=array(),$q,$id,$op,$ad)  {
		if(!isset($_GET['search'])) {
			$l = $_SERVER['QUERY_STRING'];
		} else {
			$l = $_SERVER['QUERY_STRING'];
			$l = substr($l, 0, strpos( $l, '&search'));
		}
		
		if(isset($_GET['search'])) {
			$search = strtolower($_GET['search']);
		}
		
		if(isset($_GET['s']) & !isset($_GET['d'])) {
			$m1 = '&d=DESC';
		} else if(isset($_GET['d']) & $_GET['d']=='DESC') {
			$m1 = '&d=ASC';
		} else if(isset($_GET['d']) & $_GET['d']=='ASC') {
			$m1 = '&d=DESC';
		} else {
			$m1 = '';
		}
		
		echo '<p><label class="title">Sort: &nbsp;</label>';
		
		while (list($a,$b) = each($ar)) {
			switch($_GET['s']) {
				case $a:
				$$a = 'id="sort"';
				break;
			}
			echo '<a '.$$a.' href="home.php?art='.$_GET['art'].$ad.'&s='.$a.$m1.'&search='.$_GET['search'].'">'.$b.'&nbsp;&nbsp;&nbsp;</a>';
		}
		echo '<input type="text" placeholder="Search" name="term" id="term" value="'.$_GET['search'].'" >';
		echo '</p>';
		
		echo "<script>
				var typingTimer;                
				var doneTypingInterval = 1000;  

				$('#term').keyup(function(){
    				clearTimeout(typingTimer);
    				typingTimer = setTimeout(doneTyping, doneTypingInterval);
				});


				$('#term').keydown(function(){
   					 clearTimeout(typingTimer);
				});

				function doneTyping () {
					var search1=document.getElementById('term').value;
					var target='home.php?".$l."&search='+search1;
					location.replace(target);
				}
			</script>";
		
		$ar1 = array_keys($ar);
		$z = implode(" like '%$search%' or ",$ar1);
		$z .= " like '%$search%' ";	
		self::$searchQuery = $q.' '.$op.' '.$z;
		
		if(isset($_GET['s']) & !isset($_GET['d'])) {
			self::$searchQuery .= ' order by '.$_GET['s'].' ASC ';
		} else if(isset($_GET['d'])) {
			self::$searchQuery .= ' order by '.$_GET['s'].' '. $_GET['d'] ;
		} else if(isset($_GET['search'])) {
			self::$searchQuery = self::$searchQuery;
		} else {
			self::$searchQuery = $q. ' order by '.$id.' DESC';
		}
	}
	
	public function changePassword(){
		
		$query = new query();
		$current_password = $query->fetchAssoc("select password from admin where email = '$_SESSION[username]'");
		$row = $current_password->fetch_assoc();
		
		
		if($row['password'] == md5($_POST['current_password'])) {
			query::update("update admin set password = md5('$_POST[new_pass]') where email like '$_SESSION[username]'");
			print('<script> $("#alert-s").css("display","block");</script>');
			
		} else {
			print('<script> $("#alert-w").css("display","block");</script>');
		}
	}
	
	public static function showMessage($message) {

		echo '<div class="alert alert-success" role="alert">'.$message.'</div>';
			
	}
	
	public static function showError($message) {

		echo '<div class="alert alert-danger" role="alert">'.$message.'</div>';
		echo '<div><button type="submit" class="btn btn-primary width-150" onclick="javascript:history.back()">Back</button></div>';
			
	}
	
	public static function redirect($location) {
		echo '<script>';
		echo 'location.replace("'.$location.'")';
		echo '</script>';
	}
	
	public function timer($location) {
		print("<script>setTimeout(function(){window.location.href='$location'},2000);</script>");
	}

	public static function sendApproveMessage($pass, $email) {
        $to_email = $email;
        $subject = 'SHORTCUTS - Your request has been approved';
        $message = '
        <html><head>
        <style>
        .button {display: block;width: 115px;height: 25px;background: #4E9CAF;
                padding: 10px;text-align: center;border-radius: 5px;color: white;font-weight: bold;
                line-height: 25px;}
        </style>
        </head>
        <body>
        Thanks for your request, Your request has been approved.
        <br>You can start using your account.
        <br><b>Account information</b>
        <br>Username: '.$email.'<br>Password: '.$pass.'
        <br><a class="button" href="https://barberlab95.dk/shortcuts/Control/Admin/salon-area/">View your account</a>
        </body>
        </html>
        ';
        $headers = "From: noreply@barberlab95.dk\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        mail($to_email,$subject,$message,$headers);

	}

	public static function approveSalonRequest() {
		$query = new query();
		$req = $query->fetchAssoc("select * from salon_req where req_id = '$_GET[i]'");
		$req_data = $req->fetch_assoc();
        $json = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.rawurlencode($req_data["address"]).'&key=key');
        $obj = json_decode($json);
        $lat = $obj->results[0]->geometry->location->lat;
        $lng = $obj->results[0]->geometry->location->lng;

		switch($req_data['type']) {
			case 0:
				$pass = query::generateSN();

				query::update("insert into salon values
				(salon_id,'$req_data[name]','$req_data[email]','$pass','$req_data[phone]','','','$req_data[address]','self', '$lat', '$lng')");
				
				$q = new query();
				$salon_id = $q->fetchAssoc("select salon_id from salon where email = '$req_data[email]'");
				$salon_id_data = $salon_id->fetch_assoc();
				
				query::update("insert into barbers values
				(barber_id,'$salon_id_data[salon_id]','$req_data[name]','$req_data[email]','0000-00-00','','$req_data[phone]','','$req_data[address]',20)");
			break;
			case 1:
				$pass = query::generateSN();
				query::update("insert into salon values
				(salon_id,'$req_data[salon_name]','$req_data[email]','$pass','$req_data[phone]','','','$req_data[salon_address]','salon', '$lat', '$lng')");
			break;
		}

		$latest_id = $query->fetchAssoc("select max(salon_id) as id from salon");
		$id = $latest_id->fetch_assoc();

		$socials = $query->fetchAssoc("select * from social");

		while($row = $socials->fetch_assoc()) {
			query::update("insert into salon_social values(salon_social_id,'$row[social_id]','$id[id]','',0)");
		}

		$days = [
			'Sunday' => 0,
			'Monday' => 1,
			'Tirsday' => 1,
			'Wedensday' => 1,
			'Thursday' => 1,
			'Friday' => 1,
			'Saturday' => 0,
		];
		
		foreach($days as $key => $value) {
			query::update("insert into working_days values(working_days_id,'$id[id]','$key','$value')");
		}

		if($req_data['type'] == 0) {
			query::update("INSERT INTO opening_hours values(opening_hours_id, '$id[id]','09:00:00','17:00:00','home')");
		} else {
			query::update("INSERT INTO opening_hours values(opening_hours_id, '$id[id]','09:00:00','17:00:00','home')");
			query::update("INSERT INTO opening_hours values(opening_hours_id, '$id[id]','18:00:00','21:00:00','home')");
		}

		query::update("update salon_req set approved = 1 where email = '$req_data[email]'");
		self::sendApproveMessage($pass, $req_data['email']);

	}
	
	
}
