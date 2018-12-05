<?php $curr_user_id=get_current_user_id();
$obj_gym=new MJ_Gym_management($curr_user_id);
$obj_class=new MJ_Gmgtclassschedule;
$apikey = get_option('gmgt_mailchimp_api');
$api = new MJ_GYM_MCAPI($apikey);
$active_tab = isset($_GET['tab'])?$_GET['tab']:'mailchimp_setting';
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
	if(isset($_REQUEST['save_setting']))
	{
		update_option( 'gmgt_mailchimp_api', $_REQUEST['gmgt_mailchimp_api']);
		$message = "Save Setting Successfully.";
	}
	if(isset($_REQUEST['sychroniz_email']))
	{
		$retval = $api->lists();
		$subcsriber_emil = array();
		if(isset($_REQUEST['syncmail']))
		{
			$syncmail = $_REQUEST['syncmail'];
			foreach ($syncmail as $id)
			{
				$args = array('meta_key' => 'class_id','meta_value' => $id);	
				$usersdata = get_users($args );
				if(!empty($usersdata))
				{
					foreach ($usersdata as $retrieved_data){
						$firstname=get_user_meta($retrieved_data->ID,'first_name',true);
						$lastname=get_user_meta($retrieved_data->ID,'last_name',true);
						if(trim($retrieved_data->user_email) !='')
							$subcsriber_emil[] = array('fname'=>$firstname,'lname'=>$lastname,'email'=>$retrieved_data->user_email);
						}
				}
			}
		}
		if(!empty($subcsriber_emil))
		{
			foreach ($subcsriber_emil as $value)
			{
				$merge_vars = array('FNAME'=>$value['fname'], 'LNAME'=>$value['lname']);
				$subscribe = $api->listSubscribe($_REQUEST['list_id'], $value['email'], $merge_vars );
			}
		}
		$message = "Synchronize Maill Successfully.";
	}
	if(isset($_REQUEST['send_campign']))
	{
		$retval = $api->campaigns();
		$retval1 = $api->lists();
		$emails = array();
		$listId = $_REQUEST['list_id'];
		$campaignId =$_REQUEST['camp_id'];
		$listmember = $api->listMembers($listId, 'subscribed', null, 0, 5000 );
		foreach($listmember['data'] as $member){
			$emails[] = $member['email'];
		}
		$retval2 = $api->campaignSendTest($campaignId, $emails);
		if ($api->errorCode){
			$message = "Campaign Tests Not Sent!\n";
		} else {
			$message = "Campaign Tests Sent!\n";
		}
	}
	if(isset($message))
	{
	?>
		<div id="message" class="updated below-h2"><p>
			<?php 
				echo $message;
			?></p>
		</div>
		<?php
	}?>
<div class="panel-body panel-white">
    <ul class="nav nav-tabs panel_tabs fronted_custom" role="tablist">
     
		<li class="<?php if($active_tab=='mailchimp_setting'){?>active<?php }?>">
				<a href="?dashboard=user&page=news_letter&tab=mailchimp_setting" class="nav-tab <?php echo $active_tab == 'mailchimp_setting' ? 'nav-tab-active' : ''; ?>">
			 <i class="fa fa-align-justify"></i> <?php _e('Setting', 'gym_mgt'); ?></a>
			 
		</li>
		 
		<li class="<?php if($active_tab=='sync'){?>active<?php }?>">
				<a href="?dashboard=user&page=news_letter&tab=sync" class="nav-tab <?php echo $active_tab == 'sync' ? 'nav-tab-active' : ''; ?>">
			<i class="fa fa-plus-circle"></i> <?php _e('Sync Mail', 'gym_mgt'); ?></a>
		</li>
		<li class="<?php if($active_tab=='campaign'){?>active<?php }?>">
				<a href="?dashboard=user&page=news_letter&tab=campaign" class="nav-tab <?php echo $active_tab == 'campaign' ? 'nav-tab-active' : ''; ?>">
			<i class="fa fa-plus-circle"></i> <?php _e('Campaign', 'gym_mgt'); ?></a>
		</li>
    </ul>
	<div class="tab-content">
	<?php if($active_tab == 'mailchimp_setting')
	{ ?>
		<div class="panel-body">
			<form name="newsletterform" method="post" id="newsletterform" class="form-horizontal">
				<div class="form-group">
						<label class="col-sm-2 control-label" for="wpcrm_mailchimp_api"><?php _e('MailChimp API key','gym_mgt');?></label>
						<div class="col-sm-8">
							<input id="gmgt_mailchimp_api" class="form-control" type="text" value="<?php echo get_option( 'gmgt_mailchimp_api' );?>"  name="gmgt_mailchimp_api">
						</div>
					</div>
					
					<div class="col-sm-offset-2 col-sm-8">
						<input type="submit" value="<?php _e('Save', 'gym_mgt' ); ?>" name="save_setting" class="btn btn-success"/>
				</div>
				
			  </form>
		  </div>
     <?php 
	}
	if($active_tab == 'sync')
	{
        $retval = $api->lists();?>
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
								<?php 
								}
							}?>
						 </div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="list_id"><?php _e('Mailing list','gym_mgt');?></label>
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
<?php 
}
		if($active_tab == 'campaign')
		{
			$retval = $api->campaigns();
			$retval1 = $api->lists();?>
			<div class="panel-body">
				<form name="student_form" action="" method="post" class="form-horizontal" id="setting_form">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="quote_form"><?php _e('MailChimp list','gym_mgt');?></label>
						<div class="col-sm-8">
							<select name="list_id" id="quote_form"  class="form-control">
								<option value=""><?php _e('Select list','gym_mgt');?></option>
								<?php 
								foreach ($retval1['data'] as $list){
									
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


  <?php } ?>
	</div>
</div>
<?php ?>