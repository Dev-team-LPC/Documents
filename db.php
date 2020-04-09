<?php
	//connect to the databse
	// $conn = mysqli_connect("192.168.1.217", "root", "1234", "applicant_v2_production");
	// $conn02 = mysqli_connect("192.168.1.217", "root", "1234", "self_assessment");

	$conn = mysqli_connect("localhost", "payroll_interns", "little pig 123", "applicant_v2_production");
	$conn02 = mysqli_connect("localhost", "payroll_interns", "little pig 123", "shortlist");


	if (!$conn) {
		# code...
		die("error occured...".mysqli_connect_error());
	}
	if (!$conn02) {
		# code...
		die("error occured...".mysqli_connect_error());
	}

?>
