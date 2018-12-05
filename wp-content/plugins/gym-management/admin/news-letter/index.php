<?php 
$obj_class=new MJ_Gmgtclassschedule;
$apikey = get_option('gmgt_mailchimp_api');
//$api = new MJ_GYM_MCAPI($apikey);
$api = new MJ_GYM_MCAPI();
$result=$api->MCAPI($apikey);
$active_tab = isset($_GET['tab'])?$_GET['tab']:'mailchimp_setting';
?>

<div class="page-inner" style="min-height:1631px !important">
<div class="page-title">
		<h3><img src="<?php echo get_option( 'gmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'gmgt_system_name' );?></h3>
</div>
	<?php 
	if(isset($_REQUEST['save_setting']))
	{
		update_option( 'gmgt_mailchimp_api', $_REQUEST['gmgt_mailchimp_api']);
		$message = __("Save Setting Successfully","gym_mgt");
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
		//$subcsriber_emil = array_unique($subcsriber_emil);
		if(!empty($subcsriber_emil))
		{
			foreach ($subcsriber_emil as $value)
			{
				//$merge_vars = array('FNAME'=>'Test', 'LNAME'=>'Account'));
				//echo "Fname =>".$value['fname']." LastName => ".$value['lname']."<BR>";
				$merge_vars = array('FNAME'=>$value['fname'], 'LNAME'=>$value['lname']);
				$subscribe = $api->listSubscribe($_REQUEST['list_id'], $value['email'], $merge_vars );
			}
		}
		$message = __("Synchronize Mail Successfully","gym_mgt");
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
			//echo $member['email']." - ".$member['timestamp']."\n";
			$emails[] = $member['email'];
		}
		//$emails[] = 'maks.ashvin03@gmail.com';
		$retval2 = $api->campaignSendTest($campaignId, $emails);
		//$retval2 = $api->campaignSendNow($campaignId);
		if ($api->errorCode){
			//echo "Unable to Send Test Campaign!";
			//echo "\n\tCode=".$api->errorCode;
			//echo "\n\tMsg=".$api->errorMessage."\n";
			$message = __("Campaign Tests Not Sent!","gym_mgt");
		} else {
			$message = __("Campaign Tests Sent!","gym_mgt");
		}
	}
	if(isset($message))
	{
	?>
		<div id="message" class="updated below-h2"><p>
		<?php 
			echo $message;
		?></p></div>
		<?php 
	}
	?>
	<div id="main-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-white">
					<div class="panel-body">
						<h2 class="nav-tab-wrapper">
							<a href="?page=gmgt_newsletter&tab=mailchimp_setting" class="nav-tab <?php echo $active_tab == 'mailchimp_setting' ? 'nav-tab-active' : ''; ?>">
							<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Setting', 'gym_mgt'); ?></a>
							
						  
							<a href="?page=gmgt_newsletter&tab=sync" class="nav-tab <?php echo $active_tab == 'sync' ? 'nav-tab-active' : ''; ?>">
							<?php _e('Sync Mail', 'gym_mgt'); ?></a>  
							
							<a href="?page=gmgt_newsletter&tab=campaign" class="nav-tab <?php echo $active_tab == 'campaign' ? 'nav-tab-active' : ''; ?>">
							<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Campaign', 'gym_mgt'); ?></a>
						</h2>
						 <?php 
						//Report 1 
						
						if($active_tab == 'mailchimp_setting')
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
						require_once GMS_PLUGIN_DIR. '/admin/news-letter/sync.php';
						 }
						if($active_tab == 'campaign')
						 {
						require_once GMS_PLUGIN_DIR. '/admin/news-letter/campaign.php';
						 }
						 ?>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
<?php //} ?>