<?php ?>
<script type="text/javascript">
$(document).ready(function() {
	$(".display-members").select2();
	$('#nutrition_form').validationEngine();
        /* var start = new Date();
	 	var end = new Date(new Date().setYear(start.getFullYear()+1));
		$.fn.datepicker.defaults.format =" <?php echo get_option('gmgt_datepicker_format');?>";
		$('.start_date').datepicker({
			startDate : start,
			endDate   : end,
			autoclose: true
		}).on('changeDate', function(){
			$('.end_date').datepicker('setStartDate', new Date($(this).val()));
		}); 
		$.fn.datepicker.defaults.format =" <?php echo get_option('gmgt_datepicker_format');?>";
		$('.end_date').datepicker({
			startDate : start,
			endDate   : end,
			autoclose: true
		}).on('changeDate', function(){
			$('.start_date').datepicker('setEndDate', new Date($(this).val()));
		}); */
		var date = new Date();
		date.setDate(date.getDate()-0);
		$.fn.datepicker.defaults.format =" <?php echo get_option('gmgt_datepicker_format');?>";
		  $('.start_date').datepicker({
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
	   
	   var date = new Date();
		date.setDate(date.getDate()-0);
		$.fn.datepicker.defaults.format =" <?php echo get_option('gmgt_datepicker_format');?>";
		  $('.end_date').datepicker({
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
} );
</script>
    <?php 	
	if($active_tab == 'addnutrition')
	{
        	$nutrition_id=0;
        	$edit=0;
			 $member_id=0;
			 if(isset($_REQUEST['workoutmember_id']))
			 {
				 $member_id=$_REQUEST['workoutmember_id'];
			 }
			 
	if(isset($_REQUEST['workouttype_id']))
		$workouttype_id=$_REQUEST['workouttype_id'];
		if(isset($_REQUEST['workoutmember_id']))
		{
			$edit=1;
			$workoutmember_id=$_REQUEST['workoutmember_id'];
			
			$nutrition_logdata=get_user_nutrition($workoutmember_id);
			
		}?>
        <div class="panel-body">
			<form name="nutrition_form" action="" method="post" class="form-horizontal" id="nutrition_form">
			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
			<input type="hidden" name="action" value="<?php echo $action;?>">
			<input type="hidden" name="nutrition_id" value="<?php echo $nutrition_id;?>"  />
				<div class="form-group">
					<label class="col-sm-2 control-label" for="day"><?php _e('Member','gym_mgt');?><span class="require-field">*</span></label>	
					<div class="col-sm-8">
						<?php if(isset($_POST['member_id'])){$member_id=$_POST['member_id'];}?>
						<select id="member_list" class="display-members" name="member_id" required="true">
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
					<label class="col-sm-2 control-label" for="notice_content"><?php _e('Start Date','gym_mgt');?><span class="require-field">*</span></label>
					
					<div class="col-sm-8">
					<input id="Start_date" class="start_date form-control validate[required] text-input" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>" type="text" 
					value="<?php if(isset($_POST['start_date'])){echo $_POST['start_date'];}?>" name="start_date">
						
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="notice_content"><?php _e('End Date','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
					<input id="end_date" class="datepicker form-control validate[required] text-input end_date" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>" type="text" value="<?php if(isset($_POST['end_date'])){echo $_POST['end_date'];}?>" name="end_date">
						
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-1 control-label"></label>
					<div class="col-sm-10">
						<div class="col-md-3">
							<?php foreach (days_array() as $key=>$name){?>
							<div class="checkbox">
							  <label><input type="checkbox" value="" name="day[]" value="<?php echo $key;?>" id="<?php echo $key;?>" data-val="day"><?php echo $name; ?> </label>
							</div>
							<?php }?>
						</div>
						<div class="col-md-8 activity_list">
								<label class="activity_title checkbox">				  		
									<strong>
										<input type="checkbox" value="" name="avtivity_id[]" value="breakfast" class="nutrition_check" 
										id="breakfast"  activity_title = "" data-val="nutrition_time"><?php _e('Break Fast','gym_mgt');?></strong></label>	
										<div id="txt_breakfast"></div>
										<label class="activity_title checkbox">
										<strong>
										<input type="checkbox" value="" name="avtivity_id[]" value="lunch" class="nutrition_check" 
										id="lunch"  activity_title = "" data-val="nutrition_time"><?php _e('Lunch','gym_mgt');?></strong></label>
										<div id="txt_lunch"></div>
										<label class="activity_title checkbox"><strong>
										<input type="checkbox" value="" name="avtivity_id[]" value="dinner" class="nutrition_check" 
										id="dinner"  activity_title = "" data-val="nutrition_time"><?php _e('Dinner','gym_mgt');?></strong></label>	
										<div id="txt_dinner"></div>							
									<div class="clear"></div>
						</div>
			     	</div>
			    </div>
				<div class="col-sm-offset-2 col-sm-8">
					<div class="form-group">
						<div class="col-md-8">
							<input type="button" value="<?php _e('Step-1 Add Nutrition','gym_mgt');?>" name="save_nutrition" id="add_nutrition" class="btn btn-success"/>
						</div>
					</div>
				</div>
			    <div id="display_nutrition_list"></div>
			    <div class="clear"></div>
					</hr>
				<div class="col-sm-offset-2 col-sm-8 schedule-save-button ">
					<input type="submit" value="<?php if($edit){ _e('Step 2 Save Nutrition Plan','gym_mgt'); }else{ _e('Step 2 Save Nutrition Plan','gym_mgt');}?>" name="save_nutrition" class="btn btn-success"/>
				</div>
			</form>
        </div>
     <?php 
	}
	 if(isset($nutrition_logdata))
	 	foreach($nutrition_logdata as $row)
		{
	 	$all_logdata=get_nutritiondata($row->id); //var_dump($workout_logdata);
	 	$arranged_workout=set_nutrition_array($all_logdata);
	 	?>
	 			<div class="workout_<?php echo $row->id;?> workout-block">
	 				<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-calendar"></i> 
						<?php echo "Start From <span class='work_date'>".getdate_in_input_box($row->start_date)."</span> To <span class='work_date'>".getdate_in_input_box($row->expire_date); ?> <span class="removenutrition badge badge-delete pull-right" id="<?php echo $row->id;?>">X</span>	</h3> 
					</div>
	 				<div class="panel panel-white">
	 					<?php
	 					if(!empty($arranged_workout))
	 					{
							?>
							<div class="work_out_datalist_header">
							<div class="col-md-3 col-sm-3 col-xs-3">  
							<strong><?php _e('Day Name','gym_mgt');?></strong>
							</div>
							<div class="col-md-9 col-sm-9 col-xs-9">
							<span class="col-md-3 hidden-xs"><?php _e('Time','gym_mgt');?></span>
							<span class="col-md-6"><?php _e('Description','gym_mgt');?></span>
							
							</div>
							</div>
							<?php 
							foreach($arranged_workout as $key=>$rowdata)
							{?>
								<div class="work_out_datalist">
									<div class="col-md-3 col-sm-3 col-xs-12 day_name">  
										<?php echo $key;?>
									</div>
									<div class="col-md-9 col-sm-9 col-xs-12">
											<?php foreach($rowdata as $row){
												//echo $row;
												echo chunk_split($row,95,"<BR>");
											} ?>
									</div>
								</div>
						<?php } 
	 					}?>
	 				</div>
	 			</div>
<?php
		}	
?>