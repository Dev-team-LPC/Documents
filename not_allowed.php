<?php
	error_reporting(E_ALL^E_NOTICE);
	session_start();
	require_once 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Little Pig</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="css/bootstrap-map.min.css">
		<link rel="stylesheet" href="css/freelancer.css">
		<link rel="stylesheet" href="css/font-awesome.css">
		<link rel="stylesheet" type="text/css" href="css/style02.css">
	</head>

	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.html"><img src="LittlePig.jpg" width="100px"></a>
				</div> 
			</div>
		</nav>
		<div class="container-fluid" style='padding-top:80px'>
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6 col-xs-12 well">
					<div class='text-center'>
						<h3 class=''><span class='fa fa-exclamation-circle text-danger'></span> Error</h3>
						<p>
							Please make sure that you are one of the shortlisted candidates, or you will not be able to use this website.
						</p>
					<div>
					
					<div class="row">
						<div class="col-md-4"></div>
						<div class="col-md-4">
							<a href='index.php' class='btn btn-primary btn-block'>back</a>
						</div>
						<div class="col-md-4"></div>
					</div>
				</div>
				<div class="col-md-3"></div>
			</div>
			
		</div>
<nav class="navbar navbar-inverse navbar-fixed-bottom">
  <div class="container-fluid text-center">
    
    <ul class="nav navbar-nav navbar  col-md-12 col-sm-12 col-xs-12">
      <li class='col-md-4 col-xs-6'><a href="#">Created by Ras</a></li>
      <li class='col-md-4 col-xs-6 center-block'><a href="#">Little Pig CC</a></li>
    </ul>
   
  </div>
</nav>
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/custom.js"></script>
	</body>

</html>  