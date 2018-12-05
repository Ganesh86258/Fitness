<?php 
require_once GMS_PLUGIN_DIR . '/lib/chart/GoogleCharts.class.php';
$GoogleCharts = new GoogleCharts;
$obj_dashboard= new MJ_Gmgtdashboard;
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
if (! empty ( $birthday_boys ))
{
	foreach ( $birthday_boys as $boys )
	{
		$startdate = date("Y",strtotime($boys->birth_date));
		$enddate = $startdate + 90;
		$years = range($startdate,$enddate,1);
		foreach($years as $year)
		{	
			$startdate1=date("m-d",strtotime($boys->birth_date));
			 $cal_array [] = array (
			'title' => $boys->first_name."'s Birthday",
			'start' =>"{$year}-{$startdate1}",
			'end' =>"{$year}-{$startdate1}",
			'backgroundColor' => '#F25656');
		} 

	}
}
$all_notice = "";
	$args['post_type'] = 'gmgt_notice';
	$args['posts_per_page'] = -1;
	$args['post_status'] = 'public';
	$q = new WP_Query();
	$all_notice = $q->query( $args );
	if (! empty ( $all_notice ))
	{
		foreach ( $all_notice as $notice ) 
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
	$(document).ready(function()
	{
		$('#calendar').fullCalendar(
		{
			 header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				editable: false,
			eventLimit: true, // allow "more" link when too many events
			events: <?php echo json_encode($cal_array);?>,
			forceEventDuration : true,
	        eventMouseover: function (event, jsEvent, view) {
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

			 var newdate = event.end;
			 var date = new Date(newdate);
			 var newdate1 = new Date(date);
			 newdate1.setDate(newdate1.getDate() - 1);
			 var dateObj = new Date(newdate1);
			 var momentObj = moment(dateObj);
			 var momentString = momentObj.format(dateformate);
			 
			 var newstartdate = event.start;
			 var date = new Date(newstartdate);
			 var startdate = new Date(date);
			 var dateObjstart = new Date(startdate);
			 var momentObjstart = moment(dateObjstart);
			 var momentStringstart = momentObjstart.format(dateformate);
						tooltip = '<div class="tooltiptopicevent" style="width:auto;height:auto;background:#feb811;position:absolute;z-index:10001;padding:10px 10px 10px 10px ;  line-height: 200%;">' + '<?php _e('Title Name','gym_mgt'); ?>' + ' : ' + event.title + '</br>' + ' <?php _e('Start Date','gym_mgt'); ?> ' + ' : ' + momentStringstart + '</br>' + '<?php _e('End Date','gym_mgt'); ?>' + ' : ' + momentString + '</br>' +  ' </div>';
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
					eventMouseout: function (data, event, view) {
						$(this).css('z-index', 8);

						$('.tooltiptopicevent').remove();

					},
		});
	});
</script>

<div class="page-inner" style="min-height:1088px !important">
	<div class="page-title">
		<h3><img src="<?php echo get_option( 'gmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'gmgt_system_name' );?>
		</h3>
	</div>
	<div id="main-wrapper">		
		<div class="row"><!-- Start Row2 -->
		    <div class="row left_section col-md-8 col-sm-8">
			     <div class="col-lg-3 col-md-3 col-xs-6 col-sm-6">
					<a href="<?php echo admin_url().'admin.php?page=gmgt_member';?>">
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
				<div class="col-lg-3 col-md-3 col-xs-6 col-sm-6">
					<a href="<?php echo admin_url().'admin.php?page=gmgt_staff';?>">
						<div class="panel info-box panel-white">
							<div class="panel-body staff-member">
								<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard/staff-member.png"?>" class="dashboard_background">
								<div class="info-box-stats">
									<p class="counter"><?php echo count(get_users(array('role'=>'staff_member')));?><span class="info-box-title"><?php echo esc_html( __( 'Staff Member', 'gym_mgt' ) );?></span></p>
								</div>
							</div>
						</div>
					</a>
				</div>
				<div class="col-lg-3 col-md-3 col-xs-6 col-sm-6">
					<a href="<?php echo admin_url().'admin.php?page=gmgt_group';?>">
						<div class="panel info-box panel-white">
							<div class="panel-body group">
								<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard/group.png"?>" class="dashboard_background">
								<div class="info-box-stats groups-label">
									<p class="counter"><?php echo $obj_dashboard->count_group();?><span class="info-box-title"><?php echo esc_html( __( 'Group', 'gym_mgt' ) );?></span></p>
								</div>
								
							</div>
						</div>
					</a>
				</div>
				<div class="col-lg-3 col-md-3 col-xs-6 col-sm-6">
					<a href="<?php echo admin_url().'admin.php?page=Gmgt_message';?>">
						<div class="panel info-box panel-white">
							<div class="panel-body message">
								<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard/message.png"?>" class="dashboard_background_message">
								<div class="info-box-stats">
									<p class="counter"><?php echo count(gmgt_count_inbox_item(get_current_user_id()));?><span class="info-box-title"><?php echo esc_html( __( 'Message', 'gym_mgt' ) );?></span></p>
								</div>
							</div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-md-4 membership-list col-sm-4 col-xs-12">
				<div class="panel panel-white">
					<div class="panel-heading">
							<h3 class="panel-title"><?php _e('Membership','gym_mgt');?></h3>						
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
			</div>
			<div class="col-md-8 col-sm-8 col-xs-12">
				<div class="panel panel-white">
					<div class="panel-body">
						<div id="calendar"></div>
					</div>
				</div>
			</div>
		</div>	<!-- End row2 -->
		<div class="row"><!-- Start Row3 -->
			<div class="col-md-6 col-sm-6 col-xs-12">
			<?php 
		$month =array('1'=>__('January','apartment_mgt'),'2'=>__('February','apartment_mgt'),'3'=>__('March','apartment_mgt'),'4'=>__('April','apartment_mgt'),
		'5'=>__('May','apartment_mgt'),'6'=>__('June','apartment_mgt'),'7'=>__('July','apartment_mgt'),'8'=>__('August','apartment_mgt'),
		'9'=>__('September','apartment_mgt'),'10'=>"__('Octomber','apartment_mgt')",'11'=>__('November','apartment_mgt'),'12'=>__('December','apartment_mgt'),);
					$year =isset($_POST['year'])?$_POST['year']:date('Y');
					
					global $wpdb;
					$table_income_payment_history = $wpdb->prefix."gmgt_income_payment_history";
					$table_membership_payment_history = $wpdb->prefix."gmgt_membership_payment_history";
					$table_sales_payment_history = $wpdb->prefix."gmgt_sales_payment_history";
					
					$income="SELECT EXTRACT(MONTH FROM paid_by_date) as date,sum(amount) as count FROM ".$table_income_payment_history." WHERE YEAR(paid_by_date) =".$year." group by month(paid_by_date) ORDER BY paid_by_date ASC";
					$membership="SELECT EXTRACT(MONTH FROM paid_by_date) as date,sum(amount) as count FROM ".$table_membership_payment_history." WHERE YEAR(paid_by_date) =".$year." group by month(paid_by_date) ORDER BY paid_by_date ASC";
					$sales="SELECT EXTRACT(MONTH FROM paid_by_date) as date,sum(amount) as count FROM ".$table_sales_payment_history." WHERE YEAR(paid_by_date) =".$year." group by month(paid_by_date) ORDER BY paid_by_date ASC";
					
					
					$income_result=$wpdb->get_results($income);
					$membership_result=$wpdb->get_results($membership);
					$sales_result=$wpdb->get_results($sales);					
					
					$month_array = array("1","2","3","4","5","6","7","8","9","10","11","12");
					$data_array = array();
					foreach($month_array as $m)
					{
						$data_array[$m] = 0;
						foreach($income_result as $a)
						{
							if($a->date == $m){
								$data_array[$m] = $data_array[$m] + $a->count;
							}
						}
						
						foreach($membership_result as $a)
						{
							if($a->date == $m){
								$data_array[$m] = $data_array[$m] + $a->count;
							}
						}
						
						foreach($sales_result as $a)
						{
							if($a->date == $m){
								$data_array[$m] = $data_array[$m] + $a->count;
							}
						}
						
						if($data_array[$m] == 0)
						{
							unset($data_array[$m]);
						}
					}
					
					$chart_array = array();
					
					$chart_array[] = array( __('Month','gym_mgt'), __('Payment','gym_mgt'));
					
					foreach($data_array as $key=>$value)
					{	
						foreach($month as $key1=>$value1)
						{	
							if($key1==$key)
							{								
								$chart_array[]=array( __($value1,'gym_mgt'),$value);		
							}					
						}
					} 
					
					 $options = Array(
								'title' => __('Payment by month','gym_mgt'),
								'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
								'legend' =>Array('position' => 'right',
											'textStyle'=> Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans')),
								
								'hAxis' => Array(
									'title' => __('Month','gym_mgt'),
									'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
									'textStyle' => Array('color' => '#66707e','fontSize' => 11),
									'maxAlternation' => 2
																	
									),
								'vAxis' => Array(
									'title' => __('Payment','gym_mgt'),
									 'minValue' => 0,
									'maxValue' => 5,
									 'format' => '#',
									'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
									'textStyle' => Array('color' => '#66707e','fontSize' => 12)
									),
					 		'colors' => array('#22BAA0')
								);
					require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';
					$GoogleCharts = new GoogleCharts;
					$chart = $GoogleCharts->load( 'column' , 'chart_div1' )->get( $chart_array , $options );
					?>
				<div class="panel panel-white">
					<div class="panel-heading">
						<h3 class="panel-title"><?php _e('Payment','gym_mgt');?></h3>						
					</div>
					<div class="panel-body">
						<div id="chart_div1" style="width: 100%; height: 500px;">
						<?php
							if(empty($income_result) && empty($membership_result) && empty($sales_result))
						_e('There is not enough data to generate report','gym_mgt');?>
						</div>
						<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
						<script type="text/javascript">
									<?php 
								if(!empty($income_result) || !empty($membership_result) || !empty($sales_result))
								echo $chart;?>
						</script>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<?php 
				global $wpdb;
				$table_attendance = $wpdb->prefix .'gmgt_attendence';
				$table_class = $wpdb->prefix .'gmgt_class_schedule';
				$chart_array = array();
				$report_2 =$wpdb->get_results("SELECT  at.class_id,
						SUM(case when `status` ='Present' then 1 else 0 end) as Present,
						SUM(case when `status` ='Absent' then 1 else 0 end) as Absent
						from $table_attendance as at,$table_class as cl where at.attendence_date >  DATE_SUB(NOW(), INTERVAL 1 WEEK) AND at.class_id = cl.class_id  AND at.role_name = 'member' GROUP BY at.class_id") ;
						$chart_array[] = array(__('Class','gym_mgt'),__('Present','gym_mgt'),__('Absent','gym_mgt'));
						if(!empty($report_2))
							foreach($report_2 as $result)
							{
								$class_id =gmgt_get_class_name($result->class_id);
								$chart_array[] = array("$class_id",(int)$result->Present,(int)$result->Absent);
							}
							$options = Array(
												'title' => __('Member Attendance Report','gym_mgt'),
												'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
												'legend' =>Array('position' => 'right',
												'textStyle'=> Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans')),
													
												'hAxis' => Array(
																	'title' =>  __('Class','gym_mgt'),
																	'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
																	'textStyle' => Array('color' => '#66707e','fontSize' => 10),
																	'maxAlternation' => 2
																),
												'vAxis' => Array(
																	'title' =>  __('No of Member','gym_mgt'),
																	'minValue' => 0,
																	'maxValue' => 5,
																	'format' => '#',
																	'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
																	'textStyle' => Array('color' => '#66707e','fontSize' => 12)
																),
												'colors' => array('#22BAA0','#f25656')
																			);
												$GoogleCharts = new GoogleCharts;
												$chart = $GoogleCharts->load( 'column' , 'attendance_report' )->get( $chart_array , $options );
											?>
					<div class="panel panel-white">
						<div class="panel-heading">
							<h3 class="panel-title"><?php _e('Member Attendance Report','gym_mgt');?></h3>						
						</div>
						<div class="panel-body">
							<div id="attendance_report" style="width: 100%; height: 500px;">
							<?php
							if(empty($report_2))
								_e('There is not enough data to generate report','gym_mgt');?>
							</div>
						  <!-- Javascript --> 
							<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
							<script type="text/javascript">
									<?php
									if(!empty($report_2))
									echo $chart;?>
							</script>
						</div>
				    </div>
			</div>
			<div class="clear"></div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<?php 
					global $wpdb;
					$table_attendance = $wpdb->prefix .'gmgt_attendence';
					$table_class = $wpdb->prefix .'gmgt_class_schedule';
					//$sdate = $_REQUEST['sdate'];
					//$edate = $_REQUEST['edate'];
					$sdate = '2015-09-01';
					$edate = '2015-09-10';
					$chart_array = array();
					$report_2 =$wpdb->get_results("SELECT  at.user_id,
							SUM(case when `status` ='Present' then 1 else 0 end) as Present,
							SUM(case when `status` ='Absent' then 1 else 0 end) as Absent
							from $table_attendance as at where at.attendence_date >  DATE_SUB(NOW(), INTERVAL 1 WEEK)  AND at.role_name = 'staff_member' GROUP BY at.user_id") ;
					
					$chart_array[] = array(__('Staff Member','gym_mgt'),__('Present','gym_mgt'),__('Absent','gym_mgt'));
							if(!empty($report_2))
								foreach($report_2 as $result)
								{
					
								$user_name = gym_get_display_name($result->user_id);
								$chart_array[] = array("$user_name",(int)$result->Present,(int)$result->Absent);
					}
					$options = Array(
										'title' => __('Staff Attendance Report','gym_mgt'),
										'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
										'legend' =>Array('position' => 'right',
												'textStyle'=> Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans')),
												'hAxis' => Array(
												'title' =>  __('Staff Member','gym_mgt'),
												'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
												'textStyle' => Array('color' => '#66707e','fontSize' => 10),
												'maxAlternation' => 2
												),
												'vAxis' => Array(
												'title' =>  __('Number of Staff Members','gym_mgt'),
												'minValue' => 0,
												'maxValue' => 5,
												'format' => '#',
												'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
												'textStyle' => Array('color' => '#66707e','fontSize' => 12)
												),
												'colors' => array('#22BAA0','#f25656')
									);
					$GoogleCharts = new GoogleCharts;
					$chart = $GoogleCharts->load( 'column' , 'attendance_report_staff' )->get( $chart_array , $options );
				    ?>
					<div class="panel panel-white">
						<div class="panel-heading">
							<h3 class="panel-title"><?php _e('Staff Attendance','gym_mgt');?></h3>						
						</div>
						<div class="panel-body">
							<div id="attendance_report_staff" style="width: 100%; height: 500px;">
							<?php
							if(empty($report_2))
							_e('There is not enough data to generate report','gym_mgt');?>
							</div>
					  <!-- Javascript --> 
					   <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
					    <script type="text/javascript">
								<?php 
								if(!empty($report_2))
								echo $chart;?>
					     </script>
						</div>
				    </div>
			    </div>
		</div><!-- End Row3 -->
	</div>
</div><!--  End page-inner -->
<?php ?>