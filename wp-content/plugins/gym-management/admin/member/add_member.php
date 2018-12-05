<?php $role="member"; ?>
<script type="text/javascript">
    $(document).ready(function()
	{
		$('#member_form').validationEngine();	 
		$('#add_staff_form').validationEngine();	 
		$('#membership_form').validationEngine();	 
		$('#class_form').validationEngine();	 
		$("#group_form").validationEngine();
		$('#group_id').multiselect({
		nonSelectedText :'Select Group',
		includeSelectAllOption: true
		 });
		$('.classis_ids').multiselect({
		nonSelectedText :'Select Class',
		includeSelectAllOption: true
		 });
		$('#specialization').multiselect({
		nonSelectedText :'Select Specialization',
		includeSelectAllOption: true
		 });
		$('#day').multiselect({
		nonSelectedText :'Select Day',
		includeSelectAllOption: true
		 });
		$('#class_membership_id').multiselect(
		{
			nonSelectedText :'Select Membership',
			includeSelectAllOption: true
		});
		
	
		$(".specialization_submit").click(function()
		{	
			 checked = $(".multiselect_validation_staff .dropdown-menu input:checked").length;
			if(!checked)
			{
			  alert("Please select atleast one specialization");
			  return false;
			}	
		});
			
		$(".class_submit").click(function()
		{	
			checked = $(".multiselect_validation_member .dropdown-menu input:checked").length;
			if(!checked)
			{
			  alert("Please select atleast one class");
			  return false;
			}	
		}); 
		
		$(".day_validation_submit").click(function()
		{	
		checked = $(".day_validation_member .dropdown-menu input:checked").length;
			if(!checked)
			{
			  alert("Please select atleast One Day");
			  return false;
			}	  
		}); 
		
		$.fn.datepicker.defaults.format =" <?php echo get_option('gmgt_datepicker_format');?>";
		$('.birth_date').datepicker(
		{
			endDate: '+0d',
			autoclose: true
		}); 
		var date = new Date();
		date.setDate(date.getDate()-0);
		$.fn.datepicker.defaults.format =" <?php echo get_option('gmgt_datepicker_format');?>";
		 $('#inqiury_date').datepicker({	
			<?php
			if(get_option('gym_enable_datepicker_privious_date')=='no')
			{
			?>
				startDate: date,
			<?php
			}
			?>	
			autoclose: true
	   });
	   
		var date = new Date();
		date.setDate(date.getDate()-0);
		$.fn.datepicker.defaults.format =" <?php echo get_option('gmgt_datepicker_format');?>";
		 $('#triel_date').datepicker({
			<?php
			if(get_option('gym_enable_datepicker_privious_date')=='no')
			{
			?>
				startDate: date,
			<?php
			}
			?>	
		 autoclose: true
	   });
	   
	   //$('#begin_date').datepicker({dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>'}); 
	   
	   var date = new Date();
		date.setDate(date.getDate()-0);
		$.fn.datepicker.defaults.format =" <?php echo get_option('gmgt_datepicker_format');?>";
		  $('#begin_date').datepicker({
			<?php
			if(get_option('gym_enable_datepicker_privious_date')=='no')
			{
			?>
				startDate: date,
			<?php
			}
			?>	
		 autoclose: true
	   });
	   
		var date = new Date();
		date.setDate(date.getDate()-0);
		$.fn.datepicker.defaults.format =" <?php echo get_option('gmgt_datepicker_format');?>";
		  $('#first_payment_date').datepicker({
			<?php
			if(get_option('gym_enable_datepicker_privious_date')=='no')
			{
			?>
				startDate: date,
			<?php
			}
			?>	
		 autoclose: true
	   });

		//------ADD STAFF MEMBER AJAX----------
		$('#add_staff_form').on('submit', function(e) 
		{
			e.preventDefault();
			var form = $(this).serialize();
			var valid = $('#add_staff_form').validationEngine('validate');
			/* if (valid == true) 
			{
				$('.modal').modal('hide');
			} */
			$.ajax(
			{
				type:"POST",
				url: $(this).attr('action'),
				data:form,
				success: function(data)
				{					
					if(data!='0')
					{ 
						if(data!="")
						{ 
							$('#add_staff_form').trigger("reset");
							$('#staff_id').append(data);
							$('#reference_id').append(data);
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
		//------ADD GROUP AJAX----------
		
		$('#group_form').on('submit', function(e)
		{
			e.preventDefault();
			var form = $(this).serialize();
			var valid = $("#group_form").validationEngine('validate');
			if (valid == true)
			{
				$('.modal').modal('hide');
			}
			var categCheck_group = $('#group_id').multiselect();	
			$.ajax(
			{
				type:"POST",
				url: $(this).attr('action'),
				data:form,
				success: function(data){
					if(data!=""){ 
						$('#group_form').trigger("reset");
						$('#group_id').append(data);
						categCheck_group.multiselect('rebuild');	
					}
				},
				error: function(data){
				}
			})
		});
		
		//------ADD MEMBERSHIP AJAX----------
		$('#membership_form').on('submit', function(e)
		{
			e.preventDefault();
			var form = $(this).serialize();
			var valid = $('#membership_form').validationEngine('validate');
			/* if (valid == true)
			{
				$('.modal').modal('hide');
			} */
			$.ajax(
			{
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
		
		//------ADD CLASS AJAX----------
		$('#class_form').on('submit', function(e) {
			e.preventDefault(); 
			var form = $(this).serialize();
			
			var categCheck_class = $('#classis_id').multiselect();	
			var categCheck_day = $('#day').multiselect();	
			var categCheck_class_membership = $('#class_membership_id').multiselect();	
			var valid = $('#class_form').validationEngine('validate');
			if (valid == true)
			{
				$('.modal').modal('hide');
			}
			$.ajax({
				type:"POST",
				url: $(this).attr('action'),
				data:form,
				success: function(data){
					if(data!=""){ 
						
						$('#class_form').trigger("reset");
						$('#classis_id').append(data);
						categCheck_class.multiselect('rebuild');	
						categCheck_day.multiselect('rebuild');	
						categCheck_class_membership.multiselect('rebuild');	
					}
				},
					error: function(data){
				}
			})
		});
	
    } );
</script>
<?php 	
if($active_tab == 'addmember')
{
  	$member_id=0;
	if(isset($_REQUEST['member_id']))
		$member_id=$_REQUEST['member_id'];
		$edit=0;
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{
			$edit=1;
			$user_info = get_userdata($member_id);
			if($user_info->gmgt_hash)
			{
				$lastmember_id=get_lastmember_id($role);
				$nodate=substr($lastmember_id,0,-4);
				$memberno=substr($nodate,1);
				$memberno+=1;
				$newmember='M'.$memberno.date("my");
			}
		}
		else
		{
		    $lastmember_id=get_lastmember_id($role);
			$nodate=substr($lastmember_id,0,-4);
			$memberno=substr($nodate,1);
			$memberno+=1;
			$newmember='M'.$memberno.date("my");
		}?>
        <div class="panel-body">
			<form name="member_form" action="" method="post" class="form-horizontal" id="member_form">
				<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
				<input type="hidden" name="action" value="<?php echo $action;?>">
				<input type="hidden" name="role" value="<?php echo $role;?>"  />
				<input type="hidden" name="user_id" value="<?php echo $member_id;?>"  />
				<input type="hidden" name="gmgt_hash" value="<?php if($edit){ if($user_info->gmgt_hash){ echo $user_info->gmgt_hash;}}?>"  />
				<div class="header">	
					<h3><?php _e('Personal Information','gym_mgt');?></h3>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="member_id"><?php _e('Member Id','gym_mgt');?></label>
					<div class="col-sm-8">
						<input id="member_id" class="form-control" type="text" 
						value="<?php if($edit){  echo $user_info->member_id;}else echo $newmember;?>"  readonly name="member_id">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="first_name"><?php _e('First Name','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
					<?php
					//echo "<pre>";
					// print_r($user_info->first_name);
					 ?>
						<input id="first_name" class="form-control validate[required,custom[onlyLetterSp]] text-input" maxlength="50" type="text" value="<?php 
                       

						if($edit){ echo $user_info->first_name;}elseif(isset($_POST['first_name'])) echo $_POST['first_name'];?>" name="first_name">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="middle_name"><?php _e('Middle Name','gym_mgt');?></label>
					<div class="col-sm-8">
						<input id="middle_name" class="form-control validate[custom[onlyLetterSp] " type="text" maxlength="50"  value="<?php if($edit){ echo $user_info->middle_name;}elseif(isset($_POST['middle_name'])) echo $_POST['middle_name'];?>" name="middle_name">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="last_name"><?php _e('Last Name','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="last_name" class="form-control validate[required,custom[onlyLetterSp]] text-input" maxlength="50" type="text"  value="<?php if($edit){ echo $user_info->last_name;}elseif(isset($_POST['last_name'])) echo $_POST['last_name'];?>" name="last_name">
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="gender"><?php _e('Gender','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
					<?php $genderval = "male"; if($edit){ $genderval=$user_info->gender; }elseif(isset($_POST['gender'])) {$genderval=$_POST['gender'];}?>
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
						<input id="birth_date" class="form-control validate[required] birth_date" type="text" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>" name="birth_date" 
						value="<?php if($edit){  echo getdate_in_input_box($user_info->birth_date);}elseif(isset($_POST['birth_date'])) echo getdate_in_input_box($_POST['birth_date']);?>">
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="group_id"><?php _e('Group','gym_mgt');?></label>
					<div class="col-sm-8">
						<?php 
						$joingroup_list = $obj_member->get_all_joingroup($member_id);
						$groups_array = $obj_member->convert_grouparray($joingroup_list);
						?>
						<?php if($edit){ $group_id=$user_info->group_id; }elseif(isset($_POST['group_id'])){$group_id=$_POST['group_id'];}else{$group_id='';}?>
						<select id="group_id"  name="group_id[]" multiple="multiple">
						
						<?php $groupdata=$obj_group->get_all_groups();
						 if(!empty($groupdata))
						 {
							foreach ($groupdata as $group){?>
								<option value="<?php echo $group->id;?>" <?php if(in_array($group->id,$groups_array)) echo 'selected';  ?>><?php echo $group->group_name; ?> </option>
					<?php } } ?>
					</select>
					<!--<a href="?page=gmgt_group&tab=addgroup" class="btn btn-default"> <?php _e('Add Group','gym_mgt');?></a>-->
					<a href="#" class="btn btn-default" data-toggle="modal" data-target="#myModal_add_group"> <?php _e('Add Group','gym_mgt');?></a>
					
					</div>
				</div>
				<div class="header">	<hr>
					<h3><?php _e('Contact Information','gym_mgt');?></h3>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="address"><?php _e('Address','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="address" class="form-control validate[required]" maxlength="150" type="text"  name="address" 
						value="<?php if($edit){ echo $user_info->address;}elseif(isset($_POST['address'])) echo $_POST['address'];?>">
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="city_name"><?php _e('City','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="city_name" class="form-control validate[required,custom[onlyLetterSp]]" maxlength="50" type="text"  name="city_name" 
						value="<?php if($edit){ echo $user_info->city_name;}elseif(isset($_POST['city_name'])) echo $_POST['city_name'];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="state_name"><?php _e('State','gym_mgt');?></label>
					<div class="col-sm-8">
						<input id="state_name" class="form-control validate[custom[onlyLetterSp]]" maxlength="50" type="text"  name="state_name" 
						value="<?php if($edit){ echo $user_info->state_name;}elseif(isset($_POST['state_name'])) echo $_POST['state_name'];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="zip_code"><?php _e('Zip Code','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="zip_code" class="form-control  validate[required,custom[onlyLetterNumber]]" maxlength="10" type="text"  name="zip_code" 
						value="<?php if($edit){ echo $user_info->zip_code;}elseif(isset($_POST['zip_code'])) echo $_POST['zip_code'];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label " for="mobile"><?php _e('Mobile Number','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-1">
					
					<input type="text" readonly value="+<?php echo gmgt_get_countery_phonecode(get_option( 'gmgt_contry' ));?>"  class="form-control" name="phonecode">
					</div>
					<div class="col-sm-7">
						<input id="mobile" class="form-control validate[required] text-input phone_validation"  type="text" minlength="10" name="mobile" maxlength="15"
						value="<?php if($edit){ echo $user_info->mobile;}elseif(isset($_POST['mobile'])) echo $_POST['mobile'];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label " for="phone"><?php _e('Phone','gym_mgt');?></label>
					<div class="col-sm-8">
						<input id="phone" class="form-control text-input phone_validation"  type="text" minlength="10" maxlength="15"  name="phone" 
						value="<?php if($edit){ echo $user_info->phone;}elseif(isset($_POST['phone'])) echo $_POST['phone'];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label " for="email"><?php _e('Email','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="email" class="form-control validate[required,custom[email]] text-input" maxlength="50" type="text"  name="email" 
						value="<?php if($edit){ echo $user_info->user_email;}elseif(isset($_POST['email'])) echo $_POST['email'];?>">
					</div>
				</div>
				<div class="header">	<hr>
					<h3><?php _e('Physical Information','gym_mgt');?></h3>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="weight"><?php _e('Weight','gym_mgt');?></label>
					<div class="col-sm-8">
						<input id="weight" class="form-control text-input decimal_number" maxlength="6" type="text" 
						palceholder = "Enter in centimeter"
						value="<?php if($edit){ echo $user_info->weight;}elseif(isset($_POST['weight'])) echo $_POST['weight'];?>" 
						name="weight" placeholder="<?php echo get_option( 'gmgt_weight_unit' );?>">
						
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="height"><?php _e('Height','gym_mgt');?></label>
					<div class="col-sm-8">
						<input id="height" class="form-control text-input decimal_number" type="text" maxlength="6" value="<?php if($edit){ echo $user_info->height;}elseif(isset($_POST['height'])) echo $_POST['height'];?>" 
						name="height" placeholder="<?php echo get_option( 'gmgt_height_unit' );?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="Chest"><?php _e('Chest','gym_mgt');?></label>
					<div class="col-sm-8">
						<input id="Chest" class="form-control text-input decimal_number" maxlength="6" type="text" 
						value="<?php if($edit){ echo $user_info->chest;}elseif(isset($_POST['chest'])) echo $_POST['chest'];?>" name="chest" 
						placeholder="<?php echo get_option( 'gmgt_chest_unit' );?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="Waist"><?php _e('Waist','gym_mgt');?></label>
					<div class="col-sm-8">
						<input id="waist" class="form-control text-input decimal_number" maxlength="6" type="text" 
						value="<?php if($edit){ echo $user_info->waist;}elseif(isset($_POST['waist'])) echo $_POST['waist'];?>" name="waist" 
						placeholder="<?php echo get_option( 'gmgt_waist_unit' );?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="thigh"><?php _e('Thigh','gym_mgt');?></label>
					<div class="col-sm-8">
						<input id="thigh" class="form-control text-input decimal_number" maxlength="6" type="text" 
						value="<?php if($edit){ echo $user_info->thigh;}elseif(isset($_POST['thigh'])) echo $_POST['thigh'];?>" name="thigh" 
						placeholder="<?php echo get_option( 'gmgt_thigh_unit' );?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="arms"><?php _e('Arms','gym_mgt');?></label>
					<div class="col-sm-8">
						<input id="arms" class="form-control text-input decimal_number" maxlength="6" type="text" 
						value="<?php if($edit){ echo $user_info->arms;}elseif(isset($_POST['arms'])) echo $_POST['arms'];?>" name="arms" 
						placeholder="<?php echo get_option( 'gmgt_arms_unit' );?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="fat"><?php _e('Fat','gym_mgt');?></label>
					<div class="col-sm-8">
						<input id="fat" class="form-control text-input decimal_number" maxlength="6" type="text" 
						value="<?php if($edit){ echo $user_info->fat;}elseif(isset($_POST['fat'])) echo $_POST['fat'];?>" name="fat" 
						placeholder="<?php echo get_option( 'gmgt_fat_unit' );?>">
					</div>
				</div>
				<div class="header">
					<hr>
					<h3><?php _e('Login Information','gym_mgt');?></h3>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="username"><?php _e('User Name','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="username" class="form-control validate[required] space_validation" type="text" maxlength="30"  name="username" 
						value="<?php if($edit){ echo $user_info->user_login;}elseif(isset($_POST['username'])) echo $_POST['username'];?>" <?php if($edit) echo "readonly";?>>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="password"><?php _e('Password','gym_mgt');?><?php if(!$edit) {?><span class="require-field">*</span><?php }?></label>
					<div class="col-sm-8">
						<input id="password" class="form-control space_validation <?php if(!$edit) echo 'validate[required]';?>" minlength="8" maxlength="12" type="password"  name="password" value="">
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="photo"><?php _e('Image','gym_mgt');?></label>
					<div class="col-sm-2">
						<input type="text" id="gmgt_user_avatar_url" class="form-control" name="gmgt_user_avatar"  
						value="<?php if($edit)echo esc_url( $user_info->gmgt_user_avatar );elseif(isset($_POST['gmgt_user_avatar'])) echo $_POST['gmgt_user_avatar']; ?>" />
					</div>	
						<div class="col-sm-3">
							 <input id="upload_user_avatar_button" type="button" class="button" value="<?php _e( 'Upload image', 'gym_mgt' ); ?>" />
							 <span class="description"><?php _e('Upload image', 'gym_mgt' ); ?></span>
					
					</div>
					<div class="clearfix"></div>
					
					<div class="col-sm-offset-2 col-sm-8">
						 <div id="upload_user_avatar_preview"  >
						 <?php if($edit) 
						  {
						  if($user_info->gmgt_user_avatar == ""){ ?>
									<img alt="" style="max-width:100%;" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">
									<?php }
									else {
										?>
									<img style="max-width:100%;"  src="<?php if($edit)echo esc_url( $user_info->gmgt_user_avatar ); ?>" />
									<?php 
									}
									}
									else {
										?>
										<img alt="" style="max-width:100%;" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">
										<?php 
									}?>
							</div>
				 </div>
				</div>
				<div class="header">	<hr>
					<h3><?php _e('More Information','gym_mgt');?></h3>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="refered"><?php _e('Member type','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<select name="member_type" class="form-control validate[required]" id="member_type">
							<option value=""><?php  _e('Select Member Type','gym_mgt');?></option>
							<?php if($edit)
									$mtype=$user_info->member_type;
								elseif(isset($_POST['member_type']))
									$mtype=$_POST['member_type'];
								else
									$mtype="";
								$membertype_array=member_type_array();
								if(!empty($membertype_array))
								{
									foreach($membertype_array as $key=>$type)
									{
										echo '<option value='.$key.' '.selected($mtype,$key).'>'.$type.'</option>';
									}
								} ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="staff_name"><?php _e('Select Staff Member','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<?php $get_staff = array('role' => 'Staff_member');
							$staffdata=get_users($get_staff);
						?>
						<select name="staff_id" class="form-control validate[required] " id="staff_id">
							<option value=""><?php  _e('Select Staff Member','gym_mgt');?></option>
							<?php if($edit)
									$staff_data=$user_info->staff_id;
								elseif(isset($_POST['staff_id']))
									$staff_data=$_POST['staff_id'];
								else
									$staff_data="";
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
					<!--<a href="?page=gmgt_staff&tab=add_staffmember" class="btn btn-default"> <?php _e('Add Staff Member','gym_mgt');?></a>-->
					<a href="#" class="btn btn-default" data-toggle="modal" data-target="#myModal_add_staff_member"> <?php _e('Add Staff Member','gym_mgt');?></a>
					
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="intrest"><?php _e('Interest Area','gym_mgt');?></label>
					<div class="col-sm-8">
						<select class="form-control" name="intrest_area" id="intrest_area">
							<option value=""><?php _e('Select Interest','gym_mgt');?></option>
						    <?php 
							
							if(isset($_REQUEST['intrest']))
								$category =$_REQUEST['intrest'];  
							elseif($edit)
								$category =$user_info->intrest_area;
							else 
								$category = "";
							
							$role_type=gmgt_get_all_category('intrest_area');
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
					<div class="col-sm-2"><button id="addremove" model="intrest_area"><?php _e('Add Or Remove','gym_mgt');?></button></div>
				</div>
				<?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){?>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="member_convert"><?php  _e(' Convert into Staff Member','gym_mgt');?></label>
						<div class="col-sm-8">
						<input type="checkbox"  name="member_convert" value="staff_member">
						</div>
				</div>
				<?php }?>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="Source"><?php _e('Referral Source','gym_mgt');?></label>
					<div class="col-sm-8">
						<select class="form-control" name="source" id="source">
							<option value=""><?php _e('Select Referral Source','gym_mgt');?></option>
							<?php 
							
							if(isset($_REQUEST['source']))
								$category =$_REQUEST['source'];  
							elseif($edit)
								$category =$user_info->source;
							else 
								$category = "";
							
							$role_type=gmgt_get_all_category('source');
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
					<div class="col-sm-2"><button id="addremove" model="source"><?php _e('Add Or Remove','gym_mgt');?></button></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="refered"><?php _e('Referred By','gym_mgt');?></label>
					<div class="col-sm-8">
						<?php //$get_staff = array('role' => 'Staff_member');
							//$staffdata=get_users($get_staff);
							$staffdata=get_users([ 'role__in' => ['Staff_member', 'member']]);
						?>
						<select name="reference_id" class="form-control" id="reference_id">
							<option value=""><?php  _e('Select Referred Member','gym_mgt');?></option>
							<?php if($edit)
									$staff_data=$user_info->reference_id;
								elseif(isset($_POST['reference_id']))
									$staff_data=$_POST['reference_id'];
								else
									$staff_data="";					
								
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
					<!--<a href="?page=gmgt_staff&tab=add_staffmember" class="btn btn-default"> <?php _e('Add Staff Member','gym_mgt');?></a>-->
					<a href="#" class="btn btn-default" data-toggle="modal" data-target="#myModal_add_staff_member"> <?php _e('Add Staff Member','gym_mgt');?></a>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="inqiury_date"><?php _e('Inquiry Date','gym_mgt');?></label>
					<div class="col-sm-8">
						<input id="inqiury_date" class="form-control" type="text" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>"  name="inqiury_date" 
						value="<?php if($edit){ if($user_info->inqiury_date!=""){ echo getdate_in_input_box($user_info->inqiury_date); } }elseif(isset($_POST['inqiury_date'])){ echo $_POST['inqiury_date']; }?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="triel_date"><?php _e('Trial End Date','gym_mgt');?></label>
					<div class="col-sm-8">
						<input id="triel_date" class="form-control" type="text" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>" name="triel_date" 
						value="<?php if($edit){ if($user_info->triel_date!=""){ echo getdate_in_input_box($user_info->triel_date); } }elseif(isset($_POST['triel_date'])){ echo $_POST['triel_date']; }?>">
					</div>
				</div>
				<div id="non_prospect_area">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="membership"><?php _e('Membership','gym_mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-8">
							<?php 	$membershipdata=$obj_membership->get_all_membership(); ?>
							<select name="membership_id" class="form-control validate[required] " id="membership_id">	
								<option value=""><?php  _e('Select Membership','gym_mgt');?></option>
								<?php 
									$staff_data=$user_info->membership_id;
									if(!empty($membershipdata))
									{
										foreach ($membershipdata as $membership)
										{						
											echo '<option value='.$membership->membership_id.' '.selected($staff_data,$membership->membership_id).'>'.$membership->membership_label.'</option>';
										}
									}
									?>
							</select>
						</div>
						<div class="col-sm-2">
						<!--<a href="?page=gmgt_membership_type&tab=addmembership" class="btn btn-default"> <?php _e('Add Membership','gym_mgt');?></a>-->
						<a href="#" class="btn btn-default" data-toggle="modal" id="add_membership_btn" data-target="#myModal_add_membership"> <?php _e('Add Membership','gym_mgt');?></a>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="class_id"><?php _e('Class','gym_mgt');?><span class="require-field">*</span></label>			
						<div class="col-sm-8 multiselect_validation_member">				
							<!--<?php if($edit){ $class_id=$user_info->class_id; }elseif(isset($_POST['class_id'])){$class_id=$_POST['class_id'];}else{$class_id='';}?>-->
							<select id="classis_id" class="form-control validate[required] classis_ids" multiple="multiple" name="class_id[]">
									<?php 
									if($edit)					
									{					
										$MemberShipClass = get_class_id_by_membership_id($user_info->membership_id);
										$userclass  = get_current_user_classis($member_id);
										
										foreach($MemberShipClass as $key=>$class_id)
										{ ?>
											<option value="<?php echo $class_id ;?>" <?php if(in_array($class_id,$userclass)){ print "Selected"; }  ?>><?php echo gmgt_get_class_name($class_id); ?> </option>
									<?php }
									}
									?>
									
								<!--<?php $classdata=$obj_class->get_all_classes();
								 if(!empty($classdata))
								 {
									foreach ($classdata as $class){?>
										<option value="<?php echo $class->class_id;?>" <?php selected($class_id,$class->class_id);  ?>><?php echo $class->class_name; ?> </option>
							<?php } } ?>-->
							
							</select>
						</div>
						<div class="col-sm-2">
						<!--<a href="?page=gmgt_class&tab=addclass" class="btn btn-default"> <?php _e('Add Class','gym_mgt');?></a>-->
						<a href="#" class="btn btn-default" data-toggle="modal" data-target="#myModal_add_class"> <?php _e('Add Class','gym_mgt');?></a>
						</div>
					</div>
					<?php if($edit)
					{ ?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="membership_status"><?php _e('Membership Status','gym_mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-8">
						<?php $membership_statusval = "Continue"; if($edit){ $membership_statusval=$user_info->membership_status; }elseif(isset($_POST['membership_status'])) {$membership_statusval=$_POST['membership_status'];}?>
							<label class="radio-inline">
							 <input type="radio" value="Continue" class="tog validate[required]" name="membership_status"  <?php  checked( 'Continue', $membership_statusval);  ?>/><?php _e('Continue','gym_mgt');?>
							</label>
							<label class="radio-inline">
							 <input type="radio" value="Expired" class="tog validate[required]" name="membership_status"  <?php  checked( 'Expired', $membership_statusval);  ?>/><?php _e('Expired','gym_mgt');?>
							</label>
							<label class="radio-inline">
							  <input type="radio" value="Dropped" class="tog validate[required]" name="membership_status"  <?php  checked( 'Dropped', $membership_statusval);  ?>/><?php _e('Dropped','gym_mgt');?> 
							</label>
						</div>
					</div>
					<?php } ?>
				<!--
				<div class="form-group">
					<label class="col-sm-2 control-label" for="auto-renew"><?php _e('Auto Renew','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
					<?php $auto_renewval = "No"; if($edit){ $auto_renewval=$user_info->auto_renew; }elseif(isset($_POST['auto_renew'])) {$auto_renewval=$_POST['auto_renew'];}?>
						<label class="radio-inline">
						 <input type="radio" value="Yes" class="tog validate[required]" name="auto_renew"  <?php  checked( 'Yes', $auto_renewval);  ?>/><?php _e('Yes','gym_mgt');?>
						</label>
						<label class="radio-inline">
						  <input type="radio" value="No" class="tog validate[required]" name="auto_renew"  <?php  checked( 'No', $auto_renewval);  ?>/><?php _e('No','gym_mgt');?> 
						</label>
					</div>
				</div>
				-->
					<input type="hidden" name="auto_renew" value="No">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="begin_date"><?php _e('Membership Valid From','gym_mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-3">
							<input id="begin_date" class="form-control validate[required] begin_date" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>" type="text"  name="begin_date" 
							value="<?php if($edit){ if($user_info->begin_date!=""){ echo getdate_in_input_box($user_info->begin_date); } }elseif(isset($_POST['begin_date'])) echo $_POST['begin_date'];?>">
						</div>
						<div class="col-sm-1 text-center">
							<?php _e('To','gym_mgt');?>
						</div>
						<div class="col-sm-4">
							<input id="end_date" class="form-control validate[required]" type="text"  name="end_date" 
							value="<?php
							if($edit){ 
							if($user_info->end_date!=""){
							echo getdate_in_input_box($user_info->end_date); }
							}
							elseif(isset($_POST['end_date'])) echo $_POST['end_date'];?>" readonly>
						</div>
					</div>
				</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="first_payment_date"><?php _e('First Payment Date','gym_mgt');?></label>
						<div class="col-sm-8">
							<input id="first_payment_date" class="form-control" type="text" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>"  name="first_payment_date" 
							value="<?php if($edit){ if($user_info->first_payment_date!=""){ echo getdate_in_input_box($user_info->first_payment_date); } }elseif(isset($_POST['first_payment_date'])){ echo $_POST['first_payment_date']; }?>">
						</div>
					</div>
					<div id="no_of_class"></div>
					<div class="col-sm-offset-2 col-sm-8">        	
						<input type="submit" value="<?php if($edit){ _e('Save','gym_mgt'); }else{ _e('Save Member','gym_mgt');}?>" name="save_member" class="btn btn-success class_submit "/>
					</div>
			</form>
		</div>
<?php 
}
?>
	 <!----------ADD STAFF MEMBER------------->
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
						<input type="hidden" name="user_id" value=""/>
						<div class="header">	
							<h4><?php _e('Personal Information','gym_mgt');?></h4>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="first_name"><?php _e('First Name','gym_mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-8">
								<input id="first_name" class="form-control validate[required,custom[onlyLetterSp]] text-input" maxlength="50" type="text" value="" name="first_name">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="middle_name"><?php _e('Middle Name','gym_mgt');?></label>
							<div class="col-sm-8">
								<input id="middle_name" class="form-control " type="text"  value="" name="middle_name">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="last_name"><?php _e('Last Name','gym_mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-8">
								<input id="last_name" class="form-control validate[required,custom[onlyLetterSp]] text-input" maxlength="50" type="text"  value="" name="last_name">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="gender"><?php _e('Gender','gym_mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-8">
							<?php $genderval = "male"; ?>
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
								<input id="staff_birth_date" class="form-control validate[required] birth_date" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>" type="text"  name="birth_date" 
								value="">
							</div>
						</div>	
						<div class="form-group">
							<label class="col-sm-2 control-label" for="role_type"><?php _e('Assign Role','gym_mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-8">
							
								<select class="form-control" name="role_type" id="role_type">
								<option value=""><?php _e('Select Role','gym_mgt');?></option>
								<?php 
								
								if(isset($_REQUEST['role_type']))
									$category =$_REQUEST['role_type'];  
								elseif($edit)
									$category =$user_info->role_type;
								else 
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
							<div class="col-sm-8 multiselect_validation_staff">
							
								<select class="form-control" name="specialization[]" id="specialization" multiple="multiple">
								<?php 
								
								if(isset($_REQUEST['specialization']))
									$category =$_REQUEST['specialization'];  
								else 
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
								<button id="addremove" class="add_specialize_btn" model="specialization"><?php _e('Add Or Remove','gym_mgt');?></button>
							</div>	
							
						</div>
						
						<div class="header">	<hr>
							<h4><?php _e('Contact Information','gym_mgt');?></h4>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="address"><?php _e('Home Town Address','gym_mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-8">
								<input id="address" class="form-control validate[required]" maxlength="150" type="text"  name="address" 
								value="<?php if(isset($_POST['address'])) echo $_POST['address'];?>">
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
							<label class="col-sm-2 control-label" for="state_name"><?php _e('State','gym_mgt');?></label>
							<div class="col-sm-8">
								<input id="state_name" class="form-control validate[onlyLetterSp]" type="text" maxlength="50"  name="state_name" 
								value="">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="zip_code"><?php _e('Zip Code','gym_mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-8">
								<input id="zip_code" class="form-control  validate[required,custom[onlyLetterNumber]]" type="text" maxlength="10" name="zip_code" 
								value="">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label " for="mobile"><?php _e('Mobile Number','gym_mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-1">
							
							<input type="text" readonly value="+<?php echo gmgt_get_countery_phonecode(get_option( 'gmgt_contry' ));?>"  class="form-control" name="phonecode">
							</div>
							<div class="col-sm-7">
								<input id="mobile" class="form-control validate[required] phone_validation text-input" type="text" minlength="10"  name="mobile" maxlength="15"
								value="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label " for="phone"><?php _e('Phone','gym_mgt');?></label>
							<div class="col-sm-8">
								<input id="phone" class="form-control phone_validation text-input" minlength="10" maxlength="15" type="text"  name="phone" 
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
								<input id="username" class="form-control validate[required] space_validation" maxlength="30" type="text"  name="username" 
								value="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="password"><?php _e('Password','gym_mgt');?><?php if(!$edit) {?><span class="require-field">*</span><?php }?></label>
							<div class="col-sm-8">
								<input id="password" class="form-control validate[required] space_validation" type="password" min_length="8" maxlength="12"  name="password" value="">
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
							<input type="submit" value="<?php  _e('Add Staff','gym_mgt');?>" name="save_staff" id="add_staff_member" class="btn btn-success specialization_submit"/>
						</div>
					</form>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
                </div>
            </div>
        </div>
  <!----------ADD GORUP POPUP------------->
    <div class="modal fade" id="myModal_add_group" role="dialog" style="overflow:scroll;">
        <div class="modal-dialog modal-lg">
		    <div class="modal-content">
			    <div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <h3 class="modal-title"><?php _e('Add Group','gym_mgt');?></h3>
				</div>
				<div class="modal-body">
				<form name="group_form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="form-horizontal" id="group_form">
						<input type="hidden" name="action" value="gmgt_add_group">
						<input type="hidden" name="group_id" value=""  />
						<div class="form-group">
							<label class="col-sm-2 control-label" for="group_name"><?php _e('Group Name','gym_mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-8">
								<input id="group_name" class="form-control validate[required,custom[onlyLetterSp]] text-input" maxlength="50" type="text" value="<?php if(isset($_POST['group_name'])) echo $_POST['group_name'];?>" name="group_name">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="gmgt_membershipimage"><?php _e('Group Image','gym_mgt');?></label>
							<div class="col-sm-8">
								<input type="text" id="gmgt_gym_background_image" name="gmgt_groupimage" value="<?php if(isset($_POST['gmgt_groupimage'])) echo $_POST['gmgt_groupimage'];?>" />	
								<input id="upload_image_button" type="button" class="button upload_user_cover_button" value="<?php _e( 'Upload Cover Image', 'gym_mgt' ); ?>" />
								<span class="description"><?php _e('Upload Group Image', 'gym_mgt' ); ?></span>
								<div id="upload_gym_cover_preview" style="min-height: 100px;">
								<img style="max-width:100%;" src="<?php if(isset($_POST['gmgt_groupimage'])) echo $_POST['gmgt_groupimage']; else echo get_option( 'gmgt_system_logo' );?>" />
								</div>
							</div>
						</div>
						<div class="col-sm-offset-2 col-sm-8">
							<input type="submit" value="<?php if($edit){ _e('Save','gym_mgt'); }else{ _e('Save','gym_mgt');}?>" name="save_group" class="btn btn-success"/>
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
								<input id="membership_name" class="form-control validate[required,custom[onlyLetterSp]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo $result->membership_label;}elseif(isset($_POST['membership_name'])) echo $_POST['membership_name'];?>" name="membership_name">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="membership_category"><?php _e('Membership Category','gym_mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-8">			
								<select class="form-control" name="membership_category" id="membership_category">
								<option value=""><?php _e('Select Membership Category','gym_mgt');?></option>
								<?php 				
								if(isset($_REQUEST['membership_category']))
									$category =$_REQUEST['membership_category'];  
								else 
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
								
								if(isset($_REQUEST['membership_period']))
									$category =$_REQUEST['membership_period'];  
								else 
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
								<input id="membership_period" class="form-control validate[required,custom[number]] text-input" type="number" onKeyPress="if(this.value.length==3) return false;" value="<?php if(isset($_POST['membership_period'])) echo $_POST['membership_period'];?>" name="membership_period" placeholder="<?php _e('Enter Total Number of Days','gym_mgt');?>">
							
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="member_limit"><?php _e('Members Limit','gym_mgt');?></label>
							<div class="col-sm-8">
							<?php $limitval = "unlimited"; if(isset($_POST['gender'])) {$limitval=$_POST['gender'];}?>
								<label class="radio-inline">
								 <input type="radio" value="limited" class="tog" name="member_limit"  <?php  checked( 'limited', $limitval);  ?>/><?php _e('limited','gym_mgt');?>
								</label>
								<label class="radio-inline">
								  <input type="radio" value="unlimited" class="tog" name="member_limit"  <?php  checked( 'unlimited', $limitval);  ?>/><?php _e('unlimited','gym_mgt');?> 
								</label>
							</div>
						</div>
						
						<?php if($edit)
						{
								if($result->membership_class_limit!='unlimited')
								{ ?>
										<div id="on_of_member_box">
									<div class="form-group ">
									<label class="col-sm-2 control-label" for="on_of_member"><?php _e('No Of Member','gym_mgt');?></label>
									<div class="col-sm-8">
										<input id="on_of_member" class="form-control  text-input" type="text" value="<?php print $result->on_of_member ?>" name="on_of_member">
									</div>
									</div>				
								</div>
								<?php } ?>
						<?php 			
						} 		
						?>
						<div id="member_limit"></div>		
						<div class="form-group">
							<label class="col-sm-2 control-label" for="classis_limit"><?php _e('Classic Limit','gym_mgt');?></label>
							<div class="col-sm-8">
							<?php $limitvals = "unlimited"; if(isset($_POST['gender'])) {$limitvals=$_POST['gender'];}?>
								<label class="radio-inline">
								 <input type="radio" value="limited" class="classis_limit" name="classis_limit"  <?php  checked( 'limited', $limitvals);  ?>/><?php _e('limited','gym_mgt');?>
								</label>
								<label class="radio-inline">
								  <input type="radio" value="unlimited" class="classis_limit validate[required]" name="classis_limit"  <?php  checked( 'unlimited', $limitvals);  ?>/><?php _e('unlimited','gym_mgt');?> 
								</label>
							</div>
						</div>
						<div id="classis_limit"></div>	
						<?php
						if($edit)
						{ 
							if($result->classis_limit!='unlimited')
							{ 
						?>
							   <div id="on_of_classis_box">
									<div class="form-group ">
									<label class="col-sm-2 control-label" for="on_of_classis"><?php _e('No Of Classis','gym_mgt');?></label>
									<div class="col-sm-8">
										<input id="on_of_classis" class="form-control  text-input" type="text" value="<?php print $result->on_of_classis ?>" name="on_of_classis">
									</div>
									</div>				
								</div>
					  <?php } 
						} 
						?>
					
						<div class="form-group">
							<label class="col-sm-2 control-label" for="installment_amount"><?php _e('Membership Amount','gym_mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-8">
								<input id="membership_amount" class="form-control validate[required] text-input" type="number" min="0" onkeypress="if(this.value.length==6) return false;" value="<?php if(isset($_POST['membership_amount'])) echo $_POST['membership_amount'];?>" name="membership_amount">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="installment_plan"><?php _e('Installment Plan','gym_mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-2">
								<input id="installment_amount" class="form-control validate[required] text-input" min="0"  onkeypress="if(this.value.length==6) return false;" type="number" value="<?php if(isset($_POST['installment_amount'])) echo $_POST['installment_amount'];?>" name="installment_amount" placeholder="Amount">
							</div>
							<div class="col-sm-6">
							
								<select class="form-control" name="installment_plan" id="installment_plan">
								<option value=""><?php _e('Select Installment Plan','gym_mgt');?></option>
								<?php 
								
								if(isset($_REQUEST['installment_plan']))
									$category =$_REQUEST['installment_plan'];  
								else 
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
								<input id="signup_fee" class="form-control text-input" type="number" min="0" onkeypress="if(this.value.length==6) return false;" value="<?php if(isset($_POST['membership_name'])) echo $_POST['membership_name'];?>" name="signup_fee">
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
								value="<?php if(isset($_POST['gmgt_membershipimage'])) echo $_POST['gmgt_membershipimage'];?>" />	
								 <input id="upload_image_button1" type="button" class="button upload_user_avatar_button" value="<?php _e( 'Upload Cover Image', 'gym_mgt' ); ?>" />
								 <span class="description"><?php _e('Upload Membership Image', 'gym_mgt' ); ?></span>
								<div class="upload_user_avatar_preview" id="upload_user_avatar_preview1" style="min-height: 100px;">
									<img style="max-width:100%;" src="<?php if(isset($_POST['gmgt_membershipimage'])) echo $_POST['gmgt_membershipimage']; else echo get_option( 'gmgt_system_logo' );?>" />
								</div>
							</div>
						</div>
						<div class="col-sm-offset-2 col-sm-8">
							<input type="submit" value="<?php if($edit){ _e('Save Membership','gym_mgt'); }else{ _e('Add Membership','gym_mgt');}?>" name="save_membership" class="btn btn-success"/>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>	
	 <!----------ADD CLASS POPUP------------->
    <div class="modal fade" id="myModal_add_class" role="dialog" style="overflow:scroll;">
        <div class="modal-dialog modal-lg">
		    <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <h3 class="modal-title"><?php _e('Add Class','gym_mgt');?></h3>
				</div>
				<div class="modal-body">
				    <form name="class_form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="form-horizontal" id="class_form">
						<input type="hidden" name="action" value="gmgt_add_ajax_class">
						<input type="hidden" name="class_id" value=""  />
						<div class="form-group">
							<label class="col-sm-2 control-label" for="class_name"><?php _e('Class Name','gym_mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-8">
								<input id="class_name" class="form-control validate text-input onlyletter_number_space_validation" maxlength="50" type="text" value="<?php if(isset($_POST['class_name'])) echo $_POST['class_name'];?>" name="class_name">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="staff_name"><?php _e('Select Staff Member','gym_mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-8">
								<?php $get_staff = array('role' => 'Staff_member');
									$staffdata=get_users($get_staff);?>
								<select name="staff_id" class="form-control validate[required] " id="staff_id">
								<option value=""><?php  _e('Select Staff Member ','gym_mgt');?></option>
								<?php 
									if($edit)
										$staff_data=$result->staff_id;
									elseif(isset($_POST['staff_id']))
										$staff_data=$_POST['staff_id'];
									else
										$staff_data="";
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
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="middle_name"><?php _e('Select Assistant Staff Member','gym_mgt');?></label>
							<div class="col-sm-8">
								<?php $get_staff = array('role' => 'Staff_member');
									$staffdata=get_users($get_staff);?>
								<select name="asst_staff_id" class="form-control" id="asst_staff_id">
								<option value=""><?php  _e('Select Assistant Staff Member ','gym_mgt');?></option>
								<?php if(isset($_POST['asst_staff_id']))
										$assi_staff_data=$_POST['asst_staff_id'];
									else
										$assi_staff_data="";
									
									if(!empty($staffdata))
									{
										foreach($staffdata as $staff)
										{
											
											echo '<option value='.$staff->ID.' '.selected($assi_staff_data,$staff->ID).'>'.$staff->display_name.'</option>';
										}
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="day"><?php _e('Select Day','gym_mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-8 day_validation_member">			
								<select name="day[]" class="form-control validate[required]" id="day" multiple="multiple">
								<!--<option value=""><?php  _e('Select Day ','gym_mgt');?></option>-->
								<?php $class_days=array();
									foreach(days_array() as $key=>$day)
									{
										$selected = "";
										if(in_array($key,$class_days))
											$selected = "selected";
										echo '<option value='.$key.' '.$selected.'>'.$day.'</option>';
									}?>					
								</select>
							</div>			
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="day"><?php _e('Membership','gym_mgt');?></label>
							<div class="col-sm-8">
								<?php 
									$membersdata=array();
									$data=array();
								?>
								<?php $membershipdata=$obj_membership->get_all_membership();?>
								<select name="membership_id[]" class="form-control" multiple="multiple" id="class_membership_id">	
									<?php 					
									if(!empty($membershipdata))
									{
										foreach ($membershipdata as $membership)
										{
											$selected = "";
											if(in_array($membership->membership_id,$data))
												$selected="selected";
										
											echo '<option value='.$membership->membership_id .' '.$selected.' >'.$membership->membership_label.'</option>';
											
										}
									}
									?>
								</select>
							</div>			
						</div>		
						<div class="form-group">
							<label class="col-sm-2 control-label" for="starttime"><?php _e('Start Time','gym_mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-2">
							
								 <select name="start_time" class="form-control validate[required]">
								 <option value=""><?php _e('Select Time','gym_mgt');?></option>
										 <?php 
											for($i =0 ; $i <= 12 ; $i++)
											{
											?>
											<option value="<?php echo $i;?>"><?php echo $i;?></option>
											<?php
											}
										 ?>
										 </select>
							</div>
							<div class="col-sm-2">
								<select name="start_min" class="form-control validate[required]">
										 <?php 
											foreach(minute_array() as $key=>$value)
											{?>
											<option value="<?php echo $key;?>" ><?php echo $value;?></option>
											<?php
											}
										 ?>
								</select>
							</div>
							<div class="col-sm-2">
								<select name="start_ampm" class="form-control validate[required]">
									<option value="am"><?php _e('am','gym_mgt');?></option>
									<option value="pm"><?php _e('pm','gym_mgt');?></option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="weekday"><?php _e('End Time','gym_mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-2">
								<select name="end_time" class="form-control validate[required]">
									 <option value=""><?php _e('Select Time','gym_mgt');?></option>
											 <?php 
												for($i =0 ; $i <= 12 ; $i++)
												{
												?>
												<option value="<?php echo $i;?>"><?php echo $i;?></option>
												<?php
												}
											 ?>
								</select>
							</div>
							<div class="col-sm-2">
								<select name="end_min" class="form-control validate[required]">
									<?php 
										foreach(minute_array() as $key=>$value)
										{
										?>
										<option value="<?php echo $key;?>"><?php echo $value;?></option>
										<?php
										}
									 ?>
								</select>
							</div>
							<div class="col-sm-2">
								<select name="end_ampm" class="form-control validate[required]">
									<option value="am"><?php _e('am','gym_mgt');?></option>
									<option value="pm"><?php _e('pm','gym_mgt');?></option>
								</select>
							</div>	
						</div>
						<div class="col-sm-offset-2 col-sm-8">
							<input type="submit" value="<?php _e('Save','gym_mgt');?>" name="save_class" class="btn btn-success day_validation_submit"/>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>	