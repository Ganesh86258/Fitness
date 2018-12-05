<?php 
$obj_class=new MJ_Gmgtclassschedule;
$obj_activity=new MJ_Gmgtactivity;
$obj_workouttype=new MJ_Gmgtworkouttype;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'workouttypelist';
?>
<!-- POP up code -->
<div class="popup-bg">
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
	if(isset($_POST['save_workouttype']))
	{
			
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{						
			$result=$obj_workouttype->gmgt_add_workouttype($_POST);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=gmgt_workouttype&tab=workouttypelist&message=2');
			}
				
				
		}
		else
		{
			$result=$obj_workouttype->gmgt_add_workouttype($_POST);
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=gmgt_workouttype&tab=workouttypelist&message=1');
				}
			
			}
		
	}
	
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
	{
				$result=$obj_workouttype->delete_workouttype($_REQUEST['workouttype_id']);
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=gmgt_workouttype&tab=workouttypelist&message=3');
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
							<a href="?page=gmgt_workouttype&tab=workouttypelist" class="nav-tab <?php echo $active_tab == 'workouttypelist' ? 'nav-tab-active' : ''; ?>">
							<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Workout Log', 'gym_mgt'); ?></a>
							
							<?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view' )
							{?>
							<a href="?page=gmgt_workouttype&tab=addworkouttype&action=view&workoutmember_id=<?php echo $_REQUEST['workoutmember_id'];?>" class="nav-tab <?php echo $active_tab == 'addworkouttype' ? 'nav-tab-active' : ''; ?>">
							<?php _e('View Assigned Workout', 'gym_mgt'); ?></a>  
							<?php 
							}
							else
							{?>
								<a href="?page=gmgt_workouttype&tab=addworkouttype" class="nav-tab <?php echo $active_tab == 'addworkouttype' ? 'nav-tab-active' : ''; ?>">
							<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Assign Workout', 'gym_mgt'); ?></a>
								
							<?php  }?>
						</h2>
						 <?php 
						//Report 1 
						if($active_tab == 'workouttypelist')
						{ 
						?>	
						<script type="text/javascript">
							$(document).ready(function() 
							{
							 jQuery('#assignworkout_list').DataTable({
								"responsive": true,
								"order": [[ 1, "asc" ]],
								"aoColumns":[
											  {"bSortable": false},
											  {"bSortable": true},
											  {"bSortable": true},
											  {"bSortable": false}]
								});
						    } );
					   </script>
						<form name="wcwm_report" action="" method="post">
							<div class="panel-body">
								<div class="table-responsive">
								
								
								
									<table id="assignworkout_list" class="display" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Member Name', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Member Goal', 'gym_mgt' ) ;?></th>
												<!--<th><?php  _e( 'Activity Name', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Workout Time', 'gym_mgt' ) ;?></th>-->
												<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
											</tr>
									    </thead>
										<tfoot>
											<tr>
												<th><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Member Name', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Member Goal', 'gym_mgt' ) ;?></th>
												<!--<th><?php  _e( 'Activity Name', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Workout Time', 'gym_mgt' ) ;?></th>-->
												<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
											</tr>
										</tfoot>
										<tbody>
										<?php
										$get_members = array('role' => 'member');
											$membersdata=get_users($get_members);
										if(!empty($membersdata))
										{
											foreach ($membersdata as $retrieved_data){?>
											<tr>
												<td class="user_image"><?php $uid=$retrieved_data->ID;
															$userimage=get_user_meta($uid, 'gmgt_user_avatar', true);
														if(empty($userimage))
														{
																		echo '<img src='.get_option( 'gmgt_system_logo' ).' height="50px" width="50px" class="img-circle" />';
														}
														else
														{
															echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>';
														}
												?>
												</td>
												<td class="member"><a href="?page=gmgt_workouttype&tab=addworkouttype&action=edit&workoutmember_id=<?php echo $retrieved_data->ID;?>">
												<?php $user=get_userdata($retrieved_data->ID);
												$display_label=$user->display_name;
												$memberid=get_user_meta($retrieved_data->ID,'member_id',true);
													if($memberid)
														$display_label.=" (".$memberid.")";
													echo $display_label;?></a></td>
												<td class="member-goal"><?php $intrestid=get_user_meta($retrieved_data->ID,'intrest_area',true);
												echo get_the_title($intrestid);?></td>
												
												
												<!--<td class="activity"><?php $activity=$obj_activity->get_single_activity($retrieved_data->activity_id);
												echo $activity->activity_title;?></td>
												
												<td class="repeattime"><?php echo get_the_title($retrieved_data->workouts_limit_hour);?></td>
												<td class="action"> <a href="?page=gmgt_workouttype&tab=addworkouttype&action=edit&workouttype_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('View', 'gym_mgt' ) ;?></a></td>-->
												<td class="action"> 
												<a href="?page=gmgt_workouttype&tab=addworkouttype&action=view&workoutmember_id=<?php echo $retrieved_data->ID;?>" class="btn btn-default">
												<i class="fa fa-eye"></i> <?php _e('View Workouts', 'gym_mgt');?></a>
												<!--<a href="?page=gmgt_workouttype&tab=addworkouttype&action=edit&workoutmember_id=<?php echo $retrieved_data->ID;?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>-->
												<!--  <a href="?page=gmgt_workouttype&tab=workouttypelist&action=delete&workouttype_id=<?php echo $retrieved_data->ID;?>" class="btn btn-danger" 
												onclick="return confirm('<?php _e('Do you really want to delete this record?','gym_mgt');?>');">
												<?php _e( 'Delete', 'gym_mgt' ) ;?> </a>-->
												
												</td>
											</tr>
											<?php } 
										}?>
									    </tbody>
									</table>
							    </div>
							</div>
					    </form>
					</div>
						 <?php 
						}
						if($active_tab == 'addworkouttype')
						 {
						require_once GMS_PLUGIN_DIR. '/admin/workout-type/add_workout_type.php';
						 }
						 ?>
				</div>
            </div>
        </div>
    </div>
</div>
<?php //} ?>