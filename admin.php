<?php 
 	error_reporting(E_ALL^E_NOTICE);
	session_start();
	require_once "db.php";
	/*
	if user has already logged in they must stay logged in till they click logout.
	*/
	if ($_SESSION['userType'] != "admin") {
		# code...	
		header("Location: index.php");
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
                <!--Start of Tawk.to Script-->
		<script type="text/javascript">
		var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
		(function(){
		var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
		s1.async=true;
		s1.src='https://embed.tawk.to/5cf9105bb534676f32ada5fd/default';
		s1.charset='UTF-8';
		s1.setAttribute('crossorigin','*');
		s0.parentNode.insertBefore(s1,s0);
		})();
		</script>
		<!--End of Tawk.to Script-->
	</head>

	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top" id='nav'>

			<div class="container-fluid">
				<div class="navbar-header">
			<button type="" class="navbar-toggle" style="" data-toggle="collapse" data-target="#navbar1">    
				<span class='icon-bar'></span>
				<span class='icon-bar'></span>
				<span class='icon-bar'></span>
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
				<form class='navbar-form' >
					<div class="input-group input-group-lg" style='padding-left:126px;height:10px;'>
		               	<input type="text" class="form-control" id="search-text" placeholder="name or surname"> 
		               	<span class="input-group-btn">
		               	<button class="btn btn-lg btn-default" type="button" id='search-btn' disabled> 
		                <i class="fa fa-search"></i> 
		                </button> 
		            </div>
		        </form>
			</div>
		</nav>
		<div class="container-fluid">
			<div class="row">
				<!-- hold footer in place -->
				<div class="col-md-2 col-xs-1" style='height:700px'></div>

			<!-- 	<div class="col-md-8 col-xs-10" id='search-bar' style='padding-top:120px;'>
 					<input type="text" class='form-control' id='search-text'placeholder='name or surname'/>
							            

				</div> -->

				<div class="col-md-8 col-xs-10" id='content' style='padding-top:100px;'>
					<div id='loader' style='padding-top:160px;margin-bottom:50px;'></div>

				</div>

				<div class="col-md-2 col-xs-1"></div>
			</div>
		</div>
		<nav class="navbar navbar-inverse navbar-bottom ">
		  <div class="container-fluid text-center">
		    
		    <ul class="nav navbar-nav navbar  col-md-12 col-sm-12 col-xs-12">
		      <li class='col-md-4 col-xs-6'><a href="#">Created by Ras</a></li>
		      <li class='col-md-4 col-xs-6 center-block'><a href='littl'>Little Pig CC</a></li>
		    </ul>
		   
		  </div>
		</nav>

		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/admin.js"></script>

	</body>

</html>  
