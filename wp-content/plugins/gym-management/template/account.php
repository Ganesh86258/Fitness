<?php 
	$user = wp_get_current_user ();
	$obj_member=new MJ_Gmgtmember;
	$user_data =get_userdata( $user->ID);
	require_once ABSPATH . 'wp-includes/class-phpass.php';
	$user_data =get_userdata( $user->ID);	
	$first_name = get_user_meta($user_data->ID,'first_name',true);
	$last_name = get_user_meta($user_data->ID,'last_name',true);	
	$wp_hasher = new PasswordHash( 8, true );
	if(isset($_POST['save_change']))
	{
		$referrer = $_SERVER['HTTP_REFERER'];
		$success=0;
		if($wp_hasher->CheckPassword($_REQUEST['current_pass'],$user_data->user_pass))
		{
			if($_REQUEST['new_pass']==$_REQUEST['conform_pass'])
			{
				 wp_set_password( $_REQUEST['new_pass'], $user->ID);
				$success=1;
			}
			else
			{
				wp_redirect($referrer.'&sucess=2');
			}
			
		}
		else
		{
			wp_redirect($referrer.'&sucess=3');
		}
		if($success==1)
		{
			 wp_cache_delete($user->ID,'users');
			wp_cache_delete($user_data->user_login,'userlogins');
			wp_logout();
			if(wp_signon(array('user_login'=>$user_data->user_login,'user_password'=>$_REQUEST['new_pass']),false)):
				$referrer = $_SERVER['HTTP_REFERER'];
				
				wp_redirect($referrer.'&sucess=1');
			endif;
			ob_start();
		}else
		{
			wp_set_auth_cookie($user->ID, true);
		}
	}
?>
<?php 
	$edit=1;
	$coverimage=get_option( 'gmgt_gym_background_image' );
	if($coverimage!="")
	{?>

<style>
	.profile-cover{
		background: url("<?php echo get_option( 'gmgt_gym_background_image' );?>") repeat scroll 0 0 / cover rgba(0, 0, 0, 0);
	}
<?php }?>
</style>
<script type="text/javascript">

var file_counter = 1;
			var total_file = 1;

$(document).ready(function() {
	$('#doctor_form').validationEngine();
	 $.fn.datepicker.defaults.format =" <?php echo get_option('gmgt_datepicker_format');?>";
      $('#birth_date').datepicker({
     endDate: '+0d',
        autoclose: true
   });  
   $('.space_validation').keypress(function( e ) {
       if(e.which === 32) 
         return false;
    });

jQuery("#btn_add_more").click(function (e) {

	  //alert(file_counter);
					
						file_counter++;
						total_file++;
						jQuery('#fields_wrapper').append('<div class="input-group" id="file_group' + file_counter + '"><div class="input-group-btn"><span class="fileUpload btn btn-success"><span class="upl" id="upload' + file_counter + '">Upload your Certificates</span><input type="file" class="upload up" name="attachment[]" id="attachment[]" data-multiple-caption="{count} files selected" onchange="javascript: onFileSelectForMulti(this,' + file_counter + ');"/></span> </div><a href="javascript:removeFile(' + file_counter + ');">Remove</a></div>');
						console.log("after add - " + file_counter);					
				});

function onFileSelectForMulti(curr_file_ele, file_number) {

				if (curr_file_ele.value == '') {
					jQuery("#upload" + file_number).html("No file chosen");
				} else {
					jQuery("#upload" + file_number).html(curr_file_ele.value.replace(/C:\\fakepath\\/i, ''));
				}
			}






} );


function removeFile(file_number) {
	//alert("hi");
				console.log("before-" + total_file);
				jQuery('#file_group' + file_number).remove();
				total_file--;
				console.log("after-" + total_file);
			}

function removeFileuploaded(file_name,uid)
{
	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	//alert(uid);
	var data = { 
	          action: 'delete_file',
             file_name: file_name,
             uid:uid
               }
   jQuery.ajax({
		     type:'POST', 
			 url:ajaxurl,
			 data,
		        success: function(data){
		        	console.log(data);

		         jQuery('#show').html(data);
		        }
		    });
	//alert(file_name);
}

