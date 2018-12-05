<?php $curr_user_id=get_current_user_id();
$obj_gym=new MJ_Gym_management($curr_user_id);
$obj_group=new MJ_Gmgtgroup;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'grouplist';
//access right
$user_access=get_userrole_wise_page_access_right_array();
if (isset ( $_REQUEST ['page'] ))
{	
	if($user_access['view']=='0')
	{	
		access_right_page_not_access_message();
		die;
	}
	if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='edit'))
	{
		if($user_access['edit']=='0')
		{	
			access_right_page_not_access_message();
			die;
		}			
	}
	if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='delete'))
	{
		if($user_access['delete']=='0')
		{	
			access_right_page_not_access_message();
			die;
		}	
	}
	if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='insert'))
	{
		if($user_access['add']=='0')
		{	
			access_right_page_not_access_message();
			die;
		}	
	}
}
if(isset($_POST['save_group']))
{ 
	if(isset($_FILES['gmgt_groupimage']) && !empty($_FILES['gmgt_groupimage']) && $_FILES['gmgt_groupimage']['size'] !=0)
	{
			
		if($_FILES['gmgt_groupimage']['size'] > 0)
		{
			 $member_image=load_documets($_FILES['gmgt_groupimage'],'gmgt_groupimage','pimg');
			 $member_image_url=content_url().'/uploads/gym_assets/'.$member_image;
		}
						
	}
	else
	{
			
		if(isset($_REQUEST['hidden_upload_user_avatar_image']))
		{
			$member_image=$_REQUEST['hidden_upload_user_avatar_image'];
		    $member_image_url=$member_image;
		}
	}
	$ext=check_valid_extension($member_image_url);
		
	if(!$ext == 0)
	{
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{
			$result=$obj_group->gmgt_add_group($_POST);
			$returnans=$obj_group->update_groupimage( $_REQUEST['group_id'],$member_image_url);
			if($returnans)
			{
				wp_redirect ( home_url().'?dashboard=user&page=group&tab=grouplist&message=2');
			}
			elseif($result)
			{
				wp_redirect ( home_url().'?dashboard=user&page=group&tab=grouplist&message=2');
			}
				
		}
		else
		{
			$result=$obj_group->gmgt_add_group($_POST,$member_image_url);
			if($result)
			{
				wp_redirect ( home_url().'?dashboard=user&page=group&tab=grouplist&message=1');
			}
		}
	}			
	else
	{
		?>
		<div id="message" class="updated below-h2 ">
		<p>
			<?php _e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?>
		</p></div>				 
		<?php 
	}		
}
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{
		
	$result=$obj_group->delete_group($_REQUEST['group_id']);
	if($result)
	{
		wp_redirect ( home_url().'?dashboard=user&page=group&tab=grouplist&message=3');
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
}
?>
<script type="text/javascript">
$(document).ready(function() 
{
	jQuery('#group_list').DataTable({
		"responsive": true,
		"order": [[ 0, "asc" ]],
		"aoColumns":[
					  {"bSortable": false},
	                  {"bSortable": true},
	                  {"bSortable": true},
		
					{"bSortable": false}]
		});
		$('#group_form').validationEngine();
} );
</script>
<!-- POP up code -->
<div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="category_list"></div>	
		</div>
    </div> 
</div>
<!-- End POP-UP Code -->
<div class="panel-body panel-white">
<ul class="nav nav-tabs panel_tabs" role="tablist">
	<li class="<?php if($active_tab=='grouplist'){?>active<?php }?>">
		<a href="?dashboard=user&page=group&tab=grouplist" class="tab <?php echo $active_tab == 'grouplist' ? 'active' : ''; ?>">
		 <i class="fa fa-align-justify"></i> <?php _e('Group List', 'gym_mgt'); ?></a>
	  </a>
	</li>
   <li class="<?php if($active_tab=='addgroup'){?>active<?php }?>">
	  <?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['group_id']))
		{?>
		<a href="?dashboard=user&page=group&tab=addgroup&&action=edit&group_id=<?php echo $_REQUEST['group_id'];?>" class="nav-tab <?php echo $active_tab == 'addgroup' ? 'nav-tab-active' : ''; ?>">
		 <i class="fa fa"></i> <?php _e('Edit Group', 'gym_mgt'); ?></a>
		 <?php }
		else
		{	
			if($user_access['add']=='1')
			{
			?>
				<a href="?dashboard=user&page=group&tab=addgroup&&action=insert" class="tab <?php echo $active_tab == 'addgroup' ? 'active' : ''; ?>">
				<i class="fa fa-plus-circle"></i> <?php _e('Add Group', 'gym_mgt'); ?></a>
			<?php 	
			} 
		}
	?>
	</li>

