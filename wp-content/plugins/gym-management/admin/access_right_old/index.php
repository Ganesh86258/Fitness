<?php 	
if(isset($_POST['save_access_right']))
{
	$access_right = array();
	$result=get_option( 'gmgt_access_right');
	//---------NEW MENU LINK START------------------ 
	$access_right['staff_member'] =array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/staff-member.png' ),'menu_title'=>'Staff Members',
	'member' => isset($_REQUEST['member_staff_member'])?$_REQUEST['member_staff_member']:0,
	'staff_member' =>isset($_REQUEST['staff_member_staff_member'])?$_REQUEST['staff_member_staff_member']:0,
	'accountant' =>isset($_REQUEST['accountant_staff_member'])?$_REQUEST['accountant_staff_member']:0,
	'page_link'=>'staff_member');
	//---------NEW MENU LINK START------------------ 
	$access_right['membership'] =array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/membership-type.png' ),'menu_title'=>'Membership Type',
	'member' => isset($_REQUEST['member_membership'])?$_REQUEST['member_membership']:0,
	'staff_member' =>isset($_REQUEST['staff_member_membership'])?$_REQUEST['staff_member_membership']:0,
	'accountant' =>isset($_REQUEST['accountant_membership'])?$_REQUEST['accountant_membership']:0,
	'page_link'=>'membership');
	//---------NEW MENU LINK START------------------ 
	$access_right['group'] =array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/group.png' ),'menu_title'=>'Group',
	'member' => isset($_REQUEST['member_group'])?$_REQUEST['member_group']:0,
	'staff_member' =>isset($_REQUEST['staff_member_group'])?$_REQUEST['staff_member_group']:0,
	'accountant' =>isset($_REQUEST['accountant_group'])?$_REQUEST['accountant_group']:0,
	'page_link'=>'group');
	//---------NEW MENU LINK START------------------ 
	$access_right['member'] =array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/member.png' ),'menu_title'=>'Member',
	'member' => isset($_REQUEST['member_member'])?$_REQUEST['member_member']:0,
	'staff_member' =>isset($_REQUEST['staff_member_member'])?$_REQUEST['staff_member_member']:0,
	'accountant' =>isset($_REQUEST['accountant_member'])?$_REQUEST['accountant_member']:0,
	'page_link'=>'member');
	//---------NEW MENU LINK START------------------ 
	$access_right['activity'] =array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/activity.png' ),'menu_title'=>'Activity',
	'member' => isset($_REQUEST['member_activity'])?$_REQUEST['member_activity']:0,
	'staff_member' =>isset($_REQUEST['staff_member_activity'])?$_REQUEST['staff_member_activity']:0,
	'accountant' =>isset($_REQUEST['accountant_activity'])?$_REQUEST['accountant_activity']:0,
	'page_link'=>'activity');
	//---------NEW MENU LINK START------------------ 
	$access_right['class-schedule'] =array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/class-schedule.png' ),'menu_title'=>'Class schedule',
	'member' => isset($_REQUEST['member_class-schedule'])?$_REQUEST['member_class-schedule']:0,
	'staff_member' =>isset($_REQUEST['staff_member_class-schedule'])?$_REQUEST['staff_member_class-schedule']:0,
	'accountant' =>isset($_REQUEST['accountant_class-schedule'])?$_REQUEST['accountant_class-schedule']:0,
	'page_link'=>'class-schedule');
	//---------NEW MENU LINK START------------------ 
	$access_right['attendence'] =array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/attandance.png' ),'menu_title'=>'Attendence',
	'member' => isset($_REQUEST['member_attendence'])?$_REQUEST['member_attendence']:0,
	'staff_member' =>isset($_REQUEST['staff_member_attendence'])?$_REQUEST['staff_member_attendence']:0,
	'accountant' =>isset($_REQUEST['accountant_attendence'])?$_REQUEST['accountant_attendence']:0,
	'page_link'=>'attendence');
	//---------NEW MENU LINK START------------------ 
	$access_right['assign-workout'] =array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/assigne-workout.png' ),'menu_title'=>'Assigned Workouts',
	'member' => isset($_REQUEST['member_assign-workout'])?$_REQUEST['member_assign-workout']:0,
	'staff_member' =>isset($_REQUEST['staff_member_assign-workout'])?$_REQUEST['staff_member_assign-workout']:0,
	'accountant' =>isset($_REQUEST['accountant_assign-workout'])?$_REQUEST['accountant_assign-workout']:0,
	'page_link'=>'assign-workout');
	//---------NEW MENU LINK START------------------ 
	$access_right['workouts'] =array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/workout.png' ),'menu_title'=>'Workouts',
	'member' => isset($_REQUEST['member_workouts'])?$_REQUEST['member_workouts']:0,
	'staff_member' =>isset($_REQUEST['staff_member_workouts'])?$_REQUEST['staff_member_workouts']:0,
	'accountant' =>isset($_REQUEST['accountant_workouts'])?$_REQUEST['accountant_workouts']:0,
	'page_link'=>'workouts');
	//---------NEW MENU LINK START------------------ 
	$access_right['accountant'] =array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/accountant.png' ),'menu_title'=>'Accountant',
	'member' => isset($_REQUEST['member_accountant'])?$_REQUEST['member_accountant']:0,
	'staff_member' =>isset($_REQUEST['staff_member_accountant'])?$_REQUEST['staff_member_accountant']:0,
	'accountant' =>isset($_REQUEST['accountant_accountant'])?$_REQUEST['accountant_accountant']:0,
	'page_link'=>'accountant');
	//---------NEW MENU LINK START------------------ 
	$access_right['membership_payment'] =array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/fee.png' ),'menu_title'=>'Fee Payment',
	'member' => isset($_REQUEST['member_membership_payment'])?$_REQUEST['member_membership_payment']:0,
	'staff_member' =>isset($_REQUEST['staff_member_membership_payment'])?$_REQUEST['staff_member_membership_payment']:0,
	'accountant' =>isset($_REQUEST['accountant_membership_payment'])?$_REQUEST['accountant_membership_payment']:0,
	'page_link'=>'membership_payment');
	//---------NEW MENU LINK START------------------ 
	$access_right['payment'] =array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/payment.png' ),'menu_title'=>'Payment',
	'member' => isset($_REQUEST['member_payment'])?$_REQUEST['member_payment']:0,
	'staff_member' =>isset($_REQUEST['staff_member_payment'])?$_REQUEST['staff_member_payment']:0,
	'accountant' =>isset($_REQUEST['accountant_payment'])?$_REQUEST['accountant_payment']:0,
	'page_link'=>'payment');
	//---------NEW MENU LINK START------------------ 
	$access_right['product'] =array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/products.png' ),'menu_title'=>'Product',
	'member' => isset($_REQUEST['member_product'])?$_REQUEST['member_product']:0,
	'staff_member' =>isset($_REQUEST['staff_member_product'])?$_REQUEST['staff_member_product']:0,
	'accountant' =>isset($_REQUEST['accountant_product'])?$_REQUEST['accountant_product']:0,
	'page_link'=>'product');
	//---------NEW MENU LINK START------------------ 
	$access_right['store'] =array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/store.png' ),'menu_title'=>'Store',
	'member' => isset($_REQUEST['member_store'])?$_REQUEST['member_store']:0,
	'staff_member' =>isset($_REQUEST['staff_member_store'])?$_REQUEST['staff_member_store']:0,
	'accountant' =>isset($_REQUEST['accountant_store'])?$_REQUEST['accountant_store']:0,
	'page_link'=>'store');
	//---------NEW MENU LINK START------------------ 
	$access_right['news_letter'] =array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/newsletter.png' ),'menu_title'=>'Newsletter',
	'member' => isset($_REQUEST['member_news_letter'])?$_REQUEST['member_news_letter']:0,
	'staff_member' =>isset($_REQUEST['staff_member_news_letter'])?$_REQUEST['staff_member_news_letter']:0,
	'accountant' =>isset($_REQUEST['accountant_news_letter'])?$_REQUEST['accountant_news_letter']:0,
	'page_link'=>'news_letter');
	//---------NEW MENU LINK START------------------ 
	$access_right['message'] =array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/message.png' ),'menu_title'=>'Message',
	'member' => isset($_REQUEST['member_message'])?$_REQUEST['member_message']:0,
	'staff_member' =>isset($_REQUEST['staff_member_message'])?$_REQUEST['staff_member_message']:0,
	'accountant' =>isset($_REQUEST['accountant_message'])?$_REQUEST['accountant_message']:0,
	'page_link'=>'message');
	//---------NEW MENU LINK START------------------ 
	$access_right['notice'] =array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/notice.png' ),'menu_title'=>'Notice',
	'member' => isset($_REQUEST['member_notice'])?$_REQUEST['member_notice']:0,
	'staff_member' =>isset($_REQUEST['staff_member_notice'])?$_REQUEST['staff_member_notice']:0,
	'accountant' =>isset($_REQUEST['accountant_notice'])?$_REQUEST['accountant_notice']:0,
	'page_link'=>'notice');
	//---------NEW MENU LINK START------------------ 
	$access_right['nutrition'] =array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/nutrition-schedule.png' ),'menu_title'=>'Nutrition Schedule',
	'member' => isset($_REQUEST['member_nutrition'])?$_REQUEST['member_nutrition']:0,
	'staff_member' =>isset($_REQUEST['staff_member_nutrition'])?$_REQUEST['staff_member_nutrition']:0,
	'accountant' =>isset($_REQUEST['accountant_nutrition'])?$_REQUEST['accountant_nutrition']:0,
	'page_link'=>'nutrition');
	//---------NEW MENU LINK START------------------ 
	$access_right['reservation'] =array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/reservation.png' ),'menu_title'=>'Reservation',
	'member' => isset($_REQUEST['member_reservation'])?$_REQUEST['member_reservation']:0,
	'staff_member' =>isset($_REQUEST['staff_member_reservation'])?$_REQUEST['staff_member_reservation']:0,
	'accountant' =>isset($_REQUEST['accountant_reservation'])?$_REQUEST['accountant_reservation']:0,
	'page_link'=>'reservation');
	//---------NEW MENU LINK START------------------ 
	$access_right['account'] =array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/account.png' ),'menu_title'=>'Account',
	'member' => isset($_REQUEST['member_account'])?$_REQUEST['member_account']:0,
	'staff_member' =>isset($_REQUEST['staff_member_account'])?$_REQUEST['staff_member_account']:0,
	'accountant' =>isset($_REQUEST['accountant_account'])?$_REQUEST['accountant_account']:0,
	'page_link'=>'account');
	
	$access_right['subscription_history'] =array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/subscription_history.png' ),'menu_title'=>'Subscription History',
	'member' => isset($_REQUEST['member_subscription_history'])?$_REQUEST['member_subscription_history']:0,
	'staff_member' =>isset($_REQUEST['staff_member_subscription_history'])?$_REQUEST['staff_member_subscription_history']:0,
	'accountant' =>isset($_REQUEST['accountant_subscription_history'])?$_REQUEST['accountant_subscription_history']:0,
	'page_link'=>'subscription_history');

	$result=update_option( 'gmgt_access_right',$access_right );
	wp_redirect ( admin_url() . 'admin.php?page=gmgt_access_right&message=1');
}
$access_right=get_option( 'gmgt_access_right');
if(isset($_REQUEST['message']))
{
	$message =$_REQUEST['message'];
	if($message == 1)
	{?>
			<div id="message" class="updated below-h2 ">
			<p>
			<?php 
				_e('Record Updated Successfully','gym_mgt');
			?></p></div>
			<?php 
	}
}
?>
<div class="page-inner" style="min-height:1631px !important">
<div class="page-title">
	<h3><img src="<?php echo get_option( 'gmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'gmgt_system_name' );?></h3>
