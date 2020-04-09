$(document).ready(function() {

	loadContracts();

	function loadContracts(){
		$.ajax({
			url    :"contract_action.php",
			method :"POST",
			data   :{Contracts:1},
			beforeSend:function(){
				$("#loader").html("<div class='row text-center' style='padding-bottom:20px'><span class='fa fa-spinner fa-spin fa-4x'></span></div>");
			},
			success:function(data){
				$("#content").html(data);
			}
		});
	}

	$(document).delegate("#contract_upload", "submit", function(event){
		event.preventDefault();

		$.ajax({
			url    :"action_3.php",
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
					// loadContracts();
			}
		})
	});

	$(document).scroll(function() {
		if ($(this).scrollTop() > 20) {
			$("#foota").hide();
		}else {
			$("#foota").fadeIn('slow');
		}
	});

});
