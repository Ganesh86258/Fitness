<?php 
$obj_gyme = new MJ_Gym_management();
?>
<script type="text/javascript">
$(document).ready(function() {
	$('#member_form').validationEngine();
	$('#birth_date').datepicker({
		  changeMonth: true,
	        changeYear: true,
	        yearRange:'-65:+0',
	        onChangeMonthYear: function(year, month, inst) {
	            $(this).val(month + "/" + year);
	        }
                    
                }); 
} );
</script>
     <?php	
        	$member_id=0;
			if(isset($_REQUEST['member_id']))
				$member_id=$_REQUEST['member_id'];
			$edit=0;					
					$edit=1;
					$user_info = get_userdata($member_id);
					
		?>
		
<div class="panel-body">
	<div class="member_view_row1">
	<div class="col-md-8 col-sm-12 membr_left">
		<div class="col-md-6 col-sm-12 left_side">
		<?php 
		if($user_info->gmgt_user_avatar == "")
			                     	{?>
			                     	<img alt="" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">
			                     	<?php }
			                     	else {
			                     		?>
							        <img style="max-width:100%;" src="<?php if($edit)echo esc_url( $user_info->gmgt_user_avatar ); ?>" />
							        <?php 
			                     	}
		?>
		</div>
		<div class="col-md-6 col-sm-12 right_side">
		<div class="table_row">
			<div class="col-md-5 col-sm-12 table_td">
				<i class="fa fa-user"></i> 
				<?php _e('Name','gym_mgt'); ?>	
			</div>
			<div class="col-md-7 col-sm-12 table_td">
				<span class="txt_color">
					<?php echo $user_info->first_name." ".$user_info->middle_name." ".$user_info->last_name;?> 
				</span>
			</div>
		</div>
		<div class="table_row">
			<div class="col-md-5 col-sm-12 table_td">
				<i class="fa fa-envelope"></i> 
				<?php _e('Email','gym_mgt');?> 	
			</div>
			<div class="col-md-7 col-sm-12 table_td">
				<span class="txt_color"><?php echo $user_info->user_email;?></span>
			</div>
		</div>
		<div class="table_row">
			<div class="col-md-5 col-sm-12 table_td"><i class="fa fa-phone"></i> <?php _e('Mobile No','gym_mgt');?> </div>
			<div class="col-md-7 col-sm-12 table_td">
				<span class="txt_color">
					<span class="txt_color"><?php echo $user_info->mobile;?> </span>
				</span>
			</div>
		</div>
		<div class="table_row">
			<div class="col-md-5 col-sm-12 table_td">
				<i class="fa fa-calendar"></i> <?php _e('Date Of Birth','gym_mgt');?>	
			</div>
			<div class="col-md-7 col-sm-12 table_td">
				<span class="txt_color"><?php echo getdate_in_input_box($user_info->birth_date);?></span>
			</div>
		</div>
		<div class="table_row">
			<div class="col-md-5 col-sm-12 table_td">
				<i class="fa fa-mars"></i> <?php _e('Gender','gym_mgt');?> 
			</div>
			<div class="col-md-7 col-sm-12 table_td">
				<span class="txt_color"><?php echo $user_info->gender;?></span>
			</div>
		</div>
		<div class="table_row">
			<div class="col-md-5 col-sm-12 table_td">
				<i class="fa fa-graduation-cap"></i> <?php _e('Class','gym_mgt');?>
			</div>
			<div class="col-md-7 col-sm-12 table_td">
				<span class="txt_color"><?php echo gmgt_get_class_name($user_info->class_id);?></span>
			</div>
		</div>
		<div class="table_row">
			<div class="col-md-5 col-sm-12 table_td">
				<i class="fa fa-user"></i> <?php _e('User Name','gym_mgt');?>
			</div>
			<div class="col-md-7 col-sm-12 table_td">
				<span class="txt_color"><?php echo $user_info->user_login;?> </span>
			</div>
		</div>
		
		</div>
	</div>
	<div class="col-md-4 col-sm-12 member_right">	
			<span class="report_title">
				<span class="fa-stack cutomcircle">
					<i class="fa fa-align-left fa-stack-1x"></i>
				</span> 
				<span class="shiptitle"><?php _e('More Info','gym_mgt');?></span>		
			</span>
			<div class="table_row">
				<div class="col-md-6 col-sm-12 table_td">
					<i class="fa fa-user"></i> <?php _e('Staff Member','gym_mgt'); ?>	
				</div>
				<div class="col-md-6 col-sm-12 table_td">
					<span class="txt_color"><?php echo gym_get_display_name($user_info->staff_id);?></span>
				</div>
			</div>
			<div class="table_row">
				<div class="col-md-6 col-sm-12 table_td">
					<i class="fa fa-heart"></i><?php _e('Interest Area','gym_mgt');?>
				</div>
				<div class="col-md-6 col-sm-12 table_td">
					<span class="txt_color"><?php echo get_the_title($user_info->intrest_area);?></span>
				</div>
			</div>
			<div class="table_row">
				<div class="col-md-6 col-sm-12 table_td">
					<i class="fa fa-users"></i> <?php _e('Member Ship','gym_mgt');?>
				</div>
				<div class="col-md-6 col-sm-12 table_td">
					<span class="txt_color"><?php echo get_membership_name($user_info->membership_id);?></span>
				</div>
			</div>
			<div class="table_row">
				<div class="col-md-6 col-sm-12 table_td">
					<i class="fa fa-power-off"></i> <?php _e('Status','gym_mgt');?>
				</div>
				<div class="col-md-6 col-sm-12 table_td">
					<span class="txt_color"><?php echo $user_info->membership_status;?></span>
				</div>
			</div>
			<div class="table_row">
				<div class="col-md-6 col-sm-12 table_td">
					<i class="fa fa-map-marker"></i> <?php _e('Address','gym_mgt');?>
				</div>
				<div class="col-md-6 col-sm-12 table_td">
					<span class="txt_color"><?php 
			 if($user_info->address != '')
				echo $user_info->address.", <BR>";
			if($user_info->city_name != '')
				echo $user_info->city_name.", "; 
			
			
			?> </span>
				</div>
			</div>
			
	</div>
	</div>
	</div><div class="panel-body">
	
	<div class="clear"></div>
	<div class="col-md-6  col-sm-6  col-xs-12 border">
		<span class="report_title">
			<span class="fa-stack cutomcircle">
				<i class="fa fa-line-chart fa-stack-1x"></i>
			</span> 
			<span class="shiptitle"><?php _e('Weight','gym_mgt');?></span>	
			<a href="<?php echo admin_url()?>admin.php?page=gmgt_workout&tab=addmeasurement&user_id=<?php echo $_REQUEST['member_id'];?>&result_measurment=Weight" 
			class="btn btn-danger right"> <?php _e('Add Weight','gym_mgt');?></a>	
		</span>
		
		<?php 
		$weight_data = $obj_gyme->get_weight_report('Weight',$_REQUEST['member_id']);
		$option =  $obj_gyme->report_option('Weight');
		require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';
		$GoogleCharts = new GoogleCharts;		
		$wait_chart = $GoogleCharts->load( 'LineChart' , 'weight_report' )->get( $weight_data , $option );		
		?>
		<div id="weight_report" style="width: 100%; height: 250px;">
		<?php 
		if(empty($weight_data) || count($weight_data) == 1)
		_e('There is not enough data to generate report','gym_mgt')?>
		</div>   
		<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
  		<script type="text/javascript">
			<?php 
			if(!empty($weight_data) && count($weight_data) > 1)
			echo $wait_chart;?>
		</script>
	</div>
	<div class="col-md-6  col-sm-6  col-xs-12 border borderleft">
		<span class="report_title">
			<span class="fa-stack cutomcircle">
				<i class="fa fa-line-chart fa-stack-1x"></i>
			</span> 
			<span class="shiptitle"><?php _e('Waist Report','gym_mgt');?></span>
			<a href="<?php echo admin_url()?>admin.php?page=gmgt_workout&tab=addmeasurement&user_id=<?php echo $_REQUEST['member_id'];?>&result_measurment=Waist" 
			class="btn btn-danger right"> <?php _e('Add Waist','gym_mgt');?></a>		
		</span>
		<?php 
		$waist_chart = $obj_gyme->get_weight_report('Waist',$_REQUEST['member_id']);
		
		$option =  $obj_gyme->report_option('Waist');
		
		$GoogleCharts = new GoogleCharts;		
		$waist_chartreport = $GoogleCharts->load( 'LineChart' , 'waist_report' )->get( $waist_chart , $option );	
		
		?>
		<div id="waist_report" style="width: 100%; height: 250px;">
		<?php 
		if(empty($waist_chart) || count($waist_chart) == 1)
		_e('There is not enough data to generate report','gym_mgt')?>
		</div>   
		
  		<script type="text/javascript">
			<?php 
			if(!empty($waist_chart) && count($waist_chart) > 1)
			echo $waist_chartreport;?>
		</script>
	</div>
	<div class="col-md-6  col-sm-6  col-xs-12 border">
		<span class="report_title">
			<span class="fa-stack cutomcircle">
				<i class="fa fa-line-chart fa-stack-1x"></i>
			</span> 
			<span class="shiptitle"><?php _e('Height Report','gym_mgt');?></span>	
			<a href="<?php echo admin_url()?>admin.php?page=gmgt_workout&tab=addmeasurement&user_id=<?php echo $_REQUEST['member_id'];?>&result_measurment=Height" 
			class="btn btn-danger right"> <?php _e('Add Height','gym_mgt');?></a>	
		</span>
		<?php 
		$height_data = $obj_gyme->get_weight_report('Height',$_REQUEST['member_id']);
		$option =  $obj_gyme->report_option('Height');
		
		$GoogleCharts = new GoogleCharts;		
		$height_chart = $GoogleCharts->load( 'LineChart' , 'height_reort' )->get( $height_data , $option );		
		?>
		<div id="height_reort" style="width: 100%; height: 250px;">
		<?php if(empty($height_data) || count($height_data) == 1)
		_e('There is not enough data to generate report','gym_mgt')?>
		</div>   
		<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
  		<script type="text/javascript">
			<?php 
			if(!empty($height_data) && count($height_data) > 1)
			echo $height_chart;?>
		</script>
		
	</div>
	<div class="col-md-6  col-sm-6  col-xs-12 border borderleft">
		<span class="report_title">
			<span class="fa-stack cutomcircle">
				<i class="fa fa-line-chart fa-stack-1x"></i>
			</span> 
			<span class="shiptitle"><?php _e('Chest Report','gym_mgt');?></span>	
			<a href="<?php echo admin_url()?>admin.php?page=gmgt_workout&tab=addmeasurement&user_id=<?php echo $_REQUEST['member_id'];?>&result_measurment=Chest" 
			class="btn btn-danger right"> <?php _e('Add Chest','gym_mgt');?></a>	
		</span>
		<?php 
		$chest_data = $obj_gyme->get_weight_report('Chest',$_REQUEST['member_id']);
		$option =  $obj_gyme->report_option('Chest');
		require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';
		$GoogleCharts = new GoogleCharts;		
		$chest_chart = $GoogleCharts->load( 'LineChart' , 'chest_reort' )->get( $chest_data , $option );		
		?>
		<div id="chest_reort" style="width: 100%; height: 250px;">
		<?php if(empty($chest_data) || count($chest_data) == 1)
		_e('There is not enough data to generate report','gym_mgt')?>
		</div>   
		<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
  		<script type="text/javascript">
			<?php 
			if(!empty($chest_data) && count($chest_data) > 1)
			echo $chest_chart;?>
		</script>
	</div>
	<div class="col-md-6  col-sm-6  col-xs-12 border borderleft">
		<span class="report_title">
			<span class="fa-stack cutomcircle">
				<i class="fa fa-line-chart fa-stack-1x"></i>
			</span> 
			<span class="shiptitle"><?php _e('Thigh Report','gym_mgt');?></span>	
			<a href="<?php echo admin_url()?>admin.php?page=gmgt_workout&tab=addmeasurement&user_id=<?php echo $_REQUEST['member_id'];?>&result_measurment=Thigh" 
			class="btn btn-danger right"> <?php _e('Add Thigh','gym_mgt');?></a>	
		</span>
		<?php 
		$thigh_data = $obj_gyme->get_weight_report('Thigh',$_REQUEST['member_id']);
		$option =  $obj_gyme->report_option('Thigh');
		require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';
		$GoogleCharts = new GoogleCharts;		
		$thigh_chart = $GoogleCharts->load( 'LineChart' , 'thigh_reort' )->get( $thigh_data , $option );		
		?>
		<div id="thigh_reort" style="width: 100%; height: 250px;">
		<?php if(empty($thigh_data) || count($thigh_data) == 1)
		_e('There is not enough data to generate report','gym_mgt')?>
		</div>   
		<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
  		<script type="text/javascript">
			<?php 
			if(!empty($thigh_data) && count($thigh_data) > 1)
			echo $thigh_chart;?>
		</script>
	</div>
	<div class="col-md-6  col-sm-6  col-xs-12 border borderleft">
		<span class="report_title">
			<span class="fa-stack cutomcircle">
				<i class="fa fa-line-chart fa-stack-1x"></i>
			</span> 
			<span class="shiptitle"><?php _e('Arms Report','gym_mgt');?></span>	
			<a href="<?php echo admin_url()?>admin.php?page=gmgt_workout&tab=addmeasurement&user_id=<?php echo $_REQUEST['member_id'];?>&result_measurment=Arms" 
			class="btn btn-danger right"> <?php _e('Add Arms','gym_mgt');?></a>	
		</span>
		<?php 
		$arm_data = $obj_gyme->get_weight_report('Arms',$_REQUEST['member_id']);
		$option =  $obj_gyme->report_option('Arms');
		require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';
		$GoogleCharts = new GoogleCharts;		
		$arm_chart = $GoogleCharts->load( 'LineChart' , 'arm_reort' )->get( $arm_data , $option );		
		?>
		<div id="arm_reort" style="width: 100%; height: 250px;">
		<?php if(empty($arm_data) || count($arm_data) == 1)
		_e('There is not enough data to generate report','gym_mgt')?>
		</div>   
		<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
  		<script type="text/javascript">
			<?php 
			if(!empty($arm_data) && count($arm_data) > 1)
			echo $arm_chart;?>
		</script>
	</div>
	<div class="col-md-6  col-sm-6  col-xs-12 border borderleft">
		<span class="report_title">
			<span class="fa-stack cutomcircle">
				<i class="fa fa-line-chart fa-stack-1x"></i>
			</span> 
			<span class="shiptitle"><?php _e('Fat Report','gym_mgt');?></span>	
			<a href="<?php echo admin_url()?>admin.php?page=gmgt_workout&tab=addmeasurement&user_id=<?php echo $_REQUEST['member_id'];?>&result_measurment=Fat" 
			class="btn btn-danger right"> <?php _e('Add Fat','gym_mgt');?></a>	
		</span>
		<?php 
		$fat_data = $obj_gyme->get_weight_report('Fat',$_REQUEST['member_id']);
		$option =  $obj_gyme->report_option('Fat');
		require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';
		$GoogleCharts = new GoogleCharts;		
		$fat_chart = $GoogleCharts->load( 'LineChart' , 'fat_reort' )->get( $fat_data , $option );		
		?>
		<div id="fat_reort" style="width: 100%; height: 250px;">
		<?php if(empty($fat_data) || count($fat_data) == 1)
		_e('There is not enough data to generate report','gym_mgt')?>
		</div>   
		<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
  		<script type="text/javascript">
			<?php 
			if(!empty($fat_data) && count($fat_data) > 1)
			echo $fat_chart;?>
		</script>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	jQuery('#subscription_list').DataTable({
		"responsive": true,
		"order": [[ 0, "asc" ]],
		"aoColumns":[
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
					  {"bSortable": true},
					  {"bSortable": true},
					  {"bSortable": true}]
		});
} );
</script>	
<div class="panel-body">
	
		<div class="col-md-12  col-sm-12  col-xs-12" style="border:1px solid #dedede;">
		<span class="report_title">
			<span class="fa-stack cutomcircle">
				<i class="fa fa-align-left fa-stack-1x"></i>
			</span> 
			<span class="shiptitle"><?php _e('Subscription History','gym_mgt');?></span>	
		</span>
	
		 <form name="wcwm_report" action="" method="post">
		
		
		
        <table id="subscription_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			<th><?php  _e( 'Title', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Amount', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Due Amount', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Membership <BR>Start Date', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Membership <BR>End Date', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Payment Status', 'gym_mgt' ) ;?></th>
			</tr>
        </thead>
		<tfoot>
            <tr>
			<th><?php  _e( 'Title', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Amount', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Due Amount', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Membership <BR>Start Date', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Membership <BR>End Date', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Payment Status', 'gym_mgt' ) ;?></th>
			</tr>
        </tfoot>
		<tbody>
         <?php 
		$obj_membership_payment=new MJ_Gmgt_membership_payment;
		$paymentdata=$obj_membership_payment->get_member_subscription_history($member_id);
			
		 if(!empty($paymentdata))
		 {
		 	foreach ($paymentdata as $retrieved_data){ ?>
            <tr>
				<td class="productname"><?php echo get_membership_name($retrieved_data->membership_id);?></td>
				
				<td class="totalamount"><?php echo $retrieved_data->membership_amount;?></td>
				<td class="totalamount"><?php echo $retrieved_data->membership_amount-$retrieved_data->paid_amount;?></td>
				<td class="paymentdate"><?php echo getdate_in_input_box($retrieved_data->start_date);?></td>
				<td class="paymentdate"><?php echo getdate_in_input_box($retrieved_data->end_date);?></td>
				<td class="paymentdate">
				<?php 
				echo "<span class='btn btn-success btn-xs'>";
				echo get_membership_paymentstatus($retrieved_data->mp_id);
				echo "</span>";
				?>
				</td>
                
               	
               
            </tr>
            <?php } 
			
		}?>
     
        </tbody>
        
        </table>
       
		</div>
	
	</div>