<?php 
$curr_user_id=get_current_user_id();
$obj_gym=new MJ_Gym_management($curr_user_id);
$obj_membership=new MJ_Gmgtmembership;
$obj_class=new MJ_Gmgtclassschedule;
$obj_group=new MJ_Gmgtgroup;
$obj_member=new MJ_Gmgtmember;?>
<!-- POP up code -->
<div class="popup-bg" style="z-index:100000 !important;">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="category_list"></div>     
		</div>
    </div>     
</div>
<!-- End POP-UP Code -->
<?php 
if(isset($_REQUEST['action'] ) && $_REQUEST['action']=='approve')
{
	if( get_user_meta($_REQUEST['member_id'], 'gmgt_hash', true))
	{
		$obj_membership=new MJ_Gmgtmembership;		
		$result=delete_user_meta($_REQUEST['member_id'], 'gmgt_hash');
		$user_info = get_userdata($_REQUEST['member_id']);
		$to = $user_info->user_email; 
		$login_link=home_url();
		$membership = $obj_membership->get_single_membership($user_info->membership_id);					
		$subject =get_option( 'Member_Approved_Template_Subject' ); 
		$gymname=get_option( 'gmgt_system_name' );
		$sub_arr['[GMGT_GYM_NAME]']=$gymname;
	    $subject = gmgt_subject_string_replacemnet($sub_arr,$subject);
		$search=array('[GMGT_GYM_NAME]','[GMGT_LOGIN_LINK]');
		$membership_name=get_membership_name($membership_id);
		$replace = array($gymname,$login_link);
		$message_replacement = str_replace($search, $replace,get_option('Member_Approved_Template'));	
		 gmgt_send_mail($to,$subject,$message_replacement);	 
		if($result)
		wp_redirect ( admin_url().'admin.php?page=gmgt_member&tab=memberlist&message=4');
		
	}
}
if(isset($_REQUEST['attendance']) && $_REQUEST['attendance'] == 1)
{ ?>
	<script type="text/javascript">
	$(document).ready(function() {
		// $('.sdate').datepicker({dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>'}); 
		//$('.edate').datepicker({dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>'});  
		$('.sdate').datepicker(); 
		$('.edate').datepicker(); 
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
						<a href="?page=gmgt_member&attendance=1" class="nav-tab nav-tab-active">
						<?php echo '<span class="dashicons dashicons-menu"></span>'.__('View Attendance', 'gym_mgt'); ?></a>
					</h2>
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
						$start_date = get_format_for_db($_REQUEST['sdate']);
						$end_date = get_format_for_db($_REQUEST['edate']);
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
               <?php } ?>
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
			$txturl=$_POST['gmgt_user_avatar'];
			$ext=check_valid_extension($txturl);
			if(!$ext == 0)
			{	
				$result=$obj_member->gmgt_add_user($_POST);
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=gmgt_member&tab=memberlist&message=2');
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
					$result=$obj_member->gmgt_add_user($_POST);
						
					if($result>0)
					{
						wp_redirect ( admin_url() . 'admin.php?page=gmgt_member&tab=memberlist&message=1');
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
							<a href="?page=gmgt_member&tab=memberlist" class="nav-tab <?php echo $active_tab == 'memberlist' ? 'nav-tab-active' : ''; ?>">
							<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Member List', 'gym_mgt'); ?></a>
							
							<?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
							{?>
							<a href="?page=gmgt_member&tab=addmember&action=edit&member_id=<?php echo $_REQUEST['member_id'];?>" class="nav-tab <?php echo $active_tab == 'addmember' ? 'nav-tab-active' : ''; ?>">
							<?php _e('Edit Member', 'gym_mgt'); ?></a>  
							<?php 
							}
							elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view')
							{ ?>
								
							<a href="?page=gmgt_member&tab=viewmember&action=view&member_id=<?php echo $_REQUEST['member_id'];?>" class="nav-tab <?php echo $active_tab == 'viewmember' ? 'nav-tab-active' : ''; ?>">
							<?php _e('View Member', 'gym_mgt'); ?></a>  
								<?php 
							}
							else 
							{ ?>
								<a href="?page=gmgt_member&tab=addmember" class="nav-tab <?php echo $active_tab == 'addmember' ? 'nav-tab-active' : ''; ?>">
							<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Member', 'gym_mgt'); ?></a>
							<?php  }?>
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
										   {"bSortable": true},
										   //{"bSortable": true},
										   {"bSortable": false}]
										});
								} );
							</script>
						<div class="panel-body">    
							<form method="post">  
							<div class="form-group col-md-3">
								<label class=""><?php _e('Member type','gym_mgt');?></label>
									<select name="member_type" class="form-control validate[required]" id="member_type">
									<option value=""><?php  _e('Select Member Type','gym_mgt');?></option>
									<?php if(isset($_POST['member_type']))
											$mtype=$_POST['member_type'];
										  else
											$mtype="";
										$membertype_array=member_type_array();
										
										if(!empty($membertype_array))
										{
											foreach($membertype_array as $key=>$type)
											{						
												echo '<option value='.$key.' '.selected($mtype,$key).'>'.$type.'</option>';
											}
										}
										?>
									</select>			
							</div>
							<div class="form-group col-md-3 button-possition">
								<label for="subject_id">&nbsp;</label>
								<input type="submit" value="<?php _e('Go','gym_mgt');?>" name="filter_membertype"  class="btn btn-info"/>
							</div>
							 <?php 
								if(isset($_REQUEST['filter_membertype']) )
								{
									if(isset($_REQUEST['member_type']) && $_REQUEST['member_type'] != "")
									{
										$member_type= $_REQUEST['member_type'];						
										$membersdata = get_users(array('meta_key' => 'member_type', 'meta_value' =>$member_type,'role'=>'member'));	
									}					
								}
								else 
								{					
									$membersdata =get_users( array('role' => 'member'));					
								} ?>       
							</form>
						</div>
							<form name="member_form" action="" method="post">
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
													<th><?php _e( 'Member Type', 'gym_mgt' ) ;?></th>
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
											//$get_members = array('role' => 'member');
												//$membersdata=get_users($get_members);
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
													<td class="name"><a href="?page=gmgt_member&tab=addmember&action=edit&member_id=<?php echo $retrieved_data->ID;?>"><?php echo $retrieved_data->display_name;?></a></td>
													<td class="memberid"><?php echo $retrieved_data->member_id;?></td>
													<td class="memberid"><?php if(isset($retrieved_data->member_type))  echo $membertype_array[$retrieved_data->member_type];  else echo __('Not Selected','gym_mgt');?></td>
													<td class="joining date"><?php if($retrieved_data->member_type!='Prospect'){ echo getdate_in_input_box($retrieved_data->begin_date); }else{ echo "--"; }?></td>
													
													<td class="joining date"><?php if($retrieved_data->member_type!='Prospect'){ echo getdate_in_input_box(gmgt_check_membership($retrieved_data->ID)); }else{ echo "--"; }?></td>
													<!--<td class="class"><?php $classdata=$obj_class->get_single_class($retrieved_data->class_id);
													echo $classdata->class_name;?></td>-->
													<td class="status"><?php if($retrieved_data->member_type!='Prospect'){  _e($retrieved_data->membership_status,'gym_mgt'); }else{ _e('Prospect','gym_mgt');}?></td>
													<!--<td class="email"><?php echo $retrieved_data->user_email;?></td>-->
												   <!-- <td class="mobile"><?php echo $retrieved_data->mobile;?></td>-->

													<td class="action"> 
														<a href="?page=gmgt_member&tab=viewmember&action=view&member_id=<?php echo $retrieved_data->ID?>" class="btn btn-success"> <?php _e('View', 'gym_mgt' ) ;?></a>
													<a href="?page=gmgt_member&tab=addmember&action=edit&member_id=<?php echo $retrieved_data->ID?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
													<a href="?page=gmgt_member&tab=memberlist&action=delete&member_id=<?php echo $retrieved_data->ID;?>" class="btn btn-danger" 
													onclick="return confirm('<?php _e('Do you really want to delete this record?','gym_mgt');?>');">
													<?php _e( 'Delete', 'gym_mgt' ) ;?> </a>
													<a href="?page=gmgt_member&view_member&member_id=<?php echo $retrieved_data->ID;?>&attendance=1" class="btn btn-default" 
													idtest="<?php echo $retrieved_data->ID; ?>"><i class="fa fa-eye"></i> <?php _e('View Attendance','gym_mgt');?></a>
													<?php if(get_user_meta($retrieved_data->ID, 'gmgt_hash', true)!=''){?>
													<!--<a href="?page=gmgt_member&tab=memberlist&action=approve&haskey=<?php echo get_user_meta($retrieved_data->ID, 'gmgt_hash', true);?>&member_id=<?php echo $retrieved_data->ID?>" class="btn btn-info"> <?php _e('Approve', 'gym_mgt' ) ;?></a>-->
													<a href="?page=gmgt_member&tab=addmember&action=approve&member_id=<?php echo $retrieved_data->ID?>" class="btn btn-info"> <?php _e('Approve', 'gym_mgt' ) ;?></a>
													<?php } ?>
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
						if($active_tab == 'addmember')
						 {
							require_once GMS_PLUGIN_DIR. '/admin/member/add_member.php';
						 }
						 
						 if($active_tab == 'viewmember')
						 {
							
							require_once GMS_PLUGIN_DIR. '/admin/member/view_member.php';
						 }
						 ?>
					</div>
	            </div>
	        </div>
        </div>
    </div>
</div>
<?php } ?>