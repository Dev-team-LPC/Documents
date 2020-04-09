<?php

 	error_reporting(E_ALL^E_NOTICE);
	session_start();
	require_once "db.php";
	/*
	if user has already logged in they must stay logged in till they click logout.
	*/
	if ($_SESSION['userType'] != "candidate") {
		# code...
		header("Location: index.php");
	}


if (isset($_SESSION['error']) || isset($_SESSION['feedback']) || isset($_SESSION['TypeError'])) {

	unset($_SESSION['error']);
	unset($_SESSION['TypeError']);
	unset($_SESSION['feedback']);
}

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
			<button type="" class="navbar-toggle btn-default" style="boder:none;" data-toggle="collapse" data-target="#navbar1">
                Menu
            </button>
				<a class="" href="index.html" style='padding-bottom:10px'>
					<img src="logo.png" width='100px' height='70px'>
				</a>
				</div>

				<?php

					$sql = "SELECT * FROM applicants WHERE id =".$_SESSION['id'];
					$run = mysqli_query($conn, $sql);
					$num = mysqli_num_rows($run);
					$row = mysqli_fetch_array($run);

					$mail = $row['email'];

				?>
				<ul class="collapse navbar-collapse nav navbar-nav navbar-right" id="navbar1">
				<li><a href="logout.php"><span class="fa fa-user fa-lg"></span> Logout <?php echo $mail;?></a></li>
				</ul>
			</div>
		</nav>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-3 col-sm-1 col-xs-1 " ></div>
				<!-- start 6 column/main div -->
				<div class="col-md-6 col-xs-10">
					<div class="row"style='padding-top:90px'>
						<!-- file upload form -->

							<!-- start target div -->
							<div class="col-md-12 table-responsive" id='content' >
								<!-- load server response here -->

								<div id='loader'>
									<!-- page loader icon(spinnig) -->
								</div>
							</div>
							<!-- end target div -->

					</div>
						<!-- end form -->
					</div>
				</div>
				<!-- end 6 column/main div -->
				<div class="col-md-3 col-sm-1 col-xs-1 "></div>
			</div>
		</div>
		<!-- updated footer -->
		<nav class="navbar navbar-inverse navbar- id="foota">
		  <div class="container-fluid text-center">

		    <ul class="nav navbar-nav navbar  col-md-12 col-sm-12 col-xs-12">
		      <li class='col-md-4 col-xs-6'><a href="#">Created by Ras</a></li>
		      <li class='col-md-4 col-xs-6 center-block'><a href="#">Little Pig CC</a></li>
		    </ul>

		  </div>
		</nav>
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/contracts.js"></script>
	</body>

</html>
