<?php

/*** Child Theme Function  ***/

function topfit_mikado_child_enqueue_styles() {
    $parent_style = 'topfit_mikado_default_style';

    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');

    wp_enqueue_style('childstyle',
        get_stylesheet_directory_uri() . '/style.css',
        array($parent_style),
        wp_get_theme()->get('Version')
    );



}

add_action('wp_enqueue_scripts', 'topfit_mikado_child_enqueue_styles');




//ADD SHORTCODE FOR MEMBER REGISTRATION

add_shortcode('gmgt_custom_memberreg', 'gmgt_custom_memberregistration_');

function gmgt_custom_memberregistration_(){

?>

<script>
var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
jQuery(document).ready(function(){
jQuery('#Country').on('change',function(){ 
		var countryID = jQuery(this).val();
		//alert(countryID);
	    if(countryID){

		 jQuery.ajax({ 
				 type:'POST', 
				 url:ajaxurl,
				 data:'country_id='+countryID+"&action=state_frontend",
				 success:function(html){ 
					 //alert(html);
					 jQuery('#state').html(html); 
					
				 }
				}); 
		 }else{ 
			 jQuery('#state').html('<option value="">Select country first</option>'); 			 
		} 
	});


 jQuery('#state').on('change',function(){ 
		var stateID = jQuery(this).val();
		 
	    if(stateID){

		 jQuery.ajax({ 
				 type:'POST', 
				 url:ajaxurl,
				 data:'state_id='+stateID+"&action=city_frontend",
				 success:function(html){ 
					 //alert(html);
					 jQuery('#City').html(html); 
					
				 }
				}); 
		 }else{ 
			 jQuery('#City').html('<option value="">Select state first</option>'); 			 
		} 
	});

   jQuery("#btn_register").click(function(){

         	//alert("hi");
    	var first_name=jQuery("#member_name").val();
    	var Phone_number = jQuery("#Phone_number" ).val();
		var password1=jQuery("#password1").val();
		var password2=jQuery("#password2").val();
		var email = jQuery("#email").val();

		var Country = jQuery("#Country").val();
		var State = jQuery("#state").val();
		var City = jQuery("#City").val();
		var Sport = jQuery("#Sport").val();
		var cstatus = jQuery("#cstatus1").val();
		var membership_id = jQuery("#membership_id").val();

		var trainer_type = jQuery("#trainer_type").val();
		var time_slot = jQuery("#time_slot").val();


		

		
		if(first_name=='')
			{
				
			jQuery("#member_name").css("border-color","red");
			setTimeout(function(){
				jQuery("#member_name").focus();
		    });

			jQuery("#fn_label").text("Please Enter Name");
			jQuery("#fn_label").css("color","red");
			return false;	                                      
																									
			}
			else{

				jQuery("#member_name").css("border-color","#8d8d8d");
				jQuery("#fn_label").empty();
				}
			if(email=='')
			{
			  jQuery("#email").css("border-color","red");
			  setTimeout(function(){
				jQuery("#email").focus();
		    });

			  jQuery("#email_label").text("Please enter email");
			  jQuery("#email_label").css("color","red");

			  return false;
			}
			else{

			jQuery("#email").css("border-color","#8d8d8d");
			jQuery("#email_label").empty();
			}

			if(password1=='')

			{
				jQuery("#password1").css("border-color","red");
				setTimeout(function(){
				jQuery("#password1").focus();
		    });
				jQuery("#pwd_label").text("Please enter password");
				jQuery("#pwd_label").css("color","red");                                     
			return false;									
			}
			else if(password1.length < 6)
			{
				jQuery("#password1").css("border-color","red");
				setTimeout(function(){
				              jQuery("#password1").focus();
		                     });
				jQuery("#pwd_label").text("Please enter minimum six characters");
				jQuery("#pwd_label").css("color","red");                                       
			return false;									
			}
				else{									
					jQuery("#password1").css("border-color","#8d8d8d");
				    jQuery("#pwd_label").empty();
					}
					if(password1 != password2)
						{
						jQuery("#password2").css("border-color","red");
                         
                            setTimeout(function(){
				              jQuery("#password2").focus();
		                     });

							jQuery("#cpwd_label").text("Passwords do not match");
							jQuery("#cpwd_label").css("color","red");                                        
							return false;									
							}else{									
								jQuery("#password2").css("border-color","#8d8d8d");
							    jQuery("#cpwd_label").empty();
							}

				
					
			    if(membership_id=='')
			     {
				
					jQuery("#membership_id").css("border-color","red");
					setTimeout(function(){
						jQuery("#membership_id").focus();
				    });

					jQuery("#Membership_label").text("Please Select Membership");
					jQuery("#Membership_label").css("color","red");
					return false;	                                      
																									
			    }
					else{

						jQuery("#membership_id").css("border-color","#8d8d8d");
						jQuery("#Membership_label").empty();
						}	

		       if(trainer_type=='')
			     {
				
					jQuery("#trainer_type").css("border-color","red");
					setTimeout(function(){
						jQuery("#trainer_type").focus();
				    });

					jQuery("#trainer_type_label").text("Please Select Trainer_Type");
					jQuery("#trainer_type_label").css("color","red");
					return false;	                                      
																									
			    }
					else{

						jQuery("#trainer_type").css("border-color","#8d8d8d");
						jQuery("#trainer_type_label").empty();
						}			
		
		   if(time_slot=='')
			     {
				
					jQuery("#time_slot").css("border-color","red");
					setTimeout(function(){
						jQuery("#time_slot").focus();
				    });

					jQuery("#time_slot_label").text("Please Select Time Slot");
					jQuery("#time_slot_label").css("color","red");
					return false;	                                      
																									
			    }
					else{

						jQuery("#time_slot").css("border-color","#8d8d8d");
						jQuery("#time_slot_label").empty();
						}			
		


		      

// form submit 
         var data = {
            action: 'register_member',
            first_name: first_name,
            Phone_number:Phone_number,
            password1:password1,
            password2:password2,
            email:email,
            Country:Country,
            State:State,
            City:City,
            Sport:Sport,
            cstatus:cstatus,
            membership_id:membership_id,
            trainer_type:trainer_type,
            time_slot:time_slot


        };

        
		 jQuery.ajax({ 
				 type:'POST', 
				 url:ajaxurl,
				 data,
				 success:function(html){ 
					//jQuery('#msg').html("User Register successfully");
					var url = 'http://fitness.php-dev.in/success'; 
					setTimeout(function () {
					window.location.href = url;
				    	}, 1000);
					
				 }
				}); 



    });

  
  /*check existing user usremail */
jQuery("#email").on("blur", function(){
	
var useremail = jQuery("#email").val();
if(useremail!=""){
	jQuery.ajax({
	url: ajaxurl,
	type: 'post',
	dataType: 'json',
	data: "useremail="+useremail+"&action=check_existing_user_email",
	success: function(result) { 						
	if(result['success'] == true){
		//alert(result['success']);
	    //jQuery("input[name='usrconfirmemail']").focus();
		} else {
		//alert(result['error']);
		//generateNotification(result['error'], "error");
		jQuery("#email_label").text("Email already exists");										
			jQuery("#email_label").css("color","red");
			jQuery("#email").css("border-color","red");

			jQuery("input[name='email']").focus();

			 return false;
				}
			    	}
						});
			}
  
  
	 
 });


  });

</script>

 
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <script>
  jQuery( function() {
    jQuery("#tabs").tabs();
  } );
  </script>
 <?php

   
    global $wpdb, $user_ID;  
    if (!$user_ID) { 


	$error= '';
	$success = '';
 
	global $wpdb, $PasswordHash, $current_user, $user_ID;
 
	/*if(isset($_POST['task']) && $_POST['task'] == 'register' ) {
 

       $first_name = $wpdb->escape(trim($_POST['member_name']));
       $Phone_number = $wpdb->escape(trim($_POST['Phone_number']));
       $email = $wpdb->escape(trim($_POST['email']));
	   $password1 = $wpdb->escape(trim($_POST['password1']));
	   $password2 = $wpdb->escape(trim($_POST['password2']));
       $Country = $wpdb->escape(trim($_POST['Country']));
       $State = $wpdb->escape(trim($_POST['State']));
       $City = $wpdb->escape(trim($_POST['City']));
       $Sport = $wpdb->escape(trim($_POST['Sport']));
       $cstatus = $wpdb->escape(trim($_POST['cstatus']));
       $username = $wpdb->escape(trim($_POST['member_name']));

		
		
		if( $email == "" || $password1 == "" || $password2 == "" || $first_name == "") {
			$error= 'Please don\'t leave the required fields.';
		} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error= 'Invalid email address.';
		} else if(email_exists($email) ) {
			$error= 'Email already exist.';
		} else if($password1 <> $password2 ){
			$error= 'Password do not match.';		
		} else {
 
			$user_id = wp_insert_user( array ('first_name' => apply_filters('pre_user_first_name', $first_name), 'user_pass' => apply_filters('pre_user_user_pass', $password1), 'user_login' => apply_filters('pre_user_user_login', $username), 'user_email' => apply_filters('pre_user_user_email', $email), 
                           
				'role' => 'subscriber' ) );

            $metas = array( 
				    'Phone_number'   => $Phone_number,
				    'Country' => $Country, 
				    'State'  => $State ,
				    'city'       => $City ,
				    'Sport'     => $Sport,
				    'cstatus'       => $cstatus 
				   	);

       foreach($metas as $key => $value) {
            update_user_meta( $user_id, $key, $value );
        }



			if( is_wp_error($user_id) ) {
				$error= 'Error on user creation.';
			} else {
				do_action('user_register', $user_id);
				
				$success = 'You\'re successfully register';
			}
			
		}
		
	}
	
	*/


	?>

<div id="msg" class="alignleft1"><p><?php if($sucess != "") { echo $sucess; } ?> <?php if($error!= "") { echo $error; } ?></p></div>	

<!--<form method="post">-->
<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Registration details</a></li>
    <li><a href="#tabs-2">Questionnaire</a></li>
    <li><a href="#tabs-3">Membership Type Selected Automatically</a></li>
    <li><a href="#tabs-4">Payment Page</a></li>
  </ul>
 <div id="tabs-1">
<!-- <div class="col-md-6"> -->
 <p><label>Name</label><span style="color:red;"> * </span>&nbsp;&nbsp;&nbsp;&nbsp;<label id="fn_label"></label></p>
<p><input type="text" value="" name="member_name" id="member_name" size="20" class="form-control"/></p>
<p><label>Phone number</label></p>
<p><input type="text" value="" name="Phone_number" id="Phone_number" class="form-control" /></p>
<p><label>Email ID</label><span style="color:red;"> * </span>&nbsp;&nbsp;&nbsp;&nbsp;<label id="email_label"></label></p>
<p><input type="text" value="" name="email" id="email" class="form-control" /></p>
<p><label>Password</label><span style="color:red;"> * </span>&nbsp;&nbsp;&nbsp;&nbsp;<label id="pwd_label"></label></p>
<p><input type="password" value="" name="password1" id="password1" class="form-control" /></p>
<p><label>Confirm password</label><span style="color:red;"> * </span>&nbsp;&nbsp;&nbsp;&nbsp;<label id="cpwd_label"></label></p>
<p><input type="password" value="" name="password2" id="password2" class="form-control" /></p>


<p><label>Membership</label><span style="color:red;"> * </span>&nbsp;&nbsp;&nbsp;&nbsp;<label id="Membership_label"></label></p>
<p>
<select name="membership_id" id="membership_id">
<option value="">Select Membership</option>
<?php
global $wpdb;
$results=$wpdb->get_results("select * from cp_gmgt_membershiptype");
foreach($results as $result){		
?>
<option value="<?php echo $result->membership_id;?>"><?php echo $result->membership_label;?></option>
<?php } ?>
</select>
</p>

<p><label>Type of trainer</label><span style="color:red;"> * </span>&nbsp;&nbsp;&nbsp;&nbsp;<label id="trainer_type_label"></label></p>
<p>
<select name="trainer_type" id="trainer_type">
	<option value="">Select Trainer Type</option>
	<option value="personal">Personal Trainer</option>
	<option value="remote">Remote Trainer</option>
</select>
</p>

<p><label>Time Slots</label><span style="color:red;"> * </span>&nbsp;&nbsp;&nbsp;&nbsp;<label id="time_slot_label"></label></p>
<p>
<select name="time_slot" id="time_slot">
	<option value="">Select Time Slots</option>
	<option value="1">5 am to 6 am</option>
	<option value="2">6 am to 7 am</option>
	<option value="3">7 am to 8 am</option>
	<option value="4">8 am to 9 am</option>
</select>
</p>



<p><label>Country</label></p>
<!--<p><input type="text" value="" name="Country" id="Country" class="form-control" /></p>-->
<p>
<select name="Country" id="Country" class="dropdown">
												<!--<option value="">Select Country</option>-->
												<option value="231">United States</option>
                                                <?php
                                                global $wpdb;
                                                $results=$wpdb->get_results("select * from wp_countries");                                                
                                                foreach($results as $result){													
												?>
													<option value="<?php echo $result->id;?>"><?php echo $result->name;?></option>
												<?php
												}                                                
                                                ?>
                                            </select>

</p>

<p><label>State</label></p>
<!--<p><input type="text" value="" name="State" id="State" class="form-control" /></p>-->
<p>
<select name="State" id="state">
<?php
$results=$wpdb->get_results("select * from wp_states where country_id=231");
foreach($results as $result){ 
?>
<option value="<?php echo $result->id;?>"><?php echo $result->name;?></option>
<!--<option value="">Select country first</option>-->
<?php } ?>	
 </select>
 </p>

<!--<p><input type="text" value="" name="City" id="City" class="form-control" /></p>-->
<p><label>City</label></p>
<p>
<select name="City" id="City">
<?php
global $wpdb;
		$results=$wpdb->get_results("select * from cities where state_id=3919");
		foreach($results as $result){ 
?>
<option value="<?php echo $result->id;?>"><?php echo $result->name;?></option>
<!--<option value="">Select State first</option>-->
<?php } ?>	
 </select>
 </p>

<p><label>Sport(s)</label></p>
<p><input type="text" value="" name="Sport" id="Sport" class="form-control" /></p>

<p><label>Current status </label></p>
<p class="radio"><input type="radio" name="cstatus" id="cstatus1" value="Playing">Playing  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="cstatus" id="cstatus2" value="Not playing">Not playing</p>
<button type="submit" name="btn_register" id="btn_register" class="btn btn-primary" >Register</button>
<input type="hidden" name="task" value="register" />
</div>
<div id="tabs-2"><p>Questionnaire data</p></div>
<div id="tabs-3"><p>Membership Type Selected Automatically</p></div>
<div id="tabs-4"><p>Payment Page</p></div>
</div>
  
  <!-- </div> -->

 <!--</form>-->
  <?php
    }
    else {  
   wp_redirect( home_url() ); exit;  
}  
}



