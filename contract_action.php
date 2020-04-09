<?php
error_reporting(E_ALL^E_NOTICE);
session_start();
require_once "db.php";
$user_id = $_SESSION['id'];

//========= set path to be used for...
	$path_init = getcwd()."/docs/";
	$path_init = str_replace("\\", "\/", $path_init);
	$path = $path_init.$user_id;

// loads all files, actions to take and other related data for candidate
if (isset($_POST['Contracts'])) {
	//new query for name
	$qry_ = "SELECT * FROM applicant_personal_details WHERE applicant_id =".$_SESSION['id'];
	$run_ = mysqli_query($conn, $qry_);
	$num_ = mysqli_num_rows($run_);															#	''
	$row_ = mysqli_fetch_array($run_);

	//declare user first name
	$name = ucfirst($row_['First_Name']);

	// fetch logged in user files
	$_sql = "SELECT * FROM doc_type WHERE doc_type_id >= 7";														# SQL...
	$_run = mysqli_query($conn02, $_sql);													#	''
	$_num = mysqli_num_rows($_run);															#	''
	$_row = mysqli_fetch_array($_run);														# ...SQL.

	// check if SQL was a success
	if ($_run)
	{
		$files = scandir($path);
		foreach ($files as $index => $file) {

			switch ($file) {
				case "unsigned_mictseta$user_id.pdf":
					// code...
					$contract_blk .= "<p><a href='$path/$file'>unsigned_mictseta$user_id.pdf</a></p>";
					break;

				case "unsigned_induction$user_id.pdf":
					// code...
					$contract_blk .= "<p><a href='$path/$file'>unsigned_induction$user_id.pdf</a></p>";
					break;

				case "unsigned_contract$user_id.pdf":
					// code...
					$contract_blk .= "<p><a href='$path/$file'>unsigned_contract$user_id.pdf</a></p>";
					break;

				default:
					$contract_blk = "";
				break;
			}
		}

		echo "<div class='' role='navigation'>

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

		<div class='text- well'>
			<h3>Congratulations, $name! </h3>
			<br>
			<p>Your application was successful.</p>
			<p>Below are some documents related to your employment.</p>
			<p>Please click the file names below to view/download.</p>
			$contract_blk
		</div>
		</div>
	<br>
	<div role='tabpanel' class='tab-pane' id='upload'>
		<div id='upload_reply'></div>
		<div id='upload_reply'></div>
					<form method='post' enctype='multipart/form-data' style='padding-bottom:10px' id='contract_upload'>
						<table class='table table-bordered table-responsive table-striped thumbnail'>
							<tr>
								<th><h4>Contract Name</h4></th>
								<th><h4>Contract Status</h4></th>
								<th colspan='2' class='text-center'><h4>Action</h4></th>
							</tr>";

		//counter variable
		$count = 1;

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

			//call setContractStatus func
			$status_name = setContractStatus($status_id);
			$fileRowData = setDocRowdata($type_name, $status_name, $name, $status_id, $run_, $num_, $doc_name);

			//display contract upload table/form
			echo "$fileRowData";

			$count++;
		} while ($_row = mysqli_fetch_array($_run));

		echo "	</table>
						<div class='col-md-12' style='padding-bottom:50px'>
							<button class='btn btn-block btn-primary' type='submit' name='submit' id='submit_btn'><span class='fa fa-upload fa-lg'></span> Upload Files</button>
						</div>

					</form></div>";
	}

}

//========= ******************************************************************** =========//
//========= setting doc table Details (user GUI)
function setDocRowdata($type_name, $status_name, $name, $status_id, $run_, $num_, $doc_name)
{
	// check if SQL executed
	if ($run_ && $num_ == 1)
	{
		$link = "docs/".$_SESSION['id']."/$doc_name";

		switch ($status_id)
		{

			case 3:
				return "<tr>
									<td>$type_name</td>
									<td>$status_name </td>
									<td>
										<input  type='file'  disabled>
									</td>
									<td>
										<a href='$link'class='btn btn-xs btn-success' target='_blank'>
												View File
										</a>
									</td>
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
					<td>
						<a href='$link'class='btn btn-xs btn-success' target='_blank'>
								View File
						</a>
					</td>
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
					<td>
						<a href='$link'class='btn btn-xs btn-success' target='_blank'>
								View File
						</a>
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
							No file//
						</a>
					</td>
				</tr>
			";

	}
}

//========= setting doc status name
function setContractStatus($status_id)
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
?>
