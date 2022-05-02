<?php

session_start();


unset($_SESSION['salon']);


session_destroy();


?>


<script language=javascript>

	
	window.location.replace('index.php');

</script>
