<?php 
$obj_membership=new MJ_Gmgtmembership;
$obj_activity=new MJ_Gmgtactivity;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'activitylist';
?>
<!-- POP up code -->
<div class="popup-bg" style="z-index:100000 !important;">
    <div class="overlay-content">
		<div class="modal-content">
		   <div class="category_list"> </div>
        </div>
    </div> 
</div>
<!-- End POP-UP Code -->
<div class="page-inner" style="min-height:1631px !important">
    <div class="page-title">
		<h3><img src="<?php echo get_option( 'gmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'gmgt_system_name' );?></h3>
	</div>
	<?php 
	if(isset($_POST['save_activity']))
	{
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{
				
			$result=$obj_activity->gmgt_add_activity($_POST);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=gmgt_activity&tab=activitylist&message=2');
			}
		}
		else
		{
			$result=$obj_activity->gmgt_add_activity($_POST);
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=gmgt_activity&tab=activitylist&message=1');
				}
			}
	}
	
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
	{
			
		$result=$obj_activity->delete_activity($_REQUEST['activity_id']);
		if($result)
		{
			wp_redirect ( admin_url().'admin.php?page=gmgt_activity&tab=activitylist&message=3');
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
	<div id="main-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-white">
					<div class="panel-body">
							<h2 class="nav-tab-wrapper">
								<a href="?page=gmgt_activity&tab=activitylist" class="nav-tab <?php echo $active_tab == 'activitylist' ? 'nav-tab-active' : ''; ?>">
								<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Training List', 'gym_mgt'); ?></a>
								
								<?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
								{?>
								<a href="?page=gmgt_activity&tab=addactivity&&action=edit&activity_id=<?php echo $_REQUEST['activity_id'];?>" class="nav-tab <?php echo $active_tab == 'addactivity' ? 'nav-tab-active' : ''; ?>">
								<?php _e('Edit Activity', 'gym_mgt'); ?></a>  
								<?php 
								}
								else
								{?>
									<a href="?page=gmgt_activity&tab=addactivity" class="nav-tab <?php echo $active_tab == 'addactivity' ? 'nav-tab-active' : ''; ?>">
								<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Training', 'gym_mgt'); ?></a>
									
								<?php  }?>
							</h2>
							 <?php 
							//Report 1 
							if($active_tab == 'activitylist')
							{ 
							?>	
						    <script type="text/javascript">
								$(document).ready(function() {
									jQuery('#activity_list').DataTable({
										"responsive": true,
										"order": [[ 0, "asc" ]],
										"aoColumns":[
													  {"bSortable": true},
													  {"bSortable": true},
													  {"bSortable": true},
													  {"bSortable": false}]
										});
								} );
						    </script>
							<form name="wcwm_report" action="" method="post">
								<div class="panel-body">
									<div class="table-responsive">
										<table id="activity_list" class="display" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th><?php  _e( 'Training Name', 'gym_mgt' ) ;?></th>
													<th><?php  _e( 'Training Category', 'gym_mgt' ) ;?></th>
													<th><?php  _e( 'Trainer', 'gym_mgt' ) ;?></th>
													<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
												</tr>
										    </thead>
											<tfoot>
												<tr>
													<th><?php  _e( 'Training Name', 'gym_mgt' ) ;?></th>
													<th><?php  _e( 'Training Category', 'gym_mgt' ) ;?></th>
													<th><?php  _e( 'Trainer', 'gym_mgt' ) ;?></th>
													<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
												</tr>
											</tfoot>
											<tbody>
											<?php 
											$activitydata=$obj_activity->get_all_activity();
											if(!empty($activitydata))
											{
												foreach ($activitydata as $retrieved_data){ ?>
												<tr>
													<td class="activityname"><a href="?page=gmgt_activity&tab=addactivity&action=edit&activity_id=<?php echo $retrieved_data->activity_id;?>"><?php echo $retrieved_data->activity_title;?></a></td>
													<td class="category"><?php echo get_the_title($retrieved_data->activity_cat_id);?></td>
													<td class="productquentity"><?php $user=get_userdata($retrieved_data->activity_assigned_to);
													echo $user->display_name;?></td>
													
													<td class="action"> <a href="?page=gmgt_activity&tab=addactivity&action=edit&activity_id=<?php echo $retrieved_data->activity_id?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
													<a href="?page=gmgt_activity&tab=activitylist&action=delete&activity_id=<?php echo $retrieved_data->activity_id;?>" class="btn btn-danger" 
													onclick="return confirm('<?php _e('Do you really want to delete this record?','gym_mgt');?>');">
													<?php _e( 'Delete', 'gym_mgt' ) ;?> </a>
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
							if($active_tab == 'addactivity')
							 {
							   require_once GMS_PLUGIN_DIR. '/admin/activity/add_activity.php';
							 }
							?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php ?>