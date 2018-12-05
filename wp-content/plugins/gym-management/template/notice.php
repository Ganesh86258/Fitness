<?php $curr_user_id=get_current_user_id();
$obj_gym=new MJ_Gym_management($curr_user_id);
$obj_class=new MJ_Gmgtclassschedule;
$obj_notice=new MJ_Gmgtnotice;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'noticelist';
//access right
$user_access=get_userrole_wise_page_access_right_array();
if (isset ( $_REQUEST ['page'] ))
{	
	if($user_access['view']=='0')
	{	
		access_right_page_not_access_message();
		die;
	}
}
	if(isset($_POST['save_notice']))
	{
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{
				
			$result=$obj_notice->gmgt_add_notice($_POST);
			
			if($result)
			{
				wp_redirect ( home_url().'?dashboard=user&page=notice&tab=noticelist&message=2');
			}
		}
		else
		{
			$result=$obj_notice->gmgt_add_notice($_POST);
	
				if($result)
				{
					wp_redirect ( home_url().'?dashboard=user&page=notice&tab=noticelist&message=1');
				}
			
			}
	}
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
	{
			
			$result=$obj_notice->delete_notice($_REQUEST['notice_id']);
			if($result)
			{
				wp_redirect ( home_url().'?dashboard=user&page=notice&tab=noticelist&message=3');
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
	jQuery('#notice_list').DataTable({
		"responsive": true
		});
		$('#notice_form').validationEngine();
} );
</script>
<!-- View Popup Code -->	
<div class="popup-bg">
    <div class="overlay-content">
    	<div class="notice_content"></div>    
    </div> 