//ADD SHORTCODE FOR Trainers REGISTRATION

add_shortcode('gmgt_custom_trainerreg', 'gmgt_custom_trainerregistration_');

function gmgt_custom_trainerregistration_(){

?>

<script>
var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
jQuery(document).ready(function(){
jQuery('#Country').on('change',function(){ 
		var countryID = jQuery(this).val();
		//alert(countryID);
	    if(countryID){

		 jQuery.ajax({ 
				 type:'POST', 
				 url:ajaxurl,
				 data:'country_id='+countryID+"&action=state_frontend",
				 success:function(html){ 
					 //alert(html);
					 jQuery('#state').html(html); 
					
				 }
				}); 
		 }else{ 
			 jQuery('#state').html('<option value="">Select country first</option>'); 			 
		} 
	});


 jQuery('#state').on('change',function(){ 
		var stateID = jQuery(this).val();
		 
	    if(stateID){

		 jQuery.ajax({ 
				 type:'POST', 
				 url:ajaxurl,
				 data:'state_id='+stateID+"&action=city_frontend",
				 success:function(html){ 
					 //alert(html);
					 jQuery('#City').html(html); 
					
				 }
				}); 
		 }else{ 
			 jQuery('#City').html('<option value="">Select state first</option>'); 			 
		} 
	});


   jQuery("#btnregistertrainer").click(function(){
    	    	 
    	var first_name=jQuery("#member_name").val();
    	var Phone_number = jQuery("#Phone_number" ).val();
		var password1=jQuery("#password1").val();
		var password2=jQuery("#password2").val();
		var email = jQuery("#email").val();

		var Country = jQuery("#Country").val();
		var State = jQuery("#state").val();
		var City = jQuery("#City").val();
		var Sport = jQuery("#Sport").val();
		var username = jQuery("#member_name").val();

		var Gym_name = jQuery("#Gym_name").val();
		var Location = jQuery("#Location").val();
		var Training_specialties = jQuery("#Training_specialties").val();
		 
	      

           var file_data = $("#certificates").prop("files")[0];   
		    var form_data = new FormData();
		    form_data.append("file", file_data);
		     form_data.append("action", 'trainer_up_cv');
		    //alert(form_data);
		    $.ajax({
		        url: ajaxurl,
		        dataType: 'script',
		        cache: false,
		        contentType: false,
		        processData: false,
		        data: form_data,                         
		        type: 'post',
		        success: function(){
		            alert("works"); 
		        }
		    });
		 


		if(first_name=='')
			{
			  
			jQuery("#member_name").css("border-color","red");
			setTimeout(function(){
				jQuery("#member_name").focus();
		    });
			jQuery("#fn_label").text("Please Enter Name");
			jQuery("#fn_label").css("color","red");
			return false;	                                      
																									
			}
			else{

				jQuery("#member_name").css("border-color","#8d8d8d");
				jQuery("#fn_label").empty();
				}
			if(email=='')
			{
			  jQuery("#email").css("border-color","red");
			  setTimeout(function(){
				jQuery("#email").focus();
		    });
			  jQuery("#email_label").text("Please enter email");
			  jQuery("#email_label").css("color","red");

			  return false;
			}
			else{

			jQuery("#email").css("border-color","#8d8d8d");
			jQuery("#email_label").empty();
			}

			if(password1=='')

			{
				jQuery("#password1").css("border-color","red");
				  setTimeout(function(){
				jQuery("#password1").focus();
		        });
				jQuery("#pwd_label").text("Please enter password");
				jQuery("#pwd_label").css("color","red");                                     
			return false;									
			}
			else if(password1.length < 6)
			{
				jQuery("#password1").css("border-color","red");
				setTimeout(function(){
				jQuery("#password1").focus();
		        });
				jQuery("#pwd_label").text("Please enter minimum six characters");
				jQuery("#pwd_label").css("color","red");                                       
			return false;									
			}
				else{									
					jQuery("#password1").css("border-color","#8d8d8d");
				    jQuery("#pwd_label").empty();
					}
					if(password1 != password2)
						{
						jQuery("#password2").css("border-color","red");
						   setTimeout(function(){
				        jQuery("#password2").focus();
		                });
							jQuery("#cpwd_label").text("Passwords do not match");
							jQuery("#cpwd_label").css("color","red");                                        
							return false;									
							}else{									
								jQuery("#password2").css("border-color","#8d8d8d");
							    jQuery("#cpwd_label").empty();
							}


		      

// form submit 
         var data = {
            action: 'register_trainer',
            first_name: first_name,
            Phone_number:Phone_number,
            password1:password1,
            password2:password2,
            email:email,
            Country:Country,
            State:State,
            City:City,
            Sport:Sport,
            Gym_name:Gym_name,
            Location:Location,
            Training_specialties:Training_specialties



        };

        
		 jQuery.ajax({ 
				 type:'POST', 
				 url:ajaxurl,
				 data,
				 success:function(html){ 
					//jQuery('#msg').html("Trainer Register successfully");
					var url = 'http://fitness.php-dev.in/trainer-success'; 
					setTimeout(function () {
					window.location.href = url;
				    	}, 1000); 
					
				 }
				}); 



    });

	 
  });

</script>

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

 <?php

    global $wpdb, $user_ID;  
    if (!$user_ID) { 


	$error= '';
	$success = '';
 
	global $wpdb, $PasswordHash, $current_user, $user_ID;
 
	/*(if(isset($_POST['task']) && $_POST['task'] == 'register' ) {
 

       $first_name = $wpdb->escape(trim($_POST['member_name']));
       $Phone_number = $wpdb->escape(trim($_POST['Phone_number']));
       $email = $wpdb->escape(trim($_POST['email']));
	   $password1 = $wpdb->escape(trim($_POST['password1']));
	   $password2 = $wpdb->escape(trim($_POST['password2']));
       $Country = $wpdb->escape(trim($_POST['Country']));
       $State = $wpdb->escape(trim($_POST['State']));
       $City = $wpdb->escape(trim($_POST['City']));
       $Sport = $wpdb->escape(trim($_POST['Sport']));
       $cstatus = $wpdb->escape(trim($_POST['cstatus']));
       $username = $wpdb->escape(trim($_POST['member_name']));
       $Gym_name = $wpdb->escape(trim($_POST['Gym_name']));
       $Location = $wpdb->escape(trim($_POST['Location']));
       $Training_specialties = $wpdb->escape(trim($_POST['Training_specialties']));
		
		
		if( $email == "" || $password1 == "" || $password2 == "" || $first_name == "") {
			$error= 'Please don\'t leave the required fields.';
		} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error= 'Invalid email address.';
		} else if(email_exists($email) ) {
			$error= 'Email already exist.';
		} else if($password1 <> $password2 ){
			$error= 'Password do not match.';		
		} else {
 
			$user_id = wp_insert_user( array ('first_name' => apply_filters('pre_user_first_name', $first_name), 'user_pass' => apply_filters('pre_user_user_pass', $password1), 'user_login' => apply_filters('pre_user_user_login', $username), 'user_email' => apply_filters('pre_user_user_email', $email), 
                           
				'role' => 'instructor' ) );

            $metas = array( 
				    'Phone_number'   => $Phone_number,
				    'Country' => $Country, 
				    'State'  => $State ,
				    'city'       => $City ,
				    'Sport'     => $Sport,
				    'cstatus'       => $cstatus,
				    'Gym_name' =>$Gym_name,
				    'Location' => $Location,
				    'Training_specialties' => $Training_specialties

				   	);

       foreach($metas as $key => $value) {
            update_user_meta( $user_id, $key, $value );
        }



			if( is_wp_error($user_id) ) {
				$error= 'Error on user creation.';
			} else {
				do_action('user_register', $user_id);
				
				$success = 'You\'re successfully register';
			}
			
		}
		
	}

	*/
	 

	?>

<div id="msg" class="alignleft1"><p><?php if($sucess != "") { echo $sucess; } ?> <?php if($error!= "") { echo $error; } ?></p></div>	

<form method="post" id="frmregtrainer" enctype="multipart/form-data">
<p><label>Name</label><span style="color:red;"> * </span>&nbsp;&nbsp;&nbsp;&nbsp;<label id="fn_label"></label></p>
<p><input type="text" value="" name="member_name" id="member_name" size="20" class="form-control" /></p>
<p><label>Phone number</label></p>
<p><input type="text" value="" name="Phone_number" id="Phone_number" class="form-control" /></p>
<p><label>Email ID</label><span style="color:red;"> * </span>&nbsp;&nbsp;&nbsp;&nbsp;<label id="email_label"></label></p>
<p><input type="text" value="" name="email" id="email" class="form-control"/></p>
<p><label>Password</label><span style="color:red;"> * </span>&nbsp;&nbsp;&nbsp;&nbsp;<label id="pwd_label"></label></p>
<p><input type="password" value="" name="password1" id="password1" class="form-control" /></p>
<p><label>Confirm password</label><span style="color:red;"> * </span>&nbsp;&nbsp;&nbsp;&nbsp;<label id="cpwd_label"></label></p>
<p><input type="password" value="" name="password2" id="password2" class="form-control" /></p>

<p><label>Country</label></p>
<!--<p><input type="text" value="" name="Country" id="Country" class="form-control" /></p>-->
<p>
<select name="Country" id="Country" class="dropdown">
												<!--<option value="">Select Country</option>-->
												<option value="231">United States</option>
                                                <?php
                                                global $wpdb;
                                                $results=$wpdb->get_results("select * from wp_countries");                                                
                                                foreach($results as $result){													
												?>
													<option value="<?php echo $result->id;?>"><?php echo $result->name;?></option>
												<?php
												}                                                
                                                ?>
                                            </select>

</p>


<p><label>State</label></p>
<!--<p><input type="text" value="" name="State" id="State" class="form-control" /></p>

<p><label>City</label></p>
<p><input type="text" value="" name="City" id="City" class="form-control" /></p>-->

<p>
<select name="State" id="state">
<?php
$results=$wpdb->get_results("select * from wp_states where country_id=231");
foreach($results as $result){ 
?>
<option value="<?php echo $result->id;?>"><?php echo $result->name;?></option>
<!--<option value="">Select country first</option>-->
<?php
}                                                
?>	
 </select>
 </p>

<!--<p><input type="text" value="" name="City" id="City" class="form-control" /></p>-->
<p><label>City</label></p>
<p>
<select name="City" id="City">
<?php
global $wpdb;
		$results=$wpdb->get_results("select * from cities where state_id=3919");
		foreach($results as $result){ 
?>
<option value="<?php echo $result->id;?>"><?php echo $result->name;?></option>
<!--<option value="">Select State first</option>-->
<?php } ?>	
 </select>
 </p>

<p><label>Gym name</label></p>
<p><input type="text" value="" name="Gym_name" id="Gym_name" class="form-control" /></p>

<p><label>Location</label></p>
<p><input type="text" value="" name="Location" id="Location" class="form-control" /></p>

<p><label>Sport(s)</label></p>
<p><input type="text" value="" name="Sport" id="Sport" class="form-control" /></p>

<p><label>Training specialties </label></p>
<p><p><input type="text" value="" name="Training_specialties" id="Training_specialties" class="form-control" /></p>

 <p><label>Certificates </label></p>
<p><input type="file" name="certificates" id="certificates" class="form-control" /></p>  


<button type="button" name="btnregister" id="btnregistertrainer" class="btn btn-primary" >Register</button>
<input type="hidden" name="task" value="register" />

</form>
  <?php
    }
    else {  
   wp_redirect( home_url() ); exit;  
}  
}




