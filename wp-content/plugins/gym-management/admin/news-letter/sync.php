<?php 
$retval = $api->lists();
?>
<div class="panel-body">
    <form name="template_form" action="" method="post" class="form-horizontal" id="setting_form">
	    <div class="form-group">
			<label class="col-sm-2 control-label" for="enable_quote_tab"><?php _e('Class List','gym_mgt');?></label>
			<div class="col-sm-8">
				<div class="checkbox">
					<?php 	$classdata=$obj_class->get_all_classes();
						if(!empty($classdata))
						{
							foreach ($classdata as $retrieved_data)
							{?>
									
								  <label>
										<input type="checkbox" name="syncmail[]"  value="<?php echo $retrieved_data->class_id?>"/><?php echo $retrieved_data->class_name;?>
								  </label><br/>
									 
									
							<?php }
						}?>
			    </div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="list_id"><?php _e('Mailing List','gym_mgt');?></label>
			<div class="col-sm-8">
				<select name="list_id" id="list_id"  class="form-control">
					<option value=""><?php _e('Select list','gym_mgt');?></option>
					<?php 
					foreach ($retval['data'] as $list){
						
						echo '<option value="'.$list['id'].'">'.$list['name'].'</option>';
					}
					?>
				</select>
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">        	
        	<input type="submit" value="<?php _e('Sync Mail', 'gym_mgt' ); ?>" name="sychroniz_email" class="btn btn-success"/>
        </div>
    </form>
</div>