</div>
    <div id="main-wrapper">
	    <div class="panel panel-white">
			<div class="panel-body">
				<h2>
					<?php echo esc_html( __( 'Access Right Settings', 'gym_mgt')); ?>
				</h2>
				<div class="panel-body">
					<form name="student_form" action="" method="post" class="form-horizontal" id="access_right_form">
						<div class="row">
							<div class="col-md-2 col-sm-3 col-xs-3"><?php _e('Menu','gym_mgt');?></div>
							<div class="col-md-2 col-sm-3 col-xs-3"><?php _e('Member','gym_mgt');?></div>
							<div class="col-md-2 col-sm-3 col-xs-3"><?php _e('Staff Member','gym_mgt');?></div>
							<div class="col-md-2 col-sm-3 col-xs-3"><?php _e('Accountant','gym_mgt');?></div>
						</div>
						<div class="row">
							<div class="col-md-2 col-sm-3 col-xs-5 ">
								<span class="menu-label">
									<?php _e('Staff Member','gym_mgt');?>
								</span>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['staff_member']['member'],1);?> value="1" name="member_staff_member" readonly>	              
									</label>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['staff_member']['staff_member'],1);?> value="1" name="staff_member_staff_member" readonly>	              
									</label>
								</div>
							</div>
						
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['staff_member']['accountant'],1);?> value="1" name="accountant_staff_member" readonly>	              
									</label>
								</div>
							</div>
							
						</div>
						<!--------Membership------------->
						<div class="row">
							<div class="col-md-2 col-sm-3 col-xs-5">
								<span class="menu-label">
									<?php _e('Membership Type','gym_mgt');?>
								</span>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['membership']['member'],1);?> value="1" name="member_membership" readonly>	              
									</label>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['membership']['staff_member'],1);?> value="1" name="staff_member_membership" readonly>	              
									</label>
								</div>
							</div>
						
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['membership']['accountant'],1);?> value="1" name="accountant_membership" readonly>	              
									</label>
								</div>
							</div>
							
						</div>
						<!--------Group------------->
						<div class="row">
							<div class="col-md-2 col-sm-3 col-xs-5">
								<span class="menu-label">
									<?php _e('Group','gym_mgt');?>
								</span>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['group']['member'],1);?> value="1" name="member_group" readonly>	              
									</label>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['group']['staff_member'],1);?> value="1" name="staff_member_group" readonly>	              
									</label>
								</div>
							</div>
						
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['group']['accountant'],1);?> value="1" name="accountant_group" readonly>	              
									</label>
								</div>
							</div>
							
						</div>
						<!--------Member------------->
						<div class="row">
							<div class="col-md-2 col-sm-3 col-xs-5">
								<span class="menu-label">
									<?php _e('Member','gym_mgt');?>
								</span>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['member']['member'],1);?> value="1" name="member_member" readonly>	              
									</label>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['member']['staff_member'],1);?> value="1" name="staff_member_member" readonly>	              
									</label>
								</div>
							</div>
						
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['member']['accountant'],1);?> value="1" name="accountant_member" readonly>	              
									</label>
								</div>
							</div>
							
						</div>
						<!--------Activity------------->
						<div class="row">
							<div class="col-md-2 col-sm-3 col-xs-5">
								<span class="menu-label">
									<?php _e('Activity','gym_mgt');?>
								</span>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['activity']['member'],1);?> value="1" name="member_activity" readonly>	              
									</label>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['activity']['staff_member'],1);?> value="1" name="staff_member_activity" readonly>	              
									</label>
								</div>
							</div>
						
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['activity']['accountant'],1);?> value="1" name="accountant_activity" readonly>	              
									</label>
								</div>
							</div>
							
						</div>
						<!--------Class Schedule------------->
						<div class="row">
							<div class="col-md-2 col-sm-3 col-xs-5">
								<span class="menu-label">
									<?php _e('Class Schedule','gym_mgt');?>
								</span>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['class-schedule']['member'],1);?> value="1" name="member_class-schedule" readonly>	              
									</label>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['class-schedule']['staff_member'],1);?> value="1" name="staff_member_class-schedule" readonly>	              
									</label>
								</div>
							</div>
						
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['class-schedule']['accountant'],1);?> value="1" name="accountant_class-schedule" readonly>	              
									</label>
								</div>
							</div>
							
						</div>
						<!--------Attendence------------->
						<div class="row">
							<div class="col-md-2 col-sm-3 col-xs-5">
								<span class="menu-label">
									<?php _e('Attendence','gym_mgt');?>
								</span>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['attendence']['member'],1);?> value="1" name="member_attendence" readonly>	              
									</label>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['attendence']['staff_member'],1);?> value="1" name="staff_member_attendence" readonly>	              
									</label>
								</div>
							</div>
						
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['attendence']['accountant'],1);?> value="1" name="accountant_attendence" readonly>	              
									</label>
								</div>
							</div>
							
						</div>
						<!--------Assigne Workouts------------->
						<div class="row">
							<div class="col-md-2 col-sm-3 col-xs-5">
								<span class="menu-label">
									<?php _e('Assigned Workouts','gym_mgt');?>
								</span>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['assign-workout']['member'],1);?> value="1" name="member_assign-workout" readonly>	              
									</label>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['assign-workout']['staff_member'],1);?> value="1" name="staff_member_assign-workout" readonly>	              
									</label>
								</div>
							</div>
						
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['assign-workout']['accountant'],1);?> value="1" name="accountant_assign-workout" readonly>	              
									</label>
								</div>
							</div>
							
						</div>
						<!--------Workouts------------->
						<div class="row">
							<div class="col-md-2 col-sm-3 col-xs-5">
								<span class="menu-label">
									<?php _e('Workouts','gym_mgt');?>
								</span>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['workouts']['member'],1);?> value="1" name="member_workouts" readonly>	              
									</label>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['workouts']['staff_member'],1);?> value="1" name="staff_member_workouts" readonly>	              
									</label>
								</div>
							</div>
						
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['workouts']['accountant'],1);?> value="1" name="accountant_workouts" readonly>	              
									</label>
								</div>
							</div>
							
						</div>
						<!--------Accountant------------->
						<div class="row">
							<div class="col-md-2 col-sm-3 col-xs-5">
								<span class="menu-label">
									<?php _e('Accountant','gym_mgt');?>
								</span>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['accountant']['member'],1);?> value="1" name="member_accountant" readonly>	              
									</label>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['accountant']['staff_member'],1);?> value="1" name="staff_member_accountant" readonly>	              
									</label>
								</div>
							</div>
						
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['accountant']['accountant'],1);?> value="1" name="accountant_accountant" readonly>	              
									</label>
								</div>
							</div>
							
						</div>
						<!--------Payment------------->
						<div class="row">
							<div class="col-md-2 col-sm-3 col-xs-5">
								<span class="menu-label">
									<?php _e('Fee Payment','gym_mgt');?>
								</span>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['membership_payment']['member'],1);?> value="1" name="member_membership_payment" readonly>	              
									</label>
								</div>
							</div>
							<div class="col-md-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['membership_payment']['staff_member'],1);?> value="1" name="staff_member_membership_payment" readonly>	              
									</label>
								</div>
							</div>
						
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['membership_payment']['accountant'],1);?> value="1" name="accountant_membership_payment" readonly>	              
									</label>
								</div>
							</div>
							
						</div>
						<!--------Payment------------->
						<div class="row">
							<div class="col-md-2 col-sm-3 col-xs-5">
								<span class="menu-label">
									<?php _e('Payment','gym_mgt');?>
								</span>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['payment']['member'],1);?> value="1" name="member_payment" readonly>	              
									</label>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['payment']['staff_member'],1);?> value="1" name="staff_member_payment" readonly>	              
									</label>
								</div>
							</div>
						
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['payment']['accountant'],1);?> value="1" name="accountant_payment" readonly>	              
									</label>
								</div>
							</div>
							
						</div>
						
						<!--------product------------->
						<div class="row">
							<div class="col-md-2 col-sm-3 col-xs-5">
								<span class="menu-label">
									<?php _e('product','gym_mgt');?>
								</span>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['product']['member'],1);?> value="1" name="member_product" readonly>	              
									</label>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['product']['staff_member'],1);?> value="1" name="staff_member_product" readonly>	              
									</label>
								</div>
							</div>
						
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['product']['accountant'],1);?> value="1" name="accountant_product" readonly>	              
									</label>
								</div>
							</div>
							
						</div>
								<!--------Store------------->
						<div class="row">
							<div class="col-md-2 col-sm-3 col-xs-5">
								<span class="menu-label">
									<?php _e('Store','gym_mgt');?>
								</span>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2 ">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['store']['member'],1);?> value="1" name="member_store" readonly>	              
									</label>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['store']['staff_member'],1);?> value="1" name="staff_member_store" readonly>	              
									</label>
								</div>
							</div>
						
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['store']['accountant'],1);?> value="1" name="accountant_store" readonly>	              
									</label>
								</div>
							</div>
							
						</div>
								<!--------News letter------------->
						<div class="row">
							<div class="col-md-2 col-sm-3 col-xs-5">
								<span class="menu-label">
									<?php _e('Newsletter','gym_mgt');?>
								</span>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['news_letter']['member'],1);?> value="1" name="member_news_letter" readonly>	              
									</label>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['news_letter']['staff_member'],1);?> value="1" name="staff_member_news_letter" readonly>	              
									</label>
								</div>
							</div>
						
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['news_letter']['accountant'],1);?> value="1" name="accountant_news_letter" readonly>	              
									</label>
								</div>
							</div>
							
						</div>
								<!--------Message------------->
						<div class="row">
							<div class="col-md-2 col-sm-3 col-xs-5">
								<span class="menu-label">
									<?php _e('Message','gym_mgt');?>
								</span>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['message']['member'],1);?> value="1" name="member_message" readonly>	              
									</label>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['message']['staff_member'],1);?> value="1" name="staff_member_message" readonly>	              
									</label>
								</div>
							</div>
						
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['message']['accountant'],1);?> value="1" name="accountant_message" readonly>	              
									</label>
								</div>
							</div>
							
						</div>
								<!--------Notice------------->
						<div class="row">
							<div class="col-md-2 col-sm-3 col-xs-5">
								<span class="menu-label">
									<?php _e('Notice','gym_mgt');?>
								</span>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['notice']['member'],1);?> value="1" name="member_notice" readonly>	              
									</label>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['notice']['staff_member'],1);?> value="1" name="staff_member_notice" readonly>	              
									</label>
								</div>
							</div>
						
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['notice']['accountant'],1);?> value="1" name="accountant_notice" readonly>	              
									</label>
								</div>
							</div>
							
						</div>
								<!--------Nutrition Schedule------------->
						<div class="row">
							<div class="col-md-2 col-sm-3 col-xs-5">
								<span class="menu-label">
									<?php _e('Nutrition Schedule','gym_mgt');?>
								</span>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['nutrition']['member'],1);?> value="1" name="member_nutrition" readonly>	              
									</label>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['nutrition']['staff_member'],1);?> value="1" name="staff_member_nutrition" readonly>	              
									</label>
								</div>
							</div>
						
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['nutrition']['accountant'],1);?> value="1" name="accountant_nutrition" readonly>	              
									</label>
								</div>
							</div>
							
						</div>
								<!--------Reservation------------->
						<div class="row">
							<div class="col-md-2 col-sm-3 col-xs-5">
								<span class="menu-label">
									<?php _e('Reservation','gym_mgt');?>
								</span>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['reservation']['member'],1);?> value="1" name="member_reservation" readonly>	              
									</label>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['reservation']['staff_member'],1);?> value="1" name="staff_member_reservation" readonly>	              
									</label>
								</div>
							</div>
						
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['reservation']['accountant'],1);?> value="1" name="accountant_reservation" readonly>	              
									</label>
								</div>
							</div>
							
						</div>
								<!--------Account------------->
						<div class="row">
							<div class="col-md-2 col-sm-3 col-xs-5">
								<span class="menu-label">
									<?php _e('Account','gym_mgt');?>
								</span>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['account']['member'],1);?> value="1" name="member_account" readonly>	              
									</label>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['account']['staff_member'],1);?> value="1" name="staff_member_account" readonly>	              
									</label>
								</div>
							</div>
						
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['account']['accountant'],1);?> value="1" name="accountant_account" readonly>	              
									</label>
								</div>
							</div>
							
						</div>
						
						<!--------Subscription History------------->
						<div class="row">
							<div class="col-md-2 col-sm-3 col-xs-5">
								<span class="menu-label">
									<?php _e('Subscription History','gym_mgt');?>
								</span>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['subscription_history']['member'],1);?> value="1" name="member_subscription_history" readonly>	              
									</label>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['subscription_history']['staff_member'],1);?> value="1" name="staff_member_subscription_history" readonly>	              
									</label>
								</div>
							</div>
						
							<div class="col-md-2 col-sm-3 col-xs-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" <?php echo checked($access_right['subscription_history']['accountant'],1);?> value="1" name="accountant_subscription_history" readonly>	              
									</label>
								</div>
							</div>
							
						</div>
					
						<div class="col-sm-offset-2 col-sm-8 row_bottom save_btn_padding" >
							<input type="submit" value="<?php _e('Save', 'gym_mgt' ); ?>" name="save_access_right" class="btn btn-success"/>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>    
</div>    
<?php ?> 