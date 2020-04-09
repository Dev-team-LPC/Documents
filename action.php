<?php 
 	error_reporting(E_ALL^E_NOTICE);

	session_start();
	require_once 'db.php';

	$path = "docs/".$_SESSION['id']."/";
	$user = $_SESSION['id'];

	if (!is_dir($path))	
	{
		mkdir($path,0755);
	}
	chdir($path);


	/*if (($_FILES['doc1_']['name'] == "") && ($_FILES['doc2_']['name'] == "") && ($_FILES['doc3_']['name'] == "") && ($_FILES['doc4_']['name'] == "") && ($_FILES['doc5_']['name'] == "")) {
		$blahblah = fopen("/tmp/rastafile", "w");
		fwrite($blahblah, "LOOPING\n",99);
	} */
	
	//1st input (ID)
	if ($_FILES['doc1_']['name'] == "")
	{
		// fetch from db
		$_sql = "SELECT * FROM candidate_docs WHERE applicant_id=".$_SESSION['id']." AND doc_name='id".$_SESSION['id'].".pdf'";
		$_run = mysqli_query($conn02, $_sql);
		$_num = mysqli_num_rows($_run);
		$_row = mysqli_fetch_array($_run);

		if (($_num == 0) || (($_num !=0) && ($_row['status_id'] ==2) || ($_row['status_id'] ==1))) {
			# code...
			//$blahblah = fopen("/tmp/rastafile.2", "w");
			//fwrite($blahblah, "YAYYAY\n",99);
			$_SESSION['error'] = "<p>You did not select your ID to be uploaded.</p>";
			// header("Location: feedback.php");
		}else{
			$_SESSION['error'] = "";
			
		}
	}
	else
	{
		$explo = explode(".", $_FILES['doc1_']['name']);
		$ext = end($explo) ;
		$allow = "pdf";
		
		if ($ext != $allow) {
			$_SESSION['TypeError'] .= "<p>ID file type not allowed, pdf format only.00</p>";
			header("Location: feedback.php");
		}

		if ($ext == $allow) {

			$file_name = "id".$_SESSION['id'].".pdf";
		
			if (is_uploaded_file($_FILES['doc1_']['tmp_name'])) {

				$p2 = getcwd();													# get current folder 
				$p2 = str_replace("\\", "\/", $p2);								# remove \ and place /
				$path = getcwd()."/$file_name";									# file address and file name

				// fetch from db
				$_sql = "SELECT * FROM candidate_docs WHERE applicant_id=".$_SESSION['id']." AND doc_name='".$file_name."'";
				$_run = mysqli_query($conn02, $_sql);
				$_num = mysqli_num_rows($_run);
				$_row = mysqli_fetch_array($_run);

				//if file found
				if ($_num == 1) {

					$sql = "UPDATE candidate_docs SET status_id = 1 WHERE doc_name ='$file_name'";
				}
				else{

					$sql = "INSERT INTO candidate_docs(applicant_id, status_id, doc_type_id, doc_name, doc_location) VALUES($user, 1, 1, '$file_name', '$p2')"; 
				}

				// move uploaded file to relevant dir
				if (move_uploaded_file($_FILES['doc1_']['tmp_name'], $path)) {
					
					$run =mysqli_query($conn02, $sql);
					$affect = mysqli_affected_rows($conn02);

					if ($affect == 1) {

						$sql = "SELECT * FROM candidate_docs WHERE applicant_id=".$_SESSION['id']." AND doc_name='".$file_name."'";
						$run_ = mysqli_query($conn02, $sql);
						$num = mysqli_num_rows($run_);
						$row = mysqli_fetch_array($run_);
						$status_id = $row['status_id'];
						$doc_id = $row['doc_type_id'];

						if ($run_) {

							$_SESSION['feedback'] .= "<p>ID uploaded</p>";
							header("Location: feedback.php");
						}
						
					}
				
				}
			
			}

		}
		else
		{
			// fetch from db
			$_sql = "SELECT * FROM candidate_docs WHERE applicant_id=".$_SESSION['id']." AND doc_name='id".$_SESSION['id'].".pdf'";
			$_run = mysqli_query($conn02, $_sql);
			$_num = mysqli_num_rows($_run);
			$_row = mysqli_fetch_array($_run);

			if ($_num == 0) {
				# code...
				$_SESSION['error'] .= "<p><strong class='text-danger'>Error</strong> occured whle uploading ID.Please make sure you upload <strong>ALL</strong> (5) documents in <strong>.pdf</strong> format only</p>";
				header("Location: feedback.php");
			}else{
				$_SESSION['error'] .= "";
				header("Location: feedback.php");
			}			

		}
	}
	
	if ($_FILES['doc2_']['name'] == "")
	{
		// fetch from db
		$_sql = "SELECT * FROM candidate_docs WHERE applicant_id=".$_SESSION['id']." AND doc_name='transcript".$_SESSION['id'].".pdf'";
		$_run = mysqli_query($conn02, $_sql);
		$_num = mysqli_num_rows($_run);
		$_row = mysqli_fetch_array($_run);

		// if ($_num == 0) {
		if (($_num == 0) || (($_num !=0) && ($_row['status_id'] ==2) || ($_row['status_id'] ==1))) {		
			$_SESSION['error'] .= "<p>You did not select your Academic Transcript to be uploaded.</p>";
			header("Location: feedback.php");
		}else{
			$_SESSION['error'] .= "";
			// unset($_SESSION['error']);
		}
	}
	else
	{
		$explo = explode(".", $_FILES['doc2_']['name']);
		$ext = end($explo) ;
		$allow = "pdf";

		if ($ext != $allow) {
			$_SESSION['TypeError'] .= "<p>Academic Transcript file type not allowed</p>";
			header("Location: feedback.php");

		}elseif ($ext == $allow) {

			$file_name = "transcript".$_SESSION['id'].".pdf";

			if (is_uploaded_file($_FILES['doc2_']['tmp_name'])) {

				//escape back slashes w/ preg_replace()!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
				$p2 = getcwd();
				$p2 = str_replace("\\", "\/", $p2);
				
				$path = getcwd()."/$file_name";

				// fetch from db
				$_sql = "SELECT * FROM candidate_docs WHERE applicant_id=".$_SESSION['id']." AND doc_name='".$file_name."'";
				$_run = mysqli_query($conn02, $_sql);
				$_num = mysqli_num_rows($_run);
				$_row = mysqli_fetch_array($_run);

				//if file found
				if ($_num == 1) {

					$sql = "UPDATE candidate_docs SET status_id = 1 WHERE doc_name ='$file_name'";
				}
				else{

					$sql = "INSERT INTO candidate_docs(applicant_id, status_id, doc_type_id, doc_name, doc_location) VALUES($user, 1, 2, '$file_name', '$p2')"; 
				}	

				if (move_uploaded_file($_FILES['doc2_']['tmp_name'], $path)) {
						# code...
					$run =mysqli_query($conn02, $sql);
					$affect = mysqli_affected_rows($conn02);

					if ($affect == 1) {
						# code...
						
						$sql = "SELECT * FROM candidate_docs WHERE applicant_id=".$_SESSION['id']." AND doc_name='".$file_name."'";
						$run_ = mysqli_query($conn02, $sql);
						$num = mysqli_num_rows($run_);
						$row = mysqli_fetch_array($run_);
						$status_id = $row['status_id'];
						$doc_id = $row['doc_type_id'];

						if ($num == 1) {
							
							$_SESSION['feedback'] .= "<p>Academic Transcript uploaded</p>";
							header("Location: feedback.php");	
						}
						
					}
				}
			}

		}
		else
		{
			// fetch from db
			$_sql = "SELECT * FROM candidate_docs WHERE applicant_id=".$_SESSION['id']." AND doc_name='transcript".$_SESSION['id'].".pdf'";
			$_run = mysqli_query($conn02, $_sql);
			$_num = mysqli_num_rows($_run);
			$_row = mysqli_fetch_array($_run);

			if ($_num == 0) {
				$_SESSION['error'] .= "<p><strong class='text-danger'>Error</strong> occured whle uploading Academic Transcript.Please make sure you upload <strong>ALL</strong> (5) documents in <strong>.pdf</strong> format only</p>";
				header("Location: feedback.php");
			}else{
				$_SESSION['error'] .= "";
				header("Location: feedback.php");
			}

		}
	}

	if ($_FILES['doc3_']['name'] == "") 
	{
		// fetch from db
		$_sql = "SELECT * FROM candidate_docs WHERE applicant_id=".$_SESSION['id']." AND doc_name='qualification".$_SESSION['id'].".pdf'";
		$_run = mysqli_query($conn02, $_sql);
		$_num = mysqli_num_rows($_run);
		$_row = mysqli_fetch_array($_run);

		// if ($_num == 0) {		
		if (($_num == 0) || (($_num !=0) && ($_row['status_id'] ==2) || ($_row['status_id'] ==1))) {		
			$_SESSION['error'] .= "<p>You did not select Highest Qualification to be uploaded.</p>";
			// header("Location: feedback.php");
		}else{
			$_SESSION['error'] .= "";
		}
	}
	else
	{
		$explo = explode(".", $_FILES['doc3_']['name']);
		$ext = end($explo) ;
		$allow = "pdf";

		if ($ext != $allow) {
			$_SESSION['TypeError'] .= "<p>Qualification file type not allowed, pdf format only.</p>";
			header("Location: feedback.php");
		}elseif ($ext == $allow) {
			
			$file_name = "qualification".$_SESSION['id'].".pdf";

			if (is_uploaded_file($_FILES['doc3_']['tmp_name'])) {
				
				//escape back slashes w/ preg_replace()!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
				$p2 = getcwd();
				$p2 = str_replace("\\", "\/", $p2);

				$path = getcwd()."/$file_name";

				// fetch from db
				$_sql = "SELECT * FROM candidate_docs WHERE applicant_id=".$_SESSION['id']." AND doc_name='".$file_name."'";
				$_run = mysqli_query($conn02, $_sql);
				$_num = mysqli_num_rows($_run);
				$_row = mysqli_fetch_array($_run);

				//if file found
				if ($_num == 1) {

					$sql = "UPDATE candidate_docs SET status_id = 1 WHERE doc_name ='$file_name'";
				}
				else{

					$sql = "INSERT INTO candidate_docs(applicant_id, status_id, doc_type_id, doc_name, doc_location) VALUES($user, 1, 3, '$file_name', '$p2')"; 
				}

				if (move_uploaded_file($_FILES['doc3_']['tmp_name'], $path)) {

					$run =mysqli_query($conn02, $sql);
					$affect = mysqli_affected_rows($conn02);

					if ($affect == 1) {
						# code...
						$sql = "SELECT * FROM candidate_docs WHERE applicant_id=".$_SESSION['id']." AND doc_name='".$file_name."'";
						$run_ = mysqli_query($conn02, $sql);
						$num = mysqli_num_rows($run_);
						$row = mysqli_fetch_array($run_);
						$status_id = $row['status_id'];
						$doc_id = $row['doc_type_id'];

						if ($num == 1) {
							# code...
							
							$_SESSION['feedback'] .= "<p>Highest Qualification uploaded</p>";
							header("Location: feedback.php");
					}
						
					}
				}
			}
		}
		else
		{
			// fetch from db
			$_sql = "SELECT * FROM candidate_docs WHERE applicant_id=".$_SESSION['id']." AND doc_name='qualification".$_SESSION['id'].".pdf'";
			$_run = mysqli_query($conn02, $_sql);
			$_num = mysqli_num_rows($_run);
			$_row = mysqli_fetch_array($_run);

			if ($_num == 0) {		
				$_SESSION['error'] .= "<p><strong class='text-danger'>Error</strong> occured whle uploading Highest Qualification.Please make sure you upload <strong>ALL</strong> (5) documents in <strong>.pdf</strong> format only</p>";
				header("Location: feedback.php");
			}else{
				$_SESSION['error'] .= "";
			}			

	}
	}

	if ($_FILES['doc4_']['name'] == "") 
	{
		// fetch from db
		$_sql = "SELECT * FROM candidate_docs WHERE applicant_id=".$_SESSION['id']." AND doc_name='proof".$_SESSION['id'].".pdf'";
		$_run = mysqli_query($conn02, $_sql);
		$_num = mysqli_num_rows($_run);
		$_row = mysqli_fetch_array($_run);

		// if ($_num == 0) {
		if (($_num == 0) || (($_num !=0) && ($_row['status_id'] ==2) || ($_row['status_id'] ==1))) {			
		$_SESSION['error'] .= "<p>You did not select your Proof of Residence to be uploaded.</p>";
		// header("Location: feedback.php");
		}else{
			$_SESSION['error'] .= "";
		}
	}
	else
	{
		$explo = explode(".", $_FILES['doc4_']['name']);
		$ext = end($explo) ;
		$allow = "pdf";

		if ($ext != $allow) {

			$_SESSION['TypeError'] .= "<p>Proof of residence file type not allowed, pdf format only.</p>";
			header("Location: feedback.php");

		}elseif ($ext == $allow) {
			
			$file_name = "proof".$_SESSION['id'].".pdf";

			if (is_uploaded_file($_FILES['doc4_']['tmp_name'])) {
				
				//escape back slashes w/ preg_replace()!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
				$p2 = getcwd();
				$p2 = str_replace("\\", "\/", $p2);

				$path = getcwd()."/$file_name";

				// fetch from db
				$_sql = "SELECT * FROM candidate_docs WHERE applicant_id=".$_SESSION['id']." AND doc_name='".$file_name."'";
				$_run = mysqli_query($conn02, $_sql);
				$_num = mysqli_num_rows($_run);
				$_row = mysqli_fetch_array($_run);

				//if file found
				if ($_num == 1) {

					$sql = "UPDATE candidate_docs SET status_id = 1 WHERE doc_name ='$file_name'";
				}
				else{

					$sql = "INSERT INTO candidate_docs(applicant_id, status_id, doc_type_id, doc_name, doc_location) VALUES($user, 1, 4, '$file_name', '$p2')"; 
				}

				if (move_uploaded_file($_FILES['doc4_']['tmp_name'], $path)) {

					$run =mysqli_query($conn02, $sql);
					$affect = mysqli_affected_rows($conn02);

					if ($affect == 1) {
						# code...
						$sql = "SELECT * FROM candidate_docs WHERE applicant_id=".$_SESSION['id']." AND doc_name='".$file_name."'";
						$run_ = mysqli_query($conn02, $sql);
						$num = mysqli_num_rows($run_);
						$row = mysqli_fetch_array($run_);
						$status_id = $row['status_id'];
						$doc_id = $row['doc_type_id'];

						if ($num == 1) {
							
							$_SESSION['feedback'] .= "<p>Proof of Residence uploaded</p>";
							header("Location: feedback.php");
						}
						
					}
				}
			}	
		}
		else
		{
			// fetch from db
			$_sql = "SELECT * FROM candidate_docs WHERE applicant_id=".$_SESSION['id']." AND doc_name='proof".$_SESSION['id'].".pdf'";
			$_run = mysqli_query($conn02, $_sql);
			$_num = mysqli_num_rows($_run);
			$_row = mysqli_fetch_array($_run);

			if ($_num == 0) {		
				$_SESSION['error'] .= "<p><strong class='text-danger'>Error</strong> occured whle uploading Proof of Residence.Please make sure you upload <strong>ALL</strong> (5) documents in <strong>.pdf</strong> format only</p>";
				header("Location: feedback.php");
			}else{
				$_SESSION['error'] .= "";
			}			

		}
	}

	if ($_FILES['doc5_']['name'] == "") 
	{
		// fetch from db
		$_sql = "SELECT * FROM candidate_docs WHERE applicant_id=".$_SESSION['id']." AND doc_name='banking".$_SESSION['id'].".pdf'";
		$_run = mysqli_query($conn02, $_sql);
		$_num = mysqli_num_rows($_run);
		$_row = mysqli_fetch_array($_run);

		// if ($_num == 0) {
		if (($_num == 0) || (($_num !=0) && ($_row['status_id'] ==2) || ($_row['status_id'] ==1))) {				
			$_SESSION['error'] .= "<p>You did not select your Proof of Banking Details to be uploaded.</p>";
			// header("Location: feedback.php");
		}else{
			$_SESSION['error'] = "";

		}
	}
	else
	{

		$explo = explode(".", $_FILES['doc5_']['name']);
		$ext = end($explo) ;
		$allow = "pdf";

		if ($ext != $allow) {
			$_SESSION['TypeError'] .= "<p>Proof of banking file type not allowed, pdf format only.</p>";
			header("Location: feedback.php");
		}elseif ($ext == $allow) 
		{
			$file_name = "banking".$_SESSION['id'].".pdf";

			if (is_uploaded_file($_FILES['doc5_']['tmp_name'])) {
				
				//escape back slashes w/ preg_replace()!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
				$p2 = getcwd();
				$p2 = str_replace("\\", "\/", $p2);
				
				$path = getcwd()."/$file_name";

				// fetch from db
				$_sql = "SELECT * FROM candidate_docs WHERE applicant_id=".$_SESSION['id']." AND doc_name='".$file_name."'";
				$_run = mysqli_query($conn02, $_sql);
				$_num = mysqli_num_rows($_run);
				$_row = mysqli_fetch_array($_run);

				//if file found
				if ($_num == 1) {

					$sql = "UPDATE candidate_docs SET status_id = 1 WHERE doc_name ='$file_name'";
				}
				else{

					$sql = "INSERT INTO candidate_docs(applicant_id, status_id, doc_type_id, doc_name, doc_location) VALUES($user, 1, 5, '$file_name', '$p2')"; 
				}

				if (move_uploaded_file($_FILES['doc5_']['tmp_name'], $path)) {

					$run =mysqli_query($conn02, $sql);
					$affect = mysqli_affected_rows($conn02);

					if ($affect == 1) {
						# code...
						$sql = "SELECT * FROM candidate_docs WHERE applicant_id=".$_SESSION['id']." AND doc_name='".$file_name."'";
						$run_ = mysqli_query($conn02, $sql);
						$num = mysqli_num_rows($run_);
						$row = mysqli_fetch_array($run_);
						$status_id = $row['status_id'];
						$doc_id = $row['doc_type_id'];

						if ($num == 1) {
							
							$_SESSION['feedback'] .= "<p>Proof of Banking Details uploaded</p>";
							header("Location: feedback.php");
				}
					}
				}
			}
		}
		else
		{
			// fetch from db
			$_sql = "SELECT * FROM candidate_docs WHERE applicant_id=".$_SESSION['id']." AND doc_name='banking".$_SESSION['id'].".pdf'";
			$_run = mysqli_query($conn02, $_sql);
			$_num = mysqli_num_rows($_run);
			$_row = mysqli_fetch_array($_run);

			if ($_num == 0) {		
				$_SESSION['error'] .= "<p><strong class='text-danger'>Error</strong> occured whle uploading Proof of Banking Details.Please make sure you upload <strong>ALL</strong> (5) documents in <strong>.pdf</strong> format only</p>";
				header("Location: feedback.php");
			}else{
				$_SESSION['error'] .= "";
			}
	
		}
	}


?>