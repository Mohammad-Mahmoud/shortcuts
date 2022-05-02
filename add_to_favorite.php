<?php
session_start();
//error_reporting(E_ERROR | E_PARSE);

include('in_cla/class.Database.php');
include('in_cla/class.query.php');
include('in_cla/class.lang.php');
include('in_cla/funcs.php');
include("in_cla/class.users.php");

if(isset($_GET['lang'])) {
    setUserlang($_GET['lang']);
    header('Location: index.php');
}
if(isset($_SESSION['username'])) {
$user_id = users::getUserID();
$fav = query::numRows("select * from user_favs where salon_id = '$_GET[i]' and user_id ='$user_id'");

if($_GET['type'] == 'add') {
    if($fav == 0) {
        query::update("insert into user_favs values(user_favs_id, '$_GET[i]', '$user_id')");
    }
} else if($_GET['type'] == 'remove') {
    query::update("delete from user_favs where user_id = '$user_id' and salon_id = '$_GET[i]'");
}
?>
<header>
    <title>Favourites</title>
</header>
<script>

    location.replace("salon.php?i=<?=$_GET['i']?>")
</script>
<?php
}
else {

?>

<script>
    alert('You need to login first');
    location.replace("login.php");
</script>
<?php
}
?>
