<?php ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#group_form').validationEngine();
} );
</script>
<?php 	
	if($active_tab == 'addgroup')
	{
		$group_id=0;
		if(isset($_REQUEST['group_id']))
			$group_id=$_REQUEST['group_id'];
		$edit=0;
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
			{
				$edit=1;
				$result = $obj_group->get_single_group($group_id);
			}?>
        <div class="panel-body">
			<form name="group_form"  action="" method="post" class="form-horizontal" id="group_form">
			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
			<input type="hidden" name="action" value="<?php echo $action;?>">
			<input type="hidden" name="group_id" value="<?php echo $group_id;?>"  />
			<div class="form-group">
				<label class="col-sm-2 control-label" for="group_name"><?php _e('Group Name','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="group_name" class="form-control validate[required,custom[onlyLetterSp]] text-input"  maxlength="50" type="text" value="<?php if($edit){ echo $result->group_name;}elseif(isset($_POST['group_name'])) echo $_POST['group_name'];?>" name="group_name">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="gmgt_membershipimage"><?php _e('Group Image','gym_mgt');?></label>
				<div class="col-sm-8">
				<input type="text" id="gmgt_gym_background_image" class="group_image_upload" name="gmgt_groupimage" 
				value="<?php if($edit){ echo $result->gmgt_groupimage;}elseif(isset($_POST['gmgt_groupimage'])) echo $_POST['gmgt_groupimage'];?>" />	
						  <input id="upload_image_button" type="button" class="button upload_user_cover_button" value="<?php _e( 'Upload Cover Image', 'gym_mgt' ); ?>" />
						 <span class="description"><?php _e('Upload Group Image', 'gym_mgt' ); ?></span>
					<div id="upload_gym_cover_preview" style="min-height: 100px;">
					<img style="max-width:100%;" 
					src="<?php if($edit && $result->gmgt_groupimage != ''){ echo $result->gmgt_groupimage;}elseif(isset($_POST['gmgt_groupimage'])) echo $_POST['gmgt_groupimage']; else echo get_option( 'gmgt_system_logo' );?>" />
					</div>
				</div>
			</div>
			<div class="col-sm-offset-2 col-sm-8">
				<input type="submit" value="<?php if($edit){ _e('Save','gym_mgt'); }else{ _e('Save','gym_mgt');}?>" name="save_group" class="btn btn-success"/>
			</div>
			</form>
        </div>
     <?php 
	}?>