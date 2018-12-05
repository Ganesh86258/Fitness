<?php 
$cur_user_class_id = array();	
$obj_class=new MJ_Gmgtclassschedule;
$curr_user_id=get_current_user_id();
$obj_gym=new MJ_Gym_management($curr_user_id);
//$cur_user_class_id=get_user_meta($curr_user_id,'class_id',true);
$cur_user_class_id = get_current_user_classis($curr_user_id);
$active_tab = isset($_REQUEST['tab'])?$_REQUEST['tab']:'classlist';
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
if(isset($_POST['save_class']))
{
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
	{
			if($_POST['start_ampm'] == $_POST['end_ampm'] )
			{				
				if($_POST['end_time'] < $_POST['start_time'])
				{
					$time_validation='1';					
				
				}
				elseif($_POST['end_time'] ==  $_POST['start_time'] && $_POST['start_min'] > $_POST['end_min'] )
				{
					$time_validation='1';
				}	
				elseif($_POST['end_time'] ==  $_POST['start_time'] && $_POST['start_min'] == $_POST['end_min'] )
				{
					$time_validation='1';
				}					
			}
			else
			{
				if($_POST['start_ampm']!='am')
				{
					$time_validation='1';
				}	
			}	
			if($time_validation=='1')
			{
				?>
				<div id="message" class="updated below-h2 ">
				<p>
				<?php 
					_e('End Time should be greater than Start Time','gym_mgt');
				?></p>
				</div>
				<?php 
			}
			else
			{		
				$result=$obj_class->gmgt_add_class($_POST);
				if($result)
				{
					wp_redirect ( home_url().'?dashboard=user&page=class-schedule&tab=classlist&message=2');
				}
			}		
	}
	else
	{
			if($_POST['start_ampm'] == $_POST['end_ampm'] )
			{				
				if($_POST['end_time'] < $_POST['start_time'])
				{
					$time_validation='1';					
				
				}
				elseif($_POST['end_time'] ==  $_POST['start_time'] && $_POST['start_min'] > $_POST['end_min'] )
				{
					$time_validation='1';
				}	
				elseif($_POST['end_time'] ==  $_POST['start_time'] && $_POST['start_min'] == $_POST['end_min'] )
				{
					$time_validation='1';
				}					
			}
			else
			{
				if($_POST['start_ampm']!='am')
				{
					$time_validation='1';
				}	
			}	
			if($time_validation=='1')
			{
				?>
				<div id="message" class="updated below-h2 ">
				<p>
				<?php 
					_e('End Time should be greater than Start Time','gym_mgt');
				?></p>
				</div>
				<?php 
			}
			else
			{
				$result=$obj_class->gmgt_add_class($_POST);
				if($result)
				{
					wp_redirect ( home_url().'?dashboard=user&page=class-schedule&tab=classlist&message=1');
				}	
			}			
	}
}

if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{
	$result=$obj_class->delete_class($_REQUEST['class_id']);
	if($result)
	{
		wp_redirect ( home_url().'?dashboard=user&page=class-schedule&tab=classlist&message=3');
	}
}
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='book')
{
	
	$result=$obj_class->booking_class($_REQUEST['class_id'],$_REQUEST['dayname']);
	if($result)
	{ ?>
		<div id="message" class="updated below-h2 "><p><?php print $result;	?></p></div>		
		<?php
	}
}

