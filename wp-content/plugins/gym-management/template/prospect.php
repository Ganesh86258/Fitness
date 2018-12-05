<?php $curr_user_id=get_current_user_id();
$obj_gym=new MJ_Gym_management($curr_user_id);
$obj_membership=new MJ_Gmgtmembership;
$obj_class=new MJ_Gmgtclassschedule;
$obj_group=new MJ_Gmgtgroup;
$obj_member=new MJ_Gmgtmember;
$role="member";
$active_tab = isset($_GET['tab'])?$_GET['tab']:'memberlist';

	if(isset($_POST['save_member']))		
	{
		
		if(isset($_FILES['upload_user_avatar_image']) && !empty($_FILES['upload_user_avatar_image']) && $_FILES['upload_user_avatar_image']['size'] !=0)
		{
			
			if($_FILES['upload_user_avatar_image']['size'] > 0)
						 $member_image=load_documets($_FILES['upload_user_avatar_image'],'upload_user_avatar_image','pimg');
						$member_image_url=content_url().'/uploads/gym_assets/'.$member_image;
		}
		else{
			
			if(isset($_REQUEST['hidden_upload_user_avatar_image']))
							$member_image=$_REQUEST['hidden_upload_user_avatar_image'];
						$member_image_url=$member_image;
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

<script type="text/javascript">
$(document).ready(function() {
	$('.date_field').datepicker({
		  changeMonth: true,
	        changeYear: true,
	        yearRange:'-65:+0',
	        onChangeMonthYear: function(year, month, inst) {
	            $(this).val(month + "/" + year);
	        }
                    
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
	 <?php if($obj_gym->role == 'staff_member')?>
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
    <div class="category_list">
     </div>
     
    </div>
    </div> 
    
</div>
<!-- End POP-UP Code -->
<?php 

if(isset($_REQUEST['attendance']) && $_REQUEST['attendance'] == 1)
{?>
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
       
					
            	<input type="text"  class="form-control sdate" name="sdate" 
				value="<?php if(isset($_REQUEST['sdate'])) echo $_REQUEST['sdate'];
				else echo getdate_in_input_box(date('Y-m-d'));?>">
            	
    </div>
    <div class="form-group col-md-3">
    	<label for="exam_id"><?php _e('End Date','gym_mgt');?></label>
			<input type="text"  class="form-control edate" name="edate" 
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
	$start_date = date('Y-m-d',strtotime($_REQUEST['sdate']));
	$end_date = date('Y-m-d',strtotime($_REQUEST['edate']));
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
          <a href="?dashboard=user&page=prospect&tab=memberlist">
             <i class="fa fa-align-justify"></i> <?php _e('Prospect List', 'gym_mgt'); ?></a>
          </a>
      </li>
	<?php if($obj_gym->role == 'staff_member'){?>
	<?php 
		if(isset($_REQUEST['action']) && $_REQUEST['action'] =='view')
	{?>
	 <li class="<?php if($active_tab == 'viewmember') echo "active";?>">
      	<a href="?dashboard=user&page=prospect&tab=addmember">
        <i class="fa fa-plus-circle"></i> <?php		
			_e('View Prospect', 'gym_mgt'); 		
		?></a> 
      </li>
	<?php }
	  }}?>
</ul>
	<div class="tab-content">
	<?php if($active_tab == 'memberlist'){?>
    	<div class="tab-pane <?php if($active_tab == 'memberlist') echo "fade active in";?>" >
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
		
		// $get_members = array('role' => 'member');
		 $get_members = array('meta_key'=>'member_type','meta_value'=>'Alumni','role' => 'member');
			$membersdata=get_users($get_members);
		
		 if(!empty($membersdata))
		 {
		 	foreach ($membersdata as $retrieved_data)
			{
				if(get_option('gym_enable_memberlist_for_member')=='no' && $obj_gym->role == 'member')
				{
					if($curr_user_id==$retrieved_data->ID)
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
				<?php if($obj_gym->role == 'staff_member'){?>
				
				
                <a href="#"><?php echo $retrieved_data->display_name;?></a>
				<?php }
				else
				{?>
					<a href="#"><?php echo $retrieved_data->display_name;?></a>
				<?php }?></td>
				<td class="memberid"><?php echo $retrieved_data->member_id;?></td>
				<td class="membertype"><?php echo $retrieved_data->member_type;?></td>
                <td class="joining date"><?php echo getdate_in_input_box($retrieved_data->begin_date);?></td>
                <td class="joining date"><?php echo getdate_in_input_box(gmgt_check_membership($retrieved_data->ID));?></td>
               <td class="status"><?php echo $retrieved_data->membership_status;?></td>
				<td class="action">
				<?php 
				if($obj_gym->role == 'staff_member' || ($obj_gym->role == 'member' && $retrieved_data->ID==$curr_user_id)){
					?>
				<a class="btn btn-success" href="?dashboard=user&page=prospect&tab=viewmember&action=view&member_id=<?php echo $retrieved_data->ID;?>"><?php _e('View','gym_mgt');?></a>
				<a href="?dashboard=user&page=prospect&tab=add_attendence&member_id=<?php echo $retrieved_data->ID;?>&attendance=1" class="btn btn-default"  idtest="<?php echo $retrieved_data->ID; ?>"><i class="fa fa-eye"></i> <?php _e('View Attendance','gym_mgt');?> </a>
				<?php }?>
				</td>
            </tr>
				<?php }
				}
				else
				{
					$havemeta = get_user_meta($retrieved_data->ID, 'gmgt_hash', true);
					if(!$havemeta) { ?>
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
				
				
                <a href="?dashboard=user&page=member&tab=addmember&action=edit&member_id=<?php echo $retrieved_data->ID;?>"><?php echo $retrieved_data->display_name;?></a>
				<?php }
				else
				{?>
					<a href="#"><?php echo $retrieved_data->display_name;?></a>
				<?php }?></td>
				<td class="memberid"><?php echo $retrieved_data->member_id;?></td>
               <td class="joining date"><?php echo getdate_in_input_box($retrieved_data->begin_date);?></td>
                <td class="joining date"><?php echo getdate_in_input_box(gmgt_check_membership($retrieved_data->ID));?></td>
                <!--<td class="class"><?php $classdata=$obj_class->get_single_class($retrieved_data->class_id);
				echo $classdata->class_name;?></td>-->
				<td class="status"><?php echo $retrieved_data->membership_status;?></td>
				<!--<td class="email"><?php echo $retrieved_data->user_email;?></td>
                <td class="mobile"><?php echo $retrieved_data->mobile;?></td>-->
				<td class="action">
				
				
				<?php if($obj_gym->role == 'staff_member'){?>
				
               	<!-- <a href="?dashboard=user&page=member&tab=addmember&action=edit&member_id=<?php echo $retrieved_data->ID?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
                <a href="?dashboard=user&page=member&tab=memberlist&action=delete&member_id=<?php echo $retrieved_data->ID;?>" class="btn btn-danger" 
                onclick="return confirm('<?php _e('Do you really want to delete this record?','gym_mgt');?>');">
                <?php _e( 'Delete', 'gym_mgt' ) ;?> </a>-->
                
				<?php } 
				if($obj_gym->role == 'staff_member' || ($obj_gym->role == 'member' && $retrieved_data->ID==$curr_user_id)){?>
				<a class="btn btn-success" href="?dashboard=user&page=prospect&tab=viewmember&action=view&member_id=<?php echo $retrieved_data->ID;?>"><?php _e('View','gym_mgt');?></a>
				<a href="?dashboard=user&page=prospect&tab=add_attendence&member_id=<?php echo $retrieved_data->ID;?>&attendance=1" class="btn btn-default"  idtest="<?php echo $retrieved_data->ID; ?>"><i class="fa fa-eye"></i> <?php _e('View Attendance','gym_mgt');?> </a>
				<?php }?>
				</td>
            </tr>
					<?php }
				}
			} 
			
		}?>
     
        </tbody>
        </table>
 		</div>
		</div>
		</div>
		
		<!--Member Step one information-->
		<?php } 
		if($active_tab == 'viewmember'){?>
		<div class="tab-pane <?php if($active_tab == 'viewmember') echo "fade active in";?>" >
			<?php require_once GMS_PLUGIN_DIR. '/template/view_member.php';?>
		</div>
		<?php }?>
	</div>
</div>
<?php ?>