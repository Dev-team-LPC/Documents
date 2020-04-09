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
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>

	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="" href="index.html">
						<img src="logo.png" width='100px' height='70px'>
					</a>
				</div> 
			</div> 
		</nav>
		<div class="container-fluid" style='padding-top:100px'>
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6 col-xs-12 well text-">

					
					<?php
						if (isset($_SESSION['feedback'])) {

							echo "<h2 class='text-center'><span class='fa fa-check-circle text-success'></span>&nbsp;Feedback:</h2>".$_SESSION['feedback']."<hr role='separator' class='divider'>";
						}
						if (isset($_SESSION['error'])) {
							
							echo "<h2 class='text-center'><span class='fa fa-exclamation-circle text-danger'></span> Errors: </h2>".$_SESSION['error'];
						}
						else
						{
							echo "<h5>None</h5>";
						}

						if (isset($_SESSION['TypeError'])) {
							
							// echo "ID file type not allowed, pdf format only.";
							echo $_SESSION['TypeError'];
						}
					?>
					<div class="row">
						<div class="col-md-4"></div>
						<div class="col-md-4">
							<a href='candidate.php' class='btn btn-primary btn-block'>back</a>
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
	</body>

</html>  