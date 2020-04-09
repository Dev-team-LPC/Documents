<?php 
 	error_reporting(E_ALL^E_NOTICE);

	session_start();

	/*
	  if user has already logged in they must stay logged in till they click logout.
	*/
	
	// if(isset($_SESSION['userType']))
	// {
		if ($_SESSION['userType'] == "candidate") {
			# code...
			header("Location: candidate.php");
		}
 
		if($_SESSION['userType'] == "admin")
		{
			header("Location: admin.php");
		}
		
	// }
		
	

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
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="" href="index.html" style='padding-bottom:10px'>
						<img src="logo.png" width='100px' height='70px'>
					</a>
				</div>
				<ul class="nav navbar-nav navbar-right">
					<li></li>
				</ul>
			</div>
		</nav>

		<div class="container-fluid" style='padding-top:90px'>
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6 col-xs-12">
					<form action="login.php" method="post">
						<div class="form-group">
							<!-- added labels and placeholders on inputs -->
							<br>
							<br>
							<label>email</label>
							<input class="form-control" type="email" name="email" id="email" placeholder="email@example.com">
							<br>
							<label>password</label>
							<input class="form-control" type="password" name="password" id="password" placeholder="password">
							<br>
							<button class="btn btn-block btn-primary" type="submit" name="Login" id="email" >login</button>
						</div>
					</form>
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
