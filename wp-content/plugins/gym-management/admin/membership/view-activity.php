<?php ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#activity_id').multiselect();
	$('#acitivity_form').validationEngine();
	jQuery('#activity_list').DataTable({
		"responsive": true,
		"order": [[ 0, "asc" ]],
		"aoColumns":[
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": false}]
		});
} );
</script>
     <?php 	
	if($active_tab == 'view-activity')
	 {
        	
        	$membership_id=0;
			if(isset($_REQUEST['membership_id']))
				$membership_id=$_REQUEST['membership_id'];
			$activity_result = $obj_membership->get_membership_activities($membership_id); ?>
		 <!--<div class="panel-body">
			 <form name="membership-form" action="" method="post" class="form-horizontal" id="membership-form">
					<div class="form-group col-md-6">
					<input type="hidden" name="membership_id" value="<?php echo $membership_id;?>">
					<div class="learner_user_block">
					<label for="exam_id"><?php _e('Select Activity','gym_mgt');?></label>
					<?php $activitydata=$obj_activity->get_all_activity();?>
									<select name="activity_id[]" id="activity_id" multiple="multiple" >
									 <option value =' '><?php _e('Select Activity','gym_mgt'); ?></option>
									<?php 
									$activity_array = $obj_activity->get_membership_activity($membership_id);
									if(!empty($activitydata))
									foreach($activitydata as $activity)
									{?>
										<option value="<?php echo $activity->activity_id;?>"<?php if(in_array($activity->activity_id,$activity_array)) echo "selected";?>><?php echo$activity->activity_title;?></option>
								<?php } ?>
								</select>
						</div>
					</div>
					<div class="form-group col-md-3">
						<label >&nbsp;</label>
						<input type="submit" class="btn btn-info" value="<?php _e('Add Activity','gym_mgt');?>" name="add_activities">
					</div>
				</form>	
		</div>-->
       <form name="wcwm_report" action="" method="post">
    
        <div class="panel-body">
        	<div class="table-responsive">
        <table id="activity_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			<th><?php  _e( 'Activity Name', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Activity Category', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Activity Trainer', 'gym_mgt' ) ;?></th>
               <th><?php  _e( 'Membership Name', 'gym_mgt' ) ;?></th>
			   <th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
			<th><?php  _e( 'Activity Name', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Activity Category', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Activity Trainer', 'gym_mgt' ) ;?></th>
            <th><?php  _e( 'Membership Name', 'gym_mgt' ) ;?></th>
			<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
            </tr>
        </tfoot>
 
        <tbody>
         <?php 
		
		 if(!empty($activity_result))
		 {
			 
		 	foreach ($activity_result as $activities){ 
			
				$retrieved_data=$obj_activity->get_single_activity($activities->activity_id);?>
            <tr>
				<td class="activityname"><a href="?page=gmgt_activity&tab=addactivity&action=edit&activity_id=<?php echo $retrieved_data->activity_id;?>"><?php echo $retrieved_data->activity_title;?></a></td>
				<td class="category"><?php echo get_the_title($retrieved_data->activity_cat_id);?></td>
				<td class="productquentity"><?php $user=get_userdata($retrieved_data->activity_assigned_to);
				echo $user->display_name;?></td>
                <td class="membership"><?php echo get_membership_name($activities->membership_id);?>
				 <td class="action"><a href="?page=gmgt_membership_type&tab=membershiplist&action=delete-activity&membership_id=<?php echo $membership_id;?>&assign_id=<?php echo $activities->id;?>" class="btn btn-danger" 
                onclick="return confirm('<?php _e('Do you really want to delete this record?','gym_mgt');?>');">
                <?php _e( 'Delete', 'gym_mgt' ) ;?> </a> </td>
				</td>
             </tr>
            <?php } 
			
		} ?>
     
        </tbody>
        
        </table>
        </div>
        </div>
       
</form>

        
     <?php 
	 }
	 ?>