/* The function that handles the AJAX request */
function state_frontend() {
 
	if(isset($_POST["country_id"])){
		$country_id=$_POST['country_id'];
		global $wpdb;
		$results=$wpdb->get_results("select * from wp_states where country_id=$country_id"); 
		                                             
		echo '<option value="">Select state</option>';
		if(isset($_POST['stateid'])){
			$sid=$_POST['stateid'];
			foreach($results as $result){
				$state_id=$result->id;
				$state_name=$result->name;	
			?>			
				<option value="<?php echo $state_id;?>" <?php if($sid==$state_name){echo 'selected';}?>><?php echo $state_name; ?></option>";
			<?php
			}		
		}else{
			foreach($results as $result){
				$state_id=$result->id;
				$state_name=$result->name;
				echo "<option value='$state_id'>$state_name</option>";
			}
			
		}
		
	}
    
}

add_action('wp_ajax_state_frontend', 'state_frontend');
add_action('wp_ajax_nopriv_state_frontend', 'state_frontend');


/* The function that handles the AJAX request */
function city_frontend() {
 
	if(isset($_POST["state_id"])){
		$state_id=$_POST['state_id'];
		global $wpdb;
		$results=$wpdb->get_results("select * from cities where state_id=$state_id"); 
		                                             
		echo '<option value="">Select city</option>';
		if(isset($_POST['state_id'])){
			$sid=$_POST['state_id'];
			foreach($results as $result){
				$city_id=$result->id;
				$city_name=$result->name;	
			?>			
				<option value="<?php echo $city_id;?>" <?php if($sid==$city_name){echo 'selected';}?>><?php echo $city_name; ?></option>";
			<?php
			}		
		}else{
			foreach($results as $result){
				$city_id=$result->id;
				$city_name=$result->name;
				echo "<option value='$state_id'>$city_name</option>";
			}
			
		}
		
	}
    
}