if(isset($_REQUEST['message']))
{
	$message =$_REQUEST['message'];
	if($message == 1)
	{ ?>
		<div id="message" class="updated below-h2 ">
			<p><?php 	_e('Record inserted successfully','gym_mgt');?></p>
		</div>
	<?php 
	}
	elseif($message == 2)
	{ ?>
	<div id="message" class="updated below-h2 ">
		<p><?php _e("Record updated successfully.",'gym_mgt');	?></p>
	</div>
	<?php 		
	}
	elseif($message == 3) 
	{ ?>
		<div id="message" class="updated below-h2">
			<p><?php _e('Record deleted successfully','gym_mgt'); ?></div></p>
	<?php				
	}
}
?>
<?php
$membership_id=get_user_meta( get_current_user_id(),'membership_id',true );
if($membership_id)
{
	if(get_membership_class_status($membership_id)=="limited")
	{	
		$obj_membership = new MJ_Gmgtmembership();
		$on_of_classis = $obj_membership->get_single_membership($membership_id);
		
	 ?> 
	 <div id="message" class="updated below-h2 class_booked"><p><?php  print "You have booked ".get_user_used_membership_class($membership_id,get_current_user_id())." class from ".$on_of_classis->on_of_classis." <b>"; ?></b></p></div>
	 <?php 
	}	
}
?>
<script type="text/javascript">
$(document).ready(function() {
	jQuery('#class_list').DataTable({
		"responsive": true,
		 "order": [[ 1, "asc" ]],
		 "aoColumns":[
	         {"bSortable": true},
	         {"bSortable": true},
	         {"bSortable": true},
	         {"bSortable": true},
	         {"bSortable": true},			 
			 {"bSortable": false}]
		});
		jQuery('#booking_list').DataTable({});
		$('#group_form').validationEngine();
		$('#membership_id').multiselect(
		{
			nonSelectedText :'Select Membership',
			includeSelectAllOption: true
	    });
		$('#day').multiselect(
		{
			nonSelectedText :'Select Day',
			includeSelectAllOption: true
	    });
		
		$(".day_validation_submit").click(function()
		{	
		  checked = $(".day_validation_class .dropdown-menu input:checked").length;
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
} );
</script>
<div class="panel-body panel-white">
<ul class="nav nav-tabs panel_tabs" role="tablist">      
	<li class="<?php if($active_tab == 'classlist') echo "active";?>">
          <a href="?dashboard=user&page=class-schedule&tab=classlist">
             <i class="fa fa-align-justify"></i> <?php _e('Class Schedule', 'gym_mgt'); ?></a>          
    </li>
    <li class="<?php if($active_tab=='addclass'){?>active<?php }?>">
		  <?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['class_id']))
			{?>
			<a href="?dashboard=user&page=class-schedule&tab=addclass&action=edit&class_id=<?php echo $_REQUEST['class_id'];?>" class="nav-tab <?php echo $active_tab == 'addclass' ? 'nav-tab-active' : ''; ?>">
             <i class="fa fa"></i> <?php _e('Edit Class', 'gym_mgt'); ?></a>
			 <?php }
			else
			{ 
				if($user_access['add']=='1')
				{
				?>
					<a href="?dashboard=user&page=class-schedule&tab=addclass&&action=insert" class="nav-tab <?php echo $active_tab == 'addclass' ? 'nav-tab-active' : ''; ?>">
					<i class="fa fa-plus-circle"></i> <?php _e('Add Class', 'gym_mgt'); ?></a>
			<?php }
			}
			?>	  
	</li>	
		<li class="<?php if($active_tab == 'schedulelist') {?>active<?php }?>">
			  <a href="?dashboard=user&page=class-schedule&tab=schedulelist">
				 <i class="fa fa-align-justify"></i> <?php _e('Schedule List', 'gym_mgt'); ?></a>
			  </a>
		</li>
		<?php if( $obj_gym->role == 'member')
		{ ?>
			<li class="<?php if($active_tab == 'class_booking') {?>active<?php }?>">
			  <a href="?dashboard=user&page=class-schedule&tab=class_booking">
				 <i class="fa fa-align-justify"></i> <?php _e('Booking List', 'gym_mgt'); ?></a>
			  </a>
			</li>
		 <?php
		}
	 ?>
