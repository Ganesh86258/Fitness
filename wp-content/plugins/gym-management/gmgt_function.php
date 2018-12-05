<?php
//DATE FORAMTE FUNCTION
function gmgt_datepicker_dateformat()
{
	$date_format_array = array(
	'Y-m-d'=>'yy-mm-dd',
	'Y/m/d'=>'yy/mm/dd',
	'd-m-Y'=>'dd-mm-yy',
	'm-d-Y'=>'mm-dd-yy',
	'm/d/Y'=>'mm/dd/yy');
	return $date_format_array;
}
//DATE FORAMTE FUNCTION
function gmgt_bootstrap_datepicker_dateformat($key)
{
	
	$date_format_array = array(
	'yy-mm-dd'=>'yyyy-mm-dd',
	'yy/mm/dd'=>'yyyy/mm/dd',
	'dd-mm-yy'=>'dd-mm-yyyy',
	'mm-dd-yy'=>'mm-dd-yyyy',
	'mm/dd/yy'=>'mm/dd/yyyy');
	return $date_format_array[$key];
}
//GET CURENT USER CLASSIS FUNCTION
function get_current_user_classis($member_id)
{
	global $wpdb;
	$table_memberclass = $wpdb->prefix. 'gmgt_member_class';
	$class_id = array();
	$ClassData = $wpdb->get_results("SELECT * FROM $table_memberclass WHERE member_id=$member_id");
	if(!empty($ClassData))
	{
		foreach($ClassData as $key=>$class_id)
		{
			$classids[]= $class_id->class_id;
		}
		return $classids;
	}
		
}

//GET MEMBER_BY_CLASS_ID
function get_member_by_class_id($class_id)
{
	global $wpdb;
	$table_memberclass = $wpdb->prefix. 'gmgt_member_class';
	return $MemberClass = $wpdb->get_results("SELECT * FROM $table_memberclass WHERE class_id=$class_id ");
}

//GET MEMBERSHIP CLASS FUNCTION
function get_membership_class($membership_id)
{
	global $wpdb;
	$table_membership = $wpdb->prefix. 'gmgt_membershiptype';
	$result = $wpdb->get_row("Select * from $table_membership where membership_id=$membership_id ");
	return $result;

}
//GET MEMBERSHIP BY CLASS ID FUNCTION
function get_class_id_by_membership_id($membership_id)
{
	global $wpdb;
	$table_gmgt_membership_class = $wpdb->prefix. 'gmgt_membership_class';
	$ClassMetaData = $wpdb->get_results("SELECT * FROM $table_gmgt_membership_class WHERE membership_id=$membership_id");
	$class_id =array();
	foreach($ClassMetaData as $key=>$value)
	{
		$class_id[]=$value->class_id;
	}
	return $class_id;	
}

//GET MEMBERSHIP STATUS FUNCTION
function get_membership_class_status($membership_id)
{
	global $wpdb;
	$table_gmgt_membershiptype = $wpdb->prefix. 'gmgt_membershiptype';
	 $class_limit = $wpdb->get_row("SELECT classis_limit FROM $table_gmgt_membershiptype WHERE membership_id=$membership_id");
	return $class_limit->classis_limit;
}

function get_user_used_membership_class($membership_id,$member_id)
{
	global $wpdb;
	$result=0;
	$tbl_gmgt_booking_class = $wpdb->prefix . 'gmgt_booking_class';
	$begin_date = date('Y-m-d 00:00:00',strtotime(get_user_meta($member_id,'begin_date',true)));	 
	$end_date = date('Y-m-d 00:00:00',strtotime( get_user_meta($member_id,'end_date',true)));
	$sql =  "SELECT COUNT(*) FROM $tbl_gmgt_booking_class WHERE booking_date >= '$begin_date'   AND booking_date <=  '$end_date' AND member_id=$member_id AND membership_id=$membership_id";	
	$result = $wpdb->get_var($sql);
	return $result;	
}

//GET PHPDATE FORAMTE FUNCTION
function gmgt_get_phpdateformat($dateformat_value)
{
	$date_format_array = gmgt_datepicker_dateformat();
	$php_format = array_search($dateformat_value, $date_format_array);  
	return  $php_format;
}

//GET DATE IN DIAPLAY TIME FUNCTION
function getdate_in_input_box($date)
{	
	return date(gmgt_get_phpdateformat(get_option('gmgt_datepicker_format')),strtotime($date));	
}
//GET CURENCY SYMBOL FUNCTION
function gmgt_get_currency_symbol( $currency = '' ) {			

			switch ( $currency ) {
			case 'AED' :
			$currency_symbol = 'د.إ';
			break;
			case 'AUD' :
			$currency_symbol = '&#36;';
			break;
			case 'CAD' :
			$currency_symbol = 'C&#36;';
			break;
			case 'CLP' :
			case 'COP' :
			case 'HKD' :
			$currency_symbol = '&#36';
			break;
			case 'MXN' :
			$currency_symbol = '&#36';
			break;
			case 'NZD' :
			$currency_symbol = '&#36';
			break;
			case 'SGD' :
			case 'USD' :
			$currency_symbol = '&#36;';
			break;
			case 'BDT':
			$currency_symbol = '&#2547;&nbsp;';
			break;
			case 'BGN' :
			$currency_symbol = '&#1083;&#1074;.';
			break;
			case 'BRL' :
			$currency_symbol = '&#82;&#36;';
			break;
			case 'CHF' :
			$currency_symbol = '&#67;&#72;&#70;';
			break;
			case 'CNY' :
			case 'JPY' :
			case 'RMB' :
			$currency_symbol = '&yen;';
			break;
			case 'CZK' :
			$currency_symbol = '&#75;&#269;';
			break;
			case 'DKK' :
			$currency_symbol = 'kr.';
			break;
			case 'DOP' :
			$currency_symbol = 'RD&#36;';
			break;
			case 'EGP' :
			$currency_symbol = 'EGP';
			break;
			case 'EUR' :
			$currency_symbol = '&euro;';
			break;
			case 'GBP' :
			$currency_symbol = '&pound;';
			break;
			case 'HRK' :
			$currency_symbol = 'Kn';
			break;
			case 'HUF' :
			$currency_symbol = '&#70;&#116;';
			break;
			case 'IDR' :
			$currency_symbol = 'Rp';
			break;
			case 'ILS' :
			$currency_symbol = '&#8362;';
			break;
			case 'INR' :
			$currency_symbol = 'Rs.';
			break;
			case 'ISK' :
			$currency_symbol = 'Kr.';
			break;
			case 'KIP' :
			$currency_symbol = '&#8365;';
			break;
			case 'KRW' :
			$currency_symbol = '&#8361;';
			break;
			case 'MYR' :
			$currency_symbol = '&#82;&#77;';
			break;
			case 'NGN' :
			$currency_symbol = '&#8358;';
			break;
			case 'NOK' :
			$currency_symbol = '&#107;&#114;';
			break;
			case 'NPR' :
			$currency_symbol = 'Rs.';
			break;
			case 'PHP' :
			$currency_symbol = '&#8369;';
			break;
			case 'PLN' :
			$currency_symbol = '&#122;&#322;';
			break;
			case 'PYG' :
			$currency_symbol = '&#8370;';
			break;
			case 'RON' :
			$currency_symbol = 'lei';
			break;
			case 'RUB' :
			$currency_symbol = '&#1088;&#1091;&#1073;.';
			break;
			case 'SEK' :
			$currency_symbol = '&#107;&#114;';
			break;
			case 'THB' :
			$currency_symbol = '&#3647;';
			break;
			case 'TRY' :
			$currency_symbol = '&#8378;';
			break;
			case 'TWD' :
			$currency_symbol = '&#78;&#84;&#36;';
			break;
			case 'UAH' :
			$currency_symbol = '&#8372;';
			break;
			case 'VND' :
			$currency_symbol = '&#8363;';
			break;
			case 'ZAR' :
			$currency_symbol = '&#82;';
			break;
			default :
			$currency_symbol = $currency;
			break;
	}
	return $currency_symbol;

}

function gym_change_dateformat($date)
{
	return mysql2date(get_option('date_format'),$date);
}

function gmgt_check_table_isempty($tablename){
     global	$wpdb;
	return $rows=$wpdb->get_row("select * from ".$tablename);	 
}
//GET REMOTE FILE FUNCTION

function gmgt_get_remote_file($url, $timeout = 30)
{
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$file_contents = curl_exec($ch);
	curl_close($ch);
	return ($file_contents) ? $file_contents : FALSE;
}
//CHANGE MENU IN FRONTEND SIDE FUNCTION
function change_menutitle($key)
{
	$menu_titlearray=array('staff_member'=>__('Staff Members','gym_mgt'),'membership'=>__('Membership Type','gym_mgt'),'group'=>__('Group','gym_mgt'),'member'=>__('Member','gym_mgt'),'activity'=>__('Activity','gym_mgt'),'class-schedule'=>__('Class Schedule','gym_mgt'),'attendence'=>__('Attendance','gym_mgt'),'assign-workout'=>__('Assigned Workouts','gym_mgt'),'workouts'=>__('Workouts','gym_mgt'),'accountant'=>__('Accountant','gym_mgt'),'membership_payment'=>__('Fee Payment','gym_mgt'),'payment'=>__('Payment','gym_mgt'),'product'=>__('Product','gym_mgt'),'store'=>__('Store','gym_mgt'),'news_letter'=>__('Newsletter','gym_mgt'),'message'=>__('Message','gym_mgt'),'notice'=>__('Notice + Event','gym_mgt'),'nutrition'=>__('Nutrition Schedule','gym_mgt'),'reservation'=>__('Reservation','gym_mgt'),'subscription_history'=>__('Subscription History','gym_mgt'),'alumni'=>__('Alumni','gym_mgt'),'prospect'=>__('Prospect','gym_mgt'),'account'=>__('Account','gym_mgt'));
	
	return $menu_titlearray[$key];
}

//STATUS  FUNCTION
function change_read_status($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "Gmgt_message";
	$data['status']=1;
	$whereid['message_id']=$id;
	return $retrieve_subject = $wpdb->update($table_name,$data,$whereid);
}
//IMAGE/DOCUMENT UPLOAD  FUNCTION
function gmgt_user_avatar_image_upload($type) 
{
	 $imagepath ="";
	 $parts = pathinfo($_FILES[$type]['name']);
	 $inventoryimagename = time()."-"."member".".".$parts['extension'];
	 $document_dir = WP_CONTENT_DIR ;
	 $document_dir .= '/uploads/gym_assets/';
	 $document_path = $document_dir;

	if($imagepath != "")
	{	
		if(file_exists(WP_CONTENT_DIR.$imagepath))
		unlink(WP_CONTENT_DIR.$imagepath);
	}
	if (!file_exists($document_path))
	{
		mkdir($document_path, 0777, true);
	}	
       if (move_uploaded_file($_FILES[$type]['tmp_name'], $document_path.$inventoryimagename)) 
	   {
          $imagepath= $inventoryimagename;	
       }
return $imagepath;
}
function load_documets($file,$type,$nm) 
{
	 $imagepath =$file;
	 $parts = pathinfo($_FILES[$type]['name']);
	 $inventoryimagename = time()."-".$nm."-"."in".".".$parts['extension'];
	 $document_dir = WP_CONTENT_DIR ;
	 $document_dir .= '/uploads/gym_assets/';
	 $document_path = $document_dir;

	if (!file_exists($document_path)) 
	{
		mkdir($document_path, 0777, true);
	}	
		   if (move_uploaded_file($_FILES[$type]['tmp_name'], $document_path.$inventoryimagename))
			{
			  $imagepath= $inventoryimagename;	
		    }
	return $imagepath;
}
add_action( 'wp_login_failed', 'gmgt_login_failed' ); // hook failed login 

function get_lastmember_id($role)
{
	global $wpdb;
	$this_role = "'[[:<:]]".$role."[[:>:]]'";
	$table_name = $wpdb->prefix .'usermeta';
	$metakey=$wpdb->prefix .'capabilities';
	$userid=$wpdb->get_row("SELECT MAX(user_id)as uid FROM $table_name where meta_key = '$metakey' AND meta_value RLIKE $this_role");
	return get_user_meta($userid->uid,'member_id',true);
	
}
// check what page the login attempt is coming from
function gmgt_login_failed( $user ) 
{
	// check what page the login attempt is coming from
	$referrer = $_SERVER['HTTP_REFERER'];
	 $curr_args = array(
				'page_id' => get_option('gmgt_login_page'),
				'login' => 'failed'
				);
				print_r($curr_args);
				$referrer_faild = add_query_arg( $curr_args, get_permalink( get_option('gmgt_login_page') ) );
	// check that were not on the default login page
	if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && $user!=null )
	{
		// make sure we don't already have a failed login attempt
		if ( !strstr($referrer, 'login=failed' )) {
			// Redirect to the login page and append a querystring of login failed
			wp_redirect( $referrer_faild);
		} else {
			wp_redirect( $referrer );
		}

		exit;
	}
}

//GMGT MENU FUNCTION

function gmgt_menu()
{
	$user_menu = array();
	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/staff-member.png' ),'menu_title'=>__( 'Staff Members', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>1,'page_link'=>'staff_member');
	
	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/membership-type.png' ),'menu_title'=>__( 'Membership Type', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>0,'page_link'=>'membership');
	
	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/group.png' ),'menu_title'=>__( 'Group', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>0,'page_link'=>'group');
	
	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/member.png' ),'menu_title'=>__( 'Member', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>1,'page_link'=>'member');
	
	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/activity.png' ),'menu_title'=>__( 'Activity', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>0,'page_link'=>'activity');
	
	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/class-schedule.png' ),'menu_title'=>__( 'Class schedule', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>0,'page_link'=>'class-schedule');
	 
	 $user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/attandance.png' ),'menu_title'=>__( 'Attendence', 'gym_mgt' ),'member'=>0,'staff_member' =>1,'accountant'=>0,'page_link'=>'attendence');
	
	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/assigne-workout.png' ),'menu_title'=>__( 'Assigned Workouts', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>0,'page_link'=>'assign-workout');
	
	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/workout.png' ),'menu_title'=>__( 'Workouts', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>0,'page_link'=>'workouts');
	
	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/accountant.png' ),'menu_title'=>__( 'Accountant', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>1,'page_link'=>'accountant');
	
	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/fee.png' ),'menu_title'=>__( 'Fee Payment', 'gym_mgt' ),'member'=>1,'staff_member' => 0,'accountant'=>1,'page_link'=>'membership_payment');
	
	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/payment.png' ),'menu_title'=>__( 'Payment', 'gym_mgt' ),'member'=>1,'staff_member' => 0,'accountant'=>1,'page_link'=>'payment');
	
	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/products.png' ),'menu_title'=>__( 'Product', 'gym_mgt' ),'member'=>0,'staff_member' => 1,'accountant'=>1,'page_link'=>'product');
	
	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/store.png' ),'menu_title'=>__( 'Store', 'gym_mgt' ),'member'=>0,'staff_member' => 1,'accountant'=>1,'page_link'=>'store');
	
	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/newsletter.png' ),'menu_title'=>__( 'Newsletter', 'gym_mgt' ),'member'=>0,'staff_member' => 1,'accountant'=>0,'page_link'=>'news_letter');
	
	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/message.png' ),'menu_title'=>__( 'Message', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>1,'page_link'=>'message');
	
	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/notice.png' ),'menu_title'=>__( 'Notice', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>1,'page_link'=>'notice');
	
	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/nutrition-schedule.png' ),'menu_title'=>__( 'Nutrition Schedule', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>0,'page_link'=>'nutrition');
	
	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/reservation.png' ),'menu_title'=>__( 'Reservation', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>0,'page_link'=>'reservation');
	
	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/account.png' ),'menu_title'=>__( 'Account', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>1,'page_link'=>'account');
	
	return $user_menu;

}
/*--------- FRONTEND SIDE MENU LIST--------------------*/
function gmgt_frontend_menu_list()
{
	$access_array=array('staff_member' => 
    array (
      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/staff-member.png'),
      'menu_title' =>'Staff Members',
      'member' =>'1',
      'staff_member' =>'1',
      'accountant' =>'1',
      'page_link' =>'staff_member'),
	  
	  'membership' => 
    array (
      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/membership-type.png'),
     'menu_title' =>'Membership Type',
      'member' =>'1',
      'staff_member' =>'1',
      'accountant' =>'0',
      'page_link' =>'membership'),
	  
	    'group' => 
    array (
      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/group.png'),
     'menu_title' =>'group',
      'member' =>'1',
      'staff_member' =>'1',
      'accountant' =>'0',
      'page_link' =>'group'),
	  
	    'member' => 
    array (
      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/member.png'),
     'menu_title' =>'Member',
      'member' =>'1',
      'staff_member' =>'1',
      'accountant' =>'1',
      'page_link' =>'member'),
	  
	/*array (
      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/alumni.png'),
     'menu_title' =>'Alumni',
      'member' =>'1',
      'staff_member' =>'1',
      'accountant' =>'1',
      'page_link' =>'alumni'),   
	  
	array (
      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/prospect.png'),
     'menu_title' =>'Prospect',
      'member' =>'1',
      'staff_member' =>'1',
      'accountant' =>'1',
      'page_link' =>'prospect'),    */
	  
	    'activity' => 
    array (
      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/activity.png'),
     'menu_title' =>'Activity',
      'member' =>'1',
      'staff_member' =>'1',
      'accountant' =>'0',
      'page_link' =>'activity'),
	  
	    'class-schedule' => 
    array (
      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/class-schedule.png'),
     'menu_title' =>'Class schedule',
      'member' =>'1',
      'staff_member' =>'1',
      'accountant' =>'0',
      'page_link' =>'class-schedule'),
	  
	    'attendence' => 
    array (
      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/attandance.png'),
     'menu_title' =>'Attendence',
      'member' =>'0',
      'staff_member' =>'1',
      'accountant' =>'0',
      'page_link' =>'attendence'),
	  
	    'assign-workout' => 
    array (
      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/assigne-workout.png'),
     'menu_title' =>'Assigned Workouts',
      'member' =>'1',
      'staff_member' =>'1',
      'accountant' =>'0',
      'page_link' =>'assign-workout'),
	  
	    'workouts' => 
    array (
      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/workout.png'),
     'menu_title' =>'Workouts',
      'member' =>'1',
      'staff_member' =>'1',
      'accountant' =>'0',
      'page_link' =>'workouts'),
	  
	    'accountant' => 
    array (
      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/accountant.png'),
     'menu_title' =>'Accountant',
      'member' =>'1',
      'staff_member' =>'1',
      'accountant' =>'1',
      'page_link' =>'accountant'),
	  
	    'membership_payment' => 
    array (
      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/fee.png'),
     'menu_title' =>'Fee Payment',
      'member' =>'1',
      'staff_member' =>'0',
      'accountant' =>'1',
      'page_link' =>'membership_payment'),
	  
	    'payment' => 
    array (
      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/payment.png'),
     'menu_title' =>'Payment',
      'member' =>'1',
      'staff_member' =>'0',
      'accountant' =>'1',
      'page_link' =>'payment'),
	  
	     'product' => 
    array (
      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/products.png'),
     'menu_title' =>'Product',
      'member' =>'0',
      'staff_member' =>'1',
      'accountant' =>'1',
      'page_link' =>'product'),
	  
	     'store' => 
    array (
      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/store.png'),
     'menu_title' =>'Store',
      'member' =>'0',
      'staff_member' =>'1',
      'accountant' =>'1',
      'page_link' =>'store'),
	  
	     'news_letter' => 
    array (
      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/newsletter.png'),
     'menu_title' =>'Newsletter',
      'member' =>'0',
      'staff_member' =>'1',
      'accountant' =>'0',
      'page_link' =>'news_letter'),
	  
	     'message' => 
    array (
      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/message.png'),
     'menu_title' =>'Message',
      'member' =>'1',
      'staff_member' =>'1',
      'accountant' =>'1',
      'page_link' =>'message'),
	  
	  
	     'notice' => 
    array (
      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/notice.png'),
     'menu_title' =>'Notice',
      'member' =>'1',
      'staff_member' =>'1',
      'accountant' =>'1',
      'page_link' =>'notice'),
	  
	     'nutrition' => 
    array (
      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/nutrition-schedule.png'),
     'menu_title' =>'Nutrition Schedule',
      'member' =>'1',
      'staff_member' =>'1',
      'accountant' =>'0',
      'page_link' =>'nutrition'),
	  
	     'reservation' => 
    array (
      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/reservation.png'),
     'menu_title' =>'Reservation',
      'member' =>'1',
      'staff_member' =>'1',
      'accountant' =>'0',
      'page_link' =>'reservation'),
	  
	     'account' => 
    array (
      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/account.png'),
     'menu_title' =>'Account',
      'member' =>'1',
      'staff_member' =>'1',
      'accountant' =>'1',
      'page_link' =>'account'),
	  
	     'membership' => 
    array (
      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/membership-type.png'),
     'menu_title' =>'Membership Type',
      'member' =>'1',
      'staff_member' =>'1',
      'accountant' =>'0',
      'page_link' =>'membership'),
	  
	'subscription_history' => 
    array (
      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/subscription_history.png'),
     'menu_title' =>'Subscription History',
      'member' =>'1',
      'staff_member' =>'0',
      'accountant' =>'0',
      'page_link' =>'subscription_history'),
	  
	 
	  
	 );
	
	if ( !get_option('gmgt_access_right') )
	{
		update_option( 'gmgt_access_right', $access_array );
	}
	
}
add_action('init','gmgt_frontend_menu_list');
/*--------- GET SINGLE MEMBRSHIP PAYMENT RECORD --------------------*/
function gym_get_single_membership_payment_record($mp_id)
{
	global $wpdb;
		$table_gmgt_membership_payment = $wpdb->prefix. 'Gmgt_membership_payment';
		$result = $wpdb->get_row("SELECT * FROM $table_gmgt_membership_payment where mp_id=".$mp_id);
		return $result;
}
/*--------- GET SINGLE PAYMENT HISTORY--------------------*/
function gym_get_payment_history_by_mpid($mp_id)
{
	global $wpdb;
	$result=array();
	$table_gmgt_membership_payment_history = $wpdb->prefix .'gmgt_membership_payment_history';
	
	$result =$wpdb->get_results("SELECT * FROM $table_gmgt_membership_payment_history WHERE mp_id=$mp_id ORDER BY payment_history_id DESC");
	return $result;
}
/*--------- GET INCOME PAYMENT HISTORY--------------------*/
function gym_get_income_payment_history_by_mpid($mp_id)
{
	global $wpdb;
	$result=array();
	$table_gmgt_income_payment_history = $wpdb->prefix .'gmgt_income_payment_history';
	
	$result =$wpdb->get_results("SELECT * FROM $table_gmgt_income_payment_history WHERE invoice_id=$mp_id ORDER BY payment_history_id DESC");
	return $result;
}
/*--------- GET SALE PAYMENT HISTORY BY MEMBERSHIP ID--------------------*/
function gym_get_sell_payment_history_by_mpid($mp_id)
{
	global $wpdb;
	$result=array();
	$table_gmgt_sales_payment_history = $wpdb->prefix .'gmgt_sales_payment_history';
	
	$result =$wpdb->get_results("SELECT * FROM $table_gmgt_sales_payment_history WHERE sell_id=$mp_id ORDER BY payment_history_id DESC");
	return $result;
}

