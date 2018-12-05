<?php //======Front end template=========
require_once(ABSPATH.'wp-admin/includes/user.php' );
$user = wp_get_current_user ();
$obj_dashboard= new MJ_Gmgtdashboard;
$user_id=get_current_user_id(); 
if(check_approve_user($user_id)!='')
{
	wp_logout();
	wp_redirect(site_url().'/index.php/gym-management-login-page/?na=1');
	
}
$obj_gym = new MJ_Gym_management(get_current_user_id());
if (! is_user_logged_in ())
{
	$page_id = get_option ( 'gmgt_login_page' );
	
	wp_redirect ( home_url () . "?page_id=" . $page_id );
}
if (is_super_admin ()) 
{
	wp_redirect ( admin_url () . 'admin.php?page=gmgt_system' );
}
$obj_reservation = new MJ_Gmgtreservation;
$reservationdata = $obj_reservation->get_all_reservation();
$cal_array = array();
if(!empty($reservationdata))
{
	foreach ($reservationdata as $retrieved_data){
		$cal_array [] = array (
				'title' => $retrieved_data->event_name,
				'start' => $retrieved_data->event_date,
				'end' => $retrieved_data->event_date,


		);
	}
}
$birthday_boys=get_users(array('role'=>'member'));
$boys_list="";
if (! empty ( $birthday_boys )) 
{
		foreach ( $birthday_boys as $boys ) 
		{
			 //$boys_list.=$boys->display_name." ";
			$cal_array [] = array (
					'title' => __($boys->display_name.' Birthday','gym_mgt'),
					'start' =>mysql2date('Y-m-d', $boys->birth_date) ,
					'end' => mysql2date('Y-m-d', $boys->birth_date),
					'backgroundColor' => '#F25656'
			);	
			
			
		}
		
}
if (! empty ( $obj_gym->notice )) 
{
	foreach ( $obj_gym->notice as $notice ) 
	{
			 $notice_start_date=get_post_meta($notice->ID,'gmgt_start_date',true);
			 $notice_end_date=get_post_meta($notice->ID,'gmgt_end_date',true);
			$i=1;
			
			$cal_array[] = array (
					'title' => $notice->post_title,
					'start' => mysql2date('Y-m-d', $notice_start_date ),
					'end' => date('Y-m-d',strtotime($notice_end_date.' +'.$i.' days')),
					'color' => '#12AFCB'
			);	
			
	}
}	
?>
<script>
jQuery(document).ready(function() 
 {
	jQuery('#calendar').fullCalendar(
	{
		header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				defaultView: 'month',
				editable: false,
			eventLimit: true, // allow "more" link when too many events
			events: <?php echo json_encode($cal_array);?>,
			forceEventDuration : true,
	        eventMouseover: function (event, jsEvent, view) 
			{
				//end date change with minus 1 day
				<?php $dformate=get_option('gmgt_datepicker_format'); ?>

				var dateformate_value='<?php echo $dformate;?>';	

				if(dateformate_value == 'yy-mm-dd')
				{	
				var dateformate='YYYY-MM-DD';
				}
				if(dateformate_value == 'yy/mm/dd')
				{	
				var dateformate='YYYY/MM/DD';	
				}
				if(dateformate_value == 'dd-mm-yy')
				{	
				var dateformate='DD-MM-YYYY';
				}
				if(dateformate_value == 'mm-dd-yy')
				{	
				var dateformate='MM-DD-YYYY';
				}
				if(dateformate_value == 'mm/dd/yy')
				{	
				var dateformate='MM/DD/YYYY';	
				}

				 var newstartdate = event.start;
				 var date = new Date(newstartdate);
				 var startdate = new Date(date);
				 var dateObjstart = new Date(startdate);
				 var momentObjstart = moment(dateObjstart);
				 var momentStringstart = momentObjstart.format(dateformate);

				 var newdate = event.end;
				 var date = new Date(newdate);
				 var newdate1 = new Date(date);
				 newdate1.setDate(newdate1.getDate() - 1);
				 var dateObj = new Date(newdate1);
				 var momentObj = moment(dateObj);
				 var momentString = momentObj.format(dateformate);

					tooltip = '<div class="tooltiptopicevent" style="width:auto;height:auto;background:#feb811;position:absolute;z-index:10001;padding:10px 10px 10px 10px ;  line-height: 200%;">' + '<?php _e('Title Name','gym_mgt'); ?>' + ': ' + event.title + '</br>' + ' <?php _e('Start Date','gym_mgt'); ?>' + ': ' + momentStringstart + '</br>' + '<?php _e('End Date','gym_mgt'); ?>' + ': ' + momentString + '</br>' +  ' </div>';
					$("body").append(tooltip);
					$(this).mouseover(function (e) {
						$(this).css('z-index', 10000);
						$('.tooltiptopicevent').fadeIn('500');
						$('.tooltiptopicevent').fadeTo('10', 1.9);
					}).mousemove(function (e) {
						$('.tooltiptopicevent').css('top', e.pageY + 10);
						$('.tooltiptopicevent').css('left', e.pageX + 20);
					});

            },
			eventMouseout: function (data, event, view)
			{
				$(this).css('z-index', 8);
				$('.tooltiptopicevent').remove();
			},
	})
});
</script>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/dataTables.css'; ?>">
<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/dataTables.editor.min.css'; ?>">
<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/dataTables.tableTools.css'; ?>">
<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/dataTables.responsive.css'; ?>">
<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/jquery-ui.css'; ?>">
<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/font-awesome.min.css'; ?>">
<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/popup.css'; ?>">
<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/style.css'; ?>">
<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/custom.css'; ?>">
<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/fullcalendar.css'; ?>">