</ul>
	<div class="tab-content">
	<?php 
	if($active_tab == 'class_booking')
	{ ?>
		<div class="panel-body">
			<div class="table-responsive">
			    <table id="booking_list" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th><?php  _e( 'Member Name', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Class Name', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Booking Date', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Day', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Starting Time', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Ending Time', 'gym_mgt' ) ;?></th>            
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th><?php  _e( 'Member Name', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Class Name', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Booking Date', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Day', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Starting Time', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Ending Time', 'gym_mgt' ) ;?></th>  
						</tr>
					</tfoot>
					<tbody>
						<?php 
						$bookingdata=$obj_class->get_member_book_class(get_current_user_id());
						if(!empty($bookingdata))
						{
							foreach ($bookingdata as $retrieved_data)
							{ ?>
								<tr>
									<td class="membername"><a href="#"><?php echo gym_get_display_name($retrieved_data->member_id);?></a></td>
									<td class="class_name"><?php print  $obj_class->get_class_name($retrieved_data->class_id);?></td>
									<td class="class_name"><?php print  str_replace('00:00:00',"",$retrieved_data->booking_date)?></td>
									<td class="starttime"><?php echo $retrieved_data->booking_day;?></td>
									<?php $class_data = $obj_class->get_single_class($retrieved_data->class_id); ?>
									<td class="starttime"><?php echo $class_data->start_time;?></td>
									<td class="endtime"><?php echo $class_data->end_time;?></td>

								</tr>
							<?php 
							} 
						}?>     
					</tbody>        
				</table>
			</div>
		</div>
		
	<?php 
	}
	?>
    <?php if($active_tab == 'classlist')
	{ ?>
	<div class="panel-body">
        <div class="table-responsive">
		    <table id="class_list" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><?php  _e( 'Class Name', 'gym_mgt' ) ;?></th>
						<th><?php  _e( 'Staff Name', 'gym_mgt' ) ;?></th>
						<th><?php  _e( 'Starting Time', 'gym_mgt' ) ;?></th>
						<th><?php  _e( 'Ending Time', 'gym_mgt' ) ;?></th>
						<th><?php  _e( 'Day', 'gym_mgt' ) ;?></th>
						
						<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
						
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th><?php  _e( 'Class Name', 'gym_mgt' ) ;?></th>
						<th><?php  _e( 'Staff Name', 'gym_mgt' ) ;?></th>
						<th><?php  _e( 'Starting Time', 'gym_mgt' ) ;?></th>
						<th><?php  _e( 'Ending Time', 'gym_mgt' ) ;?></th>
						<th><?php  _e( 'Day', 'gym_mgt' ) ;?></th>
						
						<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
					
					</tr>
				</tfoot>
				<tbody>
					<?php
					if($obj_gym->role == 'staff_member')
					{
						if($user_access['own_data']=='1')
						{
							$user_id=get_current_user_id();							
							$classdata=$obj_class->get_all_classes_by_staffmember($user_id);	
						}
						else
						{
							$classdata=$obj_class->get_all_classes();
						}
					}
					elseif($obj_gym->role == 'member')
					{		
						if($user_access['own_data']=='1')
						{
							$user_id=get_current_user_id();							
							$classdata=$obj_class->get_all_classes_by_member($cur_user_class_id);	
						}
						else
						{
							$classdata=$obj_class->get_all_classes();
						}
					}
					else
					{		
						if($user_access['own_data']=='1')
						{
							$user_id=get_current_user_id();							
							$classdata=$obj_class->get_all_classes_by_class_created_id($user_id);	
						}
						else
						{
							$classdata=$obj_class->get_all_classes();
						}
					}
					
					if(!empty($classdata))
					{
						foreach ($classdata as $retrieved_data)
						{?>
						<tr>
							<td class="classname"><a href="#"><?php echo $retrieved_data->class_name;?></a></td>
							<td class="staff"><?php $userdata=get_userdata( $retrieved_data->staff_id );
							echo $userdata->display_name;?></td>
						
							<td class="starttime"><?php echo $retrieved_data->start_time;?></td>
							<td class="endtime"><?php echo $retrieved_data->end_time;?></td>
							<td class="day"><?php $days_array=json_decode($retrieved_data->day); 
							$days_string=array();
							if(!empty($days_array))
							{
								foreach($days_array as $day)
								{
									$days_string[]=substr($day,0,3);
								}
							}
							echo implode(", ",$days_string);?></td>
							
								<td class="action"> 
								<?php
								if($user_access['edit']=='1')
								{
								?>
									<a href="?dashboard=user&page=class-schedule&tab=addclass&action=edit&class_id=<?php echo $retrieved_data->class_id ?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
								<?php
								}
								if($user_access['delete']=='1')
								{
								?>		
									<a href="?dashboard=user&page=class-schedule&tab=classlist&action=delete&class_id=<?php echo $retrieved_data->class_id;?>" class="btn btn-danger" 
									onclick="return confirm('<?php _e('Do you really want to delete this record?','gym_mgt');?>');">
									<?php _e( 'Delete', 'gym_mgt' ) ;?> </a>
								<?php
								}
								?>				   
								</td>
							
						</tr>
						<?php 
						}
					}?>     
				</tbody>        
			</table>
 		</div>
	</div>
	<?php 
	} 
	if($active_tab == 'addclass')
	{
		$obj_class=new MJ_Gmgtclassschedule;
		$obj_membership=new MJ_Gmgtmembership;
		$class_id=0;
		if(isset($_REQUEST['class_id']))
			$class_id=$_REQUEST['class_id'];
		$edit=0;
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{
			$edit=1;
			$result = $obj_class->get_single_class($class_id);
		} ?>
		<div class="panel-body">
        <form name="group_form" action="" method="post" class="form-horizontal" id="group_form">
			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
			<input type="hidden" name="action" value="<?php echo $action;?>">
			<input type="hidden" name="class_id" value="<?php echo $class_id;?>"  />
			<div class="form-group">
				<label class="col-sm-2 control-label" for="class_name"><?php _e('Class Name','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="group_name" class="form-control validate[required,custom[onlyLetterSp]] text-input " type="text"  maxlength="50" value="<?php if($edit){ echo $result->class_name;}elseif(isset($_POST['class_name'])) echo $_POST['class_name'];?>" name="class_name">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="staff_name"><?php _e('Select Staff Member','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<?php $get_staff = array('role' => 'Staff_member');
						$staffdata=get_users($get_staff);
						
						?>
					<select name="staff_id" class="form-control validate[required] " id="staff_id">
					<option value=""><?php  _e('Select Staff Member ','gym_mgt');?></option>
					<?php 					
					$staff_data=$result->staff_id;
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
					<?php $assi_staff_data=$result->asst_staff_id;
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
			<div class="form-group day_validation">
				<label class="col-sm-2 control-label" for="day"><?php _e('Select Day','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8 day_validation_class" >			
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
						<?php for($i =0 ; $i <= 12 ; $i++) {	?>
							<option value="<?php echo $i;?>" <?php  if($edit) selected($start_time_data[0],$i);  ?>><?php echo $i;?></option>
						<?php } ?>
					 </select>
				</div>
				<div class="col-sm-2">
					 <select name="start_min" class="form-control validate[required]">
					  <?php	foreach(minute_array() as $key=>$value){ ?>
								<option value="<?php echo $key;?>" <?php  if($edit) selected($start_time_data[1],$key);  ?>><?php echo $value;?></option>
						<?php }	 ?>
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
						 <?php for($i =0 ; $i <= 12 ; $i++){ ?>
							<option value="<?php echo $i;?>" <?php  if($edit) selected($end_time_data[0],$i);  ?>><?php echo $i;?></option>
						<?php }	 ?>
					  </select>
				</div>
				<div class="col-sm-2">
					 <select name="end_min" class="form-control validate[required]">
					  <?php foreach(minute_array() as $key=>$value)
							{	?>
							<option value="<?php echo $key;?>" <?php  if($edit) selected($end_time_data[1],$key);  ?>><?php echo $value;?></option>
					<?php } ?>
					 </select>
				</div>
				<div class="col-sm-2">
					<select name="end_ampm" class="form-control validate[required]">
						<option value="am" <?php  if($edit) if(isset($end_time_data[2])) selected($end_time_data[2],'am');  ?> ><?php _e('am','gym_mgt');?></option>
						<option value="pm" <?php  if($edit) if(isset($end_time_data[2]))selected($end_time_data[2],'pm');  ?>><?php _e('pm','gym_mgt');?></option>
					</select>
				</div>	
			</div>
			<div class="col-sm-offset-2 col-sm-8">        	
				<input type="submit" value="<?php if($edit){ _e('Save','gym_mgt'); }else{ _e('Save','gym_mgt');}?>" name="save_class" class="btn btn-success day_validation_submit"/>
			</div>
        </form>
        </div>
		<?php }
	if($active_tab == 'schedulelist')
	{ 	
    ?>
        <div class="panel-body">		 
			<table class="table table-bordered">
				<?php        
				foreach(days_array() as $daykey => $dayname)
				{?>
				<tr>
					<th width="100"><?php echo $dayname;?></th>
						<td>
							 <?php
								$period = $obj_class->get_schedule_byday($daykey);
								
								if(!empty($period))
									foreach($period as $period_data)
									{				
											
										if(!empty($period_data))
										{						
											if($obj_gym->role=='staff_member')
											{
												if($user_access['own_data']=='1')
												{
													if($period_data['staff_id']==$curr_user_id || $period_data['asst_staff_id']==$curr_user_id)
													{
													echo '<div class="btn-group ">';
													echo '<button class="btn btn-primary dropdown-toggle" aria-expanded="false" data-toggle="dropdown"><span class="period_box" id='.$period_data['class_id'].'>'.get_single_class_name($period_data['class_id']);
													echo '<span class="time"> ('.$period_data['start_time'].'- '.$period_data['end_time'].') </span>';
													
													echo '</span></span><span class="caret"></span></button>';
													echo '<ul role="menu" class="dropdown-menu">';
													if($user_access['edit']=='1')
													{
														echo '<li>
															<a href="?dashboard=user&page=class-schedule&tab=addclass&action=edit&class_id='.$period_data['class_id'].'">'.__('Edit','gym_mgt').'</a>
															</li>';
													}
													if($user_access['delete']=='1')
													{		
														echo '<li><a href="?dashboard=user&page=class-schedule&tab=schedulelist&action=delete&class_id='.$period_data['class_id'].'" onclick="return confirm(\'Are you sure, you want to delete?\')">'.__('Delete','gym_mgt').'</a></li>';
													}	
																	echo '</ul>';
													echo '</div>';
													
													}
												}
												else
												{
													
													echo '<div class="btn-group ">';
													echo '<button class="btn btn-primary dropdown-toggle" aria-expanded="false" data-toggle="dropdown"><span class="period_box" id='.$period_data['class_id'].'>'.get_single_class_name($period_data['class_id']);
													echo '<span class="time"> ('.$period_data['start_time'].'- '.$period_data['end_time'].') </span>';
													
													echo '</span></span><span class="caret"></span></button>';
													echo '<ul role="menu" class="dropdown-menu">';
													if($user_access['edit']=='1')
													{
														echo '<li>
															<a href="?dashboard=user&page=class-schedule&tab=addclass&action=edit&class_id='.$period_data['class_id'].'">'.__('Edit','gym_mgt').'</a>
															</li>';
													}
													if($user_access['delete']=='1')
													{		
														echo '<li><a href="?dashboard=user&page=class-schedule&tab=schedulelist&action=delete&class_id='.$period_data['class_id'].'" onclick="return confirm(\'Are you sure, you want to delete?\')">'.__('Delete','gym_mgt').'</a></li>';
													}	
																	echo '</ul>';
													echo '</div>';
												}		
											}
											elseif($obj_gym->role == 'member')
											{
												if($user_access['own_data']=='1')
												{
													if(in_array($period_data['class_id'],$cur_user_class_id))
													{
														echo '<div class="btn-group m-b-sm">';
														echo '<button class="btn btn-primary dropdown-toggle" aria-expanded="false" data-toggle="dropdown"><span class="period_box" id='.$period_data['class_id'].'>'.get_single_class_name($period_data['class_id']);
														echo '<span class="time"> ('.$period_data['start_time'].'- '.$period_data['end_time'].') </span>';
													
														if( get_membership_class_status(get_user_meta(get_current_user_id(),'membership_id',true))=='limited')
														{								
															echo '</span></span><span class="caret"></span></button>';
															echo '<ul role="menu" class="dropdown-menu">
																<li><a href="?dashboard=user&page=class-schedule&tab=schedulelist&action=book&class_id='.$period_data['class_id'].'&dayname='.$dayname.'">'.__('Book','gym_mgt').'</a></li>';
																if($user_access['edit']=='1')
																{
																	echo '<li>
																		<a href="?dashboard=user&page=class-schedule&tab=addclass&action=edit&class_id='.$period_data['class_id'].'">'.__('Edit','gym_mgt').'</a>
																		</li>';
																}
																if($user_access['delete']=='1')
																{		
																	echo '<li><a href="?dashboard=user&page=class-schedule&tab=schedulelist&action=delete&class_id='.$period_data['class_id'].'" onclick="return confirm(\'Are you sure, you want to delete?\')">'.__('Delete','gym_mgt').'</a></li>';
																}	
																echo  '</ul>';
																echo '</div>';
														}
													}
												}
												else
												{
													
													echo '<div class="btn-group m-b-sm">';
													echo '<button class="btn btn-primary dropdown-toggle" aria-expanded="false" data-toggle="dropdown"><span class="period_box" id='.$period_data['class_id'].'>'.get_single_class_name($period_data['class_id']);
													echo '<span class="time"> ('.$period_data['start_time'].'- '.$period_data['end_time'].') </span>';
												
													if( get_membership_class_status(get_user_meta(get_current_user_id(),'membership_id',true))=='limited')
													{								
														echo '</span></span><span class="caret"></span></button>';
														echo '<ul role="menu" class="dropdown-menu">
																<li><a href="?dashboard=user&page=class-schedule&tab=schedulelist&action=book&class_id='.$period_data['class_id'].'&dayname='.$dayname.'">'.__('Book','gym_mgt').'</a></li>';
																if($user_access['edit']=='1')
																{
																	echo '<li>
																		<a href="?dashboard=user&page=class-schedule&tab=addclass&action=edit&class_id='.$period_data['class_id'].'">'.__('Edit','gym_mgt').'</a>
																		</li>';
																}
																if($user_access['delete']=='1')
																{		
																	echo '<li><a href="?dashboard=user&page=class-schedule&tab=schedulelist&action=delete&class_id='.$period_data['class_id'].'" onclick="return confirm(\'Are you sure, you want to delete?\')">'.__('Delete','gym_mgt').'</a></li>';
																}	
															echo  '</ul>';
														echo '</div>';
														}
												}
											}
											else
											{		
												if($user_access['own_data']=='1')
												{														if($period_data['class_created_id']==		  $curr_user_id)		
													{													
													echo '<div class="btn-group ">';
													echo '<button class="btn btn-primary dropdown-toggle" aria-expanded="false" data-toggle="dropdown"><span class="period_box" id='.$period_data['class_id'].'>'.get_single_class_name($period_data['class_id']);
													echo '<span class="time"> ('.$period_data['start_time'].'- '.$period_data['end_time'].') </span>';
													
													echo '</span></span><span class="caret"></span></button>';
													echo '<ul role="menu" class="dropdown-menu">';
													if($user_access['edit']=='1')
													{
														echo '<li>
															<a href="?dashboard=user&page=class-schedule&tab=addclass&action=edit&class_id='.$period_data['class_id'].'">'.__('Edit','gym_mgt').'</a>
															</li>';
													}
													if($user_access['delete']=='1')
													{		
														echo '<li><a href="?dashboard=user&page=class-schedule&tab=schedulelist&action=delete&class_id='.$period_data['class_id'].'" onclick="return confirm(\'Are you sure, you want to delete?\')">'.__('Delete','gym_mgt').'</a></li>';
													}	
																	echo '</ul>';
													echo '</div>';	
													}												
												}
												else
												{
													echo '<div class="btn-group ">';
													echo '<button class="btn btn-primary dropdown-toggle" aria-expanded="false" data-toggle="dropdown"><span class="period_box" id='.$period_data['class_id'].'>'.get_single_class_name($period_data['class_id']);
													echo '<span class="time"> ('.$period_data['start_time'].'- '.$period_data['end_time'].') </span>';
													
													echo '</span></span><span class="caret"></span></button>';
													echo '<ul role="menu" class="dropdown-menu">';
													if($user_access['edit']=='1')
													{
														echo '<li>
															<a href="?dashboard=user&page=class-schedule&tab=addclass&action=edit&class_id='.$period_data['class_id'].'">'.__('Edit','gym_mgt').'</a>
															</li>';
													}
													if($user_access['delete']=='1')
													{		
														echo '<li><a href="?dashboard=user&page=class-schedule&tab=schedulelist&action=delete&class_id='.$period_data['class_id'].'" onclick="return confirm(\'Are you sure, you want to delete?\')">'.__('Delete','gym_mgt').'</a></li>';
													}	
													echo '</ul>';
													echo '</div>';
												}		
												
											}		
										}						
									}
								?>
						</td>
				</tr>
				<?php	
				}
			?>
            </table>
        </div>
	 <?php
	}?>
	</div>
</div>
<?php ?>