<?php ?>
<script type="text/javascript">
$(document).ready(function()
{
	$('#membership_id').multiselect(
	{
		nonSelectedText :'Select Membership',
		includeSelectAllOption: true
	});
	$('#acitivity_form').validationEngine();
	$('#add_staff_form').validationEngine();
	$('#membership_form').validationEngine();
	$('#specialization').multiselect(
	{
		nonSelectedText :'Select Specialization',
		includeSelectAllOption: true
	});
    $(".specialization_submit").click(function()
	{	
		checked = $(".multiselect_validation_specialization .dropdown-menu input:checked").length;
		if(!checked) 
		{
		  alert("Please select atleast one specialization name");
		  return false;
		}	
    });

		 
	   $(".membership_submit").click(function()
		 {	
		  checked = $(".multiselect_validation .dropdown-menu input:checked").length;
		if(!checked)
		{
		  alert("Please select atleast one membership");
		  return false;
		}	
		}); 
	 $.fn.datepicker.defaults.format =" <?php echo get_option('gmgt_datepicker_format');?>";
      $('.birth_date').datepicker({
     endDate: '+0d',
        autoclose: true
   }); 
	//------ADD STAFF MEMBER AJAX----------
	 $('#add_staff_form').on('submit', function(e) {
		e.preventDefault();
		var form = $(this).serialize();
		var valid = $('#add_staff_form').validationEngine('validate');
		/* if (valid == true) {
			$('.modal').modal('hide');
		} */
		$.ajax({
			type:"POST",
			url: $(this).attr('action'),
			data:form,
			success: function(data){
				if(data!='0')
				{				
					if(data!="")
					{ 
						$('#add_staff_form').trigger("reset");
						$('#staff_id').append(data);
						$('.upload_user_avatar_preview').html('<img alt="" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">');
						$('.gmgt_user_avatar_url').val('');
					}
					$('.modal').modal('hide');
					$('.show_msg').css('display','none');
				}
				else
				{				
					$('.show_msg').css('display','block');
				}					
			},
			error: function(data){

			}
		})
	});
	
	//------ADD MEMBERSHIP AJAX----------
	$('#membership_form').on('submit', function(e) {
		e.preventDefault();
		var form = $(this).serialize();
		var valid = $('#membership_form').validationEngine('validate');
		/* if (valid == true) {
			$('.modal').modal('hide');
		} */
		var categCheck_membership = $('#membership_id').multiselect();
		$.ajax({
			type:"POST",
			url: $(this).attr('action'),
			data:form,
			success: function(data){
				if(data!='0')
				{
					if(data!="")
					{ 
						$('#membership_form').trigger("reset");
						$('#membership_id').append(data);
						categCheck_membership.multiselect('rebuild');	
					}
					$('.modal').modal('hide');
					$('.show_msg').css('display','none');
				}
				else
				{				
					$('.show_msg').css('display','block');
				}	
			},
			error: function(data){

			}
		})
	});
	
} );
</script>
    <?php 	
	if($active_tab == 'addactivity')
	{
        	$activity_id=0;
			if(isset($_REQUEST['activity_id']))
				$activity_id=$_REQUEST['activity_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
				{
					$edit=1;
					$result = $obj_activity->get_single_activity($activity_id);
				}?>
		
        <div class="panel-body">
			<form name="acitivity_form" action="" method="post" class="form-horizontal" id="acitivity_form">
				<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
				<input type="hidden" name="action" value="<?php echo $action;?>">
				<input type="hidden" name="activity_id" value="<?php echo $activity_id;?>"  />
				<div class="form-group">
					<label class="col-sm-2 control-label" for="activity_category"><?php _e('Training Category','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<select class="form-control validate[required]" name="activity_cat_id" id="activity_category">
						<option value=""><?php _e('Select Training Category','gym_mgt');?></option>
						<?php 
						if(isset($_REQUEST['activity_cat_id']))
							$category =$_REQUEST['activity_cat_id'];  
						elseif($edit)
							$category =$result->activity_cat_id;
						else 
							$category = "";
						
						$activity_category=gmgt_get_all_category('activity_category');
						if(!empty($activity_category))
						{
							foreach ($activity_category as $retrive_data)
							{
								echo '<option value="'.$retrive_data->ID.'" '.selected($category,$retrive_data->ID).'>'.$retrive_data->post_title.'</option>';
							}
						}?>
						
						</select>
					</div>
					<div class="col-sm-2"><button id="addremove" model="activity_category"><?php _e('Add Or Remove','gym_mgt');?></button></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="activity_title"><?php _e('Training Title','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="activity_title" class="form-control validate[required,custom[onlyLetterSp]] text-input"  maxlength="50" type="text" value="<?php if($edit){ echo $result->activity_title;}elseif(isset($_POST['activity_title'])) echo $_POST['activity_title'];?>" name="activity_title">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="staff_name"><?php _e('Assign to Trainer','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<?php $get_staff = array('role' => 'Staff_member');
							$staffdata=get_users($get_staff);
							
							?>
						<select name="staff_id" class="form-control validate[required] " id="staff_id">
						<option value=""><?php  _e('Select Trainer','gym_mgt');?></option>
						<?php 
							
						$staff_data=$result->activity_assigned_to;
							if(!empty($staffdata))
							{
							foreach($staffdata as $staff)
							{
								
								echo '<option value='.$staff->ID.' '.selected($staff_data,$staff->ID).'>'.$staff->display_name.'</option>';
							}
							}
							?>
						</select>
					</div>
					<div class="col-sm-2">
					<!--<a href="?page=gmgt_staff&tab=add_staffmember" class="btn btn-default"> <?php _e('Add Trainer','gym_mgt');?></a>-->
					<a href="#" class="btn btn-default" data-toggle="modal" id="add_staff_btn" data-target="#myModal_add_staff_member"> <?php _e('Add Trainer','gym_mgt');?></a>
					
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="membership"><?php _e('Membership','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8 multiselect_validation">
						<?php 	$membershipdata=$obj_membership->get_all_membership();?>
						<select name="membership_id[]" class="form-control validate[required]" multiple="multiple" id="membership_id">
						
						<?php $getmembership_array=array();
						if($edit)
							$getmembership_array=$obj_activity->get_activity_membership($activity_id);
						elseif(isset($_REQUEST['membership_id']))
							$getmembership_array[]=$_REQUEST['membership_id'];
							
							if(!empty($membershipdata))
							 {
								foreach ($membershipdata as $membership){?>
									<option value="<?php echo $membership->membership_id;?>" <?php if(in_array($membership->membership_id,$getmembership_array)) echo "selected";?> ><?php echo $membership->membership_label;?></option>
							<?php }
							} ?>
						</select>
					</div>
					<div class="col-sm-2">
					<!--<a href="?page=gmgt_membership_type&tab=addmembership" class="btn btn-default"> <?php _e('Add Membership','gym_mgt');?></a>-->
					<a href="#" class="btn btn-default" data-toggle="modal" id="add_membership_btn" data-target="#myModal_add_membership"> <?php _e('Add Membership','gym_mgt');?></a>
					</div>
				</div>
				<div class="col-sm-offset-2 col-sm-8">
					<input type="submit" value="<?php if($edit){ _e('Save','gym_mgt'); }else{ _e('Save','gym_mgt');}?>" name="save_activity" class="btn btn-success membership_submit"/>
				</div>
			</form>
        </div>
<?php 
    } 
 ?>
<!----------ADD STAFF MEMBER----------->
<div class="modal fade" id="myModal_add_staff_member" role="dialog" style="overflow:scroll;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h3 class="modal-title"><?php _e('Add Staff Member','gym_mgt');?></h3>
			</div>
			<div id="message" class="updated below-h2 show_msg">
				<p>
				<?php _e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?>
				</p>
			</div>
			<div class="modal-body">
			    <form name="staff_form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="form-horizontal" id="add_staff_form" enctype="multipart/form-data">	
					<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
					<input type="hidden" name="action" value="gmgt_add_staff_member">
					<input type="hidden" name="role" value="staff_member"  />
					<input type="hidden" name="user_id" value=""  />
					<div class="header">	
						<h4><?php _e('Personal Information','gym_mgt');?></h4>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="first_name"><?php _e('First Name','gym_mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-8">
							<input id="first_name" class="form-control validate[required,custom[onlyLetterSp]] text-input"  maxlength="50" type="text" value="" name="first_name">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="middle_name"><?php _e('Middle Name','gym_mgt');?></label>
						<div class="col-sm-8">
							<input id="middle_name" class="form-control validate[custom[onlyLetterSp]] text-input"  maxlength="50" type="text"  value="" name="middle_name">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="last_name"><?php _e('Last Name','gym_mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-8">
							<input id="last_name" class="form-control validate[required,custom[onlyLetterSp]] text-input"  maxlength="50" type="text"  value="" name="last_name">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="gender"><?php _e('Gender','gym_mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-8">
						<?php $genderval = "male";?>
							<label class="radio-inline">
							 <input type="radio" value="male" class="tog validate[required]" name="gender"  <?php  checked( 'male', $genderval);  ?>/><?php _e('Male','gym_mgt');?>
							</label>
							<label class="radio-inline">
							  <input type="radio" value="female" class="tog validate[required]" name="gender"  <?php  checked( 'female', $genderval);  ?>/><?php _e('Female','gym_mgt');?> 
							</label>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="birth_date"><?php _e('Date of birth','gym_mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-8">
							<input id="birth_date2" class="form-control validate[required] birth_date" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>" type="text"  name="birth_date" 
							value="">
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-2 control-label" for="role_type"><?php _e('Assign Role','gym_mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-8">
						
							<select class="form-control" name="role_type" id="role_type">
							<option value=""><?php _e('Select Role','gym_mgt');?></option>
							<?php 
							
								$category = "";
							
							$role_type=gmgt_get_all_category('role_type');
							if(!empty($role_type))
							{
								foreach ($role_type as $retrive_data)
								{
									echo '<option value="'.$retrive_data->ID.'" '.selected($category,$retrive_data->ID).'>'.$retrive_data->post_title.'</option>';
								}
							}
							?>
							
							</select>
						</div>
						<div class="col-sm-2"><button id="addremove" model="role_type"><?php _e('Add Or Remove','gym_mgt');?></button></div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="specialization"><?php _e('Specialization','gym_mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-8 multiselect_validation_specialization">
							<select class="form-control" name="specialization[]" id="specialization" multiple="multiple">
							<?php 
							$category = array();
							$specialization=gmgt_get_all_category('specialization');
							if(!empty($specialization))
							{
								foreach ($specialization as $retrive_data)
								{
									$selected = "";
									if(in_array($retrive_data->ID,$category))
										$selected = "selected";
									echo '<option value="'.$retrive_data->ID.'"'.$selected.'>'.$retrive_data->post_title.'</option>';
								}
							}?>
							</select>
							<button id="addremove" model="specialization"><?php _e('Add Or Remove','gym_mgt');?></button>
						</div>	
					</div>
					<div class="header">	<hr>
						<h4><?php _e('Contact Information','gym_mgt');?></h4>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="address"><?php _e('Home Town Address','gym_mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-8">
							<input id="address" class="form-control validate[required]" type="text" maxlength="150"  name="address" 
							value="">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label" for="city_name"><?php _e('City','gym_mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-8">
							<input id="city_name" class="form-control validate[required,custom[onlyLetterSp]]" maxlength="50" type="text"  name="city_name" 
							value="">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label " for="mobile"><?php _e('Mobile Number','gym_mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-1">
						
						<input type="text" readonly value="+<?php echo gmgt_get_countery_phonecode(get_option( 'gmgt_contry' ));?>"  class="form-control" name="phonecode">
						</div>
						<div class="col-sm-7">
							<input id="mobile" class="form-control validate[required,custom[phone]] text-input phone_validation"  minlength="10" maxlength="15" type="text"  name="mobile"
							value="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label " for="phone"><?php _e('Phone','gym_mgt');?></label>
						<div class="col-sm-8">
							<input id="phone" class="form-control validate[custom[phone]] text-input phone_validation" minlength="10" maxlength="15" type="text"  name="phone" 
							value="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label " for="email"><?php _e('Email','gym_mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-8">
							<input id="email" class="form-control validate[required,custom[email]] text-input" maxlength="50" type="text"  name="email" 
							value="">
						</div>
					</div>
					<div class="header">	<hr>
						<h4><?php _e('Login Information','gym_mgt');?></h4>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="username"><?php _e('User Name','gym_mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-8">
							<input id="username" class="form-control validate[required] space_validation"  maxlength="30" type="text"  name="username" 
							value="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="password"><?php _e('Password','gym_mgt');?><?php if(!$edit) {?><span class="require-field">*</span><?php }?></label>
						<div class="col-sm-8">
							<input id="password" class="form-control space_validation" type="password" minlength="8" maxlength="12"  name="password" value="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="photo"><?php _e('Image','gym_mgt');?></label>
						<div class="col-sm-2">
							<input type="text" id="gmgt_user_avatar_url1" class="form-control gmgt_user_avatar_url" name="gmgt_user_avatar"  
							value="" />
						</div>	
							<div class="col-sm-3">
								 <input id="upload_user_avatar_button1" type="button" class="button upload_user_avatar_button" value="<?php _e( 'Upload image', 'gym_mgt' ); ?>" />
								 <span class="description"><?php _e('Upload image', 'gym_mgt' ); ?></span>
						</div>
						<div class="clearfix"></div>
						
						<div class="col-sm-offset-2 col-sm-8">
								 <div id="upload_user_avatar_preview1" class="upload_user_avatar_preview">
									 
									<img alt="" style="max-width:100%;" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">
								</div>
					    </div>
					</div>
					<div class="col-sm-offset-2 col-sm-8">
						<input type="submit" value="<?php _e('Add Staff','gym_mgt');?>" name="save_staff" id="add_staff_member" class="btn btn-success specialization_submit"/>
					</div>
				</form>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
	 <!----------ADD MEMBERSHIP POPUP------------->
	<div class="modal fade" id="myModal_add_membership" role="dialog" style="overflow:scroll;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <h3 class="modal-title"><?php _e('Add Membership','gym_mgt');?></h3>
				</div>
				<div id="message" class="updated below-h2 show_msg">
					<p>
					<?php _e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?>
					</p>
				</div>
				<div class="modal-body">
					<form name="membership_form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="form-horizontal" id="membership_form">
						<input type="hidden" name="action" value="gmgt_add_ajax_membership">
						<input type="hidden" name="membership_id" value=""  />
						<div class="form-group">
							<label class="col-sm-2 control-label" for="membership_name"><?php _e('Membership Name','gym_mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-8">
								<input id="membership_name" class="form-control validate[required,custom[onlyLetterSp]] text-input" maxlength="50" type="text" value="" name="membership_name">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="membership_category"><?php _e('Membership Category','gym_mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-8">			
								<select class="form-control" name="membership_category" id="membership_category">
								<option value=""><?php _e('Select Membership Category','gym_mgt');?></option>
								<?php 				
								$category = "";
								$mambership_category=gmgt_get_all_category('membership_category');
								if(!empty($mambership_category))
								{
									foreach ($mambership_category as $retrive_data)
									{
										echo '<option value="'.$retrive_data->ID .'" '.selected($category,$retrive_data->ID).'>'.$retrive_data->post_title .'</option>';
									}
								}
								?>				
								</select>
							</div>
							<div class="col-sm-2"><button id="addremove" model="membership_category"><?php _e('Add Or Remove','gym_mgt');?></button></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="membership_period"><?php _e('Membership Period','gym_mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-8">
								<!--<select class="form-control" name="membership_period" id="membership_period">
								<option value=""><?php _e('Select Membership Period','gym_mgt');?></option>
								<?php 
								$category = "";
								$membership_period=gmgt_get_all_category('membership_period');
								if(!empty($membership_period))
								{
									foreach ($membership_period as $retrive_data)
									{
										echo '<option value="'.$retrive_data->ID.'" '.selected($category,$retrive_data->ID).'>'.$retrive_data->post_title.'</option>';
									}
								}
								?>
								</select>
								<div class="col-sm-2"><button id="addremove" model="membership_period"><?php _e('Add Or Remove','gym_mgt');?></button></div>-->
								<input id="membership_period" class="form-control validate[required,custom[number]] text-input" type="number" onKeyPress="if(this.value.length==3) return false;"  value="<?php if($edit){ echo $result->membership_length_id;}elseif(isset($_POST['membership_period'])) echo $_POST['membership_period'];?>" name="membership_period" placeholder="<?php _e('Enter Total Number of Days','gym_mgt');?>">

							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="member_limit"><?php _e('Members Limit','gym_mgt');?></label>
							<div class="col-sm-8">
							<?php $limitval = "unlimited"; ?>
								<label class="radio-inline">
								 <input type="radio" value="limited" class="tog" name="member_limit"  <?php  checked( 'limited', $limitval);  ?>/><?php _e('limited','gym_mgt');?>
								</label>
								<label class="radio-inline">
								  <input type="radio" value="unlimited" class="tog" name="member_limit"  <?php  checked( 'unlimited', $limitval);  ?>/><?php _e('unlimited','gym_mgt');?> 
								</label>
							</div>
						</div>
						
						<div id="member_limit"></div>		
						<div class="form-group">
							<label class="col-sm-2 control-label" for="classis_limit"><?php _e('Classic Limit','gym_mgt');?></label>
							<div class="col-sm-8">
							<?php $limitvals = "unlimited"; if($edit){ $limitvals=$result->classis_limit; }elseif(isset($_POST['gender'])) {$limitvals=$_POST['gender'];}?>
								<label class="radio-inline">
								 <input type="radio" value="limited" class="classis_limit" name="classis_limit"  <?php  checked( 'limited', $limitvals);  ?>/><?php _e('limited','gym_mgt');?>
								</label>
								<label class="radio-inline">
								  <input type="radio" value="unlimited" class="classis_limit validate[required]" name="classis_limit"  <?php  checked( 'unlimited', $limitvals);  ?>/><?php _e('unlimited','gym_mgt');?> 
								</label>
							</div>
						</div>
						<div id="classis_limit"></div>	
						

						<div class="form-group">
							<label class="col-sm-2 control-label" for="installment_amount"><?php _e('Membership Amount','gym_mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-8">
								<input id="membership_amount" class="form-control validate[required] text-input" type="number" min="0"  onkeypress="if(this.value.length==6) return false;" value="" name="membership_amount">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="installment_plan"><?php _e('Installment Plan','gym_mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-2">
								<input id="installment_amount" class="form-control validate[required] text-input" type="number" min="0"  onkeypress="if(this.value.length==6) return false;" value="" name="installment_amount" placeholder="Amount">
							</div>
							<div class="col-sm-6">
							
								<select class="form-control" name="installment_plan" id="installment_plan">
								<option value=""><?php _e('Select Installment Plan','gym_mgt');?></option>
								<?php 
								
									$category = "";
								
								$installment_plan=gmgt_get_all_category('installment_plan');
								if(!empty($installment_plan))
								{
									foreach ($installment_plan as $retrive_data)
									{
										echo '<option value="'.$retrive_data->ID.'" '.selected($category,$retrive_data->ID).'>'.$retrive_data->post_title.'</option>';
									}
								}
								?>
								
								</select>
							</div>
							<div class="col-sm-2"><button id="addremove" model="installment_plan"><?php _e('Add Or Remove','gym_mgt');?></button></div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="signup_fee"><?php _e('Signup Fee','gym_mgt');?></label>
							<div class="col-sm-8">
								<input id="signup_fee" class="form-control text-input" type="number" min="0"  onkeypress="if(this.value.length==6) return false;" value="<?php if($edit){ echo $result->signup_fee;}elseif(isset($_POST['membership_name'])) echo $_POST['membership_name'];?>" name="signup_fee">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="signup_fee"><?php _e('Membership Description','gym_mgt');?></label>
							<div class="col-md-8">
								<?php wp_editor(isset($result->membership_description)?stripslashes($result->membership_description) : '','description'); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="gmgt_membershipimage"><?php _e('Membership Image','gym_mgt');?></label>
							<div class="col-sm-8">			
								<input type="text" id="gmgt_user_avatar_url1" class="gmgt_user_avatar_url" name="gmgt_membershipimage" 
								value="" />	
								 <input id="upload_image_button1" type="button" class="button upload_user_avatar_button" value="<?php _e( 'Upload Cover Image', 'gym_mgt' ); ?>" />
								 <span class="description"><?php _e('Upload Membership Image', 'gym_mgt' ); ?></span>
								<div class="upload_user_avatar_preview" id="upload_user_avatar_preview1" style="min-height: 100px;">
									<img style="max-width:100%;" src="" />
								</div>
							</div>
						</div>
						<div class="col-sm-offset-2 col-sm-8">
							<input type="submit" value="<?php  _e('Add Membership','gym_mgt');?>" name="save_membership" class="btn btn-success"/>
						</div>
					</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
			</div>
		</div>
	</div>	