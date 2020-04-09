<?php

//========= dependencies CONSTANTS
 	error_reporting(E_ALL^E_NOTICE);
	session_start();
	require 'db.php';
	$user_id = $_SESSION['id'];

	//========= set path to be used for...
		$path_init = getcwd()."/docs/";
		$path_init = str_replace("\\", "\/", $path_init);
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

			$db_file_name = setFileName($i, $user_id);


			//========= ($x) number of array elements
			$x = count($file_ary);

			//========= set counter var
			$i = 1;
			$init_doc_type = 7;
			foreach ($file_ary as $file) {

				//========= call setFileName(x,y)
				$db_file_name = setFileName($i, $user_id);

				// fetch file from db if(exists)
				$qry = "SELECT * FROM candidate_docs WHERE applicant_id = $user_id AND doc_name = '$db_file_name' AND doc_type_id <= 7";
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
				else {

					$file_type_error_msg = checkFileType($file['name']);
					$file_size_error_msg = checkFileSize($file);

					if (!$file_type_error_msg && !$file_size_error_msg) {

						//========= check if SQL ran successfully
						switch ($_num) {
							case 1:
							//========= declare SQL (UPDATE)
								$sql = "UPDATE candidate_docs SET status_id = 1 WHERE doc_name ='$db_file_name'";
								$doc_run = mysqli_query($conn02, $sql);
								break;

							case 0:
							//========= declare SQL (INSERT)
								$sql = "INSERT INTO candidate_docs(applicant_id, status_id, doc_type_id, doc_name, doc_location) VALUES($user_id, 1, $init_doc_type, '$db_file_name', '$path')";
								$doc_run = mysqli_query($conn02, $sql);
								break;
						}

							//========= run SQL
						if ($doc_run) {

							//========= affected rows in DB
							$affect = mysqli_affected_rows($conn02);

							if ($affect == 1) {

								$dir_path = getcwd()."/$db_file_name";

								//========= check if file is moved to tmp dir
								if ( (is_uploaded_file($file['tmp_name'])) && (	move_uploaded_file($file['tmp_name'], $dir_path))) {
									setSuccesMsg($i);
								}
								else {
									setFailMsg($i);
								}
							}
							else {
								setFailMsg($i)."<br>";
							}

						}
						else {
								setFailMsg($i)."<br>";
						}

					}
					else {

						print "$file_type_error_msg <br>";
						print "$file_size_error_msg <br>";

					}
				}
				$init_doc_type++;
				$i++;
			}

		}

														//	**********functions********** //
//========= ********************************************************************* =========//

//========= file not uploaded msg
function setFailMsg($i){

	switch($i){
		case 1:
			# code...
			$file_fail_msg = "<span class='fa fa-remove fa-lg text-danger'></span > MICTSETA Contract was not uploaded. <br>";
			break;

		case 2:
			# code...
			$file_fail_msg = "<span class='fa fa-remove fa-lg text-danger'></span > Induction Form was not uploaded. <br>";
			break;

		case 3:
			# code...
			$file_fail_msg = "<span class='fa fa-remove fa-lg text-danger'></span > Employment Contract was not uploaded. <br>";
			break;
	}
	echo "$file_fail_msg";
}

//========= file uploaded msg
function setSuccesMsg($i){
	switch($i){
		case 1:
		# code...
		$file_success = "<span class='fa fa-check-circle-o fa-lg text-success'></span > MICTSETA Contract uploaded.<br>";
		break;

		case 2:
		# code...
		$file_success = "<span class='fa fa-check-circle-o fa-lg text-success'></span > Induction Form uploaded.<br>";
		break;

		case 3:
		# code...
		$file_success = "<span class='fa fa-check-circle-o fa-lg text-success'></span > Employment Contract uploaded.<br>";
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

//========= check file size
function checkFileSize($file){
	if($file['size'] > 7500000){
		return "<span class='fa fa-remove fa-lg text-danger'></span > Your file (".$file['name'].") is too big, please try another one. <br>";
	}
}

//========= check if file was selected func...
function checkFileIsSelected($_num, $i)
{

	if ($_num != 1)
	{
	//========= conditions for error msg
		switch ($i)
		{
			case 1:
				# code...
				$file_error = "MICTSETA contract";
				break;

			case 2:
				# code...
				$file_error = "Induction contract";
				break;

			case 3:
				# code...
				$file_error = "Employment contract";
				break;
		}
		return "<span class='fa fa-remove fa-lg text-danger'></span > You have not selected your $file_error to be uploaded";
	}

}

//========= setFileName func...
function setFileName($var01, $var02)
{
	//========= assign file name to save in DB
			switch ($var01)
			{
				case 1:
					# code...
					$file_name = "signed_mictseta$var02.pdf";
					break;

				case 2:
					# code...
					$file_name = "signed_induction$var02.pdf";
					break;

				case 3:
					# code...
					$file_name = "signed_contract$var02.pdf";
					break;
			}
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
