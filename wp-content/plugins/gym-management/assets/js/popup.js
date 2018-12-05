jQuery(document).ready(function($) {	
//Category Add and Remove
  $("body").on("click", "#addremove", function(event)
   {
	   
	  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	  var docHeight = $(document).height(); //grab the height of the page
	  var scrollTop = $(window).scrollTop();
	  var model  = $(this).attr('model') ;
		$("#myModal_add_staff_member").css("cssText", "overflow: hidden !important;");
		$("#myModal_add_membership").css("cssText", "overflow: hidden !important;");
		
	
	   var curr_data = {
	 					action: 'gmgt_add_or_remove_category',
	 					model : model,
	 					dataType: 'json'
	 					};	
										
	 					$.post(gmgt.ajax, curr_data, function(response) { 
						
							$('.popup-bg').show().css({'height' : docHeight});
							$('.category_list').html(response);	
							return true; 					
	 					});	
	
  });

   $("body").on("click", ".close-btn", function(){	
		$( ".category_list" ).empty();
		$('.popup-bg').hide(); // hide the overlay
		
		}); 
	
		$("body").on("click", ".close-btn.specialization,.close-btn.role_type", function(){		
		
			$( ".category_list" ).empty();
			$("#myModal_add_staff_member").css("cssText", "overflow: scroll;display:block;");
			
			$('.popup-bg').hide(); // hide the overlay
		});		
		
		$("body").on("click", ".close-btn.membership_category,.close-btn.installment_plan", function(){		
		
			$( ".category_list" ).empty();
			
			$("#myModal_add_membership").css("cssText", "overflow: scroll;display:block;");
			
			$('.popup-bg').hide(); // hide the overlay
		
		});	
		 $("body").on("click", "#add_membership_btn", function(){		
			$("#myModal_add_membership").css("cssText", "overflow: scroll;display:block;");
			
		 });
		 $("body").on("click", "#add_staff_btn", function(){		
			$("#myModal_add_staff_member").css("cssText", "overflow: scroll;display:block;");
		
		 });
 
  
  $("body").on("click", ".btn-delete-cat", function(){		
		var cat_id  = $(this).attr('id') ;	
		 var model  = $(this).attr('model') ;
		 
		if(confirm("Are you sure want to delete this record?"))
		{
			var curr_data = {
					action: 'gmgt_remove_category',
					model : model,
					cat_id:cat_id,			
					dataType: 'json'
					};
					
					$.post(gmgt.ajax, curr_data, function(response) {						
						$('#cat-'+cat_id).hide();						
						$("#"+model).find('option[value='+cat_id+']').remove();						
						return true;				
					});			
		}
	});
	
	
  $("body").on("click", "#btn-add-cat", function(){	
        
		var category_name  = $('#category_name').val() ;
		var model  = $(this).attr('model');
		
		//return false;
		if(model == 'specialization')
		{
		   var categCheck = $('#specialization').multiselect();
		}		
		if(category_name != "")
		{
			var curr_data = {
					action: 'gmgt_add_category',
					model : model,
					category_name: category_name,			
					dataType: 'json'
					};
					
					/* $.post(gmgt.ajax, curr_data, function(response) {
						
						var json_obj = $.parseJSON(response);//parse JSON						
						$('.category_listbox .table').append(json_obj[0]);
						$('#category_name').val("");
						
						$('#'+model).append(json_obj[1]);
						categCheck.multiselect('rebuild');
						
						return false;					
					});	 */
					
					
					$.post(gmgt.ajax, curr_data, function(response) {
						
						var json_obj = $.parseJSON(response);//parse JSON	
                        if(json_obj[2]=="1")
						{
							$('.category_listbox .table').append(json_obj[0]);
							$('#category_name').val("");
							$('#'+model).append(json_obj[1]);
						   categCheck.multiselect('rebuild');
						}
						else {
							
							alert(json_obj[3]);
						}
						
						
						return false;					
					});	
		
		}
		else
		{
			alert("Please enter Category Name.");
		}
	});
 
  //End category Add Remove 
  $("#class_id").change(function(){
		$('#member_list').html('');
		var selection = $("#class_id").val();
		var optionval = $(this);
			var curr_data = {
					action: 'gmgt_load_user',
					class_list: $("#class_id").val(),			
					dataType: 'json'
					};
					$.post(gmgt.ajax, curr_data, function(response) {
						//alert(response);
					$('#member_list').append(response);	
					});
						
					
	});
//-----------load activity by category-------------
	$("#act_cat_id").change(function(){
		$('#activity_list').html('');
		var selection = $("#act_cat_id").val();
		var optionval = $(this);
			var curr_data = {
					action: 'gmgt_load_activity',
					activity_list: selection,			
					dataType: 'json'
					};
					$.post(gmgt.ajax, curr_data, function(response) {
						//alert(response);
					$('#activity_list').append(response);	
					});
						
					
	});


	
 
  //----------view Invoice popup--------------------
	 $("body").on("click", ".show-invoice-popup", function(event){
	

	  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	  var docHeight = $(document).height(); //grab the height of the page
	  var scrollTop = $(window).scrollTop();
	  var idtest  = $(this).attr('idtest');
	  var invoice_type  = $(this).attr('invoice_type');
	  
		//alert(idtest);
		//return false;
	   var curr_data = {
	 					action: 'gmgt_invoice_view',
	 					idtest: idtest,
	 					invoice_type: invoice_type,
	 					dataType: 'json'
	 					};	 	
							//alert('hello');					
	 					$.post(gmgt.ajax, curr_data, function(response) { 	
	 						//alert(response);	 
	 					$('.popup-bg').show().css({'height' : docHeight});							
						$('.invoice_data').html(response);	
						return true; 					
	 					});	
	
  });
  jQuery("body").on("click", ".view-nutrition", function(event){
	  var nutrition_id = $(this).attr('id');
	  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	  var docHeight = $(document).height(); //grab the height of the page
	  var scrollTop = $(window).scrollTop();
	   //alert(nutrition_id);
	   var curr_data = {
	 					action: 'gmgt_nutrition_schedule_view',
	 					nutrition_id: nutrition_id,			
	 					dataType: 'json'
	 					};
	 					//alert('hello');
	 					$.post(gmgt.ajax, curr_data, function(response) {
	 						
	 						//alert('hello');
	 						$('.popup-bg').show().css({'height' : docHeight});
							$('.category_list').html(response);	
	 						return true;
	 						
	 					
	 					
	 					});	
	 		}); 
 
		//-----------Display measurement by workout-------------
	$("#workout_id").change(function(){
		$('#workout_mesurement').html('');
		var selection = $("#workout_id").val();
		//alert(selection);
		var optionval = $(this);
			var curr_data = {
					action: 'gmgt_load_workout_measurement',
					workout_id: selection,			
					dataType: 'json'
					};
					$.post(gmgt.ajax, curr_data, function(response) {
						//alert(response);
					$('#workout_mesurement').text(response);	
					});
						
					
	});

	 jQuery("body").on("click", ".view_group_member", function(event){
		  var group_id = $(this).attr('id');
		  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
		  var docHeight = $(document).height(); //grab the height of the page
		  var scrollTop = $(window).scrollTop();
		   //alert(group_id);
		 // return false;
		   var curr_data = {
		 					action: 'gmgt_group_member_view',
		 					group_id: group_id,			
		 					dataType: 'json'
		 					};
		 					//alert('hello');
		 					$.post(gmgt.ajax, curr_data, function(response) {
		 						
		 						$('.popup-bg').show().css({'height' : docHeight});
								$('.category_list').html(response);	
		 						return true;
		 						
		 					
		 					
		 					});	
		 		}); 
	 
	 $(".activity_check").change(function(){
			
			//id = $(this).attr('id');
			//alert("Hello" + id);
			
			//$("#reps_sets_"+id).html('<P>Sets <input type="text" name = "sets_' + id + '"></p><P>Reps <input type="text" name = "reps_' + id + '"></p>');
			
			
		 if($(this).is(":checked"))
		{
			 //alert("chekked");
			 //$('#hmsg_message_sent').addClass('hmsg_message_block');
			 id = $(this).attr('id');
				//alert("Hello" + id);
			 string = '';
			
			string += '<div class="achilactiveadd"><span class="label"> Sets </span><input type="text" class="validate[required,custom[onlyNumberSp]]" maxlength="3"  name = "sets_' + id + '" id = "sets_' + id + '" placeholder="Sets"></div>';
			string += '<div class="achilactiveadd"><span class="label"> Reps</span> <input type="text" class="validate[required,custom[onlyNumberSp]]" maxlength="3" name = "reps_' + id + '" id = "reps_' + id + '" placeholder="Reps"></div>';
			string += '<div class="achilactiveadd"><span class="label"> KG </span><input type="text" class="validate[required,custom[onlyNumberSp]]" maxlength="3" name = "kg_' + id + '" id = "kg_' + id + '" placeholder="KG"></div>';
			string += '<div class="achilactiveadd"><span class="label">Rest Time </span><input type="text" class="validate[required,custom[onlyNumberSp]]" maxlength="3" name = "time_' + id + '" id = "time_' + id + '" placeholder="Min"></div>';
			
				$("#reps_sets_"+id).html(string);
			 
		}
		 else
		{
			// $('#hmsg_message_sent').addClass('hmsg_message_none');
			// $('#hmsg_message_sent').removeClass('hmsg_message_block');
			 id = $(this).attr('id');
				//alert("Hello" + id);
				
				$("#reps_sets_"+id).html('');
		}
	 });
	 function add_day(day,id)
	 {
		 var string = '';
		 string = '<span id="'+id+'">'+day+'</span>, ';
		 string += '<input type="hidden" name="day[day]['+day+']" value="'+day+'">';
		 return string;
	 }
	 function add_activity(activity,id)
	 {
		 var string = '';
		 var sets = '';
		 var reps = '';
		 sets = $("#sets_"+id).val();
		 reps = $("#reps_"+id).val();
		 kg = $("#kg_"+id).val();
		 time = $("#time_"+id).val();
		 string += '<p id="'+id+'">'+activity+' ';
		 string += '<span id="sets_'+id+'"> Sets '+sets+' </span>';
		 string += '<span id="reps_'+id+'"> Reps '+reps+' </span>';
		 string += '<span id="kg_'+id+'"> KG '+kg+' </span>';
		 string += '<span id="time_'+id+'"> Rest Time '+time+' </span></p>';
		 string += '<input type="hidden" name="sets[]" value="'+sets+'">';
		 string += '<input type="hidden" name="reps[]" value="'+reps+'">';
		 string += '<input type="hidden" name="kg[]" value="'+kg+'">';
		 string += '<input type="hidden" name="time[]" value="'+time+'">';
		 string += '<input type="hidden" name="activity[]" value="'+activity+'">';
		/*  sets = $("#sets_"+id).val('');
		 reps = $("#reps_"+id).val('');
		 kg = $("#kg_"+id).val('');
		 time = $("#time_"+id).val(''); */
		 return string;
	 }
	function workout_list(day,activity,id,response)
	{
		var string = '';
		string += "<div class='activity' id='block_"+id+"'>";
		string += '<div class="col-md-4">'+day+'</div>';
		string += '<div class="col-md-6">'+activity +'</div>';
		string += '<span>'+ response+'</span>';
		string += "<div id='"+id+"' class='removethis col-md-2'><span class='badge badge-delete pull-right'>X</span></div></div>";
		return string;
	}
	 jQuery("body").on("click", ".removethis", function(event){
		// alert("hello");
		 var chkID = $(this).attr("id");
		 $("#block_"+chkID).remove();
	 });
	 jQuery("body").on("click", ".removeworkout", function(event){
			if(confirm("Are you sure you want to delete this?"))
				{
			 var chkID = $(this).attr("id");
			// alert("hello"+chkID);
			
			 var curr_data = {
						action: 'gmgt_delete_workout',
						workout_id: chkID,			
						dataType: 'json'
						};
						
						$.post(gmgt.ajax, curr_data, function(response) {
							
							// $("#display_rout_list").append(response);
						
							 $(".workout_"+chkID).remove();
							
							return false;
							
						});	
				}
		 });
	 jQuery("body").on("click", "#add_workouttype", function(event)
	 {
		 $("#display_rout_list").html('');
		 var count = $("#display_rout_list div").length;	
		
		 var day = '';
		 var activity = '';
		 var check_val = '';
		 jsonObj1 = [];
		 jsonObj2 = [];
		 jsonObj = [];
		/* var group_id = '10';
		 var form_data = $("#workouttype_form").serialize();
		 var obj_day = [];
		   var curr_data = {
					action: 'gmgt_add_workout',
					group_id: group_id,			
					dataType: 'json'
					};
					//alert('hello');
					$.post(gmgt.ajax, curr_data, function(response) {
						alert(response);
						return false;
						
					});	
					return false;*/
		 $(":checkbox:checked").each(function(o){
			
			  var chkID = $(this).attr("id");
			  var check_val = $(this).attr("data-val");
			  
			  if(check_val == 'day')
			  {
				  //day += ' ' + chkID;
				  day += add_day(chkID,chkID);
				  item = {}
			        item ["day_name"] =chkID;
			       

			        jsonObj1.push(item);
			        //$(this).prop("disabled", true);
			  }
			  if(check_val == 'activity')
			  {
				  activity_name = $(this).attr("activity_title");
				  item = {};
				  var sets = $("#sets_"+chkID).val();
				  var reps = $("#reps_"+chkID).val();
				  var time = $("#time_"+chkID).val();
				  
			        item ["activity"] = {"activity":activity_name,"sets":$("#sets_"+chkID).val(),"reps":$("#reps_"+chkID).val(),"kg":$("#time_"+chkID).val(),"time":$("#time_"+chkID).val()};
				  activity += add_activity(activity_name,chkID);
				 
			       

			        jsonObj2.push(item);
			  }
			 // $(this).prop('checked', false);
			  $(this).prop('checked', true);
			 
			 // $("#"+chkID+"summ").removeAttr("disabled");
			  /* ... */
			  jsonObj = {"days":jsonObj1,"activity":jsonObj2};
			});
		// if(sets!="" && reps!="" && time!=""){
			
		 var curr_data = {
					action: 'gmgt_add_workout',
					data_array: jsonObj,			
					dataType: 'json'
					};
					//alert('hello');
					$.post(gmgt.ajax, curr_data, function(response) {
						
						// $("#display_rout_list").append(response);
						 var list_workout =  workout_list(day,activity,count,response);
							
							
							$("#display_rout_list").append(list_workout);
						 
						return false;
						
					});	
					//return false;
		  //}
		//var list_workout =  workout_list(day,activity);
		// $("#display_rout_list").append(list_workout);
	}); 
	 //Nutrition code
	 
	 $(".nutrition_check").change(function(){
			
			id = $(this).attr('id');
			//alert("Hello" + id);
			//return false;
			//$("#reps_sets_"+id).html('<P>Sets <input type="text" name = "sets_' + id + '"></p><P>Reps <input type="text" name = "reps_' + id + '"></p>');
			
			
		 if($(this).is(":checked"))
		{
			 
			 //$('#hmsg_message_sent').addClass('hmsg_message_block');
			 id = $(this).attr('id');
				//alert("Hello" + id);
			 string = '';
			string += '<script type="text/javascript">$(".onlyletter_space_validation").keypress(function( e ){ var regex = new RegExp("^[a-zA-Z \b]+$");var key = String.fromCharCode(!event.charCode ? event.which: event.charCode);if (!regex.test(key)) {event.preventDefault();alert("Enter Later and Space Only");return false;}  return true;});</script><div class="nutrition_add "><textarea class="form-control validate[required,custom[onlyLetterSp]] onlyletter_space_validation" maxlength="150" name="'+id+'" id="valtxt_'+id+'"></textarea></div>';
			$("#txt_"+id).html(string);
			 
		}
		 else
		{
			// $('#hmsg_message_sent').addClass('hmsg_message_none');
			// $('#hmsg_message_sent').removeClass('hmsg_message_block');
			 id = $(this).attr('id');
				//alert("Hello" + id);
			 string = '';
				$("#txt_"+id).html(string);
		}
	 });
	 function add_nutrition(activity,id)
	 {
		 var string = '';
		 var sets = '';
		 var reps = '';
		 var nutrition = '';
		 //comment this line for validation time issue.
		 nutrition = $("#valtxt_"+id).val();
		var result = ''; 
		while (nutrition.length > 0) 
		{ 
	       result += nutrition.substring(0, 60) + '\n'; 
		   nutrition = nutrition.substring(60); 
	    }
		 string += '<div id="'+id+'" class="nutrition_title">'+activity+' </div>';
		 string += '<div id="value_'+id+'" class="nutrition_value"> '+result+' </div>';
		
		 //nutrition = $("#valtxt_"+id).val('');
		 return string;
	 }
	 function nutrition_list(day,activity,id,response)
		{
			var string = '';
			string += "<div class='activity' id='block_"+id+"'>";
			string += '<div class="col-md-4">'+day+'</div>';
			string += '<div class="col-md-6">'+activity +'</div>';
			string += '<span>'+ response+'</span>';
			string += "<div id='"+id+"' class='removethis col-md-2'><span class='badge badge-delete pull-right'>X</span></div></div>";
			return string;
		}
	 jQuery("body").on("click", "#add_nutrition", function(event){
		 var count = $("#display_nutrition_list div").length;
		
		
		 var day = '';
		 var activity = '';
		 var check_val = '';
		 jsonObj1 = [];
		 jsonObj2 = [];
		 jsonObj = [];
		
		 $(":checkbox:checked").each(function(o){
			
			  var chkID = $(this).attr("id");
			  var check_val = $(this).attr("data-val");
				
			  if(check_val == 'day')
			  {
				  //day += ' ' + chkID;
				  day += add_day(chkID,chkID);
				  item = {}
			        item ["day_name"] =chkID;
			       

			        jsonObj1.push(item);
			        //$(this).prop("disabled", true);
			  }
			  if(check_val == 'nutrition_time')
			  {
				  activity_name = $(this).attr("id");
				 if(activity_name == 'dinner')
				{
					 activity_name = 'Dinner';
				}
				 if(activity_name == 'breakfast')
					{
						 activity_name = 'Break Fast';
					}
				 if(activity_name == 'lunch')
					{
						 activity_name = 'Lunch';
					}
				  item = {};
			        item ["activity"] = {"activity":activity_name,"value":$("#valtxt_"+chkID).val()};
				  activity += add_nutrition(activity_name,chkID);
				 
			       
				  
			        jsonObj2.push(item);
			        
			  }
			  $(this).prop('checked', false);
			 
			 // $("#"+chkID+"summ").removeAttr("disabled");
			  /* ... */
			  jsonObj = {"days":jsonObj1,"activity":jsonObj2};
			});
		 
		 var curr_data = {
					action: 'gmgt_add_nutrition',
					data_array: jsonObj,			
					dataType: 'json'
					};
					//alert('hello');
					$.post(gmgt.ajax, curr_data, function(response) {
						/* alert(response);
						return false; */
						// $("#display_rout_list").append(response);
						 var list_workout =  nutrition_list(day,activity,count,response);
						 
						 $("#display_nutrition_list").append(list_workout);
						return false;
						
					});	
					return false;
		
	}); 
	 
	 jQuery("body").on("click", ".removenutrition", function(event){
			if(confirm("Are you sure you want to delete this?"))
				{
			 var chkID = $(this).attr("id");
			// alert("hello"+chkID);
			
			 var curr_data = {
						action: 'gmgt_delete_nutrition',
						workout_id: chkID,			
						dataType: 'json'
						};
						
						$.post(gmgt.ajax, curr_data, function(response) {
							$(".workout_"+chkID).remove();
							
							return false;
							
						});	
				}
		 });
	//--------display today workouts---------------
	 //jQuery("body").on("change", "#record_date", function(event){
	 jQuery("body").on("changeDate", "#record_date", function(event){
	// $("#record_date").change(function(){
		
		//$('#activity_list').html('');
		var selection = $("#record_date").val();
		 var uid = $('#member_list').val();
		//alert(uid);
		 //return false;
		var optionval = $(this);
			var curr_data = {
					action: 'gmgt_today_workouts',
					record_date: selection,			
					uid: uid,			
					dataType: 'json'
					};
					$.post(gmgt.ajax, curr_data, function(response) {
					//alert(response);
					//return false;
					$('.workout_area').html(response);	
					});
						
					
	});
	 
	 $("body").on("click", ".view-measurement-popup", function(event){
			

		  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
		  var docHeight = $(document).height(); //grab the height of the page
		  var scrollTop = $(window).scrollTop();
		  var user_id  = $(this).attr('data-val');
		
		   var curr_data = {
		 					action: 'gmgt_measurement_view',
		 					user_id: user_id,		 					
		 					dataType: 'json'
		 					};	 	
								//alert('hello');					
		 					$.post(gmgt.ajax, curr_data, function(response) { 	
		 						//alert(response);	 
		 					$('.popup-bg').show().css({'height' : docHeight});							
							$('.invoice_data').html(response);	
							return true; 					
		 					});	
		
	  });
	 
	 $("body").on("click", ".measurement_delete", function(event){
			

		  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
		  var docHeight = $(document).height(); //grab the height of the page
		  var scrollTop = $(window).scrollTop();
		  var measurement_id  = $(this).attr('data-val');
		 
		 
		  if(confirm('Do you really want to delete this record?'))
			  {
		   var curr_data = {
		 					action: 'gmgt_measurement_delete',
		 					measurement_id: measurement_id,		 					
		 					dataType: 'json'
		 					};	 	
								//alert('hello');					
		 					$.post(gmgt.ajax, curr_data, function(response) { 	
		 						//alert(response);	 
		 						 $("tr#row_"+measurement_id).remove();
							return true; 					
		 					});
			  }
		
	  });
	 $("body").on("click", ".view-notice", function(event){
	  var notice_id = $(this).attr('id');
	  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	  var docHeight = $(document).height(); //grab the height of the page
	  var scrollTop = $(window).scrollTop();
	 
	   var curr_data = {
	 					action: 'gmgt_view_notice',
	 					notice_id: notice_id,			
	 					dataType: 'json'
	 					};
	 					//alert('hello');
	 					$.post(gmgt.ajax, curr_data, function(response) {
	 						
	 						//alert('hello');
	 						$('.popup-bg').show().css({'height' : docHeight});
							$('.notice_content').html(response);	
	 						return true;
	 						
	 					
	 					
	 					});	
	 		}); 
	// jQuery("body").on("change", "#begin_date", function(event){
	 jQuery("body").on("changeDate", "#begin_date", function(event){
		 
		// $("#record_date").change(function(){
		//$('#activity_list').html('');
		var start_date = $("#begin_date").val();
		 var membership_id = $('#membership_id').val();
		 
		 $('#end_date').val("Loading....");
		//return false;
		var optionval = $(this);
			var curr_data = {
					action: 'gmgt_load_enddate',
					start_date: start_date,			
					membership_id: membership_id,			
					dataType: 'json'
					};
					$.post(gmgt.ajax, curr_data, function(response) {
						//alert(response);
					//$('.workout_area').html(response);
						$('#end_date').val(response);
						$('#end_date').attr('readonly', 'true');
					//return false;
					});
						
	});
	
	$(".payment_membership_detail").change(function(){
		
		var membership_id = $(this).val();
		 $('#total_amount').val("Loading....");
		
		//alert(member_id);
		
		var optionval = $(this);
			var curr_data = {
					action: 'gmgt_paymentdetail_bymembership',
					membership_id: membership_id,			
					dataType: 'json'
					};
					$.post(gmgt.ajax, curr_data, function(response) {
						//alert(response);
						 payment_data = $.parseJSON(response);
					//$("#membership_id").val(payment_data.membership_id);
					
					$("#begin_date").val('');
					$("#end_date").val('');
					$("#total_amount").val(payment_data.price);
					//$('#workout_mesurement').text(response);	
					});
						
					
	});
	//Payment Module pop up
	 $("body").on("click", ".show-payment-popup", function(event){
				

			  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
			  var docHeight = $(document).height(); //grab the height of the page
			  var scrollTop = $(window).scrollTop();
			  var idtest  = $(this).attr('idtest');
			  var view_type  = $(this).attr('view_type');
			  var due_amount  = $(this).attr('due_amount');	
			  var member_id  = $(this).attr('member_id');	
			 
			   var curr_data = {
			 					action: 'gmgt_member_add_payment',
			 					idtest: idtest,
			 					view_type: view_type,
								due_amount: due_amount,
								member_id: member_id,
			 					dataType: 'json'
			 					};	 	
									//alert('hello');					
			 					$.post(gmgt.ajax, curr_data, function(response) { 	
			 						//alert(response);	 
			 					$('.popup-bg').show().css({'height' : docHeight});							
								$('.invoice_data').html(response);	
								return true; 					
			 					});	
			
		  });
	$("body").on("click", ".show-view-payment-popup", function(event){
				

			  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
			  var docHeight = $(document).height(); //grab the height of the page
			  var scrollTop = $(window).scrollTop();
			  var idtest  = $(this).attr('idtest');
			  var view_type  = $(this).attr('view_type');			  
			  		  
				//alert(idtest);
				//return false;
			   var curr_data = {
			 					action: 'gmgt_member_view_paymenthistory',
			 					idtest: idtest,
			 					view_type1: view_type,
			 					dataType: 'json'
			 					};	 	
													
			 					$.post(gmgt.ajax, curr_data, function(response) { 	
			 						//alert(response);	 
									
			 					$('.popup-bg').show().css({'height' : docHeight});							
								$('.invoice_data').html(response);	
								return true; 					
			 					});	
			
		  });
	var membertype=$("#member_type").val();	  
	if(membertype=='Prospect'){
			$('#non_prospect_area').hide();	
		}
		else
		{
			$('#non_prospect_area').show();	
		}
	$("body").on("change","#member_type", function(){
		var optionval = $(this).val();
		if(optionval=='Prospect'){
			$('#non_prospect_area').hide();	
		}
		else
		{
			$('#non_prospect_area').show();	
		}
	});
		  
	/*$("body").on("change","#member_list", function(){
		
	
		var optionval = $(this);
			var curr_data = {
					action: 'gmgt_load_membership_activities',
					member_id: $("#member_list").val(),			
					dataType: 'json'
					};
					$.post(gmgt.ajax, curr_data, function(response) {
					$('#member_list').append(response);	
					});
						
					
	});  */
	
	/*---------Verify licence key-----------------*/
	$("body").on("click", "#varify_key", function(event){
	$(".gmgt_ajax-img").show();
	$(".page-inner").css("opacity","0.5");
	  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
		var res_json;
	  var licence_key = $('#licence_key').val();
	  var enter_email = $('#enter_email').val();
		//alert(model);
		//return false;
	   var curr_data = {
	 		action: 'gmgt_verify_pkey',
	 		licence_key : licence_key,
	 		enter_email : enter_email,
	 		dataType: 'json'
	 	};	
		
		$.post(gmgt.ajax, curr_data, function(response) { 						
	 		res_json = JSON.parse(response);
			$('#message').html(res_json.message);
				$("#message").css("display","block");
				$(".gmgt_ajax-img").hide();
				$(".page-inner").css("opacity","1");
				if(res_json.gmgt_verify == '0')
				{
					window.location.href = res_json.location_url;
				}
				return true; 					
	 		});		
	});




//for membership update

$("body").on("change", ".tog ", function(event){	
	event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	var res_json;
	var timeperiod = $(this).val();
		
	if(timeperiod=='unlimited'){		
		$('#on_of_member_box').empty();		
		$('#member_limit').empty();		
	}
	else
	{		
		var curr_data = {
			action: 'gmgt_timeperiod_for_class_member',
			timeperiod : timeperiod,	 	
			dataType: 'json'
		 };	
											
		$.post(gmgt.ajax, curr_data, function(response) {		 	
			$('#member_limit').html(response);	
			return true; 					
		});	
	}
});





$("body").on("change", ".classis_limit ", function(event){	
	event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	var res_json;
	var timeperiod = $(this).val();

	if(timeperiod=='unlimited'){
		$('#on_of_classis_box').empty();
		$('#classis_limit').empty();
	}
	else
	{
		var curr_data = {
			action: 'gmgt_timeperiod_for_class_number',
			timeperiod : timeperiod,	 	
			dataType: 'json'
		};	
										
		$.post(gmgt.ajax, curr_data, function(response) {		 	
			$('#classis_limit').html(response);			
			return true; 					
		});
	}
		
});



$("body").on("change", "#membership_id ", function(event){		
	event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	var res_json;
	var membership_id = $(this).val();
	var categCheck = $('.classis_ids').multiselect();	
	if(membership_id!=""){
	
	
	var curr_data = {
		action: 'gmgt_get_class_id_by_membership',
		membership_id : membership_id,	 	
		dataType: 'json'
	};	
										
	$.post(gmgt.ajax, curr_data, function(response) {
		$('#classis_id').html('');	
		$('#classis_id').html(response);	
		categCheck.multiselect('rebuild');		
		return true; 					
	});
	}
	else
	{
		$('#classis_id').html('');	
		categCheck.multiselect('rebuild');		
		return true; 
	}
});


$("body").on("change", "#membership_id ", function(event){		
	event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	var res_json;
	var membership_id = $(this).val();	
	if(membership_id!=""){
	var curr_data = {
		action: 'gmgt_check_membership_limit_status',
		membership_id : membership_id,	 	
		dataType: 'json'
	};	
										
	$.post(gmgt.ajax, curr_data, function(response) {			
		$('#no_of_class').html(response);			
	});
	}
});

	//$("body").on("scroll", "#myModal_add_staff_member ", function(){		
	$("#myModal_add_staff_member").scroll(function(){
		$('.dropdown-menu.datepicker').hide();
	});
	
 //count total in store product.
 $("body").on('focus','.total_amount', function (event) {	

	$( this ).blur();
	
		var curr_data = {
	 					action: 'gmgt_count_store_total',
	 					discount_amount: $('.discount_amount').val(),			
	 					//end: $('.end').val(),			
	 					quantity: $('.quantity').val(),			
	 					Product: $('.Product').val(),			
	 					tax : $('.Tax ').val(),			
	 					dataType: 'json'
	 					};
	 					$.post(gmgt.ajax, curr_data, function(response) {
						$('.total_amount').val(response);	
	 						return true;
					});	
		 
		 return false;
	});  
	
	$("body").on('keyup', 'input.quantity', function(ev) 	
	{
			var row_no = $(this).attr('row');
		
			var product_id=$('.product_id'+row_no).val();
			var quantity=$('.quantity'+row_no).val();
			
			var curr_data = {
					action: 'gmgt_check_product_stock',		
					product_id:product_id,
					quantity:quantity,
					row_no:row_no,					
					dataType: 'json'
					
					};
					
					$.post(gmgt.ajax, curr_data, function(response)
					{	
						if(response!='')
						{
							var row_no = response;
							$('.quantity'+row_no).val('');
							alert('Product out of stock');
						}	
						return false;					
					});		 
	});
	$("body").on("change", "#product_id ", function(event)
	{
		var row_no = $(this).attr('row');
		$('.quantity'+row_no).val('');
		return false;			
	});
	
	$('.onlyletter_number_space_validation').keypress(function( e ) 
	{     
		var regex = new RegExp("^[0-9a-zA-Z \b]+$");
		var key = String.fromCharCode(!event.charCode ? event.which: event.charCode);
		if (!regex.test(key)) 
		{
		  event.preventDefault();
		  alert("Enter Numbers Later and Space Only");
		  return false;
		} 
	   return true;
	});
	
	$('.onlyletter_space_validation').keypress(function( e ) 
	{     
		var regex = new RegExp("^[a-zA-Z \b]+$");
		var key = String.fromCharCode(!event.charCode ? event.which: event.charCode);
		if (!regex.test(key)) 
		{
		  event.preventDefault();
		  alert("Enter Latter and Space Only");
		  return false;
		} 
	   return true;
	});
	
	// $(".phone_validation").keypress(function(e)
	// {
	 
	//   if (e.which > 31 && (e.which < 48 || e.which > 57))
	//    {
	// 	 alert("Enter Numbers Only");
	// 	 return false;
	//    }
	//   return true;
		  
	// });  
	   //No Space allowed
		$('.space_validation').keypress(function( e )
		{
		   if(e.which === 32)
		   {
			 alert("No Space allowed!");
			 return false;
		   }
		    return true;
		});
		//allow only decimal number
		$('.decimal_number').keyup(function()
		{
			var val = $(this).val();
			if(isNaN(val))
			{
				val = val.replace(/[^0-9\.]/g,'');
				if(val.split('.').length>2) 
				val =val.replace(/\.+$/,"");
			    alert("Enter Numbers Only");
			}
			$(this).val(val); 
		});
		
	$("body").on("change", ".notice_for ", function(event)
	{		
		var notice_for = $(this).val();
		if(notice_for == 'member')
		{
			$(".class_div").css("display", "block");
		}
		else
		{
			$(".class_div").css("display", "none");
		}
		return false;			
	});
	$("body").on("change", ".message_to ", function(event)
	{
		var message_to = $(this).val();
		
		if(message_to == 'member')
		{
			$(".display_class_css").css("display", "block");
		}
		else
		{
			$(".display_class_css").css("display", "none");
		}		
		return false;			
	});
	// member filter alert message
	$('body').on('click','.member_filter',function()
	{
		var membertype=$('#member_type').val();
		if(membertype == '')
		{
			alert('please select at least one member type...');	
			return false;				
		}		
		
	});		
});