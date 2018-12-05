<?php  $curr_user_id=get_current_user_id();
$obj_gym=new MJ_Gym_management($curr_user_id);
$obj_reservation=new MJ_Gmgtreservation;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'reservationlist';
?>
<div class="page-inner" style="min-height:1631px !important">
<div class="page-title">
		<h3><img src="<?php echo get_option( 'gmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'gmgt_system_name' );?></h3>
</div>
	<?php 
	if(isset($_POST['save_group']))
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
				$result=$obj_reservation->gmgt_add_reservation($_POST);
				
				if($result='validation')
				{ ?>
			
					<div id="message" class="updated below-h2">
						<p><p><?php _e('not valaidate.','gym_mgt');?></p></p>
					</div>
					
				<?php 
				}
				
				if($result['msg']!='reserved')
				{
					wp_redirect ( admin_url().'admin.php?page=gmgt_reservation&tab=reservationlist&message=2');
				}
				else
				{					
					if(isset($result['msg']))
					{
						$_REQUEST['reservation_id']=$result['id'];
						?>
						<div id="message" class="updated below-h2">
							<p><p><?php _e('This Date is Already Reserved.','gym_mgt');?></p></p>
						</div>
					<?php
					}
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
				$result=$obj_reservation->gmgt_add_reservation($_POST);
				
				if($result!="reserved")
				{
					wp_redirect ( admin_url().'admin.php?page=gmgt_reservation&tab=reservationlist&message=1');
					
				}
				else
				{
					wp_redirect ( admin_url().'admin.php?page=gmgt_reservation&tab=addreservation&message=4');
			    }
			}		
			
		}
	}

		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
		{
			
			$result=$obj_reservation->delete_reservation($_REQUEST['reservation_id']);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=gmgt_reservation&tab=reservationlist&message=3');
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
			_e('This Date is Already Reserved Event.','gym_mgt');
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
							<a href="?page=gmgt_reservation&tab=reservationlist" class="nav-tab <?php echo $active_tab == 'reservationlist' ? 'nav-tab-active' : ''; ?>">
							<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Reservation List', 'gym_mgt'); ?></a>
							<?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
							{?>
							<a href="?page=gmgt_reservation&tab=addreservation&action=edit&reservation_id=<?php echo $_REQUEST['reservation_id'];?>" class="nav-tab <?php echo $active_tab == 'addreservation' ? 'nav-tab-active' : ''; ?>">
							<?php _e('Edit Reservation', 'gym_mgt'); ?></a>  
							<?php 
							}
							else
							{?>
								<a href="?page=gmgt_reservation&tab=addreservation" class="nav-tab <?php echo $active_tab == 'addreservation' ? 'nav-tab-active' : ''; ?>">
							<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Reservation', 'gym_mgt'); ?></a>
								
							<?php  }?>
						</h2>
						<?php 
						//Report 1 
						if($active_tab == 'reservationlist')
						{ 
						?>	
					<script type="text/javascript">
						$(document).ready(function() 
						{
							jQuery('#reservation_list').DataTable({
								"responsive": true,
								"order": [[ 0, "asc" ]],
								"aoColumns":[
											  {"bSortable": true},
											  {"bSortable": true},
											  {"bSortable": true},
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
									<table id="reservation_list" class="display" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th><?php  _e( 'Event Name', 'gym_mgt' ) ;?></th>
													<th><?php  _e( 'Event Date', 'gym_mgt' ) ;?></th>
													<th><?php  _e( 'Place', 'gym_mgt' ) ;?></th>
													<th><?php  _e( 'Starting Time', 'gym_mgt' ) ;?></th>
													<th><?php  _e( 'Ending Time', 'gym_mgt' ) ;?></th>
													<th><?php  _e( 'Reserved By', 'gym_mgt' ) ;?></th>
													   <th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
												</tr>
										    </thead>
											<tfoot>
												<tr>
												<th><?php  _e( 'Event Name', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Event Date', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Place', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Starting Time', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Ending Time', 'gym_mgt' ) ;?></th>
												<th><?php  _e( 'Reserved By', 'gym_mgt' ) ;?></th>
												   <th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
												</tr>
											</tfoot>
											<tbody>
											<?php 
											$reservationdata=$obj_reservation->get_all_reservation();
											if(!empty($reservationdata))
											{
												foreach ($reservationdata as $retrieved_data){

											 ?>
												<tr>
													<td class="eventname"><a href="?page=gmgt_reservation&tab=addreservation&action=edit&reservation_id=<?php echo $retrieved_data->id;?>"><?php echo $retrieved_data->event_name;?></a></td>
													<td class="date"><?php echo getdate_in_input_box($retrieved_data->event_date);?></td>
													<td class="place"><?php echo  get_the_title( $retrieved_data->place_id );?></td>
													
													<td class="starttime"><?php echo $retrieved_data->start_time;?></td>
													<td class="endtime"><?php echo $retrieved_data->end_time;?></td>
													<td class="staff_id"><?php echo gym_get_display_name($retrieved_data->staff_id);?></td>
													<td class="action"> <a href="?page=gmgt_reservation&tab=addreservation&action=edit&reservation_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
													<a href="?page=gmgt_reservation&tab=reservationlist&action=delete&reservation_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
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
						if($active_tab == 'addreservation')
						 {
							require_once GMS_PLUGIN_DIR. '/admin/reservation/add_reservation.php';
						 }
						?>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
<?php //} ?>