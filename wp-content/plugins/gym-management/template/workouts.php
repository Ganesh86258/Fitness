<?php  $curr_user_id=get_current_user_id();
$obj_gym=new MJ_Gym_management($curr_user_id);
$obj_workouttype=new MJ_Gmgtworkouttype;
$obj_workout=new MJ_Gmgtworkout;
$active_tab = isset($_REQUEST['tab'])?$_REQUEST['tab']:'workoutlist';
//access right
$user_access=get_userrole_wise_page_access_right_array();
if (isset ( $_REQUEST ['page'] ))
{	
	if($user_access['view']=='0')
	{	
		access_right_page_not_access_message();
		die;
	}
	if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='edit'))
	{
		if($user_access['edit']=='0')
		{	
			access_right_page_not_access_message();
			die;
		}			
	}
	if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='delete'))
	{
		if($user_access['delete']=='0')
		{	
			access_right_page_not_access_message();
			die;
		}	
	}
	if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='insert'))
	{
		if($user_access['add']=='0')
		{	
			access_right_page_not_access_message();
			die;
		}	
	}
}
?>
<script type="text/javascript">
$(document).ready(function() 
{
	jQuery('#workout_list').DataTable(
	{
		"responsive": true,
		 "order": [[ 1, "asc" ]],
		 "aoColumns":[
					  {"bSortable": false},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
					  {"bSortable": true},
					 {"bSortable": false}]
	});
} );
</script>
<!-- POP up code -->
<div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
		<div class="invoice_data"></div>
        </div>
    </div> 
</div>
<!-- End POP-UP Code -->
<?php 
	if(isset($_POST['save_workout']))
	{
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{
			if(!empty($_POST['workouts_array']))
			{	
				$result=$obj_workout->gmgt_add_workout($_POST);
			}
			else
			{
			?>
				<div id="message" class="updated below-h2">
				<p><p><?php _e('Today Can Not Assign Workout','gym_mgt');?></p></p>
				</div>
			<?php	
			}	
			if($result)
			{
				wp_redirect ( home_url() . '?dashboard=user&page=workouts&tab=workoutlist&message=2');
			}
		}
		else
		{
			$exists_record=check_user_workouts($_POST['member_id'],$_POST['record_date']);
			if($exists_record==0){
					if(!empty($_POST['workouts_array']))
					{
						$result=$obj_workout->gmgt_add_workout($_POST);
					}	
					else
					{
					?>
						<div id="message" class="updated below-h2">
						<p><p><?php _e('Today Can Not Assign Workout','gym_mgt');?></p></p>
						</div>
					<?php	
					}	
					if($result)
					{
						wp_redirect ( home_url() . '?dashboard=user&page=workouts&tab=workoutlist&message=1');
					}
			}
			else
			{?>
				<div id="message" class="updated below-h2">
				<p><p><?php _e('Workout is already available for today.','gym_mgt');?></p></p>
				</div>						
	  <?php }
		}
	}
	if(isset($_POST['save_measurement']))
	{
		if(isset($_FILES['gmgt_progress_image']) && !empty($_FILES['gmgt_progress_image']) && $_FILES['gmgt_progress_image']['size'] !=0)
		{			
			if($_FILES['gmgt_progress_image']['size'] > 0)
						 $member_image=load_documets($_FILES['gmgt_progress_image'],'gmgt_progress_image','pimg');
						$member_image_url=content_url().'/uploads/gym_assets/'.$member_image;
						
		}
		else
		{
			
			if(isset($_REQUEST['hidden_upload_user_progress_image']))
							$member_image=$_REQUEST['hidden_upload_user_progress_image'];
						$member_image_url=$member_image;
		}		
		
		$ext=check_valid_extension($member_image_url);
		
		if(!$ext == 0)
		{
			
			if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
			{
			
				$result=$obj_workout->gmgt_add_measurement($_POST,$member_image_url);
				if($result)
				{
					wp_redirect ( home_url().'?dashboard=user&page=workouts&tab=workoutlist&message=2');
				}
			}
			else
			{
				$result=$obj_workout->gmgt_add_measurement($_POST,$member_image_url);
				if($result)
				{
					wp_redirect ( home_url().'?dashboard=user&page=workouts&tab=workoutlist&message=1');
				}				
			}	
		}			
		else
		{?>
			<div id="message" class="updated below-h2 ">
			<p>
				<?php _e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?>
			</p></div>				 
			<?php 
		}			
	}
	
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
	{		
		$result=$obj_workout->delete_workout($_REQUEST['daily_workout_id']);
		if($result)
		{
			wp_redirect ( home_url() . '?dashboard=user&page=workouts&tab=workoutlist&message=3');
		}
	}
		if(isset($_REQUEST['message']))
		{
			$message =$_REQUEST['message'];
			if($message == 1)
			{?>
					<div id="message" class="updated below-h2 ">
					<p>
					<?php 
						_e('Record inserted successfully','gym_mgt');
					?></p></div>
					<?php 				
			}
			elseif($message == 2)
			{?><div id="message" class="updated below-h2 "><p><?php
				_e("Record updated successfully.",'gym_mgt');
				?></p>
				</div>
				<?php 				
			}
			elseif($message == 3) 
			{?>
			<div id="message" class="updated below-h2"><p>
			<?php 
				_e('Record deleted successfully','gym_mgt');
			?></div></p><?php
					
			}
		}
	?>
