jQuery(document).ready(function($) {

$("#justconnect").on("change", function(){
	if($(this).is(":checked")){
		$("#connecttotwitter").show();
	} else {
		$("#connecttotwitter").hide();
	}
});		
	$("#getall_followers_of").on('click', function(e){
		e.preventDefault();
		var max_numb = $('[name="twmaxnumb"]').val();
		var max_follow = $('[name="maxfollow"]').val();
		var remainquota = $('[name="remainquota"]').val();
		if($("#deactivatehelper").prop("checked") == true) {
			var deact = $("#deactivatehelper").val();
		} else {
			var deact = "";
		}
			if($("#deactivatehelper").prop("checked") == false) {
				if(parseInt(max_numb) < parseInt(max_follow) && parseInt(max_numb) < parseInt(remainquota)) {
					$("#wait").show();
					$('#all_results').remove();
					$("#mydata").remove();
					$("input[type='submit']").attr('disabled', true);
					var init_request = $(this).val();
					var master_user = $('[name="twusername"]').val();


				var search = {
					'init_follow' : init_request,
					'user' : master_user,
					'maxnum' : max_numb,
					'nohelper' : deact
				}

					$.ajax({
							url: "handle.php",
							type: "POST",
							data: search,
							success: function(response) {
							$("input[type='submit']").attr('disabled', false);
								$(response).appendTo("#followreport_area");
								$("#wait").hide();
								$("#followdata").html("");
								$("#follows").appendTo("#followdata");
								$("#helper").html("");
								$("#helpercontent").appendTo("#helper");
								$("#followrem").insertAfter("#helpercontent");
							},
							
							error:function(response){
									$("#wait").hide();
									$("input[type='submit']").attr('disabled', false);
							}
					});
				} else {
					if(parseInt(max_follow) < parseInt(remainquota)) {
						alert("It's not safe to follow more than " + max_follow + "!" );
					} else {
						alert("It's not safe to follow more than " + remainquota + "!" );
					}
				}
			} else {
					$("#wait").show();
					$('#all_results').remove();
					$("#mydata").remove();
					$("input[type='submit']").attr('disabled', true);
					var init_request = $(this).val();
					var master_user = $('[name="twusername"]').val();
					var search = {
						'init_follow' : init_request,
						'user' : master_user,
						'maxnum' : max_numb,
						'nohelper' : deact
					}

						$.ajax({
								url: "handle.php",
								type: "POST",
								data: search,
								success: function(response) {
								$("input[type='submit']").attr('disabled', false);
									$(response).appendTo("#followreport_area");
									$("#wait").hide();
									$("#followdata").html("");
									$("#follows").appendTo("#followdata");
									$("#helper").html("");
									$("#helpercontent").appendTo("#helper");
									$("#followrem").insertAfter("#helpercontent");
								},
								
								error:function(response){
										$("#wait").hide();
										$("input[type='submit']").attr('disabled', false);
								}
						});	
			}
	});
	
	// UNFOLLOW
	$("#unfollow").on("click", function(e){
		e.preventDefault();
		$("#wait").show();
		$("#mydata").remove();
		$('#all_results').remove();
			$("input[type='submit']").attr('disabled', true);	
		var value = $(this).val();
		var limit = $("#unfollwmaxnumb").val();	
			var request = {
				'req' : value,
				'limit': limit
			}
			
			$.ajax({
				url: "handle.php",
				type: "POST",
				data: request,
				success: function(response){
			$("input[type='submit']").attr('disabled', false);	
			$("#wait").hide();
			$(response).appendTo("#unfollowreport_area");
					$("#followdata").html("");
					$("#follows").appendTo("#followdata");
					$("#helper").html("");
					$("#helpercontent").appendTo("#helper");
					$("#followrem").insertAfter("#helpercontent");
				},
				error: function(err){
				$("#wait").hide();
				$(err).appendTo("#unfollowreport_area");
				}
			});
		
	});
	
	// Follow Back
	$("#followback").on("click", function(e){
		e.preventDefault();
		var limit = $("#unfollwmaxnumb").val();
		var max_follow = $('[name="maxfollow"]').val();
		var remainquota = $('[name="remainquota"]').val();
		if($("#deactivatehelper").prop("checked") == false) {
			var deact = $("#deactivatehelper").val();
		} else {
			var deact = "";
		}	
		if($("#deactivatehelper").prop("checked") == false)	{
			if(parseInt(limit) <= parseInt(max_follow) && parseInt(limit) < parseInt(remainquota)){
		$("#wait").show();
		$("#mydata").remove();
		$('#all_results').remove();
		$("input[type='submit']").attr('disabled', true);	
		var value = $(this).val();			
			var request = {
				'followback' : value,
				'follback': limit,
				'nohelper' : deact
			}
			
			$.ajax({
				url: "handle.php",
				type: "POST",
				data: request,
				success: function(response){
			$("input[type='submit']").attr('disabled', false);	
			$("#wait").hide();
			$(response).appendTo("#unfollowreport_area");
					$("#followdata").html("");
					$("#follows").appendTo("#followdata");
					$("#helper").html("");
					$("#helpercontent").appendTo("#helper");
					$("#followrem").insertAfter("#helpercontent");
				},
				error: function(err){
				$("#wait").hide();
				$(err).appendTo("#unfollowreport_area");
				}
			});
			} else {
					if(parseInt(max_follow) < parseInt(remainquota)) {
						alert("It's not safe to follow more than " + max_follow + "!" );
					} else {
						alert("It's not safe to follow more than " + remainquota + "!" );
					}
			}
		} else {
		$("#wait").show();
		$("#mydata").remove();
		$('#all_results').remove();
		$("input[type='submit']").attr('disabled', true);	
		var value = $(this).val();		
			var request = {
				'followback' : value,
				'follback': limit,
				'nohelper' : deact
			}
			
			$.ajax({
				url: "handle.php",
				type: "POST",
				data: request,
				success: function(response){
			$("input[type='submit']").attr('disabled', false);	
			$("#wait").hide();
			$(response).appendTo("#unfollowreport_area");
					$("#followdata").html("");
					$("#follows").appendTo("#followdata");
					$("#helper").html("");
					$("#helpercontent").appendTo("#helper");
					$("#followrem").insertAfter("#helpercontent");
				},
				error: function(err){
				$("#wait").hide();
				$(err).appendTo("#unfollowreport_area");
				}
			});		
		}
	});	
	
});