add_action('wp_ajax_city_frontend', 'city_frontend');
add_action('wp_ajax_nopriv_city_frontend', 'city_frontend');


// The function that handles the AJAX request user registration

function register_user_frontend() {
 global $wpdb; 
 //print_r($_POST);

       $first_name = $wpdb->escape(trim($_POST['first_name']));
       $Phone_number = $wpdb->escape(trim($_POST['Phone_number']));
       $email = $wpdb->escape(trim($_POST['email']));
	   $password1 = $wpdb->escape(trim($_POST['password1']));
	   $password2 = $wpdb->escape(trim($_POST['password2']));
       $Country = $wpdb->escape(trim($_POST['Country']));
       $State = $wpdb->escape(trim($_POST['State']));
       $City = $wpdb->escape(trim($_POST['City']));
       $Sport = $wpdb->escape(trim($_POST['Sport']));
       $cstatus = $wpdb->escape(trim($_POST['cstatus']));
       $username = $wpdb->escape(trim($_POST['member_name']));
       $membership_id = $wpdb->escape(trim($_POST['membership_id']));
       $time_slot = $wpdb->escape(trim($_POST['time_slot']));
       $trainer_type = $wpdb->escape(trim($_POST['trainer_type']));

      // echo $password1;

       $userdata = array(
         'user_login' => $first_name,
		 'user_pass' => sanitize_text_field($_POST['password1']), 
		 'user_email' => $email,
		 'role' => 'member'
		 );

     $user_id = wp_insert_user($userdata); 

     
     if ( $user_id && !is_wp_error( $user_id ) ) {
 
         $code = sha1( $user_id . time() );    
         global $wpdb;  
         
        $wpdb->update( 
			'cp_users', 
			array( 
				'user_activation_key' => $code	// string
				
			), 
			array( 'ID' => $user_id ), 
			array( 
				'%s'	// value1
				
			) 
        );


         $activation_link = add_query_arg( array( 'key' => $code, 'user' => $user_id ), get_permalink(16093)); 

           wp_mail( $email, 'User Activation', 'Activation link : ' . $activation_link );
    

      }
 
             


 
             $metas = array( 
				    'Phone_number'   => $Phone_number,
				    'Country' => $Country, 
				    'State'  => $State ,
				    'city'       => $City ,
				    'Sport'     => $Sport,
				    'cstatus'       => $cstatus, 
				    'membership_id' => $membership_id,
				    'trainer_type'  => $trainer_type,
				    'time_slot'    => $time_slot
				   	);

       foreach($metas as $key => $value) {
            update_user_meta( $user_id, $key, $value );
        }

 

 exit;
}


