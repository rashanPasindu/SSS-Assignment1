<?php
	session_start();
	session_destroy();
	unset($_SESSION['username']);
	$_SESSION['message'] = "You are successfully logged out";
	header("Location: Login.php");	
?>

<html>
<body>
<script>
	alert("You have Successfully Logged out!");
</script>
</body>
</html>