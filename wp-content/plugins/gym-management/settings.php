<?php 
require_once GMS_PLUGIN_DIR. '/gmgt_function.php';
require_once GMS_PLUGIN_DIR. '/class/membership.php';
require_once GMS_PLUGIN_DIR. '/class/group.php';
require_once GMS_PLUGIN_DIR. '/class/member.php';
require_once GMS_PLUGIN_DIR. '/class/class_schedule.php';
require_once GMS_PLUGIN_DIR. '/class/product.php';
require_once GMS_PLUGIN_DIR. '/class/store.php';
require_once GMS_PLUGIN_DIR. '/class/reservation.php';
require_once GMS_PLUGIN_DIR. '/class/attendence.php';
require_once GMS_PLUGIN_DIR. '/class/membership_payment.php';
require_once GMS_PLUGIN_DIR. '/class/payment.php';
require_once GMS_PLUGIN_DIR. '/class/activity.php';
require_once GMS_PLUGIN_DIR. '/class/workout_type.php';
require_once GMS_PLUGIN_DIR. '/class/workout.php';
require_once GMS_PLUGIN_DIR. '/class/notice.php';
require_once GMS_PLUGIN_DIR. '/class/nutrition.php';
require_once GMS_PLUGIN_DIR. '/class/MailChimp.php';
require_once GMS_PLUGIN_DIR. '/class/MCAPI.class.php';
require_once GMS_PLUGIN_DIR. '/class/gym-management.php';
require_once GMS_PLUGIN_DIR. '/class/dashboard.php';
require_once GMS_PLUGIN_DIR. '/class/message.php';
require_once GMS_PLUGIN_DIR. '/lib/paypal/paypal_class.php';

add_action( 'admin_head', 'gmgt_admin_css' );

function gmgt_admin_css(){
	?>
     <style>
      a.toplevel_page_gmgt_system:hover,  a.toplevel_page_gmgt_system:focus,.toplevel_page_gmgt_system.opensub a.wp-has-submenu{
  background: url("<?php echo GMS_PLUGIN_URL;?>/assets/images/gym-2.png") no-repeat scroll 8px 9px rgba(0, 0, 0, 0) !important;
  
}
.toplevel_page_gmgt_system:hover .wp-menu-image.dashicons-before img {
  display: none;
}

.toplevel_page_gmgt_system:hover .wp-menu-image.dashicons-before {
  min-width: 23px !important;
}
  
     </style>
<?php
}

add_action('init', 'gmgt_session_manager'); 
function gmgt_session_manager() 
{	
	if (!session_id())
	{
		session_start();		
		if(!isset($_SESSION['gmgt_verify']))
		{			
			$_SESSION['gmgt_verify'] = '';
		}		
	}	
}
//LOGOUT FUNCTION 
function gmgt_logout()
{
	if(isset($_SESSION['gmgt_verify']))
	{ 
		unset($_SESSION['gmgt_verify']);
	}   
}

