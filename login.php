<?php
session_start();

require_once 'db.php';

	//Login
	if (isset($_POST["Login"])) {

		$email = mysqli_real_escape_string($conn, $_POST["email"]);
		$password = $_POST["password"];

		$sql = "SELECT * FROM applicants WHERE email='".$email."'";

		$result = mysqli_query($conn,$sql);    
		$row = mysqli_fetch_array($result);
		$num = mysqli_num_rows($result);
		$str = $row['encrypted_password'];
		$app_id = $row['id'];

		$password = crypt($password,$str);
				
		if(($password ==$str)?1:0)
		{
			$_SESSION['id'] = $row['id'];

			if(isset($_SESSION['id']))
			{
				$_sql = "SELECT * FROM shortlist_candidates WHERE applicant_id=".$_SESSION['id'];
				$_execute = mysqli_query($conn02, $_sql);
				$_num = mysqli_num_rows($_execute);

				if ($_num == 1) {
					# code...
					$_SESSION['userType'] = "candidate";
					header("Location: candidate.php");
				}
				else
				{
					$sql_ = "SELECT * FROM doc_admin WHERE applicant_id=".$_SESSION['id'];
					$execute_ = mysqli_query($conn02, $sql_);
					$num_ = mysqli_num_rows($execute_);

					if ($num_ == 1) {
						
						$_SESSION['userType'] = "admin";
						header("Location: admin.php");
					}else{
						header("Location: not_allowed.php");
					}
				}
			}
			else
			{
				$_SESSION['error'] = "
					<p>Something went while authenticating your credentials please <a href='candidate.php'>try again</a>, or contact the Admin.</p>
				";

				header("Location: feedback.php");
			}
		}
		else
		{
			$_SESSION['error'] = "
						<p> Your credentials were incorrect or,</p>
						<p> You are not authorised to visit this page</p>
					 	<p>Please try again later or contact Admin</p>
			";

			header("Location: feedback.php");
		}
	}
?>