</script>
<div>
	<div class="profile-cover">
		<div class="row">
			<div class="col-md-3 profile-image">
				<div class="profile-image-container">
					<?php $umetadata=get_user_meta($user->ID, 'gmgt_user_avatar', true);
					if(empty($umetadata)){
						echo '<img src='.get_option( 'gmgt_system_logo' ).' height="150px" width="150px" class="img-circle" />';
					}
					else
						echo '<img src='.$umetadata.' height="150px" 
					width="150px" class="img-circle" />';
	                ?>
				</div>
			</div>
		</div>
	</div>				
	<div id="main-wrapper"> 
		<div class="row">
			<div class="col-md-3 user-profile">
				<h3 class="text-center">
					<?php 
						echo $user_data->display_name;
					?>
				</h3>				
				<hr>
				<ul class="list-unstyled text-center">
				<li>
				<p><i class="fa fa-map-marker m-r-xs"></i>
					<?php echo $user_data->address.",".$user_data->city;?></p>
				</li>	
				<li><i class="fa fa-envelope m-r-xs"></i>
					<?php echo 	$user_data->user_email;?></p>
				</p></li>
				</ul>
				<?php if($obj_gym->role == "staff_member"){?>
				<h3 class="text-center">
					<?php 
						echo __('My Activity','gym_mgt');
					?>
				</h3>
				<ul class="list-unstyled activity_list">
				<?php 
					$activity_list = gym_get_activity_by_staffmember(get_current_user_id());
					if(!empty($activity_list))
						foreach($activity_list as $retrive)
						{
							echo "<li> <i class='fa fa-arrow-right'></i> ".$retrive->activity_title."</li>";
						}
				?>	
				</ul>			
				<hr>
				<?php }?>
			</div>			
				<?php if(isset($_REQUEST['message']))
				{
					$message =$_REQUEST['message'];
					if($message == 2)
					{ ?><div class="col-md-8 m-t-lg"><div id="message" class="updated below-h2 "><p><?php
								_e("Record updated successfully.",'gym_mgt');
								?></p>
								</div>
						</div>
							<?php 
					}
				}?>
				<div class="col-md-8 m-t-lg">
				    <div class="panel panel-white">
				        <div class="panel-heading">
							<div class="panel-title"><?php _e('Account Settings ','gym_mgt');?>	</div>
						</div>
						<div class="panel-body">
							<form class="form-horizontal" action="#" method="post">
								<div class="form-group">
										<label  class="control-label col-xs-2"></label>
										<div class="col-xs-10">	
											<p>
												<h4 class="bg-danger"><?php 
												if(isset($_REQUEST['sucess']))
												{ 
													if($_REQUEST['sucess']==1)
													{
														wp_safe_redirect(home_url()."?dashboard=user&page=account&action=edit&message=2" );
													}
												}?></h4>
										    </p>
										</div>
								</div>
								<div class="form-group">
									<label for="inputEmail" class="control-label col-sm-2"><?php _e('Name','gym_mgt');?></label>
									<div class="col-sm-10">
										<input type="Name" class="form-control validate[custom[onlyLetterSp]]" id="name" maxlength="50" placeholder="Full Name" value="<?php echo $user->display_name; ?>" readonly>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail" class="control-label col-sm-2"><?php _e('Username','gym_mgt');?></label>
									<div class="col-sm-10">
										<input type="username" class="form-control space_validation" maxlength="50" id="name" placeholder="Full Name" value="<?php echo $user->user_login; ?>" readonly>
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword" class="control-label col-sm-2 "><?php _e('Current Password','gym_mgt');?></label>
									<div class="col-sm-10">
										<input type="password" class="form-control space_validation" min_length="8" maxlength="12" id="inputPassword" placeholder="<?php _e('Current Password','gym_mgt');?>"  name="current_pass">
									</div>
								</div>
								<div class="form-group">
											<label for="inputPassword" class="control-label col-sm-2"><?php _e('New Password','gym_mgt');?></label>
											<div class="col-sm-10">
												<input type="password" class="validate[required] form-control space_validation" min_length="8" maxlength="12" id="inputPassword" placeholder="<?php _e('New Password','gym_mgt');?>" name="new_pass">
											</div>
								</div>
						        <div class="form-group">
									<label for="inputPassword" class="control-label col-sm-2"><?php _e('Confirm Password','gym_mgt');?></label>
									<div class="col-sm-10">
										<input type="password" class="validate[required] form-control space_validation" id="inputPassword"  min_length="8" maxlength="12" placeholder="<?php _e('Confirm Password','gym_mgt');?>" name="conform_pass">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" class="btn btn-success" name="save_change"><?php _e('Save','gym_mgt');?></button>
									</div>
								</div>
							</form>
						</div>		   
					</div>					
					<?php 


                    /*if( is_user_logged_in() ) {
                    $user = wp_get_current_user();
				    $role = ( array ) $user->roles;
				    echo"============". $role[0];
                      }
                    */


					$user_info=get_userdata(get_current_user_id());

					$user_meta_info = get_user_meta(get_current_user_id());

					global $wpdb;

					if (is_numeric($user_meta_info['Country'][0]))
					{
        
                    $result_country=$wpdb->get_results("SELECT * FROM wp_countries where id='".$user_meta_info['Country'][0]."'",ARRAY_A);

                     $Country = $result_country[0]['name']; 

                    }
                    else
                    {
                        $Country = $user_meta_info['Country'][0];
                      
                    }

                   if (is_numeric($user_meta_info['State'][0]))
					{

                    $result_state=$wpdb->get_results("SELECT * FROM wp_states where id='".$user_meta_info['State'][0]."'",ARRAY_A);

                     $State =  $result_state[0]['name'];

                    }
                    else
                    {

                    	$State =  $user_meta_info['State'][0];
                    }

                    if (is_numeric($user_meta_info['city'][0]))
					{

                     $result_city=$wpdb->get_results("SELECT * FROM cities where id='".$user_meta_info['city'][0]."'",ARRAY_A);
                   
                     $city =  $result_city[0]['name'];

                    
                    }
                    else
                    {
                    	$city =  $user_meta_info['city'][0];
                    }

                                       
					  $current_status = $user_meta_info['current_status'][0];
					  $phone = $user_meta_info['Phone_number'][0];
					  $Sport = $user_meta_info['Sport'][0];
					  $Gym_name = $user_meta_info['Gym_name'][0];
					  $Location = $user_meta_info['Location'][0];
					  $Training_specialties = $user_meta_info['Training_specialties'][0];
					  $time_zone = $user_meta_info['time_zone'][0];
					  $trainer_type = $user_meta_info['trainer_type'][0];
					  echo $trainer_type;
					

					 ?> 
					<div class="panel panel-white">
					    <div class="panel-heading">
							<div class="panel-title"><?php _e('Other Information','gym_mgt');?>	</div>
						</div>
						<div class="panel-body">
							<form class="form-horizontal" action="#" method="post" id="doctor_form" enctype="multipart/form-data">
								<input type="hidden" value="edit" name="action">
								<input type="hidden" value="<?php echo $obj_gym->role;?>" name="role">
								<input type="hidden" value="<?php echo get_current_user_id();?>" name="user_id">
								<input type="hidden" value="<?php print $first_name ?>" name="first_name" >
								<input type="hidden" value="<?php print $last_name ?>" name="last_name" >
								<!--<div class="form-group">
									<label class="col-sm-2 control-label" for="birth_date"><?php _e('Date of birth','gym_mgt');?><span class="require-field">*</span></label>
									<div class="col-sm-10">
										<input id="birth_date" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>" class="form-control validate[required]" type="text"  name="birth_date" 
										value="<?php if($edit){ echo getdate_in_input_box($user_info->birth_date);}
										elseif(isset($_POST['birth_date'])) echo $_POST['birth_date'];?>">
									</div>

								</div>	
								<div class="form-group">

									<label for="inputEmail" class="control-label col-sm-2"><?php _e('Home Town Address','gym_mgt');?></label>

									<div class="col-sm-10">

										<input id="address" class="form-control validate[required]" maxlength="150" type="text"  name="address" value="<?php if($edit){ echo $user_info->address;}?>">

									</div>

								</div>-->
									<div class="form-group">

									<label for="inputEmail" class="control-label col-sm-2"><?php _e('Country','gym_mgt');?></label>

									<div class="col-sm-10">

										<input id="Country" class="form-control validate[required,,custom[onlyLetterSp]]" maxlength="50" type="text"  name="Country" value="<?php if($edit){ echo $Country;}?>">

									</div>

								</div>
								<div class="form-group">

									<label for="inputEmail" class="control-label col-sm-2"><?php _e('State','gym_mgt');?></label>

									<div class="col-sm-10">

										<input id="State" class="form-control validate[required,,custom[onlyLetterSp]]" maxlength="50" type="text"  name="State" value="<?php if($edit){ echo $State;}?>">

									</div>

								</div>
								<div class="form-group">

									<label for="inputEmail" class="control-label col-sm-2"><?php _e('City','gym_mgt');?></label>

									<div class="col-sm-10">

										<input id="city" class="form-control validate[required,,custom[onlyLetterSp]]" maxlength="50" type="text"  name="city" value="<?php if($edit){ echo $city;}?>">

									</div>

								</div>

								

								<div class="form-group">

									<label for="inputEmail" class="control-label col-sm-2"><?php _e('Sports','gym_mgt');?></label>

									<div class="col-sm-10">

										<input id="Sport" class="form-control " type="text" maxlength="15"  name="Sport" value="<?php if($edit){ echo $Sport;}?>">

									</div>

								</div>

								<?php
                               	$user = wp_get_current_user();
                                if ( in_array( 'member', (array) $user->roles ) ) {
                                ?>
								<div class="form-group">

									<label for="inputEmail" class="control-label col-sm-2"><?php _e('Current status','gym_mgt');?></label>

									<div class="col-sm-10">

										<input id="current_status" class="form-control " type="text" maxlength="15"  name="current_status" value="<?php if($edit){ echo $current_status;}?>">

									</div>

								</div>
								<?php } ?>

								<?php
								if ( in_array( 'staff_member', (array) $user->roles ) ) {
                                ?>
								<div class="form-group">

									<label for="inputEmail" class="control-label col-sm-2"><?php _e('Gym name','gym_mgt');?></label>

									<div class="col-sm-10">

										<input id="Gym_name" class="form-control " type="text" maxlength="15"  name="Gym_name" value="<?php if($edit){ echo $Gym_name;}?>">

									</div>

								</div>
								<?php
								if($trainer_type =='remote'){ ?>
								<div class="form-group">

									<label for="inputEmail" class="control-label col-sm-2"><?php _e('Time Zone','gym_mgt');?></label>

									<div class="col-sm-10">

										<input id="time_zone" class="form-control " type="text" maxlength="15"  name="time_zone" value="<?php if($edit){ echo $time_zone;}?>">

									</div>

								</div>
								<?php } ?>
								<div class="form-group">

									<label for="inputEmail" class="control-label col-sm-2"><?php _e('Location','gym_mgt');?></label>

									<div class="col-sm-10">

										<input id="Location" class="form-control " type="text"   name="Location" value="<?php if($edit){ echo $Location;}?>">

									</div>

								</div>

								<div class="form-group">

									<label for="inputEmail" class="control-label col-sm-2"><?php _e('Training specialties','gym_mgt');?></label>

									<div class="col-sm-10">

										<input id="Training_specialties" class="form-control " type="text" maxlength="15"  name="Training_specialties" value="<?php if($edit){ echo $Training_specialties;}?>">

									</div>

								</div>


								<!-- <div class="form-group">

									<label for="Certificates" class="control-label col-sm-2"><?php _e('Certificates','gym_mgt');?></label>

									<div class="col-sm-10">

										<input id="Certificates" class="form-control " type="file" maxlength="15"  name="certificates[]" value="<?php if($edit){  }?>">

									</div>

								</div> -->

								<div class="col-sm-12 col-xs-12">
                                   <div class="form-group" id="fields_wrapper">
                                    
                                      <div class="input-group">										  
                                        <div class="input-group-btn" >											
                                            <span class="fileUpload btn btn-success">												 
                                              <span class="upl" id="upload1">Upload your Certificates</span>
                                              <input type="file" class="upload up" name="attachment[]" id="attachment[]" data-multiple-caption="{count} files selected" onchange="javascript: onFileSelectForMulti(this, 1);"/>
                                            </span><!-- btn-orange -->


                                         </div><!-- btn -->                                         
                                          <!--  <a href="#"><i class="fa fa-remove"></i></a>  -->
                                     </div><!-- group -->
                                     
                                     
                                    
                                     
                                     
                                   </div><!-- form-group -->
                                    <a class="add_file"  id="btn_add_more"  data-hover="Add More" href="javascript:void(0)">Add another file</a>
                                </div>


                                <div style="margin-top: 130px;margin-bottom: 30px;" id="show">
                                <table>
                                <tr>
                                <th>Uploaded Documents</th>
                                 <th></th>
                                </tr>
                                
                                                        <?php

                                                        


                                                         $uid=get_current_user_id();
                                                        
                                                        $target_path = 'http://fitness.php-dev.in/wp-content/uploads/custom/';
                                                         $userdoc=get_user_meta($uid, 'documents', true);
                                                        // echo"==".$userdoc;
                                                         $userdocarr=explode(",", $userdoc);
                                                         // if(count($userdocarr)< 1){
                                                        // print_r($userdocarr);
                                                         $cnt=1;
                                                          for($doc=0;$doc<sizeof($userdocarr); $doc++){

                                                         $without_extension = pathinfo($userdocarr[$doc], PATHINFO_FILENAME);
                                                         if($userdoc){
                                                         ?>
                                                         <tr>
                                 <td  class="Certificates">
                                 
                                                         <a href="<?php echo $target_path. $userdocarr[$doc]; ?>" target="_blank"><!-- Certificate --><?php echo $without_extension; ?></a>&nbsp;&nbsp; <a href="javascript:removeFileuploaded('<?php echo $userdocarr[$doc]; ?>' ,'<?php echo $uid; ?>');">Remove</a>
                                                          
                                                          

                                                         </td>
                                                         
                                                         </tr>
                                                         <?php } $cnt++; } //} ?>
                                                         </table>
                                </div>
								
								
								<?php } ?>
								<div class="form-group">

									<label for="inputEmail" class="control-label col-sm-2"><?php _e('Phone','gym_mgt');?></label>

									<div class="col-sm-10">

										<input id="Phone_number" class="form-control text-input phone_validation" type="text" maxlength="15"  name="Phone_number" value="<?php if($edit){ echo $phone;}?>">

									</div>

								</div>
								<div class="form-group">

									<label for="inputEmail" class="control-label col-sm-2"><?php _e('Email','gym_mgt');?></label>

									<div class="col-sm-10">

										<input id="email" class="form-control validate[required,custom[email]] text-input" maxlength="50" type="text"  name="email" value="<?php if($edit){ echo $user_info->user_email;}?>" readonly>

									</div>

								</div>
								<div class="form-group">

									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" class="btn btn-success" name="profile_save_change"><?php _e('Save','gym_mgt');?></button>
									</div>
								</div>
							</form>
						</div>
					</div>
					
			    </div>					
		</div>
 	</div>