/*--------- LOGIN LINK--------------------*/
function gmgt_login_link()
{
	
	/*--------- FRONTEND SIDE MEMBERSHIP PAYMENT BY IDEAL--------------------*/
	if(isset($_REQUEST['pay_method']) && $_REQUEST['pay_method']=="ideal")
	{
		$pay_id = $_REQUEST['pay_id'];
		$amount = $_REQUEST['amount'];
		$customer_id = get_current_user_id();
		$obj_membership_payment=new MJ_Gmgt_membership_payment;
		$obj_membership=new MJ_Gmgtmembership;	
		$obj_member=new MJ_Gmgtmember;
		$joiningdate=date("Y-m-d");
		$membership=$obj_membership->get_single_membership($pay_id);
		
		$validity=$membership->membership_length_id;
		$user_id=$customer_id;
		$expiredate= date('Y-m-d', strtotime($joiningdate. ' + '.$validity.' days'));
		$membership_status = 'continue';
		$payment_data = array();
		$payment_data['member_id'] = $user_id;
		$payment_data['membership_id'] = $pay_id;
		$payment_data['membership_amount'] = get_membership_price($pay_id);
		$payment_data['start_date'] = $joiningdate;
		$payment_data['end_date'] = $expiredate;
		$payment_data['membership_status'] = $membership_status;
		$payment_data['payment_status'] = 0;
		$payment_data['created_date'] = date("Y-m-d");
		$payment_data['created_by'] = $user_id;				
		$plan_id = $obj_member->add_membership_payment_detail($payment_data);
		$feedata['mp_id']=$plan_id;
		
		
		$feedata['amount']=$amount;
		$feedata['payment_method']='iDeal';	
		$feedata['trasaction_id']="";
		$feedata['created_by']=$user_id;
		$result=$obj_membership_payment->add_feespayment_history($feedata);
		if($result){
			$u = new WP_User($user_id);
			$u->remove_role( 'subscriber' );
			$u->add_role( 'member' );
			$hash = md5( rand(0,1000) );
			update_user_meta( $user_id, 'gmgt_hash', $hash );
			update_user_meta( $user_id, 'membership_id', $pay_id );	?>				
			<div id="login-error" style="background-color:#F3FCEB;border:1px solid #76D520;padding:5px;">
				<p><?php _e('Payment successfull.','gym_mgt');?></p>
			</div>
		<?php }
		
	}
	
	/*--------- FRONTEND SIDE MEMBERSHIP PAYMENT BY Instamojo--------------------*/
	if(isset($_REQUEST['pay_id']) && isset($_REQUEST['amount']) && isset($_REQUEST['payment_request_id']))
	{
		$pay_id = $_REQUEST['pay_id'];
		$amount = $_REQUEST['amount'];
		$customer_id = get_current_user_id();
		$obj_membership_payment=new MJ_Gmgt_membership_payment;
		$obj_membership=new MJ_Gmgtmembership;	
		$obj_member=new MJ_Gmgtmember;
		$joiningdate=date("Y-m-d");
		$membership=$obj_membership->get_single_membership($pay_id);
				$validity=$membership->membership_length_id;
				$user_id=$customer_id;
				$expiredate= date('Y-m-d', strtotime($joiningdate. ' + '.$validity.' days'));
				$membership_status = 'continue';
				$payment_data = array();
				$payment_data['member_id'] = $user_id;
				$payment_data['membership_id'] = $pay_id;
				$payment_data['membership_amount'] = get_membership_price($pay_id);
				$payment_data['start_date'] = $joiningdate;
				$payment_data['end_date'] = $expiredate;
				$payment_data['membership_status'] = $membership_status;
				$payment_data['payment_status'] = 0;
				$payment_data['created_date'] = date("Y-m-d");
				$payment_data['created_by'] = $user_id;				
				$plan_id = $obj_member->add_membership_payment_detail($payment_data);
				$feedata['mp_id']=$plan_id;
				//$feedata['memebership_id']=$_POST['custom'];
				$feedata['amount']=$amount;
				$feedata['payment_method']='Instamojo';	
				$feedata['trasaction_id']="";
				$feedata['created_by']=$user_id;
				$result=$obj_membership_payment->add_feespayment_history($feedata);
				if($result)
				{
					$u = new WP_User($user_id);
					$u->remove_role( 'subscriber' );
					$u->add_role( 'member' );
					$hash = md5( rand(0,1000) );
					update_user_meta( $user_id, 'gmgt_hash', $hash );
					update_user_meta( $user_id, 'membership_id', $pay_id );					
					wp_redirect(home_url() .'/?action=success');	
				} 
	}
	
	/*--------- FRONTEND SIDE MEMBERSHIP PAYMENT BY Skrill--------------------*/

	if(isset($_REQUEST['skrill_mp_id']) && isset($_REQUEST['amount']))
	{
		$pay_id = $_REQUEST['skrill_mp_id'];
		$amount = $_REQUEST['amount'];
		$customer_id = get_current_user_id();
		$obj_membership_payment=new MJ_Gmgt_membership_payment;
		$obj_membership=new MJ_Gmgtmembership;	
		$obj_member=new MJ_Gmgtmember;
		$joiningdate=date("Y-m-d");
		$membership=$obj_membership->get_single_membership($pay_id);
		$validity=$membership->membership_length_id;
		$user_id=$customer_id;
		$expiredate= date('Y-m-d', strtotime($joiningdate. ' + '.$validity.' days'));
		$membership_status = 'continue';
		$payment_data = array();
		$payment_data['member_id'] = $user_id;
		$payment_data['membership_id'] = $pay_id;
		$payment_data['membership_amount'] = get_membership_price($pay_id);
		$payment_data['start_date'] = $joiningdate;
		$payment_data['end_date'] = $expiredate;
		$payment_data['membership_status'] = $membership_status;
		$payment_data['payment_status'] = 0;
		$payment_data['created_date'] = date("Y-m-d");
		$payment_data['created_by'] = $user_id;				
		$plan_id = $obj_member->add_membership_payment_detail($payment_data);
		$feedata['mp_id']=$plan_id;
		//$feedata['memebership_id']=$_POST['custom'];
				
				$feedata['amount']=$amount;
				$feedata['payment_method']='Skrill';	
				$feedata['trasaction_id']="";
				$feedata['created_by']=$user_id;
				$result=$obj_membership_payment->add_feespayment_history($feedata);
		
				if($result)
				{
					$u = new WP_User($user_id);
					$u->remove_role( 'subscriber' );
					$u->add_role( 'member' );
					$hash = md5( rand(0,1000) );
					update_user_meta( $user_id, 'gmgt_hash', $hash );
					update_user_meta( $user_id, 'membership_id', $pay_id );					
					wp_redirect(home_url() .'/?action=success');	
				}
	}

	$args = array( 'redirect' => site_url() );
	
	if(isset($_GET['login']) && $_GET['login'] == 'failed')
	{?>

	<div id="login-error" class="login-error" >
	  <p><?php _e('Login failed: You have entered an incorrect Username or password, please try again.','gym_mgt');?></p>
	</div>
    <?php	
	}
	if(isset($_GET['action']) && $_GET['action'] == 'success')
	{ ?>

<div id="login-error" class="login-error">
  <p><?php _e('Payment successfull.','gym_mgt');?></p>
</div>
<?php
	} elseif(isset($_GET['action']) && $_GET['action'] == 'cencal')
	{ ?>
		<div id="login-error" class="login-error">
			<p><?php _e('Payment Cancel.','gym_mgt');?></p>
		</div>
	<?php
	}	
	 $args = array(
			'echo' => true,
			'redirect' => site_url( $_SERVER['REQUEST_URI'] ),
			'form_id' => 'loginform',
			'label_username' => __( 'Username' , 'gym_mgt'),
			'label_password' => __( 'Password', 'gym_mgt' ),
			'label_remember' => __( 'Remember Me' , 'gym_mgt'),
			'label_log_in' => __( 'Log In' , 'gym_mgt'),
			'id_username' => 'user_login',
			'id_password' => 'user_pass',
			'id_remember' => 'rememberme',
			'id_submit' => 'wp-submit',
			'remember' => true,
			'value_username' => NULL,
	        'value_remember' => false ); 
			if(isset($_REQUEST['membership_id']))
			{
				$page_id = get_option ( 'gmgt_membership_pay_page' );
					$referrer_ipn = array(				
						'page_id' => $page_id,
						'membership_id'=>$_REQUEST['membership_id']
					);
				$referrer_ipn = add_query_arg( $referrer_ipn, home_url() );
				$args = array('redirect' =>$referrer_ipn);
			}
			else
			{
				$args = array('redirect' => site_url('/?dashboard=user') );		
			}
			
			if(isset($_REQUEST['na']) && $_REQUEST['na']=='1')
			{ ?>
				<div id="login-error" class="login-error">
					<p><?php _e('You can login after admin approve your registration.','gym_mgt');?></p>
				</div>
			<?php 
			}
	if ( is_user_logged_in() )
	{
	 ?>
		<a href="<?php echo home_url('/')."?dashboard=user"; ?>">
		<?php _e('Dashboard','gym_mgt');?>
		</a>
		<br /><a href="<?php echo wp_logout_url(); ?>"><?php _e('Logout','gyn_mgt');?></a> 
		<?php 
	 }
	else 
	{ 
		wp_login_form( $args );
		echo '<a href="'.wp_lostpassword_url().'" title="Lost Password">'.__('Forgot your password?','gym_mgt').'</a> ';
		//echo ' <BR><a href="'.site_url().'/wp-login.php?action=register" title="Register">'.__('Register','gym_mgt').'</a>';
		//echo ' <BR><a href="'.site_url().'/?action=register" title="Register">'.__('Register','gym_mgt').'</a>';
	}	 
}
add_action( 'wp_ajax_gmgt_add_or_remove_category', 'gmgt_add_or_remove_category');
add_action( 'wp_ajax_gmgt_add_category', 'gmgt_add_category');
add_action( 'wp_ajax_gmgt_remove_category', 'gmgt_remove_category');
add_action( 'wp_ajax_gmgt_load_user', 'gmgt_load_user');
add_action( 'wp_ajax_gmgt_invoice_view', 'gmgt_invoice_view');
add_action( 'wp_ajax_gmgt_load_activity', 'gmgt_load_activity');
add_action( 'wp_ajax_gmgt_nutrition_schedule_view', 'gmgt_nutrition_schedule_view');
add_action( 'wp_ajax_gmgt_load_workout_measurement', 'gmgt_load_workout_measurement');
add_action( 'wp_ajax_gmgt_group_member_view', 'gmgt_group_member_view');
add_action( 'wp_ajax_gmgt_add_workout', 'gmgt_add_workout');
add_action( 'wp_ajax_gmgt_delete_workout', 'gmgt_delete_workout');
add_action( 'wp_ajax_gmgt_today_workouts', 'gmgt_today_workouts');
add_action( 'wp_ajax_gmgt_measurement_view', 'gmgt_measurement_view');
add_action( 'wp_ajax_gmgt_measurement_delete', 'gmgt_measurement_delete');
add_action( 'wp_ajax_gmgt_load_enddate', 'gmgt_load_enddate');
add_action( 'wp_ajax_nopriv_gmgt_load_enddate', 'gmgt_load_enddate');
add_action( 'wp_ajax_gmgt_view_notice',  'gmgt_view_notice');
add_action( 'wp_ajax_gmgt_add_nutrition', 'gmgt_add_nutrition');
add_action( 'wp_ajax_gmgt_delete_nutrition', 'gmgt_delete_nutrition');
add_action( 'wp_ajax_gmgt_paymentdetail_bymembership', 'gmgt_paymentdetail_bymembership');
add_action( 'wp_ajax_gmgt_member_add_payment',  'gmgt_member_add_payment');
add_action( 'wp_ajax_gmgt_member_view_paymenthistory',  'gmgt_member_view_paymenthistory');
add_action( 'wp_ajax_gmgt_verify_pkey', 'gmgt_verify_pkey');
add_action( 'wp_ajax_gmgt_timeperiod_for_class_number', 'gmgt_timeperiod_for_class_number');

add_action( 'wp_ajax_gmgt_get_class_id_by_membership', 'gmgt_get_class_id_by_membership');
add_action( 'wp_ajax_nopriv_gmgt_get_class_id_by_membership', 'gmgt_get_class_id_by_membership');

add_action( 'wp_ajax_gmgt_check_membership_limit_status', 'gmgt_check_membership_limit_status');
add_action( 'wp_ajax_nopriv_gmgt_check_membership_limit_status', 'gmgt_check_membership_limit_status');

add_action( 'wp_ajax_gmgt_timeperiod_for_class_member', 'gmgt_timeperiod_for_class_member');
add_action( 'wp_ajax_gmgt_add_staff_member', 'gmgt_add_staff_member');
add_action( 'wp_ajax_gmgt_add_group', 'gmgt_add_group');
add_action( 'wp_ajax_gmgt_add_ajax_membership', 'gmgt_add_ajax_membership');
add_action( 'wp_ajax_gmgt_add_ajax_class', 'gmgt_add_ajax_class');
add_action( 'wp_ajax_gmgt_add_ajax_product', 'gmgt_add_ajax_product');
add_action( 'wp_ajax_gmgt_count_store_total', 'gmgt_count_store_total');
add_action( 'wp_ajax_gmgt_check_product_stock', 'gmgt_check_product_stock');

//check product stock
function gmgt_check_product_stock()
{
	$product_id=$_REQUEST['product_id'];
	$quantity=$_REQUEST['quantity'];
	$row_no=$_REQUEST['row_no'];
	
	global $wpdb;
	$table_product = $wpdb->prefix. 'gmgt_product';
	$result = $wpdb->get_row("SELECT * FROM $table_product where id=".$product_id);
	
	$before_quantity=$result->quentity;
	if($quantity>$before_quantity)
	{		
		echo $row_no;
	}
	die();
}
//----------ADD MEMBERSHIP AJAX CODE-----------
function gmgt_add_ajax_product()
{
	
	$obj_product=new MJ_Gmgtproduct;
	$result=$obj_product->gmgt_add_product($_POST);
	$option ="";
	$product_info=$obj_product->get_single_product($result);
	
	if(!empty($product_info)){
		$option = "<option value='".$product_info->id."'>".$product_info->product_name."</option>";
	}
	echo $option;
	die();
}

//----------ADD MEMBERSHIP AJAX CODE-----------
function gmgt_add_ajax_class()
{
	
	$obj_class=new MJ_Gmgtclassschedule;
	$result=$obj_class->gmgt_add_class($_POST);
	$option ="";
	$class_info=$obj_class->get_single_class($result);

	if(!empty($class_info)){
		$option = "<option value='".$class_info->class_id."'>".$class_info->class_name."</option>";
	}
	echo $option;
	die();
}

//----------ADD MEMBERSHIP AJAX CODE-----------
function gmgt_add_ajax_membership()
{
	
	$txturl=$_POST['gmgt_membershipimage'];
	$ext=check_valid_extension($txturl);
	if(!$ext == 0)
	{
		$obj_membership=new MJ_Gmgtmembership;
		$result=$obj_membership->gmgt_add_membership($_POST,$_POST['gmgt_membershipimage']);
		$option ="";
		$membership_info=$obj_membership->get_single_membership($result);

		if(!empty($membership_info)){
			$option = "<option value='".$membership_info->membership_id."'>".$membership_info->membership_label."</option>";
		}
		echo $option;
	}
	else
	{
		echo 0;
	}	
	
	die();
}
//----------ADD GROUP AJAX CODE-----------
function gmgt_add_group()
{
	$obj_group=new MJ_Gmgtgroup;
	$result=$obj_group->gmgt_add_group($_POST,$_POST['gmgt_groupimage']);
	$option ="";
	$group_info=$obj_group->get_single_group($result);

	if(!empty($group_info)){
		$option = "<option value='".$group_info->id."'>".$group_info->group_name."</option>";
	}
	echo $option;
	die();
}
//----------ADD STAFF MEMBER AJAX CODE-----------
function gmgt_add_staff_member()
{	

	$txturl=$_POST['gmgt_user_avatar'];
	$ext=check_valid_extension($txturl);
	if(!$ext == 0)
	{
		$obj_member=new MJ_Gmgtmember;
		$result=$obj_member->gmgt_add_user($_POST);
		$user_info = get_userdata($result);
		$option ="";
		if(!empty($user_info)){
			$option = "<option value='".$user_info->ID."'>".$user_info->first_name." ".$user_info->last_name."</option>";
		}
		echo $option;
	}
	else
	{
		echo 0;
	}	
	die();
}


function gmgt_view_notice()
{
$notice = get_post($_REQUEST['notice_id']); ?>
<div class="form-group"> <a class="close-btn badge badge-success pull-right" href="#">X</a>
  <h4 class="modal-title" id="myLargeModalLabel">
    <?php _e('Notice Detail','gym_mgt'); ?>
  </h4>
</div>
<hr>
<div class="panel panel-white form-horizontal">
  <div class="form-group">
    <label class="col-sm-3" for="notice_title">
    <?php _e('Notice Title','gym_mgt');?>
    : </label>
    <div class="col-sm-9"> <?php echo $notice->post_title;?> </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3" for="notice_title">
    <?php _e('Notice Comment','gym_mgt');?>
    : </label>
    <div class="col-sm-9"> <?php echo $notice->post_content;?> </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3" for="notice_title">
    <?php _e('Notice For','gym_mgt');?>
    : </label>
    <div class="col-sm-9"> <?php echo gmgtGetRoleName(get_post_meta( $notice->ID, 'notice_for',true));?> </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3" for="notice_title">
    <?php _e('Start Date','gym_mgt');?>
    : </label>
    <div class="col-sm-9"> <?php echo getdate_in_input_box(get_post_meta($notice->ID,'gmgt_start_date',true));?> </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3" for="notice_title">
    <?php _e('End Date','gym_mgt');?>
    : </label>
    <div class="col-sm-9"> <?php echo getdate_in_input_box(get_post_meta( $notice->ID, 'gmgt_end_date',true));?> </div>
  </div>
</div>
<?php 
	die();
}
//---------- GET TODAY WORKOUT FOR MEMBER----------//
function gmgt_today_workouts()
{
	    $user_id=$_POST['uid'];
		global $wpdb;
		$table_name = $wpdb->prefix."gmgt_assign_workout";
		$table_gmgt_workout_data = $wpdb->prefix."gmgt_workout_data";
		$date = date('Y-m-d');
		//$record_date = date('Y-m-d',strtotime($_POST['record_date']));
		$record_date = $curr_date=get_format_for_db($_POST['record_date']);
		$day_name = date('l', strtotime($date));
		//$sql = "Select * From $table_name where  user_id = $user_id AND CURDATE() between Start_date and End_date ";
		$sql = "Select * From $table_name as workout,$table_gmgt_workout_data as workoutdata where  workout.user_id = $user_id 
		AND  workout.workout_id = workoutdata.workout_id 
		AND workoutdata.day_name = '$day_name'
		AND '".$record_date."' between workout.Start_date and workout.End_date ";
		//echo $sql;
		$result = $wpdb->get_results($sql);	

		//print_r($result);
		
		if(!empty($result))
		{
			echo $option="<div class='work_out_datalist_header'><div class='col-md-12 col-sm-12 col-xs-12'>
					<span class='col-md-3 col-sm-3 col-xs-3 no-padding'>".__('Activity','gym_mgt')."</span>
					<span class='col-md-2 col-sm-2 col-xs-2'>".__('Sets','gym_mgt')."</span>
					<span class='col-md-2 col-sm-2 col-xs-2'>".__('Reps','gym_mgt')."</span>
					<span class='col-md-2 col-sm-2 col-xs-2'>".__('KG','gym_mgt')."</span>
					<span class='col-md-3 col-sm-3 col-xs-3'>".__('Rest Time','gym_mgt')."</span>
					</div></div>";
			foreach ($result as $retrieved_data)
			{
				$workout_id=$retrieved_data->workout_id;
				echo $option="<div class='work_out_datalist'><div class='col-sm-12 col-md-12 col-xs-12'>
					<input type='hidden' name='asigned_by' value='".$retrieved_data->create_by."'>
					<input type='hidden' name='workouts_array[]' value='".$retrieved_data->id."'>
					<input type='hidden' name='workout_name_".$retrieved_data->id."' value='".$retrieved_data->workout_name."'>
					<span class='col-md-3 col-sm-3 col-xs-3 no-padding'>".$retrieved_data->workout_name."</span>
					<span class='col-md-2 col-sm-2 col-xs-2'>".$retrieved_data->sets." ".__('Sets','gym_mgt')."</span>
					<span class='col-md-2 col-sm-2 col-xs-2'>".$retrieved_data->reps."  ".__('Reps','gym_mgt')."</span>
					<span class='col-md-2 col-sm-2 col-xs-2'>".$retrieved_data->kg."  ".__('Kg','gym_mgt')."</span>
					<span class='col-md-2 col-sm-2 col-xs-2'>".$retrieved_data->time."  ".__('Min','gym_mgt')."</span>
				</div>";
				echo $option="<div class='col-md-12 col-sm-12 col-xs-12'>
					<span class='col-md-3 col-sm-3 col-xs-3 no-padding'>".__('Your Workout','gym_mgt')."</span>
					<span class='col-md-2 col-sm-2 col-xs-2'><input type='text' class='my-workouts validate[required,custom[onlyNumberSp]]' maxlength='3' id='sets' name='sets_".$retrieved_data->id."' width='50px'></span>
					<span class='col-md-2 col-sm-2 col-xs-2'><input type='text' class='my-workouts validate[required,custom[onlyNumberSp]]' maxlength='3' id='reps' name='reps_".$retrieved_data->id."' width='50px'></span>
					<span class='col-md-2 col-sm-2 col-xs-2'><input type='text' class='my-workouts validate[required,custom[onlyNumberSp]]' maxlength='3' id='kg' name='kg_".$retrieved_data->id."' width='50px'></span>
					<span class='col-md-2 col-sm-2 col-xs-2'><input type='text' class='my-workouts validate[required,custom[onlyNumberSp]]' maxlength='3' id='rest' name='rest_".$retrieved_data->id."' width='50px'></span>
				</div></div>";
			
			}
				echo $option="<input type='hidden' value='$workout_id' name='user_workout_id'>";
		}
		else
		{
			echo $option = "<div class='work_out_datalist'><div class='col-sm-10'><span class='col-md-10'>".__('No Workout assigned for today','gym_mgt')."</span></div></div>";
		}
		die();
}
//---------- LOAD MEASUREMENT----------//
function gmgt_load_workout_measurement()
{
	
	global $wpdb;
		$table_workout = $wpdb->prefix. 'gmgt_workouts';
	$result = $wpdb->get_row("SELECT measurment_id FROM $table_workout where id=". $_REQUEST['workout_id']);
	echo get_the_title($result->measurment_id);	
	die();
}
//---------- ADD CATEGORY TYPE----------//
function gmgt_add_categorytype($data)
{
	global $wpdb;
	$result = wp_insert_post( array(

			'post_status' => 'publish',

			'post_type' => $data['category_type'],

			'post_title' => $data['category_name']) );

	$id = $wpdb->insert_id;
	return $id;
}

//---------- ADD CATEGORY----------//
function gmgt_add_category($data)
{
	/* global $wpdb;
	$model = $_REQUEST['model'];
	$data = array();
	$data['category_name'] = $_REQUEST['category_name'];
	$data['category_type'] = $_REQUEST['model'];
	$id = gmgt_add_categorytype($data);
	$row1 = '<tr id="cat-'.$id.'"><td>'.$_REQUEST['category_name'].'</td><td><a class="btn-delete-cat badge badge-delete" href="#" id='.$id.' model="'.$model.'">X</a></td></tr>';
	$option = "<option value='$id'>".$_REQUEST['category_name']."</option>";
	$array_var[] = $row1;
	$array_var[] = $option;
	echo json_encode($array_var);
	die(); */
	
	
	global $wpdb;
	$model = $_REQUEST['model'];
	$data = array();
	$status=1;
	$status_msg= __('You have entered value already exists. Please enter some other value.','gym_mgt');
	$array_var = array();
	$data = array();
	$data['category_name'] = $_POST['category_name'];
	$data['category_type'] = $_POST['model'];
    $posttitle =$_REQUEST['category_name'];
    $post = $wpdb->get_row( "SELECT * FROM $wpdb->posts WHERE post_title = '" . $posttitle . "' AND  post_type ='". $model."'" );
    $postname=$post->post_title;
	
   if($postname == $posttitle )
   {
	   $status=0;
   }
   else
   { 
	$id = gmgt_add_categorytype($data);
	$row1 = '<tr id="cat-'.$id.'"><td>'.$_REQUEST['category_name'].'</td><td><a class="btn-delete-cat badge badge-delete" href="#" id='.$id.' model="'.$model.'">X</a></td></tr>';
	$option = "<option value='$id'>".$_REQUEST['category_name']."</option>";

	$array_var[] = $row1;

	$array_var[] = $option;
   }
    $array_var[2]=$status;
    $array_var[3]=$status_msg;
	echo json_encode($array_var);

	die();
	
}
//----------GET CLASS NAME----------//
function gmgt_get_class_name($cid)
{
	
	global $wpdb;
	$table_name = $wpdb->prefix .'gmgt_class_schedule';
	$classname =$wpdb->get_row("SELECT class_name FROM $table_name WHERE class_id=".$cid);
	if(!empty($classname))
	{
		return $classname->class_name;
	}
	else
	{ 
	  return " ";
	}
}
//----------GET MEMBERSHIP NAME---------//
function get_membership_name($mid)
{
	if($mid == '')
		return '';
	global $wpdb;
	$table_name = $wpdb->prefix .'gmgt_membershiptype';

	$result =$wpdb->get_row("SELECT membership_label FROM $table_name WHERE membership_id=".$mid);
	if(!empty($result))
	{
		return $result->membership_label;
	}
	else
	{
		return " ";
	}
}

//----------GET MEMBERSHIP AMOUNT--------//
function get_membership_price($mid)
{
	if($mid == '')
	{
		return '';
	}
	global $wpdb;
	$table_name = $wpdb->prefix .'gmgt_membershiptype';
	$result =$wpdb->get_row("SELECT membership_amount FROM $table_name WHERE membership_id=".$mid);
	if(!empty($result))
	{
		return $result->membership_amount;
	}
	else
	{
		return " ";
	}
}
//----------GET MEMBERSHIP DAY--------//
function get_membership_days($mid)
{
	if($mid == '')
		return '';
	global $wpdb;
	$table_name = $wpdb->prefix .'gmgt_membershiptype';

	$result =$wpdb->get_row("SELECT membership_length_id FROM $table_name WHERE membership_id=".$mid);
	if(!empty($result))
		return $result->membership_length_id;
	else
		return " ";
}
//----------GET MEMBERSHIP PAYMENT STATUS --------//
function get_membership_paymentstatus($mp_id)
{
	global $wpdb;
		$table_gmgt_membership_payment = $wpdb->prefix. 'Gmgt_membership_payment';
		//echo "SELECT paid_amount FROM $table_gmgt_membership_payment where mp_id = $mp_id";
		$result = $wpdb->get_row("SELECT * FROM $table_gmgt_membership_payment where mp_id = $mp_id");
		//return $result->paid_amount;
	if($result->paid_amount >= $result->membership_amount)
		return 'Fully Paid';
	elseif($result->paid_amount > 0)
		return 'Partially Paid';
	else
		return 'Unpaid';
}


function get_all_membership_payment_byuserid($member_id)
{
	global $wpdb;
	$table_gmgt_membership_payment = $wpdb->prefix. 'Gmgt_membership_payment';
	
	$result = $wpdb->get_results("SELECT * FROM $table_gmgt_membership_payment where member_id = $member_id");
	return $result;
}
//----------GET GROUP MEMBER --------//
function gym_get_groupmember($group_id)
{
	global $wpdb;
	$table_gmgt_groupmember = $wpdb->prefix. 'gmgt_groupmember';
	$result = $wpdb->get_results("SELECT member_id FROM $table_gmgt_groupmember where group_id=".$group_id);
	return $result;
}

//----------GETACTIVITY BY CATEGORY --------//
function gmgt_get_activity_by_category($cat_id)
{

	global $wpdb;
	$table_activity = $wpdb->prefix. 'gmgt_activity';
	$activitydata = $wpdb->get_results("SELECT * FROM $table_activity where activity_cat_id=".$cat_id);
	return $activitydata;
}
function gym_get_activity_by_staffmember($staff_memberid)
{
	global $wpdb;
	$table_gmgt_activity = $wpdb->prefix. 'gmgt_activity';
	$result = $wpdb->get_results("SELECT * FROM $table_gmgt_activity where activity_assigned_to=".$staff_memberid);
	return $result;
}

//----------REMOVE  CATEGORY --------//
function gmgt_remove_category()
{

	wp_delete_post($_REQUEST['cat_id']);

	die();

}
//----------GET ALL CATEGORY --------//
function  gmgt_get_all_category($model){

	$args= array('post_type'=> $model,'posts_per_page'=>-1,'orderby'=>'post_title','order'=>'Asc');

	$cat_result = get_posts( $args );

	return $cat_result;

}