<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/bootstrap.min.css'; ?>">	
<!--<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/bootstrap-timepicker.min.css'; ?>">-->
<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/datepicker.min.css'; ?>">
<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/bootstrap-multiselect.css'; ?>">	
<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/white.css'; ?>">
    
<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/gymmgt.min.css'; ?>">
<?php  if (is_rtl())
		 {?>
			<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/bootstrap-rtl.min.css'; ?>">
		<?php } ?>
<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/lib/validationEngine/css/validationEngine.jquery.css'; ?>">
<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/lib/select2-3.5.3/select2.css'; ?>">
<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/gym-responsive.css'; ?>">

<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/jquery-1.11.1.min.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/jquery-ui.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/moment.min.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/fullcalendar.min.js'; ?>"></script>
<?php /*--------Full calendar multilanguage---------*/
	$lancode=get_locale();
	$code=substr($lancode,0,2);?>
<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/calendar-lang/'.$code.'.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/lib/select2-3.5.3/select2.min.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/jquery.dataTables.min.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/dataTables.tableTools.min.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/dataTables.editor.min.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/dataTables.responsive.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/bootstrap.min.js'; ?>"></script>
<!--<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/bootstrap-timepicker.min.js'; ?>"></script>-->
<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/bootstrap-datepicker.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/bootstrap-multiselect.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/responsive-tabs.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/lib/validationEngine/js/languages/jquery.validationEngine-'.$code.'.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/lib/validationEngine/js/jquery.validationEngine.js'; ?>"></script>
 <script type="text/javascript" src="<?php echo GMS_PLUGIN_URL.'/assets/js/jssor.slider.mini.js';?>"></script>
