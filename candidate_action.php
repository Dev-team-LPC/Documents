<?php
error_reporting(E_ALL^E_NOTICE);
session_start();
require_once "db.php";
$user_id = $_SESSION['id'];

//========= set path to be used for...
	$path_init = getcwd()."/docs/";
	$path_init = str_replace("\\", "\/", $path_init);
	$path_ = $path_init.$user_id;
 	// loads all files, actions to take and other related data for candidate
 	if (isset($_POST['CandidateDocs']))
 	{
		//new query for name
		$qry_ = "SELECT * FROM applicant_personal_details WHERE applicant_id =".$_SESSION['id'];
		$run_ = mysqli_query($conn, $qry_);
		$num_ = mysqli_num_rows($run_);															#	''
		$row_ = mysqli_fetch_array($run_);

		//declare user first name
		$name = $row_['First_Name'];

		$files = scandir($path_);
		foreach ($files as $index => $file) {

			switch ($file) {
				case "unsigned_mictseta$user_id.pdf":
					// code...
					$contract_blk += 1;
					break;

				case "unsigned_induction$user_id.pdf":
					// code...
					$contract_blk += 1;
					break;

				case "unsigned_contract$user_id.pdf":
					// code...
					$contract_blk += 1;
					break;

				default:
					$contract_blk = "";
				break;
			}
		}
		if ($contract_blk > 0) {
//			// code...
			 echo "<p>Congratulations, your application was successful, please<a href='http://documents.littlepig.agency/contracts.php' class='text-danger'> click here</a> to download and sign your contracts. </p>";
//	header("Location: contracts.php);
		//added container-fluid div && content
}		
		echo
		"<div class='' role='navigation'>

			<div class=''>
				<!-- Nav tabs -->
				<ul class='nav nav-tabs nav- text-center' role='tablist'>
					<li style='padding-right:0px' role='presentation' class='active col-md-6 col-xs-6' id='welcome_tab'>
						<a class='' href='#welcome' aria-controls='welcome' role='tab' data-toggle='tab'>
						<span class='badge'>1</span> Welcome</a>
					</li>

					<li style='padding-left:0px' role='presentation' class='col-md-6 col-xs-6' >
						<a  href='#upload' aria-controls='upload' role='tab' data-toggle='tab' id='upload_tab'>
						<span class='badge'>2</span> Upload</a>
					</li>
				</ul>
			</div>

			<div class='tab-content'>
				<div role='tabpanel' class='tab-pane active' id='welcome'>
					<div class='container-fluid'>
						<h2>Hello $name </h2>";

						echo "<h4>Before uploading your documents, please take note of the following:</h4>
						<ul class=''>
							<li>Documents must be in PDF format only e.g. ID_copy.pdf.</li>
							<li>All Documents certified, and the date certified must be within the last three months
								i.e. If you are submitting the document in April, it must have been certified either in February, March or April itself.</li>
							<li>Select all the required documents before clicking the upload button.</li>
							<li>The content of all the documents must be clearly visible in order for the document to be approved.</li>
							<li>After you have successfully submitted all documents, please keep checking the status of the documents. If they are rejected, you must reupload a correct copy, until the document is accepted.</li>
							<br>
						</ul>";
    //                                         if ($contract_blk > 0) {
                        // code...
//echo "<p>Congratulations, your application was successfull, please <a href='http://documents.littlepig.agency/contracts.php' class='text-danger'>click here</a> to download and sign your contracts.</p>"
//                        header("Location: contracts.php");


  //                                               }


					echo"<!--if (contract){echo link to contracts page}  -->
						<label class='text-danger'>*Please make sure that you have read and understood the above instructions before proceeding to uploading*</label>
					</div>
				</div>
			<br>
			<div role='tabpanel' class='tab-pane' id='upload'>
				<div id='upload_reply'></div>
				";

		// fetch logged in user files
 		$_sql = "SELECT * FROM doc_type WHERE doc_type_id <= 5";														# SQL...
		$_run = mysqli_query($conn02, $_sql);													#	''
		$_num = mysqli_num_rows($_run);															#	''
		$_row = mysqli_fetch_array($_run);														# ...SQL.

		// check if SQL was a success
		if ($_run)
		{
			echo "<form method='post' enctype='multipart/form-data' style='padding-bottom:10px' id='file_upload'>
							<table class='table table-bordered table-responsive table-striped thumbnail'>
								<tr>
									<th><h4>Document Name</h4></th>
									<th><h4>Document Status</h4></th>
									<th colspan='2' class='text-center'><h4>Action</h4></th>
								</tr>";

					//counter variable
					$count = 1;

					// loop by number of file found
					do {
						// assign DB data
						$type_name = $_row['type_name'];
						$doc_type_id = $_row['doc_type_id'];
						$name = "name='file[]'";

						// fetch candidate related data from candidate_docs tbl
				 		$sql_ = "SELECT * FROM candidate_docs WHERE applicant_id =".$_SESSION['id']." AND doc_type_id = $doc_type_id";			# SQL...
						$run_ = mysqli_query($conn02, $sql_);													#	''
						$num_ = mysqli_num_rows($run_);															#	''
						$row_ = mysqli_fetch_array($run_);														# ...SQL.

						$candidate_docs_id = $row_['candidate_docs_id'];
						$status_id = $row_['status_id'];
						$doc_name = $row_['doc_name'];

						$status_name = setDocStatus($status_id);
						$fileRowData = setDocRowdata($type_name, $status_name, $name, $status_id, $run_, $num_, $doc_name);

						echo "$fileRowData";
						$count++;
					// loop condition
					} while ($_row = mysqli_fetch_array($_run));

					echo "	</table>
									<div class='col-md-12' style='padding-bottom:'>
										<button class='btn btn-block btn-primary' type='submit' name='submit' id='submit_btn'><span class='fa fa-upload fa-lg'></span> Upload Files</button>
									</div>
								</form>";

								$path = "docs/".$_SESSION['id'];

						echo"
					</div>";
		}

	}

													//	**********functions********** //
