<?php 
$obj_nutrition=new MJ_Gmgtnutrition;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'nutritionlist';
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
	if(isset($_POST['save_nutrition']))
	{
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{
				
			$result=$obj_nutrition->gmgt_add_nutrition($_POST);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=gmgt_nutrition&tab=nutritionlist&message=2');
			}
				
				
		}
		else
		{
			$result=$obj_nutrition->gmgt_add_nutrition($_POST);
	
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=gmgt_nutrition&tab=nutritionlist&message=1');
				}
			}
	
	}
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
		{
			
			$result=$obj_nutrition->delete_nutrition($_REQUEST['nutrition_id']);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=gmgt_nutrition&tab=nutritionlist&message=3');
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
							<a href="?page=gmgt_nutrition&tab=nutritionlist" class="nav-tab <?php echo $active_tab == 'nutritionlist' ? 'nav-tab-active' : ''; ?>">
							<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Nutrition Schedule List', 'gym_mgt'); ?></a>
							
							<?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view')
							{?>
							<a href="?page=gmgt_nutrition&tab=addnutrition&action=view&workoutmember_id=<?php echo $_REQUEST['workoutmember_id'];?>" class="nav-tab <?php echo $active_tab == 'addnutrition' ? 'nav-tab-active' : ''; ?>">
							<?php _e('View Nutrition Schedule', 'gym_mgt'); ?></a>  
							<?php 
							}
							else
							{?>
								<a href="?page=gmgt_nutrition&tab=addnutrition" class="nav-tab <?php echo $active_tab == 'addnutrition' ? 'nav-tab-active' : ''; ?>">
							<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Nutrition Schedule', 'gym_mgt'); ?></a>
								
							<?php  }?>
						   
						</h2>
						 <?php 
						//Report 1 
						if($active_tab == 'nutritionlist')
						{ 
						?>	
					<script type="text/javascript">
						$(document).ready(function() {
							jQuery('#nutrition_list').DataTable({
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
									<table id="nutrition_list" class="display" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Member Name', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Member Goal', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Member Name', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Member Goal', 'gym_mgt' ) ;?></th>
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
															echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>';
												?></td>
												<td class="member"><a href="?page=gmgt_workouttype&tab=addworkouttype&action=edit&workoutmember_id=<?php echo $retrieved_data->ID;?>">
												<?php $user=get_userdata($retrieved_data->ID);
												$display_label=$user->display_name;
												$memberid=get_user_meta($retrieved_data->ID,'member_id',true);
													if($memberid)
														$display_label.=" (".$memberid.")";
													echo $display_label;?></a></td>
												<td class="member-goal"><?php $intrestid=get_user_meta($retrieved_data->ID,'intrest_area',true);
												echo get_the_title($intrestid);?></td>			
												<td class="action"> 
												<a href="?page=gmgt_nutrition&tab=addnutrition&action=view&workoutmember_id=<?php echo $retrieved_data->ID;?>" class="btn btn-default">
												<i class="fa fa-eye"></i> <?php _e('View Nutrition', 'gym_mgt');?></a>
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
						if($active_tab == 'addnutrition')
						 {
						  require_once GMS_PLUGIN_DIR. '/admin/nutrition/add_nutrition.php';
						 }?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php //} ?>