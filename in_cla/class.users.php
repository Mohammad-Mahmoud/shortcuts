<?php
class users
{
    public $userName;

    public $passWord;

    public function login($url='index.php')
    {

        $db = new Database();

        $mysqli = $db->getConnection();

        if (isset($_POST['email']) || isset($_POST['password'])) {
            $username = $_POST['email'];

            $password = $_POST['password'];

            $useridusername_query = "select user_id from users where email like '$username'";

            $useridusername_result = $mysqli->query($useridusername_query);

            if (!$useridusername_result) {
                die($mysqli->error);
            } else {
                $row = $useridusername_result->fetch_assoc();
                $this->userName = $row['user_id'];
            }

            $useridpassword_query = "select user_id from users where password like md5('$password') and email like '$username'";

            $useridpassword_result = $mysqli->query($useridpassword_query);

            if (!$useridpassword_result) {
                die($mysqli->error);
            } else {
                $row = $useridpassword_result->fetch_assoc();
                $this->passWord = $row['user_id'];
            }

            if ($this->userName <> 0 && $this->userName == $this->passWord) {
                $query = $mysqli->query("select lang_name from lang order by lang_id  ASC limit 1");

                $_SESSION['username'] = $username;
                query::update("delete from temp_cart where temp_user_id = '$_COOKIE[temp_user_id]'");

                echo "<script>window.location.replace('".$url."');</script>";
                if($url !== 'index.php')  {

                }
            } else {
                echo '<script> $("#l1").css("visibility","visible"); $("#l1").html("' . lang::getKeyword("Email or password is not valid") . '");</script>';
            }
        }
    }

    public static function updateUserInfo()
    {
        foreach ($_POST as $name => $value) {
            query::update("update users set $name = '$value' where email = '$_SESSION[username]'");
            echo '<script>
             $("#l1").css("visibility","visible"); 
             $("#l1").css("color","green"); 
             $("#l1").html("' . lang::getKeyword("Your information has been updated") . '");
             </script>';
        }
    }

    public static function updateUserAddress()
    {
        $user_id = self::getUserID();
        if(isset($_POST['main'])) {
            query::update("update user_address set main=0 where user_id = '$user_id' ");
        }
        foreach ($_POST as $name => $value) {
            query::update("update user_address set $name = '$value' where user_address_id = '$_GET[i]'");
            echo '<script>
             $("#l1").css("visibility","visible"); 
             $("#l1").css("color","green"); 
             $("#l1").html("' . lang::getKeyword("Your information has been updated") . '");
             </script>';
        }
    }

    public static function addNewAddress() {
        $user_id = self::getUserID();
        if(!isset($_POST['main'])) {
            $main = 0;
        } else {
            $main = $_POST['main'];
            query::update("update user_address set main=0 where user_id = '$user_id' ");
        }
        query::update("insert into user_address values(user_address_id,'$_POST[name]','$_POST[address]','$_POST[zip]','$_POST[city]','$user_id','$main')");

        header('Location: address.php');
    }

    public static function updateUserPassword(){
        $pass = md5($_POST['old_pass']);
        
        $query = new query();
        $user_pass = $query->fetchAssoc("select password from users where email = '$_SESSION[username]'");
        $user_pass_data = $user_pass->fetch_assoc();
        $current_pass = $user_pass_data['password'];
        
        if($pass !== $current_pass) {
            echo '<p id="l1" class="center-text bottom-10" style="color: red;">'.
            lang::getKeyword("Password is invalid").'
            </p>';
        } else {
            query::update("update users set password = '$pass' where email = '$_SESSION[username]'");
            echo '<p id="l1" class="center-text bottom-10" style="color: green;">'.
            lang::getKeyword("Password has been updated").'
            </p>';
        }

    }

    public static function sendResetEmail() {

    }


    public static function resetPassword(){
        $email = $_POST['email'];  
        $rows = query::numRows("select email from users where email = '$email'");
        if($rows == 0) {
            echo '<p id="l1" class="center-text bottom-10" style="color: red;">'.
            lang::getKeyword("Email not found").'
            </p>';
        } else {
            self::sendResetEmail();
            echo '<p id="l1" class="center-text bottom-10" style="color: green;">'.
            lang::getKeyword("Password has been updated").'
            </p>';
        }

    }


    public static function getUserID()
    {
        $query = new query();
        $user_id = $query->fetchAssoc("select user_id from users where email = '$_SESSION[username]'");
        $user_id_data = $user_id->fetch_assoc();
        $userId = $user_id_data['user_id'];
        return $userId;
    }

    public static function getUserData($f)
	{
		$query = new query();
		$name = $query->fetchAssoc("select $f from users where email like '$_SESSION[username]'");
		$name_data = $name->fetch_assoc();
		return $name_data[$f];
	}
}
