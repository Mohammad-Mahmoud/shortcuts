<?php
class admin
{

	public $userName;

	public $passWord;

	public static $searchQuery;




	public static function indexPage()
	{

		if (!isset($_SESSION['salon'])) {
			include('login.php');
		} else {
			header('Location: home.php');
		}
	}

	public function login()
	{

		$db = new Database();

		$mysqli = $db->getConnection();

		if (isset($_POST['username']) || isset($_POST['password'])) {
			$username = $_POST['username'];

			$password = $_POST['password'];

			$useridusername_query = "select salon_id from salon where email like '$username'";

			$useridusername_result = $mysqli->query($useridusername_query);

			if (!$useridusername_result) {
				die($mysqli->error);
			} else {
				$row = $useridusername_result->fetch_assoc();
				$this->userName = $row['salon_id'];
			}

			$useridpassword_query = "select salon_id from salon where password like '$password' and email like '$username'";

			$useridpassword_result = $mysqli->query($useridpassword_query);

			if (!$useridpassword_result) {
				die($mysqli->error);
			} else {
				$row = $useridpassword_result->fetch_assoc();
				$this->passWord = $row['salon_id'];
			}

			if ($this->userName <> 0 && $this->userName == $this->passWord) {

				$_SESSION['salon'] = $username;

				echo "<script>window.location.replace('home.php');</script>";
			} else {
				print('<script> $("#l1").css("visibility","visible"); $("#l1").text("Invalid email or password");</script>');
			}
		}
	}

	static function checkSession($t)
	{

		if (!isset($_SESSION[$t])) {
			echo ('<p align="center"><label id=l1>Du er ikke logget ind</label></p>');
			echo "<br>";
			include('page_index.php');
		} else {
			include('page_main.php');
		}
	}

	static function definePage()
	{
		$page = 'page_' . $_GET['art'] . '.php';

		if (isset($_GET['art'])) {
			self::isBarber();

			self::isService();

			include($page);
		} else {
			self::isBarber();

			self::isService();

			include('page_home.php');
		}
	}

	public static function setSearch($ar = array(), $q, $id, $op, $ad)
	{
		if (!isset($_GET['search'])) {
			$l = $_SERVER['QUERY_STRING'];
		} else {
			$l = $_SERVER['QUERY_STRING'];
			$l = substr($l, 0, strpos($l, '&search'));
		}

		if (isset($_GET['search'])) {
			$search = strtolower($_GET['search']);
		}

		if (isset($_GET['s']) & !isset($_GET['d'])) {
			$m1 = '&d=DESC';
		} else if (isset($_GET['d']) & $_GET['d'] == 'DESC') {
			$m1 = '&d=ASC';
		} else if (isset($_GET['d']) & $_GET['d'] == 'ASC') {
			$m1 = '&d=DESC';
		} else {
			$m1 = '';
		}

		echo '<p><label class="title">Sort: &nbsp;</label>';

		while (list($a, $b) = each($ar)) {
			switch ($_GET['s']) {
				case $a:
					$$a = 'id="sort"';
					break;
			}
			echo '<a ' . $$a . ' href="home.php?art=' . $_GET['art'] . $ad . '&s=' . $a . $m1 . '&search=' . $_GET['search'] . '">' . $b . '&nbsp;&nbsp;&nbsp;</a>';
		}
		echo '<input type="text" placeholder="Search" name="term" id="term" value="' . $_GET['search'] . '" >';
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
					var target='home.php?" . $l . "&search='+search1;
					location.replace(target);
				}
			</script>";

		$ar1 = array_keys($ar);
		$z = implode(" like '%$search%' or ", $ar1);
		$z .= " like '%$search%' ";
		self::$searchQuery = $q . ' ' . $op . ' ' . $z;