//----------ADD OR REMOVE  CATEGORY --------//
function gmgt_add_or_remove_category()
{

	$model = $_REQUEST['model'];
	 
		$title = __("title",'gym_mgt');

		$table_header_title =  __("header",'gym_mgt');

		$button_text=  __("Add category",'gym_mgt');

		$label_text =  __("category Name",'gym_mgt');


	if($model == 'membership_category')
	{

		$title = __("Add Membership Category",'gym_mgt');

		$table_header_title =  __("Category Name",'gym_mgt');

		$button_text=  __("Add Category",'gym_mgt');

		$label_text =  __("Category Name",'gym_mgt');	

	}
	if($model == 'installment_plan')
	{

		$title = __("Add Installment Plan",'gym_mgt');

		$table_header_title =  __("Plan Name",'gym_mgt');

		$button_text=  __("Add Plan",'gym_mgt');

		$label_text =  __("Installment  Plan Name",'gym_mgt');	

	}
	if($model == 'membership_period')
	{

		$title = __("Add Membership Period",'gym_mgt');

		$table_header_title =  __("Membership Period Name",'gym_mgt');

		$button_text=  __("Add Membership Period",'gym_mgt');

		$label_text =  __("Membership Period Name",'gym_mgt');	
		
		$placeholder_text=__("Only Number of Days",'gym_mgt');

	}
	if($model == 'role_type')
	{

		$title = __("Add Role Type",'gym_mgt');

		$table_header_title =  __("Role Name",'gym_mgt');

		$button_text=  __("Add Role",'gym_mgt');

		$label_text =  __("Role Name",'gym_mgt');	

	}
	if($model == 'specialization')
	{

		$title = __("Add Specialization",'gym_mgt');

		$table_header_title =  __("Specialization Name",'gym_mgt');

		$button_text=  __("Add Specialization",'gym_mgt');

		$label_text =  __("Specialization Name",'gym_mgt');	

	}
	if($model == 'intrest_area')
	{

		$title = __("Add Intrest Area",'gym_mgt');

		$table_header_title =  __("Intrest Area Name",'gym_mgt');

		$button_text=  __("Add Intrest Area",'gym_mgt');

		$label_text =  __("Intrest Area Name",'gym_mgt');	

	}
	if($model == 'source')
	{

		$title = __("Add Source",'gym_mgt');

		$table_header_title =  __("Source Name",'gym_mgt');

		$button_text=  __("Add Source",'gym_mgt');

		$label_text =  __("Source Name",'gym_mgt');	

	}
	if($model == 'event_place')
	{

		$title = __("Add Event Place",'gym_mgt');

		$table_header_title =  __("Place Name",'gym_mgt');

		$button_text=  __("Add Place",'gym_mgt');

		$label_text =  __("Place Name",'gym_mgt');	

	}
	if($model == 'activity_category')
	{

		$title = __("Add Training Data",'gym_mgt');

		$table_header_title =  __("Training Data Name",'gym_mgt');

		$button_text=  __("Add Training Data",'gym_mgt');

		$label_text =  __("Training Data Name",'gym_mgt');	

	}
	if($model == 'measurment')
	{

		$title = __("Add Measurement",'gym_mgt');

		$table_header_title =  __("Measurement Name",'gym_mgt');

		$button_text=  __("Add Measurement",'gym_mgt');

		$label_text =  __("Measurement Name",'gym_mgt');	

	}
	if($model == 'level_type')
	{

		$title = __("Add Level Type",'gym_mgt');

		$table_header_title =  __("Level Name",'gym_mgt');

		$button_text=  __("Add Level",'gym_mgt');

		$label_text =  __("Level Name",'gym_mgt');	

	}
	if($model == 'workout_limit')
	{

		$title = __("Add Workout Limit",'gym_mgt');

		$table_header_title =  __("Workout Limit",'gym_mgt');

		$button_text=  __("Add Workout Limit",'gym_mgt');

		$label_text =  __("Workout Limit",'gym_mgt');	

	}
	if($model == 'calories_category')
	{

		$title = __("Add Calories Category",'gym_mgt');

		$table_header_title =  __("Calories",'gym_mgt');

		$button_text=  __("Add Calories Category",'gym_mgt');

		$label_text =  __("Calories",'gym_mgt');	

	}
	
	$cat_result = gmgt_get_all_category( $model );

	?>
	
	
	<div class="modal-header"> <a href="#" class="close-btn badge badge-success pull-right <?php echo $model ;?>">X</a>

  		<h4 id="myLargeModalLabel" class="modal-title"><?php echo $title;?></h4>

	</div>

	<div class="panel panel-white">
	
  		<div class="category_listbox"><!--  CATEGORY LIST BOX DIV    -->

  			<div class="table-responsive">

		  		<table class="table">

			  		<thead>

			  			<tr>

			                <!--  <th>#</th> -->

			                <th><?php echo $table_header_title;?></th>

			                <th><?php _e('Action','gym_mgt');?></th>

			            </tr>

			        </thead>
			         <?php 
					$i = 1;

					if(!empty($cat_result))
					{
						foreach ($cat_result as $retrieved_data)
						{
							echo '<tr id="cat-'.$retrieved_data->ID.'">';

							//echo '<td>'.$i.'</td>';

							echo '<td>'.$retrieved_data->post_title.'</td>';

							echo '<td id='.$retrieved_data->ID.'><a class="btn-delete-cat badge badge-delete" model='.$model.' href="#" id='.$retrieved_data->ID.'>X</a></td>';

							echo '</tr>';

							$i++;		

						}

					}
				  ?>
		        </table>

		     </div>

  		</div><!--  END CATEGORY LIST BOX DIV    -->
		
		<script>
			$('.onlyletter_number_space_validation').keypress(function( event ) 
			{     
				var regex = new RegExp("^[a-zA-Z \b]+$");
				var key = String.fromCharCode(!event.charCode ? event.which: event.charCode);
				if (!regex.test(key)) 
				{
					event.preventDefault();
					alert("Enter Latter and Space Only");
					return false;
				} 
			});
		</script>
		
  		<form name="category_form" action="" method="post" class="form-horizontal" id="category_form">

	  	 	<div class="form-group add_or_remove">

				<label class="col-sm-4 control-label" for="category_name"><?php echo $label_text;?><span class="require-field">*</span></label>

				<div class="col-sm-4">

					<input id="category_name" class="form-control onlyletter_number_space_validation"  value="" name="category_name" maxlength="50" <?php if(isset($placeholder_text)){?> type="number" placeholder="<?php  echo $placeholder_text;}else{?>" type="text" <?php }?>>

				</div>

				<div class="col-sm-4">
						<input type="button" value="<?php echo $button_text;?>" name="save_category" class="btn btn-success" model="<?php echo $model;?>" id="btn-add-cat"/>
				</div>

			</div>

  		</form>

  	</div>
	<?php 
	die();	
}

// GET PHONE CODE BY COUNTRY CODE FUNCTION //
function gmgt_get_countery_phonecode($country_name)
{
	//$xml=simplexml_load_file(plugins_url( 'countrylist.xml', __FILE__ )) or die("Error: Cannot create object");
	$url = plugins_url( 'countrylist.xml', __FILE__ );
	$xml =simplexml_load_string(gmgt_get_remote_file($url));
	foreach($xml as $country)
	{
		if($country_name == $country->name)
			return $country->phoneCode;

	}
}
// GET DAY FUNCTION //
function days_array()
{
	return $week=array(	'Sunday'=>__('Sunday','gym_mgt'),
						'Monday'=>__('Monday','gym_mgt'),
						'Tuesday'=>__('Tuesday','gym_mgt'),
						'Wednesday'=>__('Wednesday','gym_mgt'),
						'Thursday'=>__('Thursday','gym_mgt'),
						'Friday'=>__('Friday','gym_mgt'),
						'Saturday'=>__('Saturday','gym_mgt'));
}
// GET MEMBER TYPE //
function member_type_array()
{
	return $membertype=array('Member'=>__('Active Member','gym_mgt'),
						'Prospect'=>__('Prospect','gym_mgt'),
						'Alumni'=>__('Alumni','gym_mgt'));
}

// GET MINUITE AARAY FUNCTION //
function minute_array()
{
	return $minute=array('00'=>'00','15'=>'15','30'=>'30','45'=>'45');
}

// GET MEASUREMENT AARAY FUNCTION //
function measurement_array()
{
	return $measurment=array(	'Height'=>__('Height','gym_mgt'),
								'Weight'=>__('Weight','gym_mgt'),
								'Chest'=>__('Chest','gym_mgt'),
								'Waist'=>__('Waist','gym_mgt'),
								'Thigh'=>__('Thigh','gym_mgt'),
								'Arms'=>__('Arms','gym_mgt'),
								'Fat'=>__('Fat','gym_mgt'));
}
function get_single_class_name($class_id)
{
	global $wpdb;
		$table_class = $wpdb->prefix. 'gmgt_class_schedule';
	return $retrieve_subject = $wpdb->get_var( "SELECT class_name FROM $table_class WHERE class_id=".$class_id);	
}
//LOAD USER FUNCTION
function gmgt_load_user()
{
	
	$class_id =$_POST['class_list'];
	
	global $wpdb;
	$retrieve_data=get_users(array('meta_key' => 'class_id', 'meta_value' => $class_id,'role'=>'member'));
	$defaultmsg=__( 'Select Member' , 'gym_mgt');
	echo "<option value=''>".$defaultmsg."</option>";	
	foreach($retrieve_data as $users)
	{
		echo "<option value=".$users->id.">".$users->display_name."</option>";
	}
	die();	
}
//LOAD ALL ACTIVITY FUNCTION
function gmgt_load_activity()
{
	
	global $wpdb;
		$table_activity = $wpdb->prefix. 'gmgt_activity';
	
		$activitydata = $wpdb->get_results("SELECT * FROM $table_activity where activity_cat_id=".$_REQUEST['activity_list']);
		$defaultmsg=__( 'Select Activity', 'gym_mgt');
		echo "<option value=''>".$defaultmsg."</option>";	
		foreach($activitydata as $activity)
		{
			echo "<option value=".$activity->activity_id.">".$activity->activity_title."</option>";
		}
		die();
}
//GET INVOICE DATA FUNCTION
function get_invoice_data($invoice_id)
{
	global $wpdb;
		$table_invoice= $wpdb->prefix. 'gmgt_payment';
		$result = $wpdb->get_row("SELECT *FROM $table_invoice where payment_id = ".$invoice_id);
		return $result;
}
 
//VIEW INVOICE  FUNCTION BY INVOICE TYPE
function gmgt_invoice_view()
{
	$obj_payment= new MJ_Gmgtpayment();
	if($_POST['invoice_type']=='membership_invoice')
	{		
		$obj_membership_payment=new MJ_Gmgt_membership_payment;	
		$membership_data=$obj_membership_payment->get_single_membership_payment($_POST['idtest']);
	}
	if($_POST['invoice_type']=='income')
	{
		$income_data=$obj_payment->gmgt_get_income_data($_POST['idtest']);
	}
	if($_POST['invoice_type']=='expense')
	{
		$expense_data=$obj_payment->gmgt_get_income_data($_POST['idtest']);
	}
	if($_POST['invoice_type']=='sell_invoice')
	{
		$obj_store=new MJ_Gmgtstore;
		$selling_data=$obj_store->get_single_selling($_POST['idtest']);
	}
	
	?>	
	<div class="modal-header">
		<a href="#" class="close-btn badge badge-success pull-right">X</a>			
	</div>
	<div class="modal-body invoice_body">
		<div id="invoice_print">
			<img class="invoicefont1" style="vertical-align:top;background-repeat:no-repeat;" src="<?php echo plugins_url('/gym-management/assets/images/invoice.jpg'); ?>" width="100%">
			<div class="main_div">					
				<table class="width_100" border="0">					
					<tbody>
						<tr>
							<td class="width_1">
								<img class="system_logo" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">
							</td>							
							<td class="only_width_20">
								<?php
								 echo "A. ".chunk_split(get_option('gmgt_gym_address'),30,"<BR>"); 
								 echo "E. ".get_option( 'gmgt_email' )."<br>"; 
								 echo "P. " .get_option( 'gmgt_contact_number' )."<br>"; 
								?> 
							</td>
							<td align="right" class="width_24">
							</td>
						</tr>
					</tbody>
				</table>
				<table class="width_50" border="0">
					<tbody>				
						<tr>
							<td colspan="2"  class="billed_to" align="center">								
								<h3 class="billed_to_lable"><?php _e('| Bill To.','gym_mgt');?> </h3>
							</td>
							<td class="width_40">								
							<?php 
								if(!empty($expense_data))
								{
								   echo "<h3 class='display_name'>".chunk_split(ucwords($expense_data->supplier_name),30,"<BR>"). "</h3>"; 
								}
								else
								{
									if(!empty($income_data))
										$member_id=$income_data->supplier_name;
									 if(!empty($membership_data))
										$member_id=$membership_data->member_id;
									 if(!empty($selling_data))
										$member_id=$selling_data->member_id;
									$patient=get_userdata($member_id);
									 echo "<h3 style='font-weight: bold;'>".chunk_split(ucwords($patient->display_name),30,"<BR>"). "</h3>"; 
									 $address=get_user_meta( $member_id,'address',true);
									 echo chunk_split($address,30,"<BR>"); 									 
									 echo get_user_meta( $member_id,'city_name',true ).","; 
									 echo get_user_meta( $member_id,'zip_code',true )."<br>"; 
									echo get_user_meta( $member_id,'mobile',true )."<br>"; 
								}
							?>			
							</td>
						</tr>									
					</tbody>
				</table>
					<?php 
					$issue_date='DD-MM-YYYY';
					if(!empty($income_data))
					{
						$issue_date=$income_data->invoice_date;
						$payment_status=$income_data->payment_status;
						$invoice_no=$income_data->invoice_no;
					}
					if(!empty($membership_data))
					{
						$issue_date=$membership_data->created_date;
						if($membership_data->payment_status!='0')
						{	
							$payment_status=$membership_data->payment_status;
						}
						else
						{
							$payment_status='Unpaid';
						}		
						$invoice_no=$membership_data->invoice_no;
					}
					if(!empty($expense_data))
					{
						$issue_date=$expense_data->invoice_date;
						$payment_status=$expense_data->payment_status;
						$invoice_no=$expense_data->invoice_no;
					}
					if(!empty($selling_data))
					{
						$issue_date=$selling_data->sell_date;	
						if(!empty($selling_data->payment_status))
						{
							$payment_status=$selling_data->payment_status;
						}	
						else
						{
							$payment_status='Fully Paid';
						}		
						
						$invoice_no=$selling_data->invoice_no;
					}			
						
					?>
				<table class="width_50" border="0">
					<tbody>				
						<tr>	
							<td class="width_30">
							</td>
							<td class="width_20" style="padding-right:30px;" align="left">
								<?php
								if($_POST['invoice_type']!='expense')
								{
								?>	
									<h3 class="invoice_lable"  ><?php echo __('INVOICE','gym_mgt')." </br> #".$invoice_no;?></h3>								
								<?php
								}
								?>								
								<h5> <?php   echo __('Date','gym_mgt')." : ".getdate_in_input_box($issue_date);?></h5>
								<h5><?php echo __('Status','gym_mgt')." : ". __($payment_status,'gym_mgt');?></h5>									
							</td>							
						</tr>									
					</tbody>
				</table>						
				<?php
				if($_POST['invoice_type']=='membership_invoice')
				{ 
				?>	
					<table class="width_100">	
						<tbody>	
							<tr>
								<td>
									<h3  class="entry_lable"><?php _e('Membership Entries','gym_mgt');?></h3>
								</td>	
							</tr>	
						</tbody>
					</table>	
					
				<?php 	
				}				
				elseif($_POST['invoice_type']=='income')
				{ 
				?>	
					<table class="width_100">	
						<tbody>	
							<tr>
								<td>
									<h3  class="entry_lable"><?php _e('Income Entries','gym_mgt');?></h3>
								</td>	
							</tr>	
						</tbody>
					</table>
				
				<?php 	
				}
				elseif($_POST['invoice_type']=='sell_invoice')
				{ 
				   ?>
				   <table class="width_100">	
						<tbody>	
							<tr>
								<td>
									<h3  class="entry_lable"><?php _e('Sells Product','gym_mgt');?></h3>
								</td>	
							</tr>	
						</tbody>
					</table>
					
				  <?php
				}
				else
				{ ?>
					<table class="width_100">	
						<tbody>	
							<tr>
								<td>
									<h3  class="entry_lable"><?php _e('Expense Entries','gym_mgt');?></h3>
								</td>	
							</tr>	
						</tbody>
					</table>	
					 
				<?php 	
				}
			   ?>
					
				<table class="table table-bordered" class="width_93" border="1">
					<thead class="entry_heading">
						<?php
						if($_POST['invoice_type']=='membership_invoice')
						{
						?>
							<tr>
								<th class="color_white align_center">#</th>
								<th class="color_white align_center"> <?php _e('DATE','gym_mgt');?></th>
								<th class="width_40 color_white"><?php _e('Fees Type','gym_mgt');?> </th>
								<th style="color:white; align_right"><?php _e('Amount','gym_mgt');?></th>								
							</tr>	
						<?php
						}
						elseif($_POST['invoice_type']=='sell_invoice')
						{  
						?>
							<tr>
								<th class="color_white align_center">#</th>
								<th class="color_white align_center"> <?php _e('DATE','gym_mgt');?></th>
								<th class="width_40 color_white"><?php _e('PRODUCT NAME','gym_mgt');?> </th>
								<th class="width_3 color_white"><?php _e('QUANTITY','gym_mgt');?></th>
								<th class="color_white"><?php _e('PRICE','gym_mgt');?></th>
								<th class="color_white align_right"><?php _e('TOTAL','gym_mgt');?></th>								
							</tr>
						<?php 
						} 
						else
						{ 
						?>
							<tr>
								<th class="color_white align_center">#</th>
								<th class="color_white align_center"> <?php _e('DATE','gym_mgt');?></th>
								<th class="width_40 color_white"><?php _e('ENTRY','gym_mgt');?> </th>
								<th class="color_white align_right"><?php _e('Amount','gym_mgt');?></th>								
							</tr>	 
						<?php 
						}	
						?>
					</thead>
					<tbody>
						<?php 
							$id=1;
							$i=1;
							$total_amount=0;
						if(!empty($income_data) || !empty($expense_data))
						{
							if(!empty($expense_data))
								$income_data=$expense_data;							
							$member_income=$obj_payment->get_oneparty_income_data_incomeid($income_data->invoice_id);
							
							foreach($member_income as $result_income)
							{
								$income_entries=json_decode($result_income->entry);
								$discount_amount=$result_income->discount;
								$paid_amount=$result_income->paid_amount;
								$total_discount_amount= $result_income->amount - $discount_amount;
								
				                $total_tax=$total_discount_amount * $result_income->tax/100;
								
								$due_amount=0;
								$due_amount=$result_income->total_amount - $result_income->paid_amount;
								$grand_total=$total_discount_amount + $total_tax;
								
							   foreach($income_entries as $each_entry)
							   {
									$total_amount+=$each_entry->amount;
									?>
									<tr class="entry_list">
										<td class="align_center"><?php echo $id;?></td>
										<td class="align_center"><?php echo getdate_in_input_box($result_income->invoice_date);?></td>
										<td><?php echo $each_entry->entry; ?> </td>
										<td class="align_right"><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?> <?php echo round($each_entry->amount); ?></td>
									</tr>
									<?php
									$id+=1;
									$i+=1;
								}
								if($grand_total=='0')									
								{	
									if($income_data->payment_status=='Paid')
									{
										
										$grand_total=$total_amount;
										$paid_amount=$total_amount;
										$due_amount=0;										
									}
									else
									{
										
										$grand_total=$total_amount;
										$paid_amount=0;
										$due_amount=$total_amount;															
									}
								}
							}
						}
							
						if(!empty($membership_data))
						{
							$total_amount=$membership_data->total_amount;
							?>
							<tr class="entry_list">
								<td class="align_center"><?php echo $i;?></td> 
								<td class="align_center"><?php echo getdate_in_input_box($membership_data->created_date);?></td> 
								<td><?php echo get_membership_name($membership_data->membership_id);?></td>								
								<td class="align_right"><span><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span> <?php echo round($membership_data->membership_amount); ?></td>
							</tr>
							<?php
						}
						
						if(!empty($selling_data))
						{								
							$all_entry=json_decode($selling_data->entry);
							
							if(!empty($all_entry))
							{
								foreach($all_entry as $entry)
								{
									$obj_product=new MJ_Gmgtproduct;
									$product = $obj_product->get_single_product($entry->entry);
									
										$product_name=$product->product_name;					
										$quentity=$entry->quentity;	
										$price=$product->price;										
									?>
									<tr class="entry_list">										
										<td class="align_center"><?php echo $i;?></td> 
										<td class="align_center"><?php echo getdate_in_input_box($selling_data->sell_date);?></td>
										<td><?php echo $product_name;?> </td>
										<td  class="width_3"> <?php echo $quentity; ?></td>
										<td> <?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo $price; ?></td>
										<td class="align_right"> <?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo round($quentity * $price); ?></td>
									</tr>
								<?php 
								$id+=1;
								$i+=1;
								}
							}
							else
							{
								$obj_product=new MJ_Gmgtproduct;
								$product = $obj_product->get_single_product($selling_data->product_id); 
								
								$product_name=$product->product_name;					
								$quentity=$selling_data->quentity;	
								$price=$product->price;	
								?>
								<tr class="entry_list">										
									<td class="align_center"><?php echo $i;?></td> 
									<td class="align_center"><?php echo getdate_in_input_box($selling_data->sell_date);?></td>
									<td><?php echo $product_name;?> </td>
									<td  class="width_3"> <?php echo $quentity; ?></td>
									<td> <?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo $price; ?></td>
									<td class="align_right"> <?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo round($quentity * $price); ?></td>
								</tr>
								<?php
								$id+=1;
								$i+=1;
							}	
						}
							
						?>							
					</tbody>
				</table>
				<table class="width_54" border="0">
					<tbody>
						<?php 
						if(!empty($membership_data))
						{
							$total_amount=$membership_data->membership_amount;
							$paid_amount=$membership_data->paid_amount;
							$due_amount=$membership_data->membership_amount - $paid_amount;
							$grand_total=$membership_data->membership_amount;							
						}
						if(!empty($expense_data))
						{
							$grand_total=$total_amount;
						}
						if(!empty($selling_data))
						{
							$all_entry=json_decode($selling_data->entry);
							
							if(!empty($all_entry))
							{
								$total_amount=$selling_data->amount;
								$discount_amount=$selling_data->discount;
								$total_discount_amount=$total_amount-$discount_amount;
								$tax_per=$selling_data->tax;
								$total_tax=$total_discount_amount * $tax_per/100;
								$paid_amount=$selling_data->paid_amount;
								$due_amount=$selling_data->total_amount - $paid_amount;
								$grand_total=$selling_data->total_amount;
							}
							else
							{	
								$obj_product=new MJ_Gmgtproduct;
								$product = $obj_product->get_single_product($selling_data->product_id);
								$price=$product->price;	
								
								$total_amount=$price*$selling_data->quentity;
								$discount_amount=$selling_data->discount;
								$total_discount_amount=$total_amount-$discount_amount;
								$tax_per=$selling_data->tax;
								$total_tax=$total_discount_amount * $tax_per/100;
								$paid_amount=$total_amount;
								$due_amount='0';
								$grand_total=$total_amount;								
							}		
						}							
						?>
						<tr>
							<h4><td class="width_70 align_right"><h4 class="margin"><?php _e('Subtotal :','gym_mgt');?></h4></td>
							<td class="align_right"> <h4 class="margin"><span style=""><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span><?php echo round($total_amount);?></h4></td>
						</tr>
						<?php
						if($_POST['invoice_type']!='expense')
						{
							if($_POST['invoice_type']!='membership_invoice')
							{
							?>	
							<tr>
								<td class="width_70 align_right"><h4><?php _e('Discount Amount :','gym_mgt');?></h4></td>
								<td class="align_right"> <h4 class="margin"><span ><?php  echo "-";echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span><?php echo round($discount_amount); ?></h4></td>
							</tr>
							<tr>
								<td class="width_70 align_right"><h4><?php _e('Tax Amount :','gym_mgt');?></h4></td>
								<td class="align_right"><h4 class="margin"> <span ><?php  echo "+";echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span><?php echo round($total_tax); ?></h4></td>
							</tr>
							<?php
							}
							?>
							<tr>
								<td class="width_70 align_right"><h4><?php _e('Due Amount :','gym_mgt');?></h4></td>
								<td class="align_right"> <h4 class="margin"><span ><?php  echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span><?php echo round(abs($due_amount)); ?></h4></td>
							</tr>
							<tr>
								<td class="width_70 align_right"><h4><?php _e('Paid Amount :','gym_mgt');?></h4></td>
								<td class="align_right"> <h4 class="margin"><span ><?php  echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span><?php echo round($paid_amount); ?></h4></td>
							</tr>
						<?php
						}
						?>
						<tr>							
							<td class="width_70 align_right grand_total_lable"><h3 class="color_white margin"><?php _e('Grand Total :','gym_mgt');?></h3></td>
							<td class="align_right grand_total_amount"><h3 class="color_white margin">  <span><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?>  <?php echo round($grand_total); ?> </span></h3></td>
						</tr>							
					</tbody>
				</table>
				<?php
				if($_POST['invoice_type']!='expense')
				{
				?>		
				<table class="width_46" border="0">
					<tbody>						
						<tr>
							<td colspan="2">
								<h3 class="payment_method_lable"><?php _e('Payment Method','gym_mgt');?>
								</h3>
							</td>								
						</tr>							
						<tr>
							<td class="width_31 font_12"><?php _e('Bank Name ','gym_mgt');  ?></td>
							<td class="font_12">: <?php echo get_option( 'gmgt_bank_name' );?></td>
						</tr>
						<tr>
							<td class="width_31 font_12"><?php _e('Account No ','gym_mgt'); ?></td>
							<td class="font_12">: <?php echo get_option( 'gmgt_bank_acount_number' );?></td>
						</tr>
						
						<tr>
							<td class="width_31 font_12"><?php _e('IFSC Code ','gym_mgt'); ?></td>
							<td class="font_12">: <?php echo get_option( 'gmgt_bank_ifsc_code' );?></td>
						</tr>
						
						<tr>
							<td class="width_31 font_12"> <?php _e('Paypal ','gym_mgt'); ?></td>
							<td class="font_12">: <?php echo get_option( 'gmgt_paypal_email' );?></td>
						</tr>
					</tbody>
				</table>
				<?php
				}
				?>
			</div>
		</div>
		<div class="print-button pull-left">
			<a  href="?page=invoice&print=print&invoice_id=<?php echo $_POST['idtest'];?>&invoice_type=<?php echo $_POST['invoice_type'];?>" target="_blank"class="btn btn-success"><?php _e('Print','gym_mgt');?></a>
			<?php
			if($_POST['invoice_type']!='expense')
			{
			?>	
				<a  href="?page=invoice&pdf=pdf&invoice_id=<?php echo $_POST['idtest'];?>&invoice_type=<?php echo $_POST['invoice_type'];?>" target="_blank"class="btn btn-success"><?php _e('PDF','gym_mgt');?></a>			
			<?php
			}
			?>
		</div>
	</div>		
	<?php 
	die();
}
function gmgt_print_init()
{
	if(isset($_REQUEST['print']) && $_REQUEST['print'] == 'print' && $_REQUEST['page'] == 'invoice')
	{
		?>
		<script>window.onload = function(){ window.print(); };</script>
		<?php 
				
		gmgt_invoice_print($_REQUEST['invoice_id'],$_REQUEST['invoice_type']);
		exit;
	}			
}

