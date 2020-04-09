$(document).ready(function() {

	//call loadCandidateDoc
	loadCandidateDoc();

	// load all users and uploaded files for admin
	function loadCandidateDoc(){

		$.ajax({
			url    :"candidate_action.php",
			method :"POST",
			data   :{CandidateDocs:1},
			beforeSend:function(){
				$("#loader").html("<div class='row text-center' style='padding-bottom:20px'><span class='fa fa-spinner fa-spin fa-4x'></span></div>");
			},
			success:function(data){
				$("#content").html(data);
			}
		});
	}
	$(document).ready(function() {

});

	$(document).delegate("#file_upload", "submit", function(event){
		event.preventDefault();

		$.ajax({
			url    :"action_2.php",
			method :"POST",
			data   :new FormData(this),
			contentType:false,
			processData: false,
			beforeSend:function () {
				$("#submit_btn").html("<span class='fa fa-gear fa-spin fa-lg'></span > uploading...");
			},
			success:function (data) {

				$("#submit_btn").html("<span class='fa fa-upload fa-lg'></span> Upload Files");
				$("#upload_reply").html(data);
			}
		})
	});

	// $("#submit_btn").hide();


	$(document).scroll(function() {
		if ($(this).scrollTop() > 20) {
			$("#foota").hide();
		}else {
			$("#foota").fadeIn('slow');
		}
	});


});
