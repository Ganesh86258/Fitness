<?php $curr_user_id=get_current_user_id();
$obj_gym=new MJ_Gym_management($curr_user_id);
$obj_membership=new MJ_Gmgtmembership;
$obj_class=new MJ_Gmgtclassschedule;
$obj_group=new MJ_Gmgtgroup;
$obj_member=new MJ_Gmgtmember;?>

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
if(isset($_REQUEST['action'] ) && $_REQUEST['action']=='approve')
{
	if( get_user_meta($_REQUEST['member_id'], 'gmgt_hash', true))
		{
			
			if(get_user_meta($_REQUEST['member_id'], 'gmgt_hash', true) == $_REQUEST['haskey'])
			{				
				$result=delete_user_meta($_REQUEST['member_id'], 'gmgt_hash');
				if($result)
					wp_redirect ( admin_url().'admin.php?page=gmgt_member&tab=memberlist&message=4');
			}
		}
}
if(isset($_REQUEST['attendance']) && $_REQUEST['attendance'] == 1)
{
?>
<script type="text/javascript">
$(document).ready(function() {
	
	$('.sdate').datepicker({dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>'}); 
	$('.edate').datepicker({dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>'}); 

 
} );
</script>
<div class="page-inner" style="min-height:1631px !important">
	<div class="page-title"> 
		<h3><img src="<?php echo get_option( 'gmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'gmgt_system_name' );?></h3>
	</div>
	<div id="main-wrapper">
		<div class="row">
			<div class="panel panel-white">
				<div class="panel-body">
				<h2 class="nav-tab-wrapper">
			    	<a href="?page=smgt_student&attendance=1" class="nav-tab nav-tab-active">
					<?php echo '<span class="dashicons dashicons-menu"></span>'.__('View Attendance', 'gym_mgt'); ?></a>
				</h2>
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
	$attendance = gmgt_view_member_attendance($start_date,$end_date,$user_id);
	
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
	</div>
</div>
<?php 

}
else
{
	$active_tab = isset($_GET['tab'])?$_GET['tab']:'memberlist';
	?>
<div class="page-inner" style="min-height:1631px !important">
<div class="page-title">
		<h3><img src="<?php echo get_option( 'gmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'gmgt_system_name' );?></h3>
	</div>
	<?php 
	
	if(isset($_POST['save_member']))
	{
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{
			
			$result=$obj_member->gmgt_add_user($_POST);
			if($result)
			{
				//wp_redirect ( admin_url().'admin.php?page=gmgt_member&tab=addmember_step2&action=edit&member_id='.$result);
				wp_redirect ( admin_url().'admin.php?page=gmgt_member&tab=memberlist&message=2');
			}
				
				
		}
		else
		{
			if( !email_exists( $_POST['email'] ) && !username_exists( $_POST['username'] )) {
	
				$result=$obj_member->gmgt_add_user($_POST);
					
				if($result>0)
				{
					wp_redirect ( admin_url() . 'admin.php?page=gmgt_member&tab=memberlist&message=1');
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
					wp_redirect ( admin_url().'admin.php?page=gmgt_member&tab=memberlist&message=3');
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
		elseif($message == 4) 
		{?>
		<div id="message" class="updated below-h2"><p>
		<?php 
			_e('Member successfully Approved','gym_mgt');
		?></div></p><?php
				
		}
	}?>
	<div id="main-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-white">
					<div class="panel-body">
	<h2 class="nav-tab-wrapper">
    	<a href="?page=gmgt_alumni&tab=memberlist" class="nav-tab <?php echo $active_tab == 'memberlist' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Member List', 'gym_mgt'); ?></a>
    	
        <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view')
		{ ?>
			
		<a href="?page=gmgt_alumni&tab=viewmember&action=view&member_id=<?php echo $_REQUEST['member_id'];?>" class="nav-tab <?php echo $active_tab == 'viewmember' ? 'nav-tab-active' : ''; ?>">
		<?php _e('View Member', 'gym_mgt'); ?></a>  
			<?php 
		} ?>
       
    </h2>
     <?php 
	//Report 1 
	if($active_tab == 'memberlist')
	{ 
	
	?>	
    <script type="text/javascript">
$(document).ready(function() {
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
	                  //{"bSortable": true},
	                {"bSortable": false}
					 ]
		});
} );
</script>
    <form name="member_form" action="" method="post">
    
        <div class="panel-body">
        	<div class="table-responsive">
        <table id="members_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			<th style="width: 50px;height:50px;"><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
              <th><?php _e( 'Member Name', 'gym_mgt' ) ;?></th>
              <th><?php _e( 'Member Id', 'gym_mgt' ) ;?></th>
			   <th><?php _e( 'Joining Date', 'gym_mgt' ) ;?></th>
			   <th><?php _e( 'Expire Date', 'gym_mgt' ) ;?></th>
			   <!--<th><?php _e( 'Class', 'gym_mgt' ) ;?></th>-->
			    <th style="width: 50px;"><?php _e( 'Membership Status', 'gym_mgt' ) ;?></th>
				<!--<th> <?php _e( 'Member Email', 'gym_mgt' ) ;?></th>
				<th> <?php _e( 'Mobile No', 'gym_mgt' ) ;?></th>-->
                <th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
			<th><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
              <th><?php _e( 'Member Name', 'gym_mgt' ) ;?></th>
              <th><?php _e( 'Member Id', 'gym_mgt' ) ;?></th>
			   <th><?php _e( 'Joining Date', 'gym_mgt' ) ;?></th>
			   <th><?php _e( 'Expire Date', 'gym_mgt' ) ;?></th>
			   <!--<th><?php _e( 'Class', 'gym_mgt' ) ;?></th>-->
			   <th><?php _e( 'Membership Status', 'gym_mgt' ) ;?></th>
				<!--<th> <?php _e( 'Member Email', 'gym_mgt' ) ;?></th>
				<th> <?php _e( 'Mobile No', 'gym_mgt' ) ;?></th>-->
                <th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
            </tr>
           
        </tfoot>
 
        <tbody>
         <?php 
		$get_members = array('meta_key'=>'member_type','meta_value'=>'Alumni','role' => 'member');
			$membersdata=get_users($get_members);
		 if(!empty($membersdata))
		 {
		 	foreach ($membersdata as $retrieved_data){
				
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
                <td class="name"><a href="#"><?php echo $retrieved_data->display_name;?></a></td>
				<td class="memberid"><?php echo $retrieved_data->member_id;?></td>
                <td class="joining date"><?php echo getdate_in_input_box($retrieved_data->begin_date);?></td>
                
				<td class="joining date"><?php echo getdate_in_input_box(gmgt_check_membership($retrieved_data->ID));?></td>
                <!--<td class="class"><?php $classdata=$obj_class->get_single_class($retrieved_data->class_id);
				echo $classdata->class_name;?></td>-->
				<td class="status"><?php echo $retrieved_data->membership_status;?></td>
				<!--<td class="email"><?php echo $retrieved_data->user_email;?></td>-->
               <!-- <td class="mobile"><?php echo $retrieved_data->mobile;?></td>-->

            <td class="action"> 
               	   <a href="?page=gmgt_alumni&tab=viewmember&action=view&member_id=<?php echo $retrieved_data->ID?>" class="btn btn-success"> <?php _e('View', 'gym_mgt' ) ;?></a>
               	<!--	<a href="?page=gmgt_member&tab=addmember&action=edit&member_id=<?php echo $retrieved_data->ID?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
                <a href="?page=gmgt_member&tab=memberlist&action=delete&member_id=<?php echo $retrieved_data->ID;?>" class="btn btn-danger" 
                onclick="return confirm('<?php _e('Do you really want to delete this record?','gym_mgt');?>');">
                <?php _e( 'Delete', 'gym_mgt' ) ;?> </a>
                <a href="?page=gmgt_member&view_member&member_id=<?php echo $retrieved_data->ID;?>&attendance=1" class="btn btn-default" 
				idtest="<?php echo $retrieved_data->ID; ?>"><i class="fa fa-eye"></i> <?php _e(' View Attendance','gym_mgt');?></a>
				idtest="<?php echo $retrieved_data->ID; ?>"><i class="fa fa-eye"></i> <?php _e(' View Attendance','gym_mgt');?></a>
				<?php if(get_user_meta($retrieved_data->ID, 'gmgt_hash', true)!=''){?>
				<!--<a href="?page=gmgt_member&tab=memberlist&action=approve&haskey=<?php echo get_user_meta($retrieved_data->ID, 'gmgt_hash', true);?>&member_id=<?php echo $retrieved_data->ID?>" class="btn btn-info"> <?php _e('Approve', 'gym_mgt' ) ;?></a>-->
				<!--<a href="?page=gmgt_member&tab=addmember&action=edit&member_id=<?php echo $retrieved_data->ID?>" class="btn btn-info"> <?php _e('Approve', 'gym_mgt' ) ;?></a>
				<?php } ?>
                </td>-->
               
            </tr>
            <?php } 
			
		}?>
     
        </tbody>
        
        </table>
        </div>
        </div>
       
</form>
     <?php 
	 }
	 if($active_tab == 'viewmember')
	 {
	 	require_once GMS_PLUGIN_DIR. '/admin/alumni/view_member.php';
	 }
	 ?>
</div>
			
	</div>
	</div>
</div>


<?php } ?>