add_action('init','gmgt_print_init');
//print invoice
function gmgt_invoice_print($invoice_id,$type)
{
	$obj_payment= new MJ_Gmgtpayment();
	if($type=='membership_invoice')
	{		
		$obj_membership_payment=new MJ_Gmgt_membership_payment;	
		$membership_data=$obj_membership_payment->get_single_membership_payment($invoice_id);
	}
	if($type=='income')
	{
		$income_data=$obj_payment->gmgt_get_income_data($invoice_id);
	}
	if($type=='expense')
	{
		$expense_data=$obj_payment->gmgt_get_income_data($invoice_id);
	}
	if($type=='sell_invoice')
	{
		$obj_store=new MJ_Gmgtstore;
		$selling_data=$obj_store->get_single_selling($invoice_id);
	}
  echo '<link rel="stylesheet" href="'.plugins_url( '/assets/css/custom.css', __FILE__).'"></link>';	
  echo '<link rel="stylesheet" href="'.plugins_url( '/assets/css/style.css', __FILE__).'"></link>';	
	?>	
	<div class="modal-header">
		<a href="#" class="close-btn badge badge-success pull-right">X</a>			
	</div>
	<div class="modal-body invoice_body">
		<div id="invoice_print1">
			<img class="invoicefont1" src="<?php echo plugins_url('/gym-management/assets/images/invoice.jpg'); ?>" width="100%">
			<div class="main_div">					
				<table class="width_100" border="0">					
					<tbody>
						<tr>
							<td class="width_1">
								<img class="system_logo" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">
							</td>							
							<td class="only_width_20">
								<?php
								 echo "A. ".chunk_split(get_option( 'gmgt_gym_address' ),30,"<BR>"); 
								 echo "E. ".get_option( 'gmgt_email' )."<br>"; 
								 echo "P. " .get_option( 'gmgt_contact_number' )."<br>"; 
								?> 
							</td>
							<td align="right" class="width_24">
							</td>
						</tr>
					</tbody>
				</table>
				<table class="width_50" border="0">
					<tbody>				
						<tr>
							<td colspan="2"  class="billed_to" align="center">								
								<h3 class="billed_to_lable"><?php _e('| Bill To.','gym_mgt');?> </h3>
							</td>
							<td class="width_40">								
							<?php 
								if(!empty($expense_data))
								{
								   echo "<h3 class='display_name'>".chunk_split(ucwords($expense_data->supplier_name),30,"<BR>"). "</h3>"; 
								}
								else
								{
									if(!empty($income_data))
										$member_id=$income_data->supplier_name;
									 if(!empty($membership_data))
										$member_id=$membership_data->member_id;
									 if(!empty($selling_data))
										$member_id=$selling_data->member_id;
									$patient=get_userdata($member_id);
									 echo "<h3 style='font-weight: bold;'>".chunk_split(ucwords($patient->display_name),30,"<BR>"). "</h3>"; 
									 $address=get_user_meta( $member_id,'address',true);
									 echo chunk_split($address,30,"<BR>"); 	
									 echo get_user_meta( $member_id,'city_name',true ).","; 
									 echo get_user_meta( $member_id,'zip_code',true )."<br>"; 
									echo get_user_meta( $member_id,'mobile',true )."<br>"; 
								}
							?>			
							</td>
						</tr>									
					</tbody>
				</table>
					<?php 
					$issue_date='DD-MM-YYYY';
					if(!empty($income_data))
					{
						$issue_date=$income_data->invoice_date;
						$payment_status=$income_data->payment_status;
						$invoice_no=$income_data->invoice_no;
					}
					if(!empty($membership_data))
					{
						$issue_date=$membership_data->created_date;
						if($membership_data->payment_status!='0')
						{	
							$payment_status=$membership_data->payment_status;
						}
						else
						{
							$payment_status='Unpaid';
						}			
						$invoice_no=$membership_data->invoice_no;
					}
					if(!empty($expense_data))
					{
						$issue_date=$expense_data->invoice_date;
						$payment_status=$expense_data->payment_status;
						$invoice_no=$expense_data->invoice_no;
					}
					if(!empty($selling_data))
					{
						$issue_date=$selling_data->sell_date;						
						if(!empty($selling_data->payment_status))
						{
							$payment_status=$selling_data->payment_status;
						}	
						else
						{
							$payment_status='Fully Paid';
						}	
						$invoice_no=$selling_data->invoice_no;
					} 
					?>
				<table class="width_50" border="0">
					<tbody>				
						<tr>	
							<td class="width_30">
							</td>
							<td class="width_20" style="padding-right:30px;" align="left">
								<?php
								if($type!='expense')
								{
								?>	
									<h3 class="invoice_color"><?php echo __('INVOICE','gym_mgt')." </br> #".$invoice_no;?></h3>								
								<?php
								}
								?>								
								<h5 class="invoice_date_status"> <?php   echo __('Date','gym_mgt')." : ".getdate_in_input_box($issue_date);?></h5>
								<h5 class="invoice_date_status"><?php echo __('Status','gym_mgt')." : ". __($payment_status,'gym_mgt');?></h5>									
							</td>							
						</tr>									
					</tbody>
				</table>						
				<?php
				if($type=='membership_invoice')
				{ 
				?>	
					<table class="width_100">	
						<tbody>	
							<tr>
								<td>
									<h3  class="entry_lable"><?php _e('Membership Entries','gym_mgt');?></h3>
								</td>	
							</tr>	
						</tbody>
					</table>	
					
				<?php 	
				}				
				elseif($type=='income')
				{ 
				?>	
					<table class="width_100">	
						<tbody>	
							<tr>
								<td>
									<h3  class="entry_lable"><?php _e('Income Entries','gym_mgt');?></h3>
								</td>	
							</tr>	
						</tbody>
					</table>
				
				<?php 	
				}
				elseif($type=='sell_invoice')
				{ 
				   ?>
				   <table class="width_100">	
						<tbody>	
							<tr>
								<td>
									<h3  class="entry_lable"><?php _e('Sells Product','gym_mgt');?></h3>
								</td>	
							</tr>	
						</tbody>
					</table>
					
				  <?php
				}
				else
				{ ?>
					<table class="width_100">	
						<tbody>	
							<tr>
								<td>
									<h3  class="entry_lable"><?php _e('Expense Entries','gym_mgt');?></h3>
								</td>	
							</tr>	
						</tbody>
					</table>	
					 
				<?php 	
				}
			   ?>
					
				<table class="table table-bordered width_100" class="width_93" border="1">
					<thead class="entry_heading_print">
						<?php
						if($type=='membership_invoice')
						{
						?>
							<tr>
								<th class="color_white align_center">#</th>
								<th class="color_white align_center"> <?php _e('DATE','gym_mgt');?></th>
								<th class="width_40 color_white"><?php _e('Fees Type','gym_mgt');?> </th>
								<th style="color:white; align_right"><?php _e('Amount','gym_mgt');?></th>								
							</tr>	
						<?php
						}
						elseif($type=='sell_invoice')
						{  
						?>
							<tr>
								<th class="color_white align_center">#</th>
								<th class="color_white align_center"> <?php _e('DATE','gym_mgt');?></th>
								<th class="width_40 color_white"><?php _e('PRODUCT NAME','gym_mgt');?> </th>
								<th class="width_3 color_white"><?php _e('QUANTITY','gym_mgt');?></th>
								<th class="color_white"><?php _e('PRICE','gym_mgt');?></th>
								<th class="color_white align_right"><?php _e('TOTAL','gym_mgt');?></th>								
							</tr>
						<?php 
						} 
						else
						{ 
						?>
							<tr>
								<th class="color_white align_center">#</th>
								<th class="color_white align_center"> <?php _e('DATE','gym_mgt');?></th>
								<th class="width_40 color_white"><?php _e('ENTRY','gym_mgt');?> </th>
								<th class="color_white align_right"><?php _e('Amount','gym_mgt');?></th>								
							</tr>	 
						<?php 
						}	
						?>
					</thead>
					<tbody>
						<?php 
							$id=1;
							$i=1;
							$total_amount=0;
						if(!empty($income_data) || !empty($expense_data))
						{
							if(!empty($expense_data))
								$income_data=$expense_data;							
							$member_income=$obj_payment->get_oneparty_income_data_incomeid($income_data->invoice_id);
							
							foreach($member_income as $result_income)
							{
								$income_entries=json_decode($result_income->entry);
								$discount_amount=$result_income->discount;
								$paid_amount=$result_income->paid_amount;
								$total_discount_amount= $result_income->amount - $discount_amount;
								
				                $total_tax=$total_discount_amount * $result_income->tax/100;
								
								$due_amount=0;
								$due_amount=$result_income->total_amount - $result_income->paid_amount;
								$grand_total=$total_discount_amount + $total_tax;
								
							   foreach($income_entries as $each_entry)
							   {
									$total_amount+=$each_entry->amount;
									?>
									<tr class="entry_list">
										<td class="align_center"><?php echo $id;?></td>
										<td class="align_center"><?php echo getdate_in_input_box($result_income->invoice_date);?></td>
										<td><?php echo $each_entry->entry; ?> </td>
										<td class="align_right"><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?> <?php echo round($each_entry->amount); ?></td>
									</tr>
									<?php $id+=1;
									$i+=1;
								}
								if($grand_total=='0')									
								{
									if($income_data->payment_status=='Paid')
									{
										
										$grand_total=$total_amount;
										$paid_amount=$total_amount;
										$due_amount=0;										
									}
									else
									{
										
										$grand_total=$total_amount;
										$paid_amount=0;
										$due_amount=$total_amount;															
									}
								}
							}
						}
							
						if(!empty($membership_data))
						{
							$total_amount=$membership_data->total_amount;
							?>
							<tr class="entry_list">
								<td class="align_center"><?php echo $i;?></td> 
								<td class="align_center"><?php echo getdate_in_input_box($membership_data->created_date);?></td> 
								<td><?php echo get_membership_name($membership_data->membership_id);?></td>								
								<td class="align_right"><span><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span> <?php echo round($membership_data->membership_amount); ?></td>
							</tr>
							<?php
						}
						if(!empty($selling_data))
						{
								
							$all_entry=json_decode($selling_data->entry);
							
							if(!empty($all_entry))
							{
								foreach($all_entry as $entry)
								{
									$obj_product=new MJ_Gmgtproduct;
									$product = $obj_product->get_single_product($entry->entry);
									
									$product_name=$product->product_name;					
									$quentity=$entry->quentity;	
									$price=$product->price;	
									
									?>
									<tr class="entry_list">										
										<td class="align_center"><?php echo $i;?></td> 
										<td class="align_center"><?php echo getdate_in_input_box($selling_data->sell_date);?></td>
										<td><?php echo $product_name;?> </td>
										<td  class="width_3"> <?php echo $quentity; ?></td>
										<td> <?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo $price; ?></td>
										<td class="align_right"> <?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo round($quentity * $price); ?></td>
									</tr>
								<?php 
								$id+=1;
								$i+=1;
								}
							}
							else
							{
								$obj_product=new MJ_Gmgtproduct;
								$product = $obj_product->get_single_product($selling_data->product_id); 
								
								$product_name=$product->product_name;					
								$quentity=$selling_data->quentity;	
								$price=$product->price;	
								?>
								<tr class="entry_list">										
									<td class="align_center"><?php echo $i;?></td> 
									<td class="align_center"><?php echo getdate_in_input_box($selling_data->sell_date);?></td>
									<td><?php echo $product_name;?> </td>
									<td  class="width_3"> <?php echo $quentity; ?></td>
									<td> <?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo $price; ?></td>
									<td class="align_right"> <?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo round($quentity * $price); ?></td>
								</tr>
								<?php
								$id+=1;
								$i+=1;
							}		
						}
						?>							
					</tbody>
				</table>
				<table class="width_54" border="0">
					<tbody>
						<?php 
						if(!empty($membership_data))
						{
							$total_amount=$membership_data->membership_amount;
							$paid_amount=$membership_data->paid_amount;
							$due_amount=$membership_data->membership_amount - $paid_amount;
							$grand_total=$membership_data->membership_amount;
							
						}
						if(!empty($expense_data))
						{
							$grand_total=$total_amount;
						}
						if(!empty($selling_data))
						{
							$all_entry=json_decode($selling_data->entry);
							
							if(!empty($all_entry))
							{
								$total_amount=$selling_data->amount;
								$discount_amount=$selling_data->discount;
								$total_discount_amount=$total_amount-$discount_amount;
								$tax_per=$selling_data->tax;
								$total_tax=$total_discount_amount * $tax_per/100;
								$paid_amount=$selling_data->paid_amount;
								$due_amount=$selling_data->total_amount - $paid_amount;
								$grand_total=$selling_data->total_amount;
							}
							else
							{
								$obj_product=new MJ_Gmgtproduct;
								$product = $obj_product->get_single_product($selling_data->product_id); 								
								
								$price=$product->price;	
								
								$total_amount=$price*$selling_data->quentity;
								$discount_amount=$selling_data->discount;
								$total_discount_amount=$total_amount-$discount_amount;
								$tax_per=$selling_data->tax;
								$total_tax=$total_discount_amount * $tax_per/100;
								$paid_amount=$total_amount;
								$due_amount='0';
								$grand_total=$total_amount;
							}
							
						}							
						?>
						<tr>
							<h4><td class="width_70 align_right"><h4 class="margin"><?php _e('Subtotal :','gym_mgt');?></h4></td>
							<td class="align_right"> <h4 class="margin"><span style=""><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span><?php echo round($total_amount);?></h4></td>
						</tr>
						<?php
						if($type!='expense')
						{
							if($type!='membership_invoice')
							{
							?>	
							<tr>
								<td class="width_70 align_right"><h4 class="margin"><?php _e('Discount Amount :','gym_mgt');?></h4></td>
								<td class="align_right"> <h4 class="margin"><span ><?php  echo "-";echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span><?php echo round($discount_amount); ?></h4></td>
							</tr>
							<tr>
								<td class="width_70 align_right"><h4 class="margin"><?php _e('Tax Amount :','gym_mgt');?></h4></td>
								<td class="align_right"><h4 class="margin"> <span ><?php  echo "+";echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span><?php echo round($total_tax); ?></h4></td>
							</tr>
							<?php
							}
							?>
							<tr>
								<td class="width_70 align_right"><h4 class="margin"><?php _e('Due Amount :','gym_mgt');?></h4></td>
								<td class="align_right"> <h4 class="margin"><span ><?php  echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span><?php echo round(abs($due_amount)); ?></h4></td>
							</tr>
							<tr>
								<td class="width_70 align_right"><h4 class="margin"><?php _e('Paid Amount :','gym_mgt');?></h4></td>
								<td class="align_right"> <h4 class="margin"><span ><?php  echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span><?php echo round($paid_amount); ?></h4></td>
							</tr>
						<?php
						}
						?>
						<tr>							
							<td class="width_70 align_right grand_total_lable1"><h3 class="color_white margin"><?php _e('Grand Total :','gym_mgt');?></h3></td>
							<td class="align_right grand_total_amount1"><h3 class="color_white margin">  <span><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?>  <?php echo round($grand_total); ?> </span></h3></td>
						</tr>							
					</tbody>
				</table>
				<?php
				if($type!='expense')
				{
				?>		
				<table class="width_46" border="0">
					<tbody>						
						<tr>
							<td colspan="2">
								<h3 class="payment_method_lable"><?php _e('Payment Method','gym_mgt');?>
								</h3>
							</td>								
						</tr>							
						<tr>
							<td class="width_31 font_12"><?php _e('Bank Name ','gym_mgt');  ?></td>
							<td class="font_12">: <?php echo get_option( 'gmgt_bank_name' );?></td>
						</tr>
						<tr>
							<td class="width_31 font_12"><?php _e('Account No ','gym_mgt'); ?></td>
							<td class="font_12">: <?php echo get_option( 'gmgt_bank_acount_number' );?></td>
						</tr>
						
						<tr>
							<td class="width_31 font_12"><?php _e('IFSC Code ','gym_mgt'); ?></td>
							<td class="font_12">: <?php echo get_option( 'gmgt_bank_ifsc_code' );?></td>
						</tr>
						
						<tr>
							<td class="width_31 font_12"> <?php _e('Paypal ','gym_mgt'); ?></td>
							<td class="font_12">: <?php echo get_option( 'gmgt_paypal_email' );?></td>
						</tr>
					</tbody>
				</table>
				<?php
				}
				?>
			</div>
		</div>
	<?php
	die();
}
// pdf fuction call on init
function gmgt_pdf_init()
{
	if (is_user_logged_in ()) 
	{
		if(isset($_REQUEST['pdf']) && $_REQUEST['pdf'] == 'pdf')
		{			
			gmgt_invoice_pdf($_REQUEST['invoice_id'],$_REQUEST['invoice_type']);
			exit;
		}	
	}
}
add_action('init','gmgt_pdf_init');

