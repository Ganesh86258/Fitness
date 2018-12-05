<?php
/**
 * Class Eonet Manual User Approve Component
 */
namespace ComponentManualUserApprove;

if ( ! defined('ABSPATH') ) die('Forbidden');

use Eonet\Core\EonetComponents;
use ComponentManualUserApprove\classes\Eonet_MUA_UserManager;
use ComponentManualUserApprove\classes\Eonet_MUA_Message;
use ComponentManualUserApprove\classes\Eonet_MUA_Sender;

if(!class_exists('ComponentManualUserApprove\EonetManualUserApprove')) {

	class EonetManualUserApprove extends EonetComponents {

		/**
		 * Slug of the component so we can get its details
		 * @var string
		 */
		public $slug = "manual-user-approve";

		

		/**
		 * Construct the component :
		 */
		public function __construct()
		{

			// -------------------- ACTIONS & FILTERS --------------------

			// Additional checks
			add_action( 'after_setup_theme', array( $this, 'check_status_on_page' ) );

			// Handle user Sign in
			add_action( 'user_register', array( $this, 'send_request_notification_to_admin' ) );
			add_action( 'user_register', array( $this, 'set_user_status' ) );
			add_filter( 'wp_login_errors', array( $this, 'registration_completed_message' ) );
			
			// Handle user Sign on
			add_action( 'wp_login', array( $this, 'track_first_login' ), 10, 2 );
			add_filter( 'login_message', array( $this, 'welcome_message' ) );
			add_filter( 'wp_authenticate_user', array( $this, 'check_status_on_login' ) );
			
			// Handle Lost Password Page
			add_filter( 'allow_password_reset', array( $this, 'allow_password_reset' ), 10, 2 );

			// When the approval status of an user change
			add_action( 'eonet_mua_user_status_updated', array( $this, 'send_notification_to_user_about_status_changing' ), 10, 3);
			add_action( 'eonet_mua_user_denied', array( $this, 'disconnect_user_session' ) );

			// Disable the standard email sent to user when they register, containing user informations
			remove_action( 'network_site_new_created_user',   'wp_send_new_user_notifications' );
			remove_action( 'network_site_users_created_user', 'wp_send_new_user_notifications' );
			remove_action( 'network_user_new_created_user',   'wp_send_new_user_notifications' );
			remove_action( 'register_new_user',      'wp_send_new_user_notifications' );

			// Try to hide the not approved users from any theme or plugin request in frontend
			add_action('pre_get_users', array($this, 'hide_not_approved_users_in_frontend'));

			// BuddyPress compatibility
			add_action( 'bp_init', array($this, 'override_buddypress_templates') );
			add_action( 'template_notices', array($this, 'add_registration_instructions_on_buddypress_page') );
			add_action( 'init', array($this, 'change_behaviors_for_buddypress_compatibility') );

            // Parent Instance :
            parent::__construct($this->slug);
            // Action :
            do_action('eonet_mua_construct');

		}
		
		/**
		 * Generate the welcome message on login page
		 * 
		 * @param $message
		 *
		 * @throws \Exception
		 *
		 * @return mixed|void
		 */
		public function welcome_message($message) {

			if ( isset( $_GET['checkemail'] ) && $_GET['checkemail'] == 'registered')
				return $message;

			if(!empty($message)){
				$message .= '<br>';
			}

			$message .= '<p class="message register">' . Eonet_MUA_Message::get_message_content('welcome_message') . '</p><br>';

			return apply_filters('eonet_mua_welcome_message', $message);
		}

		/**
		 * Display a message the provide instruction after the use regsitration and remove the login form from there
		 * 
		 * @param $errors
		 *
		 * @throws \Exception
		 *
		 * @return \WP_Error
		 */
		public function registration_completed_message($errors) {

			if ( ! ( isset( $_GET['checkemail'] ) && $_GET['checkemail'] == 'registered') ) {
				return $errors;
			}

			$message = Eonet_MUA_Message::get_message_content('registration_completed');

			$errors->remove( 'registered');
			$errors->add( 'registered', $message,  'message');

			return $errors;
		}

		/**
		 * Save a flag that ensure if an user has ever loggedin while the plugin is activated
		 * 
		 * @param $user_login
		 * @param $user
		 *
		 * @throws \Exception
		 */
		public function track_first_login($user_login, $user) {
			
			$user_manager = new Eonet_MUA_UserManager($user);
			$user_manager->save_first_access_flag();
			
		}

		/**
		 * Send the email to the user that alert if the approval request has been approved or rejected.
		 * If the request is approved and the user needs to receive the password, a new password will be generated and sent
		 *
		 * @param $status
		 * @param $user_id
		 * @param $alert_user
		 *
		 * @throws \Exception
		 */
		public function send_notification_to_user_about_status_changing($status, $user_id, $alert_user) {

			if(!$alert_user || $status == Eonet_MUA_UserManager::PENDING)
				return;

			$user = get_userdata($user_id);

			$user_manager = new Eonet_MUA_UserManager($user_id);

			// Avoid to send multiple times the same email
			if ($status == $user_manager->get_user_status())
				return;

			$sender = new Eonet_MUA_Sender();
			$sender->setTo($user->user_email);

			if($status == Eonet_MUA_UserManager::APPROVED) {

				$sender->setSubject( Eonet_MUA_Message::get_message_content( 'email_subject_account_has_been_approved' ) );
				
				//Create the password to send to the user
				$password     = $user_manager->reset_password();

				$args = array('user_id' => $user_id, 'password' => $password);

				$sender->setMessage( Eonet_MUA_Message::get_message_content( 'email_body_account_has_been_approved', $args ) );

			} else {

				$args = array('user_id' => $user_id);
				
				$sender->setSubject( Eonet_MUA_Message::get_message_content( 'email_subject_account_has_been_denied' ) );

				$sender->setMessage( Eonet_MUA_Message::get_message_content( 'email_body_account_has_been_denied', $args ) );
			}

			$sender->send();
			
		}

		/**
		 * Send an email to the admin in order to alert the a new user requests to be approved
		 *
		 * @param $user_id
		 *
		 * @throws \Exception
		 */
		public function send_request_notification_to_admin($user_id){

			$email_to_admin = (bool) eonet_get_option( 'mua_email_to_admin_enabled', true );

			// If the user is created by admin or if the admin alert is disabled, doesn't send the email to the admin
			if ($this->is_admin_cration_process() || !$email_to_admin)
				return;

			$args = array('user_id' => $user_id);

			/*
			 * We send one email per admin
			 */
			$admins = get_users(array(
				'role'    => 'administrator',
			));

			foreach ($admins as $admin) {

				$sender = new Eonet_MUA_Sender();

				$sender->setTo( apply_filters( 'eonet_mua_admin_notification_email', $admin->user_email ) );

				$sender->setSubject( Eonet_MUA_Message::get_message_content( 'email_subject_approval_request_to_admin', $args ) );

				$sender->setMessage( Eonet_MUA_Message::get_message_content( 'email_body_approval_request_to_admin', $args ) );

				$sender->send();

			}
		}

		/**
		 * Set the status of the user right after the registration
		 *
		 * @param $user_id
		 *
		 * @throws \Exception
		 */
		public function set_user_status( $user_id ) {
			$status = Eonet_MUA_UserManager::PENDING;

			// If the user is created by admin in the backend, than automatically approve him
			if ( $this->is_admin_cration_process() ) {
				$status = Eonet_MUA_UserManager::APPROVED;
			}

			$user_manager = new Eonet_MUA_UserManager($user_id);

			//The user have to be not alerted on status creation, it will be always pending or approved
			$alert_user = false;

			$user_manager->save_status($status, $alert_user);
		}

		/**
		 * Check the status of an user on login
		 *
		 * @param $user
		 *
		 * WP_Error
		 *
		 * @return \WP_Error|\WP_User
		 * @throws \Exception
		 */
		public function check_status_on_login( \WP_User $user) {
			
			$user_manager = new Eonet_MUA_UserManager($user);
			$status = $user_manager->get_user_status();

			do_action('eonet_mua_before_check_status_on_login', $status, $user);
			
			switch ( $status ) {
				case Eonet_MUA_UserManager::APPROVED:
					return $user;
					break;
				case Eonet_MUA_UserManager::PENDING:
					$message = Eonet_MUA_Message::get_message_content('authentication_pending');
					return new \WP_Error( 'pending_approval', $message );
					break;
				case Eonet_MUA_UserManager::DENIED:
					$message = Eonet_MUA_Message::get_message_content('authentication_denied');
					return new \WP_Error( 'denied_access', $message );
					break;
			}

		}

		/**
		 * Check on every page if the current user is actual approved, otherwise logout him
		 * This is an additional protection against that themes or plugins that login users automatically after sign up
		 */
		public function check_status_on_page( ) {

			if( !is_user_logged_in() )
				return;

			$user_manager = new Eonet_MUA_UserManager();
			$status = $user_manager->get_user_status();

			do_action('eonet_mua_before_check_status_on_page', $status, $user_manager);

			if ( $status == Eonet_MUA_UserManager::APPROVED )
				return;

			wp_logout();

		}

		/**
		 * Check the $_REQUEST variable to understand if the user currently created is created by admin in the backend or noth
		 *
		 * @return bool
		 */
		protected function is_admin_cration_process() {
			return ( isset( $_REQUEST['action'] ) && 'createuser' == $_REQUEST['action'] );
		}

		/**
		 * Disconnect an user selected by id
		 * 
		 * @param $user_id
		 */
		public function disconnect_user_session($user_id) {

			// get all sessions for user with ID $user_id
			$sessions = \WP_Session_Tokens::get_instance($user_id);

			// we have got the sessions, destroy them all!
			$sessions->destroy_all();
		}

		/**
		 * If the user is not approved, disalow to reset the password fom Lost Passwod form and display an error message
		 *
		 * @param $result
		 * @param $user_id
		 *
		 * @throws \Exception
		 *
		 * @return \WP_Error
		 */
		public function allow_password_reset( $result, $user_id ) {
			
			$user_manager = new Eonet_MUA_UserManager($user_id);
						
			if ( ! $user_manager->is_approved() ) {

				$error_message = Eonet_MUA_Message::get_message_content('message_reset_password_not_allowed', array('status' => $user_manager->get_user_status()) );

				$result = new \WP_Error( 'user_not_approved', $error_message );
			}

			return $result;
		}

		/**
		 * Function called on action pre_get_users, it remove all users not approved when the request is don by frontend,
		 * in this way it ensure a compatibility with all other plugin and themes, avoiding to show unapproved users
		 * (for instance in members page of buddypress or Extrafooter of Woffice)
		 *
		 * @param \WP_Query $query
		 */
		public function hide_not_approved_users_in_frontend($query){
			
			// If this is not a frontend page, then do nothing
			if (is_admin())
				return;

			if (isset($query->query_vars['eonet_mua_ignore_users_hiding']) && $query->query_vars['eonet_mua_ignore_users_hiding'])
				return;

			// Otherwise display only approved users
			$meta_query = array(
			'relation' => 'OR',
				array(
					'key' => 'eonet_mua_status',
					'compare' => 'NOT EXISTS', // works!
					'value' => '' // This is ignored, but is necessary...
				),
				array(
					'key' => 'eonet_mua_status',
					'value' => Eonet_MUA_UserManager::APPROVED
				)
			);

			$meta_query = apply_filters('eonet_mua_hide_not_approved_users_in_frontend', $meta_query, $query);

			if(!empty($meta_query))
				$query->set( 'meta_query', $meta_query );
		}


		/**
		 * Override BuddyPress templates
		 */
		public function override_buddypress_templates(){

			if( function_exists( 'bp_register_template_stack' ) )
				bp_register_template_stack( array($this, 'register_buddypress_template_location') );

			if (bp_is_user())
				add_filter( 'bp_get_template_part', array($this, 'replace_buddypress_active_user_template'), 10, 3 );
		}

		/**
		 * Replace the BuddyPress template activate
		 *
		 * @param $templates
		 * @param $slug
		 * @param $name
		 *
		 * @return array
		 */
		public function replace_buddypress_active_user_template( $templates, $slug, $name ) {

			if( 'members/activate' != $slug )
				return $templates;

			return array( 'members/activate.php' );
		}

		/**
		 * Set the path of the plugin where are stored the BuddyPress templates
		 *
		 * @return string
		 */
		public function register_buddypress_template_location() {
			return dirname( __FILE__ ) . '/templates/';
		}

		/**
		 * Add a custom message
		 *
		 * @throws \Exception
		 */
		public function add_registration_instructions_on_buddypress_page() {

			global $bp;

			if($bp->theme_compat->templates[0] != 'members/index-register.php')
				return;

			echo '<div id="message" class="bp-template-notice ">';

			echo '<p>' . Eonet_MUA_Message::get_message_content('welcome_message') . '</p>';

			echo '</div>';

		}

		/**
		 * Change the behavior of the BuddyPress capabilities, we remove a few actions
		 */
		public function change_behaviors_for_buddypress_compatibility() {
			if (!class_exists('Buddypress'))
				return;

			add_filter('eonet_mua_avoid_password_reset', '__return_true');

			global $bp;

			if(
				!class_exists('BP_Signup')
				|| !isset($bp->pages->activate)
				|| (function_exists('woffice_is_enabled_confirmation_email') && !woffice_is_enabled_confirmation_email())
			)
				return;

			// Buddypress force to send the standard email to admin when an user is activated, there is no way to override it,
			// so for now, avoid to send this one in order toavoid doubled emails
			// add_action( 'bp_core_activated_user', array( $this, 'send_request_notification_to_admin' ) );

			add_action( 'bp_core_activated_user', array( $this, 'set_user_status' ) );

		}
	}

	
}