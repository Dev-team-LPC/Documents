<?php
// $ll = "SELECT a.userID, b.usersFirstName, b.usersLastName  FROM databaseA.dbo.TableA a inner join database B.dbo.TableB b  ON a.userID=b.userID";
//========= dependencies CONSTANTS
 	error_reporting(E_ALL^E_NOTICE);
	session_start();
	require 'db.php';
	$user_id = $_SESSION['id'];

//========= set path to be used for...
	$path_init = getcwd()."/docs/";
	$path_init = str_replace("\\", "\/", $path_init);

//	$pathstr=rand(); 
//	$pathstr = md5($pathstr); 

//	$path = $path_init.$pathstr;


	$path = $path_init.$user_id;

	if (!is_dir($path))
	{
		//create directory
		mkdir($path,0755);
	}

	chdir($path);

//========= check if 2D array is set for uploading files/docs
	if (isset($_FILES)) {

		//========= call and assign func ... to var
	    $file_ary = reArrayFiles($_FILES['file']);

	    //========= ($x) number of array elements
		$x = count($_FILES['file']);

		//========= set counter var
		$i = 1;

	//========= loop through files array
		foreach ($file_ary as $file) {

      //========= call setFileName(x,y)
      $db_file_name = setFileName($i, $user_id);

			// fetch file from db if(exists)
			$qry = "SELECT * FROM candidate_docs WHERE applicant_id = $user_id AND doc_name = '$db_file_name' AND doc_type_id <= 5";
			$_run = mysqli_query($conn02, $qry);
			$_num = mysqli_num_rows($_run);
			$_row = mysqli_fetch_array($_run);

		//========= if no file is selected
			if (!$file['name']) {

		    //========= call checkFileIsSelected()

		        $error_msg = checkFileIsSelected($_num,$i);

		    //========= if there are error msgz
		        if ($error_msg) {
			        echo "<br> $error_msg <br>";
		        }

			}
			else{

				$newvar = 99;
				$file_type_error_msg = checkFileType($file['name']);
				$file_size_error_msg = checkFileSize($file);

				//========= if there is no file type error in this iteration
				if (!$file_type_error_msg && !$file_size_error_msg) {
						//========= check if SQL ran successfully
						switch ($_num) {
							case 1:
							//========= declare SQL (UPDATE)
								$sql = "UPDATE candidate_docs SET status_id = 1 WHERE doc_name ='$db_file_name'";
								$doc_run = mysqli_query($conn02, $sql);
								$newvar = mysqli_affected_rows($conn02);
								//var_dump($sql);
								//var_dump($doc_run);
								break;

							case 0:
							//========= declare SQL (INSERT)
								$sql = "INSERT INTO candidate_docs(applicant_id, status_id, doc_type_id, doc_name, doc_location) VALUES($user_id, 1, $i, '$db_file_name', '$path')";
								$doc_run = mysqli_query($conn02, $sql);
								$newvar = mysqli_affected_rows($conn02);
								// var_dump($doc_run);
//                                                                die("dead at case 0");
								break;
						}

						//========= run SQL
					if ($doc_run) {
//					var_dump($doc_run);
//					die("dead at $doc_run");

							//========= affected rows in DB
							$affect = mysqli_affected_rows($conn02);
//							var_dump($affect);
//							var_dump($newvar);
//							die("dead here");
							//if ($affect == 1) {
							if ($doc_run) {

									$dir_path = getcwd()."/$db_file_name";
//									var_dump($dir_path);
//									exit("Dead");
									//========= check if file is moved to tmp dir
									//if ( (is_uploaded_file($file['tmp_name'])) && (	move_uploaded_file($file['tmp_name'], $dir_path))) {
									if ( (is_uploaded_file($file['tmp_name']))) {
									       if(	move_uploaded_file($file['tmp_name'], $dir_path)) {

											//========= save file in correct dir
											setSuccesMsg($i)."<br>";
										}
									       else {
//										       print_r("FUCK OFF");
//										       exit("fuck off");
									       }
									}
									else {
										
//										print_r("FUCK OFF 2");
//									exit("fuck off 2");
										setFailMsg($i)."<br>";
									}

							}
							else{
//								print_r("fuck off 3");
//								die();
								setFailMsg($i)."<br>";
							}

						}
						else{
//							print_r("fuck off 4"); 
//							die();
							setFailMsg($i)."<br>";
						}

				}
				else{
					//========= execute
					echo "<br> $file_type_error_msg $file_size_error_msg <br>";
				}
			}
		//========= accumulate counter var
	        $i++;
		}

	}


									//	**********functions********** //
