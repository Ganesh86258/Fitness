<?php ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#group_form').validationEngine();
	$('#add_staff_form').validationEngine();
	$('#day').multiselect({
	nonSelectedText :'Select Day',
	includeSelectAllOption: true
	 });
	$('#specialization').multiselect({
	nonSelectedText :'Select Specialization',
	includeSelectAllOption: true
	 });
	 
	$('#membership_id').multiselect({
	nonSelectedText :'Select Membership',
	includeSelectAllOption: true
	 });
	
	 $(".day_validation_submit").click(function()
		 {	
		  checked = $(".day_validation .dropdown-menu input:checked").length;
			if(!checked)
			{
			  alert("Please select Atleast One Day");
			  return false;
			}	  
		}); 
		
		$(".day_validation_submit").click(function()
		 {	
		  checked = $(".multiselect_validation_membership .dropdown-menu input:checked").length;
			if(!checked)
			{
			  alert("Please select Atleast One membership");
			  return false;
			}	  
		}); 
		
		 $(".specialization_submit").click(function()
		 {	
		  checked = $(".multiselect_validation_specialization .dropdown-menu input:checked").length;
		if(!checked)
		{
		  alert("Please Select Atleast one specialization");
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
		if (valid == true) {
			$('.modal').modal('hide');
		}
		$.ajax({
			type:"POST",
			url: $(this).attr('action'),
			data:form,
			success: function(data){
								
				if(data!=""){ 
					$('#add_staff_form').trigger("reset");
					$('#staff_id').append(data);
				}
				
			},
			error: function(data){

			}
		})
	});
} );
</script>
     <?php 	
	if($active_tab == 'addclass')
	 {
        	
        	$class_id=0;
			if(isset($_REQUEST['class_id']))
				$class_id=$_REQUEST['class_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
					
					$edit=1;
					$result = $obj_class->get_single_class($class_id);
					
				//	var_dump($membersdata);
				
				}?>
		
       <div class="panel-body">
        <form name="group_form" action="" method="post" class="form-horizontal" id="group_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="class_id" value="<?php echo $class_id;?>"  />
		<div class="form-group">
			<label class="col-sm-2 control-label" for="class_name"><?php _e('Class Name','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="group_name" class="form-control validate[required,custom[onlyLetterSp]]  text-input" type="text" maxlength="50" value="<?php if($edit){ echo $result->class_name;}elseif(isset($_POST['class_name'])) echo $_POST['class_name'];?>" name="class_name">
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
						$role_title="";
						$postdata=get_post($staff->role_type);
						if(isset($postdata))
							$role_title=$postdata->post_title;
						
						echo '<option value='.$staff->ID.' '.selected($staff_data,$staff->ID).'>'.$staff->display_name.' ('.$role_title.') </option>';
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
			<label class="col-sm-2 control-label" for="middle_name"><?php _e('Select Assistant Staff Member','gym_mgt');?></label>
			<div class="col-sm-8">
				<?php $get_staff = array('role' => 'Staff_member');
					$staffdata=get_users($get_staff);?>
				<select name="asst_staff_id" class="form-control" id="asst_staff_id">
				<option value=""><?php  _e('Select Assistant Staff Member ','gym_mgt');?></option>
				<?php if($edit)
						$assi_staff_data=$result->asst_staff_id;
					elseif(isset($_POST['asst_staff_id']))
						$assi_staff_data=$_POST['asst_staff_id'];
					else
						$assi_staff_data="";
					
					if(!empty($staffdata))
					{
						foreach($staffdata as $staff)
						{
							$role_title="";
							$postdata=get_post($staff->role_type);
							if(isset($postdata))
								$role_title=$postdata->post_title;
							echo '<option value='.$staff->ID.' '.selected($assi_staff_data,$staff->ID).'>'.$staff->display_name.' ('.$role_title.')</option>';
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
		 
		<div class="form-group day_validation">
			<label class="col-sm-2 control-label" for="day"><?php _e('Select Day','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8 multiselect_validation" >			
				<select name="day[]" class="form-control validate[required] " id="day" multiple="multiple">
				<!--<option value=""><?php  _e('Select Day ','gym_mgt');?></option>-->
				<?php $class_days=array();
				if($edit){$class_days=json_decode($result->day);}
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
			<label class="col-sm-2 control-label" for="day"><?php _e('Membership','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8 multiselect_validation_membership">
			<?php 
				$membersdata=array();
				$data=array();
				if($edit){
					$membersdata = $obj_class->get_class_members($class_id);
					foreach($membersdata as $key=>$val)
					{
						$data[]= $val->membership_id;
					}
				} 
				
			?>
			<?php $membershipdata=$obj_membership->get_all_membership();?>
			<select name="membership_id[]" class="form-control" multiple="multiple" id="membership_id">	
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
			<?php 
			if($edit)
			{
				$start_time_data = explode(":", $result->start_time);
				
			}
			?>
				 <select name="start_time" class="form-control validate[required]">
				 <option value=""><?php _e('Select Time','gym_mgt');?></option>
                         <?php 
						 	for($i =0 ; $i <= 12 ; $i++)
							{
							?>
							<option value="<?php echo $i;?>" <?php  if($edit) selected($start_time_data[0],$i);  ?>><?php echo $i;?></option>
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
							<option value="<?php echo $key;?>" <?php  if($edit) selected($start_time_data[1],$key);  ?>><?php echo $value;?></option>
							<?php
							}
						 ?>
                         </select>
			</div>
			<div class="col-sm-2">
				 <select name="start_ampm" class="form-control validate[required]">
                         	<option value="am" <?php  if($edit) if(isset($start_time_data[2])) selected($start_time_data[2],'am');  ?>><?php _e('am','gym_mgt');?></option>
                            <option value="pm" <?php  if($edit) if(isset($start_time_data[2])) selected($start_time_data[2],'pm');  ?>><?php _e('pm','gym_mgt');?></option>
                         </select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="weekday"><?php _e('End Time','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-2">
			<?php 
			if($edit)
			{
				$end_time_data = explode(":", $result->end_time);
			}
			?>
				 <select name="end_time" class="form-control validate[required]">
				 <option value=""><?php _e('Select Time','gym_mgt');?></option>
                         <?php 
						 	for($i =0 ; $i <= 12 ; $i++)
							{
							?>
							<option value="<?php echo $i;?>" <?php  if($edit) selected($end_time_data[0],$i);  ?>><?php echo $i;?></option>
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
							<option value="<?php echo $key;?>" <?php  if($edit) selected($end_time_data[1],$key);  ?>><?php echo $value;?></option>
							<?php
							}
						 ?>
                         </select>
			</div>
			<div class="col-sm-2">
				<select name="end_ampm" class="form-control validate[required]">
					<option value="<?php _e('am','gym_mgt');?>" <?php  if($edit) if(isset($end_time_data[2])) selected($end_time_data[2], _e('am','gym_mgt'));  ?> ><?php _e('am','gym_mgt');?></option>
					<option value="<?php _e('pm','gym_mgt');?>" <?php  if($edit) if(isset($end_time_data[2]))selected($end_time_data[2], _e('pm','gym_mgt'));  ?>><?php _e('pm','gym_mgt');?></option>
			   </select>
			</div>	
		</div>
		
		<div class="col-sm-offset-2 col-sm-8">
        	
        	<input type="submit" value="<?php if($edit){ _e('Save','gym_mgt'); }else{ _e('Save','gym_mgt');}?>" name="save_class" class="btn btn-success day_validation_submit"/>
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
        <div class="modal-body">
           <form name="staff_form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="form-horizontal" id="add_staff_form" enctype="multipart/form-data">	
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="gmgt_add_staff_member">
		<input type="hidden" name="role" value="staff_member"  />
		<input type="hidden" name="user_id" value="<?php echo $staff_member_id;?>"  />
		<div class="header">	
			<h4><?php _e('Personal Information','gym_mgt');?></h4>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="first_name"><?php _e('First Name','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="first_name" class="form-control validate[required,custom[onlyLetterSp]] text-input"  maxlength="50" type="text" value="<?php if($edit){ echo $user_info->first_name;}elseif(isset($_POST['first_name'])) echo $_POST['first_name'];?>" name="first_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="middle_name"><?php _e('Middle Name','gym_mgt');?></label>
			<div class="col-sm-8">
				<input id="middle_name" class="form-control validate[custom[onlyLetterSp]] text-input"  maxlength="50" type="text"  value="<?php if($edit){ echo $user_info->middle_name;}elseif(isset($_POST['middle_name'])) echo $_POST['middle_name'];?>" name="middle_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="last_name"><?php _e('Last Name','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="last_name" class="form-control validate[custom[onlyLetterSp]] text-input"  maxlength="50" text-input" type="text"  value="<?php if($edit){ echo $user_info->last_name;}elseif(isset($_POST['last_name'])) echo $_POST['last_name'];?>" name="last_name">
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
				<input  class="form-control validate[required] birth_date" type="text" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>"  name="birth_date" 
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
			<div class="col-sm-8 multiselect_validation_specialization">
			
				<select class="form-control" name="specialization[]" id="specialization" multiple="multiple">
				<?php 
				
				if($edit)
					$category =json_decode($user_info->specialization);
				elseif(isset($_REQUEST['specialization']))
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
				<button id="addremove" model="specialization"><?php _e('Add Or Remove','gym_mgt');?></button>
			</div>	
			
		</div>
		
		<div class="header">	<hr>
			<h4><?php _e('Contact Information','gym_mgt');?></h4>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="address"><?php _e('Home Town Address','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="address" class="form-control validate[required] text-input" type="text" maxlength="150"  name="address" 
				value="<?php if($edit){ echo $user_info->address;}elseif(isset($_POST['address'])) echo $_POST['address'];?>">
			</div>
		</div>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="city_name"><?php _e('City','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="city_name" class="form-control validate[required,custom[onlyLetterSp]] text-input" type="text" maxlength="50" name="city_name" 
				value="<?php if($edit){ echo $user_info->city_name;}elseif(isset($_POST['city_name'])) echo $_POST['city_name'];?>">
			</div>
		</div>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label " for="mobile"><?php _e('Mobile Number','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-1">
			
			<input type="text" readonly value="+<?php echo gmgt_get_countery_phonecode(get_option( 'gmgt_contry' ));?>"  class="form-control" name="phonecode">
			</div>
			<div class="col-sm-7">
				<input id="mobile" class="form-control validate[required] text-input phone_validation text-input" type="text" name="mobile" minlength="10" maxlength="15"  name="mobile" 
				value="<?php if($edit){ echo $user_info->mobile;}elseif(isset($_POST['mobile'])) echo $_POST['mobile'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label " for="phone"><?php _e('Phone','gym_mgt');?></label>
			<div class="col-sm-8">
				<input id="phone" class="form-control validate[required] text-input phone_validation" minlength="10" maxlength="15"  name="phone" 
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
			<h4><?php _e('Login Information','gym_mgt');?></h4>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="username"><?php _e('User Name','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="username" class="form-control validate[required] space_validation" type="text"  name="username"  maxlength="30"
				value="<?php if($edit){ echo $user_info->user_login;}elseif(isset($_POST['username'])) echo $_POST['username'];?>" <?php if($edit) echo "readonly";?>>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="password"><?php _e('Password','gym_mgt');?><?php if(!$edit) {?><span class="require-field">*</span><?php }?></label>
			<div class="col-sm-8">
				<input id="password" class="form-control <?php if(!$edit) echo 'validate[required]';?> space_validation"  minlength="8" maxlength="12" type="password"  name="password" value="">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="photo"><?php _e('Image','gym_mgt');?></label>
			<div class="col-sm-2">
				<input type="text" id="gmgt_user_avatar_url1" class="form-control gmgt_user_avatar_url" name="gmgt_user_avatar"  
				value="<?php if($edit)echo esc_url( $user_info->gmgt_user_avatar );elseif(isset($_POST['gmgt_user_avatar'])) echo $_POST['gmgt_user_avatar']; ?>" />
			</div>	
				<div class="col-sm-3">
       				 <input id="upload_user_avatar_button1" type="button" class="button upload_user_avatar_button" value="<?php _e( 'Upload image', 'gym_mgt' ); ?>" />
       				 <span class="description"><?php _e('Upload image', 'gym_mgt' ); ?></span>
       		
			    </div>
			<div class="clearfix"></div>
			
			<div class="col-sm-offset-2 col-sm-8">
				<div id="upload_user_avatar_preview1" class="upload_user_avatar_preview">
					 <?php if($edit) 
						{
							if($user_info->gmgt_user_avatar == "")
							{?>
							<img alt="" style="max-width:100%;" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">
							<?php }
							else {
								?>
							<img style="max-width:100%;" src="<?php if($edit)echo esc_url( $user_info->gmgt_user_avatar ); ?>" />
							<?php 
							}
						}
						else
						{
							?>
							<img alt="" style="max-width:100%;" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">
							<?php 
						}?>
				</div>
   		 </div>
		</div>

		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','gym_mgt'); }else{ _e('Add Staff','gym_mgt');}?>" name="save_staff" id="add_staff_member" class="btn btn-success specialization_submit "/>
        </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  
        </div>
      </div>
    </div>
  </div>