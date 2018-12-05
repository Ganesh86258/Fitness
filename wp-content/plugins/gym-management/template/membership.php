<?php 
$obj_membership=new MJ_Gmgtmembership;
$active_tab = isset($_REQUEST['tab'])?$_REQUEST['tab']:'membershiplist';
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
	if(isset($_POST['save_membership']))
	{
		if(isset($_FILES['gmgt_membershipimage']) && !empty($_FILES['gmgt_membershipimage']) && $_FILES['gmgt_membershipimage']['size'] !=0)
		{
			if($_FILES['gmgt_membershipimage']['size'] > 0)
			{
			 $member_image=load_documets($_FILES['gmgt_membershipimage'],'gmgt_membershipimage','pimg');
						 $member_image_url=content_url().'/uploads/gym_assets/'.$member_image;
			}
						
		}
		else{
			
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
				$result=$obj_membership->gmgt_add_membership($_POST,$member_image_url);
				if($result)
				{
					wp_redirect ( home_url().'?dashboard=user&page=membership&tab=membershiplist&message=2');
				}
			}
			else
			{
			
					$result=$obj_membership->gmgt_add_membership($_POST,$member_image_url);
					if($result)
					{
						wp_redirect ( home_url().'?dashboard=user&page=membership&tab=membershiplist&message=1');
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
		
		$result=$obj_membership->delete_membership($_REQUEST['membership_id']);
		if($result)
		{
			wp_redirect ( home_url().'?dashboard=user&page=membership&tab=membershiplist&message=3');
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
	}?>
<script type="text/javascript">
$(document).ready(function() 
{
	jQuery('#membership_list').DataTable({
		"responsive": true,
		 "order": [[ 1, "asc" ]],
		 "aoColumns":[
					  {"bSortable": false},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},	
					  <?php
					  if($user_access['edit']=='1' || $user_access['delete']=='1')
					  {	
					?>
						{"bSortable": false}
					  <?php
					  }
					  ?>
					   ]
		});
	$('#membership_form').validationEngine();
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
		<li class="<?php if($active_tab == 'membershiplist') echo "active";?>">
			  <a href="?dashboard=user&page=membership&tab=membershiplist">
				 <i class="fa fa-align-justify"></i> <?php _e('Membership', 'gym_mgt'); ?></a>
			  </a>
		</li>		  
		<li class="<?php if($active_tab=='addmembership'){?>active<?php }?>">
			  <?php 
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['membership_id']))
				{
				?>
					<a href="?dashboard=user&page=membership&tab=addmembership&action=edit&membership_id=<?php echo $_REQUEST['membership_id'];?>" class="nav-tab <?php echo $active_tab == 'addmembership' ? 'nav-tab-active' : ''; ?>">
					<i class="fa fa"></i> <?php _e('Edit Membership', 'gym_mgt'); ?></a>
				 <?php 
				}
				else
				{
					if($user_access['add']=='1')
					{
					?>
						<a href="?dashboard=user&page=membership&tab=addmembership&&action=insert" class="nav-tab <?php echo $active_tab == 'addmembership' ? 'nav-tab-active' : ''; ?>">
						<i class="fa fa-plus-circle"></i> <?php _e('Add Membership', 'gym_mgt'); ?></a>
					<?php 
					} 
				}
			?>	  
		</li>		  
    </ul>
	<div class="tab-content">
    	<?php if($active_tab == 'membershiplist')
		{ ?>
		<div class="panel-body">
            <div class="table-responsive">
			   <table id="membership_list" class="display dataTable " cellspacing="0" width="100%">
					<thead>
						<tr>
							<th style="width: 50px;height:50px;"><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Membership Name', 'gym_mgt' ) ;?></th>
							<th><?php _e( 'Membership Period', 'gym_mgt' ) ;?></th>
							<th> <?php _e( 'Installment Plan', 'gym_mgt' ) ;?></th>
							<th> <?php _e( 'Signup Fee', 'gym_mgt' ) ;?></th>
						<?php
						if($user_access['edit']=='1' || $user_access['delete']=='1')
						{	
						?>							
							<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
						<?php
						}
						?>
						</tr>
						
				    </thead>
				<tfoot>
						<tr>
							<th><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
							<th><?php  _e( 'Membership Name', 'gym_mgt' ) ;?></th>
							<th><?php _e( 'Membership Period', 'gym_mgt' ) ;?></th>
							<th> <?php _e( 'Installment Plan', 'gym_mgt' ) ;?></th>
							<th> <?php _e( 'Signup Fee', 'gym_mgt' ) ;?></th>	
						<?php
						if($user_access['edit']=='1' || $user_access['delete']=='1')
						{	
						?>		
							<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>		
						<?php
						}
						?>		
						</tr>
					</tfoot>
					<tbody>
						<?php
						if($obj_gym->role == 'member')
						{	
							if($user_access['own_data']=='1')
							{
								$user_id=get_current_user_id();
								$membership_id = get_user_meta( $user_id,'membership_id', true ); 
								$membershipdata=$obj_membership->get_member_own_membership($membership_id);			
							}
							else
							{
								$membershipdata=$obj_membership->get_all_membership();
							}	
						}
						elseif($obj_gym->role == 'staff_member' || $obj_gym->role == 'accountant')
						{
							if($user_access['own_data']=='1')
							{
								$user_id=get_current_user_id();							
								$membershipdata=$obj_membership->get_membership_by_created_by($user_id);			
							}
							else
							{
								$membershipdata=$obj_membership->get_all_membership();
							}
						}
						
						if(!empty($membershipdata))
						{
							foreach ($membershipdata as $retrieved_data)
							{
							?>
							<tr>
								<td class="user_image"><?php $userimage=$retrieved_data->gmgt_membershipimage;
											
										if(empty($userimage))
										{
											echo '<img src='.get_option( 'gmgt_system_logo' ).' height="25px" width="25px" class="img-circle" />';
										}
										else
											echo '<img src='.$userimage.' height="25px" width="25px" class="img-circle"/>';
								?></td>
								<td class="membershipname">
								<?php 
									if($obj_gym->role == 'staff_member' || $obj_gym->role == 'accountant')
								   {?>
										<a href="?dashboard=user&page=membership&tab=addmembership&action=edit&membership_id=<?php echo $retrieved_data->membership_id;?>"><?php echo $retrieved_data->membership_label;?></a>
								   <?php
								   }
								   else
								   {?>
									   <?php echo $retrieved_data->membership_label;?>
								   <?php }?>
								</td>
								<td class="membershiperiod"><?php echo $retrieved_data->membership_length_id;?></td>
								<td class="installmentplan"><?php   echo $retrieved_data->installment_amount." ".get_the_title( $retrieved_data->install_plan_id );?></td>
								<td class="signup_fee"><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); echo $retrieved_data->signup_fee;?></td>

							<?php
							if($user_access['edit']=='1' || $user_access['delete']=='1')
							{	
							?>			
								<td class="action">
								<?php
								if($user_access['edit']=='1')
								{
								?>
									<a href="?dashboard=user&page=membership&tab=addmembership&action=edit&membership_id=<?php echo $retrieved_data->membership_id?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
								<?php
								}
								if($user_access['delete']=='1')
								{
								?>	
									<a href="?dashboard=user&page=membership&tab=membershiplist&action=delete&membership_id=<?php echo $retrieved_data->membership_id;?>" class="btn btn-danger" 
									onclick="return confirm('<?php _e('Do you really want to delete this record?','gym_mgt');?>');">
									<?php _e( 'Delete', 'gym_mgt' ) ;?> </a>				
								<?php
								}
								?>	
								</td>	
							<?php
							}
							?>	
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
		if($active_tab == 'addmembership')
		{ 
			$membership_id=0;
			if(isset($_REQUEST['membership_id']))
				$membership_id=$_REQUEST['membership_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
				{
					$edit=1;
					$result = $obj_membership->get_single_membership($membership_id);
				}?>
		
        <div class="panel-body">
			<form name="membership_form" action="" method="post" class="form-horizontal" id="membership_form" enctype="multipart/form-data">
				<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
				<input type="hidden" name="action" value="<?php echo $action;?>">
				<input type="hidden" name="membership_id" value="<?php echo $membership_id;?>"  />
				<div class="form-group">
					<label class="col-sm-2 control-label" for="membership_name"><?php _e('Membership Name','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="membership_name" class="form-control validate[required,custom[onlyLetterSp]] text-input"  maxlength="50" type="text" value="<?php if($edit){ echo $result->membership_label;}elseif(isset($_POST['membership_name'])) echo $_POST['membership_name'];?>" name="membership_name">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="membership_category"><?php _e('Membership Category','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<select class="form-control" name="membership_category" id="membership_category">
							<option value=""><?php _e('Select Membership Category','gym_mgt');?></option>
							<?php 
							if(isset($_REQUEST['membership_category']))
								$category =$_REQUEST['membership_category'];  
							elseif($edit)
								$category =$result->membership_cat_id;
							else 
								$category = "";
							
							$mambership_category=gmgt_get_all_category('membership_category');
							if(!empty($mambership_category))
							{
								foreach ($mambership_category as $retrive_data)
								{
									echo '<option value="'.$retrive_data->ID.'" '.selected($category,$retrive_data->ID).'>'.$retrive_data->post_title.'</option>';
								}
							}
							?>
						</select>
					</div>
					<div class="col-sm-2"><button id="addremove" model="membership_category"><?php _e('Add Or Remove','gym_mgt');?></button></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="membership_period"><?php _e('Membership Period','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<!--<select class="form-control" name="membership_period" id="membership_period">
						<option value=""><?php _e('Select Membership Period','gym_mgt');?></option>
						<?php 
						
						if(isset($_REQUEST['membership_period']))
							$category =$_REQUEST['membership_period'];  
						elseif($edit)
							$category =$result->membership_length_id;
						else 
							$category = "";
						
						$membership_period=gmgt_get_all_category('membership_period');
						if(!empty($membership_period))
						{
							foreach ($membership_period as $retrive_data)
							{
								echo '<option value="'.$retrive_data->ID.'" '.selected($category,$retrive_data->ID).'>'.$retrive_data->post_title.'</option>';
							}
						}
						?>
						
						</select>
					</div>
					<div class="col-sm-2"><button id="addremove" model="membership_period"><?php _e('Add Or Remove','gym_mgt');?></button></div>-->
					<input id="membership_period" class="form-control validate[required,custom[number]] text-input" type="number" min="0" onKeyPress="if(this.value.length==3) return false;" value="<?php if($edit){ echo $result->membership_length_id;}elseif(isset($_POST['membership_period'])) echo $_POST['membership_period'];?>" name="membership_period" placeholder="<?php _e('Enter Total Number of Days','gym_mgt');?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="member_limit"><?php _e('Members Limit','gym_mgt');?></label>
					<div class="col-sm-8">
					<?php $limitval = "unlimited"; if($edit){ $limitval=$result->membership_class_limit; }elseif(isset($_POST['gender'])) {$limitval=$_POST['gender'];}?>
						<label class="radio-inline">
						 <input type="radio" value="limited" class="tog" name="member_limit"  <?php  checked( 'limited', $limitval);  ?>/><?php _e('limited','gym_mgt');?>
						</label>
						<label class="radio-inline">
						  <input type="radio" value="unlimited" class="tog validate[required]" name="member_limit"  <?php  checked( 'unlimited', $limitval);  ?>/><?php _e('unlimited','gym_mgt');?> 
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="installment_amount"><?php _e('Membership Amount','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="membership_amount" class="form-control text-input validate[required]" type="number" min="0"  onkeypress="if(this.value.length==6) return false;" value="<?php if($edit){ echo $result->membership_amount;}elseif(isset($_POST['membership_amount'])) echo $_POST['membership_amount'];?>" name="membership_amount" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="installment_plan"><?php _e('Installment Plan','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-2">
						<input id="installment_amount" class="form-control text-input validate[required]" type="number" min="0"  onkeypress="if(this.value.length==6) return false;" value="<?php if($edit){ echo $result->installment_amount;}elseif(isset($_POST['installment_amount'])) echo $_POST['installment_amount'];?>" name="installment_amount" placeholder="<?php _e('Amount','gym_mgt');?>">
					</div>
					<div class="col-sm-6">
					
						<select class="form-control" name="installment_plan" id="installment_plan">
							<option value=""><?php _e('Select Installment Plan','gym_mgt');?></option>
							<?php 
							
							if(isset($_REQUEST['installment_plan']))
								$category =$_REQUEST['installment_plan'];  
							elseif($edit)
								$category =$result->install_plan_id;
							else 
								$category = "";
							
							$installment_plan=gmgt_get_all_category('installment_plan');
							if(!empty($installment_plan))
							{
								foreach ($installment_plan as $retrive_data)
								{
									echo '<option value="'.$retrive_data->ID.'" '.selected($category,$retrive_data->ID).'>'.$retrive_data->post_title.'</option>';
								}
							}
							?>
						</select>
					</div>
					<div class="col-sm-2"><button id="addremove" model="installment_plan"><?php _e('Add Or Remove','gym_mgt');?></button></div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="signup_fee"><?php _e('Signup Fee','gym_mgt');?></label>
					<div class="col-sm-8">
						<input id="signup_fee" class="form-control text-input" type="number" min="0"  onkeypress="if(this.value.length==6) return false;" value="<?php if($edit){ echo $result->signup_fee;}elseif(isset($_POST['membership_name'])) echo $_POST['membership_name'];?>" name="signup_fee">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="photo"><?php _e('Membership Image','gym_mgt');?></label>
					<div class="col-sm-2">
						<input type="text" id="gmgt_user_avatar_url" class="form-control" name="gmgt_membershipimage"  
						value="<?php if($edit)echo esc_url( $result->gmgt_membershipimage );elseif(isset($_POST['gmgt_membershipimage'])) echo $_POST['gmgt_membershipimage']; ?>" />
					</div>	
					<div class="col-sm-3">
						<input type="hidden" name="hidden_upload_user_avatar_image" value="<?php if($edit){ echo $result->gmgt_membershipimage;}elseif(isset($_POST['gmgt_membershipimage'])) echo $_POST['gmgt_membershipimage'];?>">
							 <input id="upload_user_avatar_image" name="gmgt_membershipimage" onchange="fileCheck(this);" type="file" class="form-control file" value="<?php _e( 'Upload image', 'gym_mgt' ); ?>" />
					</div>
					<div class="clearfix"></div>
					
					<div class="col-sm-offset-2 col-sm-8">
							 <div id="upload_user_avatar_preview" >
								 <?php if($edit) 
									{
									if($result->gmgt_membershipimage == "")
									{?>
									<img alt="" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">
									<?php }
									else {
										?>
									<img style="max-width:100%;" src="<?php if($edit)echo esc_url( $result->gmgt_membershipimage ); ?>" />
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
					<input type="submit" value="<?php if($edit){ _e('Save Membership','gym_mgt'); }else{ _e('Add Membership','gym_mgt');}?>" name="save_membership" class="btn btn-success"/>
				</div>
			</form>
        </div>
		<?php 
		}?>
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