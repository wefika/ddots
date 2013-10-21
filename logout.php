<?php
	
	session_start();
	$_SESSION['login'] = false;
	header("location: login.php");

?>