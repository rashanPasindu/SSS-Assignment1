<!DOCTYPE HTML>
<html>
<head>
<script>
function getToken(method,url,htmltag)
{
 var xhr = new XMLHttpRequest();
 xhr.onreadystatechange = function ()
		{
		if (xhr.readyState == 4 && xhr.status == 200)
		 {
		 console.log("CSRF Token Successfully Received "+this.responseText);
		 document.getElementById(htmltag).value = xhr.responseText;
		 }
		};
	xhr.open(method,url,true);
	xhr.send();
};

</script>
</head>
<?php
	//require 'session.php';
	session_start();

	if (isset ($_SESSION['views']))
	{
		$_SESSION['views'] = $_SESSION['views'] +1;
	}
	else {
		$_SESSION['views'] = 1;
	}

	$expire = time()+60*60*24;
	$id = session_id();
	$cookiename = "session"; 
	
	setcookie ($cookiename, $id, $expire, "","localhost", FALSE, TRUE);

	//$username = "user";
	//$password = "password";

	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
		header("Location: success.php");
	}

	if(isset($_COOKIE[$cookiename])) //checking whether the cookie is set
		 {
		 $msg = "Cookie Created";
		 echo "<script type='text/javascript'>alert('$msg')</script>";
		 
		 echo "<script>getToken('POST','serverside.php','CSRF')</script>"; //getting the token from serverside
		 
		 }
		 else 
		 {
		 $msg = "Cookie not Created";
		 echo "<script type='text/javascript'>alert('$msg')</script>";
		 }
	
?>


<title>
Login
</title>

<body>
	<form method="post" action="serverside.php">
		Username:<br/>
		<input type="text" name="username"><br/>
		Password:<br/>
		<input type="password" name="password"><br/><br/>

		<input type="hidden" id="CSRF" name="csrfToken" value="<?php echo $_SESSION['CSRF_TOKEN'];?>">

		<input type="submit" name="submit" value="Login"/> 
		
	</form>
<br/><br/>

<p> Page Views: <?php echo $_SESSION['views']; ?></p>

</body>
</html>