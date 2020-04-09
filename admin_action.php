 <?php
  	error_reporting(E_ALL^E_NOTICE);
 	session_start();
	require_once "db.php";

	//SQL for experience and (highest?)qualification

// SELECT applicant_experiences.Job_Name, applicant_experiences.Company_Name, applicant_experiences.Duties, applicant_person_qualification_field_of_studies.Field_Of_Study, applicant_nqf_qualifications.Qualification_Name
// FROM applicant_experiences

// INNER JOIN
// applicant_person_qualification_field_of_studies ON applicant_experiences.applicant_id = applicant_person_qualification_field_of_studies.applicant_id

// INNER JOIN applicant_nqf_qualifications ON applicant_nqf_qualifications.id = applicant_person_qualification_field_of_studies.applicant_nqf_qualification_id

// INNER JOIN applicant_qual_statuses ON applicant_qual_statuses.id = applicant_person_qualification_field_of_studies.applicant_qual_status_id

// WHERE applicant_experiences.applicant_id = 213 AND applicant_qual_statuses.id = 1 ORDER BY applicant_nqf_qualifications.applicant_nqf_level_id DESC LIMIT 1;

	// loads/searches all users and their uploaded files
 	if ((isset($_POST['search'])) || (isset($_POST['loadCandidates'])))
 	{
		//search
			if (isset($_POST['keyword']))
			{
				$list = array();
				$key = $_POST['keyword'];

				if ($key != "" && strlen($key) >= 4) {
					# code...
					// $key = $_POST['keyword'];
					// select by surname
					$_sql_ = "SELECT First_Name, applicant_id FROM applicant_personal_details WHERE First_Name LIKE '%".$key."%'";
					$_run_ = mysqli_query($conn, $_sql_);												# run/execute SQL
					$_num_ = mysqli_num_rows($_run_);													# get number of rows returned from SQL
					$_row_ = mysqli_fetch_array($_run_);

					// if surname found
					if ($_run_ && $_num_ > 0 ) {
						//loop while by row_
						do {
							# code...
							$id = $_row_['applicant_id'];

							array_push($list, $id);

						} while ( $_row_ = mysqli_fetch_array($_run_));
						// SELECT * FROM shortlist_candidates WHERE applicant_id = $id

						$in_string = implode(", ", $list);

						$sql = "SELECT * FROM shortlist_candidates WHERE applicant_id IN ($in_string)";
						$run = mysqli_query($conn02, $sql);
						$num = mysqli_num_rows($run);												# get number of rows returned from SQL
						$row_ = mysqli_fetch_array($run);
					}
					else{

					 	// select by first name
						$_sql = "SELECT * FROM applicant_personal_details WHERE Surname LIKE '%$key%'";
						$_run = mysqli_query($conn, $_sql);											# run/execute SQL
						$_num = mysqli_num_rows($_run);													# get number of rows returned from SQL
						$_row = mysqli_fetch_array($_run);

						// if name found
						if ($_run && $_num > 0 ) {
							do {
								# code...
								$id = $_row['applicant_id'];
											# assign DB returned data to aray($row_)
								array_push($list,$id);

							} while ( $_row = mysqli_fetch_array($_run));

								$in_string = implode(", ", $list);

								$sql = "SELECT * FROM shortlist_candidates WHERE applicant_id IN ($in_string)";
								$run = mysqli_query($conn02, $sql);
								$num = mysqli_num_rows($run);												# get number of rows returned from SQL
								$row_ = mysqli_fetch_array($run);

						}else{
							$sql = "SELECT * FROM shortlist_candidates";
							$run = mysqli_query($conn02, $sql);
							$num = mysqli_num_rows($run);												# get number of rows returned from SQL
						}
					}
				}else{
					$sql = "SELECT * FROM shortlist_candidates";
					$run = mysqli_query($conn02, $sql);
					$num = mysqli_num_rows($run);												# get number of rows returned from SQL
					$row_ = mysqli_fetch_array($run);											# assign DB returned data to aray($row_)
				}

			}else{
				$sql = "SELECT * FROM shortlist_candidates";
				$run = mysqli_query($conn02, $sql);											# run/execute SQL
				$num = mysqli_num_rows($run);												# get number of rows returned from SQL
				$row_ = mysqli_fetch_array($run);											# assign DB returned data to aray($row_
			}

		//validate that SQL query was executed in the DB
		if ($num > 0) {

			// loop for as many times as the rows fetched from the above SQL=>(SELECT)
			do {
				// assign/instantiate relevant
				// print_r($list);
				// echo "$in_string";

				$id = $row_['applicant_id'];										# assign returned data to variables on every loop
				$data_target = "data-target='#action".$id."'";						# ...
		        $action = "id='action".$id."'";										# ...

				//SQL for experience and (highest?)qualification

				$additional_info_sql = "SELECT applicant_experiences.Job_Name, applicant_experiences.Company_Name, applicant_experiences.Duties, applicant_person_qualification_field_of_studies.Field_Of_Study, applicant_nqf_qualifications.Qualification_Name FROM applicant_experiences INNER JOIN applicant_person_qualification_field_of_studies ON applicant_experiences.applicant_id = applicant_person_qualification_field_of_studies.applicant_id INNER JOIN applicant_nqf_qualifications ON applicant_nqf_qualifications.id = applicant_person_qualification_field_of_studies.applicant_nqf_qualification_id INNER JOIN applicant_qual_statuses ON applicant_qual_statuses.id = applicant_person_qualification_field_of_studies.applicant_qual_status_id WHERE applicant_experiences.applicant_id = $id AND applicant_qual_statuses.id = 1 ORDER BY applicant_nqf_qualifications.applicant_nqf_level_id DESC LIMIT 1";
				$additional_info_run = mysqli_query($conn, $additional_info_sql);
				$additional_info_num = mysqli_num_rows($additional_info_run);

				// if query/SQL for additional info "runs well '&&' also returns rows greater than 0"
				if ($additional_info_run && ($additional_info_num > 0)) {
					# code...
					$additional_info_row = 	mysqli_fetch_array($additional_info_run);

					$Job_Name = $additional_info_row['Job_Name'];
					$Company_Name = $additional_info_row['Company_Name'];
					$duties = $additional_info_row['Duties'];
					$employ_quali = $additional_info_row['Qualification_Name'];
					$Field_Of_Study = "in ".$additional_info_row['Field_Of_Study'];

					$Job = strtoupper($Job_Name);

					if ($Job == "N/A" || $Job == "NA" || $Job == "NONE") {
						# code...
						$experience = "N/A";
					}else{

						$experience = "$Job_Name at $Company_Name";
					}


				}else{
					$i = "hayi";
				}

		        // fetch candidate names from DB
		        $sql_ = "SELECT * FROM applicants WHERE id = $id";
        		$run_ = mysqli_query($conn, $sql_);											# run/execute SQL
				$num_ = mysqli_num_rows($run_);
				$row_ = mysqli_fetch_array($run_);
				$email = $row_['email'];

		        // fetch candidate names from DB
		        $_sql = "SELECT * FROM applicant_personal_details WHERE applicant_id = $id";
        		$_run = mysqli_query($conn, $_sql);											# run/execute SQL
				$_num = mysqli_num_rows($_run);												# get number of rows returned from SQL
				$_row = mysqli_fetch_array($_run);
				$occupationId = $_row['applicant_current_occupation_id'];
				$employ_skills = $_row['Skills'];


				$First_Name = ucfirst($_row['First_Name']);											# assign DB data to display
				$Surname = ucfirst($_row['Surname']);
				$cell_1 = $_row['Contact_Number'];													# 		''
				$cell_2 = $_row['Alt_Contact_Number'];


				$link = "docs/$id";								# <----- link to all personal docments

				//qry for address
				$addr_qry = "SELECT * FROM applicant_addresses WHERE applicant_id = $id";
				$addr_run = mysqli_query($conn, $addr_qry);
				$addr_row = mysqli_fetch_array($addr_run);
				$addr_num = mysqli_num_rows($addr_run);

				// loop for references
				$ref_sql = "SELECT * FROM applicant_references WHERE applicant_id = $id";
				$ref_run = mysqli_query($conn, $ref_sql);
				$ref_num = mysqli_num_rows($ref_run);
				$ref_row = mysqli_fetch_array($ref_run);

				if ($ref_run && $ref_num > 0 ) {
					# code...
					$ref_blk = "";
					$count = 1;
					do {
						# code...
						$ref_id = $ref_row['id'];
						$nmbr = $ref_row['Contact_Number'];
						$ref_name = $ref_row['Reference_Name'];
						$ref_email = $ref_row['Email_address'];
						$relationship = ucfirst($ref_row['Relationship']);

						// doc_name to search by
						$ref_doc_name = "ref$ref_id"."_user$id";

						// fetch ref status
						$stat_sql = "SELECT * FROM candidate_docs WHERE doc_name ='$ref_doc_name'";
						$stat_run = mysqli_query($conn02, $stat_sql);
						$stat_num = mysqli_num_rows($stat_run);
						$stat_row = mysqli_fetch_array($stat_run);


						if ($stat_run && $stat_num > 0) {

							$ref_stat = $stat_row['status_id'];

							if ($ref_stat == 3) {

								$ref_status = "<span class='fa fa-check-circle-o text-success'></span ><em>  Approved</em>";

							}
							if ($ref_stat == 2) {

								$ref_status = "<span class='glyphicon glyphicon-remove-circle text-danger'></span ><em>  Rejected</em>";

							}

						}else{

							$ref_status = "<span class='fa fa-question-circle  text-default'></span ><em>  Awaiting Approval</em>";

						}

						$ref_blk .= "
								<tr>
									<th>Reference_$count</th>
									<td>
										<p>$ref_name</p>
										<p>$nmbr</p>
										<p>$ref_email</p>
										<p>$relationship</p>
									</td>
						     		<td>
						     			<p id='ref$id'>$ref_status</p>
						     			<p class='btn-group'>
											<button type='button' class='btn btn-xs btn-warning ref_reject' id='ref_reject$id' ref_id='$ref_id' user-id='$id'>Reject</button>
											<button type='button' class='btn btn-xs btn-success ref_approve' id='ref_reject$id' ref_id='$ref_id' user-id='$id'>Approve</button>
										</p>
									</td>
								</tr>
									";
						$count++;
					} while ($ref_row = mysqli_fetch_array($ref_run));

				}else{
					$ref_blk = "<td>N/A</td>";
				}

				//
				if ($addr_run && $addr_num > 0) {
					# code...
					$line1 = $addr_row['Address_Line_1'];
					$line2 = $addr_row['Address_Line_2'];
					$line3 = $addr_row['Address_Line_3'];
					$code = $addr_row['Postal_Code'];

					// Current_Occupation SQL
					$employ_qry = "SELECT Current_Occupation FROM applicant_current_occupations WHERE id = $occupationId";
					$employ_run = mysqli_query($conn, $employ_qry);
					$employ_num = mysqli_num_rows($employ_run);
					$employ_row = mysqli_fetch_array($employ_run);

					//test if Current_Occupation found
					if ( $employ_num > 0) {
						# code if occupation is submitted
						$Current_Occupation = "<td colspan='2'>".$employ_row['Current_Occupation']."</td>";
					}else{
						# code if occupation is not submitted
						$Current_Occupation = "<td><textarea></textarea></td>";
					}
					// address details
					$address_blk = "
					<table class='table table-striped table- table-bordered address' data-id='$id' style='font-size:18px;list-style:none;'>

						<tr id='other-blk'>
							<th>Address</th>
							<td colspan='2'>
								<p>$line1</p>
								<p>$line2</p>
								<p>$line3</p>
								<p>$code</p>
							</td>
						</tr>

						<tr>
							<th>Email</th>
							<td colspan='2'>$email</td>
						</tr>
						<tr>
							<th>Cell</th>
							<td colspan='2'>$cell_1 <span></td>
						</tr>
						<tr>
							<th>Occupation</th>
							$Current_Occupation
						</tr>
						<tr>
							<th>Experience</th>
							<td colspan='2'>$experience</td>
						</tr>
						<tr>
							<th>Qualification</th>
							<td colspan='2'>$employ_quali $Field_Of_Study</td>
						</tr>
						<tr>
							<th>Skills</th>
							<td colspan='2'>$employ_skills</td>
						</tr>
						$ref_blk
					</table>";
				}

				//just added thumbnail to accordion div
		        echo "
			        <div class='panel-group container-fluid thumbnail table-responsive' id='accordion'>
			            <div class='panel-default'>
			              <div class='panel-heading'><span class='pull-right fa fa-angle-double-down' style='padding-bottom:3px'></span>
			                <a href='#action$id' class='person' data-toggle='collapse' data-parent='#accordion' $data_target id=''>
				                <h3 class='panel-title' style='color:black;'> <span class='fa fa-user fa-lg'></span>
				                $First_Name $Surname		($id)
				                </h3>
			                </a>
			            </div>
			            <div class='panel-collapse collapse active' $action style='background-color:white;'>

			                  <div class='panel'>
			                    <div class='row'>

			                      <div class='col-md-12 container-fluid'>
			                      $address_blk
			                        <table class='table table-striped table-concerned table-bordered doc_files' data-id='$id' style='font-size:18px;list-style:none;' id='files'>
				                        <tr class='text-center'><td colspan='3'><h3>Documents</td></h3></tr>
				                        <tr>
											<th><h4>Document Name</h4></th>
											<th><h4>Document Status</h4></th>
											<th  class='text-center'><h4>Action</h4></th>
										</tr>
			                        ";

			                        // fetch all files uploaded by user
															$sql_ = "SELECT doc_name, candidate_docs_id, doc_location, status_id FROM candidate_docs WHERE applicant_id = $id AND doc_type_id != 6";

	                        		$run_ = mysqli_query($conn02, $sql_);			# run...
	                        		$row_ = mysqli_fetch_array($run_);				# assign DB data to array
	                        		$num_ = mysqli_num_rows($run_);					# get number of rows returned from SQL

	                        		// validate that number of returned rows is greater than > 0
	                        		if ($num_ > 0)
	                        		{

	                        			// loop for each entry in the DB table related to specific user
	                        			do {

																	$doc_location = $row_['doc_location'];					# assign returned DB data to avriables on every iteration
																	$status_id = $row_['status_id'];						# ...
			                        		$doc_name = $row_['doc_name'];							# ...
			                        		$candidate_docs_id = $row_['candidate_docs_id'];		# ...

			                        		$link = "docs/$id/$doc_name";							# assign document href attr
			                        		$approval = "id='approval$candidate_docs_id'";
			                        		$rejection = "id='reject$candidate_docs_id'";			# create document specific id attr
			                        		$status_result = "id='status_result$candidate_docs_id'";

			                        		// display 1 file name every iteeration
											echo "
												";

		                        			// check document status id for output
		                        			if ($status_id == 3)
		                        			{
		                        				// Approved
				                        		echo "
				                        		<tr>
		                        					<td>
		                        						<a href='$link' target='_blank'> $doc_name </a>
			                        				</td>
				                        			<td $status_result role='group' style='opacity:0.8;'>
				                        				<span class='glyphicon glyphicon-ok-circle fa-lg text-success' ></span >
				                        				<em>Approved</em>
				                        			</td>
					                        		<td class='btn-group' role='group'>
														  <button type='button' class='btn btn-xs btn-warning reject' $rejection data-id='$candidate_docs_id' user-id='$id'>Reject</button>
														  <button type='button' class='btn btn-xs btn-success approve' $approval data-id='$candidate_docs_id' user-id='$id'>Approve</button>
													</td>
				                        			";

		                        			}

		                        			if ($status_id == 2)
		                        			{
		                        				// Rejected
				                        		echo "
				                        		<tr>
		                        					<td>
		                        						<a href='$link' target='_blank'> $doc_name</a>
			                        				</td>
				                        			<td $status_result role='group' style='opacity:0.8;'>
					                        			<span class='glyphicon glyphicon-remove-circle fa-lg text-danger' ></span >
					                        			<em>Rejected</em>
				                        			</td>
					                        		<td class='btn-group' role='group'>
														  <button type='button' class='btn btn-xs btn-warning reject' $rejection data-id='$candidate_docs_id' user-id='$id'>Reject</button>
														  <button type='button' class='btn btn-xs btn-success approve' $approval data-id='$candidate_docs_id' user-id='$id'>Approve</button>
													</td>
				                        			";

		                        			}

		                        			if ($status_id == 1)
		                        			{
		                        				// Not evaluated
		                        				echo "
		                        				<tr>
		                        					<td>
		                        						<a href='$link' target='_blank'> $doc_name</a>
			                        				</td>
				                        			<td $status_result role='group' style='opacity:0.8;'>
					                        			<span class='fa fa-question-circle fa-lg text-warning' ></span >
					                        			<em>Awaiting approval</em>
				                        			</td>
				                        			<td class='btn-group' role='group'>
														  <button type='button' class='btn btn-xs btn-warning reject' $rejection data-id='$candidate_docs_id' user-id='$id'>Reject</button>
														  <button type='button' class='btn btn-xs btn-success approve' $approval data-id='$candidate_docs_id' user-id='$id'>Approve</button>
													</td>
													";
		                        			}


		                        			echo "</tr>";

		                        		} while ( $row_ = mysqli_fetch_array($run_));

	                        		}
	                        		else
		                    		{
		                    			// output if candidate files not found in DB

                        				echo "<tr><td colspan='3'>This candidate has no documents in the system yet, contact if needed.</td></tr>";
	                        		}

									$_link = "docs/$id";
									// looping for the google form doc personal dir
	                        		if (is_dir($_link)) {

	                        			#scanning files in dir
	                        			$files = scandir($_link);

	                        			#loop too search for specific filename
	                        			foreach ($files as $index => $file) {

	                        				// if file found, display
	                        				if ($file == "interview$id.pdf") {
	                        					# code...
	                        					$_link = "docs/$id/$file";
	                        					echo "
	                        						<tr>
			                        					<td colspan='3'>
			                        						<a href='$_link' target='_blank'> $file</a>
				                        				</td>
				                        			</tr>";


	                        				}
	                        				if ($file == "skills$id.pdf") {
	                        					# code...
	                        					$_link = "docs/$id/$file";
	                        					echo "
	                        						<tr>
			                        					<td colspan='3'>
			                        						<a href='$_link' target='_blank'> $file</a>
				                        				</td>
				                        			</tr>";
	                        				}

																	if ($file == "profile_pic$id.jpg" || $file == "profile_pic$id.JPG" || $file == "profile_pic$id.jpeg" || $file == "profile_pic$id.JPEG") {
	                        					# code...
	                        					$_link = "docs/$id/$file";
	                        					echo "
	                        						<tr>
			                        					<td colspan='3'>
			                        						<a href='$_link' target='_blank'> $file</a>
				                        				</td>
				                        			</tr>";
	                        				}

	                        			}
	                        		}


			                        echo "
	                        			<tr class='text-danger text-center'style='font-size:13px;;'><td colspan='3'><strong>Click file name to view</strong></td></tr>
			                        	</table>
				                  </div>

				                </div>
				              </div>


					        </div>
					        </div>
					    </div>";
			// loop condition below
			} while ($row_ = mysqli_fetch_array($run));

		}else{
			// if no match found msg
			echo
				"<div class='well text-center'>
					<h3><i class='fa fa-exclamation-triangle text-warning fa-4x'></i></h3>
					<p>
						Please make sure that you have typed the correct name or surname,
					</p>
					<h3>OR</h3>
					<p>Press Ctrl/command(Mac) + F on your keyboard </p>
					<button class='btn btn-block btn-primary' id='_reload' type='button'>refresh</buton>
				</div>";
		}
 	}

	// btn to reject any pdf document in file type DB tbl
 	if (isset($_POST['Reject']))
	{
		// assign avriables from $_POST array/Ajax object
		$doc_id = $_POST['doc_id'];
		$user = $_POST['user_id'];

		// search DB for rejecting Admin

		$_sql = "SELECT * FROM doc_admin WHERE applicant_id =".$_SESSION['id'];			# SQL...
		$_run = mysqli_query($conn02, $_sql);											#	''
		$_num = mysqli_num_rows($_run);													#	''
		$_row = mysqli_fetch_array($_run);												# ...SQL.

		$admin = $_row['doc_admin_id'];													# get doc_admin_id from DB

		// authenticate rejecting Admin

		if ($_num == 1)
		{
			// change document status candidate_docs DB tbl

			$sql = "UPDATE candidate_docs SET status_id = 2 WHERE candidate_docs_id = $doc_id AND applicant_id = $user";
			$run = mysqli_query($conn02, $sql);
			$affec = mysqli_affected_rows($conn02);


			if ($affec == 1)
			{
				// add most recent document status and time stamp in approvals tbl

				$sql = "INSERT INTO approvals(admin_id, status_id, candidate_doc_id, date_time) VALUES($admin, 2, $doc_id, NOW())";
				$run = mysqli_query($conn02, $sql);
				$affect = mysqli_affected_rows($conn02);

				// check if 1, and only one row was ADDED by SQL

				if ($affect == 1)
				{
					// output
					echo "1";
				}else{
					echo "0";
				}

			}else{
				echo "Document may already be rejected!!!";
			}
		}
	}

	// btn to approve any pdf document in file type DB tbl
	if (isset($_POST['Approve']))
	{
		// assign avriables from $_POST array/Ajax object

		$doc_id = $_POST['doc_id'];
		$user = $_POST['user_id'];

		// search DB for approving Admin

		$_sql = "SELECT * FROM doc_admin WHERE applicant_id =".$_SESSION['id'];			# SQL...
		$_run = mysqli_query($conn02, $_sql);											# 	''
		$_num = mysqli_num_rows($_run);													#	''
		$_row = mysqli_fetch_array($_run);												# ...SQL.

		$admin = $_row['doc_admin_id'];													# get doc_admin_id from DB

		// authenticate approving Admin

		if ($_num == 1)
		{
			// change document status candidate_docs DB tbl

			$sql = "UPDATE candidate_docs SET status_id = 3 WHERE candidate_docs_id = $doc_id AND applicant_id = $user";
			$run = mysqli_query($conn02, $sql);											# ...
			$affec = mysqli_affected_rows($conn02);										# check if SQL altered any rows

			// check if 1, and only one row was UPDATED by SQL

			if ($affec == 1)
			{
				// add most recent document status and time stamp in approvals tbl

				$sql = "INSERT INTO approvals(admin_id, status_id, candidate_doc_id, date_time) VALUES($admin, 3, $doc_id, NOW())";
				$run = mysqli_query($conn02, $sql);										#
				$affect = mysqli_affected_rows($conn02);								# return number of rows added by SQL

				// check if 1, and only one row was ADDED by SQL

				if ($affect == 1)
				{
					echo "1";
				}else{
					echo "0";
				}
			}else{
				echo "Document may already be approved!!!";
			}
		}
	}

	// function to update doc status on click(NO PAGE REFESH !!!)
	if (isset($_POST['statusUpdate'])) {
		sleep(1);
		$docId = $_POST['docId'];
		$userId = $_POST['userId'];

		$_sql = "SELECT * FROM candidate_docs WHERE candidate_docs_id = $docId AND applicant_id = $userId";			# SQL...
		$_run = mysqli_query($conn02, $_sql);																		#	''
		$_num = mysqli_num_rows($_run);																				#	''
		$_row = mysqli_fetch_array($_run);
		$status_id = $_row['status_id'];

		if ($_run) {
			if ($_num == 1) {

				if ($status_id == 3) {

					echo "<span class='glyphicon glyphicon-ok-circle fa-lg text-success' ></span ><em> Approved</em>";

				}elseif ($status_id == 2) {

					echo "<span class='glyphicon glyphicon-remove-circle fa-lg text-danger' ></span ><em> Rejected</em>";

				}else{

					echo "<span class='glyphicon glyphicon-question-circle fa-lg' ></span ><em> Awaiting approval</em>";

				}
			}else{
				echo "num != 1";
			}
		}else{
			echo "did not run";
		}
	}

	// reject candidate reference
	if (isset($_POST['ref_approve'])) {

		# DOM variables
		$applicant_id = $_POST['user_id'];
		$ref_id = $_POST['ref_id'];

		// search DB for rejecting Admin
		$_sql = "SELECT * FROM doc_admin WHERE applicant_id =".$_SESSION['id'];			# SQL...
		$_run = mysqli_query($conn02, $_sql);											#	''
		$_num = mysqli_num_rows($_run);													#	''
		$_row = mysqli_fetch_array($_run);												# ...SQL.

		$admin = $_row['doc_admin_id'];													# get doc_admin_id from DB


		// authenticate rejecting Admin
		if ($_run && $_num == 1)
		{
			//create appropreate doc name to search by...
			$doc_name = "ref$ref_id"."_user$applicant_id";

			// fecth for refference if in DB
			$ref_qry = "SELECT * FROM candidate_docs WHERE doc_name = '$doc_name' AND (applicant_id = $applicant_id)";
			$ref_run = mysqli_query($conn02, $ref_qry);											#	''
			$ref_num = mysqli_num_rows($ref_run);													#	''
			$ref_row = mysqli_fetch_array($ref_run);

			$ref_to_update = $ref_row['candidate_docs_id'];


			// check if doc/ref is found...
			if ( $ref_run && $ref_num > 0) {

				// ...update selected row by id...
				$query_ref = "UPDATE candidate_docs SET status_id = 3 WHERE candidate_docs_id = '$ref_to_update' AND applicant_id = '$applicant_id'";
				$run_ref = mysqli_query($conn02, $query_ref);
				$afc_ref = mysqli_affected_rows($conn02);

				if ($run_ref && ($afc_ref > 0)) {

					echo "Reference Updated To Approved Status!!!";

				}else{
					echo "Something went wrong while approving the Reference!!!";
				}

			}else{//num num num


				$ref_qry_ = "INSERT INTO candidate_docs(applicant_id, status_id, doc_type_id, doc_name, doc_location) VALUES($applicant_id, 3, 6, '$doc_name', 'num num num')";
				$ref_run_ = mysqli_query($conn02, $ref_qry_);
				$afc_ref = mysqli_affected_rows($conn02);

				echo "$afc_ref Reference Rated Approved Status!!!";
				// if ($ref_run_) {
				// 	# code...
				// 	echo "insert executed!!!";
				// }

			}

		}
	}

	// reject candidate reference
	if (isset($_POST['ref_reject'])) {

		# DOM variables
		$applicant_id = $_POST['user_id'];
		$ref_id = $_POST['ref_id'];

		// search DB for rejecting Admin
		$_sql = "SELECT * FROM doc_admin WHERE applicant_id =".$_SESSION['id'];			# SQL...
		$_run = mysqli_query($conn02, $_sql);											#	''
		$_num = mysqli_num_rows($_run);													#	''
		$_row = mysqli_fetch_array($_run);												# ...SQL.

		$admin = $_row['doc_admin_id'];													# get doc_admin_id from DB


		// authenticate rejecting Admin
		if ($_run && $_num == 1)
		{
			//create appropreate doc name to search by...
			$doc_name = "ref$ref_id"."_user$applicant_id";

			// fecth for refference if in DB
			$ref_qry = "SELECT * FROM candidate_docs WHERE doc_name = '$doc_name' AND (applicant_id = $applicant_id)";
			$ref_run = mysqli_query($conn02, $ref_qry);											#	''
			$ref_num = mysqli_num_rows($ref_run);													#	''
			$ref_row = mysqli_fetch_array($ref_run);

			$ref_to_update = $ref_row['candidate_docs_id'];


			// check if doc/ref is found...
			if ( $ref_run && $ref_num > 0) {

				// ...update selected row by id...
				$query_ref = "UPDATE candidate_docs SET status_id = 2 WHERE candidate_docs_id = '$ref_to_update' AND applicant_id = '$applicant_id'";
				$run_ref = mysqli_query($conn02, $query_ref);
				$afc_ref = mysqli_affected_rows($conn02);

				if ($run_ref && ($afc_ref > 0)) {

					echo "Reference Updated To Rejected Status!!!";

				}
				else{
					echo "Reference Might already be Rejected, please see status";
				}

			}else{

				$ref_qry_ = "INSERT INTO candidate_docs(applicant_id, status_id, doc_type_id, doc_name, doc_location) VALUES($applicant_id, 2, 6, '$doc_name', 'num num num')";
				$ref_run_ = mysqli_query($conn02, $ref_qry_);
				$afc_ref = mysqli_affected_rows($conn02);


				if ($ref_run_ && ($afc_ref > 0)) {

					echo "Reference Rejected!!!";
				}

			}

		}

	}
 ?>
