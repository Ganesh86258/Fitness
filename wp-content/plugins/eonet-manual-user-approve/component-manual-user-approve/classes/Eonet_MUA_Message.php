<?php

namespace ComponentManualUserApprove\classes;


use ComponentManualUserApprove\EonetManualUserApprove;

if ( ! defined('ABSPATH') ) die('Forbidden');

/**
 * Handle the messages content ofthe whole plugin
 *
 * Class Eonet_MUA_Message
 *
 * @package ComponentManualUserApprove\classes
 */
class Eonet_MUA_Message {

	/**
	 * Return the message selected by a slug passed as parameter
	 *
	 * @param $message_type
	 *
	 * @param array $args
	 *
	 * @param bool $parse_variables If the variables have to be replaced or not
	 *
	 * @return string
	 * @throws \Exception
	 */
	public static function get_message_content( $message_type, $args = array(), $parse_variables = true ) {

		switch ($message_type) {
			case 'welcome_message':
				return self::welcome_message();
			case 'registration_completed':
				return self::registration_completed();
			case 'buddypress_registration_completed':
				return self::buddypress_registration_completed();
			case 'authentication_pending':
				return self::message_authentication_pending();
			case 'authentication_denied':
				return self::message_authentication_denied();
			case 'message_reset_password_not_allowed':
				return self::message_reset_password_not_allowed($args);
			
			case 'email_subject_approval_request_to_admin':
				return self::email_subject_approval_request_to_admin($args);
			case 'email_body_approval_request_to_admin':
				return self::email_body_approval_request_to_admin($args, $parse_variables);
			case 'email_subject_account_has_been_approved':
				return self::email_subject_account_has_been_approved();
			case 'email_body_account_has_been_approved':
				return self::email_body_account_has_been_approved($args, $parse_variables);
			case 'email_subject_account_has_been_denied':
				return self::email_subject_account_has_been_denied();
			case 'email_body_account_has_been_denied':
				return self::email_body_account_has_been_denied($args, $parse_variables);
			default:
				throw new \Exception('Impossible to get message content: Unkown message slug.');
		}
	}


	/**
	 * Return the welcome message content
	 *
	 * @return string
	 */
	protected static function welcome_message() {
		$default_message = __('This site is accessible to approved users only. After registration, you have to wait for the admin approval before accessing the admin area.', 'eonet-manual-user-approve');

		$message = eonet_get_option('mua_welcome_message');

		if( empty($message))
			$message = $default_message;

		return apply_filters('eonet_mua_welcome_message_content', $message);
	}

	/**
	 * Content of the message that provide instruction on registration completed page
	 */
	protected static function registration_completed(){

		if ( function_exists( 'bp_is_active' ) )
			$default_message = __('Your email was confirmed successfully but your account is still waiting for approval. Once your registration is approved, you will receive an email with further instructions for logging into the site.', 'eonet-manual-user-approve');
		else
			$default_message = __('Registration completed.<br><br>An email has been sent to the admin, once he approves your registration, you will receive your credentials.', 'eonet-manual-user-approve');

		$message = eonet_get_option('mua_registration_completed');

		if( empty($message))
			$message = $default_message;

		return apply_filters('eonet_mua_registration_completed_message', $message);
	}

	/**
	 * Content of the message showed on buddypress user activate page
	 *
	 * @return string
	 */
	protected static function buddypress_registration_completed(){

		$message = self::registration_completed();

		return apply_filters('eonet_mua_buddypress_registration_completed_message', $message);
	}

	/**
	 * Retun the message content that alert user about the pending status of him account during the login process
	 *
	 * @return string
	 */
	protected static function message_authentication_pending(){

		$default_message = '<strong>'.__('ERROR:','eonet-manual-user-approve').'</strong> '. __( 'Your account is still pending approval.', 'eonet-manual-user-approve' );

		$message = eonet_get_option( 'mua_authentication_pending' );

		if( empty($message))
			$message = $default_message;

		return apply_filters('eonet_mua_message_alert_authentication_pending', $message);
	}

	/**
	 * Retun the message content that alert user about the denied status of him account during the login process
	 *
	 * @return string
	 */
	protected static function message_authentication_denied(){

		$default_message =  '<strong>'.__('ERROR:','eonet-manual-user-approve').'</strong> '.__( 'Your account has been denied.', 'eonet-manual-user-approve' );

		$message = eonet_get_option( 'mua_authentication_denied' );

		if( empty($message))
			$message = $default_message;

		return apply_filters('eonet_mua_message_alert_authentication_denied', $message);
	}

	/**
	 * Returns the message content that alert user about the denied status of him account during the login process
	 *
	 * @return string
	 */
	protected static function message_reset_password_not_allowed($args){

		if($args['status'] == Eonet_MUA_UserManager::PENDING)
			$message = '<strong>'.__('ERROR','eonet-manual-user-approve').'</strong> : '.__( "This account is still waiting for the aproval, you cannot reset the password until your account has been approved.", 'eonet-manual-user-approve' );
		else
			$message = '<strong>'.__('ERROR','eonet-manual-user-approve').'</strong> : '.__( "This account is denied access to this site, you cannot reset the password.", 'eonet-manual-user-approve' );

		return apply_filters('eonet_mua_message_reset_password_not_allowed', $message, $args['status']);
	}