		if (isset($_GET['s']) & !isset($_GET['d'])) {
			self::$searchQuery .= ' order by ' . $_GET['s'] . ' ASC ';
		} else if (isset($_GET['d'])) {
			self::$searchQuery .= ' order by ' . $_GET['s'] . ' ' . $_GET['d'];
		} else if (isset($_GET['search'])) {
			self::$searchQuery = self::$searchQuery;
		} else {
			self::$searchQuery = $q . ' order by ' . $id . ' DESC';
		}
	}

	public function changePassword()
	{

		$query = new query();
		$current_password = $query->fetchAssoc("select password from salon where email = '$_SESSION[salon]'");
		$row = $current_password->fetch_assoc();


		if ($row['password'] == $_POST['current_password']) {
			query::update("update salon set password = '$_POST[new_pass]' where email like '$_SESSION[salon]'");
			print('<script> $("#alert-s").css("display","block");</script>');
		} else {
			print('<script> $("#alert-w").css("display","block");</script>');
		}
	}

	public static function showMessage($message)
	{

		echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
	}

	public static function showError($message)
	{

		echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
		echo '<div><button type="submit" class="btn btn-primary width-150" onclick="javascript:history.back()">Back</button></div>';
	}

	public static function redirect($location)
	{
		echo '<script>';
		echo 'location.replace("' . $location . '")';
		echo '</script>';
	}

	public static function isBarber()
	{
		$salon_id = self::getSalonData('salon_id');
		$b_count = query::numRows("select * from barbers where salon_id = '$salon_id'");
		if ($b_count == 0) {

			echo '<div class="alert alert-danger" role="alert">You have no barbers, and your salon is not active yet, please add at least one barber to active your salon </div>';
		}
	}

	public static function isService()
	{
		$type = self::getSalonData('type');
		if ($type == 'self') {
			$query = new query();
			$salon_id = self::getSalonData('salon_id');
			$barber = $query->fetchAssoc("select barber_id from barbers where salon_id = '$salon_id'");
			$barb_id_data = $barber->fetch_assoc();
			$barb_id = $barb_id_data['barber_id'];
			$b_count = query::numRows("select * from barbers_services where barber_id = '$barb_id'");
			if ($b_count == 0) {

				echo '<div class="alert alert-danger" role="alert">You have no services, and your salon is not active yet, please add at least one service to active your salon </div>';
			}
		}
	}

	public static function getSalonData($f)
	{
		$query = new query();
		$name = $query->fetchAssoc("select $f from salon where email like '$_SESSION[salon]'");
		$name_data = $name->fetch_assoc();
		return $name_data[$f];
	}

	
	

	public static function timer($location)
	{
		print("<script>setTimeout(function(){window.location.href='$location'},2000);</script>");
	}

	public static function updateProfile()
	{
        $json = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.rawurlencode($_POST["address"]).'&key=AIzaSyC1y5bZPJv7dEB4EQZDukXO3IeCsUkkNFo');
        $obj = json_decode($json);
        $lat = $obj->results[0]->geometry->location->lat;
        $lng = $obj->results[0]->geometry->location->lng;
        query::update("update salon set lat = '$lat' where email = '$_SESSION[salon]'");
        query::update("update salon set lng = '$lng' where email = '$_SESSION[salon]'");

		foreach($_POST as $key => $value) {
			query::update("update salon set $key = '$value' where email = '$_SESSION[salon]'");
		}
	}

	

	public static function updateBarberProfile()
	{

		foreach($_POST as $key => $value) {
			query::update("update barbers set $key = '$value' where barber_id = '$_GET[i]'");
		}
	}

	public static function changeLogo()
	{

		$image = new image;
		$image->setImageName();

		//echo $_SESSION['salon'];
		//echo $image->imgUrl;

		$q = "update salon set logo ='$image->imgUrl' where email like '$_SESSION[salon]'";

		$image->uploadPic('../../../img/', $q);
	}

	public static function addBarber()
	{

		$query = new query();
		$b_email = $query->extractArrayFromQuery("barbers", "email");

		if (in_array($_POST['email'], $b_email)) {
			self::showError("Email already used, please select another one");
			exit();
		}

		$image = new image;
		$image->setImageName();

		$id = admin::getSalonData('salon_id');

		$q = "insert into barbers values(
			 'barber_id','$id','$_POST[name]','$_POST[email]','$_POST[birthday]','$_POST[info]',
			 '$_POST[phone]','$image->imgUrl','$_POST[address]',20
			 )";

		$image->uploadPic('../../../img/', $q);


		$last_id = $query->fetchAssoc("select max(barber_id) as id from barbers");
		$last_id_data = $last_id->fetch_assoc();
		$barb_id = $last_id_data['id'];

		$ser = query::numRows("select * from services");

		for ($i = 1; $i <= $ser; $i++) {
			$ser_id = $_POST['c' . $i];
			$price_salon = $_POST['price_salon' . $i];
			$price_home = $_POST['price_home' . $i];
			$dur = $_POST['duration' . $i];
			$type = $_POST['ser' . $i];
			if ($ser_id) {
				query::update("insert into barbers_services values
				(barb_ser_id,'$barb_id','$ser_id','$price_home','$price_salon','','$dur','$type')");
			}
		}
	}

	public static function updateBarberServices()
	{


		$ser = query::numRows("select * from services");
		$barb_ser = query::numRows("select * from barbers_services where barber_id = '$_GET[i]'");

		for ($i = 1; $i <= $barb_ser; $i++) {
			$barb_ser_id = $_POST['c' . $i];
			$price_home = $_POST['price_home' . $i];
			$price_salon = $_POST['price_salon' . $i];
			$dur = $_POST['duration' . $i];
			$type = $_POST['ser' . $i];
			$uncheck = $_POST['uncheck' . $i];

			query::update("UPDATE barbers_services set price_home = '$price_home' where barb_ser_id = '$barb_ser_id'");
			query::update("UPDATE  barbers_services set dur = '$dur' where barb_ser_id = '$barb_ser_id'");
			if(admin::getSalonData('type') == 'salon') {
				query::update("UPDATE  barbers_services set type = '$type' where barb_ser_id = '$barb_ser_id'");
				query::update("UPDATE barbers_services set price_salon = '$price_salon' where barb_ser_id = '$barb_ser_id'");
			}

			
			if ($uncheck != "") {
				query::update("DELETE from barbers_services where barb_ser_id= '$uncheck'");
			}
		}

		if ($barb_ser < $ser) {

			$query = new query();

			$barb_service = $query->fetchAssoc("SELECT * from barbers_services where barber_id = '$_GET[i]'");

			$arr = array();

			while ($row = $barb_service->fetch_assoc()) {
				array_push($arr, $row['service_id']);
			}

			$new_arr = implode("','", $arr);

			$other_ser = query::numRows("SELECT * FROM services WHERE service_id NOT IN ('$new_arr')");

			for ($i = 1; $i <= $other_ser; $i++) {
				$ser_id = $_POST['ch' . $i];
				$price_home = $_POST['s_price_home' . $i];
				$price_salon = $_POST['s_price_salon' . $i];
				$dur = $_POST['s_duration' . $i];
				if(admin::getSalonData('type') == 'salon') {
					$type = $_POST['serv' . $i];
				} else { $type = 'home'; }

				if (isset($ser_id)) {
					query::update("INSERT into barbers_services values
				(barb_ser_id,'$_GET[i]','$ser_id','$price_home','$price_salon','','$dur','$type')");
				}
			}
		}
	}

	public static function changeSocialActivity($status)
	{

		query::update("update salon_social set active = '$status' where salon_social_id = '$_GET[i]'");
	}

	public static function addClosingDay()
	{
		$salon_id = self::getSalonData('salon_id');
		$query = new query();

		$my_ar = $query->extractArrayFromQuery('closing_days', 'date', 'salon_id = ' . $salon_id);

		foreach ($_POST as $val) {

			$in_arr =  in_array($val, $my_ar);

			if (!$in_arr) {

				query::update("INSERT into closing_days values(closing_days_id,'$salon_id','$val')");
			}
		}
	}

	public static function deletePastClosingDays()
	{
		$salon_id = self::getSalonData('salon_id');
		$query = new query;

		$days_ar = $query->extractArrayFromQuery('closing_days', 'closing_days_id', 'date<current_date() and salon_id =' . $salon_id);

		foreach ($days_ar as $val) {
			query::update("delete from closing_days where closing_days_id = '$val'");
		}
	}

	public static function updateWorkingDays()
	{
		$salon_id = self::getSalonData('salon_id');
		$not_active = array();

		foreach ($_POST as $key => $val) {

			array_push($not_active, $key);
			query::update("UPDATE working_days set active=1 where working_days_id = '$key' and salon_id ='$salon_id'");
		}

		$not_active = implode("','", $not_active);

		query::update("UPDATE working_days set active=0 where working_days_id not in ('$not_active') and salon_id ='$salon_id'");
	}

	public static function changeOpeningHours()
	{
		$salon_id = self::getSalonData('salon_id');
		query::update("UPDATE opening_hours set open ='$_POST[open]' where salon_id = '$salon_id' and opening_hours_id = '$_GET[i]'");
		query::update("UPDATE opening_hours set close ='$_POST[close]' where salon_id = '$salon_id' and opening_hours_id = '$_GET[i]'");
	}
}