// invoice pdf
function gmgt_invoice_pdf($id,$type)
{
	error_reporting(0);
	$obj_payment= new MJ_Gmgtpayment();
	if($type=='membership_invoice')
	{		
		$obj_membership_payment=new MJ_Gmgt_membership_payment;	
		$membership_data=$obj_membership_payment->get_single_membership_payment($id);
	}
	if($type=='income')
	{
		$income_data=$obj_payment->gmgt_get_income_data($id);
	}
	{
	if($type=='expense')
		$expense_data=$obj_payment->gmgt_get_income_data($id);
	}
	if($type=='sell_invoice')
	{
		$obj_store=new MJ_Gmgtstore;
		$selling_data=$obj_store->get_single_selling($id);
	}
    echo '<link rel="stylesheet" href="'.plugins_url( '/assets/css/bootstrap.min.css', __FILE__).'"></link>';
    echo '<script  rel="javascript" src="'.plugins_url( '/assets/js/bootstrap.min.js', __FILE__).'"></script>';
	ob_clean();
	header('Content-type: application/pdf');
	header('Content-Disposition: inline; filename="invoice.pdf"');
	header('Content-Transfer-Encoding: binary');
	header('Accept-Ranges: bytes');	
	require GMS_PLUGIN_DIR. '/lib/mpdf/mpdf.php';	
	$stylesheet = file_get_contents(GMS_PLUGIN_DIR. '/assets/css/custom.css'); // Get css content
	$stylesheet1 = file_get_contents(GMS_PLUGIN_DIR. '/assets/css/style.css'); // Get css content
    $mpdf	=	new mPDF('c','A4','','' , 5 , 5 , 5 , 0 , 0 , 0); 
	$mpdf->debug = true;
	$mpdf->WriteHTML('<html>');
	$mpdf->WriteHTML('<head>');
	$mpdf->WriteHTML('<style></style>');
	$mpdf->WriteHTML($stylesheet,1); // Writing style to pdf
	$mpdf->WriteHTML($stylesheet1,1); // Writing style to pdf
	$mpdf->WriteHTML('</head>');
	$mpdf->WriteHTML('<body>');		
	$mpdf->SetTitle('Income Invoice');
	
		$mpdf->WriteHTML('<div id="invoice_print">');		
			$mpdf->WriteHTML('<img class="invoicefont1" src="'.plugins_url('/gym-management/assets/images/invoice.jpg').'" width="100%">');
			$mpdf->WriteHTML('<div class="main_div">');	
			
					$mpdf->WriteHTML('<table class="width_100_print" border="0">');					
					$mpdf->WriteHTML('<tbody>');
						$mpdf->WriteHTML('<tr>');
							$mpdf->WriteHTML('<td class="width_1_print">');
								$mpdf->WriteHTML('<img class="system_logo"  src="'.get_option( 'gmgt_system_logo' ).'">');
							$mpdf->WriteHTML('</td>');							
							$mpdf->WriteHTML('<td class="only_width_20_print">');								
								$mpdf->WriteHTML(''.__('A','gym_mgt').'. '.chunk_split(get_option('gmgt_gym_address'),30,"<BR>").'<br>'); 
								 $mpdf->WriteHTML(''.__('E','gym_mgt').'. '.get_option( 'gmgt_email' ).'<br>'); 
								 $mpdf->WriteHTML(''.__('P','gym_mgt').'. '.get_option( 'gmgt_contact_number' ).'<br>'); 
							$mpdf->WriteHTML('</td>');
							$mpdf->WriteHTML('<td align="right" class="width_24">');
							$mpdf->WriteHTML('</td>');
						$mpdf->WriteHTML('</tr>');
					$mpdf->WriteHTML('</tbody>');
				$mpdf->WriteHTML('</table>');
				
				$mpdf->WriteHTML('<table>');
			 $mpdf->WriteHTML('<tr>');
				$mpdf->WriteHTML('<td>');
				
					$mpdf->WriteHTML('<table class="width_50_print"  border="0">');
						$mpdf->WriteHTML('<tbody>');				
						$mpdf->WriteHTML('<tr>');
							$mpdf->WriteHTML('<td colspan="2" class="billed_to_print" align="center">');								
								$mpdf->WriteHTML('<h3 class="billed_to_lable"> | '.__('Bill To','gym_mgt').'. </h3>');
							$mpdf->WriteHTML('</td>');
							$mpdf->WriteHTML('<td class="width_40_print">');								
							
								if(!empty($expense_data))
								{
								  $mpdf->WriteHTML('<h3 class="display_name">'.chunk_split(ucwords($expense_data->supplier_name),30,"<BR>").'</h3>'); 
								}
								else
								{
									if(!empty($income_data))
										$member_id=$income_data->supplier_name;
									 if(!empty($membership_data))
										$member_id=$membership_data->member_id;
									 if(!empty($selling_data))
										$member_id=$selling_data->member_id;
									$patient=get_userdata($member_id);
									
									$mpdf->WriteHTML('<h3 class="display_name">'.chunk_split(ucwords($patient->display_name),30,"<BR>").'</h3>'); 
									 $address=get_user_meta( $member_id,'address',true);									
									 $mpdf->WriteHTML(''.chunk_split($address,30,"<BR>").''); 
									  $mpdf->WriteHTML(''.get_user_meta( $member_id,'city_name',true ).','); 
									 $mpdf->WriteHTML(''.get_user_meta( $member_id,'zip_code',true ).'<br>'); 
									 $mpdf->WriteHTML(''.get_user_meta( $member_id,'mobile',true ).'<br>'); 
								}
									
							 $mpdf->WriteHTML('</td>');
						 $mpdf->WriteHTML('</tr>');									
					 $mpdf->WriteHTML('</tbody>');
				 $mpdf->WriteHTML('</table>');
				
				$mpdf->WriteHTML('</td>');
				$mpdf->WriteHTML('<td>');
				
				   $mpdf->WriteHTML('<table class="width_50_print"  border="0">');
					 $mpdf->WriteHTML('<tbody>');				
						 $mpdf->WriteHTML('<tr>');	
							 $mpdf->WriteHTML('<td class="width_30_print">');
							 $mpdf->WriteHTML('</td>');
							 $mpdf->WriteHTML('<td class="width_20_print invoice_lable" style="padding-right:30px;" align="left">');
								
								$issue_date='DD-MM-YYYY';
								if(!empty($income_data))
								{
									$issue_date=$income_data->invoice_date;
									$payment_status=$income_data->payment_status;
									$invoice_no=$income_data->invoice_no;
								}
								if(!empty($membership_data))
								{
									$issue_date=$membership_data->created_date;
									$payment_status=$membership_data->payment_status;
									$invoice_no=$membership_data->invoice_no;									
								}
								if(!empty($expense_data))
								{
									$issue_date=$expense_data->invoice_date;
									$payment_status=$expense_data->payment_status;
									$invoice_no=$expense_data->invoice_no;
								}
								if(!empty($selling_data))
								{
									$issue_date=$selling_data->sell_date;									
									if(!empty($selling_data->payment_status))
									{
										$payment_status=$selling_data->payment_status;
									}	
									else
									{
										$payment_status='Fully Paid';
									}	
									$invoice_no=$selling_data->invoice_no;
								} 
								
								if($type!='expense')
								{								
									$mpdf->WriteHTML('<h3>'.__('INVOICE','gym_mgt').' <br> #'.$invoice_no.'</h3>');										
								}																			
							 $mpdf->WriteHTML('</td>');							
						 $mpdf->WriteHTML('</tr>');
						 $mpdf->WriteHTML('<tr>');	
							 $mpdf->WriteHTML('<td class="width_30_print">');
							 $mpdf->WriteHTML('</td>');
							 $mpdf->WriteHTML('<td class="width_20_print" style="padding-right:30px;" align="left">');
								$mpdf->WriteHTML('<h5>'.__('Date','gym_mgt').' : '.getdate_in_input_box($issue_date).'</h5>');
							$mpdf->WriteHTML('<h5>'.__('Status','gym_mgt').' : '.__(''.$payment_status.'','gym_mgt').'</h5>');											
							 $mpdf->WriteHTML('</td>');							
						 $mpdf->WriteHTML('</tr>');						
					 $mpdf->WriteHTML('</tbody>');
				 $mpdf->WriteHTML('</table>');	
				$mpdf->WriteHTML('</td>');
			  $mpdf->WriteHTML('</tr>');
			$mpdf->WriteHTML('</table>');
			
				if($type=='membership_invoice')
				{	
					$mpdf->WriteHTML('<table class="width_100_print">');	
						$mpdf->WriteHTML('<tbody>');	
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td style="padding-left:20px;">');
									$mpdf->WriteHTML('<h3 class="entry_lable">'.__('Membership Entries','gym_mgt').'</h3>');
								$mpdf->WriteHTML('</td>');	
							$mpdf->WriteHTML('</tr>');	
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');				
					
				}		
				elseif($type=='income')
				{ 
					$mpdf->WriteHTML('<table class="width_100_print">');	
						$mpdf->WriteHTML('<tbody>');	
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td style="padding-left:20px;">');
									$mpdf->WriteHTML('<h3 class="entry_lable">'.__('Income Entries','gym_mgt').'</h3>');
								$mpdf->WriteHTML('</td>');	
							$mpdf->WriteHTML('</tr>');	
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');
				
				}
				elseif($type=='sell_invoice')
				{ 
				  $mpdf->WriteHTML('<table class="width_100_print">');	
						$mpdf->WriteHTML('<tbody>');	
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td style="padding-left:20px;">');
									$mpdf->WriteHTML('<h3 class="entry_lable">'.__('Sells Product','gym_mgt').'</h3>');
								$mpdf->WriteHTML('</td>');	
							$mpdf->WriteHTML('</tr>');	
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');
				  
				}
				else
				{ 
					$mpdf->WriteHTML('<table class="width_100_print">');	
						$mpdf->WriteHTML('<tbody>');	
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td style="padding-left:20px;">');
									$mpdf->WriteHTML('<h3 class="entry_lable">'.__('Expense Entries','gym_mgt').'</h3>');
								$mpdf->WriteHTML('</td>');	
							$mpdf->WriteHTML('</tr>');	
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');	
				}		  
					
				$mpdf->WriteHTML('<table class="table table-bordered" class="width_93" border="1">');
					$mpdf->WriteHTML('<thead>');
						
						if($type=='membership_invoice')
						{						
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center">#</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center">DATE'.__('Bill To','gym_mgt').'</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_left">Fees Type'.__('Bill To','gym_mgt').'</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right">Amount'.__('Bill To','gym_mgt').'</th>');								
							$mpdf->WriteHTML('</tr>');
						}
						elseif($type=='sell_invoice')
						{  
						
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center">#</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.__('DATE','gym_mgt').'</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_left">'.__('PRODUCT NAME','gym_mgt').'</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_left">'.__('QUANTITY','gym_mgt').'</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_left">'.__('PRICE','gym_mgt').'</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right">'.__('TOTAL','gym_mgt').'</th>');
								
							$mpdf->WriteHTML('</tr>');
						
						} 
						else
						{ 						
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center">#</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.__('DATE','gym_mgt').'</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_left">'.__('ENTRY','gym_mgt').'</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right">'.__('Amount','gym_mgt').'</th>');								
							$mpdf->WriteHTML('</tr>');
						}	
						
					$mpdf->WriteHTML('</thead>');
					$mpdf->WriteHTML('<tbody>');
						
							$id=1;
							$i=1;
							$total_amount=0;
						if(!empty($income_data) || !empty($expense_data))
						{
							if(!empty($expense_data))
								$income_data=$expense_data;
						
							$member_income=$obj_payment->get_oneparty_income_data_incomeid($income_data->invoice_id);
							
							foreach($member_income as $result_income)
							{
								$income_entries=json_decode($result_income->entry);
								$discount_amount=$result_income->discount;
								$paid_amount=$result_income->paid_amount;
								$total_discount_amount= $result_income->amount - $discount_amount;
								
				                $total_tax=$total_discount_amount * $result_income->tax/100;
								
								$due_amount=0;
								$due_amount=$result_income->total_amount - $result_income->paid_amount;
								$grand_total=$total_discount_amount + $total_tax;
								
							   foreach($income_entries as $each_entry)
							   {
									$total_amount+=$each_entry->amount;
									
									$mpdf->WriteHTML('<tr class="entry_list">');
										$mpdf->WriteHTML('<td class="align_center">'.$id.'</td>');
										$mpdf->WriteHTML('<td class="align_center">'.getdate_in_input_box($result_income->invoice_date).'</td>');
										$mpdf->WriteHTML('<td >'.$each_entry->entry.'</td>');
										$mpdf->WriteHTML('<td class="align_right">'.gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).''.round($each_entry->amount).'</td>');
									$mpdf->WriteHTML('</tr>');
									 $id+=1;
									$i+=1;
								}
								if($grand_total=='0')									
								{
									if($income_data->payment_status=='Paid')
									{
										
										$grand_total=$total_amount;
										$paid_amount=$total_amount;
										$due_amount=0;										
									}
									else
									{
										
										$grand_total=$total_amount;
										$paid_amount=0;
										$due_amount=$total_amount;															
									}
								}
							}
						}
						
						if(!empty($membership_data))
						{
							$total_amount=$membership_data->total_amount;
							
							$mpdf->WriteHTML('<tr class="entry_list">');
								$mpdf->WriteHTML('<td class="align_center">'.$i.'</td>'); 
								$mpdf->WriteHTML('<td class="align_center">'.getdate_in_input_box($membership_data->created_date).'</td>'); 
								$mpdf->WriteHTML('<td>'.get_membership_name($membership_data->membership_id).'</td>');								
								$mpdf->WriteHTML('<td class="align_right"><span>'.gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.round($membership_data->membership_amount).'</td>');
							$mpdf->WriteHTML('</tr>');
							
						}
						if(!empty($selling_data))
						{
								
							$all_entry=json_decode($selling_data->entry);
							
							if(!empty($all_entry))
							{
								foreach($all_entry as $entry)
								{
									$obj_product=new MJ_Gmgtproduct;
									$product = $obj_product->get_single_product($entry->entry);
									
									$product_name=$product->product_name;					
									$quentity=$entry->quentity;	
									$price=$product->price;	
									
									
									$mpdf->WriteHTML('<tr class="entry_list">');										
										$mpdf->WriteHTML('<td class="align_center">'.$i.'</td> ');
										$mpdf->WriteHTML('<td class="align_center">'.getdate_in_input_box($selling_data->sell_date).'</td>');
										$mpdf->WriteHTML('<td>'.$product_name.'</td>');
										$mpdf->WriteHTML('<td>'.$quentity.'</td>');
										$mpdf->WriteHTML('<td>'.gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).''.$price.'</td>');
										$mpdf->WriteHTML('<td class="align_right">'.gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).''.round($quentity * $price).'</td>');
										
									$mpdf->WriteHTML('</tr>');		
								$id+=1;
								$i+=1;									
								}
							}
							else
							{
								$obj_product=new MJ_Gmgtproduct;
								$product = $obj_product->get_single_product($selling_data->product_id); 
								
								$product_name=$product->product_name;					
								$quentity=$selling_data->quentity;	
								$price=$product->price;	
								
								$mpdf->WriteHTML('<tr class="entry_list">');										
									$mpdf->WriteHTML('<td class="align_center">'.$i.'</td> ');
									$mpdf->WriteHTML('<td class="align_center">'.getdate_in_input_box($selling_data->sell_date).'</td>');
									$mpdf->WriteHTML('<td>'.$product_name.'</td>');
									$mpdf->WriteHTML('<td>'.$quentity.'</td>');
									$mpdf->WriteHTML('<td>'.gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).''.$price.'</td>');
									$mpdf->WriteHTML('<td class="align_right">'.gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).''.round($quentity * $price).'</td>');
									
								$mpdf->WriteHTML('</tr>');	
								
								$id+=1;
								$i+=1;
							}	
						}
										
					$mpdf->WriteHTML('</tbody>');
				$mpdf->WriteHTML('</table>');
				
				$mpdf->WriteHTML('<table>');
				 $mpdf->WriteHTML('<tr>');
				 $mpdf->WriteHTML('<td>');
					  $mpdf->WriteHTML('<table class="width_46_print" border="0">');
						$mpdf->WriteHTML('<tbody>');						
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td colspan="2" style="padding-left:15px;">');
									$mpdf->WriteHTML('<h3 class="payment_method_lable">'.__('Payment Method','gym_mgt').'');
								$mpdf->WriteHTML('</h3>');
								$mpdf->WriteHTML('</td>');								
							$mpdf->WriteHTML('</tr>');							
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td  class="width_31 font_12">'.__('Bank Name ','gym_mgt').' </td>');
								$mpdf->WriteHTML('<td class="font_12">: '.get_option( 'gmgt_bank_name' ).'</td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_31 font_12">'.__('Account No ','gym_mgt').'</td>');
								$mpdf->WriteHTML('<td class="font_12">: '.get_option( 'gmgt_bank_acount_number' ).'</td>');
							$mpdf->WriteHTML('</tr>');						
						$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_31 font_12">'.__('IFSC Code ','gym_mgt').' </td>');
								$mpdf->WriteHTML('<td class="font_12">: '.get_option( 'gmgt_bank_ifsc_code' ).'</td>');
							$mpdf->WriteHTML('</tr>');						
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_31 font_12">'.__('Paypal ','gym_mgt').' </td>');
								$mpdf->WriteHTML('<td class="font_12">: '.get_option( 'gmgt_paypal_email' ).'</td>');
							$mpdf->WriteHTML('</tr>');
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>'); 
					$mpdf->WriteHTML('</td>');
					$mpdf->WriteHTML('<td>');
					$mpdf->WriteHTML('<table class="width_54_print"  border="0">');
					$mpdf->WriteHTML('<tbody>');
						
						if(!empty($membership_data))
						{
							$total_amount=$membership_data->membership_amount;
							$paid_amount=$membership_data->paid_amount;
							$due_amount=$membership_data->membership_amount - $paid_amount;
							$grand_total=$membership_data->membership_amount;
							
						}
						if(!empty($expense_data))
						{
							$grand_total=$total_amount;
						} 
						if(!empty($selling_data))
						{
							$all_entry=json_decode($selling_data->entry);
							
							if(!empty($all_entry))
							{
								$total_amount=$selling_data->amount;
								$discount_amount=$selling_data->discount;
								$total_discount_amount=$total_amount-$discount_amount;
								$tax_per=$selling_data->tax;
								$total_tax=$total_discount_amount * $tax_per/100;
								$paid_amount=$selling_data->paid_amount;
								$due_amount=$selling_data->total_amount - $paid_amount;
								$grand_total=$selling_data->total_amount;
							}
							else
							{
								$obj_product=new MJ_Gmgtproduct;
								$product = $obj_product->get_single_product($selling_data->product_id); 								
								
								$price=$product->price;	
								
								$total_amount=$price*$selling_data->quentity;
								$discount_amount=$selling_data->discount;
								$total_discount_amount=$total_amount-$discount_amount;
								$tax_per=$selling_data->tax;
								$total_tax=$total_discount_amount * $tax_per/100;
								$paid_amount=$total_amount;
								$due_amount='0';
								$grand_total=$total_amount;
							}
							
						}		
						$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<h4><td  class="width_70 align_right"><h4 class="margin">'.__('Subtotal :','gym_mgt').'</h4></td>');
								$mpdf->WriteHTML('<td class="align_right"> <h4 class="margin"><span style="">'.gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.round($total_amount).'</h4></td>');
							$mpdf->WriteHTML('</tr>');
						if($type!='membership_invoice')
						{
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_70 align_right"><h4 class="margin">'.__('Discount Amount','gym_mgt').' </h4></td>');
								$mpdf->WriteHTML('<td class="align_right"><h4 class="margin"> <span >+ '.gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.round($discount_amount).'</h4></td>');
							$mpdf->WriteHTML('</tr>'); 
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_70 align_right"><h4 class="margin">'.__('Tax Amount :','gym_mgt').' </h4></td>');
								$mpdf->WriteHTML('<td class="align_right"><h4 class="margin"> <span >+ '.gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.round($total_tax).'</h4></td>');
							$mpdf->WriteHTML('</tr>');
						}
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_70 align_right"><h4 class="margin">'.__('Due Amount :','gym_mgt').' </h4></td>');
								$mpdf->WriteHTML('<td class="align_right"> <h4 class="margin"><span >'.gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.round(abs($due_amount)).'</h4></td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_70 align_right"><h4 class="margin">'.__('Paid Amount :','gym_mgt').' </h4></td>');
								$mpdf->WriteHTML('<td class="align_right"> <h4 class="margin"><span >'.gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.round($paid_amount).'</h4></td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');							
								$mpdf->WriteHTML('<td  class="width_70 align_right grand_total_lable"><h3 class="color_white margin">'.__('Grand Total :','gym_mgt').' </h3></td>');
								$mpdf->WriteHTML('<td class="align_right grand_total_amount"><h3 class="color_white margin">  <span>'.gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).''.round($grand_total).'</span></h3></td>');
							$mpdf->WriteHTML('</tr>');
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');			
					$mpdf->WriteHTML('</td>');					
				  $mpdf->WriteHTML('</tr>');
				$mpdf->WriteHTML('</table>');						
				$mpdf->WriteHTML('</div>');
			$mpdf->WriteHTML('</div>'); 
			$mpdf->WriteHTML('</body>'); 
			$mpdf->WriteHTML('</html>'); 
	
	$mpdf->Output();	
	ob_end_flush();
	unset($mpdf);	

}
//send mail for generated invoice  
function gmgt_send_invoice_generate_mail($emails,$subject,$message,$invoice_id,$type)
{		
	
	error_reporting(0);
	
	$obj_payment= new MJ_Gmgtpayment();
	if($type=='membership_invoice')
	{		
		$obj_membership_payment=new MJ_Gmgt_membership_payment;	
		$membership_data=$obj_membership_payment->get_single_membership_payment($invoice_id);
		$history_detail_result = gym_get_payment_history_by_mpid($invoice_id);		
	}
	if($type=='income')
	{
		$income_data=$obj_payment->gmgt_get_income_data($invoice_id);
		$history_detail_result = gym_get_income_payment_history_by_mpid($invoice_id);
	}	
	if($type=='sell_invoice')
	{
		$obj_store=new MJ_Gmgtstore;
		$selling_data=$obj_store->get_single_selling($invoice_id);
		$history_detail_result = gym_get_sell_payment_history_by_mpid($invoice_id);
	}

  echo '<link rel="stylesheet" href="'.plugins_url( '/assets/css/bootstrap.min.css', __FILE__).'"></link>';
  
  echo '<script  rel="javascript" src="'.plugins_url( '/assets/js/bootstrap.min.js', __FILE__).'"></script>';

ob_clean();
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="invoice.pdf"');
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');	
require GMS_PLUGIN_DIR. '/lib/mpdf/mpdf.php';	
$stylesheet = file_get_contents(GMS_PLUGIN_DIR. '/assets/css/custom.css'); // Get css content
$stylesheet1 = file_get_contents(GMS_PLUGIN_DIR. '/assets/css/style.css'); // Get css content
 $mpdf	=	new mPDF('c','A4','','' , 5 , 5 , 5 , 0 , 0 , 0); 

	$mpdf->debug = true;
	$mpdf->WriteHTML('<html>');
	$mpdf->WriteHTML('<head>');
	$mpdf->WriteHTML('<style></style>');
	$mpdf->WriteHTML($stylesheet,1); // Writing style to pdf
	$mpdf->WriteHTML($stylesheet1,1); // Writing style to pdf
	$mpdf->WriteHTML('</head>');
	$mpdf->WriteHTML('<body>');		
	$mpdf->SetTitle('Income Invoice');	
	
		$mpdf->WriteHTML('<div id="invoice_print">');		
			$mpdf->WriteHTML('<img class="invoicefont1" src="'.plugins_url('/gym-management/assets/images/invoice.jpg').'" width="100%">');
			$mpdf->WriteHTML('<div class="main_div">');	
			
					$mpdf->WriteHTML('<table class="width_100_print" border="0">');					
					$mpdf->WriteHTML('<tbody>');
						$mpdf->WriteHTML('<tr>');
							$mpdf->WriteHTML('<td class="width_1_print">');
								$mpdf->WriteHTML('<img class="system_logo"  src="'.get_option( 'gmgt_system_logo' ).'">');
							$mpdf->WriteHTML('</td>');							
							$mpdf->WriteHTML('<td class="only_width_20_print">');								
								$mpdf->WriteHTML('A. '.chunk_split(get_option( 'gmgt_gym_address' ),30,"<BR>").'<br>'); 
								 $mpdf->WriteHTML('E. '.get_option( 'gmgt_email' ).'<br>'); 
								 $mpdf->WriteHTML('P. '.get_option( 'gmgt_contact_number' ).'<br>'); 
							$mpdf->WriteHTML('</td>');
							$mpdf->WriteHTML('<td align="right" class="width_24">');
							$mpdf->WriteHTML('</td>');
						$mpdf->WriteHTML('</tr>');
					$mpdf->WriteHTML('</tbody>');
				$mpdf->WriteHTML('</table>');
				
				$mpdf->WriteHTML('<table>');
			 $mpdf->WriteHTML('<tr>');
				$mpdf->WriteHTML('<td>');
				
					$mpdf->WriteHTML('<table class="width_50_print"  border="0">');
						$mpdf->WriteHTML('<tbody>');				
						$mpdf->WriteHTML('<tr>');
							$mpdf->WriteHTML('<td colspan="2" class="billed_to_print" align="center">');								
								$mpdf->WriteHTML('<h3 class="billed_to_lable"> |'.__('Bill To','gym_mgt').'. </h3>');
							$mpdf->WriteHTML('</td>');
							$mpdf->WriteHTML('<td class="width_40_print">');								
							
								if(!empty($expense_data))
								{
								  $mpdf->WriteHTML('<h3 class="display_name">'.chunk_split(ucwords($expense_data->supplier_name),30,"<BR>").'</h3>'); 
								}
								else
								{
									if(!empty($income_data))
										$member_id=$income_data->supplier_name;
									 if(!empty($membership_data))
										$member_id=$membership_data->member_id;
									 if(!empty($selling_data))
										$member_id=$selling_data->member_id;
									$patient=get_userdata($member_id);
									
									$mpdf->WriteHTML('<h3 class="display_name">'.chunk_split(ucwords($patient->display_name),30,"<BR>").'</h3>'); 
									$address=get_user_meta( $member_id,'address',true);									
									$mpdf->WriteHTML(''.chunk_split($address,30,"<BR>").''); 
									  $mpdf->WriteHTML(''.get_user_meta( $member_id,'city_name',true ).','); 
									 $mpdf->WriteHTML(''.get_user_meta( $member_id,'zip_code',true ).'<br>'); 
									 $mpdf->WriteHTML(''.get_user_meta( $member_id,'mobile',true ).'<br>'); 
								}
									
							 $mpdf->WriteHTML('</td>');
						 $mpdf->WriteHTML('</tr>');									
					 $mpdf->WriteHTML('</tbody>');
				 $mpdf->WriteHTML('</table>');
				
				$mpdf->WriteHTML('</td>');
				$mpdf->WriteHTML('<td>');
				
				   $mpdf->WriteHTML('<table class="width_50_print"  border="0">');
					 $mpdf->WriteHTML('<tbody>');				
						 $mpdf->WriteHTML('<tr>');	
							 $mpdf->WriteHTML('<td class="width_30_print">');
							 $mpdf->WriteHTML('</td>');
							 $mpdf->WriteHTML('<td class="width_20_print invoice_lable" style="padding-right:30px;" align="left">');
								
								$issue_date='DD-MM-YYYY';
								if(!empty($income_data))
								{
									$issue_date=$income_data->invoice_date;
									$payment_status=$income_data->payment_status;
									$invoice_no=$income_data->invoice_no;
								}
								if(!empty($membership_data))
								{
									$issue_date=$membership_data->created_date;
									if($membership_data->payment_status!='0')
									{	
										$payment_status=$membership_data->payment_status;
									}
									else
									{
										$payment_status='Unpaid';
									}		
									$invoice_no=$membership_data->invoice_no;									
								}
								if(!empty($expense_data))
								{
									$issue_date=$expense_data->invoice_date;
									$payment_status=$expense_data->payment_status;
									$invoice_no=$expense_data->invoice_no;
								}
								if(!empty($selling_data))
								{
									$issue_date=$selling_data->sell_date;									
									$payment_status=$selling_data->payment_status;
									$invoice_no=$selling_data->invoice_no;
								} 
								
								if($type!='expense')
								{								
									$mpdf->WriteHTML('<h3>'.__('INVOICE','gym_mgt').' <br> #'.$invoice_no.'</h3>');										
								}																			
							 $mpdf->WriteHTML('</td>');							
						 $mpdf->WriteHTML('</tr>');
						 $mpdf->WriteHTML('<tr>');	
							 $mpdf->WriteHTML('<td class="width_30_print">');
							 $mpdf->WriteHTML('</td>');
							 $mpdf->WriteHTML('<td class="width_20_print" style="padding-right:30px;" align="left">');
								$mpdf->WriteHTML('<h5>'.__('Date','gym_mgt').' : '.getdate_in_input_box($issue_date).'</h5>');
							$mpdf->WriteHTML('<h5>'.__('Status','gym_mgt').' : '.__(''.$payment_status.'','gym_mgt').'</h5>');											
							 $mpdf->WriteHTML('</td>');							
						 $mpdf->WriteHTML('</tr>');						
					 $mpdf->WriteHTML('</tbody>');
				 $mpdf->WriteHTML('</table>');	
				$mpdf->WriteHTML('</td>');
			  $mpdf->WriteHTML('</tr>');
			$mpdf->WriteHTML('</table>');
			
				if($type=='membership_invoice')
				{	
					$mpdf->WriteHTML('<table class="width_100_print">');	
						$mpdf->WriteHTML('<tbody>');	
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td style="padding-left:20px;">');
									$mpdf->WriteHTML('<h3 class="entry_lable">'.__('Membership Entries','gym_mgt').'</h3>');
								$mpdf->WriteHTML('</td>');	
							$mpdf->WriteHTML('</tr>');	
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');				
					
				}		
				elseif($type=='income')
				{ 
					$mpdf->WriteHTML('<table class="width_100_print">');	
						$mpdf->WriteHTML('<tbody>');	
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td style="padding-left:20px;">');
									$mpdf->WriteHTML('<h3 class="entry_lable">'.__('Income Entries','gym_mgt').'</h3>');
								$mpdf->WriteHTML('</td>');	
							$mpdf->WriteHTML('</tr>');	
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');
				
				}
				elseif($type=='sell_invoice')
				{ 
				  $mpdf->WriteHTML('<table class="width_100_print">');	
						$mpdf->WriteHTML('<tbody>');	
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td style="padding-left:20px;">');
									$mpdf->WriteHTML('<h3 class="entry_lable">'.__('Sells Product','gym_mgt').'</h3>');
								$mpdf->WriteHTML('</td>');	
							$mpdf->WriteHTML('</tr>');	
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');
				  
				}
				else
				{ 
					$mpdf->WriteHTML('<table class="width_100_print">');	
						$mpdf->WriteHTML('<tbody>');	
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td style="padding-left:20px;">');
									$mpdf->WriteHTML('<h3 class="entry_lable">'.__('Expense Entries','gym_mgt').'</h3>');
								$mpdf->WriteHTML('</td>');	
							$mpdf->WriteHTML('</tr>');	
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');	
				}		  
					
				$mpdf->WriteHTML('<table class="table table-bordered" class="width_93" border="1">');
					$mpdf->WriteHTML('<thead>');
						
						if($type=='membership_invoice')
						{						
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center">#</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.__('DATE','gym_mgt').'</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_left">'.__('Fees Type','gym_mgt').'</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right">'.__('Amount','gym_mgt').'</th>');								
							$mpdf->WriteHTML('</tr>');
						}
						elseif($type=='sell_invoice')
						{  
						
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center">#</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.__('DATE','gym_mgt').'</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_left">'.__('PRODUCT NAME','gym_mgt').'</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_left">'.__('QUANTITY','gym_mgt').'</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_left">'.__('PRICE','gym_mgt').'</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right">'.__('TOTAL','gym_mgt').'</th>');
								
							$mpdf->WriteHTML('</tr>');
						
						} 
						else
						{ 						
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center">#</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.__('DATE','gym_mgt').'</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_left">'.__('ENTRY','gym_mgt').'</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right">'.__('Amount','gym_mgt').'</th>');								
							$mpdf->WriteHTML('</tr>');
						}	
						
					$mpdf->WriteHTML('</thead>');
					$mpdf->WriteHTML('<tbody>');
						
							$id=1;
							$i=1;
							$total_amount=0;
						if(!empty($income_data) || !empty($expense_data))
						{
							if(!empty($expense_data))
								$income_data=$expense_data;
						
							$member_income=$obj_payment->get_oneparty_income_data_incomeid($income_data->invoice_id);
							
							foreach($member_income as $result_income)
							{
								$income_entries=json_decode($result_income->entry);
								$discount_amount=$result_income->discount;
								$paid_amount=$result_income->paid_amount;
								$total_discount_amount= $result_income->amount - $discount_amount;
								
				                $total_tax=$total_discount_amount * $result_income->tax/100;
								
								$due_amount=0;
								$due_amount=$result_income->total_amount - $result_income->paid_amount;
								$grand_total=$total_discount_amount + $total_tax;
								
							   foreach($income_entries as $each_entry)
							   {
									$total_amount+=$each_entry->amount;
									
									$mpdf->WriteHTML('<tr class="entry_list">');
										$mpdf->WriteHTML('<td class="align_center">'.$id.'</td>');
										$mpdf->WriteHTML('<td class="align_center">'.getdate_in_input_box($result_income->invoice_date).'</td>');
										$mpdf->WriteHTML('<td >'.$each_entry->entry.'</td>');
										$mpdf->WriteHTML('<td class="align_right">'.gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).''.round($each_entry->amount).'</td>');
									$mpdf->WriteHTML('</tr>');
									 $id+=1;
									$i+=1;
								}
							}
						}
						
						if(!empty($membership_data))
						{
							$total_amount=$membership_data->total_amount;
							
							$mpdf->WriteHTML('<tr class="entry_list">');
								$mpdf->WriteHTML('<td class="align_center">'.$i.'</td>'); 
								$mpdf->WriteHTML('<td class="align_center">'.getdate_in_input_box($membership_data->created_date).'</td>'); 
								$mpdf->WriteHTML('<td>'.get_membership_name($membership_data->membership_id).'</td>');								
								$mpdf->WriteHTML('<td class="align_right"><span>'.gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.round($membership_data->membership_amount).'</td>');
							$mpdf->WriteHTML('</tr>');
							
						}
						if(!empty($selling_data))
						{
								
							$all_entry=json_decode($selling_data->entry);
							
							if(!empty($all_entry))
							{
								foreach($all_entry as $entry)
								{
									$obj_product=new MJ_Gmgtproduct;
									$product = $obj_product->get_single_product($entry->entry);
									
									$product_name=$product->product_name;					
									$quentity=$entry->quentity;	
									$price=$product->price;	
									
									
									$mpdf->WriteHTML('<tr class="entry_list">');										
										$mpdf->WriteHTML('<td class="align_center">'.$i.'</td> ');
										$mpdf->WriteHTML('<td class="align_center">'.getdate_in_input_box($selling_data->sell_date).'</td>');
										$mpdf->WriteHTML('<td>'.$product_name.'</td>');
										$mpdf->WriteHTML('<td>'.$quentity.'</td>');
										$mpdf->WriteHTML('<td>'.gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).''.$price.'</td>');
										$mpdf->WriteHTML('<td class="align_right">'.gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).''.round($quentity * $price).'</td>');
										
									$mpdf->WriteHTML('</tr>');								
								}
							}	
						}
										
					$mpdf->WriteHTML('</tbody>');
				$mpdf->WriteHTML('</table>');
				
				$mpdf->WriteHTML('<table>');
				 $mpdf->WriteHTML('<tr>');
				 $mpdf->WriteHTML('<td>');
					  $mpdf->WriteHTML('<table border="0">');
						$mpdf->WriteHTML('<tbody>');						
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td colspan="2" style="padding-left:15px;">');
									$mpdf->WriteHTML('<h3 class="payment_method_lable">'.__('Payment Method','gym_mgt').'');
								$mpdf->WriteHTML('</h3>');
								$mpdf->WriteHTML('</td>');								
							$mpdf->WriteHTML('</tr>');							
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td  class="width_31 font_12">'.__('Bank Name ','gym_mgt').' </td>');
								$mpdf->WriteHTML('<td class="font_12">: '.get_option( 'gmgt_bank_name' ).'</td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_31 font_12">'.__('Account No ','gym_mgt').'</td>');
								$mpdf->WriteHTML('<td class="font_12">: '.get_option( 'gmgt_bank_acount_number' ).'</td>');
							$mpdf->WriteHTML('</tr>');						
						$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_31 font_12">'.__('IFSC Code ','gym_mgt').' </td>');
								$mpdf->WriteHTML('<td class="font_12">: '.get_option( 'gmgt_bank_ifsc_code' ).'</td>');
							$mpdf->WriteHTML('</tr>');						
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_31 font_12">'.__('Paypal ','gym_mgt').' </td>');
								$mpdf->WriteHTML('<td class="font_12">: '.get_option( 'gmgt_paypal_email' ).'</td>');
							$mpdf->WriteHTML('</tr>');
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>'); 
					$mpdf->WriteHTML('</td>');
					$mpdf->WriteHTML('<td>');
					$mpdf->WriteHTML('<table class="width_54_print"  border="0">');
					$mpdf->WriteHTML('<tbody>');
						
						if(!empty($membership_data))
						{
							$total_amount=$membership_data->membership_amount;
							$paid_amount=$membership_data->paid_amount;
							$due_amount=$membership_data->membership_amount - $paid_amount;
							$grand_total=$membership_data->membership_amount;
							
						}
						if(!empty($expense_data))
						{
							$grand_total=$total_amount;
						} 
						if(!empty($selling_data))
						{
							$total_amount=$selling_data->amount;
							$discount_amount=$selling_data->discount;
							$total_discount_amount=$total_amount-$discount_amount;
							$tax_per=$selling_data->tax;
							$total_tax=$total_discount_amount * $tax_per/100;
							$paid_amount=$selling_data->paid_amount;
							$due_amount=$selling_data->total_amount - $paid_amount;
							$grand_total=$selling_data->total_amount;
						}		
						$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<h4><td  class="width_70 align_right"><h4 class="margin">'.__('Subtotal :','gym_mgt').'</h4></td>');
								$mpdf->WriteHTML('<td class="align_right"> <h4 class="margin"><span style="">'.gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.round($total_amount).'</h4></td>');
							$mpdf->WriteHTML('</tr>');
						if($type!='membership_invoice')
						{
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_70 align_right"><h4 class="margin">'.__('Discount Amount','gym_mgt').' </h4></td>');
								$mpdf->WriteHTML('<td class="align_right"><h4 class="margin"> <span >+ '.gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.round($discount_amount).'</h4></td>');
							$mpdf->WriteHTML('</tr>'); 
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_70 align_right"><h4 class="margin">'.__('Tax Amount :','gym_mgt').' </h4></td>');
								$mpdf->WriteHTML('<td class="align_right"><h4 class="margin"> <span >+ '.gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.round($total_tax).'</h4></td>');
							$mpdf->WriteHTML('</tr>');
						}
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_70 align_right"><h4 class="margin">'.__('Due Amount :','gym_mgt').' </h4></td>');
								$mpdf->WriteHTML('<td class="align_right"> <h4 class="margin"><span >'.gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.round(abs($due_amount)).'</h4></td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_70 align_right"><h4 class="margin">'.__('Paid Amount :','gym_mgt').' </h4></td>');
								$mpdf->WriteHTML('<td class="align_right"> <h4 class="margin"><span >'.gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.round($paid_amount).'</h4></td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');							
								$mpdf->WriteHTML('<td  class="width_70 align_right grand_total_lable"><h3 class="color_white margin">'.__('Grand Total :','gym_mgt').' </h3></td>');
								$mpdf->WriteHTML('<td class="align_right grand_total_amount"><h3 class="color_white margin">  <span>'.gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).''.round($grand_total).'</span></h3></td>');
							$mpdf->WriteHTML('</tr>');
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');			
					$mpdf->WriteHTML('</td>');					
				  $mpdf->WriteHTML('</tr>');
				$mpdf->WriteHTML('</table>');	

				if(!empty($history_detail_result))
				{
					$mpdf->WriteHTML('<hr>');
					$mpdf->WriteHTML('<h4>'.__('Payment History','gym_mgt').'</h4>');
					$mpdf->WriteHTML('<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">');
					$mpdf->WriteHTML('<thead>');
						$mpdf->WriteHTML('<tr>');
							$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.__('DATE','gym_mgt').'</th>');
							$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.__('Amount','gym_mgt').'</th>');
							$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.__('Method','gym_mgt').'</th>');
						$mpdf->WriteHTML('</tr>');
					$mpdf->WriteHTML('</thead>');
					$mpdf->WriteHTML('<tbody>');
						
						foreach($history_detail_result as  $retrive_date)
						{						
							$mpdf->WriteHTML('<tr>');
							$mpdf->WriteHTML('<td class="align_center">'.$retrive_date->paid_by_date.'</td>');
							$mpdf->WriteHTML('<td class="align_center">'.$retrive_date->amount.'</td>');
							$mpdf->WriteHTML('<td class="align_center">'.$retrive_date->payment_method.'</td>');
							$mpdf->WriteHTML('</tr>');
						}
					$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');
				}				
				$mpdf->WriteHTML('</div>');
			$mpdf->WriteHTML('</div>'); 
			
			$mpdf->WriteHTML('</body>'); 
			$mpdf->WriteHTML('</html>'); 
				 	
	
	$mpdf->Output( WP_CONTENT_DIR . '/uploads/'.$invoice_id.'-'.$type.'.pdf','F');
	
	ob_end_flush();
	unset($mpdf);	
	
	$system_name=get_option('gmgt_system_name');
	
	$headers = "From: ".$system_name.' <noreplay@gmail.com>' . "\r\n";	
	
	$mail_attachment = array(WP_CONTENT_DIR . '/uploads/'.$invoice_id.'-'.$type.'.pdf');
	
	wp_mail($emails,$subject,$message,$headers,$mail_attachment); 
	
	unlink(WP_CONTENT_DIR . '/uploads/'.$invoice_id.'-'.$type.'.pdf');

}
function gmgt_nutrition_schedule_view()
{
	 //var_dump($notice);
	$obj_nutrition=new MJ_Gmgtnutrition;
	$result = $obj_nutrition->get_single_nutrition($_REQUEST['nutrition_id']);
	 ?>
			<div class="form-group"> 	<a href="#" class="close-btn badge badge-success pull-right">X</a>
			  <h4 class="modal-title" id="myLargeModalLabel">
				<?php echo $result->day.' '. __('Nutrition Schedule','gym_mgt'); ?>
			  </h4>
			</div>
			<hr>
			<div class="panel panel-white form-horizontal">
			  <div class="form-group">
				<label class="col-sm-3" for="Breakfast"><strong>
				<?php _e(' Breakfast','gym_mgt');?></strong>
				: </label>
				<div class="col-sm-9"> <?php echo $result->breakfast;?> </div>
			  </div>
			  <div class="form-group">
				<label class="col-sm-3" for="notice_title"><strong>
				<?php _e('Midmorning Snack','gym_mgt');?></strong>
				: </label>
				<div class="col-sm-9"> <?php echo $result->midmorning_snack;?> </div>
			  </div>
			  <div class="form-group">
				<label class="col-sm-3" for="lunch"><strong>
				<?php _e('Lunch','gym_mgt');?></strong>
				: </label>
				<div class="col-sm-9"> <?php echo $result->lunch;?> </div>
			  </div>
			  <div class="form-group">
				<label class="col-sm-3" for="afternoon_snack"><strong>
				<?php _e('Afternoon Snack','gym_mgt');?></strong>
				: </label>
				<div class="col-sm-9"> <?php echo $result->afternoon_snack;?> </div>
			  </div>
			   <div class="form-group">
				<label class="col-sm-3" for="dinner"><strong>
				<?php _e('Dinner','gym_mgt');?></strong>
				: </label>
				<div class="col-sm-9"> <?php echo $result->dinner;?> </div>
			  </div>
			   <div class="form-group">
				<label class="col-sm-3" for="afterdinner_snack"><strong>
				<?php _e('Afterdinner Snack','gym_mgt');?></strong>
				: </label>
				<div class="col-sm-9"> <?php echo $result->afterdinner_snack;?> </div>
			  </div>
			  			   <div class="form-group">
				<label class="col-sm-3" for="afterdinner_snack"><strong>
				<?php _e('Afterdinner Snack','gym_mgt');?></strong>
				: </label>
				<div class="col-sm-9"> <?php echo $result->start_date;?> </div>
			  </div>
			  			   <div class="form-group">
				<label class="col-sm-3" for="afterdinner_snack"><strong>
				<?php _e('Afterdinner Snack','gym_mgt');?></strong>
				: </label>
				<div class="col-sm-9"> <?php echo $result->expire_date;?> </div>
			  </div>
			<?php 
				die();
}
function gmgt_group_member_view()
{
	$group_id = $_REQUEST['group_id'];
	$allmembers =gym_get_groupmember($group_id);
	?>
	<div class="form-group"> 	<a href="#" class="close-btn badge badge-success pull-right">X</a>
		<h4 class="modal-title" id="myLargeModalLabel">
			<?php echo  __('Group Member','gym_mgt'); ?>
		</h4>
	</div>
	<hr>
	<div class="panel-body">
		<div class="slimScrollDiv">
			<div class="inbox-widget slimscroll">
			<?php 
			if(!empty($allmembers))
			foreach ($allmembers as $retrieved_data){
			?>
				<div class="inbox-item">
					<div class="inbox-item-img">
			<?php 
				$uid=$retrieved_data->member_id;
				$userimage=get_user_meta($uid, 'gmgt_user_avatar', true);
				if(empty($userimage))
								{
												echo '<img src='.get_option( 'gmgt_system_logo' ).' height="50px" width="50px" class="img-circle" />';
								}
								else
									echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>';	
			?>
				</div>
				<p class="inbox-item-author"><?php echo gym_get_display_name($retrieved_data->member_id);?></p>
				</div>
				
			<?php 
			}
			else 
			{
				?>
			<p><?php _e('No members yet','gym_mgt');?></p>
			<?php
			} 
			?>
			
			</div>
		</div>
	</div>
	<?php 
?>
	
<?php 
	die();
}
//MEASUREMENT DELETE FUNCTION
function gmgt_measurement_delete()
{
	$obj_workout = new MJ_Gmgtworkout();
	$measurement_id = $_REQUEST['measurement_id'];
	$measurement_data = $obj_workout->get_measurement_deleteby_id($measurement_id);
	die();
}

