<?php ?>
<script type="text/javascript">
$(document).ready(function() {
	 var date = new Date();
	 date.setDate(date.getDate()-0);
	 $.fn.datepicker.defaults.format =" <?php echo get_option('gmgt_datepicker_format');?>";
	 $('#curr_date').datepicker({
	 	<?php
		if(get_option('gym_enable_datepicker_privious_date')=='no')
		{
		?>
			startDate: date,
		<?php
		}
		?>	
	 autoclose: true
   });
    $('#record_date').datepicker({
	 	<?php
		if(get_option('gym_enable_datepicker_privious_date')=='no')
		{
		?>
			startDate: date,
		<?php
		}
		?>	
	 autoclose: true
   });
	$('#workout_form').validationEngine();
	$(".display-members").select2();
} );
</script>
     <?php 	
	if($active_tab == 'addworkout')
	{
        	$workoutmember_id=0;
			if(isset($_REQUEST['workoutmember_id']))
				$workoutmember_id=$_REQUEST['workoutmember_id'];
				$view=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view')
				{
				$view=1;?>
				<form method="post" class="form-horizontal">  
					<div class="col-md-12">
									<h2><?php echo gym_get_display_name($_REQUEST['workoutmember_id']).'\'s Workout'; ?></h2>
					</div>
					<div class="form-group">
						<label class="col-sm-1 control-label" for="curr_date"><?php _e('Date','gym_mgt');?></label>
						<div class="col-sm-3">
						<input id="curr_date" class="form-control" type="text" 
						value="<?php if(isset($_POST['tcurr_date'])) echo $_POST['tcurr_date']; 
						else 
							echo  getdate_in_input_box(date("Y-m-d"));?>" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>" name="tcurr_date">
						</div>
						<div class="col-sm-3">
						<input type="submit" value="<?php _e('View Workouts','gym_mgt');?>" name="view_workouts"  class="btn btn-success"/>
						</div>
					</div>
				</form>
		       <div class="clearfix"> </div>
		        <?php 
				if(isset($_REQUEST['view_workouts']) || isset($_REQUEST['view_workouts']))
				{	
				?>
				 		<?php 
						$tcurrent_date=get_format_for_db($_POST['tcurr_date']);
						$today_workouts=$obj_workout->get_member_today_workouts($workoutmember_id,$tcurrent_date);
					    if(!empty($today_workouts))
						{
							?>
							<div class="col-md-12 my-workouts-display">
							<?php foreach($today_workouts as $value)
							{
								$workoutid=$value->user_workout_id;
								$activity_name=$value->workout_name;
								$workflow_category=$obj_workout->get_user_workouts($workoutid,$activity_name);
							?>
							<div class='col-md-10 activity-data no-padding'>
							<div class='workout_datalist_header'>
								<h2><?php echo $value->workout_name;?></h2>
							</div>
							<div class="col-md-12 workout_datalist no-padding"> 
							<?php //for($i=1;$i<=4;$i++){
								?>
						
								<div class="col-md-6 sets-row no-paddingleft">	
									<span class="text-center sets_counter"><?php echo 1 ;?></span>
									<span class="sets_kg"><?php echo $value->sets." Sets";?></span>								
									<span class="reps_count"><?php echo $workflow_category->sets." Sets";?></span>
								</div>
								<div class="col-md-6 sets-row no-paddingleft">	
									<span class="text-center sets_counter"><?php echo 2 ;?></span>
									<span class="sets_kg"><?php echo $value->reps." Reps";?></span>								
									<span class="reps_count"><?php echo $workflow_category->reps." Reps";?></span>
								</div>
								
								
							<?php 
							//}?>
							</div>
								<div class="col-md-12 workout_datalist no-padding"> 
								<div class="col-md-6 sets-row no-paddingleft">	
										<span class="text-center sets_counter"><?php echo 3;?></span>
										<span class="sets_kg"><?php echo $value->kg." Kg";?></span>								
										<span class="reps_count"><?php echo $workflow_category->kg." Kg";?></span>
									</div>
									<div class="col-md-6 sets-row no-paddingleft">	
										<span class="text-center sets_counter"><?php echo 4 ;?></span>
										<span class="sets_kg"><?php echo $value->rest_time ." Rest Time";?></span>								
										<span class="reps_count"><?php echo $workflow_category->time ." Rest Time";?></span>
									</div>
								</div>
								</div>
								<div class="border_line"></div>
								
							<?php 
							
							}
							?>
							
							</div>
						
					<?php }
						else
						{ ?>
						<span class="col-md-10"><?php _e('No Data Of Today workout','gym_mgt');?></span>
				<?php }
				}
         }
		else
		{ ?>
		<div class="panel-body">
			<form name="workout_form" action="" method="post" class="form-horizontal" id="workout_form">
			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
			<input type="hidden" name="action" value="<?php echo $action;?>">
			<input type="hidden" name="daily_workout_id" value="<?php echo $workoutmember_id;?>"  />
			

			<div class="form-group">
				<label class="col-sm-2 control-label" for="day"><?php _e('Member','gym_mgt');?> <span class="require-field">*</span></label>
				<div class="col-sm-8">
					<?php if($view){ $member_id=$result->member_id; }elseif(isset($_POST['member_id'])){$member_id=$_POST['member_id'];}else{$member_id='';}?>
					<select id="member_list" class="display-members" required="true" name="member_id">
					<option value=""><?php _e('Select Member','gym_mgt');?></option>
						<?php $get_members = array('role' => 'member');
						$membersdata=get_users($get_members);
						 if(!empty($membersdata))
						 {
							foreach ($membersdata as $member){
								if( $member->membership_status == "Continue")
									{?>
								<option value="<?php echo $member->ID;?>" <?php selected($member_id,$member->ID);?>><?php echo $member->display_name." - ".$member->member_id; ?> </option>
							<?php } }
						 }?>
				</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="record_date"><?php _e('Record Date','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="record_date" class="form-control  validate[required]" type="text" userid="<?php echo get_current_user_id();?>" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>" name="record_date" 
					value="<?php if($view){ echo $result->record_date;}elseif(isset($_POST['record_date'])){ echo $_POST['record_date'];}?>">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="workout_id"><?php _e('Workout','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8 workout_area">
				<div class='work_out_datalist'><div class='col-sm-10'><span class='col-md-10'><?php _e('Select Record Date For Today Workout','gym_mgt');?></span></div></div>
				</div>
			</div>
			
			
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="note"><?php _e('Note','gym_mgt');?></label>
				<div class="col-sm-8">
					<textarea id="note" class="form-control" name="note" maxlength="150"><?php if($view){echo $result->note; }elseif(isset($_POST['note'])) echo $_POST['note']; ?> </textarea>
				</div>
			</div>
			
			
			<div class="col-sm-offset-2 col-sm-8">
				
				<input type="submit" value="<?php if($view){ _e('Save','gym_mgt'); }else{ _e('Save','gym_mgt');}?>" name="save_workout" class="btn btn-success"/>
			</div>
			
			
			
			</form>
		</div>
		 <?php 
		}
	}
	?>