<div class="panel-body panel-white">
<ul class="nav nav-tabs panel_tabs" role="tablist">
      <li class="<?php if($active_tab == 'workoutlist') echo "active";?>">
          <a href="?dashboard=user&page=workouts&tab=workoutlist">
             <i class="fa fa-align-justify"></i> <?php _e('Workout List', 'gym_mgt'); ?></a>
          </a>
      </li>	  
      <li class="<?php if($active_tab == 'addworkout') echo "active";?>">
	    <?php 
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view' && isset($_REQUEST['workoutmember_id']))
		{
		?>	
			<a href="?dashboard=user&page=workouts&tab=addworkout&action=view&workoutmember_id=<?php echo $_REQUEST['workoutmember_id'];?>" class="nav-tab <?php echo $active_tab == 'addworkout' ? 'nav-tab-active' : ''; ?>">
			<i class="fa fa"></i> <?php _e('View Workout', 'gym_mgt'); ?></a>
		<?php
		}
		else
		{
			if($user_access['add']=='1')
			{
		?>
			<a href="?dashboard=user&page=workouts&tab=addworkout&&action=insert" class="nav-tab <?php echo $active_tab == 'addworkout' ? 'nav-tab-active' : ''; ?>">
			<i class="fa fa-plus-circle"></i> <?php _e('Add Workout', 'gym_mgt'); ?></a>
		<?php
			}
		}		
		?>      	
      </li>
       
       <li class="<?php if($active_tab == 'addmeasurement') echo "active";?>">
	       <?php 
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['measurment_id']))
		{
		?>	
			<a href="?dashboard=user&page=workouts&tab=addmeasurement&action=edit&measurment_id=<?php echo $_REQUEST['measurment_id'];?>" class="nav-tab <?php echo $active_tab == 'addmeasurement' ? 'nav-tab-active' : ''; ?>">
			<i class="fa fa-plus-circle"></i> <?php _e('Edit Measurement', 'gym_mgt'); ?></a>
		<?php
		}
		else
		{
			if($user_access['add']=='1')
			{
		?>
			<a href="?dashboard=user&page=workouts&tab=addmeasurement&&action=insert" class="nav-tab <?php echo $active_tab == 'addmeasurement' ? 'nav-tab-active' : ''; ?>">
			<i class="fa fa-plus-circle"></i><?php _e('Add Measurement', 'gym_mgt'); ?></a>
		<?php
			}
		}		
		?>       
      </li>
