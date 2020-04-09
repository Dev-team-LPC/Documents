<?php
	error_reporting(E_ALL^E_NOTICE);
	session_start();

	if (isset($_SESSION['id'])) {

	session_destroy();
	unset($_SESSION['id']);

	if(!$_SESSION['id']){

		header("Location:index.php");

	}

	}else {
		header("Location:index.php");
	}
?>