	/**
	 * Return the subject of the email that alert the admin about a new user registration
	 *
	 * @param array $args
	 *
	 * @return mixed|void
	 */
	protected static function email_subject_approval_request_to_admin($args = array()) {

		$default_subject = __( 'New user approval request', 'eonet-manual-user-approve' );

		$subject = eonet_get_option( 'mua_email_subject_admin_alert' );

		if( empty($subject))
			$subject = $default_subject;

		return apply_filters( 'eonet_mua_email_subject_approval_request_to_admin', $subject );

	}

	/**
	 * Content of the email that alert the admin about a new user approval request
	 *
	 * @param array $args
	 * @param bool $parse_variables If the variables have to be parsed or not
	 *
	 * @return string
	 */
	protected static function email_body_approval_request_to_admin($args = array(), $parse_variables = true) {

		$default_message = 'You received a new user approval request at site {{$site_name}}.<br>

Username: {{$user_login}}<br>
Email: {{$user_email}}<br>

You can see all the pending users here: <a href="{{$pending_users_url}}">{{$pending_users_url}}</a>
';

		$message = eonet_get_option( 'mua_email_body_admin_alert' );

		if( empty($message))
			$message = $default_message;

		if( $parse_variables )
			$message = self::parse_email_content($message, $args);

		return apply_filters('eonet_mua_email_body_approval_request_to_admin', $message);

	}

	/**
	 * Return the subject of the email that alert the user that him account has been approved
	 *
	 * @return string
	 */
	protected static function email_subject_account_has_been_approved() {

		$default_subject = __( 'Your registration request has been approved', 'eonet-manual-user-approve' );

		$subject = eonet_get_option( 'mua_email_subject_approved' );

		if( empty($subject))
			$subject = $default_subject;

		return apply_filters( 'eonet_mua_email_subject_account_has_been_approved', $subject );

	}

	/**
	 * Body of the email that alert that alert the user that him account has been approved
	 *
	 * @param $args
 	 * @param bool $parse_variables If the variables have to be parsed or not
	 *
	 * @return string
	 * @throws \Exception
	 */
	protected static function email_body_account_has_been_approved($args, $parse_variables = true) {

		$password = (isset($args['password']) && is_string($args['password'])) ? $args['password'] : null;

		$default_message = 'Hello {{$user_login}},
		
Your account has been approved to access to {{$site_name}}.
		
You can access here: {{$access_url}}.';

		$message = eonet_get_option( 'mua_email_body_approved' );

		if( empty($message))
			$message = $default_message;

		if( $parse_variables )
			$message = self::parse_email_content($message, $args);

		if(!empty($password) && !apply_filters('eonet_mua_hide_password_from_email', false)) {
			$message .= "\r\n\r\n";
			$message .= __('Password:', 'eonet-manual-user-approve') . ' '. $password;
		}

		return apply_filters('eonet_mua_email_body_account_has_been_approved', $message);
	}

	/**
	 * Return the subject of the email that alert the user that him account has been denied
	 *
	 * @return string
	 */
	protected static function email_subject_account_has_been_denied() {

		$default_subject = __( 'Your registration request has been denied', 'eonet-manual-user-approve' );

		$subject = eonet_get_option( 'mua_email_subject_denied' );

		if( empty($subject))
			$subject = $default_subject;

		return apply_filters( 'eonet_mua_email_subject_account_has_been_denied', $subject );

	}

	/**
	 * Body of the email that alert that alert the user that him account has been denied
	 *
	 * @param array $args
	 * @param bool $parse_variables If the variables have to be parsed or not
	 *
	 * @return string
	 */
	protected static function email_body_account_has_been_denied($args = array(), $parse_variables = true) {

		$default_message = 'Hello {{$user_login}},

Unfortunately, your registration request for the site {{$site_name}} has been denied by the admin, you are not allowed to access to the site.';

		$message = eonet_get_option( 'mua_email_body_denied' );

		if( empty($message))
			$message = $default_message;

		if( $parse_variables )
			$message = self::parse_email_content($message, $args);


		return apply_filters('eonet_mua_email_body_account_has_been_denied', $message);

	}

	/**
	 * Parse the email contents and replace the variables with the right values
	 *
	 * @param $message
	 * @param $args
	 *
	 * @return mixed|void
	 */
	protected static function parse_email_content( $message, $args) {

		$pending_users_url = admin_url( 'users.php?eonet_mua_approval_status=pending&eonet_mua_filter_status=Filter&paged=1' );
		$pending_users_url = apply_filters('eonet_mua_email_content_pending_uers_url', $pending_users_url);
		$message = str_replace( '{{$pending_users_url}}', $pending_users_url, $message);

		$message = str_replace( '{{$site_name}}', get_bloginfo('name'), $message);

		$message = str_replace( '{{$site_url}}', home_url(), $message);

		$password = (isset($args['password']) && is_string($args['password'])) ? $args['password'] : null;
		$message = str_replace( '{{$password}}', $password, $message);

		$access_url = apply_filters('eonet_mua_approved_access_url', get_home_url());
		$message = str_replace( '{{$access_url}}', $access_url, $message);

		$user_id = (isset($args['user_id']) && !empty($args['user_id'])) ? $args['user_id'] : null;

		if( !is_null($user_id)) {
			$user = get_userdata($user_id);

			$message = str_replace( '{{$user_login}}', $user->user_login, $message);
			$message = str_replace( '{{$user_email}}', $user->user_email, $message);
			$message = str_replace( '{{$user_firstname}}', $user->user_firstname, $message);
			$message = str_replace( '{{$user_lastname}}', $user->user_lastname, $message);
			$message = str_replace( '{{$display_name}}', $user->display_name, $message);

		}

		return apply_filters( 'eonet_mua_parse_email_content', $message);
	}
}