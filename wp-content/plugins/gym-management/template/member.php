<?php $curr_user_id=get_current_user_id();
$obj_gym=new MJ_Gym_management($curr_user_id);
$obj_membership=new MJ_Gmgtmembership;
$obj_class=new MJ_Gmgtclassschedule;
$obj_group=new MJ_Gmgtgroup;
$obj_member=new MJ_Gmgtmember;
$role="member";
$active_tab = isset($_GET['tab'])?$_GET['tab']:'memberlist';
//access right
$user_access=get_userrole_wise_page_access_right_array();
if (isset ( $_REQUEST ['page'] ))
{	
	if($user_access['view']=='0')
	{	
		access_right_page_not_access_message();
		die;
	}
}
	if(isset($_POST['save_member']))		
	{
		if(isset($_FILES['upload_user_avatar_image']) && !empty($_FILES['upload_user_avatar_image']) && $_FILES['upload_user_avatar_image']['size'] !=0)
		{
			
			if($_FILES['upload_user_avatar_image']['size'] > 0)
			{
			  $member_image=load_documets($_FILES['upload_user_avatar_image'],'upload_user_avatar_image','pimg');
						$member_image_url=content_url().'/uploads/gym_assets/'.$member_image;
			}
		}
		else
		{
			if(isset($_REQUEST['hidden_upload_user_avatar_image']))
			{
				$member_image=$_REQUEST['hidden_upload_user_avatar_image'];
			    $member_image_url=$member_image;
			}
		}
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{
				
			$result=$obj_member->gmgt_add_user($_POST);	
				$returnans=update_user_meta( $result,'gmgt_user_avatar',$member_image_url);
			if($result)
			{
				wp_redirect ( home_url().'?dashboard=user&page=member&tab=memberlist&message=2');
			}
				
				
		}
		else
		{
			if( !email_exists( $_POST['email'] ) && !username_exists( $_POST['username'] )) {
	
				$result=$obj_member->gmgt_add_user($_POST);
					$returnans=update_user_meta( $result,'gmgt_user_avatar',$member_image_url);
				if($result>0)
				{
					wp_redirect ( home_url() . '?dashboard=user&page=member&tab=memberlist&message=2');
				}
				
			}
			else
			{?>
				<div id="message" class="updated below-h2">
				<p><p><?php _e('Username Or Email id exists already.','gym_mgt');?></p></p>
				</div>
	  <?php }
		}
	}
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{
	$result=$obj_member->delete_usedata($_REQUEST['member_id']);
	if($result)
	{
		wp_redirect ( home_url().'?dashboard=user&page=member&tab=memberlist&message=3');
	}
}
if(isset($_REQUEST['message']))
{
	$message =$_REQUEST['message'];
	if($message == 1)
	{  ?>
	<div id="message" class="updated below-h2 "><p>
		<?php 	_e('Record inserted successfully','gym_mgt');?></p></div>
	
	<?php 
	}
	elseif($message == 2){ ?>
		<div id="message" class="updated below-h2 ">
			<p>	<?php	_e("Record updated successfully.",'gym_mgt');?></p>
		</div>
<?php }
	elseif($message == 3) { ?>
		<div id="message" class="updated below-h2"><p>
		<?php 	_e('Record deleted successfully','gym_mgt');?></div></p>
<?php		
		}
}
?>