add_action('wp_ajax_register_member', 'register_user_frontend');
add_action('wp_ajax_nopriv_register_member', 'register_user_frontend');





// The function that handles the AJAX request trainer registration

function register_trainer_frontend() {
 global $wpdb; 
 //print_r($_POST);

       $first_name = $wpdb->escape(trim($_POST['first_name']));
       $Phone_number = $wpdb->escape(trim($_POST['Phone_number']));
       $email = $wpdb->escape(trim($_POST['email']));
	   $password1 = $wpdb->escape(trim($_POST['password1']));
	   $password2 = $wpdb->escape(trim($_POST['password2']));
       $Country = $wpdb->escape(trim($_POST['Country']));
       $State = $wpdb->escape(trim($_POST['State']));
       $City = $wpdb->escape(trim($_POST['City']));
       $Sport = $wpdb->escape(trim($_POST['Sport']));
       $username = $wpdb->escape(trim($_POST['member_name']));

       $Gym_name = $wpdb->escape(trim($_POST['Gym_name']));
       $Location = $wpdb->escape(trim($_POST['Location']));
       $Training_specialties = $wpdb->escape(trim($_POST['Training_specialties']));

      // echo $password1;

       $userdata = array(
         'user_login' => $first_name,
		 'user_pass' => sanitize_text_field($_POST['password1']), 
		 'user_email' => $email,
		 'role' => 'staff_member'
		 );

        $user_id = wp_insert_user($userdata); 



     if ( $user_id && !is_wp_error( $user_id ) ) {
 
         $code = sha1( $user_id . time() );    
         global $wpdb;  
         
        $wpdb->update( 
			'cp_users', 
			array( 
				'user_activation_key' => $code	// string
				
			), 
			array( 'ID' => $user_id ), 
			array( 
				'%s'	// value1
				
			) 
        );

        //get user name from user id

         $user_info = get_userdata($user_id);
         $username = $user_info->user_login;


         $activation_link = add_query_arg( array( 'key' => $code, 'user' => $user_id ), get_permalink(16100)); 

         //sending notification to user

         $message = 'Hi, '.$username.' Your registration in progress  submitted for approval please click on activation link : '.$activation_link;

         // wp_mail( $email, 'User Activation', 'Activation link : ' . $activation_link );
         wp_mail( $email, 'User Activation', $message );

         //sending notification to admin for aaproval

          $adminemail = get_option('admin_email');

          //$adminemail ='neogannear@gmail.com';

          $admmessage = 'Hi, New trainer '.$username.' has been registered.';
    
          wp_mail( $adminemail, 'New Trainer Registration', $admmessage );

      }

 
             $metas = array( 
				    'Phone_number'   => $Phone_number,
				    'Country' => $Country, 
				    'State'  => $State ,
				    'city'       => $City ,
				    'Sport'     => $Sport,
				    'Gym_name'       => $Gym_name,
				    'Location'       => $Location,
				    'Training_specialties'       => $Training_specialties

				   	);

       foreach($metas as $key => $value) {
            update_user_meta( $user_id, $key, $value );
        }

 

 exit;
}


add_action('wp_ajax_register_trainer', 'register_trainer_frontend');
add_action('wp_ajax_nopriv_register_trainer', 'register_trainer_frontend');


function register_trainer_upcv_frontend()
{
	
	echo"<pre>";
	print_r($_FILES);
	//print_r($_POST);;
	$upload_dir = wp_upload_dir();
	$temp_name = $_FILES['file']['tmp_name'];
    $target_path = $upload_dir["basedir"]."/custom/";
    $upload_path = $upload_dir['baseurl'];
     //echo $target_path;
  

    $target_path = $target_path . basename( $_FILES['file']['name']); 

		if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
		    echo "The file ".  basename( $_FILES['file']['name']). 
		    " has been uploaded";
		} else{
		    echo "There was an error uploading the file, please try again!";
		}


	die();

    
}

add_action('wp_ajax_trainer_up_cv', 'register_trainer_upcv_frontend');
add_action('wp_ajax_nopriv_trainer_up_cv', 'register_trainer_upcv_frontend');





/*gmgt_custom_grievancesform shortcode */


add_shortcode('gmgt_custom_grievancesfrm', 'gmgt_custom_grievances');

function gmgt_custom_grievances(){
	?>

	<script>
		  var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
		  jQuery(document).ready(function(){
		  jQuery("#btnsumnitgrievnces").click(function(){
         
          var title=jQuery("#title").val();
          var description=jQuery("#description").val();


          if(title=='')
			{
			
			jQuery("#title").css("border-color","red");
			jQuery("#fn_label").text("Please Enter Name");
			jQuery("#fn_label").css("color","red");
			return false;	                                      
																									
			}
			else{

				jQuery("#title").css("border-color","#8d8d8d");
				jQuery("#fn_label").empty();
				}

			if(description=='')
			{
			
			jQuery("#description").css("border-color","red");
			jQuery("#desc_label").text("Please Enter Description");
			jQuery("#desc_label").css("color","red");
			return false;	                                      
																									
			}
			else{

				jQuery("#description").css("border-color","#8d8d8d");
				jQuery("#desc_label").empty();
				}

            var data = {
            action: 'grievence_frm_sbmt',
            title: title,
            description:description
           
           };

        
		 jQuery.ajax({ 
				 type:'POST', 
				 url:ajaxurl,
				 data,
				 success:function(html){ 
					jQuery('#msg').html("Form Submitted successfully"); 
					
				 }
				}); 


		  
		    });

			 
		  });
</script>
     
<div id="msg" class="alignleft1"><p><?php if($sucess != "") { echo $sucess; } ?> <?php if($error!= "") { echo $error; } ?></p></div>	

     <p><label>Name</label><span style="color:red;"> * </span>&nbsp;&nbsp;&nbsp;&nbsp;<label id="fn_label"></label></p>
     <p><input type="text" value="" name="title" id="title" size="20" class="form-control" /></p>
     <p><label>Description</label><span style="color:red;"> * </span>&nbsp;&nbsp;&nbsp;&nbsp;<label id="desc_label"></label></p>
     <p><textarea name="description" id ="description" rows="5" cols="40" ></textarea></p>
     <button type="submit" name="btnsumnitgrievnces" id="btnsumnitgrievnces" class="btn btn-primary" >Submit</button>


<?php

}


function grievence_frontend(){
      global $wpdb; 
	   $name = $wpdb->escape(trim($_POST['title']));
       $description = $wpdb->escape(trim($_POST['description']));

       $uid = get_current_user_id();


       $post = array(
		  'post_title'    => $name,
		  'post_content'  => $description,
		  'post_type'     =>'grievence',
		  'post_status'   => 'publish',
		  'post_author'   => 1
		);

       $post_id = wp_insert_post( $post, $wp_error='' );

       update_post_meta($post_id,'description',$description);
       update_post_meta($post_id,'userid',$uid);
   
       exit;

}


add_action('wp_ajax_grievence_frm_sbmt', 'grievence_frontend');
add_action('wp_ajax_nopriv_grievence_frm_sbmt', 'grievence_frontend');