</head>
<body class="gym-management-content">
	<div class="container-fluid mainpage">
		<div class="navbar">
		<div class="col-md-8 col-sm-8 col-xs-6">
			<h3 class="logo-image"><img src="<?php echo get_option( 'gmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" />
			<span><?php echo get_option( 'gmgt_system_name' );?> </span>
			</h3>
		</div>
			<ul class="nav navbar-right col-md-4 col-sm-4 col-xs-6">
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<li class="dropdown"><a data-toggle="dropdown"
						class="dropdown-toggle" href="javascript:;">
							<?php
							$userimage = get_user_meta( $user->ID,'gmgt_user_avatar',true );
							if (empty ( $userimage )){
								echo '<img src='.get_option( 'gmgt_system_logo' ).' height="40px" width="40px" class="img-circle" />';
							}
							else	
								echo '<img src=' . $userimage . ' height="40px" width="40px" class="img-circle"/>';
							?>
								<span>	<?php echo $user->display_name;?> </span> <b class="caret"></b>
					</a>
						<ul class="dropdown-menu extended logout">
							<li><a href="?dashboard=user&page=account"><i class="fa fa-user"></i>
									<?php _e('My Profile','gym_mgt');?></a></li>
							<li><a href="<?php echo wp_logout_url(home_url()); ?>"><i
									class="fa fa-sign-out m-r-xs"></i><?php _e('Log Out','gym_mgt');?> </a></li>
						</ul></li>
					<!-- END USER LOGIN DROPDOWN -->
			</ul>
		
		</div>
	</div>
	<div class="container-fluid">
	<div class="row">
			<div class="col-sm-2 nopadding gym_left nav-side-menu">	<!--  Left Side -->
				<div class="brand"><?php _e('Menu',''); ?>    
					<i data-target="#menu-content" data-toggle="collapse" 
					class="fa fa-bars fa-2x toggle-btn collapsed" aria-expanded="false"></i>
				</div>
				<?php				
				$menu = userwise_access_right();
				
				$class = "";
				if (! isset ( $_REQUEST ['page'] ))	
					$class = 'class = "active"';
					?>
				<ul class="nav nav-pills nav-stacked collapsed collapse" id="menu-content">
							<li><a href="<?php echo site_url();?>"><span class="icone"><img src="<?php echo plugins_url( 'gym-management/assets/images/icon/home.png' )?>"/></span><span class="title"><?php _e('Home','gym_mgt');?></span></a></li>
							<li <?php echo $class;?>><a href="?dashboard=user"><span class="icone"><img src="<?php echo plugins_url('gym-management/assets/images/icon/dashboard.png' )?>"/></span><span
									class="title"><?php _e('Dashboard','gym_mgt');?></span></a></li>
									<?php											
										$role = $obj_gym->role;
										$access_page_view_array=array();
										if(!empty($menu))	
										{											
											foreach ( $menu as $key1=>$value1 ) 
											{									
												foreach ( $value1 as $key=>$value ) 
												{														
													if($value['view']=='1')
													{
														$access_page_view_array[]=$value ['page_link'];
														
														if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $value ['page_link'])
															$class = 'class = "active"';
														else
															$class = "";	
														
														echo '<li ' . $class . '><a href="?dashboard=user&page=' . $value ['page_link'] . '" class="left-tooltip" data-tooltip="'. $value ['menu_title'] . '" title="'. $value ['menu_title'] . '"><span class="icone"> <img src="' .$value ['menu_icone'].'" /></span><span class="title">'.change_menutitle($key).'</span></a></li>';
													}
												}									
											}
										}												
							?>
											
				</ul>
			</div>
			<div class="page-inner" style="min-height:1050px;">
				<div class="right_side <?php if(isset($_REQUEST['page']))echo $_REQUEST['page'];?>">
				   <?php 
				if (isset ( $_REQUEST ['page'] ))
				{
					require_once GMS_PLUGIN_DIR . '/template/' . $_REQUEST['page'] . '.php';
					return false;
				}?>
				<!---start new dashboard------>
				
				<div class="row "><!-- Start Row2 -->
					
					<div class="row left_section col-md-8 col-sm-8"><!-- Start Row2 -->
					<?php
					$page='member';
					$access=page_access_rolewise_accessright_dashboard($page);
					
					if($access)
					{	
					?>
						<div class="col-lg-3 col-md-3 col-xs-6 col-sm-6">
						<a href="<?php if($menu['member'][$role]){ echo home_url().'?dashboard=user&page=member';  }
						else
			            { echo "#"; }?>">
							<div class="panel info-box panel-white">
								<div class="panel-body member">
									<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard/member.png"?>" class="dashboard_background">
									<div class="info-box-stats">
										<p class="counter"><?php echo count(get_users(array('role'=>'member')));?> <span class="info-box-title"><?php echo esc_html( __( 'Member', 'gym_mgt' ) );?></span></p>
									</div>
								</div>
							</div>
						</a>
						</div>
					<?php
					}
					
					$page='staff_member';
					$access=page_access_rolewise_accessright_dashboard($page);
					if($access)
					{					
					?>					
						<div class="col-lg-3 col-md-3 col-xs-6 col-sm-6">
						<a href="<?php if($menu['staff_member'][$role]){ echo home_url().'?dashboard=user&page=staff_member';  }
						else
			            { echo "#"; }?>">
							<div class="panel info-box panel-white">
								<div class="panel-body staff-member">
									<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard/staff-member.png"?>" class="dashboard_background">
									<div class="info-box-stats">
										<p class="counter"><?php echo count(get_users(array('role'=>'staff_member')));?>
										<span class="info-box-title"><?php echo esc_html( __( 'Staff Member', 'gym_mgt' ) );?></span>
										</p>
										
									</div>
									
								</div>
							</div>
							</a>
						</div>
					<?php
					}					
					$page='group';
					$access=page_access_rolewise_accessright_dashboard($page);
					if($access)
					{					
					?>		
						<div class="col-lg-3 col-md-3 col-xs-6 col-sm-6">
						<a href="<?php if($menu['group'][$role]){ echo home_url().'?dashboard=user&page=group';  }
						else
			            { echo "#"; }?>">
							<div class="panel info-box panel-white">
								<div class="panel-body group">
									<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard/group.png"?>" class="dashboard_background">
									<div class="info-box-stats groups-label">
										<p class="counter"><?php echo $obj_dashboard->count_group();?> <span class="info-box-title"><?php echo esc_html( __( 'Group', 'gym_mgt' ) );?></span></p>
										
										
									</div>
									
								</div>
							</div>
							</a>
						</div>
					<?php
					}
					
					$page='message';
					$access=page_access_rolewise_accessright_dashboard($page);
					if($access)
					{					
					?>		
						<div class="col-lg-3 col-md-3 col-xs-6 col-sm-6">
						<a href="<?php if($menu['message'][$role]){ echo home_url().'?dashboard=user&page=message&tab=inbox';  }
						else
			            { echo "#"; }?>">
							<div class="panel info-box panel-white">
								<div class="panel-body message">
									<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard/message.png"?>" class="dashboard_background_message">
									<div class="info-box-stats">
										<p class="counter"><?php echo count(gmgt_count_inbox_item(get_current_user_id()));?> <span class="info-box-title"><?php echo esc_html( __( 'Message', 'gym_mgt' ) );?></span></p>
									</div>
									
								</div>
							</div>
							</a>
						</div>
					<?php
					}
					?>					
					</div>
					<div class="col-md-4 membership-list col-sm-4 col-xs-12">
							<div class="panel panel-white">
								<div class="panel-heading">
									<h3 class="panel-title"><?php _e('MemberShip','gym_mgt');?></h3>						
								</div>
								<div class="panel-body">
								<?php $membershipdata = $obj_dashboard->get_membership_list();
								 if(!empty($membershipdata))
									 {
										$i= 1;
										//var_dump($membershipdata);
										foreach ($membershipdata as $retrieved_data)
										{
											?>
											<p><?php $membershipimage=$retrieved_data->gmgt_membershipimage;
													if(empty($membershipimage))
													{
																	echo '<img src='.get_option( 'gmgt_system_logo' ).' height="25px" width="25px" class="img-circle" />';
													}
													else
														echo '<img src='.$membershipimage.' height="25px" width="25px" class="img-circle"/>';
											echo " ".$retrieved_data->membership_label;?></p>
											<?php 
											$i++;
										}
									 }?>
								</div>
							</div>
							<div class="panel panel-white">
								<div class="panel-heading">
									<h3 class="panel-title"><?php _e('Group List','gym_mgt');?></h3>						
								</div>
								<div class="panel-body">
									<?php $groupdata = $obj_dashboard->get_grouplist();
								 if(!empty($groupdata))
									 {
										$i= 1;
										//var_dump($membershipdata);
										foreach ($groupdata as $retrieved_data)
										{
											?>
											<p><?php $groupimage=$retrieved_data->gmgt_groupimage;
													if(empty($groupimage))
													{
																	echo '<img src='.get_option( 'gmgt_system_logo' ).' height="25px" width="25px" class="img-circle" />';
													}
													else
														echo '<img src='.$groupimage.' height="25px" width="25px" class="img-circle"/>';
											echo " ".$retrieved_data->group_name;?></p>
											<?php 
											$i++;
										}
									 }?>
								</div>
								
							</div>
							<?php 
								$work_out = $obj_gym->get_today_workout(get_current_user_id());
								//var_dump($work_out);
								if(!empty($work_out))
								{
									?>
									<div class="panel panel-white">
									<div class="panel-heading">
									<h3 class="panel-title"><?php _e('Today Workout','gym_mgt');?></h3>						
									</div>
									<div class="panel-body">
									<?php 
									foreach($work_out as $retrive)
									{
										echo "<p>".$retrive->workout_name." Sets ".$retrive->sets." Reps ".$retrive->reps."</p>";
									}
									?>
									</div>
									</div>
									<?php 
								}
								?>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-12">
						<div class="panel panel-white">
							<div class="panel-body">
								<div id="calendar"></div>
							</div>
						</div>
					</div>
				</div>	<!-- End Row2 -->
					
				<?php if($obj_gym->role=='member')
				{
						$weight_data = $obj_gym->get_weight_report('Weight',$user_id);
						$option =  $obj_gym->report_option('Weight');
						require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';
						$GoogleCharts = new GoogleCharts;
						$chart = $GoogleCharts->load( 'LineChart' , 'wait_reort' )->get( $weight_data , $option);	
						?>
					<!---End new dashboard------>
					<div class="row"><!-- Start Row3 -->
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="panel panel-white">
								<div class="panel-heading">
									<h3 class="panel-title"><?php _e('Weight Progress Report','gym_mgt');?></h3>						
								</div>
								    <div class="panel-body">
									    <div id="wait_reort" style="width: 100%; height: 250px;">
									<?php if(empty($weight_data) || count($weight_data) == 1)
										_e('There is not enough data to generate report','gym_mgt')?>
									    </div>
									  <!-- Javascript --> 
									    <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
									    <script type="text/javascript">
												<?php 
												if(!empty($weight_data) && count($weight_data) > 1)
												echo $chart;?>
									    </script>
							        </div>
							</div>
						</div>
						<?php 
						$thigh_data = $obj_gym->get_weight_report('Waist',$user_id);
						$option =  $obj_gym->report_option('Waist');
						$GoogleCharts = new GoogleCharts;
						if(!empty($thigh_data))	
						$chart = $GoogleCharts->load( 'LineChart' , 'chart_div1' )->get( $thigh_data , $option );
						?>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="panel panel-white">
								<div class="panel-heading">
									<h3 class="panel-title"><?php _e('Waist Progress Report','gym_mgt');?></h3>						
								</div>
								<div class="panel-body">
									<div id="chart_div1" style="width: 100%; height: 250px;">
									<?php 
									if(empty($thigh_data) || count($thigh_data) == 1)
									_e('There is not enough data to generate report','gym_mgt')?>
									</div>
			  
							    <!-- Javascript --> 
							    <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
							    <script type="text/javascript">
										<?php
										if(!empty($thigh_data) && count($thigh_data) > 1)
										echo $chart;?>
							    </script>
								</div>
							</div>
						</div>
					</div><!-- End Row3 -->
				<div class="row"><!-- Start Row4 -->
					<?php 
						$height_data = $obj_gym->get_weight_report('Height',$user_id);
						$option =  $obj_gym->report_option('Height');
					
						$GoogleCharts = new GoogleCharts;
						$chart = $GoogleCharts->load( 'LineChart' , 'height_report' )->get( $height_data , $option );
					?>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="panel panel-white">
								<div class="panel-heading">
									<h3 class="panel-title"><?php _e('Height Progress Report','gym_mgt');?></h3>						
								</div>
								<div class="panel-body">
									<div id="height_report" style="width: 100%; height: 250px;">
									<?php if(empty($height_data) || count($height_data) == 1)
										_e('There is not enough data to generate report','gym_mgt')?>
									</div>
			  
								  <!-- Javascript --> 
								    <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
								    <script type="text/javascript">
								 			<?php 
											if(!empty($height_data) && count($height_data) > 1)
											echo $chart;?>
									</script>
								</div>
						    </div>
						 </div>
						<?php 
							$chest_data = $obj_gym->get_weight_report('Chest',$user_id);
							$option =  $obj_gym->report_option('Chest');
							$GoogleCharts = new GoogleCharts;
							$chart = $GoogleCharts->load( 'LineChart' , 'chart_chest' )->get( $chest_data , $option );
						
						?>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="panel panel-white">
								<div class="panel-heading">
									<h3 class="panel-title"><?php _e('Chest Progress Report','gym_mgt');?></h3>						
								</div>
								<div class="panel-body">
									<div id="chart_chest" style="width: 100%; height: 250px;">
									<?php if(empty($chest_data) || count($chest_data) == 1)
								_e('There is not enough data to generate report','gym_mgt')?>
									</div>
			  
								  <!-- Javascript --> 
								    <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
								    <script type="text/javascript">
											<?php 
										if(!empty($chest_data) && count($chest_data) > 1)
											echo $chart;?>
								    </script>
								</div>
							</div>
						</div>
				   <!--THIGH REPORT  -->	
					<?php 
					$thigh_data = $obj_gym->get_weight_report('Thigh',$user_id);
					$option =  $obj_gym->report_option('Thigh');
					require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';
					$GoogleCharts = new GoogleCharts;		
					$thigh_chart = $GoogleCharts->load( 'LineChart' , 'thigh_report' )->get( $thigh_data , $option );		
					?>
					<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="panel panel-white">
								<div class="panel-heading">
									<h3 class="panel-title"><?php _e('Thigh Progress Report','gym_mgt');?></h3>						
								</div>
								<div class="panel-body">
									<div id="thigh_report" style="width: 100%; height: 250px;">
									<?php if(empty($thigh_data) || count($thigh_data) == 1)
								     _e('There is not enough data to generate report','gym_mgt')?>
								    </div>
			  
								  <!-- Javascript --> 
								  <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
								  <script type="text/javascript">
											<?php 
										if(!empty($thigh_data) && count($thigh_data) > 1)
											echo $thigh_chart;?>
									</script>
								</div>
							</div>
					</div>
					<!--ARMS REPORT  -->	
					<?php 
					$arm_data = $obj_gym->get_weight_report('Arms',$user_id);
					$option =  $obj_gym->report_option('Arms');
					require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';
					$GoogleCharts = new GoogleCharts;		
					$arm_chart = $GoogleCharts->load( 'LineChart' , 'arm_report' )->get( $arm_data , $option );
					?>
					<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="panel panel-white">
								<div class="panel-heading">
									<h3 class="panel-title"><?php _e('Arms Progress Report','gym_mgt');?></h3>						
								</div>
								<div class="panel-body">
										<div id="arm_report" style="width: 100%; height: 250px;">
										<?php if(empty($arm_data) || count($arm_data) == 1)
									_e('There is not enough data to generate report','gym_mgt')?>
										</div>
				  
								   <!-- Javascript --> 
								   <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
								   <script type="text/javascript">
											<?php 
										if(!empty($arm_data) && count($arm_data) > 1)
											echo $arm_chart;?>
									</script>
								</div>
							</div>
					</div>
				    <!--FAT REPORT -->	
					<?php 
					$fat_data = $obj_gym->get_weight_report('Fat',$user_id);
					$option =  $obj_gym->report_option('Fat');
					require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';
					$GoogleCharts = new GoogleCharts;		
					$fat_chart = $GoogleCharts->load( 'LineChart' , 'fat_report' )->get( $fat_data , $option );		
					?>
					<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="panel panel-white">
								<div class="panel-heading">
									<h3 class="panel-title"><?php _e('Fat Progress Report','gym_mgt');?></h3>						
								</div>
								<div class="panel-body">
									<div id="fat_report" style="width: 100%; height: 250px;">
									<?php if(empty($fat_data) || count($fat_data) == 1)
								_e('There is not enough data to generate report','gym_mgt')?>
									</div>
			  
							  <!-- Javascript --> 
								<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
								<script type="text/javascript">
										<?php 
									if(!empty($fat_data) && count($fat_data) > 1)
										echo $fat_chart;?>
								</script>
								</div>
							</div>
					</div>
				</div><!-- End Row4 -->
					<?php 
				}?>
			</div>
		</div>
    </div>
</body>
</html>
<?php  ?>