//========= ********************************************************************* =========//

//========= check file size
	function checkFileSize($file){
		if($file['size'] > 7500000){
			return "<span class='fa fa-remove fa-lg text-danger'></span > Your file (".$file['name'].") is too big, please try another one. <br>";
		}
	}

//========= file not uploaded msg
	function setFailMsg($i){

		switch($i){
			case 1:
				# code...
				$file_fail_msg = "<span class='fa fa-remove fa-lg text-danger'></span > ID was not uploaded. <br>";
				break;

			case 2:
				# code...
				$file_fail_msg = "<span class='fa fa-remove fa-lg text-danger'></span > Academic Transcript was not uploaded. <br>";
				break;

			case 3:
				# code...
				$file_fail_msg = "<span class='fa fa-remove fa-lg text-danger'></span > Highest Qualification was not uploaded. <br>";
				break;

			case 4:
				# code...
				$file_fail_msg = "<span class='fa fa-remove fa-lg text-danger'></span > Proof of Residence was not uploaded. <br>";
				break;

			case 5:
				# code...
				$file_fail_msg = "<span class='fa fa-remove fa-lg text-danger'></span > Proof of Banking Details was not uploaded. <br>";
				break;
		}
		echo "$file_fail_msg";
	}

//========= file uploaded msg
	function setSuccesMsg($i){

		switch($i){
			case 1:
				# code...
				$file_success = "<span class='fa fa-check-circle-o fa-lg text-success'></span > ID uploaded.<br>";
				break;

			case 2:
				# code...
				$file_success = "<span class='fa fa-check-circle-o fa-lg text-success'></span > Academic Transcript uploaded.<br>";
				break;

			case 3:
				# code...
				$file_success = "<span class='fa fa-check-circle-o fa-lg text-success'></span > Highest Qualification uploaded.<br>";
				break;

			case 4:
				# code...
				$file_success = "<span class='fa fa-check-circle-o fa-lg text-success'></span > Proof of Residence uploaded.<br>";
				break;

			case 5:
				# code...
				$file_success = "<span class='fa fa-check-circle-o fa-lg text-success'></span > Proof of Banking Details uploaded.<br>";
				break;
	}
		echo "$file_success";
	}

//========= check file type func
	function checkFileType($fileName) {
		//========= extract extension from file name
		$explo = explode(".", $fileName);
		$ext = strtoupper(end($explo));
		$allow = "PDF";

		//========= check uploaded file's extension
		if ($ext != $allow){
			return "<span class='fa fa-remove fa-lg text-danger'></span > ERROR $fileName!!! $ext is not allowed, plz upload PDFs only, e.g... file.pdf <br>";
		}

	}

//========= check if file was selected func...
	function checkFileIsSelected($_num, $i) {

		if ($_num != 1)
		{
		//========= conditions for error msg
			switch ($i)
			{
				case 1:
					# code...
					$file_error = "ID";
					break;

				case 2:
					# code...
					$file_error = "Academic Transcript";
					break;

				case 3:
					# code...
					$file_error = "Qualification";
					break;

				case 4:
					# code...
					$file_error = "Proof of Residence";
					break;

				case 5:
					# code...
					$file_error = "Banking Details";
					break;
			}
			return "<span class='fa fa-remove fa-lg text-danger'></span > You have not selected your $file_error to be uploaded";
		}


	}

//========= setFileName func...
	function setFileName($var01, $var02) {
    //========= assign file name to save in DB
        switch ($var01)
        {
        	case 1:
        		# code...
        		$file_name = "id$var02.pdf";
        		break;

        	case 2:
        		# code...
        		$file_name = "transcript$var02.pdf";
        		break;

        	case 3:
        		# code...
        		$file_name = "qualification$var02.pdf";
        		break;

        	case 4:
        		# code...
        		$file_name = "proof$var02.pdf";
        		break;

        	case 5:
        		# code...
        		$file_name = "banking$var02.pdf";
        		break;
        }

		//========= return var
		return $file_name;
	}

//========= fix $_FILES array arrangemnet func...
	function reArrayFiles($file_post) {

	//========= array details
	    $file_ary = array();
	    $file_count = count($file_post['name']);
	    $file_keys = array_keys($file_post);

	//========= loop thru array to rearrange
	    for ($i=0; $i<$file_count; $i++) {
	        foreach ($file_keys as $key) {
	            $file_ary[$i][$key] = $file_post[$key][$i];
	        }
	    }

	//========= return var
	return $file_ary;
	}

?>