add_action('wp_logout','gmgt_logout');
add_action('init','gmgt_setup');
function gmgt_setup()
{
	$is_cmgt_pluginpage = gmgt_is_gmgtpage();
	$is_verify = false;
	if(!isset($_SESSION['gmgt_verify']))
		$_SESSION['gmgt_verify'] = '';
	$server_name = $_SERVER['SERVER_NAME'];
	$is_localserver = gmgt_chekserver($server_name);
	if($is_localserver)
	{
		
		return true;
	}
	
	if($is_cmgt_pluginpage)
	{	
		if($_SESSION['gmgt_verify'] == ''){
		
			if( get_option('licence_key') && get_option('gmgt_setup_email'))
			{
				
				$domain_name = $_SERVER['SERVER_NAME'];
				$licence_key = get_option('licence_key');
				$email = get_option('gmgt_setup_email');
				$result = gmgt_check_productkey($domain_name,$licence_key,$email);
				$is_server_running = gmgt_check_ourserver();
				if($is_server_running)
					$_SESSION['gmgt_verify'] =$result;
				else
					$_SESSION['gmgt_verify'] = '0';
				$is_verify = gmgt_check_verify_or_not($result);
			
			}
		}
	}
	$is_verify = gmgt_check_verify_or_not($_SESSION['gmgt_verify']);
	if($is_cmgt_pluginpage)
		if(!$is_verify)
		{
			if($_REQUEST['page'] != 'gmgt_setup')
			wp_redirect(admin_url().'admin.php?page=gmgt_setup');
		}
}
if ( is_admin() )
{
	require_once GMS_PLUGIN_DIR. '/admin/admin.php';
	function gym_install()
	{
			add_role('staff_member', __( 'Instructor' ,'gym_mgt'),array( 'read' => true, 'level_1' => true ));
			add_role('accountant', __( 'Accountant' ,'gym_mgt'),array( 'read' => true, 'level_1' => true ));
			add_role('member', __( 'Member' ,'gym_mgt'),array( 'read' => true, 'level_0' => true ));
			//gmgt_register_post();
			gmgt_install_tables();			
	}
	register_activation_hook(GMS_PLUGIN_BASENAME, 'gym_install' );

	function gmgt_option()
	{		
		$access_right_member = array();
		$access_right_member['member'] = [
							"staff_member"=>["menu_icone"=>plugins_url('gym-management/assets/images/icon/staff-member.png'),
							           "menu_title"=>'Staff Members1',
							           "page_link"=>'staff_member',
									   "own_data" =>isset($_REQUEST['staff_member_own_data'])?$_REQUEST['staff_member_own_data']:0,
									   "add" =>isset($_REQUEST['staff_member_add'])?$_REQUEST['staff_member_add']:0,
										"edit"=>isset($_REQUEST['staff_member_edit'])?$_REQUEST['staff_member_edit']:0,
										"view"=>isset($_REQUEST['staff_member_view'])?$_REQUEST['staff_member_view']:1,
										"delete"=>isset($_REQUEST['staff_member_delete'])?$_REQUEST['staff_member_delete']:0
										],
												
						   "membership"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/membership-type.png'),
						              "menu_title"=>'Membership Type',
						              "page_link"=>'membership',
									 "own_data" => isset($_REQUEST['membership_own_data'])?$_REQUEST['membership_own_data']:0,
									 "add" => isset($_REQUEST['membership_add'])?$_REQUEST['membership_add']:0,
									 "edit"=>isset($_REQUEST['membership_edit'])?$_REQUEST['membership_edit']:0,
									 "view"=>isset($_REQUEST['membership_view'])?$_REQUEST['membership_view']:1,
									 "delete"=>isset($_REQUEST['membership_delete'])?$_REQUEST['membership_delete']:0
						  ],
									  
							"group"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/group.png'),
							        "menu_title"=>'Group',
									"page_link"=>'group',
									 "own_data" => isset($_REQUEST['group_own_data'])?$_REQUEST['group_own_data']:0,
									 "add" => isset($_REQUEST['group_add'])?$_REQUEST['group_add']:0,
									"edit"=>isset($_REQUEST['group_edit'])?$_REQUEST['group_edit']:0,
									"view"=>isset($_REQUEST['group_view'])?$_REQUEST['group_view']:1,
									"delete"=>isset($_REQUEST['group_delete'])?$_REQUEST['group_delete']:0
						  ],
									  
							  "member"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/member.png'),
							            "menu_title"=>'Member',
										"page_link"=>'member',
										"own_data" => isset($_REQUEST['member_own_data'])?$_REQUEST['member_own_data']:1,
										 "add" => isset($_REQUEST['member_add'])?$_REQUEST['member_add']:0,
										 "edit"=>isset($_REQUEST['member_edit'])?$_REQUEST['member_edit']:0,
										"view"=>isset($_REQUEST['member_view'])?$_REQUEST['member_view']:1,
										"delete"=>isset($_REQUEST['member_delete'])?$_REQUEST['member_delete']:0
							  ],
							  
							  "activity"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/activity.png'),
							             "menu_title"=>'Activity',
										 "page_link"=>'activity',
										 "own_data" => isset($_REQUEST['activity_own_data'])?$_REQUEST['activity_own_data']:0,
										 "add" => isset($_REQUEST['activity_add'])?$_REQUEST['activity_add']:0,
										"edit"=>isset($_REQUEST['activity_edit'])?$_REQUEST['activity_edit']:0,
										"view"=>isset($_REQUEST['activity_view'])?$_REQUEST['activity_view']:1,
										"delete"=>isset($_REQUEST['activity_delete'])?$_REQUEST['activity_delete']:0
							  ],
							  "class-schedule"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/class-schedule.png'),
							               "menu_title"=>'Class schedule',
										   "page_link"=>'class-schedule',
										 "own_data" => isset($_REQUEST['class_schedule_own_data'])?$_REQUEST['class_schedule_own_data']:0,
										 "add" => isset($_REQUEST['class_schedule_add'])?$_REQUEST['class_schedule_add']:0,
										"edit"=>isset($_REQUEST['class_schedule_edit'])?$_REQUEST['class_schedule_edit']:0,
										"view"=>isset($_REQUEST['class_schedule_view'])?$_REQUEST['class_schedule_view']:1,
										"delete"=>isset($_REQUEST['class_schedule_delete'])?$_REQUEST['class_schedule_delete']:0
							  ],
							  
							    "attendence"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/attandance.png'),
								         "menu_title"=>'Attendence',
										 "page_link"=>'attendence',
										 "own_data" => isset($_REQUEST['attendence_own_data'])?$_REQUEST['attendence_own_data']:0,
										 "add" => isset($_REQUEST['attendence_add'])?$_REQUEST['attendence_add']:0,
										"edit"=>isset($_REQUEST['attendence_edit'])?$_REQUEST['attendence_edit']:0,
										"view"=>isset($_REQUEST['attendence_view'])?$_REQUEST['attendence_view']:0,
										"delete"=>isset($_REQUEST['attendence_delete'])?$_REQUEST['attendence_delete']:0
							  ],						  
							  
							    "assign-workout"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/assigne-workout.png'),
								         "menu_title"=>'Assigned Workouts',
										 "page_link"=>'assign-workout',
										 "own_data" => isset($_REQUEST['assign_workout_own_data'])?$_REQUEST['assign_workout_own_data']:1,
										 "add" => isset($_REQUEST['assign_workout_add'])?$_REQUEST['assign_workout_add']:0,
										"edit"=>isset($_REQUEST['assign_workout_edit'])?$_REQUEST['assign_workout_edit']:0,
										"view"=>isset($_REQUEST['assign_workout_view'])?$_REQUEST['assign_workout_view']:1,
										"delete"=>isset($_REQUEST['assign_workout_delete'])?$_REQUEST['assign_workout_delete']:0
							  ],
							    "workouts"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/workout.png'),
								         "menu_title"=>'Workouts',
										 "page_link"=>'workouts',
										 "own_data" => isset($_REQUEST['workouts_own_data'])?$_REQUEST['workouts_own_data']:1,
										 "add" => isset($_REQUEST['workouts_add'])?$_REQUEST['workouts_add']:1,
										"edit"=>isset($_REQUEST['workouts_edit'])?$_REQUEST['workouts_edit']:0,
										"view"=>isset($_REQUEST['workouts_view'])?$_REQUEST['workouts_view']:1,
										"delete"=>isset($_REQUEST['workouts_delete'])?$_REQUEST['workouts_delete']:0
							  ],
							    "accountant"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/accountant.png'),
								          "menu_title"=>'Accountant',
										  "page_link"=>'accountant',
										 "own_data" => isset($_REQUEST['accountant_own_data'])?$_REQUEST['accountant_own_data']:0,
										 "add" => isset($_REQUEST['accountant_add'])?$_REQUEST['accountant_add']:0,
										"edit"=>isset($_REQUEST['accountant_edit'])?$_REQUEST['accountant_edit']:0,
										"view"=>isset($_REQUEST['accountant_view'])?$_REQUEST['accountant_view']:1,
										"delete"=>isset($_REQUEST['accountant_delete'])?$_REQUEST['accountant_delete']:0
							  ],
							  
							  "membership_payment"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/fee.png'),
							             "menu_title"=>'Fee Payment',
										 "page_link"=>'membership_payment',
										 "own_data" => isset($_REQUEST['membership_payment_own_data'])?$_REQUEST['membership_payment_own_data']:1,
										 "add" => isset($_REQUEST['membership_payment_add'])?$_REQUEST['membership_payment_add']:0,
										"edit"=>isset($_REQUEST['membership_payment_edit'])?$_REQUEST['membership_payment_edit']:0,
										"view"=>isset($_REQUEST['membership_payment_view'])?$_REQUEST['membership_payment_view']:1,
										"delete"=>isset($_REQUEST['membership_payment_delete'])?$_REQUEST['membership_payment_delete']:0
							  ],
							  
							  "payment"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/payment.png'),
							             "menu_title"=>'Payment',
										 "page_link"=>'payment',
										 "own_data" => isset($_REQUEST['payment_own_data'])?$_REQUEST['payment_own_data']:1,
										 "add" => isset($_REQUEST['payment_add'])?$_REQUEST['payment_add']:0,
										"edit"=>isset($_REQUEST['payment_edit'])?$_REQUEST['payment_edit']:0,
										"view"=>isset($_REQUEST['payment_view'])?$_REQUEST['payment_view']:1,
										"delete"=>isset($_REQUEST['payment_delete'])?$_REQUEST['payment_delete']:0
							  ],
							  "product"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/products.png'),
							           "menu_title"=>'Product',
									   "page_link"=>'product',
										 "own_data" => isset($_REQUEST['product_own_data'])?$_REQUEST['product_own_data']:0,
										 "add" => isset($_REQUEST['product_add'])?$_REQUEST['product_add']:0,
										"edit"=>isset($_REQUEST['product_edit'])?$_REQUEST['product_edit']:0,
										"view"=>isset($_REQUEST['product_view'])?$_REQUEST['product_view']:1,
										"delete"=>isset($_REQUEST['product_delete'])?$_REQUEST['product_delete']:0
							  ],
							  "store"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/store.png'),
							              "menu_title"=>'Store',
										  "page_link"=>'store',
										 "own_data" => isset($_REQUEST['store_own_data'])?$_REQUEST['store_own_data']:1,
										 "add" => isset($_REQUEST['store_add'])?$_REQUEST['store_add']:0,
										"edit"=>isset($_REQUEST['store_edit'])?$_REQUEST['store_edit']:0,
										"view"=>isset($_REQUEST['store_view'])?$_REQUEST['store_view']:1,
										"delete"=>isset($_REQUEST['store_delete'])?$_REQUEST['store_delete']:0
							  ],
							  "news_letter"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/newsletter.png'),
							            "menu_title"=>'Newsletter',
										"page_link"=>'news_letter',
										 "own_data" => isset($_REQUEST['news_letter_own_data'])?$_REQUEST['news_letter_own_data']:0,
										 "add" => isset($_REQUEST['news_letter_add'])?$_REQUEST['news_letter_add']:0,
										"edit"=>isset($_REQUEST['news_letter_edit'])?$_REQUEST['news_letter_edit']:0,
										"view"=>isset($_REQUEST['news_letter_view'])?$_REQUEST['news_letter_view']:0,
										"delete"=>isset($_REQUEST['news_letter_delete'])?$_REQUEST['news_letter_delete']:0
							  ],
							  "message"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/message.png'),
							             "menu_title"=>'Message',
										 "page_link"=>'message',
										 "own_data" => isset($_REQUEST['message_own_data'])?$_REQUEST['message_own_data']:1,
										 "add" => isset($_REQUEST['message_add'])?$_REQUEST['message_add']:1,
										"edit"=>isset($_REQUEST['message_edit'])?$_REQUEST['message_edit']:0,
										"view"=>isset($_REQUEST['message_view'])?$_REQUEST['message_view']:1,
										"delete"=>isset($_REQUEST['message_delete'])?$_REQUEST['message_delete']:1
							  ],
							  
							   "notice"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/notice.png'),
							           "menu_title"=>'Notice',
									   "page_link"=>'notice',
										 "own_data" => isset($_REQUEST['notice_own_data'])?$_REQUEST['notice_own_data']:1,
										 "add" => isset($_REQUEST['notice_add'])?$_REQUEST['notice_add']:0,
										"edit"=>isset($_REQUEST['notice_edit'])?$_REQUEST['notice_edit']:0,
										"view"=>isset($_REQUEST['notice_view'])?$_REQUEST['notice_view']:1,
										"delete"=>isset($_REQUEST['notice_delete'])?$_REQUEST['notice_delete']:0
							  ],
							  
							   "nutrition"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/nutrition-schedule.png'),
							            "menu_title"=>'Nutrition Schedule',
										"page_link"=>'nutrition',
										 "own_data" => isset($_REQUEST['nutrition_own_data'])?$_REQUEST['nutrition_own_data']:1,
										 "add" => isset($_REQUEST['nutrition_add'])?$_REQUEST['nutrition_add']:0,
										"edit"=>isset($_REQUEST['nutrition_edit'])?$_REQUEST['nutrition_edit']:0,
										"view"=>isset($_REQUEST['nutrition_view'])?$_REQUEST['nutrition_view']:1,
										"delete"=>isset($_REQUEST['nutrition_delete'])?$_REQUEST['nutrition_delete']:0
							  ],
							  
							   "reservation"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/reservation.png'),							       
								         "menu_title"=>'Reservation',
										 "page_link"=>'reservation',
										 "own_data" => isset($_REQUEST['reservation_own_data'])?$_REQUEST['reservation_own_data']:0,
										 "add" => isset($_REQUEST['reservation_add'])?$_REQUEST['reservation_add']:0,
										"edit"=>isset($_REQUEST['reservation_edit'])?$_REQUEST['reservation_edit']:0,
										"view"=>isset($_REQUEST['reservation_view'])?$_REQUEST['reservation_view']:1,
										"delete"=>isset($_REQUEST['reservation_delete'])?$_REQUEST['reservation_delete']:0
							  ],
							  
							   "account"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/account.png'),
							              "menu_title"=>'Account',
										  "page_link"=>'account',
										 "own_data" => isset($_REQUEST['account_own_data'])?$_REQUEST['account_own_data']:0,
										 "add" => isset($_REQUEST['account_add'])?$_REQUEST['account_add']:0,
										"edit"=>isset($_REQUEST['account_edit'])?$_REQUEST['account_edit']:0,
										"view"=>isset($_REQUEST['account_view'])?$_REQUEST['account_view']:1,
										"delete"=>isset($_REQUEST['account_delete'])?$_REQUEST['account_delete']:0
							  ],
							   "subscription_history"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/subscription_history.png'),
							             "menu_title"=>'Subscription History',
										 "page_link"=>'subscription_history',
										 "own_data" => isset($_REQUEST['subscription_history_own_data'])?$_REQUEST['subscription_history_own_data']:1,
										 "add" => isset($_REQUEST['subscription_history_add'])?$_REQUEST['subscription_history_add']:0,
										"edit"=>isset($_REQUEST['subscription_history_edit'])?$_REQUEST['subscription_history_edit']:0,
										"view"=>isset($_REQUEST['subscription_history_view'])?$_REQUEST['subscription_history_view']:1,
										"delete"=>isset($_REQUEST['subscription_history_delete'])?$_REQUEST['subscription_history_delete']:0
							  ]
			];
			
		$access_right_staff_member = array();
		$access_right_staff_member['staff_member'] = [
							"staff_member"=>["menu_icone"=>plugins_url('gym-management/assets/images/icon/staff-member.png'),
							           "menu_title"=>'Staff Members',
							           "page_link"=>'staff_member',
									   "own_data" =>isset($_REQUEST['staff_member_own_data'])?$_REQUEST['staff_member_own_data']:1,
									   "add" =>isset($_REQUEST['staff_member_add'])?$_REQUEST['staff_member_add']:0,
										"edit"=>isset($_REQUEST['staff_member_edit'])?$_REQUEST['staff_member_edit']:0,
										"view"=>isset($_REQUEST['staff_member_view'])?$_REQUEST['staff_member_view']:1,
										"delete"=>isset($_REQUEST['staff_member_delete'])?$_REQUEST['staff_member_delete']:0
										],
												
						   "membership"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/membership-type.png'),
						              "menu_title"=>'Membership Type',
						              "page_link"=>'membership',
									 "own_data" => isset($_REQUEST['membership_own_data'])?$_REQUEST['membership_own_data']:0,
									 "add" => isset($_REQUEST['membership_add'])?$_REQUEST['membership_add']:1,
									 "edit"=>isset($_REQUEST['membership_edit'])?$_REQUEST['membership_edit']:1,
									 "view"=>isset($_REQUEST['membership_view'])?$_REQUEST['membership_view']:1,
									 "delete"=>isset($_REQUEST['membership_delete'])?$_REQUEST['membership_delete']:1
						  ],
									  
							"group"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/group.png'),
							        "menu_title"=>'Group',
									"page_link"=>'group',
									 "own_data" => isset($_REQUEST['group_own_data'])?$_REQUEST['group_own_data']:0,
									 "add" => isset($_REQUEST['group_add'])?$_REQUEST['group_add']:1,
									"edit"=>isset($_REQUEST['group_edit'])?$_REQUEST['group_edit']:1,
									"view"=>isset($_REQUEST['group_view'])?$_REQUEST['group_view']:1,
									"delete"=>isset($_REQUEST['group_delete'])?$_REQUEST['group_delete']:1
						  ],
									  
							  "member"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/member.png'),
							            "menu_title"=>'Member',
										"page_link"=>'member',
										"own_data" => isset($_REQUEST['member_own_data'])?$_REQUEST['member_own_data']:0,
										 "add" => isset($_REQUEST['member_add'])?$_REQUEST['member_add']:0,
										 "edit"=>isset($_REQUEST['member_edit'])?$_REQUEST['member_edit']:0,
										"view"=>isset($_REQUEST['member_view'])?$_REQUEST['member_view']:1,
										"delete"=>isset($_REQUEST['member_delete'])?$_REQUEST['member_delete']:0
							  ],
							  
							  "activity"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/activity.png'),
							             "menu_title"=>'Activity',
										 "page_link"=>'activity',
										 "own_data" => isset($_REQUEST['activity_own_data'])?$_REQUEST['activity_own_data']:0,
										 "add" => isset($_REQUEST['activity_add'])?$_REQUEST['activity_add']:1,
										"edit"=>isset($_REQUEST['activity_edit'])?$_REQUEST['activity_edit']:1,
										"view"=>isset($_REQUEST['activity_view'])?$_REQUEST['activity_view']:1,
										"delete"=>isset($_REQUEST['activity_delete'])?$_REQUEST['activity_delete']:1
							  ],
							  "class-schedule"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/class-schedule.png'),
							               "menu_title"=>'Class schedule',
										   "page_link"=>'class-schedule',
										 "own_data" => isset($_REQUEST['class_schedule_own_data'])?$_REQUEST['class_schedule_own_data']:0,
										 "add" => isset($_REQUEST['class_schedule_add'])?$_REQUEST['class_schedule_add']:1,
										"edit"=>isset($_REQUEST['class_schedule_edit'])?$_REQUEST['class_schedule_edit']:1,
										"view"=>isset($_REQUEST['class_schedule_view'])?$_REQUEST['class_schedule_view']:1,
										"delete"=>isset($_REQUEST['class_schedule_delete'])?$_REQUEST['class_schedule_delete']:1
							  ],
							  
							    "attendence"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/attandance.png'),
								         "menu_title"=>'Attendence',
										 "page_link"=>'attendence',
										 "own_data" => isset($_REQUEST['attendence_own_data'])?$_REQUEST['attendence_own_data']:0,
										 "add" => isset($_REQUEST['attendence_add'])?$_REQUEST['attendence_add']:0,
										"edit"=>isset($_REQUEST['attendence_edit'])?$_REQUEST['attendence_edit']:0,
										"view"=>isset($_REQUEST['attendence_view'])?$_REQUEST['attendence_view']:0,
										"delete"=>isset($_REQUEST['attendence_delete'])?$_REQUEST['attendence_delete']:0
							  ],						  
							  
							    "assign-workout"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/assigne-workout.png'),
								         "menu_title"=>'Assigned Workouts',
										 "page_link"=>'assign-workout',
										 "own_data" => isset($_REQUEST['assign_workout_own_data'])?$_REQUEST['assign_workout_own_data']:0,
										 "add" => isset($_REQUEST['assign_workout_add'])?$_REQUEST['assign_workout_add']:1,
										"edit"=>isset($_REQUEST['assign_workout_edit'])?$_REQUEST['assign_workout_edit']:0,
										"view"=>isset($_REQUEST['assign_workout_view'])?$_REQUEST['assign_workout_view']:1,
										"delete"=>isset($_REQUEST['assign_workout_delete'])?$_REQUEST['assign_workout_delete']:1
							  ],
							    "workouts"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/workout.png'),
								         "menu_title"=>'Workouts',
										 "page_link"=>'workouts',
										 "own_data" => isset($_REQUEST['workouts_own_data'])?$_REQUEST['workouts_own_data']:0,
										 "add" => isset($_REQUEST['workouts_add'])?$_REQUEST['workouts_add']:1,
										"edit"=>isset($_REQUEST['workouts_edit'])?$_REQUEST['workouts_edit']:0,
										"view"=>isset($_REQUEST['workouts_view'])?$_REQUEST['workouts_view']:1,
										"delete"=>isset($_REQUEST['workouts_delete'])?$_REQUEST['workouts_delete']:0
							  ],
							    "accountant"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/accountant.png'),
								          "menu_title"=>'Accountant',
										  "page_link"=>'accountant',
										 "own_data" => isset($_REQUEST['accountant_own_data'])?$_REQUEST['accountant_own_data']:0,
										 "add" => isset($_REQUEST['accountant_add'])?$_REQUEST['accountant_add']:0,
										"edit"=>isset($_REQUEST['accountant_edit'])?$_REQUEST['accountant_edit']:0,
										"view"=>isset($_REQUEST['accountant_view'])?$_REQUEST['accountant_view']:1,
										"delete"=>isset($_REQUEST['accountant_delete'])?$_REQUEST['accountant_delete']:0
							  ],
							  
							  "membership_payment"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/fee.png'),
							             "menu_title"=>'Fee Payment',
										 "page_link"=>'membership_payment',
										 "own_data" => isset($_REQUEST['membership_payment_own_data'])?$_REQUEST['membership_payment_own_data']:0,
										 "add" => isset($_REQUEST['membership_payment_add'])?$_REQUEST['membership_payment_add']:0,
										"edit"=>isset($_REQUEST['membership_payment_edit'])?$_REQUEST['membership_payment_edit']:0,
										"view"=>isset($_REQUEST['membership_payment_view'])?$_REQUEST['membership_payment_view']:0,
										"delete"=>isset($_REQUEST['membership_payment_delete'])?$_REQUEST['membership_payment_delete']:0
							  ],
							  
							  "payment"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/payment.png'),
							             "menu_title"=>'Payment',
										 "page_link"=>'payment',
										 "own_data" => isset($_REQUEST['payment_own_data'])?$_REQUEST['payment_own_data']:0,
										 "add" => isset($_REQUEST['payment_add'])?$_REQUEST['payment_add']:0,
										"edit"=>isset($_REQUEST['payment_edit'])?$_REQUEST['payment_edit']:0,
										"view"=>isset($_REQUEST['payment_view'])?$_REQUEST['payment_view']:0,
										"delete"=>isset($_REQUEST['payment_delete'])?$_REQUEST['payment_delete']:0
							  ],
							  "product"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/products.png'),
							           "menu_title"=>'Product',
									   "page_link"=>'product',
										 "own_data" => isset($_REQUEST['product_own_data'])?$_REQUEST['product_own_data']:0,
										 "add" => isset($_REQUEST['product_add'])?$_REQUEST['product_add']:1,
										"edit"=>isset($_REQUEST['product_edit'])?$_REQUEST['product_edit']:1,
										"view"=>isset($_REQUEST['product_view'])?$_REQUEST['product_view']:1,
										"delete"=>isset($_REQUEST['product_delete'])?$_REQUEST['product_delete']:1
							  ],
							  "store"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/store.png'),
							              "menu_title"=>'Store',
										  "page_link"=>'store',
										 "own_data" => isset($_REQUEST['store_own_data'])?$_REQUEST['store_own_data']:0,
										 "add" => isset($_REQUEST['store_add'])?$_REQUEST['store_add']:1,
										"edit"=>isset($_REQUEST['store_edit'])?$_REQUEST['store_edit']:0,
										"view"=>isset($_REQUEST['store_view'])?$_REQUEST['store_view']:1,
										"delete"=>isset($_REQUEST['store_delete'])?$_REQUEST['store_delete']:0
							  ],
							  "news_letter"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/newsletter.png'),
							            "menu_title"=>'Newsletter',
										"page_link"=>'news_letter',
										 "own_data" => isset($_REQUEST['news_letter_own_data'])?$_REQUEST['news_letter_own_data']:0,
										 "add" => isset($_REQUEST['news_letter_add'])?$_REQUEST['news_letter_add']:0,
										"edit"=>isset($_REQUEST['news_letter_edit'])?$_REQUEST['news_letter_edit']:0,
										"view"=>isset($_REQUEST['news_letter_view'])?$_REQUEST['news_letter_view']:1,
										"delete"=>isset($_REQUEST['news_letter_delete'])?$_REQUEST['news_letter_delete']:0
							  ],
							  "message"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/message.png'),
							             "menu_title"=>'Message',
										 "page_link"=>'message',
										 "own_data" => isset($_REQUEST['message_own_data'])?$_REQUEST['message_own_data']:1,
										 "add" => isset($_REQUEST['message_add'])?$_REQUEST['message_add']:1,
										"edit"=>isset($_REQUEST['message_edit'])?$_REQUEST['message_edit']:0,
										"view"=>isset($_REQUEST['message_view'])?$_REQUEST['message_view']:1,
										"delete"=>isset($_REQUEST['message_delete'])?$_REQUEST['message_delete']:1
							  ],
							  
							   "notice"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/notice.png'),
							           "menu_title"=>'Notice',
									   "page_link"=>'notice',
										 "own_data" => isset($_REQUEST['notice_own_data'])?$_REQUEST['notice_own_data']:1,
										 "add" => isset($_REQUEST['notice_add'])?$_REQUEST['notice_add']:0,
										"edit"=>isset($_REQUEST['notice_edit'])?$_REQUEST['notice_edit']:0,
										"view"=>isset($_REQUEST['notice_view'])?$_REQUEST['notice_view']:1,
										"delete"=>isset($_REQUEST['notice_delete'])?$_REQUEST['notice_delete']:0
							  ],
							  
							   "nutrition"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/nutrition-schedule.png'),
							            "menu_title"=>'Nutrition Schedule',
										"page_link"=>'nutrition',
										 "own_data" => isset($_REQUEST['nutrition_own_data'])?$_REQUEST['nutrition_own_data']:0,
										 "add" => isset($_REQUEST['nutrition_add'])?$_REQUEST['nutrition_add']:1,
										"edit"=>isset($_REQUEST['nutrition_edit'])?$_REQUEST['nutrition_edit']:0,
										"view"=>isset($_REQUEST['nutrition_view'])?$_REQUEST['nutrition_view']:1,
										"delete"=>isset($_REQUEST['nutrition_delete'])?$_REQUEST['nutrition_delete']:1
							  ],
							  
							   "reservation"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/reservation.png'),							       
								         "menu_title"=>'Reservation',
										 "page_link"=>'reservation',
										 "own_data" => isset($_REQUEST['reservation_own_data'])?$_REQUEST['reservation_own_data']:0,
										 "add" => isset($_REQUEST['reservation_add'])?$_REQUEST['reservation_add']:1,
										"edit"=>isset($_REQUEST['reservation_edit'])?$_REQUEST['reservation_edit']:1,
										"view"=>isset($_REQUEST['reservation_view'])?$_REQUEST['reservation_view']:1,
										"delete"=>isset($_REQUEST['reservation_delete'])?$_REQUEST['reservation_delete']:1
							  ],
							  
							   "account"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/account.png'),
							              "menu_title"=>'Account',
										  "page_link"=>'account',
										 "own_data" => isset($_REQUEST['account_own_data'])?$_REQUEST['account_own_data']:0,
										 "add" => isset($_REQUEST['account_add'])?$_REQUEST['account_add']:0,
										"edit"=>isset($_REQUEST['account_edit'])?$_REQUEST['account_edit']:0,
										"view"=>isset($_REQUEST['account_view'])?$_REQUEST['account_view']:1,
										"delete"=>isset($_REQUEST['account_delete'])?$_REQUEST['account_delete']:0
							  ],
							   "subscription_history"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/subscription_history.png'),
							             "menu_title"=>'Subscription History',
										 "page_link"=>'subscription_history',
										 "own_data" => isset($_REQUEST['subscription_history_own_data'])?$_REQUEST['subscription_history_own_data']:0,
										 "add" => isset($_REQUEST['subscription_history_add'])?$_REQUEST['subscription_history_add']:0,
										"edit"=>isset($_REQUEST['subscription_history_edit'])?$_REQUEST['subscription_history_edit']:0,
										"view"=>isset($_REQUEST['subscription_history_view'])?$_REQUEST['subscription_history_view']:0,
										"delete"=>isset($_REQUEST['subscription_history_delete'])?$_REQUEST['subscription_history_delete']:0
							  ]
			];	
				
		$access_right_accountant = array();
		$access_right_accountant['accountant'] = [
							"staff_member"=>["menu_icone"=>plugins_url('gym-management/assets/images/icon/staff-member.png'),
							           "menu_title"=>'Staff Members',
							           "page_link"=>'staff_member',
									   "own_data" =>isset($_REQUEST['staff_member_own_data'])?$_REQUEST['staff_member_own_data']:0,
									   "add" =>isset($_REQUEST['staff_member_add'])?$_REQUEST['staff_member_add']:0,
										"edit"=>isset($_REQUEST['staff_member_edit'])?$_REQUEST['staff_member_edit']:0,
										"view"=>isset($_REQUEST['staff_member_view'])?$_REQUEST['staff_member_view']:1,
										"delete"=>isset($_REQUEST['staff_member_delete'])?$_REQUEST['staff_member_delete']:0
										],
												
						   "membership"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/membership-type.png'),
						              "menu_title"=>'Membership Type',
						              "page_link"=>'membership',
									 "own_data" => isset($_REQUEST['membership_own_data'])?$_REQUEST['membership_own_data']:0,
									 "add" => isset($_REQUEST['membership_add'])?$_REQUEST['membership_add']:0,
									 "edit"=>isset($_REQUEST['membership_edit'])?$_REQUEST['membership_edit']:0,
									 "view"=>isset($_REQUEST['membership_view'])?$_REQUEST['membership_view']:0,
									 "delete"=>isset($_REQUEST['membership_delete'])?$_REQUEST['membership_delete']:0
						  ],
									  
							"group"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/group.png'),
							        "menu_title"=>'Group',
									"page_link"=>'group',
									 "own_data" => isset($_REQUEST['group_own_data'])?$_REQUEST['group_own_data']:0,
									 "add" => isset($_REQUEST['group_add'])?$_REQUEST['group_add']:0,
									"edit"=>isset($_REQUEST['group_edit'])?$_REQUEST['group_edit']:0,
									"view"=>isset($_REQUEST['group_view'])?$_REQUEST['group_view']:0,
									"delete"=>isset($_REQUEST['group_delete'])?$_REQUEST['group_delete']:0
						  ],
									  
							  "member"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/member.png'),
							            "menu_title"=>'Member',
										"page_link"=>'member',
										"own_data" => isset($_REQUEST['member_own_data'])?$_REQUEST['member_own_data']:0,
										 "add" => isset($_REQUEST['member_add'])?$_REQUEST['member_add']:0,
										 "edit"=>isset($_REQUEST['member_edit'])?$_REQUEST['member_edit']:0,
										"view"=>isset($_REQUEST['member_view'])?$_REQUEST['member_view']:1,
										"delete"=>isset($_REQUEST['member_delete'])?$_REQUEST['member_delete']:0
							  ],
							  
							  "activity"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/activity.png'),
							             "menu_title"=>'Activity',
										 "page_link"=>'activity',
										 "own_data" => isset($_REQUEST['activity_own_data'])?$_REQUEST['activity_own_data']:0,
										 "add" => isset($_REQUEST['activity_add'])?$_REQUEST['activity_add']:0,
										"edit"=>isset($_REQUEST['activity_edit'])?$_REQUEST['activity_edit']:0,
										"view"=>isset($_REQUEST['activity_view'])?$_REQUEST['activity_view']:0,
										"delete"=>isset($_REQUEST['activity_delete'])?$_REQUEST['activity_delete']:0
							  ],
							  "class-schedule"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/class-schedule.png'),
							               "menu_title"=>'Class schedule',
										   "page_link"=>'class-schedule',
										 "own_data" => isset($_REQUEST['class_schedule_own_data'])?$_REQUEST['class_schedule_own_data']:0,
										 "add" => isset($_REQUEST['class_schedule_add'])?$_REQUEST['class_schedule_add']:0,
										"edit"=>isset($_REQUEST['class_schedule_edit'])?$_REQUEST['class_schedule_edit']:0,
										"view"=>isset($_REQUEST['class_schedule_view'])?$_REQUEST['class_schedule_view']:0,
										"delete"=>isset($_REQUEST['class_schedule_delete'])?$_REQUEST['class_schedule_delete']:0
							  ],
							  
							    "attendence"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/attandance.png'),
								         "menu_title"=>'Attendence',
										 "page_link"=>'attendence',
										 "own_data" => isset($_REQUEST['attendence_own_data'])?$_REQUEST['attendence_own_data']:0,
										 "add" => isset($_REQUEST['attendence_add'])?$_REQUEST['attendence_add']:0,
										"edit"=>isset($_REQUEST['attendence_edit'])?$_REQUEST['attendence_edit']:0,
										"view"=>isset($_REQUEST['attendence_view'])?$_REQUEST['attendence_view']:0,
										"delete"=>isset($_REQUEST['attendence_delete'])?$_REQUEST['attendence_delete']:0
							  ],						  
							  
							    "assign-workout"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/assigne-workout.png'),
								         "menu_title"=>'Assigned Workouts',
										 "page_link"=>'assign-workout',
										 "own_data" => isset($_REQUEST['assign_workout_own_data'])?$_REQUEST['assign_workout_own_data']:0,
										 "add" => isset($_REQUEST['assign_workout_add'])?$_REQUEST['assign_workout_add']:0,
										"edit"=>isset($_REQUEST['assign_workout_edit'])?$_REQUEST['assign_workout_edit']:0,
										"view"=>isset($_REQUEST['assign_workout_view'])?$_REQUEST['assign_workout_view']:0,
										"delete"=>isset($_REQUEST['assign_workout_delete'])?$_REQUEST['assign_workout_delete']:0
							  ],
							    "workouts"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/workout.png'),
								         "menu_title"=>'Workouts',
										 "page_link"=>'workouts',
										 "own_data" => isset($_REQUEST['workouts_own_data'])?$_REQUEST['workouts_own_data']:0,
										 "add" => isset($_REQUEST['workouts_add'])?$_REQUEST['workouts_add']:0,
										"edit"=>isset($_REQUEST['workouts_edit'])?$_REQUEST['workouts_edit']:0,
										"view"=>isset($_REQUEST['workouts_view'])?$_REQUEST['workouts_view']:0,
										"delete"=>isset($_REQUEST['workouts_delete'])?$_REQUEST['workouts_delete']:0
							  ],
							    "accountant"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/accountant.png'),
								          "menu_title"=>'Accountant',
										  "page_link"=>'accountant',
										 "own_data" => isset($_REQUEST['accountant_own_data'])?$_REQUEST['accountant_own_data']:1,
										 "add" => isset($_REQUEST['accountant_add'])?$_REQUEST['accountant_add']:0,
										"edit"=>isset($_REQUEST['accountant_edit'])?$_REQUEST['accountant_edit']:0,
										"view"=>isset($_REQUEST['accountant_view'])?$_REQUEST['accountant_view']:1,
										"delete"=>isset($_REQUEST['accountant_delete'])?$_REQUEST['accountant_delete']:0
							  ],
							  
							  "membership_payment"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/fee.png'),
							             "menu_title"=>'Fee Payment',
										 "page_link"=>'membership_payment',
										 "own_data" => isset($_REQUEST['membership_payment_own_data'])?$_REQUEST['membership_payment_own_data']:0,
										 "add" => isset($_REQUEST['membership_payment_add'])?$_REQUEST['membership_payment_add']:0,
										"edit"=>isset($_REQUEST['membership_payment_edit'])?$_REQUEST['membership_payment_edit']:0,
										"view"=>isset($_REQUEST['membership_payment_view'])?$_REQUEST['membership_payment_view']:1,
										"delete"=>isset($_REQUEST['membership_payment_delete'])?$_REQUEST['membership_payment_delete']:0
							  ],
							  
							  "payment"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/payment.png'),
							             "menu_title"=>'Payment',
										 "page_link"=>'payment',
										 "own_data" => isset($_REQUEST['payment_own_data'])?$_REQUEST['payment_own_data']:0,
										 "add" => isset($_REQUEST['payment_add'])?$_REQUEST['payment_add']:1,
										"edit"=>isset($_REQUEST['payment_edit'])?$_REQUEST['payment_edit']:1,
										"view"=>isset($_REQUEST['payment_view'])?$_REQUEST['payment_view']:1,
										"delete"=>isset($_REQUEST['payment_delete'])?$_REQUEST['payment_delete']:1
							  ],
							  "product"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/products.png'),
							           "menu_title"=>'Product',
									   "page_link"=>'product',
										 "own_data" => isset($_REQUEST['product_own_data'])?$_REQUEST['product_own_data']:0,
										 "add" => isset($_REQUEST['product_add'])?$_REQUEST['product_add']:1,
										"edit"=>isset($_REQUEST['product_edit'])?$_REQUEST['product_edit']:1,
										"view"=>isset($_REQUEST['product_view'])?$_REQUEST['product_view']:1,
										"delete"=>isset($_REQUEST['product_delete'])?$_REQUEST['product_delete']:1
							  ],
							  "store"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/store.png'),
							              "menu_title"=>'Store',
										  "page_link"=>'store',
										 "own_data" => isset($_REQUEST['store_own_data'])?$_REQUEST['store_own_data']:0,
										 "add" => isset($_REQUEST['store_add'])?$_REQUEST['store_add']:1,
										"edit"=>isset($_REQUEST['store_edit'])?$_REQUEST['store_edit']:0,
										"view"=>isset($_REQUEST['store_view'])?$_REQUEST['store_view']:1,
										"delete"=>isset($_REQUEST['store_delete'])?$_REQUEST['store_delete']:0
							  ],
							  "news_letter"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/newsletter.png'),
							            "menu_title"=>'Newsletter',
										"page_link"=>'news_letter',
										 "own_data" => isset($_REQUEST['news_letter_own_data'])?$_REQUEST['news_letter_own_data']:0,
										 "add" => isset($_REQUEST['news_letter_add'])?$_REQUEST['news_letter_add']:0,
										"edit"=>isset($_REQUEST['news_letter_edit'])?$_REQUEST['news_letter_edit']:0,
										"view"=>isset($_REQUEST['news_letter_view'])?$_REQUEST['news_letter_view']:0,
										"delete"=>isset($_REQUEST['news_letter_delete'])?$_REQUEST['news_letter_delete']:0
							  ],
							  "message"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/message.png'),
							             "menu_title"=>'Message',
										 "page_link"=>'message',
										 "own_data" => isset($_REQUEST['message_own_data'])?$_REQUEST['message_own_data']:1,
										 "add" => isset($_REQUEST['message_add'])?$_REQUEST['message_add']:1,
										"edit"=>isset($_REQUEST['message_edit'])?$_REQUEST['message_edit']:0,
										"view"=>isset($_REQUEST['message_view'])?$_REQUEST['message_view']:1,
										"delete"=>isset($_REQUEST['message_delete'])?$_REQUEST['message_delete']:1
							  ],
							  
							   "notice"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/notice.png'),
							           "menu_title"=>'Notice',
									   "page_link"=>'notice',
										 "own_data" => isset($_REQUEST['notice_own_data'])?$_REQUEST['notice_own_data']:1,
										 "add" => isset($_REQUEST['notice_add'])?$_REQUEST['notice_add']:0,
										"edit"=>isset($_REQUEST['notice_edit'])?$_REQUEST['notice_edit']:0,
										"view"=>isset($_REQUEST['notice_view'])?$_REQUEST['notice_view']:1,
										"delete"=>isset($_REQUEST['notice_delete'])?$_REQUEST['notice_delete']:0
							  ],
							  
							   "nutrition"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/nutrition-schedule.png'),
							            "menu_title"=>'Nutrition Schedule',
										"page_link"=>'nutrition',
										 "own_data" => isset($_REQUEST['nutrition_own_data'])?$_REQUEST['nutrition_own_data']:0,
										 "add" => isset($_REQUEST['nutrition_add'])?$_REQUEST['nutrition_add']:0,
										"edit"=>isset($_REQUEST['nutrition_edit'])?$_REQUEST['nutrition_edit']:0,
										"view"=>isset($_REQUEST['nutrition_view'])?$_REQUEST['nutrition_view']:0,
										"delete"=>isset($_REQUEST['nutrition_delete'])?$_REQUEST['nutrition_delete']:0
							  ],
							  
							   "reservation"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/reservation.png'),							       
								         "menu_title"=>'Reservation',
										 "page_link"=>'reservation',
										 "own_data" => isset($_REQUEST['reservation_own_data'])?$_REQUEST['reservation_own_data']:0,
										 "add" => isset($_REQUEST['reservation_add'])?$_REQUEST['reservation_add']:0,
										"edit"=>isset($_REQUEST['reservation_edit'])?$_REQUEST['reservation_edit']:0,
										"view"=>isset($_REQUEST['reservation_view'])?$_REQUEST['reservation_view']:0,
										"delete"=>isset($_REQUEST['reservation_delete'])?$_REQUEST['reservation_delete']:0
							  ],
							  
							   "account"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/account.png'),
							              "menu_title"=>'Account',
										  "page_link"=>'account',
										 "own_data" => isset($_REQUEST['account_own_data'])?$_REQUEST['account_own_data']:0,
										 "add" => isset($_REQUEST['account_add'])?$_REQUEST['account_add']:0,
										"edit"=>isset($_REQUEST['account_edit'])?$_REQUEST['account_edit']:0,
										"view"=>isset($_REQUEST['account_view'])?$_REQUEST['account_view']:1,
										"delete"=>isset($_REQUEST['account_delete'])?$_REQUEST['account_delete']:0
							  ],
							   "subscription_history"=>['menu_icone'=>plugins_url( 'gym-management/assets/images/icon/subscription_history.png'),
							             "menu_title"=>'Subscription History',
										 "page_link"=>'subscription_history',
										 "own_data" => isset($_REQUEST['subscription_history_own_data'])?$_REQUEST['subscription_history_own_data']:0,
										 "add" => isset($_REQUEST['subscription_history_add'])?$_REQUEST['subscription_history_add']:0,
										"edit"=>isset($_REQUEST['subscription_history_edit'])?$_REQUEST['subscription_history_edit']:0,
										"view"=>isset($_REQUEST['subscription_history_view'])?$_REQUEST['subscription_history_view']:0,
										"delete"=>isset($_REQUEST['subscription_history_delete'])?$_REQUEST['subscription_history_delete']:0
							  ]
			];	
			
		$options=array("gmgt_system_name"=> __( 'Gym Management System' ,'gym_mgt'),
					"gmgt_staring_year"=>"2015",
					"gmgt_gym_address"=>"",
					"gmgt_contact_number"=>"9999999999",
					"gmgt_contry"=>"India",
					"gmgt_email"=>get_option('admin_email'),
					"gmgt_datepicker_format"=>'yy/mm/dd',
					"gmgt_system_logo"=>plugins_url( 'gym-management/assets/images/Thumbnail-img.png' ),
					"gmgt_gym_background_image"=>plugins_url('gym-management/assets/images/gym-background.png' ),
					"gmgt_instructor_thumb"=>plugins_url( 'gym-management/assets/images/useriamge/instructor.png' ),
					"gmgt_member_thumb"=>plugins_url( 'gym-management/assets/images/useriamge/member.png' ),
					
					"gmgt_assistant_thumb"=>plugins_url( 'gym-management/assets/images/useriamge/assistant.png' ),
					
					"gmgt_accountant_thumb"=>plugins_url( 'gym-management/assets/images/useriamge/accountant.png' ),
					
					"gmgt_mailchimp_api"=>"",
					"gmgt_sms_service"=>"",
					"gmgt_sms_service_enable"=> 0,					
					"gmgt_clickatell_sms_service"=>array(),
					"gmgt_twillo_sms_service"=>array(),
					"gmgt_weight_unit"=>'KG',
					"gmgt_height_unit"=>'Centemeter',
					"gmgt_chest_unit"=>'Inches',
					"gmgt_waist_unit"=>'Inches',
					"gmgt_thigh_unit"=>'Inches',
					"gmgt_arms_unit"=>'Inches',
					"gmgt_fat_unit"=>'Percentage',
					"gmgt_paypal_email"=>'',
					"gym_enable_sandbox"=>'yes',
					"pm_payment_method"=>'paypal',
					"gmgt_currency_code" => 'USD',
					/*"gym_enable_memberlist_for_member" => 'yes',
					"gym_enable_trainee_memberlist_for_staffmember" => 'no',*/
					"gym_enable_membership_alert_message" => 'yes',
					"gmgt_reminder_before_days" => '20',
					"gmgt_bank_holder_name"=>"",
					"gmgt_bank_name"=>"",
					"gmgt_bank_acount_number"=>"",
					"gmgt_bank_ifsc_code"=>"",
					"gmgt_mailchimp_api"=>"",
					"gym_enable_past_attendance"=>"no",
					"gym_enable_datepicker_privious_date"=>"no",
					
					"gmgt_access_right_member"=>$access_right_member,				
					"gmgt_access_right_staff_member"=>$access_right_staff_member,				
					"gmgt_access_right_accountant"=>$access_right_accountant,		
					
					"gym_reminder_message" => 'Hello [GMGT_MEMBERNAME],
					
      Your [GMGT_MEMBERSHIP]  started at [GMGT_STARTDATE] and it will be expire on [GMGT_ENDDATE].',
	  
	               'registration_title'=>'You are successfully registered at [GMGT_GYM_NAME]',
					'registration_mailtemplate'=>'Dear [GMGT_MEMBERNAME] ,
					
        You are successfully registered at [GMGT_GYM_NAME] .Your member id is [GMGT_MEMBERID] .Your  Membership name is [GMGT_MEMBERSHIP] .Your Membership start date is [GMGT_STARTDATE] .Your Membership end date is [GMGT_ENDDATE] .You can access your account after admin approval.

Regards From [GMGT_GYM_NAME].',

                   'Member_Approved_Template_Subject'=>'You profile has been approved by admin at [GMGT_GYM_NAME]',
					'Member_Approved_Template'=>'Dear Member Name,
					
         You are successfully registered at [GMGT_GYM_NAME].You profile has been approved by admin and you can sign in using this link. [GMGT_LOGIN_LINK] 
 
Regards From [GMGT_GYM_NAME].',

                    'Add_Other_User_in_System_Subject'=>'Your have been assigned role of [GMGT_ROLE_NAME] in [GMGT_GYM_NAME] ',
					'Add_Other_User_in_System_Template'=>'Dear [GMGT_USERNAME],
					
         You are Added by admin of [GMGT_GYM_NAME].Your have been assigned role of [GMGT_ROLE_NAME] in [GMGT_GYM_NAME]. You can access system using your username and password.  You can signin using this link.[GMGT_LOGIN_LINK] 
UserName : [GMGT_Username].
Password : [GMGT_PASSWORD].
Regards From [GMGT_GYM_NAME].',

                    'Add_Notice_Subject'=>'New Notice from [GMGT_USERNAME] at [GMGT_GYM_NAME] ',
					'Add_Notice_Template'=>'Dear [GMGT_USERNAME] ,
					
         Here is the new Notice from  [GMGT_MEMBERNAME].
Title : [GMGT_NOTICE_TITLE].
Notice For: [GMGT_NOTICE_FOR].
Notice Start Date : Notice [GMGT_STARTDATE].
Notice End Date : Notice [GMGT_ENDDATE].
Description : Notice [GMGT_COMMENT].
View Notice Click [GMGT_NOTICE_LINK]

Regards From [GMGT_GYM_NAME] .',

                    'Member_Added_In_Group_subject'=>'You are added in [GMGT_GROUPNAME] at [GMGT_GYM_NAME] ',
					'Member_Added_In_Group_Template'=>'Dear [GMGT_USERNAME],
					
         You are added in [GMGT_GROUPNAME] . 
     
Regards From [GMGT_GYM_NAME] .',

                    'Assign_Workouts_Subject'=>'New workouts assigned to you at [GMGT_GYM_NAME] ',
					'Assign_Workouts_Template'=>'Dear [GMGT_MEMBERNAME],
					
         You have assigned new workouts for [GMGT_STARTDATE] To [GMGT_ENDDATE] .We have also attached your schedule.For View  Workout  [GMGT_PAGE_LINK]

Regards From [GMGT_GYM_NAME] .',

                    'Add_Reservation_Subject'=>' [GMGT_EVENT_PLACE] have been Successfully reserved for you for [GMGT_EVENT_NAME] on [GMGT_EVENT_DATE] And [GMGT_START_TIME] ',
					'Add_Reservation_Template'=>'Dear [GMGT_STAFF_MEMBERNAME],
					
        [GMGT_EVENT_PLACE] has been successfully booked for you. This place booked for [GMGT_EVENT_NAME] on [GMGT_EVENT_DATE] And [GMGT_START_TIME] . 
   
        Event Name: [GMGT_EVENT_NAME].
        Event Date : [GMGT_EVENT_DATE].
        Event Place: [GMGT_EVENT_PLACE].
        Event Start Time: [GMGT_START_TIME]. 
        Event EndTime: [GMGT_END_TIME].
[GMGT_PAGE_LINK] 
		
Regards From [GMGT_GYM_NAME] .',

                    'Assign_Nutrition_Schedule_Subject'=>'New Nutrition Schedule assigned to you at [GMGT_GYM_NAME] ',
					'Assign_Nutrition_Schedule_Template'=>'Dear [GMGT_MEMBERNAME],
					
          You have assigned new nutrition schedule for [GMGT_STARTDATE] To [GMGT_ENDDATE]. We have also attached your schedule.For View Nutrition  [GMGT_PAGE_LINK]

Regards From [GMGT_GYM_NAME].',

                    'Submit_Workouts_Subject'=>'[GMGT_STAFF_MEMBERNAME]  has updated daily workout log',
					'Submit_Workouts_Template'=>'Dear [GMGT_STAFF_MEMBERNAME] ,

        I have completed my workout of [GMGT_DAY_NAME] on [GMGT_DATE] . Attached details of my workouts. 
		 
Regards From [GMGT_GYM_NAME].',

                    'sell_product_subject'=>'You have purchased new product from  [GMGT_GYM_NAME]',
					'sell_product_template'=>'Dear [GMGT_USERNAME], 
             
             Your have purchased products.  You can check the product  Invoice attached here. 

Regards From [GMGT_GYM_NAME] .',

                    'generate_invoice_subject'=>'Your have a new invoice from [GMGT_GYM_NAME]',
					'generate_invoice_template'=>'Dear [GMGT_USERNAME],

        Your have a new Fees invoice. You can check the invoice attached here. For payment click [GMGT_PAYMENT_LINK]
 
Regards From [GMGT_GYM_NAME].',

                    'add_income_subject'=>'Your have a new Payment Invoice raised by [GMGT_ROLE_NAME] at [GMGT_GYM_NAME]',
					'add_income_template'=>'Dear [GMGT_USERNAME],

        Your have a new Payment Invoice raised by Admin. You can check the Invoice attached here.
 
Regards From [GMGT_GYM_NAME].',

                    'payment_received_against_invoice_subject'=>'Your have successfully paid your invoice at [GMGT_GYM_NAME]',
					'payment_received_against_invoice_template'=>'Dear [GMGT_USERNAME],

        Your have successfully paid your invoice.  You can check the invoice attached here.
 
Regards From [GMGT_GYM_NAME].',

                    'message_received_subject'=>'You have received new message from [GMGT_SENDER_NAME]  at [GMGT_GYM_NAME]',
					'message_received_template'=>'Dear [GMGT_RECEIVER_NAME],

         You have received new message from [GMGT_SENDER_NAME]. [GMGT_MESSAGE_CONTENT].
 
Regards From [GMGT_GYM_NAME].',

		);
		return $options;
	}
	add_action('admin_init','gmgt_general_setting');	
	function gmgt_general_setting()
	{
		$options=gmgt_option();
		foreach($options as $key=>$val)
		{
			add_option($key,$val); 
			
		}
	}