</div>	
<div class="panel-body panel-white">
    <ul class="nav nav-tabs panel_tabs" role="tablist">
	  	<li class="<?php if($active_tab=='noticelist'){?>active<?php }?>">
			<a href="?dashboard=user&page=notice&tab=noticelist" class="tab <?php echo $active_tab == 'noticelist' ? 'active' : ''; ?>">
             <i class="fa fa-align-justify"></i> <?php _e('Notice List', 'gym_mgt'); ?></a>
          </a>
      </li>
	 <!-- <?php if($obj_gym->role=='staff_member' || $obj_gym->role=='accountant'){?>
       <li class="<?php if($active_tab=='addnotice'){?>active<?php }?>">
		  <?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['notice_id']))
			{?>
			<a href="?dashboard=user&page=notice&tab=addnotice&action=edit&notice_id=<?php echo $_REQUEST['notice_id'];?>" class="nav-tab <?php echo $active_tab == 'addnotice' ? 'nav-tab-active' : ''; ?>">
             <i class="fa fa"></i> <?php _e('Edit  Notice', 'gym_mgt'); ?></a>
			 <?php }
			else
			{?>
				<a href="?dashboard=user&page=notice&tab=addnotice" class="tab <?php echo $active_tab == 'addnotice' ? 'active' : ''; ?>">
				<i class="fa fa-plus-circle"></i> <?php _e('Add Notice', 'gym_mgt'); ?></a>
	  <?php } ?>
	  
	</li>
	  <?php }?>-->
    </ul>
	<div class="tab-content">
	<?php if($active_tab == 'noticelist')
	{ ?>	
    	<div class="panel-body">
            <div class="table-responsive">
				<table id="notice_list" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th><?php  _e( 'Notice Title', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Notice Comment', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Notice For', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Class', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Start Date', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'End Date', 'gym_mgt' ) ;?></th>
							  <?php if($obj_gym->role == 'member' || $obj_gym->role == 'staff_member' || $obj_gym->role == 'accountant')
								   {?>
							<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
							   <?php }?>
						</tr>
				    </thead>
					<tfoot>
						<tr>
							<th><?php  _e( 'Notice Title', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Notice Comment', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Notice For', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Class', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Start Date', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'End Date', 'gym_mgt' ) ;?></th>
							  <?php if($obj_gym->role == 'member' ||$obj_gym->role == 'staff_member' || $obj_gym->role == 'accountant')
								   {?>
							<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
								   <?php }?>
						</tr>
					</tfoot>
				<tbody>
					<?php 
					if($user_access['own_data']=='1')
					{
						$noticedata =$obj_notice->get_notice($obj_gym->role);
					}
					else	
					{
						$noticedata =$obj_notice->get_all_notice();
					}	
					if(!empty($noticedata))
					{
						foreach ($noticedata as $retrieved_data)
						{
							$class_id=get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true);
							if($class_id!="")
							{
								$ClassArr=get_current_user_classis($curr_user_id);
								$staff_classes=$obj_class->getClassesByStaffmeber($curr_user_id);
								if($obj_gym->role=="member" && in_array($class_id,$ClassArr))
								{
								?>
									<tr>
										<td class="noticetitle"><a href=""><?php echo $retrieved_data->post_title;?></a></td>
										
										<td class="noticecontent"><?php $strlength= strlen($retrieved_data->post_content);
											if($strlength > 60)
												echo substr($retrieved_data->post_content, 0,60).'...';
											else
												echo $retrieved_data->post_content;?></td>
										<td class="productquentity"><?php echo ucwords(str_replace("_"," ",get_post_meta( $retrieved_data->ID, 'notice_for',true)));?></td>
										<td>
										 <?php 
										 if(get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true) !="" && get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true) =="all")
										 {
											 _e('All','gym_mgt');
										 }
										 elseif(get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true) !=""){
										 echo gmgt_get_class_name(get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true));}?></td>
										  <td><?php echo get_post_meta($retrieved_data->ID,'gmgt_start_date',true);?></td>
										 <td><?php echo get_post_meta($retrieved_data->ID,'gmgt_end_date',true);?></td>
										<td class="action"> 
										<a href="#" class="btn btn-success view-notice" id="<?php echo $retrieved_data->ID;?>"> <?php _e('View', 'gym_mgt' ) ;?></a>
										</td>
									</tr>
								<?php
								}	
								if($obj_gym->role=="staff_member" && !empty($staff_classes) && in_array($class_id,$staff_classes))
								{
								?>
									<tr>
										<td class="noticetitle"><a href=""><?php echo $retrieved_data->post_title;?></a></td>
										
										<td class="noticecontent"><?php $strlength= strlen($retrieved_data->post_content);
											if($strlength > 60)
												echo substr($retrieved_data->post_content, 0,60).'...';
											else
												echo $retrieved_data->post_content;?></td>
										<td class="productquentity"><?php echo ucwords(str_replace("_"," ",get_post_meta( $retrieved_data->ID, 'notice_for',true)));?></td>
										<td>
										 <?php 
										 if(get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true) !="" && get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true) =="all")
										 {
											 _e('All','gym_mgt');
										 }
										 elseif(get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true) !=""){
										 echo gmgt_get_class_name(get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true));}?></td>
										  <td><?php echo get_post_meta($retrieved_data->ID,'gmgt_start_date',true);?></td>
										 <td><?php echo get_post_meta($retrieved_data->ID,'gmgt_end_date',true);?></td>
										
										<td class="action"> 
										<a href="#" class="btn btn-success view-notice" id="<?php echo $retrieved_data->ID;?>"> <?php _e('View', 'gym_mgt' ) ;?></a>
										</td>
									</tr>
								<?php 
								}
									
							}
							else
							{
							?>
								<tr>
									<td class="noticetitle"><a href=""><?php echo $retrieved_data->post_title;?></a></td>
									<td class="noticecontent"><?php $strlength= strlen($retrieved_data->post_content);
										if($strlength > 60)
											echo substr($retrieved_data->post_content, 0,60).'...';
										else
											echo $retrieved_data->post_content;?></td>
									<td class="productquentity"><?php echo ucwords(str_replace("_"," ",get_post_meta( $retrieved_data->ID, 'notice_for',true)));?></td>
									<td>
									 <?php 
									 if(get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true) !="" && get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true) =="all")
									 {
										 _e('All','gym_mgt');
									 }
									 elseif(get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true) !=""){
									 echo gmgt_get_class_name(get_post_meta( $retrieved_data->ID, 'gmgt_class_id',true));}?></td>
									  <td><?php echo get_post_meta($retrieved_data->ID,'gmgt_start_date',true);?></td>
									 <td><?php echo get_post_meta($retrieved_data->ID,'gmgt_end_date',true);?></td>
									
									<?php if($obj_gym->role == 'member' || $obj_gym->role == 'staff_member' || $obj_gym->role == 'accountant')
									   {?>
									<td class="action"> 
									<a href="#" class="btn btn-success view-notice" id="<?php echo $retrieved_data->ID;?>"> <?php _e('View', 'gym_mgt' ) ;?></a>
									<!--<a href="?dashboard=user&page=notice&tab=addnotice&action=edit&notice_id=<?php echo $retrieved_data->ID?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
									<a href="?dashboard=user&page=notice&tab=noticelist&action=delete&notice_id=<?php echo $retrieved_data->ID;?>" class="btn btn-danger" 
									onclick="return confirm('<?php _e('Do you really want to delete this record?','gym_mgt');?>');">
									<?php _e( 'Delete', 'gym_mgt' ) ;?> </a>-->
									
									</td>
									   <?php } ?>
								</tr>
								<?php 
							}	
						}
						
					}?>
			    </tbody>
			</table>
 		</div>
	</div>
	<?php 
	}
	if($active_tab == 'addnotice')
	{
        	$notice_id=0;
			if(isset($_REQUEST['notice_id']))
				$notice_id=$_REQUEST['notice_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
				{
					$edit=1;
					$result = get_post($notice_id);
				}?>
        <div class="panel-body">
			<form name="notice_form" action="" method="post" class="form-horizontal" id="notice_form">
			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
			<input type="hidden" name="action" value="<?php echo $action;?>">
			<input type="hidden" name="notice_id" value="<?php echo $notice_id;?>"  />
			<div class="form-group">
				<label class="col-sm-2 control-label" for="notice_title"><?php _e('Notice Title','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="notice_title" class="form-control validate[required,custom[onlyLetterSp]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo $result->post_title;}?>" name="notice_title">
					 <input type="hidden" name="notice_id"   value="<?php if($edit){ echo $result->ID;}?>"/> 
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="notice_for"><?php _e('Notice For','gym_mgt');?></label>
				<div class="col-sm-8">
				 <select name="notice_for" id="notice_for" class="form-control notice_for">
				   <option value = "all"><?php _e('All','gym_mgt');?></option>
				   <option value="staff_member" <?php if($edit) echo selected(get_post_meta( $result->ID, 'notice_for',true),'staff_member');?>><?php _e('Stall Members','gym_mgt');?></option>
				   <option value="member" <?php if($edit) echo selected(get_post_meta( $result->ID, 'notice_for',true),'member');?>><?php _e('Member','gym_mgt');?></option>
				 </select>
					
				</div>
			</div>
			<div class="class_div">
				<div class="form-group">
					<label class="col-sm-2 control-label" for="class_id"><?php _e('Class','gym_mgt');?></label>
					<div class="col-sm-8">
						<?php if($edit){ $class_id=get_user_meta($result->member_id,'class_id',true); }elseif(isset($_POST['class_id'])){$class_id=$_POST['class_id'];}else{$class_id='';}?>
						<select id="class_id" class="form-control" name="class_id">
						<option value=""><?php _e('Select Class','gym_mgt');?></option>
					<?php $classdata=$obj_class->get_all_classes();
						 if(!empty($classdata))
						 {
							foreach ($classdata as $class){?>
								<option value="<?php echo $class->class_id;?>" <?php selected($class_id,$class->class_id);  ?>><?php echo $class->class_name; ?> </option>
					<?php } } ?>
					</select>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="notice_content"><?php _e('Notice Comment','gym_mgt');?></label>
				<div class="col-sm-8">
				<textarea name="notice_content" class="form-control" id="notice_content" maxlength="150"><?php if($edit){ echo $result->post_content;}?></textarea>
				</div>
			</div>
			
			<div class="col-sm-offset-2 col-sm-8">
				
				<input type="submit" value="<?php if($edit){ _e('Save Notice','gym_mgt'); }else{ _e('Save Notice','gym_mgt');}?>" name="save_notice" class="btn btn-success"/>
			</div>
			
			</form>
        </div>
     <?php 
	}
	?>
	</div>
</div>
<?php ?>