// MEMBRSHIP LOAD END DATE FUNTION 
function gmgt_load_enddate()
{
$date = trim($_POST['start_date']);
$new_date = DateTime::createFromFormat(gmgt_get_phpdateformat(get_option('gmgt_datepicker_format')), $date); 
$joiningdate=$new_date->format('Y-m-d');

$membership_id = $_POST['membership_id'];
$obj_membership=new MJ_Gmgtmembership;	
$membership=$obj_membership->get_single_membership($membership_id);
$validity=$membership->membership_length_id;
$expiredate= date(gmgt_get_phpdateformat(get_option('gmgt_datepicker_format')), strtotime($joiningdate. ' + '.$validity.' days'));
echo $expiredate;
die();
}

//VIEW MEASUREMENT FUNCTION
function gmgt_measurement_view()
{
	$obj_workout = new MJ_Gmgtworkout();
	$curr_user_id=get_current_user_id();
	$obj_gym=new MJ_Gym_management($curr_user_id);
	$user_id = $_REQUEST['user_id'];	
	$measurement_data = $obj_workout->get_all_measurement_by_userid($user_id);
	//access right
	$page_name='workouts';
	$user_access=get_userrole_wise_manually_page_access_right_array($page_name);
	
	?>
	<div class="form-group"> 	<a href="#" class="close-btn badge badge-success pull-right">X</a>
		<h4 class="modal-title" id="myLargeModalLabel">
			<?php 
				$userimage=get_user_meta($user_id, 'gmgt_user_avatar', true);
				if(empty($userimage))
				{
					echo '<img src='.get_option( 'gmgt_system_logo' ).' height="50px" width="50px" class="img-circle" />';
				}
				else
					echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/> ';
				echo  gym_get_display_name($user_id).__('\'s Measurement','gym_mgt'); ?>
		</h4>
	</div>
	<hr>
	<div class="panel-body">
		<div class="table-responsive box-scroll">
       		<table id="measurement_list" class="display table" cellspacing="0" width="100%">
	        	 <thead>
	            	<tr>						
						<th><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
						<th><?php  _e( 'Measurement', 'gym_mgt' ) ;?></th>
						<th><?php  _e( 'Result', 'gym_mgt' ) ;?></th>			
					    <th><?php  _e( 'Record Date', 'gym_mgt' ) ;?></th>		
					     <th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>				            
		            </tr>		            	 
		        </thead>
		        <tbody>
		        <?php 
		        	
		        if(!empty($measurement_data))
		        {
		        	foreach ($measurement_data as $retrieved_data)
		        	{ ?>
			        <tr id="row_<?php echo $retrieved_data->measurment_id?>">
						<td class="user_image"><?php $userimage=$retrieved_data->gmgt_progress_image;
							if(empty($userimage)){
								echo '<img src='.get_option( 'gmgt_system_logo' ).' height="50px" width="50px" class="img-circle" />';
							}
							else
								echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>';
						?>
						</td>
			        	<td class="recorddate"><?php echo $retrieved_data->result_measurment;?></td>			  
						<td class="duration"><?php echo $retrieved_data->result." ".measurement_counts_lable_array($retrieved_data->result_measurment);?></td>
						<td class="result"><?php echo getdate_in_input_box($retrieved_data->result_date);?></td>
						<td class="result">
							<?php if($obj_gym->role=='administrator'){?>
							<a href="?page=gmgt_workout&tab=addmeasurement&action=edit&measurment_id=<?php echo $retrieved_data->measurment_id?>" class="btn btn-info"><?php _e('Edit', 'gym_mgt' ) ;?></a>
							<?php
							}	
							else
							{							
								if($user_access['edit']=='1')
								{
								?>
									<a href="?dashboard=user&page=workouts&tab=addmeasurement&action=edit&measurment_id=<?php echo $retrieved_data->measurment_id?>" class="btn btn-info">
									<?php _e('Edit', 'gym_mgt' ) ;?></a>
								<?php
								}
								if($user_access['delete']=='1')
								{
								?>		
									<a href="#" class="btn btn-danger measurement_delete" data-val="<?php echo $retrieved_data->measurment_id?>"><?php _e('Delete','gym_mgt');?></a>
								<?php
								}
							}	
								?>	
						</td>
			        </tr>
					<?php 
					}
				}
				else 
				{
				?>
					<tr>
					<td colspan=3> <?php _e('No Record Found','gym_mgt');?></td>
					</tr>
				<?php 
				}
				?>
		        </tbody>
		        	
		        </table>
		</div>
		<?php
		die(); 
}

//ADD WORKOUT FUNCTION
function gmgt_add_workout()
{
	
	if(isset($_REQUEST['data_array']))
	{
		$data_array = $_REQUEST['data_array'];
		$data_value = json_encode($data_array);
		
		echo "<input type='hidden'  value='".htmlspecialchars($data_value,ENT_QUOTES)."' name='activity_list[]'>";
		//var_dump($data_array);
	}
	die();
}
//ADD Nutrition FUNCTION
function gmgt_add_nutrition()
{
	
	if(isset($_REQUEST['data_array']))
	{
	$data_array = $_REQUEST['data_array'];
	$data_value = json_encode($data_array);
	echo "<input type='hidden' onlyNumberSp value='".htmlspecialchars($data_value,ENT_QUOTES)."' name='nutrition_list[]'>";
	//var_dump($data_array);
	}
	die();
}
//DELETE WORKOUT FUNCTION 
function gmgt_delete_workout()
{

	
	$work_out_id = $_REQUEST['workout_id'];
	global $wpdb;
	$table_workout = $wpdb->prefix. 'gmgt_assign_workout';
	$table_workout_data = $wpdb->prefix. 'gmgt_workout_data';
	$result = $wpdb->query("DELETE FROM $table_workout_data where workout_id= ".$work_out_id);
	$result = $wpdb->query("DELETE FROM $table_workout where workout_id= ".$work_out_id);
	die();
}
//DELETE nutrition FUNCTION

function gmgt_delete_nutrition()
{
	$work_out_id = $_REQUEST['workout_id'];
	global $wpdb;
	$table_gmgt_nutrition = $wpdb->prefix. 'gmgt_nutrition';
	$table_gmgt_nutrition_data = $wpdb->prefix. 'gmgt_nutrition_data';
	$result = $wpdb->query("DELETE FROM $table_gmgt_nutrition_data where nutrition_id= ".$work_out_id);
	$result = $wpdb->query("DELETE FROM $table_gmgt_nutrition where id = ".$work_out_id);
	die();
}