<script type="text/javascript">
$(document).ready(function() {

	var ToEndDate = new Date();
			 $('.date_field').datepicker({
			  }).on('show', function(){
			$('.date_field').datepicker('setEndDate', ToEndDate);
		});
	
	 jQuery('#members_list').DataTable({
		"responsive": true,
		 "order": [[ 1, "asc" ]],
		 "aoColumns":[
	                  {"bSortable": false},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": false}]
		}); 
		$('#member_form').validationEngine();
		$('#memberform2_form').validationEngine();
		$('#group_id').multiselect();
			
} );
</script>
<!-- POP up code -->
<div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="category_list"> </div>		 
		</div>
    </div>     
</div>
<!-- End POP-UP Code -->
<?php 
if(isset($_REQUEST['attendance']) && $_REQUEST['attendance'] == 1)
{ ?>
	<script type="text/javascript">
$(document).ready(function() {	
	$('.sdate').datepicker({dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>'}); 
	$('.edate').datepicker({dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>'}); 
} );
</script>
	<div class="panel-body panel-white">
		 <ul class="nav nav-tabs panel_tabs" role="tablist">
			  <li class="active">			 
				  <a href="#child" role="tab" data-toggle="tab">
					 <i class="fa fa-align-justify"></i> <?php _e('Attendance', 'gym_mgt'); ?></a>
				  </a>
			  </li>
		</ul>
<div class="tab-content">
     <div class="panel-body">
<form name="wcwm_report" action="" method="post">
<input type="hidden" name="attendance" value=1> 
<input type="hidden" name="user_id" value=<?php echo $_REQUEST['member_id'];?>>       
	<div class="form-group col-md-3">
    	<label for="exam_id"><?php _e('Start Date','gym_mgt');?></label>
			<input type="text"  class="form-control sdate" name="sdate" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>" value="<?php if(isset($_REQUEST['sdate'])) echo $_REQUEST['sdate'];
				else echo getdate_in_input_box(date('Y-m-d'));?>">            	
    </div>
    <div class="form-group col-md-3">
    	<label for="exam_id"><?php _e('End Date','gym_mgt');?></label>
			<input type="text"  class="form-control edate" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>" name="edate" 
			value="<?php if(isset($_REQUEST['edate'])) echo $_REQUEST['edate'];
			else echo getdate_in_input_box(date('Y-m-d'));?>">
            	
    </div>
    <div class="form-group col-md-3 button-possition">
    	<label for="subject_id">&nbsp;</label>
      	<input type="submit" name="view_attendance" Value="<?php _e('Go','gym_mgt');?>"  class="btn btn-info"/>
    </div>	
</form>
<div class="clearfix"></div>
<?php if(isset($_REQUEST['view_attendance']))
{
	//$start_date = date('Y-m-d',strtotime($_REQUEST['sdate']));
	$start_date = get_format_for_db($_REQUEST['sdate']);
	//$end_date = date('Y-m-d',strtotime($_REQUEST['edate']));
	$end_date = get_format_for_db($_REQUEST['edate']);
	
	if($start_date > $end_date )
	{
		echo '<script type="text/javascript">alert("End Date should be greater than the Start Date");</script>';
	}
	else
	{
		$user_id = $_REQUEST['user_id'];
		$attendance = gmgt_view_member_attendance($start_date,$end_date,$curr_user_id);
		$curremt_date =$start_date;
		?>
		<table class="table col-md-12">
		<tr>
		<th width="200px"><?php _e('Date','gym_mgt');?></th>
		<th><?php _e('Day','gym_mgt');?></th>
		<th><?php _e('Attendance','gym_mgt');?></th>
		</tr>
		<?php 
		while ($end_date >= $curremt_date)
		{
			echo '<tr>';
			echo '<td>';
			echo getdate_in_input_box($curremt_date);
			echo '</td>';
			
			$attendance_status = gmgt_get_attendence($user_id,$curremt_date);
			echo '<td>';
			echo date("D", strtotime($curremt_date));
			echo '</td>';
			
			if(!empty($attendance_status))
			{
				echo '<td>';
				echo gmgt_get_attendence($user_id,$curremt_date);
				echo '</td>';
			}
			else 
			{
				echo '<td>';
				echo __('Absent','gym_mgt');
				echo '</td>';
			}
			
			echo '</tr>';
			$curremt_date = strtotime("+1 day", strtotime($curremt_date));
			$curremt_date = date("Y-m-d", $curremt_date);
		}
	}
?>
</table>

<?php }?>
</div>
</div>
</div>
	<?php 
}
else
{ ?>
<div class="panel-body panel-white">
 <ul class="nav nav-tabs panel_tabs" role="tablist">
   <li class="<?php if($active_tab == 'memberlist') echo "active";?>">
          <a href="?dashboard=user&page=member&tab=memberlist">
             <i class="fa fa-align-justify"></i> <?php _e('Member List', 'gym_mgt'); ?></a>
          </a>
    </li>
	<?php if(isset($_REQUEST['action']) && $_REQUEST['action'] =='view')
		{ ?>
		<li class="<?php if($active_tab == 'viewmember') echo "active";?>">
      	<a href="?dashboard=user&page=member&tab=addmember">
        <i class="fa fa-plus-circle"></i> <?php		
			_e('View Member', 'gym_mgt'); 		
		?></a> 
      </li>
		<?php } 
	//if($obj_gym->role == 'staff_member'){?>
	<?php 
		//if(isset($_REQUEST['action']) && $_REQUEST['action'] =='view')
	{ ?>
	 <!--<li class="<?php if($active_tab == 'viewmember') echo "active";?>">
      	<a href="?dashboard=user&page=member&tab=addmember">
        <i class="fa fa-plus-circle"></i> <?php		
			_e('View Member', 'gym_mgt'); 		
		?></a> 
      </li>
	<?php //else{?>--->
     <!-- <li class="<?php if($active_tab == 'addmember') echo "active";?>">
      	<a href="?dashboard=user&page=member&tab=addmember">
        <i class="fa fa-plus-circle"></i> <?php
		if(isset($_REQUEST['action']) && $_REQUEST['action'] =='edit')
			_e('Edit Member', 'gym_mgt'); 
		else
			_e('Add Member', 'gym_mgt'); 
		?></a> 
      </li>-->
	  
		<?php //} 
	  }}?>
</ul>
	<div class="tab-content">
	<?php if($active_tab == 'memberlist'){?>
    	<div class="tab-pane <?php if($active_tab == 'memberlist') echo "fade active in";?>" >
		<div class="panel-body"> 
   
        <form method="post">  
   <div class="form-group col-md-3">
		<label class=""><?php _e('Member type','gym_mgt');?></label>			
		<select name="member_type" class="form-control validate[required]" id="member_type">
		<option value=""><?php  _e('Select Member Type','gym_mgt');?></option>
		<?php
			  if(isset($_POST['member_type']))
				$mtype=$_POST['member_type'];
			  else
				$mtype="";
			$membertype_array=member_type_array();
			
			if(!empty($membertype_array))
			{
				foreach($membertype_array as $key=>$type)
				{							
					echo '<option value='.$key.' '.selected($mtype,$type).'>'.$type.'</option>';
				}
			}
		?>
		</select>			
	</div>
	 <div class="form-group col-md-3 button-possition">
    	<label for="subject_id">&nbsp;</label>
      	<input type="submit" value="<?php _e('Go','gym_mgt');?>" name="filter_membertype"  class="member_filter btn btn-info"/>
    </div>
	 <?php  if(isset($_REQUEST['filter_membertype']))
			{
				if(isset($_REQUEST['member_type']) && $_REQUEST['member_type'] != "")
				{
					$member_type= $_REQUEST['member_type'];					
					
					if($obj_gym->role == 'member')
					{	
						if($user_access['own_data']=='1')
						{
							$user_id=get_current_user_id();
							$user_membershiptype= get_user_meta( $user_id, 'member_type',true ); 
							if($user_membershiptype==$member_type)
							{
								$membersdata=array();
								$membersdata[] = get_userdata($user_id);		
							}	
						}
						else
						{
							$membersdata = get_users(array('meta_key' => 'member_type', 'meta_value' =>$member_type,'role'=>'member'));
						}	
					}
					elseif($obj_gym->role == 'staff_member')
					{
						if($user_access['own_data']=='1')
						{
							$membersdata = get_users(array('meta_key' => 'member_type', 'meta_value' =>$member_type,'meta_query'=> array(array('key' => 'staff_id','value' =>$curr_user_id ,'compare' => '=')),'role'=>'member'));	
						}
						else
						{
							$membersdata = get_users(array('meta_key' => 'member_type', 'meta_value' =>$member_type,'role'=>'member'));
						}
					}
					else
					{
						$membersdata = get_users(array('meta_key' => 'member_type', 'meta_value' =>$member_type,'role'=>'member'));
					}
				}
			}	
			else 
			{
				if($obj_gym->role == 'member')
				{	
					if($user_access['own_data']=='1')
					{
						$user_id=get_current_user_id();
						$membersdata=array();
						$membersdata[] = get_userdata($user_id);			
					}
					else
					{
						$membersdata =get_users( array('role' => 'member'));
					}	
				}
				elseif($obj_gym->role == 'staff_member')
				{
					if($user_access['own_data']=='1')
					{
						$membersdata = get_users(array('meta_key' => 'staff_id', 'meta_value' =>$curr_user_id ,'role'=>'member'));		
					}
					else
					{
						//$membersdata =get_users( array('role' => 'member'));
						$membersdata = get_users(array('meta_key' => 'staff_id', 'meta_value' =>$curr_user_id ,'role'=>'member'));
					}
				}
				else
				{
					$membersdata =get_users( array('role' => 'member'));
				}				
			}
			?>
       
          </form>
		  </div>
		
		
		<div class="panel-body">
        <div class="table-responsive">
        <table id="members_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			<th style="width: 50px;height:50px;"><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
              <th><?php _e( 'Member Name', 'gym_mgt' ) ;?></th>
              <th><?php _e( 'Member Id', 'gym_mgt' ) ;?></th>
			   <th><?php _e( 'Member Type', 'gym_mgt' ) ;?></th>
			   <th><?php _e( 'Joining Date', 'gym_mgt' ) ;?></th>
			   <th><?php _e( 'Expire Date', 'gym_mgt' ) ;?></th>
				<th style="width: 50px;"><?php _e( 'Membership Status', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
			
            </tr>
        </thead>
 
        <tfoot>
            <tr>
			<th><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
              <th><?php _e( 'Member Name', 'gym_mgt' ) ;?></th>
			  <th><?php _e( 'Member Id', 'gym_mgt' ) ;?></th>
			   <th><?php _e( 'Member Type', 'gym_mgt' ) ;?></th>
			   <th><?php _e( 'Joining Date', 'gym_mgt' ) ;?></th>
			   <th><?php _e( 'Expire Date', 'gym_mgt' ) ;?></th>
			  <th><?php _e( 'Membership Status', 'gym_mgt' ) ;?></th>
				<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
			
            </tr>
           
        </tfoot>
	<tbody>
        <?php 		
		if(!empty($membersdata))
		{
		 	foreach ($membersdata as $retrieved_data)
			{	
				if($obj_gym->role == 'member')
				{					
					?>
						<tr>
							<td class="user_image"><?php $uid=$retrieved_data->ID;
										$userimage=get_user_meta($uid, 'gmgt_user_avatar', true);
									if(empty($userimage))
									{
										echo '<img src='.get_option( 'gmgt_system_logo' ).' height="50px" width="50px" class="img-circle" />';
									}
									else
										echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>';
							?></td>
							<td class="name">
							<?php if($obj_gym->role == 'staff_member'){?>	
							
							<?php echo $retrieved_data->display_name;?>
							<?php }
							else
							{?>
								<a href="#"><?php echo $retrieved_data->display_name;?></a>
							<?php }?></td>
							<td class="memberid"><?php echo $retrieved_data->member_id;?></td>
							<td class="memberid"><?php if(isset($retrieved_data->member_type))  echo $membertype_array[$retrieved_data->member_type];  else echo __('Not Selected','gym_mgt');?></td>
							<td class="joining date"><?php if($retrieved_data->member_type!='Prospect'){ echo getdate_in_input_box($retrieved_data->begin_date); }else{ echo "--"; }?></td>
							<td class="joining date"><?php if($retrieved_data->member_type!='Prospect'){ echo getdate_in_input_box(gmgt_check_membership($retrieved_data->ID)); }else{ echo "--"; }?></td>
						   <td class="status"><?php if($retrieved_data->member_type!='Prospect'){  _e($retrieved_data->membership_status,'gym_mgt'); }else{ _e('Prospect','gym_mgt');}?></td>
							<td class="action">
							<?php 
							if($obj_gym->role == 'staff_member' || ($obj_gym->role == 'member' && $retrieved_data->ID==$curr_user_id))
							{
								?>
							<a class="btn btn-success" href="?dashboard=user&page=member&tab=viewmember&action=view&member_id=<?php echo $retrieved_data->ID;?>"><?php _e('View','gym_mgt');?></a>
							<a href="?dashboard=user&page=member&tab=add_attendence&member_id=<?php echo $retrieved_data->ID;?>&attendance=1" class="btn btn-default"  idtest="<?php echo $retrieved_data->ID; ?>"><i class="fa fa-eye"></i> <?php _e('View Attendance','gym_mgt');?> </a>
							<?php }?>
							</td>
						</tr>
					<?php 					
				}
				elseif($obj_gym->role == 'staff_member')
				{					
					$havemeta = get_user_meta($retrieved_data->ID, 'gmgt_hash', true);
					
					if(!$havemeta) 
					{ ?>
						<tr>
							<td class="user_image"><?php $uid=$retrieved_data->ID;
										$userimage=get_user_meta($uid, 'gmgt_user_avatar', true);
									if(empty($userimage))
									{
										echo '<img src='.get_option( 'gmgt_system_logo' ).' height="50px" width="50px" class="img-circle" />';
									}
									else
										echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>';
							?></td>
							<td class="name">
							<?php echo $retrieved_data->display_name;?></td>
							<td class="memberid"><?php echo $retrieved_data->member_id;?></td>
							<td class="membertype"><?php echo $retrieved_data->member_type;?></td>
						   <td class="joining date"><?php if($retrieved_data->member_type!='Prospect'){ echo getdate_in_input_box($retrieved_data->begin_date); }else{ echo "--"; }?></td>
							<td class="joining date"><?php if($retrieved_data->member_type!='Prospect'){ echo getdate_in_input_box(gmgt_check_membership($retrieved_data->ID));}else{ echo "--"; }?></td>
							
							<td class="status"><?php if($retrieved_data->member_type!='Prospect'){  _e($retrieved_data->membership_status,'gym_mgt'); }else{ _e('Prospect','gym_mgt'); }?></td>
							
							<td class="action">
							
							<a class="btn btn-success" href="?dashboard=user&page=member&tab=viewmember&action=view&member_id=<?php echo $retrieved_data->ID;?>"><?php _e('View','gym_mgt');?></a>
							<a href="?dashboard=user&page=member&tab=add_attendence&member_id=<?php echo $retrieved_data->ID;?>&attendance=1" class="btn btn-default"  idtest="<?php echo $retrieved_data->ID; ?>"><i class="fa fa-eye"></i> <?php _e('View Attendance','gym_mgt');?> </a>
							
							</td>
						</tr>
					<?php 
					}					
				//}
			}
				else
				{
					$havemeta = get_user_meta($retrieved_data->ID, 'gmgt_hash', true);
					if(!$havemeta) 
					{ 
					?>
						<tr>
							<td class="user_image"><?php $uid=$retrieved_data->ID;
										$userimage=get_user_meta($uid, 'gmgt_user_avatar', true);
									if(empty($userimage))
									{
													echo '<img src='.get_option( 'gmgt_system_logo' ).' height="50px" width="50px" class="img-circle" />';
									}
									else
										echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>';
							?></td>
							<td class="name">
							<?php if($obj_gym->role == 'staff_member')
							{
								echo $retrieved_data->display_name;							
							}
							else
							{?>
								<?php echo $retrieved_data->display_name;?>
							<?php }?></td>
							<td class="memberid"><?php echo $retrieved_data->member_id;?></td>
							<td class="memberid"><?php if(isset($retrieved_data->member_type))  echo $membertype_array[$retrieved_data->member_type];  else echo __('Not Selected','gym_mgt');?></td>
						   <td class="joining date"><?php if($retrieved_data->member_type!='Prospect'){ echo getdate_in_input_box($retrieved_data->begin_date); }else{ echo "--"; }?></td>
							<td class="joining date"><?php if($retrieved_data->member_type!='Prospect'){ echo getdate_in_input_box(gmgt_check_membership($retrieved_data->ID)); }else{ echo "--"; }?></td>
						   
							<td class="status"><?php if($retrieved_data->member_type!='Prospect'){  _e($retrieved_data->membership_status,'gym_mgt'); }else{ _e('Prospect','gym_mgt');}?></td>
							
							<td class="action">
							<?php 
							if($obj_gym->role == 'staff_member' || ($obj_gym->role == 'member' && $retrieved_data->ID==$curr_user_id)){?>
							<a class="btn btn-success" href="?dashboard=user&page=member&tab=viewmember&action=view&member_id=<?php echo $retrieved_data->ID;?>"><?php _e('View','gym_mgt');?></a>
							<a href="?dashboard=user&page=member&tab=add_attendence&member_id=<?php echo $retrieved_data->ID;?>&attendance=1" class="btn btn-default"  idtest="<?php echo $retrieved_data->ID; ?>"><i class="fa fa-eye"></i> <?php _e('View Attendance','gym_mgt');?> </a>
							<?php }?>
							</td>
						</tr>
					<?php 
					}
				}
			}			
		} ?>
     
        </tbody>
        </table>
 		</div>
		</div>
		</div>
		
		<!--Member Step one information-->
		<?php }?>

<?php 
			$member_id=0;
			if(isset($_REQUEST['member_id']))
				$member_id=$_REQUEST['member_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
					
					$edit=1;
					$user_info = get_userdata($member_id);
					
				}
				else
				{
				 $lastmember_id=get_lastmember_id($role);
				$nodate=substr($lastmember_id,0,-4);
				$memberno=substr($nodate,1);
				$memberno+=1;
				$newmember='M'.$memberno.date("my");
				}?>
<?php if($active_tab == 'addmember'){?>
		<div class="tab-pane <?php if($active_tab == 'addmember') echo "fade active in";?>" >
			<div class="panel-body">
        <form name="member_form" action="" method="post" class="form-horizontal" id="member_form" enctype="multipart/form-data">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="role" value="<?php echo $role;?>"  />
		<input type="hidden" name="user_id" value="<?php echo $member_id;?>"  />
		<div class="header">	
			<h3><?php _e('Personal Information','gym_mgt');?></h3>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="member_id"><?php _e('Member Id','gym_mgt');?></label>
			<div class="col-sm-8">
				<input id="member_id" class="form-control" type="text" 
				value="<?php if($edit){ echo $user_info->member_id;}else echo $newmember;?>"  readonly name="member_id">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="first_name"><?php _e('First Name','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="first_name" class="form-control validate[required,custom[onlyLetterSp]] text-input" type="text" value="<?php if($edit){ echo $user_info->first_name;}elseif(isset($_POST['first_name'])) echo $_POST['first_name'];?>" name="first_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="middle_name"><?php _e('Middle Name','gym_mgt');?></label>
			<div class="col-sm-8">
				<input id="middle_name" class="form-control " type="text"  value="<?php if($edit){ echo $user_info->middle_name;}elseif(isset($_POST['middle_name'])) echo $_POST['middle_name'];?>" name="middle_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="last_name"><?php _e('Last Name','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="last_name" class="form-control validate[required,custom[onlyLetterSp]] text-input" type="text"  value="<?php if($edit){ echo $user_info->last_name;}elseif(isset($_POST['last_name'])) echo $_POST['last_name'];?>" name="last_name">
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
				<input id="birth_date" class="form-control date_field validate[required]" type="text"  name="birth_date" 
				value="<?php if($edit){ echo $user_info->birth_date;}elseif(isset($_POST['birth_date'])) echo $_POST['birth_date'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="class_id"><?php _e('Class','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<?php if($edit){ $class_id=$user_info->class_id; }elseif(isset($_POST['class_id'])){$class_id=$_POST['class_id'];}else{$class_id='';}?>
				<select id="class_id" class="form-control validate[required]" name="class_id">
				<option><?php _e('Select Class','gym_mgt');?></option>
			<?php $classdata=$obj_class->get_all_classes();
				 if(!empty($classdata))
				 {
					foreach ($classdata as $class){?>
						<option value="<?php echo $class->class_id;?>" <?php selected($class_id,$class->class_id);  ?>><?php echo $class->class_name; ?> </option>
			<?php } } ?>
			</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="group_id"><?php _e('Group','gym_mgt');?></label>
			<div class="col-sm-8">
				<?php if($edit){ $group_id=$user_info->group_id; }elseif(isset($_POST['group_id'])){$group_id=$_POST['group_id'];}else{$group_id='';}?>
				<select id="group_id" class="form-control" name="group_id[]" multiple="multiple">
				<option><?php _e('Select Group','gym_mgt');?></option>
				<?php $groupdata=$obj_group->get_all_groups();
				 if(!empty($groupdata))
				 {
					foreach ($groupdata as $group){?>
						<option value="<?php echo $group->id;?>" <?php selected($group_id,$group->id);  ?>><?php echo $group->group_name; ?> </option>
			<?php } } ?>
			</select>
			</div>
		</div>
		<div class="header">	<hr>
			<h3><?php _e('Contact Information','gym_mgt');?></h3>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="address"><?php _e('Address','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="address" class="form-control validate[required]" type="text"  name="address" 
				value="<?php if($edit){ echo $user_info->address;}elseif(isset($_POST['address'])) echo $_POST['address'];?>">
			</div>
		</div>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="city_name"><?php _e('City','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="city_name" class="form-control validate[required]" type="text"  name="city_name" 
				value="<?php if($edit){ echo $user_info->city_name;}elseif(isset($_POST['city_name'])) echo $_POST['city_name'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label " for="mobile"><?php _e('Mobile Number','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-1">
			
			<input type="text" readonly value="+<?php echo gmgt_get_countery_phonecode(get_option( 'gmgt_contry' ));?>"  class="form-control" name="phonecode">
			</div>
			<div class="col-sm-7">
				<input id="mobile" class="form-control validate[required,custom[phone]] text-input" type="text"  name="mobile" maxlength="10"
				value="<?php if($edit){ echo $user_info->mobile;}elseif(isset($_POST['mobile'])) echo $_POST['mobile'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label " for="phone"><?php _e('Phone','gym_mgt');?></label>
			<div class="col-sm-8">
				<input id="phone" class="form-control validate[,custom[phone]] text-input" type="text"  name="phone" 
				value="<?php if($edit){ echo $user_info->phone;}elseif(isset($_POST['phone'])) echo $_POST['phone'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label " for="email"><?php _e('Email','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="email" class="form-control validate[required,custom[email]] text-input" type="text"  name="email" 
				value="<?php if($edit){ echo $user_info->user_email;}elseif(isset($_POST['email'])) echo $_POST['email'];?>">
			</div>
		</div>
		<div class="header">	<hr>
			<h3><?php _e('Physical Information','gym_mgt');?></h3>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="weight"><?php _e('Weight','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="weight" class="form-control validate[required] text-input" type="text" value="<?php if($edit){ echo $user_info->weight;}elseif(isset($_POST['weight'])) echo $_POST['weight'];?>" name="weight">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="height"><?php _e('Height','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="height" class="form-control validate[required] text-input" type="text" value="<?php if($edit){ echo $user_info->height;}elseif(isset($_POST['height'])) echo $_POST['height'];?>" name="height">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="Chest"><?php _e('Chest','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="Chest" class="form-control validate[required] text-input" type="text" value="<?php if($edit){ echo $user_info->chest;}elseif(isset($_POST['chest'])) echo $_POST['chest'];?>" name="chest">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="Waist"><?php _e('Waist','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="waist" class="form-control validate[required] text-input" type="text" value="<?php if($edit){ echo $user_info->waist;}elseif(isset($_POST['waist'])) echo $_POST['waist'];?>" name="waist">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="thigh"><?php _e('Thigh','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="thigh" class="form-control validate[required] text-input" type="text" value="<?php if($edit){ echo $user_info->thigh;}elseif(isset($_POST['thigh'])) echo $_POST['thigh'];?>" name="thigh">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="arms"><?php _e('Arms','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="arms" class="form-control validate[required] text-input" type="text" value="<?php if($edit){ echo $user_info->arms;}elseif(isset($_POST['arms'])) echo $_POST['arms'];?>" name="arms">
			</div>
		</div>
		<div class="header">
			<hr>
			<h3><?php _e('Login Information','gym_mgt');?></h3>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="username"><?php _e('User Name','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="username" class="form-control validate[required]" type="text"  name="username" 
				value="<?php if($edit){ echo $user_info->user_login;}elseif(isset($_POST['username'])) echo $_POST['username'];?>" <?php if($edit) echo "readonly";?>>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="password"><?php _e('Password','gym_mgt');?><?php if(!$edit) {?><span class="require-field">*</span><?php }?></label>
			<div class="col-sm-8">
				<input id="password" class="form-control <?php if(!$edit) echo 'validate[required]';?>" type="password"  name="password" value="">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="photo"><?php _e('Image','gym_mgt');?></label>
			<div class="col-sm-2">
				<input type="text" id="gmgt_user_avatar_url" class="form-control" name="gmgt_user_avatar"  
				value="<?php if($edit)echo esc_url( $user_info->gmgt_user_avatar );elseif(isset($_POST['gmgt_user_avatar'])) echo $_POST['gmgt_user_avatar']; ?>" />
			</div>	
			<div class="col-sm-3">
				<input type="hidden" name="hidden_upload_user_avatar_image" value="<?php if($edit){ echo $user_info->gmgt_user_avatar;}elseif(isset($_POST['upload_user_avatar_image'])) echo $_POST['upload_user_avatar_image'];?>">
       				 <input id="upload_user_avatar_image" name="upload_user_avatar_image" type="file" class="form-control file" value="<?php _e( 'Upload image', 'gym_mgt' ); ?>" />
       		</div>
			<div class="clearfix"></div>
			
			<div class="col-sm-offset-2 col-sm-8">
                     <div id="upload_user_avatar_preview" >
	                     <?php if($edit) 
	                     	{
	                     	if($user_info->gmgt_user_avatar == "")
	                     	{?>
	                     	<img alt="" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">
	                     	<?php }
	                     	else {
	                     		?>
					        <img style="max-width:100%;" src="<?php if($edit)echo esc_url( $user_info->gmgt_user_avatar ); ?>" />
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
		
		
		<div class="header">	<hr>
			<h3><?php _e('More Information','gym_mgt');?></h3>
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
					
				$staff_data=$user_info->staff_id;
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
			<label class="col-sm-2 control-label" for="intrest"><?php _e('Intrest Area','gym_mgt');?></label>
			<div class="col-sm-8">
			
				<select class="form-control" name="intrest_area" id="intrest_area">
				<option value=""><?php _e('Select Intrest','gym_mgt');?></option>
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
			<label class="col-sm-2 control-label" for="Source"><?php _e('Source','gym_mgt');?></label>
			<div class="col-sm-8">
			
				<select class="form-control" name="source" id="source">
				<option value=""><?php _e('Select Source','gym_mgt');?></option>
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
			<label class="col-sm-2 control-label" for="refered"><?php _e('Reffered By','gym_mgt');?></label>
			<div class="col-sm-8">
				<?php $get_staff = array('role' => 'Staff_member');
					$staffdata=get_users($get_staff);?>
				<select name="reference_id" class="form-control" id="reference_id">
				<option value=""><?php  _e('Select Reffered Member ','gym_mgt');?></option>
				<?php 
					if($edit)
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
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="inqiury_date"><?php _e('Inquiry Date','gym_mgt');?></label>
			<div class="col-sm-8">
				<input id="inqiury_date" class="form-control date_field" type="text"  name="inqiury_date" 
				value="<?php if($edit){ echo $user_info->inqiury_date;}elseif(isset($_POST['inqiury_date'])) echo $_POST['inqiury_date'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="triel_date"><?php _e('Triel End Date','gym_mgt');?></label>
			<div class="col-sm-8">
				<input id="triel_date" class="form-control date_field" type="text"  name="triel_date" 
				value="<?php if($edit){ echo $user_info->triel_date;}elseif(isset($_POST['triel_date'])) echo $_POST['triel_date'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="membership"><?php _e('Membership','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<?php 	$membershipdata=$obj_membership->get_all_membership();?>
				<select name="membership_id" class="form-control validate[required] " id="membership_id">
				<option value=""><?php  _e('Select Membership ','gym_mgt');?></option>
				<?php 
					
				$staff_data=$user_info->membership_id;
					if(!empty($membershipdata))
					 {
						foreach ($membershipdata as $membership){
					
						
						echo '<option value='.$membership->membership_id.' '.selected($staff_data,$membership->membership_id).'>'.$membership->membership_label.'</option>';
					}
					}
					?>
				</select>
			</div>
		</div>
		<?php if($edit)
		{?>
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
		<?php }?>
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
		<div class="form-group">
			<label class="col-sm-2 control-label" for="begin_date"><?php _e('Begin Date','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="begin_date" class="form-control date_field validate[required]" type="text" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>"  name="begin_date" 
				value="<?php if($edit){ echo $user_info->begin_date;}elseif(isset($_POST['begin_date'])) echo $_POST['begin_date'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="first_payment_date"><?php _e('First Payment Date','gym_mgt');?></label>
			<div class="col-sm-8">
				<input id="first_payment_date" class="form-control date_field" type="text"  name="first_payment_date" 
				value="<?php if($edit){ echo $user_info->first_payment_date;}elseif(isset($_POST['first_payment_date'])) echo $_POST['first_payment_date'];?>">
			</div>
		</div>
		
		
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','gym_mgt'); }else{ _e('Save Member','gym_mgt');}?>" name="save_member" class="btn btn-success"/>
        </div>
		
		
		
        </form>
        </div>
		</div>
		<?php }?>
		<!--Member Step two information-->
		<?php if($active_tab == 'viewmember'){?>
		<div class="tab-pane <?php if($active_tab == 'viewmember') echo "fade active in";?>" >
			<?php require_once GMS_PLUGIN_DIR. '/template/view_member.php';?>
		</div>
		<?php }?>

	</div>
</div>
<?php ?>