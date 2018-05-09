<?php
	
	session_start();

	if(empty($_SESSION['key']))
	{
		$_SESSION['key']=bin2hex(random_bytes(32));
	}

	$token = hash_hmac('sha256',"CSRF Token:Login.php",$_SESSION['key']);
	
	$_SESSION['CSRF_TOKEN'] = $token; //mapping CSRF Token to the SESSION IDENTIFIER
	
	echo $token;

	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
		header("Location: success.php");
	}

	$page = $_SERVER['PHP_SELF'];
 	$sec = "0";
 	header("Refresh: $sec; url=$page");

	if(isset($_POST['submit']))
		 {
		 ob_end_clean(); //cleaning previous echoed
		
		 validatelogin($_POST['csrfToken'],$_COOKIE['session'],$_POST['username'],$_POST['password']); 
		 
		 }

	function validatelogin($user_CSRF,$user_sessionID,$user,$pwd)
	{
	if($user == "user" && $pwd == "password" && $user_sessionID == session_id())
	{
	if (hash_equals($user_CSRF, $_SESSION['CSRF_TOKEN']))
	{
	echo "<script> alert('Successful: Tokens Matched'+<?;?>) </script>";
	//echo $_SESSION['CSRF_TOKEN'];
	//echo $user_CSRF;
	$_SESSION['loggedin'] = true;
	}
	else
	{ 
	 echo "<script> alert('Un-Successful: Tokens Un-Matched'+ <?;?>)</script>";
	 //echo "<script> alert()</script>";
	 echo $_SESSION['CSRF_TOKEN']; echo " ";
	 echo $user_CSRF;
	}
	}
	else
	{
	 echo "<script> alert('Unsuccessful: Invalid Credentials & Session') </script>";
	}
	}

	
?>