</ul>

	<div class="tab-content">
		<?php if($active_tab == 'workoutlist'){?>
    	<div class="tab-pane <?php if($active_tab == 'workoutlist') echo "fade active in";?>" id="workoutlist">
		    <div class="panel-body">
                <div class="table-responsive">
				    <table id="workout_list" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
							<th><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Member Name', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Membership', 'gym_mgt' ) ;?></th>
							<th><?php _e( 'Joining Date', 'gym_mgt' ) ;?></th>
							<th><?php _e( 'Expire Date', 'gym_mgt' ) ;?></th>
							<!--<th><?php  _e( 'Mobile', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Email', 'gym_mgt' ) ;?></th>-->
							<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
							
							</tr>
				     	</thead>
						<tfoot>
							<tr>
							<th><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Member Name', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Membership', 'gym_mgt' ) ;?></th>
							<th><?php _e( 'Joining Date', 'gym_mgt' ) ;?></th>
							<th><?php _e( 'Expire Date', 'gym_mgt' ) ;?></th>
							<!--<th><?php  _e( 'Mobile', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Email', 'gym_mgt' ) ;?></th>-->
							<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
							</tr>
						</tfoot>
						<tbody>
						 <?php //$workoutdata=$obj_workout->get_all_workout();
							if($obj_gym->role == 'member')
							{
								$user_id = get_current_user_id();
								?>
								<tr>
								<td class="user_image"><?php 
								$userimage=get_user_meta($user_id, 'gmgt_user_avatar', true);
									if(empty($userimage))
									{
										echo '<img src='.get_option( 'gmgt_system_logo' ).' height="50px" width="50px" class="img-circle" />';
									}
									else
									{
										echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>';
									}
								?></td>
								<td class="membername">
								<?php $user=get_userdata($user_id);
								$display_label=$user->display_name;
								$memberid=get_user_meta($user_id,'member_id',true);
									if($memberid)
										$display_label.=" (".$memberid.")";
									echo $display_label;?></td>
								
								<td><?php echo get_membership_name($user->membership_id);?></td>
								<td class="joining date"><?php if($user->member_type!='Prospect'){ echo getdate_in_input_box($user->begin_date); }else{ echo "--"; }?></td>
								
								<td class="joining date"><?php if($user->member_type!='Prospect'){ echo getdate_in_input_box(gmgt_check_membership($user->ID)); }else{ echo "--"; }?></td>
							   
								<td class="action"> 
									<?php if($obj_gym->role == 'staff_member' || ($obj_gym->role == 'member' && $user_id==$curr_user_id)){?>
									<a href="?dashboard=user&page=workouts&tab=addworkout&action=view&workoutmember_id=<?php echo $user_id;?>" class="btn btn-success"> <?php _e('View', 'gym_mgt' ) ;?></a>
									<a href="#" class="btn btn-default view-measurement-popup" data-val="<?php echo $user_id;?>"> <i class="fa fa-eye"></i><?php _e('View Measurement', 'gym_mgt' ) ;?></a>
									<?php }?>
								</td>
							</tr>
								
								<?php 
							}
							else
							{
							
								$get_members = array('role' => 'member');
								$membersdata=get_users($get_members);
								if(!empty($membersdata))
								{
									foreach ($membersdata as $retrieved_data)
									{?>							
									<tr>
										<td class="user_image">
											<?php 
											$userimage=get_user_meta($retrieved_data->ID, 'gmgt_user_avatar', true);
											if(empty($userimage))
											{
												echo '<img src='.get_option( 'gmgt_system_logo' ).' height="50px" width="50px" class="img-circle" />';
											}
											else
											{
												echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>';
											}
										?></td>
										<td class="membername"><a href="#">
										<?php $user=get_userdata($retrieved_data->ID);
										$display_label=$user->display_name;
										$memberid=get_user_meta($retrieved_data->ID,'member_id',true);
											if($memberid)
												$display_label.=" (".$memberid.")";
											echo $display_label;?></a></td>
										
										<td><?php echo get_membership_name($user->membership_id);?></td>
										<td class="joining date"><?php if($user->member_type!='Prospect'){ echo getdate_in_input_box($user->begin_date); }else{ echo "--"; }?></td>
										
										<td class="joining date"><?php if($user->member_type!='Prospect'){ echo getdate_in_input_box(gmgt_check_membership($user->ID)); }else{ echo "--"; }?></td>
									   
										<td class="action"> 
											<?php if($obj_gym->role == 'staff_member' || ($obj_gym->role == 'member' && $retrieved_data->ID==$curr_user_id)){?>
											<a href="?dashboard=user&page=workouts&tab=addworkout&action=view&workoutmember_id=<?php echo $retrieved_data->ID;?>" class="btn btn-success"> <?php _e('View', 'gym_mgt' ) ;?></a>
											<a href="#" class="btn btn-default view-measurement-popup" data-val="<?php echo $retrieved_data->ID;?>"> <i class="fa fa-eye"></i><?php _e('View Measurement', 'gym_mgt' ) ;?></a>
											<?php }?>
										</td>
									   
									   
									</tr>
									
									<?php 
									} 							
								}
							}
							?>
						</tbody>
					</table>
 	         	</div>
		    </div>
	    </div>
		<?php }
		if($active_tab == 'addworkout')
		{?>
		<script type="text/javascript">
		$(document).ready(function() 
		{
			$('#workout_form').validationEngine();
			 var date = new Date();
			 date.setDate(date.getDate()-0);
			 $.fn.datepicker.defaults.format =" <?php echo get_option('gmgt_datepicker_format');?>";
			 $('#curr_date').datepicker({
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
			$('#record_date').datepicker({
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
			$(".display-members").select2();
	    } );
	    </script>
       <?php 	
	 
        	$daily_workout_id=0;
			if(isset($_REQUEST['daily_workout_id']))
				$daily_workout_id=$_REQUEST['daily_workout_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
				{
					
					$edit=1;
					$result = $obj_workout->get_single_workout($daily_workout_id);
					
				}?>
		<div class="tab-pane <?php if($active_tab == 'addworkout') echo "fade active in";?>">
       <?php 
	   $workoutmember_id=0;
			if(isset($_REQUEST['workoutmember_id']))
				$workoutmember_id=$_REQUEST['workoutmember_id'];
				$view=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view')
				{
					$view=1;?>
			<div class="panel-body"> 
				<form method="post" class="form-horizontal">  
					<div class="col-md-12">
						<h2><?php echo gym_get_display_name($_REQUEST['workoutmember_id']).'\'s Workout'; ?></h2>
					</div>
					<div class="form-group">
						<label class="col-sm-1 control-label" for="curr_date"><?php _e('Date','gym_mgt');?></label>
						<div class="col-sm-3">
						<input id="curr_date" class="form-control" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>" type="text" 
						value="<?php if(isset($_POST['tcurr_date'])) echo $_POST['tcurr_date'];  
						else echo  getdate_in_input_box(date("Y-m-d"));?>" 
						name="tcurr_date">
						</div>
						<div class="col-sm-3">
						<input type="submit" value="<?php _e('View Workouts','gym_mgt');?>" name="view_workouts"  class="btn btn-success"/>
						</div>
					</div>
				</form>
		    </div>
		  <div class="clearfix"> </div>
		   <?php 
				if(isset($_REQUEST['view_workouts']) || isset($_REQUEST['view_workouts']))
				{	
				?>
				 		<?php 
						//$tcurrent_date = date('Y-m-d',strtotime($_POST['tcurr_date']));
						$tcurrent_date=get_format_for_db($_POST['tcurr_date']);
						$today_workouts=$obj_workout->get_member_today_workouts($workoutmember_id,$tcurrent_date);
					    if(!empty($today_workouts))
						{
						?>
							<div class="col-md-12 my-workouts-display">
							<?php foreach($today_workouts as $value)
							{
								$workoutid=$value->user_workout_id;
								$activity_name=$value->workout_name;
								$workflow_category=$obj_workout->get_user_workouts($workoutid,$activity_name);
							?>
							<div class='col-md-10 activity-data no-padding'>
							<div class='workout_datalist_header'>
								<h2><?php echo $value->workout_name;?></h2>
							</div>
							<div class="col-md-12 workout_datalist no-padding"> 
							<?php //for($i=1;$i<=4;$i++){
								?>
						
								<div class="col-md-6 sets-row no-paddingleft">	
									<span class="text-center sets_counter"><?php echo 1 ;?></span>
									<span class="sets_kg"><?php echo $workflow_category->sets." Sets";?></span>								
									<span class="reps_count"><?php echo $value->sets." Sets";?></span>
								</div>
								<div class="col-md-6 sets-row no-paddingleft">	
									<span class="text-center sets_counter"><?php echo 2 ;?></span>
									<span class="sets_kg"><?php echo $workflow_category->reps." Reps";?></span>								
									<span class="reps_count"><?php echo $value->reps." Reps";?></span>
								</div>
								
								
							<?php 
							//}?>
							</div>
								<div class="col-md-12 workout_datalist no-padding"> 
								<div class="col-md-6 sets-row no-paddingleft">	
										<span class="text-center sets_counter"><?php echo 3;?></span>
										<span class="sets_kg"><?php echo $workflow_category->kg." Kg";?></span>								
										<span class="reps_count"><?php echo $value->kg." Kg";?></span>
									</div>
									<div class="col-md-6 sets-row no-paddingleft">	
										<span class="text-center sets_counter"><?php echo 4 ;?></span>
										<span class="sets_kg"><?php echo $workflow_category->time." Rest Time";?></span>								
										<span class="reps_count"><?php echo $value->rest_time." Rest Time";?></span>
									</div>
								</div>
								</div>
								<div class="border_line"></div>
								
							<?php 
							
							}
							?>
							
							</div>
						
					<?php }
						else
						{ ?>
						<span class="col-md-10"><?php _e('No Data Of Today workout','gym_mgt');?></span>
				<?php }
				}
            }
		else
		{ ?>
       <div class="panel-body">
        <form name="workout_form" action="" method="post" class="form-horizontal" id="workout_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="daily_workout_id" value="<?php //echo $daily_workout_id;?>"  />
		
		<?php if($obj_gym->role=='staff_member' || $obj_gym->role=='accountant'){?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="day"><?php _e('Member','gym_mgt');?></label>
			<div class="col-sm-8">
				<?php if($view){ $member_id=$result->member_id; }elseif(isset($_POST['member_id'])){$member_id=$_POST['member_id'];}else{$member_id='';}?>
				<select id="member_list" class="display-members" required="true"  name="member_id">
					<option value=""><?php _e('Select Member','gym_mgt');?></option>
					<?php $get_members = array('role' => 'member');
					$membersdata=get_users($get_members);
					//print_r($membersdata);

					 if(!empty($membersdata))
					 {
						foreach ($membersdata as $member){ 
						if( $member->membership_status == "Continue")
								{?>
							<option value="<?php echo $member->ID;?>" <?php selected($member_id,$member->ID);?>><?php echo $member->display_name." - ".$member->member_id; ?> </option>
						<?php }
						
						}
					 }?>
			</select>
			</div>
		</div>
		<?php }
		else
		{?>
			<input type="hidden" id="member_list" name="member_id" value="<?php echo $curr_user_id;?>">
	<?php } ?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="record_date">
			<?php _e('Record Date','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="record_date" class="form-control validate[required]" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>" 
				type="text" userid="<?php echo get_current_user_id();?>" name="record_date" 
				value="<?php if($view){ echo getdate_in_input_box($result->record_date);}
				elseif(isset($_POST['record_date'])){ echo $_POST['record_date'];}?>">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="workout_id"><?php _e('Workout','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8 workout_area">
			<div class='work_out_datalist'><div class='col-sm-10'><span class='col-md-10'><?php _e('Select Record Date For Today Workout','gym_mgt');?></span></div></div>
			</div>
		</div>
		
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="note"><?php _e('Note','gym_mgt');?></label>
			<div class="col-sm-8">
				<textarea id="note" class="form-control" name="note" maxlength="150"><?php if($view){echo $result->note; }elseif(isset($_POST['note'])) echo $_POST['note']; ?> </textarea>
			</div>
		</div>
		
		<div class="col-sm-offset-2 col-sm-8">
        	
        	<input type="submit" value="<?php if($view){ _e('Save','gym_mgt'); }else{ _e('Save','gym_mgt');}?>" name="save_workout" class="btn btn-success"/>
        </div>
		
        </form>
    </div>
        
     <?php }
		}
		if($active_tab == 'addmeasurement')
		{
				$edit = 0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
				{
						
					$edit=1;
					$result = $obj_workout->get_single_measurement($_REQUEST['measurment_id']);
				}
				?>
				<script type="text/javascript">
				$(document).ready(function() 
				{
					$('#workout_form').validationEngine();
					$(".display-members").select2();
					var date = new Date();
					 date.setDate(date.getDate()-0);
					 $.fn.datepicker.defaults.format =" <?php echo get_option('gmgt_datepicker_format');?>";
					 $('#result_date').datepicker({
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
				   
					$('.decimal_number').keyup(function(){
					var val = $(this).val();
					if(isNaN(val)){
						 val = val.replace(/[^0-9\.]/g,'');
						 if(val.split('.').length>2) 
							 val =val.replace(/\.+$/,"");
					}
					$(this).val(val); 
					  });
				} );
				</script>
				<div class="panel-body">
					<form name="workout_form" action="" method="post" class="form-horizontal" id="workout_form" enctype="multipart/form-data">
					   <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
						<input type="hidden" name="action" value="<?php echo $action;?>">
						<input type="hidden" name="measurment_id" value="<?php if(isset($_REQUEST['measurment_id']))echo $_REQUEST['measurment_id'];?>">
						<?php if($obj_gym->role=='staff_member' || $obj_gym->role=='accountant'){?>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="day"><?php _e('Member','gym_mgt');?><span class="require-field">*</span></label>	
							<div class="col-sm-8">
								<?php if($edit){ $member_id=$result->user_id; }elseif(isset($_REQUEST['user_id'])){$member_id=$_REQUEST['user_id'];}else{$member_id='';}?>
								<select id="member_list" class="display-members" required="true" name="user_id">
								<!-- <option value=""><?php _e('Select Member','gym_mgt');?></option> -->
									<?php $get_members = array('role' => 'member');
									$membersdata=get_users($get_members);
									 if(!empty($membersdata))
									 {
										foreach ($membersdata as $member){
											if( $member->membership_status == "Continue")
												{
											?>
											<option value="<?php echo $member->ID;?>" <?php selected($member_id,$member->ID);?>><?php echo $member->display_name." - ".$member->member_id; ?> </option>
										<?php }
										}
									 }?>
							</select>
							</div>
						</div>
						<?php }
						else
						{?>
							<input type="hidden" id="member_list" name="user_id" value="<?php echo $curr_user_id;?>">
					<?php } ?>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="result_measurment">
							<?php _e('Result Measurement','gym_mgt');?> <span class="require-field">*</span></label>
							<div class="col-sm-8">
							<?php if($edit){
									$measument=$result->result_measurment;
								}
								elseif(isset($_REQUEST['result_measurment']))
								{
									$measument = $_REQUEST['result_measurment'];
								}
								else
								{
									$measument="";
								}?>
								<select name="result_measurment" class="form-control validate[required] " id="result_measurment">
									<option value=""><?php  _e('Select Result Measurement ','gym_mgt');?></option>
									<?php 	foreach(measurement_array() as $key=>$element)
											{
												if($element == 'Height')
												{
													$unit= get_option( 'gmgt_height_unit' );
												}
											   elseif($element == 'Weight')
											   {
												  $unit= get_option( 'gmgt_weight_unit' );
											   }
											   elseif($element == 'Chest')
											   {
												  $unit= get_option( 'gmgt_chest_unit' );
											   }
											   elseif($element == 'Waist')
											   {
												  $unit= get_option( 'gmgt_waist_unit' );
											   }
											   elseif($element == 'Thigh')
											   {
												  $unit= get_option( 'gmgt_thigh_unit' );
											   }
											   elseif($element == 'Arms')
											   {
												  $unit= get_option( 'gmgt_arms_unit' );
											   }
												elseif($element == 'Fat')
											   {
												  $unit= get_option( 'gmgt_fat_unit' );
											   }
												
												echo '<option value='.$key.' '.selected($measument,$key).'>'.$element.' - '.$unit.'</option>';
												
											}
										
										?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="result"><?php _e('Result','gym_mgt');?> <span class="require-field">*</span></label>
							<div class="col-sm-8">
								<input id="result" class="form-control validate[required] text-input decimal_number" maxlength="6" type="text" value="<?php if($edit){ echo $result->result;}elseif(isset($_POST['result'])) echo $_POST['result'];?>" name="result">
							</div>
							<!--<div class="col-sm-1">
								<label id="workout_mesurement" class="control-label"></label>
							</div>-->
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="result_date">
							<?php _e('Record Date','gym_mgt');?>  <span class="require-field">*</span></label>
							<div class="col-sm-8">
								<input id="result_date" class="form-control validate[required]" type="text" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>" name="result_date" 
								value="<?php if($edit){ echo getdate_in_input_box($result->result_date);}
								elseif(isset($_POST['result_date'])){ echo $_POST['result_date'];} 
								else echo getdate_in_input_box(date('Y-m-d'));?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="photo"><?php _e('Image','gym_mgt');?></label>
							<div class="col-sm-2">
								<input type="text" id="gmgt_user_avatar_url" class="form-control" name="gmgt_progress_image"  
								value="<?php if($edit)echo esc_url( $result->gmgt_progress_image );elseif(isset($_POST['gmgt_progress_image'])) echo $_POST['gmgt_progress_image']; ?>" />
							</div>	
							<div class="col-sm-3">
								<input type="hidden" name="hidden_upload_user_progress_image" value="<?php if($edit){ echo $result->gmgt_progress_image;}elseif(isset($_POST['gmgt_progress_image'])) echo $_POST['gmgt_progress_image'];?>">
									 <input id="upload_user_avatar_image" name="gmgt_progress_image" onchange="fileCheck(this);" type="file" class="form-control file" value="<?php _e( 'Upload image', 'gym_mgt' ); ?>" />
							</div>
							<div class="clearfix"></div>
							
							<div class="col-sm-offset-2 col-sm-8">
									 <div id="upload_user_avatar_preview" >
										 <?php 
										 if($edit) 
											{
											
											if($result->gmgt_progress_image == "")
											{ ?>
											<img alt="" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">
											<?php }
											else {
												?>
											<img style="max-width:100%;" src="<?php echo esc_url( $result->gmgt_progress_image ); ?>" />
											<?php 
											}
											}
											else {
												?>
												<img alt="" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">
												<?php 
											}?>
									</div>
						 </div>
						</div>
						<div class="col-sm-offset-2 col-sm-8">
						   <input type="submit" value="<?php if($edit){ _e('Save Measurement','gym_mgt'); }else{ _e('Save Measurement','gym_mgt');}?>" name="save_measurement" class="btn btn-success"/>
						</div>
					</form>
				</div>
					<?php
					} ?>
					</div>
				</div>
				<?php ?>
				<script type="text/javascript">
				function fileCheck(obj) {
							var fileExtension = ['jpeg', 'jpg', 'png', 'bmp'];
							if ($.inArray($(obj).val().split('.').pop().toLowerCase(), fileExtension) == -1)
							{
								alert("Only '.jpeg','.jpg', '.png', '.bmp' formats are allowed.");
								$(obj).val('');
							}	
							
				}
				</script>