//GET PAYMENT DETAILS BY MEMBERSHIP
function gmgt_paymentdetail_bymembership()
{
	$membership_id = $_POST['membership_id'];
	global $wpdb;
	$gmgt_membershiptype = $wpdb->prefix.'gmgt_membershiptype';
	$sql = "SELECT * From $gmgt_membershiptype where membership_id = $membership_id";
	$result = $wpdb->get_row($sql);
	 
	$payment_detail = array();
	$payment_detail['title'] = $result->membership_label;
	//$payment_detail['membership_id'] = $result->membership_id;
	$payment_detail['price'] = $result->membership_amount;
	//$payment_detail['membership_length_id'] = $result->membership_length_id;
	echo json_encode($payment_detail);
	die();
}
//ADD PAYMENT POPUP FUNCTION
function gmgt_member_add_payment()
{ ?>
	
	<script type="text/javascript">
$(document).ready(function() {
	$('#expense_form').validationEngine();
} );
</script>
<?php 
	$mp_id = $_POST['idtest'];
	$member_id= $_POST['member_id'];
	$due_amount = $_POST['due_amount'];
	$view_type = $_POST['view_type'];	
	
?>
	<div class="modal-header">
			<a href="#" class="close-btn badge badge-success pull-right">X</a>
			<h4 class="modal-title"><?php echo get_option('gmgt_system_name');?></h4>
	</div>
	<div class="modal-body">
		 <form name="expense_form" action="" method="post" class="form-horizontal" id="expense_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
		
		<input type="hidden" name="mp_id" value="<?php echo $mp_id;?>">
		<input type="hidden" name="member_id" value="<?php echo $member_id;?>">
		<input type="hidden" name="view_type" value="<?php echo $view_type;?>">
		
		<input type="hidden" name="created_by" value="<?php echo get_current_user_id();?>">
		<div class="form-group">
			<label class="col-sm-3 control-label" for="amount"><?php _e('Paid Amount','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="amount" class="form-control validate[required] text-input" type="number" onkeypress="if(this.value.length==8) return false;" min="0" max="<?php echo $due_amount ?>" value="<?php echo $due_amount ?>" name="amount">
			</div>
		</div>
		<div class="form-group">
			<input type="hidden" name="payment_status" value="paid">
			<label class="col-sm-3 control-label" for="payment_method"><?php _e('Payment By','gym_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
			<?php global $current_user;
		$user_roles = $current_user->roles;
		$user_role = array_shift($user_roles);?>
				<select name="payment_method" id="payment_method" class="form-control">
					<?php if($user_role != 'member'){?>
					<option value="Cash"><?php _e('Cash','gym_mgt');?></option>
					<option value="Cheque"><?php _e('Cheque','gym_mgt');?></option>
					<option value="Bank Transfer"><?php _e('Bank Transfer','gym_mgt');?></option>		
					<?php } else {
					//<option value="Paypal"><?php _e('Paypal','gym_mgt');</option>
					 if(is_plugin_active('paymaster/paymaster.php') && get_option('gmgt_paymaster_pack')=="yes"){ 
						$payment_method = get_option('pm_payment_method');
						print '<option value="'.$payment_method.'">'.$payment_method.'</option>';
					} else{
						print '<option value="Paypal">Paypal</option>';
					} ?>
					
					<?php }?>
						
			</select>
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">
        	 <input type="submit" value="<?php _e('Add Payment','gym_mgt');?>" name="add_fee_payment" class="btn btn-success"/>
        </div>
		</form>
	</div>
<?php
	die();
}
//VIEW PAYMENT HISTORY
function gmgt_member_view_paymenthistory()
{
	$mp_id = $_REQUEST['idtest'];
	$fees_detail_result = gym_get_single_membership_payment_record($mp_id);
	$fees_history_detail_result = gym_get_payment_history_by_mpid($mp_id);
	?>
	<div class="modal-header">
			<a href="#" class="close-btn badge badge-success pull-right">X</a>
			<h4 class="modal-title"><?php echo get_option('gmgt_system_name');?></h4>
	</div>
	<div class="modal-body">
	
	<div id="invoice_print"> 
		<table width="100%" border="0">
						<tbody>
							<tr>
								<td width="70%">
									<img style="max-height:80px;" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">
								</td>
								<td align="right" width="24%">
									
									<h5><?php $issue_date='DD-MM-YYYY';
												
													$issue_date=$fees_detail_result->created_date;
													
									
									echo __('Issue Date','gym_mgt')." : ".getdate_in_input_box($issue_date);?></h5>
									
						<h5><?php echo __('Status','gym_mgt')." : "; echo "<span class='btn btn-success btn-xs'>";
					echo get_membership_paymentstatus($fees_detail_result->mp_id);
					echo "</span>";?></h5>
								</td>
							</tr>
						</tbody>
					</table>
					<hr>
					<table width="100%" border="0">
						<tbody>
							<tr>
								<td align="left">
									<h4><?php _e('Payment To','gym_mgt');?> </h4>
								</td>
								<td align="right">
									<h4><?php _e('Bill To','gym_mgt');?> </h4>
								</td>
							</tr>
							<tr>
								<td valign="top" align="left">
									<?php echo get_option( 'gmgt_system_name' )."<br>"; 
									 echo get_option( 'gmgt_gym_address' ).","; 
									 echo get_option( 'gmgt_contry' )."<br>"; 
									 echo get_option( 'gmgt_contact_number' )."<br>"; 
									?>
									
								</td>
								<td valign="top" align="right">
									<?php
									$member_id=$fees_detail_result->member_id;								
										
										$patient=get_userdata($member_id);
												
										echo $patient->display_name."<br>"; 
										 echo get_user_meta( $member_id,'address',true ).","; 
										 echo get_user_meta( $member_id,'city_name',true ).","; 
										 echo get_user_meta( $member_id,'zip_code',true ).",<BR>"; 
										 echo get_user_meta( $member_id,'state_name',true ).","; 
										 echo get_option( 'gmgt_contry' ).","; 
										 echo get_user_meta( $member_id,'mobile',true )."<br>"; 
									
									?>
								</td>
							</tr>
						</tbody>
					</table>
					<hr>
					<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th class="text-center"> <?php _e('Fees Type','gym_mgt');?></th>
								<th><?php _e('Total','gym_mgt');?> </th>
								
							</tr>
						</thead>
						<tbody>
							<td>1</td>
							<td><?php echo get_membership_name($fees_detail_result->membership_id);?></td>
							<td><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?> <?php echo $fees_detail_result->membership_amount;?></td>
						</tbody>
						</table>
						<table width="100%" border="0">
						<tbody>
							
							<tr>
								<td width="80%" align="right"><?php _e('Subtotal :','gym_mgt');?></td>
								<td align="right"><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo $fees_detail_result->membership_amount;?></td>
							</tr>
							<tr>
								<td width="80%" align="right"><?php _e('Payment Made :','gym_mgt');?></td>
								<td align="right"><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo $fees_detail_result->paid_amount;?></td>
							</tr>
							<tr>
								<td width="80%" align="right"><?php _e('Due Amount  :','gym_mgt');?></td>
								<td align="right"><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php  $dueamount=$fees_detail_result->membership_amount - $fees_detail_result->paid_amount; echo abs($dueamount); ?></td>
							</tr>
							
						</tbody>
					</table>
					<hr>
					<?php if(!empty($fees_history_detail_result))
					{?>
					<h4><?php _e('Payment History','gym_mgt');?></h4>
					<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
					<thead>
							<tr>
								<th class="text-center"><?php _e('Date','gym_mgt');?></th>
								<th class="text-center"> <?php _e('Amount','gym_mgt');?></th>
								<th><?php _e('Method','gym_mgt');?> </th>
								
							</tr>
						</thead>
						<tbody>
							<?php 
							foreach($fees_history_detail_result as  $retrive_date)
							{
							?>
							<tr>
							<td><?php echo getdate_in_input_box($retrive_date->paid_by_date);?></td>
							<td><?php  echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); echo $retrive_date->amount;?></td>
							<td><?php echo  $retrive_date->payment_method;?></td>
							</tr>
							<?php }?>
						</tbody>
					</table>
					<?php }?>
	</div>
	</div>
	<?php
	die();
}
//CHECK MEMBERRSHIP FUNCTION
function gmgt_check_membership($userid)
{
	$validity=0;
	$obj_membership=new MJ_Gmgtmembership;
	$membershipid=get_user_meta($userid,'membership_id',true);
	$membershistatus=get_user_meta($userid,'membership_status',true);
	$joiningdate=get_user_meta($userid,'begin_date',true);
	$autorenew=get_user_meta($userid,'auto_renew',true);
	$membership=$obj_membership->get_single_membership($membershipid);
	if(!empty($membership))
		$validity=$membership->membership_length_id;
	$expiredate="";
	$today = date("Y-m-d");
	 $expiredate= date('Y-m-d', strtotime($joiningdate. ' + '.$validity.' days'));
	if($membershistatus!="Dropped"){
		if($today < $expiredate){
			$returnans=update_user_meta( $userid, 'membership_status','Continue');		 
			 return $expiredate;
		 }	 
		 elseif($autorenew=="Yes")
		 {
			 $returnans=update_user_meta( $userid, 'begin_date',$today );
			  $bigindate=get_user_meta($userid,'begin_date',true);
			return $expiredate= date('Y-m-d', strtotime($bigindate. ' + '.$validity.' days'));
		 }
		 else
		 {
			  $returnans=update_user_meta( $userid, 'membership_status','Expired');
			  return $expiredate;
		 }
	}
	else
	{
		return $expiredate;
	}
		 
	
}
add_action('init','gmgt_send_alert_message');
//SEND REMINDER MAIL FUNCTION
function gmgt_send_alert_message()
{
	$enable_service=get_option('gym_enable_membership_alert_message');
	if($enable_service=='yes')
	{
		$search=array('[GMGT_MEMBERNAME]','[GMGT_STARTDATE]','[GMGT_ENDDATE]','[GMGT_MEMBERSHIP]');
		$before_days=get_option('gmgt_reminder_before_days');
		$today=date('Y-m-d');
		$get_members = array('role' => 'member');
				$membersdata=get_users($get_members);
			 if(!empty($membersdata))
			 {
				foreach ($membersdata as $retrieved_data){
					
					$expiredate=gmgt_check_membership($retrieved_data->ID);
					$start_date=$retrieved_data->begin_date;
					$membership_id=get_user_meta($retrieved_data->ID,'membership_id',true);
					$membership_name=get_membership_name($membership_id);
					$message_content=get_option('gym_reminder_message');
					
					$replace = array($retrieved_data->display_name,$retrieved_data->begin_date,$expiredate,$membership_name);
					$message_content = str_replace($search, $replace, $message_content);
					$mail_sent=check_alert_mail_send($retrieved_data->ID,$expiredate,$start_date);
					$date1=date_create($today);
					$date2=date_create($expiredate);
					$interval = $date1->diff($date2);
					$difference=$interval->format('%R%a');
					
					if($difference<= +$before_days && $difference > 0){
					
						if($mail_sent==0){
							$to=$retrieved_data->user_email;
							$subject="Gym Membership Alert";
							$from=get_option('admin_email');
							$headers = 'From: <'.$from.'>' . "\r\n";
							$success=wp_mail( $to, $subject, $message_content, $headers ); 
							if($success)
								insert_alert_mail($retrieved_data->ID,$expiredate,$start_date,$membership_id);
						}
					}
					
				}
			 }
	}
	
}
//SEND REMINDER MAIL CHECK  FUNCTION
function check_alert_mail_send($member_id,$expiredate,$start_date)
{
	global $wpdb;
	$table_gmgt_alert_mail_log = $wpdb->prefix . 'gmgt_alert_mail_log';
	
	$result= $wpdb->get_var("SELECT count(*) FROM ".$table_gmgt_alert_mail_log." WHERE member_id =".$member_id." and start_date='".$start_date."' and end_date='".$expiredate."'");
	return $result;
}
//INSER REMINDER MESGAE FUNCTION
function insert_alert_mail($member_id,$expiredate,$start_date,$membership_id)
{
	global $wpdb;
	$table_gmgt_alert_mail_log = $wpdb->prefix . 'gmgt_alert_mail_log';
	$alertdata['member_id']=$member_id;
	$alertdata['membership_id']=$membership_id;
	$alertdata['start_date']=$start_date;
	$alertdata['end_date']=$expiredate;
	$alertdata['alert_date']=date("Y-m-d");
	$result=$wpdb->insert( $table_gmgt_alert_mail_log, $alertdata );
	return $result;
	
}

//GET MEMBER Attendance
function gmgt_view_member_attendance($start_date,$end_date,$user_id)
{
	
	global $wpdb;
	$tbl_name = $wpdb->prefix .'gmgt_attendence';
	
	$result =$wpdb->get_results("SELECT *  FROM $tbl_name where user_id=$user_id AND role_name = 'member' and attendence_date between '$start_date' and '$end_date'");
	return $result;
}
function gmgt_get_attendence($userid,$curr_date)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "gmgt_attendence";
	
	$result=$wpdb->get_var("SELECT status FROM $table_name WHERE attendence_date='$curr_date'  and user_id=$userid");
	return $result;

}
//GET CURENT USER CLASS
function get_current_userclass($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix .'gmgt_class_schedule';
	$result =$wpdb->get_results("SELECT *  FROM $table_name where staff_id=$id OR asst_staff_id =$id");
	return $result;
}
//GET INBOX MESSGAE FUNCTION
function gmgt_get_inbox_message($user_id,$p=0,$lpm1=10)
{
	
	global $wpdb;
	$tbl_name_message = $wpdb->prefix .'Gmgt_message';
	$tbl_name_message_replies = $wpdb->prefix .'gmgt_message_replies';
	//$inbox =$wpdb->get_results("SELECT *  FROM $tbl_name_message where receiver = $user_id limit $p , $lpm1");
	
	$inbox = $wpdb->get_results("SELECT DISTINCT b.message_id, a.* FROM $tbl_name_message a LEFT JOIN $tbl_name_message_replies b ON a.message_id = b.message_id WHERE ( a.receiver = $user_id OR b.receiver_id =$user_id)  ORDER BY 	date DESC limit $p , $lpm1");
	
	return $inbox;
}
//COUNT UNREAD FUNCTION
function gmgt_count_unread_message($user_id)
{
	
	global $wpdb;
	$tbl_name = $wpdb->prefix .'Gmgt_message';
	
	$inbox =$wpdb->get_results("SELECT *  FROM $tbl_name where receiver = $user_id and status=0");
	return $inbox;
}
function gmgt_admininbox_pagination($totalposts,$p,$lpm1,$prev,$next)
{
	$adjacents = 1;
	$page_order = "";
	$pagination = "";
	$form_id = 1;
	if(isset($_REQUEST['form_id']))
		$form_id=$_REQUEST['form_id'];
	if(isset($_GET['orderby']))
	{
		$page_order='&orderby='.$_GET['orderby'].'&order='.$_GET['order'];
	}
	if($totalposts > 1)
	{
		$pagination .= '<div class="btn-group">';
		
		if ($p > 1)
			$pagination.= "<a href=\"?page=smgt_message&tab=inbox&pg=$prev\" class=\"btn btn-default\"><i class=\"fa fa-angle-left\"></i></a> ";
		else
			$pagination.= "<a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-left\"></i></a> ";

		if ($p < $totalposts)
			$pagination.= " <a href=\"?page=smgt_message&tab=inbox&pg=$next\" class=\"btn btn-default next-page\"><i class=\"fa fa-angle-right\"></i></a>";
		else
			$pagination.= " <a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-right\"></i></a>";
		$pagination.= "</div>\n";
	}
	return $pagination;
}
function gym_get_display_name($user_id) {
	if (!$user = get_userdata($user_id))
		return false;
	return $user->data->display_name;
}
function gmgt_get_all_user_in_message()
{
	$staff_member = get_users(array('role'=>'staff_member'));
	$accountant = get_users(array('role'=>'accountant'));
	$member = get_users(array('role'=>'member'));
	
	$obj_gym = new MJ_Gym_management(get_current_user_id());
	
	
	
	
	$all_user = array('member'=>$member,
			'staff_member'=>$staff_member,
			'accountant'=>$accountant,
			
	);
	$return_array = array();
	
	foreach($all_user as $key => $value)
	{
		if(!empty($value))
		{
		 echo '<optgroup label="'.$key.'" style = "text-transform: capitalize;">';
		 foreach($value as $user)
		 {
		 	echo '<option value="'.$user->ID.'">'.$user->display_name.'</option>';
		 }
		}
	}
}
function gmgt_get_allclass(){
	
	
	global $wpdb;
	$table_name = $wpdb->prefix .'gmgt_class_schedule';
	
	return $classdata =$wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
	//print_r($classdata);
}
//GET USER NOTICE BY ROLE WISE FUNCTION
function gmgt_get_user_notice($role,$class_id)
{
	
	if($role == 'all' )
	{
		$userdata = array();
		$roles = array('member', 'staff_member', 'accountant');
		
		foreach ($roles as $role) :
		$users_query = new WP_User_Query( array(
			'fields' => 'all_with_meta',
			'role' => $role,
			'orderby' => 'display_name'
		));
		$results = $users_query->get_results();
		if ($results) $userdata = array_merge($userdata, $results);
		endforeach;
	}
	else 
	{	
		if($class_id == 'all')
		{
			$userdata=get_users(array('role'=>$role));
		}
		else
		{	
			
			if($role=='member')
			{
				
				foreach(get_member_by_class_id($class_id) as $key=>$member_id)
				{
					$userdata[] = get_userdata($member_id->member_id);					
				}				
			}
			if($role=='staff_member')
			{
				
				foreach(gmgtGetStaffMemberById($class_id) as $key=>$member_id)
				{
					$userdata[] = get_userdata($member_id->staff_id);					
				}				
			}
			else
			{				
				
				$userdata=get_users(array('role'=>$role));
			}
			
		}
	}		
	return $userdata;
}
function gmgt_insert_record($tablenm,$records)
{
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	return $result=$wpdb->insert( $table_name, $records);
	
}
function gmgt_pagination($totalposts,$p,$lpm1,$prev,$next){
	$adjacents = 1;
	$page_order = "";
	$pagination = "";
	$form_id = 1;
	if(isset($_REQUEST['form_id']))
		$form_id=$_REQUEST['form_id'];
	if(isset($_GET['orderby']))
	{
		$page_order='&orderby='.$_GET['orderby'].'&order='.$_GET['order'];
	}
	if($totalposts > 1)
	{
		$pagination .= '<div class="btn-group">';
		
		if ($p > 1)
			$pagination.= "<a href=\"?page=smgt_message&tab=sentbox&form_id=$form_id&pg=$prev$page_order\" class=\"btn btn-default\"><i class=\"fa fa-angle-left\"></i></a> ";
		else
			$pagination.= "<a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-left\"></i></a> ";
		
		if ($p < $totalposts)
			$pagination.= " <a href=\"?page=smgt_message&tab=sentbox&form_id=$form_id&pg=$next\" class=\"btn btn-default next-page\"><i class=\"fa fa-angle-right\"></i></a>";
		else
			$pagination.= " <a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-right\"></i></a>";
		$pagination.= "</div>\n";
	}
	return $pagination;
}
//COUNT SEND MESSAGE IN MESSAGE BOX
function gmgt_count_send_item($id)
{
	global $wpdb;
	$posts = $wpdb->prefix."posts";
	$total =$wpdb->get_var("SELECT Count(*) FROM ".$posts." Where post_type = 'message' AND post_author = $id");
	return $total;
}
//SEND MESSAGE FUNCTION
function gmgt_get_send_message($user_id,$max=10,$offset=0)
{
	
	global $wpdb;
	$tbl_name = $wpdb->prefix .'Gmgt_message';
	
	$obj_gym = new MJ_Gym_management($user_id);
	
	if(is_admin() || $obj_gym->role=='staff_member' || $obj_gym->role=='accountant' || $obj_gym->role == 'member' && get_option('gym_enable_member_can_message')=='yes')
	{
		
		$args['post_type'] = 'message';
		$args['posts_per_page'] =$max;
		$args['offset'] = $offset;
		$args['post_status'] = 'public';
		$args['author'] = $user_id;
		
		$q = new WP_Query();
		$sent_message = $q->query( $args );
	
	}
	else 
	{
		$sent_message =$wpdb->get_results("SELECT *  FROM $tbl_name where sender = $user_id ");
	}
	return $sent_message;
}
//GET EMAIL ID BY  USER ID FUNCTION
function gmgt_get_emailid_byuser_id($id)
{
	if (!$user = get_userdata($id))
		return false;
	return $user->data->user_email;
}
function gmgt_count_inbox_item($id)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'Gmgt_message';
	$inbox =$wpdb->get_results("SELECT *  FROM $tbl_name where receiver = $id and status=0");
	return $inbox;
}
function gmgt_inbox_pagination($totalposts,$p,$lpm1,$prev,$next)
{
	$adjacents = 1;
	$page_order = "";
	$pagination = "";
	$form_id = 1;
	if(isset($_REQUEST['form_id']))
		$form_id=$_REQUEST['form_id'];
	if(isset($_GET['orderby']))
	{
		$page_order='&orderby='.$_GET['orderby'].'&order='.$_GET['order'];
	}
	if($totalposts > 1)
	{
		$pagination .= '<div class="btn-group">';
		
		if ($p > 1)
			$pagination.= "<a href=\"?dashboard=user&page=message&tab=inbox&pg=$prev\" class=\"btn btn-default\"><i class=\"fa fa-angle-left\"></i></a> ";
		else
			$pagination.= "<a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-left\"></i></a> ";
	
		if ($p < $totalposts)
			$pagination.= " <a href=\"?dashboard=user&page=message&tab=inbox&pg=$next\" class=\"btn btn-default next-page\"><i class=\"fa fa-angle-right\"></i></a>";
		else
			$pagination.= "<a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-right\"></i></a>";
		$pagination.= "</div>\n";
	}
	return $pagination;
}
function gmgt_get_message_by_id($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "Gmgt_message";
	//return $retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE message_id=".$id);
	$qry = $wpdb->prepare( "SELECT * FROM $table_name WHERE message_id= %d ",$id);
	return $retrieve_subject = $wpdb->get_row($qry);

}
function gmgt_fronted_sentbox_pagination($totalposts,$p,$lpm1,$prev,$next){
	$adjacents = 1;
	$page_order = "";
	$pagination = "";
	$form_id = 1;
	if(isset($_REQUEST['form_id']))
		$form_id=$_REQUEST['form_id'];
	if(isset($_GET['orderby']))
	{
		$page_order='&orderby='.$_GET['orderby'].'&order='.$_GET['order'];
	}
	if($totalposts > 1)
	{
		$pagination .= '<div class="btn-group">';
		
		if ($p > 1)
			$pagination.= "<a href=\"?dashboard=user&page=message&tab=sentbox&pg=$prev$page_order\" class=\"btn btn-default\"><i class=\"fa fa-angle-left\"></i></a> ";
		else
			$pagination.= "<a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-left\"></i></a> ";

		if ($p < $totalposts)
			$pagination.= " <a href=\"?dashboard=user&page=message&tab=sentbox&pg=$next\" class=\"btn btn-default next-page\"><i class=\"fa fa-angle-right\"></i></a>";
		else
			$pagination.= " <a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-right\"></i></a>";
		$pagination.= "</div>\n";
	}
	return $pagination;
}
//GET USER WORKOUT FUNCTION
function get_userworkout($id)
{
	global $wpdb;
	$workouttable = $wpdb->prefix."gmgt_assign_workout";
	$workoutdata =$wpdb->get_results("SELECT *FROM ".$workouttable." Where user_id = $id");
	return $workoutdata;
}

//GET USER WORKOUT DATA FUNCTION
function get_workoutdata($id)
{
	
	global $wpdb;
	$workouttable = $wpdb->prefix."gmgt_workout_data";
	$workoutdata =$wpdb->get_results("SELECT *FROM ".$workouttable." Where workout_id = $id");
	
	return $workoutdata;
	
}
//SET WORKOUT AARAY FUNCTION
function set_workoutarray($data)
{
	$workout_array=array();
	foreach($data as $row)
	{
			$workout_array[$row->day_name][]= "<span class='col-md-3 col-sm-3 col-xs-12'>".$row->workout_name."</span>   
				<span class='col-md-3 col-sm-3 col-xs-6'>".$row->sets." ".__('Sets','gym_mgt')."</span>
			<span class='col-md-2 col-sm-2 col-xs-6'> ".$row->reps." ".__('Reps','gym_mgt')."</span>
				<span class='col-md-2 col-sm-2 col-xs-6'> ".$row->kg." ".__('KG','gym_mgt')."</span>
			<span class='col-md-2 col-sm-2  col-xs-6'> ".$row->time." ".__('Min','gym_mgt')."</span>";
		
	}
	return $workout_array;
	
}
//CHECK USER WORKOUT
function check_user_workouts($id,$date)
{
	global $wpdb;
	$workouttable = $wpdb->prefix."gmgt_daily_workouts";
	$count_rec =$wpdb->get_var("SELECT COUNT(*) FROM ".$workouttable." Where member_id = $id AND record_date='$date'");
	return $count_rec;
}
//GET USER NUTRISION
function get_user_nutrition($id)
{
	global $wpdb;
	$workouttable = $wpdb->prefix."gmgt_nutrition";
	$workoutdata =$wpdb->get_results("SELECT *FROM ".$workouttable." Where user_id = $id");
	return $workoutdata;
}
//GET NUTRISION DATA FUNCTION
function get_nutritiondata($id)
{

	global $wpdb;
	$workouttable = $wpdb->prefix."gmgt_nutrition_data";
	$workoutdata =$wpdb->get_results("SELECT *FROM ".$workouttable." Where nutrition_id = $id");

	return $workoutdata;

}
//SET NUTRISION AARAY FUNCTION
function set_nutrition_array($data)
{
	$workout_array=array();
	foreach($data as $row)
	{
		$workout_array[$row->day_name][]= "<span class='col-md-3 col-sm-3 col-xs-12 nutrition_time'>".$row->nutrition_time."</span>
			<span class='col-md-9 col-sm-9 col-xs-12'>".$row->nutrition_value." </span>";
		
	}
	return $workout_array;

}
//----------LICENCE KEY REGISTRAION CODE-------------
function gmgt_verify_pkey()
{
	//$api_server = '192.168.1.22';
	//$api_server = 'http://license.dasinfomedia.com';
	$api_server = 'license.dasinfomedia.com';
	$fp = fsockopen($api_server,80, $errno, $errstr, 2);
	$location_url = admin_url().'admin.php?page=gmgt_system';
	if (!$fp)
              $server_rerror = 'Down';
        else
              $server_rerror = "up";
	if($server_rerror == "up")
	{
	$domain_name= $_SERVER['SERVER_NAME'];
	$licence_key = $_REQUEST['licence_key'];
	$email = $_REQUEST['enter_email'];
	$data['domain_name']= $domain_name;
	$data['licence_key']= $licence_key;
	$data['enter_email']= $email;

	//$verify_result = amgt_submit_setupform($data);
	$result = gmgt_check_productkey($domain_name,$licence_key,$email);
	if($result == '1')
	{
		$message = 'Please provide correct Envato purchase key.';
			$_SESSION['gmgt_verify'] = '1';
	}
	elseif($result == '2')
	{
		$message = 'This purchase key is already registered with the different domain. If have any issue please contact us at sales@dasinfomedia.com ';
			$_SESSION['gmgt_verify'] = '2';
	}
	elseif($result == '3')
	{
		$message = 'There seems to be some problem please try after sometime or contact us on sales@dasinfomedia.com';
			$_SESSION['gmgt_verify'] = '3';
	}
	elseif($result == '4')
	{
		$message = 'Please provide correct Envato purchase key for this plugin.';
			$_SESSION['gmgt_verify'] = '4';
	}
	else{
		update_option('domain_name',$domain_name,true);
	update_option('licence_key',$licence_key,true);
	update_option('gmgt_setup_email',$email,true);
		$message = 'Success fully register';
			$_SESSION['gmgt_verify'] = '0';
	}
	
	
		$result_array = array('message'=>$message,'gmgt_verify'=>$_SESSION['gmgt_verify'],'location_url'=>$location_url);
		echo json_encode($result_array);
	}
	else
	{
		$message = 'Server is down Please wait some time';
		$_SESSION['gmgt_verify'] = '3';
		$result_array = array('message'=>$message,'gmgt_verify'=>$_SESSION['gmgt_verify'],'location_url'=>$location_url);
	echo json_encode($result_array);
	}
	die();
}
function gmgt_check_ourserver()
{
	//$api_server = 'http://license.dasinfomedia.com';
	$api_server = 'license.dasinfomedia.com';
	//$api_server = '192.168.1.22';
	$fp = @fsockopen($api_server,80, $errno, $errstr, 2);
	$location_url = admin_url().'admin.php?page=gmgt_system';
	if (!$fp)
              return false; /*server down*/
        else
              return true; /*Server up*/
}
function gmgt_check_productkey($domain_name,$licence_key,$email)
{
	
	//$api_server = 'http://license.dasinfomedia.com';
	$api_server = 'license.dasinfomedia.com';
	//$api_server = '192.168.1.22';
	$fp = @fsockopen($api_server,80, $errno, $errstr, 2);
	$location_url = admin_url().'admin.php?page=gmgt_system';
	if (!$fp)
              $server_rerror = 'Down';
        else
              $server_rerror = "up";
	if($server_rerror == "up")
	{
	//$url = 'http://192.168.1.22/php/test/index.php';
	$url = 'http://license.dasinfomedia.com/index.php';
	$fields = 'result=2&domain='.$domain_name.'&licence_key='.$licence_key.'&email='.$email.'&item_name=gym';
	//open connection
	$ch = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);

	//execute post
	$result = curl_exec($ch);
	
	curl_close($ch);
	return $result;
	}
	else{
		return '3';
	}
		
}
/* Setup form submit*/
function gmgt_submit_setupform($data)
{
	$domain_name= $data['domain_name'];
	$licence_key = $data['licence_key'];
	$email = $data['enter_email'];
	
	
	$result = gmgt_check_productkey($domain_name,$licence_key,$email);
	if($result == '1')
	{
		$message = 'Please provide correct Envato purchase key.';
			$_SESSION['gmgt_verify'] = '1';
	}
	elseif($result == '2')
	{
		$message = 'This purchase key is already registered with the different domain. If have any issue please contact us at sales@dasinfomedia.com';
			$_SESSION['gmgt_verify'] = '2';
	}
	elseif($result == '3')
	{
		$message = 'There seems to be some problem please try after sometime or contact us on sales@dasinfomedia.com';
			$_SESSION['gmgt_verify'] = '3';
	}
	if($result == '4')
	{
		$message = 'Please provide correct Envato purchase key for this plugin.';
			$_SESSION['gmgt_verify'] = '1';
	}
	else{
		update_option('domain_name',$domain_name,true);
	update_option('licence_key',$licence_key,true);
	update_option('gmgt_setup_email',$email,true);
		$message = 'Success fully register';
			$_SESSION['gmgt_verify'] = '0';
	}
		
	
	$result_array = array('message'=>$message,'gmgt_verify'=>$_SESSION['gmgt_verify']);
	return $result_array;
}
/* check server live */
function gmgt_chekserver($server_name)
{
	if($server_name == 'localhost')
		{
	
			return true;
		}
		
}
/*Check is_verify*/
function gmgt_check_verify_or_not($result)
{	
	
	$server_name = $_SERVER['SERVER_NAME'];
	$current_page = isset($_REQUEST['page'])?$_REQUEST['page']:'';
	$pos = strrpos($current_page, "gmgt_");	
	
	if($pos !== false)			
	{
		if($server_name == 'localhost')
		{
			return true;
		}
		else
		{
			if($result == '0')
			{
				return true;
			}
		}
		return false;
	}
	
}
//GET PAGE FUNCTION
function gmgt_is_gmgtpage()
{
	$current_page = isset($_REQUEST['page'])?$_REQUEST['page']:'';
	$pos = strrpos($current_page, "gmgt_");	
	
	if($pos !== false)			
	{
		return true;
	}
	return false;
}
//GET TIME PERIOD FOR CLASS FUNCTUION
function gmgt_timeperiod_for_class_member(){
	if($_REQUEST['timeperiod']=='limited'){ ?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="on_of_member"><?php _e('No Of Member','gym_mgt');?></label>
			<div class="col-sm-8">
				<input id="on_of_member" class="form-control text-input" type="number" min="0" onkeypress="if(this.value.length==4) return false;" value="<?php if($edit){ echo $result->on_of_member;}elseif(isset($_POST['on_of_member'])) echo $_POST['on_of_member'];?>" name="on_of_member">
			</div>
		</div>
<?php }
die;
}
function gmgt_timeperiod_for_class_number(){
	if($_REQUEST['timeperiod']=='limited'){ ?>
		<div class="form-group">
			<label class="col-sm-2 control-label " for="on_of_classis "><?php _e('No Of Class','gym_mgt');?></label>
			<div class="col-sm-8">
				<input id="on_of_classis" class="form-control text-input phone_validation" type="number" min="0" onkeypress="if(this.value.length==4) return false;" value="<?php if($edit){ echo $result->on_of_classis;}elseif(isset($_POST['on_of_classis'])) echo $_POST['on_of_classis'];?>" name="on_of_classis">
			</div>
		</div>
<?php }
die;
}
//GET CLASS BY MEMER ID
function gmgt_get_class_id_by_membership()
{ 
	global $wpdb;
	$tbl_gmgt_membership_class = $wpdb->prefix."gmgt_membership_class";	
	$retrive_data = $wpdb->get_results("SELECT * FROM $tbl_gmgt_membership_class WHERE membership_id=".$_REQUEST['membership_id']);
	if(!empty($retrive_data))
	{
		foreach($retrive_data as $key=>$value)
		{
			print '<option value="'. $value->class_id .'">'.gmgt_get_class_name($value->class_id).'</option>';
		}
	} 
	else
	{
		$obj_class = new MJ_Gmgtclassschedule();
		$classdata = $obj_class->get_all_classes();
		if(!empty($classdata))
		{
			foreach($classdata as $key=>$value)
			{
				print '<option value="'. $value->class_id .'">'.gmgt_get_class_name($value->class_id).'</option>';
			}
		}
	} 
die;
}
//CHECK MEMBERSHIP LIMIT STATUS FUNCTION
function gmgt_check_membership_limit_status(){
	
	global $wpdb;
	$obj_membership = new MJ_Gmgtmembership();
	$tbl_membership = $wpdb->prefix .'gmgt_membershiptype';
	$result = $wpdb->get_row("SELECT * FROM $tbl_membership WHERE membership_id=".$_REQUEST['membership_id']);
	if($result->membership_class_limit=='limited'){		
		print '<input name="no_of_class" type="hidden" value="'.$result->on_of_classis .'">';
	}
	
die;
}
//GET USER ROLE FUNCTION
function gmgtGetRoleName($rolename)
{
	$return_role="";
	if($rolename=="staff_member")
		$return_role=__('Staff Members','gym_mgt');
	if($rolename=="accountant")
		$return_role=__('Accountant','gym_mgt');
	if($rolename=="member")
		$return_role=__('Member','gym_mgt');
	if($rolename=="all")
		$return_role=__('All','gym_mgt');
	return $return_role;
}
//add_action('init','check_approve_user');
function check_approve_user($user_id)
{	
	return $userdata = get_user_meta($user_id,'gmgt_hash',true);
}
function measurement_counts_lable_array($key)
{
	 $measurement_counts=array(	'Height'=>get_option('gmgt_height_unit'),
								'Weight'=>get_option('gmgt_weight_unit'),
								'Chest'=>get_option('gmgt_chest_unit'),
								'Waist'=>get_option('gmgt_waist_unit'),
								'Thigh'=>get_option('gmgt_thigh_unit'),
								'Arms'=>get_option('gmgt_arms_unit'),
								'Fat'=>get_option('gmgt_fat_unit'));
			
	return $measurement_counts[$key];		
}
function gmgtGetStaffMemberById($id)
{		
		global $wpdb;
		$table_class = $wpdb->prefix. 'gmgt_class_schedule';
		$result = $wpdb->get_results("select *FROM $table_class where class_id= ".$id);
		return $result;
	
}

