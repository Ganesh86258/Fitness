<?php 
$retval = $api->campaigns();
$retval1 = $api->lists();
?>
<div class="panel-body">
    <form name="student_form" action="" method="post" class="form-horizontal" id="setting_form">
	    <div class="form-group">
			<label class="col-sm-2 control-label" for="quote_form"><?php _e('MailChimp list','gym_mgt');?></label>
			<div class="col-sm-8">
				<select name="list_id" id="quote_form"  class="form-control">
					<option value=""><?php _e('Select list','gym_mgt');?></option>
					<?php 
					foreach ($retval1['data'] as $list){
						//echo "Id = ".$list['id']." - ".$list['name']."\n";
						//echo "Web_id = ".$list['web_id']."\n";
						//echo "\tSub = ".$list['stats']['member_count'];
						//echo "\tUnsub=".$list['stats']['unsubscribe_count'];
						//echo "\tCleaned=".$list['stats']['cleaned_count']."\n";
						echo '<option value="'.$list['id'].'">'.$list['name'].'</option>';
					}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="quote_form"><?php _e('Campaign list','gym_mgt');?></label>
			<div class="col-sm-8">
				<select name="camp_id" id="quote_form"  class="form-control">
					<option value=""><?php _e('Select Campaign','gym_mgt');?></option>
					<?php 
					foreach ($retval['data'] as $c){
						//echo "Id = ".$list['id']." - ".$list['name']."\n";
						//echo "Web_id = ".$list['web_id']."\n";
						//echo "\tSub = ".$list['stats']['member_count'];
						//echo "\tUnsub=".$list['stats']['unsubscribe_count'];
						//echo "\tCleaned=".$list['stats']['cleaned_count']."\n";
						echo '<option value="'.$c['id'].'">'.$c['title'].'</option>';
					}
					?>
				</select>
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">        	
			<input type="submit" value="<?php _e('Send Campaign', 'gym_mgt' ); ?>" name="send_campign" class="btn btn-success"/>
		</div>
    </form>
</div>