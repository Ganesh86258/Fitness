<?php 
$obj_group=new MJ_Gmgtgroup;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'grouplist';
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
	if(isset($_POST['save_group']))
	{
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{
			$txturl=$_POST['gmgt_groupimage'];
			$ext=check_valid_extension($txturl);
			if(!$ext == 0)
			{	
				$result=$obj_group->gmgt_add_group($_POST,$_POST['gmgt_groupimage']);
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=gmgt_group&tab=grouplist&message=2');
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
			$txturl=$_POST['gmgt_groupimage'];
			$ext=check_valid_extension($txturl);
			if(!$ext == 0)
			{
				$result=$obj_group->gmgt_add_group($_POST,$_POST['gmgt_groupimage']);
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=gmgt_group&tab=grouplist&message=1');
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
	
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
	{
		$result=$obj_group->delete_group($_REQUEST['group_id']);
		if($result)
		{
			wp_redirect ( admin_url().'admin.php?page=gmgt_group&tab=grouplist&message=3');
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
							<a href="?page=gmgt_group&tab=grouplist" class="nav-tab <?php echo $active_tab == 'grouplist' ? 'nav-tab-active' : ''; ?>">
							<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Group List', 'gym_mgt'); ?>
							</a>
							<?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
							{?>
								<a href="?page=gmgt_group&tab=addgroup&&action=edit&group_id=<?php echo $_REQUEST['group_id'];?>" class="nav-tab <?php echo $active_tab == 'addgroup' ? 'nav-tab-active' : ''; ?>">
								<?php _e('Edit Group', 'gym_mgt'); ?></a>  
								<?php 
							}
							else
							{?>
							  <a href="?page=gmgt_group&tab=addgroup" class="nav-tab <?php echo $active_tab == 'addgroup' ? 'nav-tab-active' : ''; ?>">
							<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Group', 'gym_mgt'); ?></a>
							<?php  }?>
						</h2>
						 <?php 
						//Report 1 
						if($active_tab == 'grouplist')
						{ 
						?>	
						<script type="text/javascript">
						$(document).ready(function() {
							jQuery('#group_list').DataTable({
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
									<table id="group_list" class="display" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th style="width: 50px;height:50px;"><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Group Name', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Total Group Members', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
											</tr>
									    </thead>
										<tfoot>
											<tr>
												<th><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Group Name', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Total Group Members', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
											</tr>
										</tfoot>
										<tbody>
											<?php 
											$groupdata=$obj_group->get_all_groups();
											if(!empty($groupdata))
											{
												foreach ($groupdata as $retrieved_data){
											 ?>
												<tr>
													<td class="user_image"><?php 
															if($retrieved_data->gmgt_groupimage == '')
															{
															  echo '<img src='.get_option( 'gmgt_system_logo' ).' height="25px" width="25px" class="img-circle" />';
															}
															else
															{
															 echo '<img src='.$retrieved_data->gmgt_groupimage.' height="25px" width="25px" class="img-circle"/>';
															}
													?>
													</td>	
													<td class="membershipname"><a href="?page=gmgt_group&tab=addgroup&action=edit&group_id=<?php echo $retrieved_data->id;?>"><?php echo $retrieved_data->group_name;?></a></td>
													<td class="allmembers"><?php echo $obj_group->count_group_members($retrieved_data->id);?></td>
													
													<td class="action"> 
														<a href="#" class="btn btn-success view_group_member" id="<?php echo $retrieved_data->id?>"> <?php _e('View', 'gym_mgt' ) ;?></a>
														<a href="?page=gmgt_group&tab=addgroup&action=edit&group_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
														<a href="?page=gmgt_group&tab=grouplist&action=delete&group_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
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
						if($active_tab == 'addgroup')
						{
						  require_once GMS_PLUGIN_DIR. '/admin/group/add_group.php';
						}
						
						?>
					</div>
	            </div>
	        </div>
        </div>
    </div>
</div>
<?php ?>