</div>
<?php 
	if(isset($_POST['profile_save_change']))
	{
		  //print_r($_FILES['attachment']['name'][0]);
		
		$cnt= count($_FILES['attachment']['name']);

		//echo  $cnt;
        $upload_dir = wp_upload_dir();
	    $temp_name = $_FILES['file']['tmp_name'];
        $target_path = $upload_dir["basedir"]."/custom/";
        $upload_path = $upload_dir['baseurl'];

        $file_array=array();

        for($i=0;$i<$cnt;$i++)
         {

          $target_path = $upload_dir["basedir"]."/custom/";
         	
          array_push($file_array,$_FILES['attachment']['name'][$i]);
          $target_path = $target_path . basename( $_FILES['attachment']['name'][$i]); 

		if(move_uploaded_file($_FILES['attachment']['tmp_name'][$i], $target_path)) {

			$target_path ='';
		    //echo "The file ".  basename( $_FILES['attachment']['name'][$i]).
		   // " has been uploaded";
		} else{
		   // echo "There was an error uploading the file, please try again!";
		}

     }




     $user_id =get_current_user_id();

     if($_FILES['attachment']['name'][0]=='')
     {
           
       $old_data= get_user_meta($user_id, 'documents', true); 

       //echo "old data".$old_data;
        update_user_meta( $user_id, 'documents', $old_data );

     }
     else
     {

      $old_data= get_user_meta($user_id, 'documents', true);
      if($old_data!='') 
      {
      	  array_push($file_array,$old_data);
      }

     $file_name_str = implode(",",$file_array);
     update_user_meta( $user_id, 'documents', $file_name_str );

     }
		 
		$result=$obj_member->gmgt_add_user($_POST);
		if($result)
		{ 
			wp_safe_redirect(home_url()."?dashboard=user&page=account&action=edit&message=2" );
		}
	}
?>