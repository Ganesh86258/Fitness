<?php 
$obj_membership=new MJ_Gmgtmembership;
$obj_activity=new MJ_Gmgtactivity;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'membershiplist';
?>

<!-- POP up code -->
<div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="category_list"></div>     
		</div>
    </div>    
</div>
<!-- End POP-UP Code -->
<div class="page-inner" style="min-height:1631px !important">
<div class="page-title">
		<h3><img src="<?php echo get_option( 'gmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'gmgt_system_name' );?></h3>
</div>
<?php 	
	if(isset($_POST['save_membership']))
	{	
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{
			$txturl=$_POST['gmgt_membershipimage'];
			$ext=check_valid_extension($txturl);
			if(!$ext == 0)
			{	
				$result=$obj_membership->gmgt_add_membership($_POST,$_POST['gmgt_membershipimage']);
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=gmgt_membership_type&tab=membershiplist&message=2');
				}
			}
			else
			{ ?>
				<div id="message" class="updated below-h2 ">
				<p>
					<?php _e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?>
				</p></div>				 
				<?php 
			}				
		}
		else
		{
			$txturl=$_POST['gmgt_membershipimage'];
			$ext=check_valid_extension($txturl);
			if(!$ext == 0)
			{
				$result=$obj_membership->gmgt_add_membership($_POST,$_POST['gmgt_membershipimage']);
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=gmgt_membership_type&tab=membershiplist&message=1&membershipid='.$result);
				}
			}
			else
			{ ?>
				<div id="message" class="updated below-h2 ">
				<p>
					<?php _e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?>
				</p></div>				 
				<?php 
			}			
		}
	} 
	if(isset($_POST['add_activities']))
	{
		$membershipid='&tab=membershiplist&message=1';
		if(isset($_POST['membership_id']))
			$membershipid="&tab=view-activity&membership_id=".$_POST['membership_id']."&message=1";
		$result=$obj_activity->add_membership_activities($_POST);	
		if($result)
		{
			wp_redirect ( admin_url().'admin.php?page=gmgt_membership_type'.$membershipid);
		}
	}
		
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
			{
				
				$result=$obj_membership->delete_membership($_REQUEST['membership_id']);
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=gmgt_membership_type&tab=membershiplist&message=3');
				}
			}
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete-activity')
			{
				$membershipid='&tab=membershiplist&message=3';
				if(isset($_REQUEST['membership_id']))
					$membershipid="&tab=view-activity&membership_id=".$_REQUEST['membership_id']."&message=3";
				$result=$obj_activity->delete_membership_activity($_REQUEST['assign_id']);
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=gmgt_membership_type'.$membershipid);
				}
			}	
			$valtemp=0;
			$newmembershipid=0;
	if(isset($_REQUEST['message']))
	{
		$message =$_REQUEST['message'];
		if($message == 1)
		{ 
			$valtemp=$_REQUEST['message'];
			$newmembershipid=isset($_REQUEST['membershipid'])?$_REQUEST['membershipid']:0;
			?>
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
	<div id="main-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-white">
					<div class="panel-body">
	<h2 class="nav-tab-wrapper">
    	<a href="?page=gmgt_membership_type&tab=membershiplist" class="nav-tab <?php echo $active_tab == 'membershiplist' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Membership List', 'gym_mgt'); ?></a>
    	
        <?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{?>
        <a href="?page=gmgt_membership_type&tab=addmembership&&action=edit&membership_id=<?php echo $_REQUEST['membership_id'];?>" class="nav-tab <?php echo $active_tab == 'addmembership' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Membership', 'gym_mgt'); ?></a>  
		<?php 
		}
		else
		{?>
			<a href="?page=gmgt_membership_type&tab=addmembership" class="nav-tab <?php echo $active_tab == 'addmembership' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Membership', 'gym_mgt'); ?></a>  
		<?php  }
		if(isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'view-activity'){ ?>
         <a href="?page=gmgt_membership_type&tab=view-activity" class="nav-tab <?php echo $active_tab == 'view-activity' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('View Activity', 'gym_mgt'); ?></a>
		<?php } ?>
    </h2>
     <?php 
	//Report 1 
	if($active_tab == 'membershiplist')
	{ 
	
	?>	
    <script type="text/javascript">
$(document).ready(function() {
	
	jQuery('#membership_list').DataTable({
		"responsive": true,
		"order": [[ 1, "asc" ]],
		"aoColumns":[
	                  {"bSortable": false},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": false}]
		});
		var tempval=<?php echo $valtemp;?>;
		if(tempval==1){
		swal({
						title: "Successfully inserted!",
						text: "Do you Want to Add New Activity?",
						type: "warning",
						showCancelButton: true,
						confirmButtonColor: '#22baa0',
						confirmButtonText: 'Yes',
						cancelButtonText: "No",
						closeOnConfirm: false,
						closeOnCancel: true
					},
						function(isConfirm){
						if (isConfirm){
							window.location.href = "<?php echo admin_url().'admin.php?page=gmgt_activity&tab=addactivity&membership_id='.$newmembershipid; ?>";
						} else {
							tempval=0;
						 window.location.href = "<?php echo admin_url().'admin.php?page=gmgt_membership_type&tab=membershiplist';?>";
						}
					});
		}
	
} );
</script>
    <form name="wcwm_report" action="" method="post">
    
        <div class="panel-body">
        	<div class="table-responsive">
        <table id="membership_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			<th style="width: 50px;height:50px;"><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Membership Name', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Membership Short Code', 'gym_mgt' ) ;?></th>
              <th><?php _e( 'Membership Period', 'gym_mgt' ) ;?></th>
			  <th> <?php _e( 'Installment Plan', 'gym_mgt' ) ;?></th>
				<th> <?php _e( 'Signup Fee', 'gym_mgt' ) ;?></th>
                <th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
			<th><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Membership Name', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Membership Short Code', 'gym_mgt' ) ;?></th>
              <th><?php _e( 'Membership Period', 'gym_mgt' ) ;?></th>
			  <th> <?php _e( 'Installment Plan', 'gym_mgt' ) ;?></th>
				<th> <?php _e( 'Signup Fee', 'gym_mgt' ) ;?></th>
                <th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
            </tr>
        </tfoot>
 
        <tbody>
         <?php $membershipdata=$obj_membership->get_all_membership();
		 if(!empty($membershipdata))
		 {
		 	foreach ($membershipdata as $retrieved_data){ ?>
            <tr>
				<td class="user_image"><?php $userimage=$retrieved_data->gmgt_membershipimage;
							
						if(empty($userimage))
						{
								echo '<img src='.get_option( 'gmgt_system_logo' ).' height="25px" width="25px" class="img-circle" />';
						}
						else
							echo '<img src='.$userimage.' height="25px" width="25px" class="img-circle"/>';
				?></td>
				<td class="membershipname"><a href="?page=gmgt_membership_type&tab=addmembership&action=edit&membership_id=<?php echo $retrieved_data->membership_id;?>"><?php echo $retrieved_data->membership_label;?></a></td>
                <td class="membershipshortcode"><?php echo "[MembershipCode id=".$retrieved_data->membership_id."]";?></td>
                <td class="membershiperiod"><?php echo $retrieved_data->membership_length_id;?></td>
                <td class="installmentplan"><?php echo $retrieved_data->installment_amount." ".get_the_title( $retrieved_data->install_plan_id );?></td>
				<td class="signup_fee"><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); echo $retrieved_data->signup_fee;?></td>
               	<td class="action"> <a href="?page=gmgt_membership_type&tab=addmembership&action=edit&membership_id=<?php echo $retrieved_data->membership_id?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
                <a href="?page=gmgt_membership_type&tab=membershiplist&action=delete&membership_id=<?php echo $retrieved_data->membership_id;?>" class="btn btn-danger" 
                onclick="return confirm('<?php _e('Do you really want to delete this record?','gym_mgt');?>');">
                <?php _e( 'Delete', 'gym_mgt' ) ;?> </a>
                <a href="?page=gmgt_membership_type&tab=view-activity&membership_id=<?php echo $retrieved_data->membership_id?>" class="btn btn-success"> 
				<?php _e('View Activities', 'gym_mgt' );?></a>
                </td>
               
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
	
	if($active_tab == 'addmembership')
	 {
		require_once GMS_PLUGIN_DIR. '/admin/membership/add_membership.php';
	 }
	 if($active_tab == 'view-activity')
	 {
	   require_once GMS_PLUGIN_DIR. '/admin/membership/view-activity.php';
	 } 
	 ?>
</div>
			
	</div>
	</div>
</div>


<?php //} ?>