// REPLACE STRING FUNTION FOR MAIL TEMPLATE
function gmgt_string_replacemnet($arr,$message){
	$data = str_replace(array_keys($arr),array_values($arr),$message);
	return $data;
}

// REPLACE STRING FUNTION FOR MAIL TEMPLATE
function gmgt_subject_string_replacemnet($sub_arr,$subject){
	$data = str_replace(array_keys($sub_arr),array_values($sub_arr),$subject);
	return $data;
} 
// SEND MAIL FUNCTION FOR NOTIFICATION
function gmgt_send_mail($emails,$subject,$message)
{	
	$gymname=get_option('gmgt_system_name');
	$headers="";
    $headers.= 'From: '.$gymname.' <noreplay@gmail.com>' . "\r\n";
	$headers.= "MIME-Version: 1.0\r\n";
    $headers.= 'Content-type: text/plain; charset=iso-8859-1' . "\r\n";
	$enable_notofication=get_option('gym_enable_notifications');
	if($enable_notofication=='yes'){
	return wp_mail($emails,$subject,$message,$headers);
	}

}  

// SEND MAIL WITH HTML FUNCTION FOR NOTIFICATION
function gmgt_send_mail_text_html($emails,$subject,$message)
{
    $gymname=get_option('gmgt_system_name');
	$headers="";
    $headers.= 'From: '.$gymname.' <noreplay@gmail.com>' . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
	$enable_notofication=get_option('gym_enable_notifications');
	if($enable_notofication=='yes'){
	return wp_mail($emails,$subject,$message,$headers);
	}
} 

function Assign_Workouts_Add_Html_Content($assign_workout_id)
{
	$message='';
	$message.='<html>
          <head>
         <title>A Responsive Email Template</title>
          <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<style type="text/css">
    /* CLIENT-SPECIFIC STYLES */
    body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} /* Prevent WebKit and Windows mobile changing default text sizes */
    table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} /* Remove spacing between tables in Outlook 2007 and up */
    img{-ms-interpolation-mode: bicubic;} /* Allow smoother rendering of resized image in Internet Explorer */

    /* RESET STYLES */
    img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}
    table{border-collapse: collapse !important;}
    body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}

    /* iOS BLUE LINKS */
    a[x-apple-data-detectors] {
        color: inherit !important;
        text-decoration: none !important;
        font-size: inherit !important;
        font-family: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
    }

    /* MOBILE STYLES */
    @media screen and (max-width: 525px) {

        /* ALLOWS FOR FLUID TABLES */
        .wrapper {
          width: 100% !important;
        	max-width: 100% !important;
        }

        /* ADJUSTS LAYOUT OF LOGO IMAGE */
        .logo img {
          margin: 0 auto !important;
        }

        /* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */
        .mobile-hide {
          display: none !important;
        }

        .img-max {
          max-width: 100% !important;
          width: 100% !important;
          height: auto !important;
        }

        /* FULL-WIDTH TABLES */
        .responsive-table {
          width: 100% !important;
        }
		

        /* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
        .padding {
          padding: 10px 5% 15px 5% !important;
		  
        }

        .padding-meta {
          padding: 30px 5% 0px 5% !important;
          text-align: center;
        }

        .padding-copy {
     		padding: 10px 5% 10px 5% !important;
          text-align: center;
        }

        .no-padding {
          padding: 0 !important;
        }

        .section-padding {
          padding: 50px 15px 50px 15px !important;
        }

        /* ADJUST BUTTONS ON MOBILE */
        .mobile-button-container {
            margin: 0 auto;
            width: 100% !important;
        }

        .mobile-button {
            padding: 15px !important;
            border: 0 !important;
            font-size: 16px !important;
            display: block !important;
        }

    }

    /* ANDROID CENTER FIX */
    div[style*="margin: 16px 0;"] { margin: 0 !important; }
</style>
<!--[if gte mso 12]>
<style type="text/css">
.mso-right {
	padding-left: 20px;
}
</style>
<![endif]-->
</head>
<body style="margin: 0 !important; padding: 0 !important;">';
		           //$assign_workout_id='118';
						global $wpdb;
						$table_workout = $wpdb->prefix. 'gmgt_assign_workout';
						$result = $wpdb->get_row("SELECT * FROM $table_workout where workout_id=".$assign_workout_id);
						
						$workoutid=$result->workout_id;
						
						$workouttable = $wpdb->prefix."gmgt_workout_data";
						$all_logdata =$wpdb->get_results("SELECT *FROM ".$workouttable." Where workout_id = $workoutid");
						
						//$all_logdata=get_workoutdata($row->workout_id); //var_dump($workout_logdata);
						$arranged_workout=set_workoutarray($all_logdata); 
					 $message.=' Start From <span style="color: #f25656;
             font-style: italic;" >'.getdate_in_input_box($result->start_date).'</span> To <span style="color: #f25656;
              font-style: italic;">'.getdate_in_input_box($result->end_date).'</span> ';
					
					$message.='<table style="border-collapse: collapse; width: 100%; float: left;">
					  <thead>
						<tr>
							<th style="padding: 8px; text-align: left; border-bottom: 2px solid #ddd;">'. __("Day Name","gym_mgt") .'</th>
							<th  style="padding: 3px; text-align: left; border-bottom: 2px solid #ddd;"> '.__("Activity","gym_mgt").'</th>
							<th  style="padding: 3px; text-align: left; border-bottom: 2px solid #ddd;">'. __("Sets","gym_mgt").'</th>
							<th  style="padding: 3px; text-align: left; border-bottom: 2px solid #ddd;">'. __("Reps","gym_mgt").'</th>
							<th  style="padding: 3px; text-align: left; border-bottom: 2px solid #ddd;">'.__("KG","gym_mgt").'</th>
							<th  style="padding: 3px; text-align: left; border-bottom: 2px solid #ddd;">'.__("Rest Time","gym_mgt").'</th>
						</tr>
					  </thead> <tbody>  ';
							  
			   foreach($arranged_workout as $key=>$rowdata)
				{ 
					
					$i=count($rowdata)+1;
				$message.='<tr>
                      <td rowspan="'.$i.'" style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd; "> '.$key.'</td>';
					 
						foreach($rowdata as $row)
						{
							
							$asd = explode('<span',$row);
	 								$message.='<tr>
									<td style="padding: 8px;border-bottom: 1px solid #ddd;"><span'.$asd[1].'</td>
									<td style="padding: 8px;border-bottom: 1px solid #ddd;"><span'.$asd[2].'</td>
									<td style="padding: 8px;border-bottom: 1px solid #ddd;"><span'.$asd[3].'</td>
									<td style="padding: 8px;border-bottom: 1px solid #ddd;"><span'.$asd[4].'</td>
									<td style="padding: 8px;border-bottom: 1px solid #ddd;"><span'.$asd[5].'</td></tr>';
									
						} 
						 $message.='</tr>';	
					
					//$j++;	
			    }
				$message.='
					</tbody>
	 				</table>';
					
					return $message;
	}
	
	function asign_nutristion_content_send_mail($id)
	{
		 $message='';
		 $message.='<html>
         <head>
         <title>A Responsive Email Template</title>
         <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	   <style type="text/css">
		/* CLIENT-SPECIFIC STYLES */
		body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} /* Prevent WebKit and Windows mobile changing default text sizes */
		table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} /* Remove spacing between tables in Outlook 2007 and up */
		img{-ms-interpolation-mode: bicubic;} /* Allow smoother rendering of resized image in Internet Explorer */

		
		.panel-title{
		font-size: 14px;
		float: left;
		margin: 0;
		padding: 0;
		font-weight: 600;
	}

		/* RESET STYLES */
		img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}
		table{border-collapse: collapse !important;}
		body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}

		/* iOS BLUE LINKS */
		a[x-apple-data-detectors] {
			color: inherit !important;
			text-decoration: none !important;
			font-size: inherit !important;
			font-family: inherit !important;
			font-weight: inherit !important;
			line-height: inherit !important;
		}

		/* MOBILE STYLES */
		@media screen and (max-width: 525px) {

			/* ALLOWS FOR FLUID TABLES */
			.wrapper {
			  width: 100% !important;
				max-width: 100% !important;
			}

			/* ADJUSTS LAYOUT OF LOGO IMAGE */
			.logo img {
			  margin: 0 auto !important;
			}

			/* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */
			.mobile-hide {
			  display: none !important;
			}

			.img-max {
			  max-width: 100% !important;
			  width: 100% !important;
			  height: auto !important;
			}

			/* FULL-WIDTH TABLES */
			.responsive-table {
			  width: 100% !important;
			}

			/* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
			.padding {
			  padding: 10px 5% 15px 5% !important;
			}

			.padding-meta {
			  padding: 30px 5% 0px 5% !important;
			  text-align: center;
			}

			.padding-copy {
				padding: 10px 5% 10px 5% !important;
			  text-align: center;
			}

			.no-padding {
			  padding: 0 !important;
			}

			.section-padding {
			  padding: 50px 15px 50px 15px !important;
			}

			/* ADJUST BUTTONS ON MOBILE */
			.mobile-button-container {
				margin: 0 auto;
				width: 100% !important;
			}

			.mobile-button {
				padding: 15px !important;
				border: 0 !important;
				font-size: 16px !important;
				display: block !important;
			}

		}
		/* ANDROID CENTER FIX */
		div[style*="margin: 16px 0;"] { margin: 0 !important; }
		</style>
		<!--[if gte mso 12]>
		<style type="text/css">
		.mso-right {
			padding-left: 20px;
		}
		</style>
		<![endif]-->
		</head>
	    <body style="margin: 0 !important; padding: 0 !important;">';
		$obj_nutrition=new MJ_Gmgtnutrition;
		//$id=$nutrition_id;
		$result=$obj_nutrition->get_single_nutrition($id);
		$all_logdata=get_nutritiondata($result->id); //var_dump($workout_logdata);
		$arranged_workout=set_nutrition_array($all_logdata);
	   $message.=' Start From <span style="color: #f25656;
	   font-style: italic;" >'.getdate_in_input_box($result->start_date).'</span> To <span style="color: #f25656;
	   font-style: italic;">'.getdate_in_input_box($result->expire_date).'</span> ';
        
			if(!empty($arranged_workout))
			{
			$message.='<table style="border-collapse: collapse; width: 100%; float: left;">
						  <thead>
							<tr>
								<th style="padding: 8px; text-align: left; border-bottom: 2px solid #ddd;">'. __("Day Name","gym_mgt") .'</th>
								<th  style="padding: 8px; text-align: left; border-bottom: 2px solid #ddd;">'. __("Time","gym_mgt").'</th>
								<th  style="padding: 8px; text-align: left; border-bottom: 2px solid #ddd;">'. __("Description","gym_mgt").'</th>
							</tr>
						  </thead> <tbody> ';
			foreach($arranged_workout as $key=>$rowdata){ 
		   $message.='<tr>
		  <td rowspan=4 style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd; "> '.$key.'</td>
			';
				 foreach($rowdata as $row){
					  $asd = explode('<span',$row);
					   // var_dump($asd);die;
						$message.='<tr>
						<td rowspan=1 style="padding: 8px;border-bottom: 1px solid #ddd;"><span'.$asd[1].'</td>
						<td rowspan=1 style="padding: 8px;border-bottom: 1px solid #ddd;"><span'.$asd[2].'</td></tr>';
				 }
				$message.=' </tr>';
				 }
		$message.='
		</tbody>
		</table>';
			}
	$message.='</body>
</html>';
		//var_dump($message);exit;
	return $message;
	}
			 

function submit_workout_html_content($workoutmember_id,$tcurrent_date)
{
	     $message='';
		 $message.='<html>
          <head>
         <title>A Responsive Email Template</title>
          <meta charset="utf-8">
		   <meta name="viewport" content="width=device-width, initial-scale=1">
		   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
		   <style type="text/css">

			*   {
			/* CLIENT-SPECIFIC STYLES */
			body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} /* Prevent WebKit and Windows mobile changing default text sizes */
			table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} /* Remove spacing between tables in Outlook 2007 and up */
			img{-ms-interpolation-mode: bicubic;} /* Allow smoother rendering of resized image in Internet Explorer */

			/* RESET STYLES */
			img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}
			table{border-collapse: collapse !important;}
			body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}
		   
			/* iOS BLUE LINKS */
			  a[x-apple-data-detectors] {
				color: inherit !important;
				text-decoration: none !important;
				font-size: inherit !important;
				font-family: inherit !important;
				font-weight: inherit !important;
				line-height: inherit !important;
			}

			/* MOBILE STYLES */
			@media screen and (max-width: 525px) {

				/* ALLOWS FOR FLUID TABLES */
				.wrapper {
				  width: 100% !important;
					max-width: 100% !important;
				}

				/* ADJUSTS LAYOUT OF LOGO IMAGE */
				.logo img {
				  margin: 0 auto !important;
				}

				/* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */
				.mobile-hide {
				  display: none !important;
				}

				.img-max {
				  max-width: 100% !important;
				  width: 100% !important;
				  height: auto !important;
				}

				/* FULL-WIDTH TABLES */
				.responsive-table {
				  width: 100% !important;
				}

				/* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
				.padding {
				  padding: 10px 5% 15px 5% !important;
				}

				.padding-meta {
				  padding: 30px 5% 0px 5% !important;
				  text-align: center;
				}

				.padding-copy {
					padding: 10px 5% 10px 5% !important;
				  text-align: center;
				}

				.no-padding {
				  padding: 0 !important;
				}

				.section-padding {
				  padding: 50px 15px 50px 15px !important;
				}

				/* ADJUST BUTTONS ON MOBILE */
				.mobile-button-container {
					margin: 0 auto;
					width: 100% !important;
				}

				.mobile-button {
					padding: 15px !important;
					border: 0 !important;
					font-size: 16px !important;
					display: block !important;
				}
			}

				/* ANDROID CENTER FIX */
				div[style*="margin: 16px 0;"] { margin: 0 !important; }
			</style>
			<!--[if gte mso 12]>
			<style type="text/css">
			.mso-right {
				padding-left: 20px;
			}
			</style>
			<![endif]-->
			</head>
		    <body style="margin: 0 !important; padding: 0 !important;">';
		           
		    $obj_workout=new MJ_Gmgtworkout;
		    $message='';
			$today_workouts=$obj_workout->get_member_today_workouts($workoutmember_id,$tcurrent_date); 
			
				foreach($today_workouts as $value)
				{
					$workoutid=$value->user_workout_id;
					$activity_name=$value->workout_name;
					$workflow_category=$obj_workout->get_user_workouts($workoutid,$activity_name);
				       $message.='<table style="border-collapse: collapse; margin-bottom: 30px; width: 100%;">
						  <thead style="float: left;width: 100%;">
							<tr>
							<h2>
								<th style="float: left;font-weight: bold;font-size: 22px;">'.$value->workout_name .'</th></h2>
								</tr>
						  </thead><tbody style="float: left;width: 100%;">';
					
						$message.='<tr style="margin-bottom: 11px; margin-top: 42px; float: left;width: 100%;margin-left: 10px;">
						<td style="background-color: #02967d; border-radius: 50%;color: #ffffff;float: left;height: 23px;padding: 5px; position: relative; text-align: center;width: 30px;z-index: 1 !important;">'.'1'.'</td>
						<td style="background-color: #1db198; padding: 8px; border-radius: 15px;  text-align: center; width: 26%; float:left; position: relative; color: #fff;left: -39px;">'. $value->sets .' Sets</td>
						<td style="padding: 11px; color: #4e5e6a;float: left; font-size: 18px; font-weight: bold; margin-left: 8px;">'.$workflow_category->sets .' Sets</td></tr>';
					
					$message.='<tr style="margin-bottom: 11px; margin-top: 42px; float: left;width: 100%;margin-left: 10px;">
						<td style="background-color: #02967d; border-radius: 50%;color: #ffffff;float: left;height: 23px;padding: 5px; position: relative; text-align: center;width: 30px;z-index: 1 !important;">'.'2'.'</td>
						<td style="background-color: #1db198; padding: 8px; border-radius: 15px;  text-align: center; width: 26%; float:left; position: relative; color: #fff;left: -39px;">'. $value->reps .' Reps</td>
						<td style="padding: 11px; color: #4e5e6a;float: left; font-size: 18px; font-weight: bold; margin-left: 8px;">'.$workflow_category->reps .' Reps</td></tr>';
					
					$message.='<tr style="margin-bottom: 11px; margin-top: 42px; float: left;width: 100%;margin-left: 10px;">
						<td style="background-color: #02967d; border-radius: 50%;color: #ffffff;float: left;height: 23px;padding: 5px; position: relative; text-align: center;width: 30px;z-index: 1 !important;">'.'3'.'</td>
						<td style="background-color: #1db198; padding: 8px; border-radius: 15px;  text-align: center; width: 26%; float:left; position: relative; color: #fff;left: -39px;">'. $value->kg.' Kg</td>
						<td style="padding: 11px; color: #4e5e6a;float: left; font-size: 18px; font-weight: bold; margin-left: 8px;">'.$workflow_category->kg .' Kg</td></tr>';
					
					$message.='<tr style="margin-bottom: 11px; margin-top: 42px; float: left;width: 100%;margin-left: 10px;">
						<td style="background-color: #02967d; border-radius: 50%;color: #ffffff;float: left;height: 23px;padding: 5px; position: relative; text-align: center;width: 30px;z-index: 1 !important;">'.'4'.'</td>
						<td style="background-color: #1db198; padding: 8px; border-radius: 15px;  text-align: center; width: 26%; float:left; position: relative; color: #fff;left: -39px;">'. $value->time .' Rest Time</td>
						<td style="padding: 11px; color: #4e5e6a;float: left; font-size: 18px; font-weight: bold; margin-left: 8px;">'.$workflow_category->rest_time .' Rest Time</td></tr>';
					
						$message.='
								</tbody>
							</table>';
				} 
				
				
				
				
				  /*   if(!empty($today_workouts))
					 {
						 $message.='<table style="border-collapse: collapse; margin-bottom: 30px; width: 100%;">';
							 foreach($today_workouts as $value)
							{
								$workoutid=$value->user_workout_id;
								$activity_name=$value->workout_name;
								$workflow_category=$obj_workout->get_user_workouts($workoutid,$activity_name);
								
								
							$message.='<thead style="float: left;">
								<tr>
								<h2>
								  <th style="float: left;font-weight: bold;font-size: 22px;">'.$value->workout_name .'</th></h2>
								</tr>
							  </thead>
							  <tbody style="float: left;">';
							  $message.='<tr style="margin-bottom: 11px; float: left;width: 100%;">
						    <td style="background-color: #02967d; border-radius: 50%;color: #ffffff;float: left;height: 23px;padding: 5px; position: relative; text-align: center;width: 30px;z-index: 1 !important;">'.'1'.'</td>
						    <td style="background-color: #1db198; padding: 8px; border-radius: 15px;  text-align: center; width: 26%; float:left; position: relative; color: #fff;left: -39px;">'. $workflow_category->sets .'Sets</td>
						    <td style="padding: 11px; color: #4e5e6a;float: left; font-size: 18px; font-weight: bold; margin-left: 8px;">'.$value->sets .'Sets</td><td style="background-color: #02967d; border-radius: 50%;color: #ffffff;float: left;height: 23px;padding: 5px; position: relative; text-align: center;width: 30px;z-index: 1 !important;">'.'2'.'</td>
						    <td style="background-color: #1db198; padding: 8px; border-radius: 15px;  text-align: center; width: 26%; float:left; position: relative; color: #fff;left: -39px;">'. $workflow_category->reps .'Reps</td>
						    <td style="padding: 11px; color: #4e5e6a;float: left; font-size: 18px; font-weight: bold; margin-left: 8px;">'.$value->reps .'Reps</td></tr>';
							
							$message.='<tr style="margin-bottom: 11px; float: left;width: 50%;">
						    <td style="background-color: #02967d; border-radius: 50%;color: #ffffff;float: left;height: 23px;padding: 5px; position: relative; text-align: center;width: 30px;z-index: 1 !important;">'.'3'.'</td>
						    <td style="background-color: #1db198; padding: 8px; border-radius: 15px;  text-align: center; width: 26%; float:left; position: relative; color: #fff;left: -39px;">'. $workflow_category->kg .'Kg</td>
						    <td style="padding: 11px; color: #4e5e6a;float: left; font-size: 18px; font-weight: bold; margin-left: 8px;">'.$value->kg .'Kg</td></tr>';
							
							$message.='<tr style="margin-bottom: 11px; float: left;width: 50%;">
						    <td style="background-color: #02967d; border-radius: 50%;color: #ffffff;float: left;height: 23px;padding: 5px; position: relative; text-align: center;width: 30px;z-index: 1 !important;">'.'4'.'</td>
						    <td style="background-color: #1db198; padding: 8px; border-radius: 15px;  text-align: center; width: 26%; float:left; position: relative; color: #fff;left: -39px;">'. $workflow_category->time.'Rest Time</td>
						    <td style="padding: 11px; color: #4e5e6a;float: left; font-size: 18px; font-weight: bold; margin-left: 8px;">'.$value->rest_time .'Rest Time</td></tr></tbody';
							}
					 }
				$message.='</table></body>
				 </html>'; */
				 return $message;
			 
}

//this function use in image validation in add time
function check_valid_extension($filename)
{
	$flag = 2; 
	if($filename != '')
	{
		 $flag = 0;
		 $ext = pathinfo($filename, PATHINFO_EXTENSION);
		 $valid_extension = ['gif','png','jpg','jpeg','bmp',""];
		if(in_array($ext,$valid_extension) )
		{
		  $flag = 1;
		}
	}
      return $flag;
}			
//This function use in document validation in add time
function check_valid_file_extension($filename)
{
	$flag = 2; 
	if($filename != '')
	{
		$flag = 0;
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$valid_extension = ['pdf',""];
		if(in_array($ext,$valid_extension) )
		{
			$flag = 1;
		}
	}
	return $flag;
}
//count total in tax module
function gmgt_count_store_total()
{ 
	$total_amount_withtax=0;
	$discount=$_POST['discount_amount'];
	$quantity=$_POST['quantity'];
	$Product=$_POST['Product'];
	$tax=$_POST['tax'];
	$obj_product=new MJ_Gmgtproduct();
	 $product_data=$obj_product->get_single_product($Product);
	 $price=$product_data->price;
	 $total_price=(int)$price * (int)$quantity;
	 $total_amount_minusdiscount=$total_price - $discount;
	 $total_tax=$total_amount_minusdiscount * $tax/100;
	 $total_amount_withtax=$total_amount_minusdiscount + $total_tax;
	echo $total_amount_withtax;
	die();
} 
function get_format_for_db($date)
{

$date = trim($date);
$new_date = DateTime::createFromFormat(gmgt_get_phpdateformat(get_option('gmgt_datepicker_format')), $date);
$new_date=$new_date->format('Y-m-d');
return $new_date;
}
//Html Tags special character remove from sring
function remove_tags_and_special_characters($string)
{	
	$search = array('!','@','#','$','%','^','&','*','(',')','.','{','}','<','>',',','+','-','*');
	$replace = array('','','','','','','','','','','','','','','','','','','');
	$new_string=str_replace($search, $replace,strip_tags($string));

	return $new_string;
}
//userwise access Right array
function userwise_access_right()
{
	$curr_user_id=get_current_user_id();
	$obj_gym=new MJ_Gym_management($curr_user_id);

	$role = $obj_gym->role;
		
	if($role=='member')
	{ 
		$menu = get_option( 'gmgt_access_right_member');
	
	}
	elseif($role=='staff_member')
	{
		$menu = get_option( 'gmgt_access_right_staff_member');
	}
	elseif($role=='accountant')
	{
		$menu = get_option( 'gmgt_access_right_accountant');
	}
	return $menu;
}
//page wise access right
function get_userrole_wise_page_access_right_array()
{
	$curr_user_id=get_current_user_id();
	$obj_gym=new MJ_Gym_management($curr_user_id);

	$role = $obj_gym->role;
		
	if($role=='member')
	{ 
		$menu = get_option( 'gmgt_access_right_member');
	
	}
	elseif($role=='staff_member')
	{
		$menu = get_option( 'gmgt_access_right_staff_member');
	}
	elseif($role=='accountant')
	{
		$menu = get_option( 'gmgt_access_right_accountant');
	}
	
	foreach ( $menu as $key1=>$value1 ) 
	{									
		foreach ( $value1 as $key=>$value ) 
		{				
			if ($_REQUEST ['page'] == $value['page_link'])
			{				
				return $value;
			}
		}
	}	
}
//manually page wise access right
function get_userrole_wise_manually_page_access_right_array($page)
{
	$curr_user_id=get_current_user_id();
	$obj_gym=new MJ_Gym_management($curr_user_id);

	$role = $obj_gym->role;
		
	if($role=='member')
	{ 
		$menu = get_option( 'gmgt_access_right_member');
	
	}
	elseif($role=='staff_member')
	{
		$menu = get_option( 'gmgt_access_right_staff_member');
	}
	elseif($role=='accountant')
	{
		$menu = get_option( 'gmgt_access_right_accountant');
	}
	
	foreach ( $menu as $key1=>$value1 ) 
	{									
		foreach ( $value1 as $key=>$value ) 
		{				
			if ($page == $value['page_link'])
			{				
				return $value;
			}
		}
	}	
}
//dashboard page access right
function page_access_rolewise_accessright_dashboard($page)
{
	$curr_user_id=get_current_user_id();
	$obj_gym=new MJ_Gym_management($curr_user_id);

	$role = $obj_gym->role;
		
	if($role=='member')
	{ 
		$menu = get_option( 'gmgt_access_right_member');
	
	}
	elseif($role=='staff_member')
	{
		$menu = get_option( 'gmgt_access_right_staff_member');
	}
	elseif($role=='accountant')
	{
		$menu = get_option( 'gmgt_access_right_accountant');
	}	
	
	foreach ( $menu as $key1=>$value1 ) 
	{									
		foreach ( $value1 as $key=>$value ) 
		{	
			if ($page == $value['page_link'])
			{				
				if($value['view']=='0')
				{			
					$flage=0;
				}
				else
				{
					$flage=1;
				}
			}
		}
	}	
	
	return $flage;
} 
function access_right_page_not_access_message()
{
	?>
	<script type="text/javascript">
		$(document).ready(function() 
		{	
			alert('You do not have permission to perform this operation.');
			window.location.href='?dashboard=user';
		});
	</script>
<?php
}	
?>