//========= ********************************************************************* =========//

//========= setting doc table Details
function setDocRowdata($type_name, $status_name, $name, $status_id, $run_, $num_, $doc_name)
{
	// check if SQL executed
	if ($run_ && $num_ == 1)
	{

			$link = "/docs/".$_SESSION['id']."/$doc_name";

			// output based on document status id from DB
			switch ($status_id)
			{
				case 3:
					return "<tr>
							<td>$type_name</td>
							<td>$status_name</td>
							<td>
								<input  type='file'  disabled>
							</td>
				<!--			<td>
								<a href='$link'class='btn btn-xs btn-success' target='_blank'>
										View File
								</a>
							</td>  -->
						</tr>
					";
				break;

				case 2:
					return "<tr>
						<td>$type_name</td>
						<td>$status_name</td>
						<td>
							<input  type='file' $name>
						</td>
<!--						<td>
							<a href='$link'class='btn btn-xs btn-success' target='_blank'>
									View File
							</a>
						</td> -->
					</tr>
					";
				break;

				case 1:
					return "<tr>
						<td>$type_name</td>
						<td>$status_name</td>
						<td>
							<input  type='file' $name>
						</td>
<!--						<td>
							<a href='$link'class='btn btn-xs btn-success' target='_blank'>
									View File
							</a>
						</td> -->
					</tr>
					";
				break;

				default:
					return "
					<tr>
						<td>$type_name</td>
						<td>$status_name</td>
						<td class=''>
							<input  type='file' $name>
						</td>
						<td>
							No file
						</td>
					</tr>
					";
				break;
			}

	}
	else{
			return"
				<tr>
					<td>$type_name</td>
					<td>$status_name</td>
					<td class=''>
						<input  type='file' $name>
					</td>
					<td>
						<a class='btn btn-sm btn-default' disabled>
							No file
						</a>
					</td>
				</tr>
			";

	}
}

//========= setting doc status name
function setDocStatus($status_id)
{
	// condition for displaying correct doc status
	switch ($status_id) {
		case 3:
			return "<span class='fa fa-check-circle-o fa-lg text-success'></span >  <em>Approved</em>";
			break;

		case 2:
			return "<span class='fa fa-remove fa-lg text-danger'></span ><em>  Rejected</em>";
			break;

		case 1:
			return "<span class='fa fa-question-circle fa-lg' text-warning'></span >  <em>Awaiting Approval</em>";
			break;

		default :
			return "<span class='fa fa-exclamation-circle fa-lg' text-default'></span >  <em>Not uploaded</em>";
			break;
	}
}
