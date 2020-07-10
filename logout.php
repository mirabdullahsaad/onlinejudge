<?php
	session_start();
	session_destroy();
	unset($_SESSION['username']);
	unset($_SESSION['loggedin']);
	setcookie("loggedin", "true", time()-3600);
	setcookie("username", $name, time()-3600);
	setcookie("userid", $row['id'], time()-3600);
	setcookie("privilage", $row['privilage'], time()-3600);
	$_SESSION['message'] = "You are logged out";
	header('location:home.php');
?>