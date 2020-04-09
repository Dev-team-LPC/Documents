$(document).ready(function() {

	// call/execute function
	loadAllUsers();

	// load all users and uploaded files for admin
	function loadAllUsers(){
		$.ajax({
			url    :"admin_action.php",
			method :"POST",
			data   :{loadCandidates:1},
			beforeSend:function(){
				$("#loader").html("<div class='row text-center' style='padding-bottom:20px'><span class='fa fa-spinner fa-spin fa-4x'></span><div style='padding-top:10px'><span class='fa fa-lg'>loading...</span></div></div>");
			},
			success:function(data){

				$('#content').html(data);
				// alert('loadAllUsers() executed...');
			}
		});
	}

	//search on keyup
	$('#search-text').keyup(function(){
		//
		var keyword = $('#search-text').val();

		if (keyword != "") {

			$.ajax({
				url    :"admin_action.php",
				method :"POST",
				data   :{search:1,keyword:keyword},
				beforeSend:function(){
					// alert(keyword);
				$("#search-btn").html("<span class='fa fa-spinner fa-spin'></span>");				},
				success:function(data){
					$("#search-btn").html("<i class='fa fa-search'></i>");
					$('#content').html(data);
				}
			});

		}
		else{
			loadAllUsers();
		}
	});

	// focus on clicked accordion/person
	$(document).delegate(".person", "click", function(e){
		$(this).focus();
		$(this).parent().css({"font-color":"red"});
		return false;
	});

	// reject doc btn
	$(document).delegate(".reject", "click", function(e){
        e.preventDefault();

        var doc_id = $(this).attr('data-id');
        var user_id = $(this).attr('user-id');

        $.ajax({
			url		:"admin_action.php",
			method	:"POST",
			data	:{Reject:1, doc_id:doc_id, user_id:user_id},
			beforeSend:function(){
				$("#reject"+doc_id).html("<i class='fa fa-spinner fa-spin '></i> loading");
				$("#status_result"+doc_id).html("<i class='fa fa-spinner fa-spin '></i> loading");
			},
			success	:function(data){

				if(data == 1) {

					loadDocStatus(doc_id, user_id);
					$("#reject"+doc_id).html("Reject");

				}else {
					alert(data);
					$("#reject"+doc_id).html("Reject");
					loadDocStatus(doc_id, user_id);
				}
			}
		});
    });

    // reload btn
	$(document).delegate("#_reload", "click",function(e){

		e.preventDefault();
		loadAllUsers();
	});

	// approve doc btn
	$(document).delegate(".approve", "click", function(e){
        e.preventDefault();

        var doc_id = $(this).attr('data-id');
        var user_id = $(this).attr('user-id');

        $.ajax({
			url		:"admin_action.php",
			method	:"POST",
			data	:{Approve:1, doc_id:doc_id, user_id:user_id},
			beforeSend:function()
			{
				$("#approval"+doc_id).html("<i class='fa fa-spinner fa-spin fa-lg'></i> loading");				// add  sipinning animation
				$("#status_result"+doc_id).html("<i class='fa fa-spinner fa-spin fa-lg'></i> loading");			// add  sipinning animation
			},
			success	:function(data){

				if(data == 1) {

					loadDocStatus(doc_id, user_id);						// Fn to load updated status on click
					$("#approval"+doc_id).html("Approve");				// remove sipinning animation

				}else {
					// alert(data);										// msg if doc already approved
					$("#approval"+doc_id).html("Approve");				// remove sipinning animation
					loadDocStatus(doc_id, user_id);
				}
			}
		});
    });

	// function for uploading status only but not whole page
	function loadDocStatus(docId, userId){

		$.ajax({
			url		:"admin_action.php",
			method	:"POST",
			data 	:{statusUpdate: 1, docId: docId, userId: userId},
			success	:function(data){

				// alert("loadDocStatus ran");
				$("#status_result"+docId).html(data);
			}
		});
	}

	// fade nav bar on scroll
  $(document).scroll(function() {
    if ($(this).scrollTop() > 20) {
    	$(".navbar").css({opacity: '0.7'});
    }else{
    	$(".navbar").css({opacity: '10'});
    }
	});

	// approve candidate reference
	$(document).delegate(".ref_approve", "click", function(e){

		var ref_id = $(this).attr("ref_id");
		var user_id = $(this).attr("user-id");

		$.ajax({
			url		:"admin_action.php",
			method	:"POST",
			data	:{ref_approve:1, ref_id:ref_id, user_id:user_id},
			success	:function(data){
				alert(data);
			}
		});
	});

	// reject candidate reference
	$(document).delegate(".ref_reject", "click", function(e){

		var ref_id = $(this).attr("ref_id");
		var user_id = $(this).attr("user-id");

		$.ajax({
			url		:"admin_action.php",
			method	:"POST",
			data	:{ref_reject:1, ref_id:ref_id, user_id:user_id},
			success	:function(data){
				alert(data);
			}
		});

	});

});