/*Custom post type grievence*/

function create_post_type() {
  register_post_type( 'grievence',
    array(
      'labels' => array(
        'name' => __( 'Grievances' ),
        'singular_name' => __( 'Grievances' )
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
}
add_action( 'init', 'create_post_type' );

function hd_add_box() {
  global $submenu;
  unset($submenu['edit.php?post_type=grievence'][10]);
}


add_action('admin_menu', 'hd_add_box');


// Add the custom columns to the book post type:


add_filter( 'manage_grievence_posts_columns', 'set_custom_edit_grievence_columns' );
function set_custom_edit_grievence_columns($columns) {
     $columns = array(
        'cb' => '&lt;input type="checkbox" />',
        'Title' => __( 'Title' ),
        'description' => __( 'Description' ),
        'submitted' => __( 'Submitted By' ),
        'date' => __( 'Date' )
    );
   

    return $columns;
}

 
add_action( 'manage_grievence_posts_custom_column' , 'custom_grievence_column', 10, 2 );
function custom_grievence_column( $column, $post_id ) {
    switch ( $column ) {

        
        case 'description' :
            echo get_post_meta( $post_id , 'description' , true ); 
            break;
        case 'submitted' :
            $uid = get_post_meta( $post_id , 'userid' , true );
            $udata = get_userdata( $uid ); 
            echo $udata->user_login;
            break;

    }
}


//aprove triner by admin from backend 
 

function approve_trainer()
{
    echo $_POST['staff_id'];

    global $wpdb;

	 
    $wpdb->update( 
			'cp_users', 
			array( 
				'user_status' => 0	// string
				
			), 
			array( 'ID' => $_POST['staff_id'] ), 
			array( 
				'%d'	// value1
				
			) 
        );

      $data = get_userdata($_POST['staff_id']); 

      $email = $data->user_email;
      $name = $data->user_login;

      $msg = 'Hi, '.$name.' Your account has been approved to access to 4th Power Performance.';

    //send email to the triner about approval

    wp_mail( $email, 'Request Approved', $msg );



    exit;
}


add_action('wp_ajax_approve_trainer', 'approve_trainer');
add_action('wp_ajax_approve_trainer', 'approve_trainer');



// The function that handles the AJAX request
function check_existing_user_email() {
 $useremail = sanitize_email($_POST['useremail']);
 $user = get_user_by('email', $useremail);
 if ($user) {
 $result['error'] = "Email already Exists. Please try another email.";
 //$result['userdata'] = $user;
 $result['success'] = false;
 } else {
 $result['message'] = "User not exists.";
 $result['success'] = true;
 }
 echo json_encode($result);
 exit;
}

add_action('wp_ajax_check_existing_user_email', 'check_existing_user_email');
add_action('wp_ajax_nopriv_check_existing_user_email', 'check_existing_user_email');



$capability ='manage_options';

// Add to admin_menu function
// add_menu_page(__('Question Type'), __('Question Type'), 'edit_themes', 'question_type', 'questiontype_render', '', 7); 

//  add_submenu_page( 'question_type', ' ', ' ',$capability, 'edit_question_typesss', 'edit_question_type');


// add_menu_page('Questionnaire', 'Questionnaire', 'manage_options', 'questionnaire');
// add_submenu_page( 'questionnaire', 'Question Type', 'Question Type',
//     'manage_options', 'questionnaire' ,'render_question_type');
//  add_submenu_page( 'questionnaire', 'My Custom Submenu Page', 'My Custom Submenu Page',
//     'manage_options', 'edit_question_type','edit_question_type');

// function test()
// {
// 	echo "hi";
// }






 add_menu_page('Question-Type', 'Question Type', $capability, 'Question-Type', 'render_question_type','','7');
  add_submenu_page( 'question_type', ' ', ' ', $capability, 'edit_question_type', 'edit_question_type');





 
function render_question_type() {
    global $title;
    ?>
        <h2><?php echo $title;?></h2>

        <!-- <h3><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=edit_question_type">Add Question-Type</a></h3> -->
        
        <?php
        global $wpdb;
        $results=$wpdb->get_results("select * from cp_question_type");
        ?>
        <table border="1" width="100%" style="border-collapse: collapse;">
        <tr>
        <th>Id</th>
        <th>Question Type</th>
        <th>Status</th>
        <th>Action</th>
        </tr>
        <?php
        foreach($results as $result){
        ?>
        <tr>
        <td><?php echo $result->id; ?></td>
        <td><?php echo $result->qtype; ?></td>
        <td><?php if($result->status=='1') { ?> Active  <?php }else { ?>Inactive <?php } ?></td>
        <td><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=edit_question_type&q_id=<?php echo $result->id;?>">Edit</a>&nbsp;<!-- <a  href="<?php echo home_url(); ?>/wp-admin/admin.php?page=edit_question_type&action=delete&q_id=<?php echo $result->id;?>">Delete</a> --></td>
        </tr>
        <?php
         }
         ?>
         </table>

<?php        	

}

function edit_question_type()
{
	global $wpdb;

     
	 
  	 if($_GET['q_id']!='' && $_GET['action']=='delete')
      {
      	$wpdb->delete( 'cp_question_type', array( 'id' => $_GET['q_id'] ), array( '%d' ) );
          


    	header('Location:/wp-admin/admin.php?page=Question-Type');
      }
  	
  

  if(isset($_POST['submit']))
  {
  	 $qtype = $_POST['qtype'];
  	 $status = $_POST['status'];
 
     if($_GET['q_id']!='')

     {

      $wpdb->update( 
			'cp_question_type', 
			array( 
				'qtype' => $qtype,
				'status' =>$status	// string
				
			), 
			array( 'id' => $_GET['q_id'] ), 
			array( 
				'%s',
				'%d'	// value1
				
			) 
        );

     	

  	}
  	else
  	{
  		//echo $qtype;
  		//exit;
         $wpdb->insert( 
			'cp_question_type', 
			array( 
				'qtype' => $qtype,
				'status' =>$status
			), 
			array( 
				'%s',
				'%d' 
				 
			) 
		);

  	}

  	header('Location:/wp-admin/admin.php?page=Question-Type');
  }

   $results=$wpdb->get_results("select * from cp_question_type where id='".$_GET['q_id']."'");

   if($_GET['action']!='delete')
   {
  ?>

 
  <div style="padding-top: 30px;">

  <?php if($_GET['q_id']) { ?> <h2>Edit Question Type </h2><?php } else { ?> <h2>Add Question Type</h2> <?php } ?>
  


  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.18.0/jquery.validate.js'></script>
  <script type="text/javascript">
  	jQuery(document).ready(function () {
      jQuery('#frmeditqtype').validate({ // initialize the plugin
   errorElement: "div",
        rules: {
            qtype:{
                  required: true
			       },
			status: {
                  required: true
			       }
		  },

		messages:{

			 qtype:{
                  required:"Please enter question type"
			  },
			 status:{
                  required:"Please select the status"
			  } 


        }
    });

});
</script>

  <form name="frmeditqtype" id="frmeditqtype" method="post" action="">
  <table border="1" width="50%" style="border-collapse: collapse;">
  <tr>
  <td>Question Type</td>
  <td><input type="text" name="qtype" id="qtype" value="<?php echo $results[0]->qtype; ?>" style="width:400px;"></td>
  </tr>
  <tr>
  <td>Status</td>
  <td>
  <select name="status" id="status">
  	<option value="">Select the Status</option>
  	<option value="1" <?php if($results[0]->status == '1') { ?> selected='selected' <?php } ?>>Active</option>
  	<option value="0" <?php if($results[0]->status == '0') { ?> selected='selected' <?php } ?>>Inactive</option>
  </select>

  </td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  <td><input type="submit" name="submit" id="submit" <?php if($_GET['q_id']) { ?> value="Update" <?php } else { ?> value="Add" <?php } ?> ></td>
  </tr>
  </table>
  <div style="padding-top: 20px;padding-left:10px;"><a href='javascript:history.back(1);'>Back</a></div>
  </form>
  </div>

<?php

}
}
/*------------------------end of question type-------------------*/

 /*------------------------Add question -------------------*/



 add_menu_page('Question', 'Question', $capability, 'Question', 'render_question');
add_submenu_page( 'question', ' ', ' ', $capability, 'edit_question', 'edit_question');

function render_question()
{

	global $title;
    ?>
        <h2><?php echo $title;?></h2>

        <?php
        if($_GET['error_type'] == '2'){ ?>

        <div>Two Answers for True False OR Yes No type are already present in database</div>

        <?php } elseif ($_GET['error_type'] == '1') {
          ?>
        	 <div> Answers already present in database</div>
       <?php
        }

         ?>

        <h3><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=edit_question">Add Question</a></h3>

        <script language="JavaScript" type="text/javascript">
			jQuery(document).ready(function(){
			    jQuery("a.delete").click(function(e){
			        if(!confirm('Are you sure to delete the question?')){
			            e.preventDefault();
			            return false;
			        }
			        return true;
			    });
			});
      </script>

        
        <?php
        global $wpdb;
        $results=$wpdb->get_results("select * from cp_questions as q LEFT JOIN cp_question_type as qt ON q.qtype_id=qt.id");
        //print_r($results);
        ?>
        <table border="1" width="100%" style="border-collapse: collapse;">
        <tr>
        <th>Id</th>
        <th>Question Type</th>
        <th>Question Description</th>
        <th>Action</th>
        </tr>
        <?php
        $i=1;
        foreach($results as $result){
        ?>
        <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $result->qtype; ?></td>
        <td><?php echo $result->question; ?></td>
        <td><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=edit_question&q_id=<?php echo $result->qid;?>">Edit</a>&nbsp; | &nbsp;<a class="delete" href="<?php echo home_url(); ?>/wp-admin/admin.php?page=edit_question&action=delete&q_id=<?php echo $result->qid;?>">Delete</a>&nbsp; | &nbsp;<a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=edit_question&action=answer&q_id=<?php echo $result->qid;?>&type_id=<?php echo $result->qtype_id;?>"> Add Answers </a> &nbsp; | &nbsp;<a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=edit_question&action=Viewanswer&q_id=<?php echo $result->qid;?>">View Answers</a></td>
        </tr>
        <?php
        $i++;
         }
         ?>
         </table>



<?php        	
}

function edit_question()
{


global $wpdb;
$resultsqt=$wpdb->get_results("select * from cp_question_type");

if($_GET['q_id']!='' && $_GET['action']=='delete')
      {
      	$wpdb->delete( 'cp_questions', array( 'qid' => $_GET['q_id'] ), array( '%d' ) );

      	$wpdb->delete( 'cp_question_answers', array( 'ques_id' => $_GET['q_id'] ), array( '%d' ) );
    	header('Location:/wp-admin/admin.php?page=Question');
      }

 if($_GET['ansid']!='' && $_GET['action']=='delete')
      {

         $wpdb->delete( 'cp_question_answers', array( 'id' => $_GET['ansid'] ), array( '%d' ) ); 
        header('Location:/wp-admin/admin.php?page=Question');
      }

if($_GET['q_id']!='' && $_GET['action']=='Viewanswer')
      {
      	 
         $get_que_ans = $wpdb->get_results("select * from cp_question_answers as qans LEFT JOIN cp_questions as q ON
             qans.ques_id = q.qid           
             where ques_id=".$_GET['q_id']);
         
         //print_r($get_que_ans);

          $i=1;

       ?> 
           <h2 style="margin-top: 30px;">Edit Answers for specific question.</h2>

          <script language="JavaScript" type="text/javascript">
			jQuery(document).ready(function(){
			    jQuery("a.delete").click(function(e){
			        if(!confirm('Are you sure to delete the answer?')){
			            e.preventDefault();
			            return false;
			        }
			        return true;
			    });
			});
      </script>


           <table border="1" width="100%" style="border-collapse: collapse;">
	        <tr>
	        <th>Id</th>
	        <!--<th>Question Type</th>-->
	        <th>Question Description</th>
	        <th>Answer</th>
	        <th>Action</th>
	        </tr>

     <?php

         foreach($get_que_ans as $result){
         ?>
         <tr>
         <td><?php echo $i; ?></td>
         <td><?php echo $result->question;?></td>
         <td><?php echo $result->ques_answer;?></td>
         <td><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=edit_question&action=editans&ansid=<?php echo $result->id;?>&qtype_id=<?php echo $result->qtype_id;?>">Edit</a>&nbsp; | &nbsp;<a class="delete"  href="<?php echo home_url(); ?>/wp-admin/admin.php?page=edit_question&action=delete&ansid=<?php echo $result->id;?>">Delete</a></td>
         </tr>
         <?php
         $i++;
         }
         ?>
         </table>
         <div style="padding-top: 20px;padding-left:10px;"><a href='javascript:history.back(1);'>Back</a></div>
         <?php



      }

      
      if($_GET['ansid']!='' && $_GET['action']=='editans')
      {
          $getqustion = $wpdb->get_results("select * from cp_question_answers as qans LEFT JOIN cp_questions as q ON
               qans.ques_id = q.qid           
              where id=".$_GET['ansid']);
          // print_r($getqustion);

          if(isset($_POST['submiteditanswer']))
          {

          	$ques_answer= $_POST['ques_answer'];
          	$is_default = $_POST['is_default'];

          	//print_r($_POST);
          	//echo "===".$is_default;
          	//die();

          	$wpdb->update( 
			'cp_question_answers', 
			array( 
				'ques_answer' => $ques_answer,
				'is_default'  => $is_default
				
				
			), 
			array( 'id' => $_GET['ansid'] ), 
			array( 
				'%s'  
				
			) 
        );

          	header('Location:/wp-admin/admin.php?page=Question');

          }

      	?>

      	  <form name="editanswer" method="post" action="">
         
           <div style="padding-top: 20px;"><b>Question Desc : </b><?php echo $getqustion[0]->question; ?></div>

           <?php
         
          if($_GET['qtype_id']=='1') {
          	?>
         
         <div style="padding-top: 20px;">
	         <textarea rows="5" cols="60" name="ques_answer" id="ques_answer"><?php echo $getqustion[0]->ques_answer; ?> </textarea>
         </div>
         <?php } else if($_GET['qtype_id']=='2' || $_GET['qtype_id']=='4') { ?>
         
             <div style="padding-top: 20px;">
	         <input name="ques_answer" value="True" type="radio" <?php if($getqustion[0]->ques_answer == 'True') { ?> checked <?php } ?>>True
	         <input name="ques_answer" value="false" <?php if($getqustion[0]->ques_answer == 'false') { ?> checked <?php } ?> type="radio">False
         </div>

             <div style="padding-top: 20px;">
          <input name="is_default" value="1" <?php if($getqustion[0]->is_default == 1) { ?> checked <?php } ?> type="checkbox">Is Default Answer </div>

         <?php }
         
          else if ($_GET['qtype_id']=='3') {
          	?>
          	<div style="padding-top: 20px;">
            <textarea rows="5" cols="60" name="ques_answer" id="ques_answer"><?php echo $getqustion[0]->ques_answer; ?> </textarea>
            </div>
          <?php 	 
          }
          
          ?>


         <div style="padding-top: 20px;">
          <input type="submit" name="submiteditanswer" value="Edit Answer" ></div>
         
         </form>

         <div style="padding-top: 20px;padding-left:10px;"><a href='javascript:history.back(1);'>Back</a></div>


     <?php 	 
      }
     


	if($_GET['q_id']!='' && $_GET['action']=='answer')
	  {

	  	$getquestion_data = $wpdb->get_results("select *,qt.id as type from cp_questions as q LEFT JOIN cp_question_type as qt ON q.qtype_id=qt.id where qid='".$_GET['q_id']."'");
          
       // print_r($getquestion_data);

        if(isset($_POST['submitanswer']))
        {
        	global $wpdb;
            $is_default = $_POST['is_default'];
            $ques_answer = $_POST['ques_answer'];
            $question_id = $_GET['q_id'];

            $check_enrty =  $wpdb->get_results("select * from cp_question_answers where ques_id='".$_GET['q_id']."'");

             if($_GET['type_id'] == '2' || $_GET['type_id'] == '4'){

                       

             if($wpdb->num_rows == '2')
             {
             	$error_type2='2';
              ?>
              
            <?php
             }
             else
             {


				            $wpdb->insert( 
							'cp_question_answers', 
							array( 
								'ques_answer' => $ques_answer,
								'ques_id'=> $question_id,
								'is_default' => $is_default

							), 
							array( 
								'%s',
				                '%d',
				                '%s'

								 
							) 
						   );
             }

            }
            else if($_GET['type_id'] == '1')
              {

                   
                if($wpdb->num_rows == '1')
                  {
                  	 
                  	$error_type2='1';
              ?>
              
                <?php
		             }
		             else
		             {

                         $wpdb->insert( 
							'cp_question_answers', 
							array( 
								'ques_answer' => $ques_answer,
								'ques_id'=> $question_id,
								'is_default' => $is_default

							), 
							array( 
								'%s',
				                '%d',
				                '%s'

								 
							) 
						   );

                       }
         

                }
                else if($_GET['type_id'] == '3')
                {
                        $wpdb->insert( 
							'cp_question_answers', 
							array( 
								'ques_answer' => $ques_answer,
								'ques_id'=> $question_id 

							), 
							array( 
								'%s',
				                '%d' 

								 
							) 
						   );

                }
    
  
        header('Location:/wp-admin/admin.php?page=Question&error_type='.$error_type2);

        }

	  	
       ?>
        <h2>Add Answers for specific question.</h2>
        <div><b>Question Type : </b><?php echo $getquestion_data[0]->qtype; ?></div>
        <div style="padding-top: 20px;"><b>Question Desc : </b><?php echo $getquestion_data[0]->question; ?></div>
 
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.18.0/jquery.validate.js'></script>
		  <script type="text/javascript">
		  	jQuery(document).ready(function () {
		      jQuery('#addnanswer').validate({ // initialize the plugin
		   errorElement: "div",
		        rules: {
		            ques_answer:{
		                  required: true
					       } 
				  },

				messages:{

					 ques_answer:{
		                  required:"Please enter the answer"
					  }
		        }
		    });

		});
		</script>



        <form name="addnanswer" id="addnanswer" method="post" action="">

         <?php
         if($getquestion_data[0]->type == '1' )
         {
         ?>
         <div style="padding-top: 20px;">
	         <textarea rows="5" cols="60" name="ques_answer" id="ques_answer"></textarea>
         </div>
         <?php
          }
         
         else if($getquestion_data[0]->type == '2' )
         {

         ?>
         <div style="padding-top: 20px;">
	         <input name="ques_answer" value="True" type="radio">True
	         <input name="ques_answer" value="false" type="radio">False
         </div>
         <?php	 
         }
         else if($getquestion_data[0]->type=='4')
         {
          ?>
           <div style="padding-top: 20px;">
		         <input name="ques_answer" value="True" type="radio">Yes
		         <input name="ques_answer" value="false" type="radio">No
         </div>
          <?php
         }
         
         else if($getquestion_data[0]->type=='3')
         {
          ?>
            <div style="padding-top: 20px;">
            <textarea rows="5" cols="60" name="ques_answer" id="ques_answer"></textarea>
            </div>

          <?php
           }
          if($getquestion_data[0]->type =='2' || $getquestion_data[0]->type =='4')
          {
         ?>
         <div style="padding-top: 20px;">
          <input name="is_default" value="1" type="checkbox">Is Default Answer </div>
         <?php } ?>

         <div style="padding-top: 20px;">
          <input type="submit" name="submitanswer" value="Add Answer" ></div>

         </form> 

         <div style="padding-top: 20px;padding-left:10px;"><a href='javascript:history.back(1);'>Back</a></div>

      <?php

	  }

  if(isset($_POST['submit']))
  {

    $qtype_id = $_POST['qtype_id'];
    $question  = $_POST['question'];

     if($_GET['q_id']!='')

     {

      $wpdb->update( 
			'cp_questions', 
			array( 
				'question' => $question,
				'qtype_id'=> $qtype_id	// string
				
			), 
			array( 'qid' => $_GET['q_id'] ), 
			array( 
				'%s',
				'%d'	// value1
				
			) 
        );

     	

  	}
  	else
  	{
  		//echo $qtype;
  		//exit;
         $wpdb->insert( 
			'cp_questions', 
			array( 
				'question' => $question,
				'qtype_id'=> $qtype_id

			), 
			array( 
				'%s',
                '%d'

				 
			) 
		);

  	}

  	header('Location:/wp-admin/admin.php?page=Question');

  }

$resultsedit=$wpdb->get_results("select * from cp_questions where qid='".$_GET['q_id']."'");

   if($_GET['action']!='delete'&& $_GET['action']!='answer' && $_GET['action']!='Viewanswer' && $_GET['action']!='editans' )
   {


  ?>



<div style="padding-top: 30px;">

  <?php if($_GET['q_id']) { ?> <h2>Edit Question </h2> <?php } else { ?> <h2>Add Question </h2> <?php } ?>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.18.0/jquery.validate.js'></script>
  <script type="text/javascript">
  	jQuery(document).ready(function () {
      jQuery('#frmeditqtype').validate({ // initialize the plugin
   errorElement: "div",
        rules: {
            qtype_id:{
                  required: true
			       },
			question: {
                  required: true
			       }
		  },

		messages:{

			 qtype_id:{
                  required:"Please select question type"
			  },
			 question:{
                  required:"Please enter the question"
			  } 


        }
    });

});
</script>


  <form name="frmeditqtype" id="frmeditqtype" method="post" action="">
  <table border="1" width="50%">
  <tr>
  <td>Question Type</td>
  <td>
  <select name="qtype_id" id="qtype_id">
  <option value="">Select Question Type</option>
  <?php
  foreach ($resultsqt as $resultqt) {
  	?>
   <option value="<?php echo $resultqt->id; ?>" <?php if($resultqt->id == $resultsedit[0]->qtype_id) { ?> selected='selected' <?php } ?>><?php echo $resultqt->qtype; ?></option>
  <?php
  }
  ?>
  </select>
  </td>
  <tr>
  <td>Question</td>
  <td><textarea rows="5" cols="60" name="question" id="question"><?php echo $resultsedit[0]->question; ?></textarea></td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  <td><input type="submit" name="submit" id="submit" <?php if($_GET['q_id']) { ?> value="Update" <?php } else { ?> value="Add" <?php } ?> ></td>
  </tr>
  </table>
  </form>
  </div>
  <div style="padding-top: 20px;padding-left:10px;"><a href='javascript:history.back(1);'>Back</a></div> 
  <?php
}
}