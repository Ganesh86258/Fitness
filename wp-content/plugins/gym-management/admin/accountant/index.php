<?php 
$obj_user=new MJ_Gmgtmember;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'accountantlist';
?>
<!-- POP up code -->
<div class="popup-bg" style="min-height:1631px !important">
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
	if(isset($_POST['save_staff']))
	{
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{
			$txturl=$_POST['gmgt_user_avatar'];
			$ext=check_valid_extension($txturl);
			if(!$ext == 0)
			{
				$result=$obj_user->gmgt_add_user($_POST);
		
				if($result)
				{
					wp_redirect ( admin_url() . 'admin.php?page=gmgt_accountant&tab=accountantlist&message=2');
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
			if( !email_exists( $_POST['email'] ) && !username_exists( $_POST['username'] ))
			{
				$txturl=$_POST['gmgt_user_avatar'];
				$ext=check_valid_extension($txturl);
				if(!$ext == 0)
				{
					$result=$obj_user->gmgt_add_user($_POST);
						
					if($result)
					{
						wp_redirect ( admin_url() . 'admin.php?page=gmgt_accountant&tab=accountantlist&message=1');
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
			{ ?>
						<div id="message" class="updated below-h2">
						<p><p><?php _e('Username Or Email id exists already.','gym_mgt');?></p></p>
						</div>
						
	  <?php }
		}
	}
		
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
	{
		
		$result=$obj_user->delete_usedata($_REQUEST['accountant_id']);
		if($result)
		{
			wp_redirect ( admin_url() . 'admin.php?page=gmgt_accountant&tab=accountantlist&message=3');
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
					_e("Record updated successfully",'gym_mgt');
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
							<a href="?page=gmgt_accountant&tab=accountantlist" class="nav-tab <?php echo $active_tab == 'accountantlist' ? 'nav-tab-active' : ''; ?>">
							<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Accountant  List', 'gym_mgt'); ?></a>
							
							<?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
							{?>
							<a href="?page=gmgt_accountant&tab=add_accountant&&action=edit&accountant_id=<?php echo $_REQUEST['accountant_id'];?>" class="nav-tab <?php echo $active_tab == 'add_accountant' ? 'nav-tab-active' : ''; ?>">
							<?php _e('Edit Accountant', 'gym_mgt'); ?></a>  
							<?php 
							}
							else
							{?>
								<a href="?page=gmgt_accountant&tab=add_accountant" class="nav-tab <?php echo $active_tab == 'add_accountant' ? 'nav-tab-active' : ''; ?>">
							<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Accountant', 'gym_mgt'); ?></a>  
							<?php  }?>
						</h2>
						 <?php 
						//Report 1 
						if($active_tab == 'accountantlist')
						{ ?>	
						<script type="text/javascript">
					    $(document).ready(function() {
						jQuery('#staff_list').DataTable({
							"responsive": true,
							 "order": [[ 1, "asc" ]],
							 "aoColumns":[
										  {"bSortable": false},
										  {"bSortable": true},
										  {"bSortable": true},
										  {"bVisible": true},	                 
										  {"bSortable": false}
									   ]
							 
							});
					    } );
					    </script>
					    <form name="wcwm_report" action="" method="post">
						    <div class="panel-body">
								<div class="table-responsive">
									<table id="staff_list" class="display" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th style="width: 50px;height:50px;"><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
												<th><?php _e( 'Accountant Name', 'gym_mgt' ) ;?></th>
												  <!-- <th><?php _e( 'Department', 'gym_mgt' ) ;?></th>-->
												<th> <?php _e( 'Accountant Email', 'gym_mgt' ) ;?></th>
												<th> <?php _e( 'Mobile No', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
											</tr>
									    </thead>
										<tfoot>
											<tr>
												<th><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
												<th><?php _e( 'Accountant Name', 'gym_mgt' ) ;?></th>
												   <!-- <th><?php _e( 'Department', 'gym_mgt' ) ;?></th>-->
												<th> <?php _e( 'Accountant Email', 'gym_mgt' ) ;?></th>
												<th> <?php _e( 'Mobile No', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
											</tr>
										</tfoot>
										<tbody>
										<?php 
										//$nursedata=get_usersdata('nurse');
										 $get_staff = array('role' => 'accountant');
											$staffdata=get_users($get_staff);
										if(!empty($staffdata))
										{
										foreach ($staffdata as $retrieved_data){
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
												<td class="name"><a href="?page=gmgt_accountant&tab=add_accountant&action=edit&accountant_id=<?php echo $retrieved_data->ID;?>"><?php echo $retrieved_data->display_name;?></a></td>
												<!--<td class="department"><?php 
												$postdata=get_post($retrieved_data->role_type);
												echo $postdata->post_title;?></td>-->
												
												
												<td class="email"><?php echo $retrieved_data->user_email;?></td>
												<td class="mobile"><?php echo $retrieved_data->mobile;?></td>
												<td class="action"> <a href="?page=gmgt_accountant&tab=add_accountant&action=edit&accountant_id=<?php echo $retrieved_data->ID;?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
												<a href="?page=gmgt_accountant&tab=accountantlist&action=delete&accountant_id=<?php echo $retrieved_data->ID;?>" class="btn btn-danger" 
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
						if($active_tab == 'add_accountant')
						 {
							require_once GMS_PLUGIN_DIR. '/admin/accountant/add_accountant.php';
						 }
						 ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php //} ?>