//GET ALL SCRIPT PAGE IN ADMIN SIDE FUNCTION
function gmgt_call_script_page()
{
	$page_array = array('gmgt_system','gmgt_membership_type','gmgt_group','gmgt_staff','gmgt_accountant','gmgt_class','gmgt_member',
			'gmgt_product','gmgt_reservation','gmgt_attendence','gmgt_fees_payment','gmgt_payment','Gmgt_message','gmgt_newsletter','gmgt_activity',
			'gmgt_notice','gmgt_workouttype','gmgt_workout','gmgt_store','gmgt_nutrition','gmgt_report','gmgt_mail_template','gmgt_gnrl_settings','gmgt_access_right','gmgt_alumni','gmgt_prospect','gmgt_setup');
	return  $page_array;
}


function gmgt_change_adminbar_css($hook)
 {	
	$current_page = $_REQUEST['page'];
	$page_array = gmgt_call_script_page();
	if(in_array($current_page,$page_array))
    {
				//wp_register_script( 'jquery-1.8.2', plugins_url( '/assets/js/jquery-1.11.1.min.js', __FILE__), array( 'jquery' ) );
			 	//wp_enqueue_script( 'jquery-1.8.2' );		
				wp_enqueue_style( 'accordian-jquery-ui-css', plugins_url( '/assets/accordian/jquery-ui.css', __FILE__) );		
				wp_enqueue_script('accordian-jquery-ui', plugins_url( '/assets/accordian/jquery-ui.js',__FILE__ ));
			
				wp_enqueue_style( 'gmgt  -calender-css', plugins_url( '/assets/css/fullcalendar.css', __FILE__) );
				wp_enqueue_style( 'gmgt  -datatable-css', plugins_url( '/assets/css/dataTables.css', __FILE__) );
				wp_enqueue_style( 'gmgt-dataTables.responsive-css', plugins_url( '/assets/css/dataTables.responsive.css', __FILE__) );
				//wp_enqueue_style( 'gmgt  -admin-style-css', plugins_url( '/admin/css/admin-style.css', __FILE__) );
				wp_enqueue_style( 'gmgt  -style-css', plugins_url( '/assets/css/style.css', __FILE__) );
				wp_enqueue_style( 'gmgt  -popup-css', plugins_url( '/assets/css/popup.css', __FILE__) );
				wp_enqueue_style( 'gmgt  -custom-css', plugins_url( '/assets/css/custom.css', __FILE__) );
				wp_enqueue_style( 'gmgt-select2-css', plugins_url( '/lib/select2-3.5.3/select2.css', __FILE__) );
				
				wp_enqueue_script('gmgt-select2', plugins_url( '/lib/select2-3.5.3/select2.min.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );
				
				
				wp_enqueue_script('gmgt  -calender_moment', plugins_url( '/assets/js/moment.min.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );
				wp_enqueue_script('gmgt  -calender', plugins_url( '/assets/js/fullcalendar.min.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );
				wp_enqueue_script('gmgt  -datatable', plugins_url( '/assets/js/jquery.dataTables.min.js',__FILE__ ), array( 'jquery' ), '4.1.1', true);
				$lancode=get_locale();
				$code=substr($lancode,0,2);
				wp_enqueue_script('gmgt-calender-'.$code.'', plugins_url( '/assets/js/calendar-lang/'.$code.'.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );
				wp_enqueue_script('gmgt  -datatable-tools', plugins_url( '/assets/js/dataTables.tableTools.min.js',__FILE__ ), array( 'jquery' ), '4.1.1', true);
				wp_enqueue_script('gmgt  -datatable-editor', plugins_url( '/assets/js/dataTables.editor.min.js',__FILE__ ), array( 'jquery' ), '4.1.1', true);	
				wp_enqueue_script('gmgt-dataTables.responsive-js', plugins_url( '/assets/js/dataTables.responsive.js',__FILE__ ), array( 'jquery' ), '4.1.1', true);	
				wp_enqueue_script('gmgt-customjs', plugins_url( '/assets/js/gmgt_custom.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );
			
			
			
				wp_enqueue_script('gmgt-popup', plugins_url( '/assets/js/popup.js', __FILE__ ), array( 'jquery' ), '4.1.1', false );
				wp_localize_script( 'gmgt-popup', 'gmgt', array( 'ajax' => admin_url( 'admin-ajax.php' ) ) );
			 	wp_enqueue_script('jquery');
			 	wp_enqueue_media();
		       	wp_enqueue_script('thickbox');
		       	wp_enqueue_style('thickbox');
		 
		      
			 	wp_enqueue_script('gmgt -image-upload', plugins_url( '/assets/js/image-upload.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );
			 
			
				wp_enqueue_style( 'gmgt  -bootstrap-css', plugins_url( '/assets/css/bootstrap.min.css', __FILE__) );
				wp_enqueue_style( 'gmgt  -bootstrap-multiselect-css', plugins_url( '/assets/css/bootstrap-multiselect.css', __FILE__) );
				//wp_enqueue_style( 'gmgt  -bootstrap-timepicker-css', plugins_url( '/assets/css/bootstrap-timepicker.min.css', __FILE__) );
				wp_enqueue_style( 'gmgt  -bootstrap-timepicker-css', plugins_url( '/assets/css/datepicker.min.css', __FILE__) );
				//wp_enqueue_style( 'gmgt  -bootstrap-timepicker-css', plugins_url( '/assets/css/datepicker.css', __FILE__) );
			 	wp_enqueue_style( 'gmgt  -font-awesome-css', plugins_url( '/assets/css/font-awesome.min.css', __FILE__) );
			 	wp_enqueue_style( 'gmgt  -white-css', plugins_url( '/assets/css/white.css', __FILE__) );
			 	wp_enqueue_style( 'gmgt-gymmgt-min-css', plugins_url( '/assets/css/gymmgt.min.css', __FILE__) );
			 	wp_enqueue_style( 'gmgt-sweetalert-css', plugins_url( '/assets/css/sweetalert.css', __FILE__) );
				if (is_rtl())
				{
					wp_enqueue_style( 'gmgt-bootstrap-rtl-css', plugins_url( '/assets/css/bootstrap-rtl.min.css', __FILE__) );
				}
				wp_enqueue_style( 'gmgt-gym-responsive-css', plugins_url( '/assets/css/gym-responsive.css', __FILE__) );
			  
			 	wp_enqueue_script('gmgt-bootstrap-js', plugins_url( '/assets/js/bootstrap.min.js', __FILE__ ) );
			 	wp_enqueue_script('gmgt-bootstrap-multiselect-js', plugins_url( '/assets/js/bootstrap-multiselect.js', __FILE__ ) );
				//wp_enqueue_script('gmgt  -bootstrap-timepicker-js', plugins_url( '/assets/js/bootstrap-timepicker.min.js', __FILE__ ) );
			 	wp_enqueue_script('gmgt-bootstrap-timepicker-js', plugins_url( '/assets/js/bootstrap-datepicker.js', __FILE__ ) );
			 	wp_enqueue_script('gmgt-gym-js', plugins_url( '/assets/js/gymjs.js', __FILE__ ) );
				wp_enqueue_script('gmgt-slider-js', plugins_url( '/assets/js/jssor.slider.mini.js', __FILE__ ) );
				wp_enqueue_script('gmgt-sweetalert-dev-js', plugins_url( '/assets/js/sweetalert-dev.js', __FILE__ ) );
			 	
			 	//Validation style And Script
			 	
			 	//validation lib
			 	wp_enqueue_style( 'wcwm-validate-css', plugins_url( '/lib/validationEngine/css/validationEngine.jquery.css', __FILE__) );	 	
			 	wp_register_script( 'jquery-validationEngine-'.$code.'', plugins_url( '/lib/validationEngine/js/languages/jquery.validationEngine-'.$code.'.js', __FILE__), array( 'jquery' ) );
			 	wp_enqueue_script( 'jquery-validationEngine-'.$code.'' );
			 	wp_register_script( 'jquery-validationEngine', plugins_url( '/lib/validationEngine/js/jquery.validationEngine.js', __FILE__), array( 'jquery' ) );
			 	wp_enqueue_script( 'jquery-validationEngine' );
			    wp_enqueue_script('gmgt-gmgt_custom_confilict_obj-js', plugins_url( '/assets/js/gmgt_custom_confilict_obj.js', __FILE__ ) );
			 	
	}
		
}
	if(isset($_REQUEST['page']))
	add_action( 'admin_enqueue_scripts', 'gmgt_change_adminbar_css' );
}

//REMOVE OL STYLE IN THEMAE FUNCTION
function hmgt_remove_all_theme_styles() {
	global $wp_styles;
	$wp_styles->queue = array();
}
//FRONTEND SIDE CHECK USER DASHBORD FUNCTION
if(isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'user')
{
	add_action('wp_print_styles', 'hmgt_remove_all_theme_styles', 100);
}
//LOAD SCRIPT FUNCTION
function gmgt_load_script1()
{
	if(isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'user')
	{
	wp_register_script('gmgt  -popup-front', plugins_url( 'assets/js/popup.js', __FILE__ ), array( 'jquery' ));
	wp_enqueue_script('gmgt  -popup-front');
	
	wp_localize_script( 'gmgt  -popup-front', 'gmgt  ', array( 'ajax' => admin_url( 'admin-ajax.php' ) ) );
	 wp_enqueue_script('jquery');
	 
	}
	
	wp_enqueue_style( 'gmgt-style-css', plugins_url( '/assets/css/style.css', __FILE__) );
	

}
//DOMAIN NAME LOAD FUNCTION
function gmgt_domain_load(){
	load_plugin_textdomain( 'gym_mgt', false, dirname( plugin_basename( __FILE__ ) ). '/languages/' );
}
//INSTALL LOGIN PAGE
function gmgt_install_login_page()
{
	if ( !get_option('gmgt_login_page') ) {
		

		$curr_page = array(
				'post_title' => __('Gym Management Login Page', 'gym_mgt'),
				'post_content' => '[gmgt_login]',
				'post_status' => 'publish',
				'post_type' => 'page',
				'comment_status' => 'closed',
				'ping_status' => 'closed',
				'post_category' => array(1),
				'post_parent' => 0 );
		

		$curr_created = wp_insert_post( $curr_page );

		update_option( 'gmgt_login_page', $curr_created );

	}
	
}
//FRONTEN SIDE GET USER DASHBOARD REQUEST FUNCTION
function gmgt_user_dashboard()
{
	if(isset($_REQUEST['dashboard']))
	{
		require_once GMS_PLUGIN_DIR. '/fronted_template.php';
		exit;
	}
}
//GET USER CHOICE PAGE INSERT FUNCTION
function gmgt_user_choice_page() {
	

	if ( !get_option('gmgt_user_choice_page') ) {
		$curr_page = array(
			'post_title' => __('Member Registration or Login', 'gym_mgt'),
			'post_content' => '[gmgt_memberregistration]',
			'post_status' => 'publish',
			'post_type' => 'page',
			'comment_status' => 'closed',
			'ping_status' => 'closed',
			'post_category' => array(1),
			'post_parent' => 0 );
			$curr_created = wp_insert_post( $curr_page );
		update_option( 'gmgt_user_choice_page', $curr_created );
			
	}
}
//GET MEMBRSHIP LINK
function membershipcode_link($atts)
{
	if(isset($_POST['buy_membership']))
	{		
		$obj_member=new MJ_Gmgtmember;		
		$page_id = get_option ( 'gmgt_user_choice_page' );			
		$referrer_ipn = array(				
			'page_id' => $page_id,
			'membership_id'=>$_POST['membership_id']
		);				
		$referrer_ipn = add_query_arg( $referrer_ipn, home_url() );		
		wp_redirect ($referrer_ipn);	
		exit;
	}
		$obj_activity=new MJ_Gmgtactivity;
		$obj_membership=new MJ_Gmgtmembership;
		$atts = shortcode_atts( array(
		'id' => $atts['id'],
		'buttontxt' => __('Buy Now','gym_mgt')
		), $atts, 'gmgt_user_choice_page' );
		 $retrieved_data=$obj_membership->get_single_membership($atts['id']);
		if(!empty($retrieved_data))
		{ 
			$result = get_membership_class($retrieved_data->membership_id);
			if(!empty($result))
			{
					$fake="";
					if($result->classis_limit=='limited')
					{ $fake=1;
						//print $result->on_of_classis;
					}						
			}?>
		    <div class="wpgym-detail-box col-md-12">
				<div class="wpgym-border-box">
				<form name="membership" method="post" action="">
					<div class="wpgym-box-title">
						<span class="wpgym-membershiptitle">
							<?php echo $retrieved_data->membership_label;?>
						</span>
					</div>
					<div class="wpgym-course-lession-list">
					<?php echo $retrieved_data->membership_description;?>
					</div>
					<table>
					<thead>
					<tr>
						<th><?php _e('Installment Plan','gym_mgt');?></th>
						<th><?php _e('Cost','gym_mgt');?></th>
						<th> <?php if($fake==1)
							_e('Class',' gym_mgt');?>
						</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td><?php echo get_the_title($retrieved_data->install_plan_id);?></td>
						<td><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."".$retrieved_data->installment_amount;?></td>
						<td><?php if($fake==1){
							print $result->on_of_classis;
						}	?></td>
					</tr>
					</tbody>
					</table>
					
					<span class="wpgym-btn-buynow">
					<?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."".$retrieved_data->membership_amount;?>
					
					<input type="hidden" name="amount" value="<?php echo  $retrieved_data->membership_amount;?>">
					<input type="hidden" name="member_id" value="<?php echo get_current_user_id();?>">
					<input type="hidden" name="membership_id" value="<?php echo $retrieved_data->membership_id;?>">
					</span>
					<?php /*if (! is_user_logged_in ()) { ?>
							<input type="submit" name="buy_membership" value="<?php if(isset($atts['buttontxt'])) echo $atts['buttontxt'];?>" onclick="return confirm('<?php _e('1) Purchasing membership will require you to Register first. Once you are registered please come back to this page again.\n2) If you are already registered then you will be able to purchase the plan after login.','gym_mgt');?>');">
					<?php }
						else{ */ ?>
					<input type="submit" name="buy_membership" value="<?php if(isset($atts['buttontxt'])) echo $atts['buttontxt'];?>">
						<?php //} ?>
					
					</form>
				</div>	
		    </div>
			<?php 
		}
 }
/*function gmgt_membership_cart_link($atts)
{
	if(isset($_POST['buy_membership'])){
		
		$obj_member=new MJ_Gmgtmember; 
		if (! is_user_logged_in ()) {
		$page_id = get_option ( 'gmgt_login_page' );
		
			wp_redirect ( home_url () . "?page_id=".$page_id);
			
		}
		else
		{
			$page_id = get_option ( 'gmgt_membership_pay_page' );
			
			$referrer_ipn = array(				
				'page_id' => $page_id,
				'membership_id'=>$_POST['membership_id']
				);
			$referrer_ipn = add_query_arg( $referrer_ipn, home_url() );
			wp_redirect ($referrer_ipn);	
			exit;
				
		}
	}
		$obj_activity=new MJ_Gmgtactivity;
		$obj_membership=new MJ_Gmgtmembership;
		
		
		$atts = shortcode_atts( array(
		'buttontxt' => __('Proceed','gym_mgt')
		), $atts, 'MembershipCode' );
		
		 $retrieved_data=$obj_membership->get_single_membership($_REQUEST['membership_id']);
		 if(!empty($retrieved_data))
		 { ?>
		<div class="wpgym-detail-box col-md-12">
			<div class="wpgym-border-box">
			<form name="membership" method="post" action="">
				<table>
				<thead>
				<tr>
					<th><?php _e('Membership Name','gym_mgt');?></th>
					<th><?php _e('Cost','gym_mgt');?></th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td><?php echo $retrieved_data->membership_label;?></td>
					<td><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."".$retrieved_data->installment_amount;?></td>
				</tr>
				</tbody>
				</table>
				<input type="hidden" name="amount" value="<?php echo  $retrieved_data->membership_amount;?>">
				<input type="hidden" name="member_id" value="<?php echo get_current_user_id();?>">
				<input type="hidden" name="membership_id" value="<?php echo $retrieved_data->membership_id;?>">
				
				<?php if (! is_user_logged_in ()) { ?>
						<input type="submit" name="buy_membership" value="<?php if(isset($atts['buttontxt'])) echo $atts['buttontxt'];?>" onclick="return confirm('<?php _e('1) Purchasing membership will require you to Register first. Once you are registered please come back to this page again.\n2) If you are already registered then you will be able to purchase the plan after login.','gym_mgt');?>');">
				<?php }
					else{?>
				<input type="submit" name="buy_membership" value="<?php if(isset($atts['buttontxt'])) echo $atts['buttontxt'];?>">
					<?php } ?>
				
				</form>
			</div>	
		</div>
			<?php 
		 }?>
	
	
<?php } */
function gmgt_pay_membership_amount()
{
	
	/*if(!empty($data))
		{
		$obj_membership_payment=new MJ_Gmgt_membership_payment;
		$obj_membership=new MJ_Gmgtmembership;	
		$obj_member=new MJ_Gmgtmember;
		
		
		$trasaction_id  = $data["txn_id"];
		$custom_array = explode("_",$data['custom']);
		$joiningdate=date("Y-m-d");
		$membership=$obj_membership->get_single_membership($custom_array[1]);
		
		
	 $validity=$membership->membership_length_id;
	 $user_id=$custom_array[0];
	 $expiredate= date('Y-m-d', strtotime($joiningdate. ' + '.$validity.' days'));
		$membership_status = 'continue';
					$payment_data = array();
				$payment_data['member_id'] = $custom_array[0];
				$payment_data['membership_id'] = $custom_array[1];
				$payment_data['membership_amount'] = get_membership_price($custom_array[1]);
				$payment_data['start_date'] = $joiningdate;
				$payment_data['end_date'] = $expiredate;
				$payment_data['membership_status'] = $membership_status;
				$payment_data['payment_status'] = 0;
				$payment_data['created_date'] = date("Y-m-d");
				$payment_data['created_by'] = $user_id;
				$plan_id = $obj_member->add_membership_payment_detail($payment_data);
				$feedata['mp_id']=$plan_id;
				
				
				

		$feedata['amount']=$data['mc_gross_1'];
		$feedata['payment_method']='paypal';	
		$feedata['trasaction_id']=$trasaction_id ;
		$feedata['created_by']=$custom_array[0];
		
	$result=$obj_membership_payment->add_feespayment_history($feedata);
		
		if($result){
			update_user_meta( $user_id, 'membership_id', $custom_array[1]);
				$u = new WP_User($user_id);
				$u->remove_role( 'subscriber' );
				$u->add_role( 'member' );
				$hash = md5( rand(0,1000) );
				update_user_meta( $user_id, 'gmgt_hash', $hash );
			
			
				
			}
		
	
		
		}*/
//MEMBERSHI PPAYMENT PROCES FUNCTION

if(isset($_POST['payer_status']) && $_POST['payer_status'] == 'VERIFIED' && (isset($_POST['payment_status'])) && $_POST['payment_status']=='Completed' && isset($_REQUEST['fullpay'] ) && $_REQUEST['fullpay']=='yes')
{
	if(!empty($_POST)){
		$obj_membership_payment=new MJ_Gmgt_membership_payment;
		$obj_membership=new MJ_Gmgtmembership;	
		$obj_member=new MJ_Gmgtmember;
		
		$trasaction_id  = $_POST["txn_id"];
		$custom_array = explode("_",$_POST['custom']);
		
		$joiningdate=date("Y-m-d");
		$membership=$obj_membership->get_single_membership($custom_array[1]);
		
		
	 $validity=$membership->membership_length_id;
	 $user_id=$custom_array[0];
	 $expiredate= date('Y-m-d', strtotime($joiningdate. ' + '.$validity.' days'));
		$membership_status = 'continue';
		$payment_data = array();
		$membershippayment=$obj_membership_payment->checkMembershipBuyOrNot($custom_array[0],$joiningdate,$expiredate);
		
		if(!empty($membershippayment)){
			global $wpdb;
			$table_gmgt_membership_payment=$wpdb->prefix.'Gmgt_membership_payment';
			$payment_data['payment_status'] = 0;
			$whereid['mp_id']=$membershippayment->mp_id;
			$wpdb->update( $table_gmgt_membership_payment, $payment_data ,$whereid);
			$plan_id =$membershippayment->mp_id;
		}
		else
		{
			$payment_data['member_id'] = $custom_array[0];
			$payment_data['membership_id'] = $custom_array[1];
			$payment_data['membership_amount'] = get_membership_price($custom_array[1]);
			$payment_data['start_date'] = $joiningdate;
			$payment_data['end_date'] = $expiredate;
			$payment_data['membership_status'] = $membership_status;
			$payment_data['payment_status'] = 0;
			$payment_data['created_date'] = date("Y-m-d");
			$payment_data['created_by'] = $user_id;
			$plan_id = $obj_member->add_membership_payment_detail($payment_data);
		}
		$feedata['mp_id']=$plan_id;
		//$feedata['memebership_id']=$_POST['custom'];
		$feedata['amount']=$_POST['mc_gross_1'];
		$feedata['payment_method']='paypal';		
		$feedata['trasaction_id']=$trasaction_id ;
		$feedata['created_by']=$custom_array[0];
	    $result=$obj_membership_payment->add_feespayment_history($feedata);
		$payment_data=$obj_membership_payment->get_single_membership_payment($plan_id);
		if($result){
			$membersdata =get_users( array('role' => 'member'));
			$member_ids_array=array();
			if(!empty($membersdata)){
				foreach ($membersdata as $retrieved_data){
					$member_ids_array[]=$retrieved_data->ID;
				}
			}
			
			if(!in_array($user_id,$member_ids_array)){
				
				$u = new WP_User($user_id);
				$u->remove_role( 'subscriber' );
				$u->add_role( 'member' );
				$hash = md5( rand(0,1000) );
				update_user_meta( $user_id, 'gmgt_hash', $hash );
				
			}
				
				update_user_meta( $user_id, 'membership_id', $custom_array[1] );
				update_user_meta( $user_id,'begin_date',$payment_data->start_date);	
				update_user_meta( $user_id,'end_date',$payment_data->end_date);	
				update_user_meta( $user_id,'membership_status','Continue');	
			}
		}
	}
}
function gmgt_membership_pay_link()
{
	require_once GMS_PLUGIN_DIR. '/template/membership_details.php';
}
//INSTAL MEMBERSHIP PAY PAGE
function gmgt_install_membership_pay_page()
{
	if ( !get_option('gmgt_membership_pay_page') ) {
		

		$curr_page = array(
				'post_title' => __('Membership Payment', 'gym_mgt'),
				'post_content' => '[membership_pay_shortcode]',
				'post_status' => 'publish',
				'post_type' => 'page',
				'comment_status' => 'closed',
				'ping_status' => 'closed',
				'post_category' => array(1),
				'post_parent' => 0 );
		$curr_created = wp_insert_post( $curr_page );
		update_option( 'gmgt_membership_pay_page', $curr_created );
	}
}
/*function gmgt_install_membership_cart_page()
{
	if ( !get_option('gmgt_membership_cart_page') ) {
		

		$curr_page = array(
				'post_title' => __('Membership Cart', 'gym_mgt'),
				'post_content' => '[membership_cart_shortcode]',
				'post_status' => 'publish',
				'post_type' => 'page',
				'comment_status' => 'closed',
				'ping_status' => 'closed',
				'post_category' => array(1),
				'post_parent' => 0 );
		

		$curr_created = wp_insert_post( $curr_page );

		update_option( 'gmgt_membership_cart_page', $curr_created );

	}
}*/
add_action( 'plugins_loaded', 'gmgt_domain_load' );
add_action('wp_enqueue_scripts','gmgt_load_script1');
add_action('init','gmgt_install_login_page');
add_shortcode( 'gmgt_login','gmgt_login_link');
//add_action('init','gmgt_install_membershiplist_page');
add_action('init','gmgt_user_choice_page');
add_shortcode( 'MembershipCode','membershipcode_link' );
add_shortcode( 'membership_pay_shortcode','gmgt_membership_pay_link' );
//add_shortcode( 'membership_cart_shortcode','gmgt_membership_cart_link' );
add_action('init','gmgt_install_membership_pay_page');
//add_action('init','gmgt_install_membership_cart_page');
add_action('wp_head','gmgt_user_dashboard');
add_action( 'init', 'gmgt_pay_membership_amount');
add_shortcode( 'gmgt_memberregistration', 'gmgt_member_choice' );
add_shortcode( 'gmgt_member_registration', 'gmgt_memberregistration_link' );
add_action('init','gmgt_output_ob_start');
function gmgt_member_choice($attr)
{
	 ?>
<style>
.user-choice-area {
  float: left;
  width: 100%;
}
.user-choice-block {
  float: left;
  width: 30%;
}
</style>	 
<script type="text/javascript">
jQuery(document).ready(function() 
{
		jQuery('.student_login_form').show();
		jQuery('.student_registraion_form').hide();
		jQuery('.user_login_choice').change(function() {
			var choice="";
			if(jQuery('.user_login_choice').is(':checked')) { 
				 choice=jQuery(this).val();
				if(choice=='new_user'){
						jQuery('.student_registraion_form').show();
						jQuery('.student_login_form').hide();
					}
					else
					{
						jQuery('.student_login_form').show();
						jQuery('.student_registraion_form').hide();
					}
				}
			});
});
		
</script>	 
	<?php
	if (is_user_logged_in ()) {
		$page_id = get_option ( 'gmgt_membership_pay_page' );
		$referrer_ipn = array(				
			'page_id' => $page_id,
			'membership_id'=>$_REQUEST['membership_id']
		);
		$referrer_ipn = add_query_arg( $referrer_ipn, home_url() );
		wp_redirect ($referrer_ipn);	
			exit;
	}
	else { ?>
		<div class="user-choice-area">
			<div class="user-choice-block">
				<input class="user_login_choice" checked="true" type="radio" value="existing_user"  name="user_choice"><?php _e('Existing User','gym_mgt');?>
			</div>
			<div class="user-choice-block">					
				<input class="user_login_choice" type="radio" value="new_user"  name="user_choice"><?php _e('New User','gym_mgt');?>
			</div>
		</div>
			
		<div class="student_login_form"><?php echo do_shortcode('[gmgt_login]'); ?></div>	
		<div class="student_registraion_form"><?php echo do_shortcode('[gmgt_member_registration]'); ?></div>		
		<?php }
	
}
//MEMBER RAGISTATION LINK FUNCTION
function gmgt_memberregistration_link()
{
	 ob_start();
    gmgt_member_registration_function();
    return ob_get_clean();
	
}

//MEMBER RAGIDSTAION FORM FUNCTION IN FRONTEND SIDE
function gmgt_registration_form( $class_name,$first_name,$middle_name,$last_name,$gender,$birth_date,$address,$city_name,$state_name,$zip_code,$mobile_number,$phone,$email,$username,$password,$gmgt_user_avatar,$member_id,$weight,$Height,$chest,$waist,$thigh,$arms,$fat,$intrest_area,$member_convert,$source,$reference_id,$inqiury_date,$membership_id,$begin_date,$end_date,$first_payment_date,$staff_id) 
{
		
		wp_enqueue_script('gmgt-defaultscript', plugins_url( '/assets/js/jquery-1.11.1.min.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );
		$lancode=get_locale();
		$code=substr($lancode,0,2);
		
	 	wp_enqueue_style( 'wcwm-validate-css', plugins_url( '/lib/validationEngine/css/validationEngine.jquery.css', __FILE__) );
	 	wp_register_script( 'jquery-1.8.2', plugins_url( '/lib/validationEngine/js/jquery-1.8.2.min.js', __FILE__), array( 'jquery' ) );
	 	wp_enqueue_script( 'jquery-1.8.2' );
	 	wp_register_script( 'jquery-validationEngine-'.$code.'', plugins_url( '/lib/validationEngine/js/languages/jquery.validationEngine-'.$code.'.js', __FILE__), array( 'jquery' ) );
	 	wp_enqueue_script( 'jquery-validationEngine-'.$code.'' );
	 	wp_register_script( 'jquery-validationEngine', plugins_url( '/lib/validationEngine/js/jquery.validationEngine.js', __FILE__), array( 'jquery' ) );
	 	wp_enqueue_script( 'jquery-validationEngine' );

		wp_enqueue_script('jquery-ui-datepicker');
		//wp_enqueue_script('gmgt-bootstrap-multiselect-js');
		wp_enqueue_script('gmgt-bootstrap-multiselect-js', plugins_url( '/assets/js/bootstrap-multiselect.js', __FILE__ ) );
		
		wp_enqueue_style( 'accordian-jquery-ui-css', plugins_url( '/assets/accordian/jquery-ui.css', __FILE__) );
		wp_enqueue_style( 'gmgt-bootstrap-multiselect-css', plugins_url( '/assets/css/bootstrap-multiselect.css', __FILE__) );
		wp_register_script('gmgt  -popup-front', plugins_url( 'assets/js/popup.js', __FILE__ ), array( 'jquery' ));
	   wp_enqueue_script('gmgt  -popup-front');
	   
	   wp_enqueue_script('gmgt-bootstrap-timepicker-js', plugins_url( '/assets/js/bootstrap-datepicker.js', __FILE__ ) );
	   wp_enqueue_style( 'gmgt -bootstrap-timepicker-css', plugins_url( '/assets/css/datepicker.min.css', __FILE__) );
	
	   wp_localize_script( 'gmgt  -popup-front', 'gmgt  ', array( 'ajax' => admin_url( 'admin-ajax.php' ) ) );
	   wp_enqueue_script('jquery');
     echo '
    <style>
	.student_registraion_form .form-group,.student_registraion_form .form-group .form-control{float:left;width:100%}
	.student_registraion_form .form-group .require-field{color:red;}
	.student_registraion_form select.form-control,.student_registraion_form input[type="file"] 
	{
     padding: 0.5278em;
     margin-bottom: 5px;
    }
	.student_registraion_form  .radio-inline {
		float: left;
		margin-bottom: 10px;
		margin-top: 10px;
		 margin-right: 15px;
	}
	.student_registraion_form  .radio-inline .tog {
		margin-right: 5px;
	}
	.student_registraion_form .col-sm-2.control-label {
	  line-height: 50px;
	  text-align: right;
	}
	.student_registraion_form .form-group .col-sm-2 {width: 32.666667%;}
	.student_registraion_form .form-group .col-sm-8 {     width: 66.66666667%;}
	.student_registraion_form .form-group .col-sm-7{  width: 53.33333333%;}
	.student_registraion_form .form-group .col-sm-1{  width: 13.33333333%;}
	.student_registraion_form .form-group .col-sm-8, .student_registraion_form .form-group .col-sm-2,.student_registraion_form .form-group .col-sm-7,.student_registraion_form .form-group .col-sm-1{      
	padding-left: 15px;
	 padding-right: 15px;
	float:left;}
	.student_registraion_form .form-group .col-sm-8, .student_registraion_form .form-group .col-sm-2,.student_registraion_form .form-group .col-sm-7{
		position: relative;
    min-height: 1px;   
	}

    div {
        margin-bottom:2px;
    }
     
    input{
        margin-bottom:4px;
    }
	.student_registraion_form .col-sm-offset-2.col-sm-8 {
     float: left;
     margin-left: 35%;
    margin-top: 15px;
    }

	.datepicker-days {
	 width: 220px;
		height: 220px;
		font-size: x-small;
	}

	.table-condensed {
	 width: 220px;
		height: 220px;
		font-size: x-small;
	}
	.datepicker-months {
	 width: 220px;
		height: 220px;
		font-size: x-small;
	}

	.student_reg_error .error{color:red;}
    </style>
    ';?>
   <script type="text/javascript">
    jQuery(document).ready(function()
	{
	  $('#registration_form').validationEngine();
		$.fn.datepicker.defaults.format =" <?php echo get_option('gmgt_datepicker_format');?>";
		  $('#birth_date').datepicker({
		 endDate: '+0d',
			autoclose: true
			 
	   }); 
	   
	   var date = new Date();
            date.setDate(date.getDate()-0);
	        $.fn.datepicker.defaults.format =" <?php echo get_option('gmgt_datepicker_format');?>";
             $('#inqiury_date').datepicker({
	         startDate: date,
             autoclose: true
           });
		var date = new Date();
            date.setDate(date.getDate()-0);
	        $.fn.datepicker.defaults.format =" <?php echo get_option('gmgt_datepicker_format');?>";
             $('#triel_date').datepicker({
	         startDate: date,
             autoclose: true
           });
		   var date = new Date();
            date.setDate(date.getDate()-0);
	        $.fn.datepicker.defaults.format =" <?php echo get_option('gmgt_datepicker_format');?>";
             $('#first_payment_date').datepicker({
	         startDate: date,
             autoclose: true
           });
		   
		   /* var date = new Date();
            date.setDate(date.getDate()-0);
	        $.fn.datepicker.defaults.format =" <?php echo get_option('gmgt_datepicker_format');?>";
             $('#begin_date').datepicker({
	         startDate: date,
             autoclose: true
           }); */
		   
		    $('#begin_date').datepicker({dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>'});
	

    } );
    </script>	
	<script type="text/javascript">
	function fileCheck(obj) {
				var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
				if ($.inArray($(obj).val().split('.').pop().toLowerCase(), fileExtension) == -1)
					alert("Only '.jpeg','.jpg', '.png', '.gif', '.bmp' formats are allowed.");
				
	}
	</script>
	<?php 
	$obj_class=new MJ_Gmgtclassschedule; 
	$obj_member=new MJ_Gmgtmember; 
	$obj_group=new MJ_Gmgtgroup;
	$obj_membership=new MJ_Gmgtmembership;
	 $edit = 0; 
	 $role="member";
	  $lastmember_id=get_lastmember_id($role);
					$nodate=substr($lastmember_id,0,-4);
					$memberno=substr($nodate,1);
					$memberno+=1;
					$newmember='M'.$memberno.date("my");?>		
	<div class="student_registraion_form">
		<form id="registration_form" action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="role" value="<?php //echo $role;?>"  />
			<input type="hidden" name="user_id" value="<?php //echo $member_id;?>"  />
			<div class="header">	
				<h3><?php _e('Personal Information','gym_mgt');?></h3>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="member_id"><?php _e('Member Id','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="member_id" class="form-control validate[required]" type="text" 
					value="<?php if($edit){ echo $user_info->member_id;}else echo $newmember;?>"  readonly name="member_id">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="first_name"><?php _e('First Name','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="first_name" class="form-control validate[required,custom[onlyLetterSp]] text-input" type="text" value="<?php if($edit){ echo $user_info->first_name;}elseif(isset($_POST['first_name'])) echo $_POST['first_name'];?>" name="first_name">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="middle_name"><?php _e('Middle Name','gym_mgt');?></label>
				<div class="col-sm-8">
					<input id="middle_name" class="form-control " type="text"  value="<?php if($edit){ echo $user_info->middle_name;}elseif(isset($_POST['middle_name'])) echo $_POST['middle_name'];?>" name="middle_name">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="last_name"><?php _e('Last Name','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="last_name" class="form-control validate[required,custom[onlyLetterSp]] text-input" type="text"  value="<?php if($edit){ echo $user_info->last_name;}elseif(isset($_POST['last_name'])) echo $_POST['last_name'];?>" name="last_name">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="gender"><?php _e('Gender','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
				<?php $genderval = "male"; if($edit){ $genderval=$user_info->gender; }elseif(isset($_POST['gender'])) {$genderval=$_POST['gender'];}?>
					<label class="radio-inline">
					 <input type="radio" value="male" class="tog validate[required]" name="gender"  <?php  checked( 'male', $genderval);  ?>/><?php _e('Male','gym_mgt');?>
					</label>
					<label class="radio-inline">
					  <input type="radio" value="female" class="tog validate[required]" name="gender"  <?php  checked( 'female', $genderval);  ?>/><?php _e('Female','gym_mgt');?> 
					</label>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="birth_date"><?php _e('Date of birth','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="birth_date" class="form-control validate[required]" type="text"  name="birth_date" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>" 
					value="<?php if($edit){ echo $user_info->birth_date;}elseif(isset($_POST['birth_date'])) echo $_POST['birth_date'];?>">
				</div>
			</div>
			
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="group_id"><?php _e('Group','gym_mgt');?></label>
				<div class="col-sm-8">
					<?php 
					//$joingroup_list = $obj_member->get_all_joingroup($member_id);
					//$groups_array = $obj_member->convert_grouparray($joingroup_list);
					$groups_array=array();
					?>
					<?php if($edit){ $group_id=$user_info->group_id; }elseif(isset($_POST['group_id'])){$group_id=$_POST['group_id'];}else{$group_id='';}?>
					<select id="group_id"  name="group_id[]" multiple="multiple">
					<option><?php _e('Select Group','gym_mgt');?></option>
					<?php $groupdata=$obj_group->get_all_groups();
					 if(!empty($groupdata))
					 {
						foreach ($groupdata as $group){?>
							<option value="<?php echo $group->id;?>" <?php if(in_array($group->id,$groups_array)) echo 'selected';  ?>><?php echo $group->group_name; ?> </option>
				<?php } } ?>
				</select>
				
				</div>
			</div>
			<div class="header">	<hr>
				<h3><?php _e('Contact Information','gym_mgt');?></h3>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="address"><?php _e('Address','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="address" class="form-control validate[required]" type="text"  name="address" 
					value="<?php if($edit){ echo $user_info->address;}elseif(isset($_POST['address'])) echo $_POST['address'];?>">
				</div>
			</div>
			
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="city_name"><?php _e('City','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="city_name" class="form-control validate[required]" type="text"  name="city_name" 
					value="<?php if($edit){ echo $user_info->city_name;}elseif(isset($_POST['city_name'])) echo $_POST['city_name'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="state_name"><?php _e('State','gym_mgt');?></label>
				<div class="col-sm-8">
					<input id="state_name" class="form-control" type="text"  name="state_name" 
					value="<?php if($edit){ echo $user_info->state_name;}elseif(isset($_POST['state_name'])) echo $_POST['state_name'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="zip_code"><?php _e('Zip Code','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="zip_code" class="form-control  validate[required,custom[onlyLetterNumber]]" type="text"  name="zip_code" 
					value="<?php if($edit){ echo $user_info->zip_code;}elseif(isset($_POST['zip_code'])) echo $_POST['zip_code'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label " for="mobile"><?php _e('Mobile Number','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-1">
				
				<input type="text" readonly value="+<?php echo gmgt_get_countery_phonecode(get_option( 'gmgt_contry' ));?>"  class="form-control" name="phonecode">
				</div>
				<div class="col-sm-7">
					<input id="mobile" class="form-control validate[required,custom[phone]] text-input" type="text"  name="mobile" maxlength="10"
					value="<?php if($edit){ echo $user_info->mobile;}elseif(isset($_POST['mobile'])) echo $_POST['mobile'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label " for="phone"><?php _e('Phone','gym_mgt');?></label>
				<div class="col-sm-8">
					<input id="phone" class="form-control validate[,custom[phone]] text-input" type="text"  name="phone" 
					value="<?php if($edit){ echo $user_info->phone;}elseif(isset($_POST['phone'])) echo $_POST['phone'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label " for="email"><?php _e('Email','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="email" class="form-control validate[required,custom[email]] text-input" type="text"  name="email" 
					value="<?php if($edit){ echo $user_info->user_email;}elseif(isset($_POST['email'])) echo $_POST['email'];?>">
				</div>
			</div>
			
			<div class="header">	<hr>
				<h3><?php _e('Physical Information','gym_mgt');?></h3>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="weight"><?php _e('Weight','gym_mgt');?></label>
				<div class="col-sm-8">
					<input id="weight" class="form-control text-input" type="text" 
					palceholder = "Enter in centimeter"
					value="<?php if($edit){ echo $user_info->weight;}elseif(isset($_POST['weight'])) echo $_POST['weight'];?>" 
					name="weight" placeholder="<?php echo get_option( 'gmgt_weight_unit' );?>">
					
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="height"><?php _e('Height','gym_mgt');?></label>
				<div class="col-sm-8">
					<input id="height" class="form-control text-input" type="text" value="<?php if($edit){ echo $user_info->height;}elseif(isset($_POST['height'])) echo $_POST['height'];?>" 
					name="height" placeholder="<?php echo get_option( 'gmgt_height_unit' );?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="Chest"><?php _e('Chest','gym_mgt');?></label>
				<div class="col-sm-8">
					<input id="Chest" class="form-control text-input" type="text" 
					value="<?php if($edit){ echo $user_info->chest;}elseif(isset($_POST['chest'])) echo $_POST['chest'];?>" name="chest" 
					placeholder="<?php echo get_option( 'gmgt_chest_unit' );?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="Waist"><?php _e('Waist','gym_mgt');?></label>
				<div class="col-sm-8">
					<input id="waist" class="form-control text-input" type="text" 
					value="<?php if($edit){ echo $user_info->waist;}elseif(isset($_POST['waist'])) echo $_POST['waist'];?>" name="waist" 
					placeholder="<?php echo get_option( 'gmgt_waist_unit' );?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="thigh"><?php _e('Thigh','gym_mgt');?></label>
				<div class="col-sm-8">
					<input id="thigh" class="form-control text-input" type="text" 
					value="<?php if($edit){ echo $user_info->thigh;}elseif(isset($_POST['thigh'])) echo $_POST['thigh'];?>" name="thigh" 
					placeholder="<?php echo get_option( 'gmgt_thigh_unit' );?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="arms"><?php _e('Arms','gym_mgt');?></label>
				<div class="col-sm-8">
					<input id="arms" class="form-control text-input" type="text" 
					value="<?php if($edit){ echo $user_info->arms;}elseif(isset($_POST['arms'])) echo $_POST['arms'];?>" name="arms" 
					placeholder="<?php echo get_option( 'gmgt_arms_unit' );?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="fat"><?php _e('Fat','gym_mgt');?></label>
				<div class="col-sm-8">
					<input id="fat" class="form-control text-input" type="text" 
					value="<?php if($edit){ echo $user_info->fat;}elseif(isset($_POST['fat'])) echo $_POST['fat'];?>" name="fat" 
					placeholder="<?php echo get_option( 'gmgt_fat_unit' );?>">
				</div>
			</div>
			<div class="header">
				<hr>
				<h3><?php _e('Login Information','gym_mgt');?></h3>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="username"><?php _e('User Name','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="username" class="form-control validate[required]" type="text"  name="username" 
					value="<?php if($edit){ echo $user_info->user_login;}elseif(isset($_POST['username'])) echo $_POST['username'];?>" <?php if($edit) echo "readonly";?>>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="password"><?php _e('Password','gym_mgt');?><?php if(!$edit) {?><span class="require-field">*</span><?php }?></label>
				<div class="col-sm-8">
					<input id="password" class="form-control <?php if(!$edit) echo 'validate[required]';?>" type="password"  name="password" value="">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="photo"><?php _e('Image','gym_mgt');?></label>
				<div class="col-sm-8">
					<input type="file" onchange="fileCheck(this);"  class="form-control" name="gmgt_user_avatar"  >
				</div>	
				<div class="clearfix"></div>
			</div>
			<div class="header">	<hr>
				<h3><?php _e('More Information','gym_mgt');?></h3>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="staff_name"><?php _e('Select Staff Member','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<?php $get_staff = array('role' => 'Staff_member');
						$staffdata=get_users($get_staff);
						
						?>
					<select name="staff_id" class="form-control validate[required] " id="staff_id">
					<option value=""><?php  _e('Select Staff Member','gym_mgt');?></option>
					<?php 
						if(!empty($staffdata))
						{
							foreach($staffdata as $staff)
							{						
								echo '<option value='.$staff->ID.' '.selected($staff_id,$staff->ID).'>'.$staff->display_name.'</option>';
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="intrest"><?php _e('Interest Area','gym_mgt');?></label>
				<div class="col-sm-8">
				
					<select class="form-control" name="intrest_area" id="intrest_area">
					<option value=""><?php _e('Select Interest','gym_mgt');?></option>
					<?php 
					
					if(isset($_REQUEST['intrest']))
						$category =$_REQUEST['intrest'];  
					elseif($edit)
						$category =$user_info->intrest_area;
					else 
						$category = "";
					
					$role_type=gmgt_get_all_category('intrest_area');
					if(!empty($role_type))
					{
						foreach ($role_type as $retrive_data)
						{
							echo '<option value="'.$retrive_data->ID.'" '.selected($category,$retrive_data->ID).'>'.$retrive_data->post_title.'</option>';
						}
					}
					?>
					
					</select>
				</div>
				
			</div>
			<?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){?>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="member_convert"><?php  _e(' Convert into Staff Member','gym_mgt');?></label>
					<div class="col-sm-8">
					<input type="checkbox"  name="member_convert" value="staff_member">
					
					</div>
			</div>
			<?php }?>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="Source"><?php _e('Referral Source','gym_mgt');?></label>
				<div class="col-sm-8">
				
					<select class="form-control" name="source" id="source">
					<option value=""><?php _e('Select Referral Source','gym_mgt');?></option>
					<?php 
					
					if(isset($_REQUEST['source']))
						$category =$_REQUEST['source'];  
					elseif($edit)
						$category =$user_info->source;
					else 
						$category = "";
					
					$role_type=gmgt_get_all_category('source');
					if(!empty($role_type))
					{
						foreach ($role_type as $retrive_data)
						{
							echo '<option value="'.$retrive_data->ID.'" '.selected($category,$retrive_data->ID).'>'.$retrive_data->post_title.'</option>';
						}
					} ?>
					</select>
				</div>
				
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="refered"><?php _e('Referred By','gym_mgt');?></label>
				<div class="col-sm-8">
					<?php $get_staff = array('role' => 'Staff_member');
						$staffdata=get_users($get_staff);
						
						?>
					<select name="reference_id" class="form-control" id="reference_id">
					<option value=""><?php  _e('Select Referred Member','gym_mgt');?></option>
					<?php if($edit)
							$staff_data=$user_info->reference_id;
						elseif(isset($_POST['reference_id']))
							$staff_data=$_POST['reference_id'];
						else
							$staff_data="";
						
						
						if(!empty($staffdata))
						{
							foreach($staffdata as $staff)
							{
								
								echo '<option value='.$staff->ID.' '.selected($staff_data,$staff->ID).'>'.$staff->display_name.'</option>';
							}
						}
						?>
					</select>
				</div>
				
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="inqiury_date"><?php _e('Inquiry Date','gym_mgt');?></label>
				<div class="col-sm-8">
					<input id="inqiury_date" class="form-control" type="text"  name="inqiury_date" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>"
					value="<?php if($edit){ echo $user_info->inqiury_date;}elseif(isset($_POST['inqiury_date'])){ echo $_POST['inqiury_date']; }else{ echo getdate_in_input_box(date('Y-m-d')); }?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="triel_date"><?php _e('Trial End Date','gym_mgt');?></label>
				<div class="col-sm-8">
					<input id="triel_date" class="form-control" type="text"  name="triel_date" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>" 
					 value="<?php if($edit){ echo $user_info->triel_date;}elseif(isset($_POST['triel_date'])){ echo $_POST['triel_date']; }else{ echo getdate_in_input_box(date('Y-m-d')); }?>">
				</div>
			</div>
			
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="membership"><?php _e('Membership','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<?php 	
					$membershipdata=$obj_membership->get_all_membership();?>
					<!--<select name="membership_id" class="form-control validate[required] " id="membership_id">
					<option value=""><?php  _e('Select Membership ','gym_mgt');?></option>
					<?php if(isset($_REQUEST['membership_id']))
							$membership_id=$_REQUEST['membership_id'];
					
						if(!empty($membershipdata))
						 {
							foreach ($membershipdata as $membership){
						
							
							echo '<option value='.$membership->membership_id.' '.selected($membership_id,$membership->membership_id).'>'.$membership->membership_label.'</option>';
						}
						}?>
					</select>-->
					<select name="membership_id" class="form-control validate[required] " id="membership_id">
					<?php 
					if(!empty($membershipdata))
					{
						foreach ($membershipdata as $membership)
						{						
							echo '<option value='.$membership->membership_id.' '.selected($staff_data,$membership->membership_id).'>'.$membership->membership_label.'</option>';
						}
					}
					?>
					</select>
				</div>
			</div>
			<!--<div class="form-group">
				<label class="col-sm-2 control-label" for="class_id"><?php _e('Class','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<?php $class_id= $class_name;?>
					<select id="class_id" class="form-control validate[required]" name="class_id">
					<option><?php _e('Select Class','gym_mgt');?></option>
				<?php $classdata=$obj_class->get_all_classes();
					 if(!empty($classdata))
					 {
						foreach ($classdata as $class){ ?>
							<option value="<?php echo $class->class_id;?>" <?php selected($class_id,$class->class_id);  ?>><?php echo $class->class_name; ?> </option>
				<?php } } ?>
				</select>
				</div>			
			</div>-->
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="class_id"><?php _e('Class','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<!--<?php if($edit){ $class_id=$user_info->class_id; }elseif(isset($_POST['class_id'])){$class_id=$_POST['class_id'];}else{$class_id='';}?>-->
				<select id="classis_id" class="form-control validate[required]" multiple="multiple" name="class_id[]">
					<option><?php _e('Select Class','gym_mgt');?></option>
				<!--<?php $classdata=$obj_class->get_all_classes();
					 if(!empty($classdata))
					 {
						foreach ($classdata as $class){?>
							<option value="<?php echo $class->class_id;?>" <?php selected($class_id,$class->class_id);  ?>><?php echo $class->class_name; ?> </option>
				<?php } } ?>-->
				</select>
				</div>
				
			</div>
			
			
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="begin_date"><?php _e('Membership Valid From','gym_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
				<div class="col-sm-12">
					<input id="begin_date" class="form-control validate[required] begin_date" type="text" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>"  name="begin_date" 
					value="<?php if($edit){  echo $user_info->begin_date; }elseif(isset($_POST['begin_date'])) echo $_POST['begin_date'];?>">
					</div>
					<div class="col-sm-1 text-center">
					<?php _e('To','gym_mgt');?></div>
					<div class="col-sm-12">
					<input id="end_date" class="form-control validate[required]" type="text" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>"   name="end_date" 
					value="<?php if($edit){ echo $user_info->end_date;}elseif(isset($_POST['end_date'])) echo $_POST['end_date'];?>" readonly>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="first_payment_date"><?php _e('First Payment Date','gym_mgt');?></label>
				<div class="col-sm-8">
					<input id="first_payment_date" class="form-control" type="text"  name="first_payment_date" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>" 
					value="<?php if($edit){ echo $user_info->first_payment_date;}elseif(isset($_POST['first_payment_date'])){ echo $_POST['first_payment_date']; }else{ echo getdate_in_input_box(date(get_option('gmgt_datepicker_format'))); }?>">
				</div>
			</div>
			
			<div class="col-sm-offset-2 col-sm-8"> 
				<input type="submit" value="<?php _e('Registration','gym_mgt');?>" name="save_member_front" class="btn btn-success"/>
			</div>
		</form>
	</div>
	<?php
}
//MEMBER RAGISTATION FUNCTION 
function gmgt_member_registration_function() 
{
	global $class_name,$first_name,$middle_name,$last_name,$gender,$birth_date,$address,$city_name,$state_name,$zip_code,$mobile_number,$alternet_mobile_number,$phone,$email,$username,$password,$gmgt_user_avatar,$member_id,$weight,$height,$chest,$waist,$thigh,$arms,$fat,$intrest_area,$member_convert,$source,$reference_id,$inqiury_date,$membership_id,$begin_date,$end_date,$first_payment_date,$group_id,$staff_id;
	$class_name = isset($_POST['class_id'])?$_POST['class_id']:'';
	   
    if ( isset($_POST['save_member_front'] ) )
	{
		
        gmgt_registration_validation(
		$_POST['class_id'],
		$_POST['first_name'],
		$_POST['last_name'],
		$_POST['gender'],
		$_POST['birth_date'],
		$_POST['address'],
		$_POST['city_name'],
		$_POST['state_name'],
		$_POST['zip_code'],
		$_POST['mobile'],
		$_POST['email'],
        $_POST['username'],
        $_POST['password'],        
		$_POST['membership_id'],
        $_POST['begin_date'],
        $_POST['end_date'], 
        $_POST['staff_id']);
         
		 
        // sanitize user form input
        global $class_name,$first_name,$middle_name,$last_name,$gender,$birth_date,$address,$city_name,$state_name,$zip_code,$mobile_number,$alternet_mobile_number,$phone,$email,$username,$password,$gmgt_user_avatar,$member_id,$weight,$height,$chest,$waist,$thigh,$arms,$fat,$intrest_area,$member_convert,$source,$reference_id,$inqiury_date,$membership_id,$begin_date,$end_date,$first_payment_date,$group_id,$staff_id;
        if(isset($_POST['class_id'])){ $class_name =$_POST['class_id']; } else { echo $class_name =""; } 
		//$roll_id =   sanitize_text_field( $_POST['roll_id'] );
		$first_name =    $_POST['first_name'] ;
		$middle_name =   $_POST['middle_name'] ;
		$last_name =  $_POST['last_name'] ;
		$gender =   $_POST['gender'] ;
		$birth_date =   $_POST['birth_date'] ;
		$address =   $_POST['address'] ;
		$city_name =    $_POST['city_name'] ;
		$state_name =   $_POST['state_name'] ;
		$zip_code =   $_POST['zip_code'] ;
		$mobile_number =   $_POST['mobile'] ;
		if(!empty($_POST['group_id']))
			$group_id =   $_POST['group_id'] ;
		else
			$group_id=array();
		
		$phone =   $_POST['phone'] ;		
		$username   =    $_POST['username'] ;
        $password   =    $_POST['password'] ;
        $email      =    $_POST['email'] ;
        $gmgt_user_avatar      = $_FILES['gmgt_user_avatar'] ;
        $member_id      =    $_POST['member_id'] ;
        $weight      =    $_POST['weight'] ;
        $height      =    $_POST['height'] ;
        $chest      =    $_POST['chest'] ;
        $waist      =    $_POST['waist'] ;
        $thigh      =    $_POST['thigh'] ;
        $arms      =    $_POST['arms'] ;
        $fat      =    $_POST['fat'] ;
        $intrest_area      =    $_POST['intrest_area'] ;
		
        
        $source      =    $_POST['source'] ;
        $reference_id      =    $_POST['reference_id'] ;
        $inqiury_date      =    $_POST['inqiury_date'] ;
        $membership_id      =    $_POST['membership_id'] ;
        $begin_date      =    $_POST['begin_date'] ;
        $end_date      =    $_POST['end_date'] ;
        $staff_id      =    $_POST['staff_id'] ;
        $first_payment_date      =    $_POST['first_payment_date'] ;
       
        // call @function complete_registration to create the user
        // only when no WP_error is found
        gmgt_complete_registration(
        $class_name,$first_name,$middle_name,$last_name,$gender,$birth_date,$address,$city_name,$state_name,$zip_code,$mobile_number,$alternet_mobile_number,$phone,$email,$username,$password,$gmgt_user_avatar,$member_id,$weight,$height,$chest,$waist,$thigh,$arms,$fat,$intrest_area,$source,$reference_id,$inqiury_date,$membership_id,$begin_date,$end_date,$first_payment_date,$group_id,$staff_id
        );
	 }
	gmgt_registration_form(
       $class_name,$first_name,$middle_name,$last_name,$gender,$birth_date,$address,$city_name,$state_name,$zip_code,$mobile_number,$alternet_mobile_number,$phone,$email,$username,$password,$gmgt_user_avatar,$member_id,$weight,$height,$chest,$waist,$thigh,$arms,$fat,$intrest_area,$source,$reference_id,$inqiury_date,$membership_id,$begin_date,$end_date,$first_payment_date,$group_id,$staff_id);

}

function gmgt_complete_registration($class_name,$first_name,$middle_name,$last_name,$gender,$birth_date,$address,$city_name,$state_name,$zip_code,$mobile_number,$alternet_mobile_number,$phone,$email,$username,$password,$gmgt_user_avatar,$member_id,$weight,$height,$chest,$waist,$thigh,$arms,$fat,$intrest_area,$source,$reference_id,$inqiury_date,$membership_id,$begin_date,$end_date,$first_payment_date,$group_id,$staff_id)
{
   $obj_member=new MJ_Gmgtmember;    
   global $reg_errors;
   global $wpdb;
	 global $class_name,$first_name,$middle_name,$last_name,$gender,$birth_date,$address,$city_name,$state_name,$zip_code,$mobile_number,$alternet_mobile_number,$phone,$email,$username,$password,$gmgt_user_avatar,$member_id,$weight,$height,$chest,$waist,$thigh,$arms,$fat,$intrest_area,$source,$reference_id,$inqiury_date,$membership_id,$begin_date,$end_date,$first_payment_date,$group_id,$staff_id;
	 $smgt_avatar = '';	
		
    if ( 1 > count( $reg_errors->get_error_messages() ) ) 
	{
        $userdata = array(
        'user_login'    =>   $username,
        'user_email'    =>   $email,
        'user_pass'     =>   $password,
        'user_url'      =>   NULL,
        'first_name'    =>   $first_name,
        'last_name'     =>   $last_name,
        'nickname'      =>   NULL
        );
        
		$user_id = wp_insert_user( $userdata );
	
 		$user = new WP_User($user_id);
	  $user->set_role('member');
	  $smgt_avatar = '';
	  $table_gmgt_groupmember = $wpdb->prefix.'gmgt_groupmember';
	if($_FILES['gmgt_user_avatar']['size'] > 0)
		{
		 $gmgt_avatar_image = gmgt_user_avatar_image_upload('gmgt_user_avatar');
		 $gmgt_avatar = content_url().'/uploads/gym_assets/'.$gmgt_avatar_image;
		}
		else {
			$gmgt_avatar = '';
		}
		$usermetadata=array(					
			'middle_name'=>$middle_name,
			'gender'=>$gender,
			'birth_date'=>$birth_date,
			'address'=>$address,
			'city_name'=>$city_name,
			'state_name'=>$state_name,
			'zip_code'=>$zip_code,
			//'class_id'=>json_encode($class_name),
			'phone'=>$phone,
			'mobile'=>$mobile_number,
			'gmgt_user_avatar'=>$gmgt_avatar,
			'member_id'=>$member_id,
			'member_type'=>'Member',
			'height'=>$height,
			'weight'=>$weight,
			'chest'=>$chest,
			'waist'=>$waist,
			'thigh'=>$thigh,
			'arms'=>$arms,
			'fat'=>$fat,
			'staff_id'=>$staff_id,
			'intrest_area'=>$intrest_area,
			'source'=>$source,
			'reference_id'=>$reference_id,
			'inqiury_date'=>$inqiury_date,
			'membership_id'=>$membership_id,
			'begin_date'=>$begin_date,
			'end_date'=>$end_date,
			'first_payment_date'=>$first_payment_date);
		
		
		
		foreach($usermetadata as $key=>$val)
		{		
			update_user_meta( $user_id, $key,$val );	
		}
		
		
		global $wpdb;
		$table_gmgt_member_class = $wpdb->prefix. 'gmgt_member_class';
		$memclss['member_id']=$user_id;
		foreach($class_name as $key=>$class)
		{
			$memclss['class_id']=$class;
			$result = $wpdb->insert($table_gmgt_member_class,$memclss);			
		} 
		
		if(!empty($group_id))
		{
			if($obj_member->member_exist_ingrouptable($user_id))
				$obj_member->delete_member_from_grouptable($user_id);
			foreach($group_id as $id)
			{
				$group_data['group_id']=$id;
				$group_data['member_id']=$user_id;
				$group_data['created_date']=date("Y-m-d");
				$group_data['created_by']=$user_id;
				$wpdb->insert( $table_gmgt_groupmember, $group_data );
			}
		}
		$membership_status = 'continue';
				$payment_data = array();
				$payment_data['member_id'] = $user_id;
				$payment_data['membership_id'] = $membership_id;
				$payment_data['membership_amount'] = get_membership_price($membership_id);
				$payment_data['start_date'] = $begin_date;
				$payment_data['end_date'] = $end_date;
				$payment_data['membership_status'] = $membership_status;
				$payment_data['payment_status'] = 0;
				$payment_data['created_date'] = date("Y-m-d");
				$payment_data['created_by'] = $user_id;
				
				  $plan_id = $obj_member->add_membership_payment_detail($payment_data);
		          $hash = md5( rand(0,1000) );
                  update_user_meta( $user_id, 'gmgt_hash', $hash );
                  $user_info = get_userdata($user_id);

					$gymname=get_option( 'gmgt_system_name' );
					$to = $user_info->user_email;         
					$subject = get_option('registration_title'); 
					$sub_arr['[GMGT_GYM_NAME]']=$gymname;
			        $subject = gmgt_subject_string_replacemnet($sub_arr,$subject);
					$search=array('[GMGT_MEMBERNAME]','[GMGT_MEMBERID]','[GMGT_STARTDATE]','[GMGT_ENDDATE]','[GMGT_MEMBERSHIP]','[GMGT_GYM_NAME]');
					$membership_name=get_membership_name($membership_id);
					$replace = array($user_info->display_name,$user_info->member_id,$begin_date,$end_date,$membership_name,get_option( 'gmgt_system_name' ));
					$message_replacement = str_replace($search, $replace,get_option('registration_mailtemplate'));
            
                    gmgt_send_mail($to,$subject,$message_replacement);			
					
					//wp_mail($to, $subject, $message); 
				
		//wp_mail($to, $subject, $message); 
        echo 'Registration complete.Your account active after admin can approve.'; 
		if($user_id)
		{
				$page_id = get_option ( 'gmgt_membership_pay_page' );
				$referrer_ipn = array(				
					'page_id' => $page_id,
					'user_id' => $user_id,
					'membership_id'=>$membership_id);
				$referrer_ipn = add_query_arg( $referrer_ipn, home_url() );
				wp_redirect ($referrer_ipn);	
			exit;	
		}			
	}
	
}

//MEMBER RAGISTATION FORM VALIDATION FUNCTION//
function gmgt_registration_validation($class_name,$first_name,$last_name,$gender,$birth_date,$address,$city_name,$state_name,$zip_code,$mobile_number,$email,$username,$password,$membership_id,$begin_date,$end_date,$staff_id)  
{
	global $reg_errors;
	$reg_errors = new WP_Error;
	if ( empty( $class_name )  || empty( $first_name ) || empty( $last_name ) || empty( $birth_date ) || empty( $address ) || empty( $city_name ) || empty( $zip_code ) ||  empty( $email ) || empty( $username ) || empty( $password ) || empty( $membership_id ) || empty( $begin_date )|| empty( $end_date ) || empty( $staff_id )) 
	{
    $reg_errors->add('field', 'Required form field is missing');
	}
	if ( 4 > strlen( $username ) ) {
    $reg_errors->add( 'username_length', 'Username too short. At least 4 characters is required' );
	}
	if ( username_exists( $username ) )
		$reg_errors->add('user_name', 'Sorry, that username already exists!');
	if ( ! validate_username( $username ) ) {
    $reg_errors->add( 'username_invalid', 'Sorry, the username you entered is not valid' );
	}
	
	if ( !is_email( $email ) ) {
    $reg_errors->add( 'email_invalid', 'Email is not valid' );
	}
	if ( email_exists( $email ) ) {
    $reg_errors->add( 'email', 'Email Already in use' );
	}
	
	if ( is_wp_error( $reg_errors ) ) {
 
    foreach ( $reg_errors->get_error_messages() as $error ) {
     
        echo '<div class="student_reg_error">';
        echo '<strong>ERROR</strong> : ';
        echo '<span class="error"> '.$error . ' </span><br/>';
        echo '</div>';
         
    }
 
}	

}
/*add_filter( 'wp_authenticate_user', 'gmgt_login_activation_hash_check', 10, 2 );
function gmgt_login_activation_hash_check( $user, $password ) {
     global $wpdb;
	 $table_users=$wpdb->prefix.'users';
	 $user_id =  $user->ID; // prints the id of the user 
	  
	if( get_user_meta($user_id, 'gmgt_hash', true) )
	{			
		$WP_Error = new WP_Error();
		// var_dump($WP_Error);
		$WP_Error ->add( 'broke', __( "Please Activate your account by activation link,Check your e-mail.", "gym_mgt" ) );	
		return $WP_Error;		
	}
	else
	{
		return $user;
	}
	  
	
	}
add_action('init','gmgt_activat_mail_link');
function gmgt_activat_mail_link()
{
	if(isset($_REQUEST['haskey']) && isset($_REQUEST['id']))
	{		
	
		
		$user = get_user_by("login",$_REQUEST['id']);
		
		$user_id =  $user->ID; // prints the id of the user
		if( get_user_meta($user_id, 'gmgt_hash', true))
		{
			
			if(get_user_meta($user_id, 'gmgt_hash', true) == $_REQUEST['haskey'])
			{				
				delete_user_meta($user_id, 'gmgt_hash');
				$curr_args = array(
			'page_id' => get_option('gmgt_login_page'),
			'gmgt_activate' => 1
	);
	//print_r($curr_args);
	$referrer_faild = add_query_arg( $curr_args, get_permalink( get_option('gmgt_login_page') ) );
				wp_redirect($referrer_faild);
				exit;
			}
			else
			{
				$curr_args = array(
			'page_id' => get_option('gmgt_login_page'),
			'gmgt_activate' => 2
	);
	//print_r($curr_args);
	$referrer_faild = add_query_arg( $curr_args, get_permalink( get_option('gmgt_login_page') ) );
				wp_redirect($referrer_faild);
				exit;
			}
			
			
		}
		wp_redirect(home_url('/'));
				exit;
		
			
		
	}
}*/

function gmgt_output_ob_start()
{
	ob_start();
}

///INSTALL TABLE PLUGIN ACTIVATE DEAVTIVATE TIME
function gmgt_install_tables()
{
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	global $wpdb;
	
	$table_gmgt_activity = $wpdb->prefix . 'gmgt_activity';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_activity ." (
				  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
				  `activity_cat_id` int(11) NOT NULL,
				  `activity_title` varchar(200) NOT NULL,
				  `activity_assigned_to` int(11) NOT NULL,
				  `activity_added_by` int(11) NOT NULL,
				  `activity_added_date` date NOT NULL,
				  PRIMARY KEY (`activity_id`)
				) DEFAULT CHARSET=utf8";
	
		$wpdb->query($sql);
		
		$table_gmgt_assign_workout = $wpdb->prefix . 'gmgt_assign_workout';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_assign_workout." (
				  `workout_id` bigint(20) NOT NULL AUTO_INCREMENT,
				  `user_id` bigint(20) NOT NULL,
				  `start_date` date NOT NULL,
				  `end_date` date NOT NULL,
				  `level_id` int(11) NOT NULL,
				  `description` text NOT NULL,
				  `created_date` datetime NOT NULL,
				  `created_by` bigint(20) NOT NULL,
				  PRIMARY KEY (`workout_id`)
				) DEFAULT CHARSET=utf8";
	
		$wpdb->query($sql);
		
		$table_gmgt_attendence = $wpdb->prefix . 'gmgt_attendence';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_attendence." (
				 `attendence_id` int(11) NOT NULL AUTO_INCREMENT,
				  `user_id` int(11) NOT NULL,
				  `class_id` int(11) NOT NULL,
				  `attendence_date` date NOT NULL,
				  `status` varchar(50) NOT NULL,
				  `attendence_by` int(11) NOT NULL,
				  `role_name` varchar(50) NOT NULL,
				  PRIMARY KEY (`attendence_id`)
				) DEFAULT CHARSET=utf8";
	
		$wpdb->query($sql);
		
		
		$table_gmgt_class_schedule = $wpdb->prefix . 'gmgt_class_schedule';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_class_schedule." (
				 `class_id` int(11) NOT NULL AUTO_INCREMENT,
				  `class_name` varchar(100) NOT NULL,
				  `day` text NOT NULL,
				  `staff_id` int(11) NOT NULL,
				  `asst_staff_id` int(11) NOT NULL,
				  `start_time` varchar(20) NOT NULL,
				  `end_time` varchar(20) NOT NULL,
				  `class_created_id` int(11) NOT NULL,
				  `class_creat_date` date NOT NULL,
				  PRIMARY KEY (`class_id`)
				) DEFAULT CHARSET=utf8";
	
		$wpdb->query($sql);
		
		
		$table_gmgt_daily_workouts = $wpdb->prefix . 'gmgt_daily_workouts';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_daily_workouts." (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `workout_id` int(11) NOT NULL,
				  `member_id` int(11) NOT NULL,
				  `record_date` date NOT NULL,
				  `result_measurment` varchar(50) NOT NULL,
				  `result` varchar(100) NOT NULL,
				  `duration` varchar(100) NOT NULL,
				  `assigned_by` int(11) NOT NULL,
				  `due_date` date NOT NULL,
				  `time_of_workout` varchar(50) NOT NULL,
				  `status` varchar(100) NOT NULL,
				  `note` text NOT NULL,
				  `created_by` int(11) NOT NULL,
				  `created_date` date NOT NULL,
				  PRIMARY KEY (`id`)
				)  DEFAULT CHARSET=utf8";
	
		$wpdb->query($sql);
		
		
		$table_gmgt_groups = $wpdb->prefix . 'gmgt_groups';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_groups." (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `group_name` varchar(100) NOT NULL,
				  `gmgt_groupimage` varchar(255) NOT NULL,
				  `created_by` int(11) NOT NULL,
				  `created_date` date NOT NULL,
				  PRIMARY KEY (`id`)
				) DEFAULT CHARSET=utf8";
	
		$wpdb->query($sql);
		
		$table_gmgt_groupmember = $wpdb->prefix . 'gmgt_groupmember';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_groupmember." (
				  `id` bigint(20) NOT NULL AUTO_INCREMENT,
				  `group_id` int(11) NOT NULL,
				  `member_id` int(11) NOT NULL,
				  `created_by` int(11) NOT NULL,
				  `created_date` datetime NOT NULL,
				  PRIMARY KEY (`id`)
				) DEFAULT CHARSET=utf8";
	
		$wpdb->query($sql);
		
		$table_gmgt_income_expense = $wpdb->prefix . 'gmgt_income_expense';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_income_expense." (
				  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
				  `invoice_type` varchar(100) NOT NULL,
				  `invoice_label` varchar(100) NOT NULL,
				  `supplier_name` varchar(100) NOT NULL,
				  `entry` text NOT NULL,
				  `payment_status` varchar(50) NOT NULL,
				  `receiver_id` int(11) NOT NULL,
				  `invoice_date` date NOT NULL,
				  `invoice_no` varchar(100) NOT NULL,
				  `discount` double NOT NULL,
				  `total_amount` double NOT NULL,
				  `paid_amount` double NOT NULL,
				  `tax` double NOT NULL,
				  `due_amount` double NOT NULL,
				  `create_by` int(11) NOT NULL,
				  PRIMARY KEY (`invoice_id`)
				)  DEFAULT CHARSET=utf8";
	
		$wpdb->query($sql);
		
		
		$table_gmgt_membershiptype= $wpdb->prefix . 'gmgt_membershiptype';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_membershiptype." (
				  `membership_id` int(11) NOT NULL AUTO_INCREMENT,
				  `membership_label` varchar(100) NOT NULL,
				  `membership_cat_id` int(11) NOT NULL,
				  `membership_length_id` int(11) NOT NULL,
				  `membership_class_limit` varchar(20) NOT NULL,
				  `install_plan_id` int(11) NOT NULL,
				  `membership_amount` double NOT NULL,
				  `installment_amount` double NOT NULL,
				  `signup_fee` double NOT NULL,
				  `gmgt_membershipimage` varchar(255) NOT NULL,
				  `created_date` date NOT NULL,
				  `created_by_id` int(11) NOT NULL,
				  PRIMARY KEY (`membership_id`)
				)  DEFAULT CHARSET=utf8";
		$wpdb->query($sql);
		
		$table_gmgt_nutrition = $wpdb->prefix . 'gmgt_nutrition';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_nutrition." (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `user_id` int(11) NOT NULL,
				  `day` varchar(50) NOT NULL,
				  `breakfast` text NOT NULL,
				  `midmorning_snack` text NOT NULL,
				  `lunch` text NOT NULL,
				  `afternoon_snack` text NOT NULL,
				  `dinner` text NOT NULL,
				  `afterdinner_snack` text NOT NULL,
				  `start_date` varchar(20) NOT NULL,
				  `expire_date` varchar(20) NOT NULL,
				  `created_by` int(11) NOT NULL,
				  `created_date` date NOT NULL,
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";
	
		$wpdb->query($sql);
		
		$table_gmgt_payment = $wpdb->prefix . 'gmgt_payment';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_payment." (
				 `payment_id` int(11) NOT NULL AUTO_INCREMENT,
				  `title` varchar(100) NOT NULL,
				  `member_id` int(11) NOT NULL,
				  `due_date` date NOT NULL,
				  `unit_price` double NOT NULL,
				  `discount` double NOT NULL,
				  `total_amount` double NOT NULL,
				  `amount` double NOT NULL,
				  `payment_status` varchar(50) NOT NULL,
				  `payment_date` date NOT NULL,
				  `receiver_id` int(11) NOT NULL,
				  `description` text NOT NULL,
				  PRIMARY KEY (`payment_id`)
				)DEFAULT CHARSET=utf8";
					
		$wpdb->query($sql);
		
		
		$table_gmgt_product = $wpdb->prefix . 'gmgt_product';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_product." (
				 `id` int(11) NOT NULL AUTO_INCREMENT,
				  `product_name` varchar(100) NOT NULL,
				  `price` double NOT NULL,
				  `quentity` int(11) NOT NULL,
				  `created_by` int(11) NOT NULL,
				  `created_date` date NOT NULL,
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";
	
		$wpdb->query($sql);
		
		
		$table_gmgt_reservation = $wpdb->prefix . 'gmgt_reservation';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_reservation." (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `event_name` varchar(100) NOT NULL,
				  `event_date` date NOT NULL,
				  `start_time` varchar(20) NOT NULL,
				  `end_time` varchar(20) NOT NULL,
				  `place_id` int(11) NOT NULL,
				  `created_by` int(11) NOT NULL,
				  `created_date` date NOT NULL,
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";
	
		$wpdb->query($sql);		
	 
		$table_gmgt_store = $wpdb->prefix . 'gmgt_store';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_store."(
				  `id` int(11) NOT NULL AUTO_INCREMENT,				 
				  `invoice_no` varchar(50) NOT NULL,	
					`member_id` int(11) NOT NULL,				  
				  `entry` text NOT NULL,		  				  
				  `tax` double NOT NULL,
				  `discount` double NOT NULL,
				  `amount` double NOT NULL,
				  `total_amount` double NOT NULL,
				  `paid_amount` double NOT NULL,
				  `payment_status` varchar(50) NOT NULL,
				  `sell_by` int(11) NOT NULL,
				  `sell_date` date NOT NULL,
				  `created_date` date NOT NULL,
				  PRIMARY KEY (`id`)
				) DEFAULT CHARSET=utf8";
					
		$wpdb->query($sql);
		
		
		
		$table_gmgt_message= $wpdb->prefix . 'Gmgt_message';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_message." (
			  `message_id` int(11) NOT NULL AUTO_INCREMENT,
			  `sender` int(11) NOT NULL,
			  `receiver` int(11) NOT NULL,
			  `date` datetime NOT NULL,
			  `subject` varchar(150) NOT NULL,
			  `message_body` text NOT NULL,
			  `status` int(11) NOT NULL,
			  PRIMARY KEY (`message_id`)
			)DEFAULT CHARSET=utf8";
	
		$wpdb->query($sql);
		
		$table_gmgt_workout_data= $wpdb->prefix . 'gmgt_workout_data';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_workout_data." (
			  `id` bigint(20) NOT NULL AUTO_INCREMENT,
			  `day_name` varchar(15) NOT NULL,
			  `workout_name` varchar(100) NOT NULL,
			  `sets` int(11) NOT NULL,
			  `reps` int(11) NOT NULL,
			  `kg` float NOT NULL,
			  `time` int(11) NOT NULL,
			  `workout_id` bigint(20) NOT NULL,
			  `created_date` datetime NOT NULL,
			  `create_by` bigint(20) NOT NULL,
			  PRIMARY KEY (`id`)
			)DEFAULT CHARSET=utf8";
	
		$wpdb->query($sql);
		
		$table_gmgt_measurment= $wpdb->prefix . 'gmgt_measurment';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_measurment." (
			  `measurment_id` int(11) NOT NULL AUTO_INCREMENT,
			  `result_measurment` varchar(100) NOT NULL,
			  `result` int(11) NOT NULL,
			  `user_id` int(11) NOT NULL,
			  `result_date` date NOT NULL,
			  `created_by` int(11) NOT NULL,
			  `created_date` date NOT NULL,
			  PRIMARY KEY (`measurment_id`)
			)DEFAULT CHARSET=utf8";
				
		$wpdb->query($sql);
		
		$table_gmgt_user_workouts= $wpdb->prefix . 'gmgt_user_workouts';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_user_workouts." (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `user_workout_id` int(11) NOT NULL,
			  `workout_name` varchar(200) NOT NULL,
			  `sets` int(11) NOT NULL,
			  `reps` int(11) NOT NULL,
			  `kg` float NOT NULL,
			  `rest_time` int(11) NOT NULL,
			  PRIMARY KEY (`id`)
			)DEFAULT CHARSET=utf8";
				
		$wpdb->query($sql);
		
		$table_gmgt_nutrition_data= $wpdb->prefix . 'gmgt_nutrition_data';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_nutrition_data." (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `day_name` varchar(30) NOT NULL,
				  `nutrition_time` varchar(30) NOT NULL,
				  `nutrition_value` text NOT NULL,
				  `nutrition_id` int(11) NOT NULL,
				  `created_date` date NOT NULL,
				  `create_by` int(11) NOT NULL,
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";
				
		$wpdb->query($sql);
		
		$table_gmgt_membership_payment= $wpdb->prefix . 'Gmgt_membership_payment';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_membership_payment." (
				  `mp_id` int(11) NOT NULL AUTO_INCREMENT,
				  `member_id` int(11) NOT NULL,
				  `membership_id` int(11) NOT NULL,
				  `invoice_no` 	varchar(10) NOT NULL,
				  `membership_amount` double NOT NULL,
				  `paid_amount` double NOT NULL,
				  `start_date` date NOT NULL,
				  `end_date` date NOT NULL,
				  `membership_status` varchar(50) NOT NULL,
				  `payment_status` varchar(20) NOT NULL,
				  `created_date` date NOT NULL,
				  `created_by` int(11) NOT NULL,
				  PRIMARY KEY (`mp_id`)
				)DEFAULT CHARSET=utf8";
				
		$wpdb->query($sql);
		
		$table_gmgt_membership_payment_history = $wpdb->prefix . 'gmgt_membership_payment_history';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_membership_payment_history." (
				  `payment_history_id` bigint(20) NOT NULL AUTO_INCREMENT,
				  `mp_id` int(11) NOT NULL,
				  `amount` int(11) NOT NULL,
				  `payment_method` varchar(50) NOT NULL,
				  `paid_by_date` date NOT NULL,
				  `created_by` int(11) NOT NULL,
				  `trasaction_id` varchar(255) NOT NULL,
				  PRIMARY KEY (`payment_history_id`)
				)DEFAULT CHARSET=utf8";
				
		$wpdb->query($sql);
		
		$table_gmgt_alert_mail_log = $wpdb->prefix . 'gmgt_alert_mail_log';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_alert_mail_log." (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `member_id` int(11) NOT NULL,
				  `membership_id` int(11) NOT NULL,
				  `start_date` varchar(20) NOT NULL,
				  `end_date` varchar(20) NOT NULL,
				  `alert_date` int(11) NOT NULL,
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";
				
		$wpdb->query($sql);
		
		$table_gmgt_message_replies = $wpdb->prefix . 'gmgt_message_replies';
		$sql = "CREATE TABLE ".$table_gmgt_message_replies." (
			  `id` int(20) NOT NULL AUTO_INCREMENT,
			  `message_id` int(20) NOT NULL,
			  `sender_id` int(20) NOT NULL,
			  `receiver_id` int(20) NOT NULL,
			  `message_comment` text NOT NULL,
			  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";
	
		$wpdb->query($sql);	
		
		
		$table_gmgt_membership_activities = $wpdb->prefix . 'gmgt_membership_activities';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_membership_activities." (
		  `id` bigint(11) NOT NULL AUTO_INCREMENT,
		  `activity_id` int(11) NOT NULL,
		  `membership_id` int(11) NOT NULL,
		  `created_by` int(11) NOT NULL,
		  `created_date` date NOT NULL,
		  PRIMARY KEY (`id`)
		)DEFAULT CHARSET=utf8";		
		$wpdb->query($sql);
		
		
		$table_gmgt_member_class = $wpdb->prefix . 'gmgt_member_class';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_member_class." (
		  `id` int(20) NOT NULL AUTO_INCREMENT,
		  `member_id` int(20) NOT NULL,
		  `class_id` int(20) NOT NULL,
		   PRIMARY KEY (`id`)
		)DEFAULT CHARSET=utf8";		
		$wpdb->query($sql);
		
		$teacher_class = $wpdb->get_results("SELECT *from $table_gmgt_member_class");	
		if(empty($teacher_class))
		{
			$memberlist = get_users(array('role'=>'member'));
		
			if(!empty($memberlist))
			{
				foreach($memberlist as $retrieve_data)
				{				
					$created_by = get_current_user_id();
					$created_date = date('Y-m-d H:i:s');
					$class_id = get_user_meta($retrieve_data->ID,'class_id',true);				
					$success = $wpdb->insert($table_gmgt_member_class,array('member_id'=>$retrieve_data->ID,
						'class_id'=>$class_id,
						));
				}
			}		
		}
	
	$table_gmgt_booking_class = $wpdb->prefix . 'gmgt_booking_class';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_booking_class." (
		  `id` int(20) NOT NULL AUTO_INCREMENT,
		  `member_id` int(20) NOT NULL,
		  `class_id` int(20) NOT NULL,
		  `booking_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `membership_id` int(10) NOT NULL,
		  `booking_day` varchar(255) NOT NULL,
		  PRIMARY KEY (`id`)
		)DEFAULT CHARSET=utf8";		
		$wpdb->query($sql);
		
		$table_gmgt_membership_class = $wpdb->prefix . 'gmgt_membership_class';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_membership_class." (
		 `id` int(20) NOT NULL AUTO_INCREMENT,
		  `class_id` int(20) NOT NULL,
		  `membership_id` int(20) NOT NULL,
		  `booking_day` varchar(255) NOT NULL,
		  PRIMARY KEY (`id`)
		)DEFAULT CHARSET=utf8";		
		$wpdb->query($sql);
		
		
		$table_gmgt_sales_payment_history = $wpdb->prefix . 'gmgt_sales_payment_history';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_sales_payment_history." (
				  `payment_history_id` bigint(20) NOT NULL AUTO_INCREMENT,
				  `sell_id` int(11) NOT NULL,
				  `member_id` int(11) NOT NULL,
				  `amount` int(11) NOT NULL,
				  `payment_method` varchar(50) NOT NULL,
				  `paid_by_date` date NOT NULL,
				  `created_by` int(11) NOT NULL,
				  `trasaction_id` varchar(255) NOT NULL,
				  PRIMARY KEY (`payment_history_id`)
				)DEFAULT CHARSET=utf8";
				
		$wpdb->query($sql);
		
		$table_gmgt_income_payment_history = $wpdb->prefix . 'gmgt_income_payment_history';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_gmgt_income_payment_history." (
				  `payment_history_id` bigint(20) NOT NULL AUTO_INCREMENT,
				  `invoice_id` int(11) NOT NULL,
				  `member_id` int(11) NOT NULL,
				  `amount` int(11) NOT NULL,
				  `payment_method` varchar(50) NOT NULL,
				  `paid_by_date` date NOT NULL,
				  `created_by` int(11) NOT NULL,
				  `trasaction_id` varchar(255) NOT NULL,
				  PRIMARY KEY (`payment_history_id`)
				)DEFAULT CHARSET=utf8";
				
		$wpdb->query($sql);
		
		$table_gmgt_measurment= $wpdb->prefix . 'gmgt_measurment';
	$results='result';
	$result= $wpdb->query("ALTER TABLE $table_gmgt_measurment MODIFY COLUMN $results FLOAT");
	
	$table_gmgt_membership_payment_history = $wpdb->prefix . 'gmgt_membership_payment_history';
	$trasaction_id='trasaction_id';
	$result= $wpdb->query("ALTER TABLE $table_gmgt_membership_payment_history MODIFY COLUMN $trasaction_id varchar(255)");
	
	$table_gmgt_membershiptype= $wpdb->prefix . 'gmgt_membershiptype';
	$comment_field='membership_description';
	
	if (!in_array($comment_field, $wpdb->get_col( "DESC " . $table_gmgt_membershiptype, 0 ) )){  
		$result= $wpdb->query("ALTER     TABLE $table_gmgt_membershiptype  ADD   $comment_field  text");
	}
	
	$table_gmgt_measurment= $wpdb->prefix . 'gmgt_measurment';
	$progress_image='gmgt_progress_image';
	if (!in_array($progress_image, $wpdb->get_col( "DESC " . $table_gmgt_measurment, 0 ) ))
	{  
		$result= $wpdb->query("ALTER     TABLE $table_gmgt_measurment  ADD   $progress_image  text");
	}
	$tbl_message = $wpdb->prefix . 'Gmgt_message';
	$post_id='post_id';
	if (!in_array($post_id, $wpdb->get_col( "DESC " . $tbl_message, 0 ) )){  
		$result= $wpdb->query("ALTER     TABLE $tbl_message  ADD   $post_id  int(30)");
	}
	
	$tbl_gmgt_membershiptype = $wpdb->prefix . 'gmgt_membershiptype';
	$on_of_member='on_of_member';
	$classis_limit='classis_limit';
	$on_of_classis='on_of_classis';
	if (!in_array($on_of_member, $wpdb->get_col( "DESC " . $tbl_gmgt_membershiptype, 0 ) )){  
		$result= $wpdb->query("ALTER     TABLE $tbl_gmgt_membershiptype  ADD   $on_of_member  int(20)");
	}
	if (!in_array($classis_limit, $wpdb->get_col( "DESC " . $tbl_gmgt_membershiptype, 0 ) )){  
		$result= $wpdb->query("ALTER     TABLE $tbl_gmgt_membershiptype  ADD   $classis_limit  varchar(200)");
	}
	
	if (!in_array($on_of_classis, $wpdb->get_col( "DESC " . $tbl_gmgt_membershiptype, 0 ) )){  
		$result= $wpdb->query("ALTER     TABLE $tbl_gmgt_membershiptype  ADD   $on_of_classis  int(20)");
	}
	
	$gmgt_reservation = $wpdb->prefix . 'gmgt_reservation';
	$staff_id='staff_id';
	if (!in_array($staff_id, $wpdb->get_col( "DESC " . $gmgt_reservation, 0 ) )){  
		$result= $wpdb->query("ALTER     TABLE $gmgt_reservation  ADD   $staff_id  int(11)");
	}
	
	$table_gmgt_membership_payment = $wpdb->prefix . 'Gmgt_membership_payment';
	$invoice_no='invoice_no';
	if (!in_array($invoice_no, $wpdb->get_col( "DESC " . $table_gmgt_membership_payment, 0 ) )){  
		$result= $wpdb->query("ALTER     TABLE $table_gmgt_membership_payment  ADD   $invoice_no  varchar(10) NOT NULL");
	}

	  $table_gmgt_store = $wpdb->prefix . 'gmgt_store';
	  $member_id='member_id';
	  $entry='entry';
	  $tax_entry='tax';
	  $discount='discount';
	  $amount='amount';
	  $total_amount='total_amount';
	  $paid_amount='paid_amount';
	  $payment_status='payment_status';
	  $invoice_no='invoice_no';
	  $created_date='created_date';
	  $sell_date='sell_date';
	 
		if (!in_array($member_id, $wpdb->get_col( "DESC " . $table_gmgt_store, 0 ) ))
		{  
		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_store  ADD   $member_id  int(11) NOT NULL");
		}
		
		if (!in_array($entry, $wpdb->get_col( "DESC " . $table_gmgt_store, 0 ) ))
		{  
		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_store  ADD   $entry  text NOT NULL");
		}
		
		if (!in_array($tax_entry, $wpdb->get_col( "DESC " . $table_gmgt_store, 0 ) ))
		{  
		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_store  ADD   $tax_entry  double NOT NULL");
		}
		
		if (!in_array($discount, $wpdb->get_col( "DESC " . $table_gmgt_store, 0 ) ))
		{  
		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_store  ADD   $discount  double NOT NULL");
		}
		
		if (!in_array($amount, $wpdb->get_col( "DESC " . $table_gmgt_store, 0 ) ))
		{  
		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_store  ADD   $amount  double NOT NULL");
		}
		
		if (!in_array($total_amount, $wpdb->get_col( "DESC " . $table_gmgt_store, 0 ) ))
		{  
		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_store  ADD   $total_amount  double NOT NULL");
		}
		
		if (!in_array($paid_amount, $wpdb->get_col( "DESC " . $table_gmgt_store, 0 ) ))
		{  
		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_store  ADD   $paid_amount  double NOT NULL");
		}
		
		if (!in_array($payment_status, $wpdb->get_col( "DESC " . $table_gmgt_store, 0 ) ))
		{  
		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_store  ADD   $payment_status  varchar(20) NOT NULL");
		}
		
		if (!in_array($invoice_no, $wpdb->get_col( "DESC " . $table_gmgt_store, 0 ) ))
		{  
		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_store  ADD   $invoice_no  varchar(50) NOT NULL");
		}
		
		if (!in_array($created_date, $wpdb->get_col( "DESC " . $table_gmgt_store, 0 ) ))
		{  
		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_store  ADD   $created_date  date NOT NULL");
		}
		
		if (!in_array($sell_date, $wpdb->get_col( "DESC " . $table_gmgt_store, 0 ) ))
		{  
		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_store  ADD   $sell_date  date NOT NULL");
		}
		
	  $table_gmgt_income_expense = $wpdb->prefix . 'gmgt_income_expense';
	  $invoice_no='invoice_no';
	  $discount='discount';
	  $total_amount='total_amount';
	  $amount='amount';
	  $paid_amount='paid_amount';
	  $tax='tax';
	  $create_by='create_by';	  
	  
	   if (!in_array($create_by, $wpdb->get_col( "DESC " . $table_gmgt_income_expense, 0 ) ))
		{  
		   $result= $wpdb->query("ALTER  TABLE $table_gmgt_income_expense  ADD   $create_by  int(11) NOT NULL");
		}
	  
	    if (!in_array($invoice_no, $wpdb->get_col( "DESC " . $table_gmgt_income_expense, 0 ) ))
		{  
		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_income_expense  ADD   $invoice_no  varchar(50) NOT NULL");
		}
		
	    if (!in_array($discount, $wpdb->get_col( "DESC " . $table_gmgt_income_expense, 0 ) ))
		{  
		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_income_expense  ADD   $discount  double NOT NULL");
		}
		
		if (!in_array($total_amount, $wpdb->get_col( "DESC " . $table_gmgt_income_expense, 0 ) ))
		{  
		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_income_expense  ADD   $total_amount  double NOT NULL");
		}
		
		if (!in_array($amount, $wpdb->get_col( "DESC " . $table_gmgt_income_expense, 0 ) ))
		{  
		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_income_expense  ADD   $amount  double NOT NULL");
		}
		
		if (!in_array($paid_amount, $wpdb->get_col( "DESC " . $table_gmgt_income_expense, 0 ) ))
		{  
		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_income_expense  ADD   $paid_amount  double NOT NULL");
		}
		
		if (!in_array($tax, $wpdb->get_col( "DESC " . $table_gmgt_income_expense, 0 ) ))
		{  
		   $result= $wpdb->query("ALTER     TABLE $table_gmgt_income_expense  ADD   $tax  double NOT NULL");
		}
}
?>