</ul>
	<div class="tab-content">
	<?php if($active_tab == 'grouplist')
	{ ?>	
    	<div class="panel-body">
        	<div class="table-responsive">
				<table id="group_list" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th style="width: 50px;height:50px;"><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Group Name', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Total Group Members', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Group Name', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Total Group Members', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
						</tr>
					</tfoot>
					<tbody>
					<?php
						if($obj_gym->role == 'member')
						{	
							if($user_access['own_data']=='1')
							{
								$user_id=get_current_user_id();
								$groupdata=$obj_group->get_member_all_groups($user_id);			
							}
							else
							{
								$groupdata=$obj_group->get_all_groups();
							}	
						}
						elseif($obj_gym->role == 'staff_member' || $obj_gym->role == 'accountant')
						{
							if($user_access['own_data']=='1')
							{
								$user_id=get_current_user_id();							
								$groupdata=$obj_group->get_all_groups_by_created_by($user_id);			
							}
							else
							{
								$groupdata=$obj_group->get_all_groups();
							}
						}
						
					
					if(!empty($groupdata))
					{
						foreach ($groupdata as $retrieved_data)
						{
					 ?>
						<tr>
							<td class="user_image"><?php $userimage=$retrieved_data->gmgt_groupimage;
										if(empty($userimage))
										{
											echo '<img src='.get_option( 'gmgt_system_logo' ).' height="25px" width="25px" class="img-circle" />';
										}
										else
											echo '<img src='.$userimage.' height="25px" width="25px" class="img-circle"/>';
								?>
							</td>
							<td class="membershipname">
							<?php if($obj_gym->role == 'staff_member' || $obj_gym->role == 'accountant')
								   {?>
								<a href="?dashboard=user&page=group&tab=addgroup&action=edit&group_id=<?php echo $retrieved_data->id;?>"><?php echo $retrieved_data->group_name;?></a>
								   <?php }
								   else
								   {?>
									  <?php echo $retrieved_data->group_name;?>
								   <?php }?>
							</td>
							<td class="allmembers"><?php echo $obj_group->count_group_members($retrieved_data->id);?>
							</td>
							<td class="action">
								<a href="#" class="btn btn-success view_group_member" id="<?php echo $retrieved_data->id?>"> <?php _e('View', 'gym_mgt' ) ;?></a>
								<?php
								if($user_access['edit']=='1')
								{
								?>								
									<a href="?dashboard=user&page=group&tab=addgroup&action=edit&group_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
								 <?php
								}
								if($user_access['delete']=='1')
								{
								?>	
									<a href="?dashboard=user&page=group&tab=grouplist&action=delete&group_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
									onclick="return confirm('<?php _e('Do you really want to delete this record?','gym_mgt');?>');">
									<?php _e( 'Delete', 'gym_mgt' ) ;?> </a>
								<?php
								}
								?>		
							</td>
						</tr>
						<?php
						} 
					}?>
					</tbody>
				</table>
            </div>
        </div>
		<?php 
	}
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
        <form name="group_form" action="" method="post" class="form-horizontal" id="group_form" enctype="multipart/form-data">
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
			<label class="col-sm-2 control-label" for="photo"><?php _e('Group Image','gym_mgt');?></label>
			<div class="col-sm-2">
				<input type="text" id="gmgt_user_avatar_url" class="form-control" name="gmgt_groupimage"  
				value="<?php if($edit)echo esc_url( $result->gmgt_groupimage );elseif(isset($_POST['gmgt_groupimage'])) echo $_POST['gmgt_groupimage']; ?>" />
			</div>	
			<div class="col-sm-3">
				<input type="hidden" name="hidden_upload_user_avatar_image" value="<?php if($edit){ echo $result->gmgt_groupimage;}elseif(isset($_POST['gmgt_groupimage'])) echo $_POST['gmgt_groupimage'];?>">
       				 <input id="upload_user_avatar_image" name="gmgt_groupimage" onchange="fileCheck(this);" type="file" class="form-control file" value="<?php _e( 'Upload image', 'gym_mgt' ); ?>" />
       		</div>
			<div class="clearfix"></div>
			<div class="col-sm-offset-2 col-sm-8">
                <div id="upload_user_avatar_preview" >
	                     <?php if($edit) 
	                     	{
	                     	if($result->gmgt_groupimage == "")
	                     	{?>
	                     	<img alt="" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">
	                     	<?php }
	                     	else {
	                     		?>
					        <img style="max-width:100%;" src="<?php if($edit)echo esc_url( $result->gmgt_groupimage ); ?>" />
					        <?php 
	                     	}
	                     	}
					        else {
					        	?>
					        	<img alt="" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">
					        	<?php 
					        }?>
    			</div>
   		    </div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','gym_mgt'); }else{ _e('Save','gym_mgt');}?>" name="save_group" class="btn btn-success"/>
        </div>
        </form>
    </div>
     <?php 
	}
	?>
    </div>
</div>
<script type="text/javascript">
function fileCheck(obj) {
            var fileExtension = ['jpeg', 'jpg', 'png', 'bmp'];
            if ($.inArray($(obj).val().split('.').pop().toLowerCase(), fileExtension) == -1)
			{
                alert("Only '.jpeg','.jpg', '.png', '.bmp' formats are allowed.");
				$(obj).val('');
			}	
}
</script>
<?php ?>