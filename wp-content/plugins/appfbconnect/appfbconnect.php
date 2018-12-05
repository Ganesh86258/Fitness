<?php
/*
Plugin Name: App Facebook Connect
Plugin URI: http://apppresser.com
Description: Facebook Connect for AppPresser apps.
Text Domain: appfbconnect
Domain Path: /languages
Version: 2.6.1
Author: AppPresser Team
Author URI: http://apppresser.com
License: GPLv2
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow

/**
 * Main Class.
 */
class AppFBConnect {

	// A single instance of this class.
	public static $instance    = null;
	public static $this_plugin = null;
	public $basename;
	public $directory_path;
	public $directory_url;
	public static $callback_url;
	public static $css_dir_url;
	public static $js_dir_url;
	public static $rewrite_disabled;
	const APPP_KEY             = 'appfbconnect_key';
	const PLUGIN               = 'App Facebook Connect';
	const VERSION              = '2.6.1';

	/**
	 * run function.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function run() {
		if ( self::$instance === null )
			self::$instance = new self();

		return self::$instance;
	}

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {

		self::$this_plugin = plugin_basename( __FILE__ );

		// is main plugin active? If not, throw a notice and deactivate
		if ( ! in_array( 'apppresser/apppresser.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			add_action( 'all_admin_notices', array( $this, 'apppresser_required' ) );
			return;
		}

		// Load translations
		load_plugin_textdomain( 'appfbconnect', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

		// Define plugin constants
		$this->basename			=	plugin_basename( __FILE__ );
		$this->directory_path	=	plugin_dir_path( __FILE__ );
		$this->directory_url	=	plugin_dir_url( __FILE__ );
		self::$css_dir_url      =   $this->directory_url . 'css/';
		self::$js_dir_url       =   $this->directory_url . 'js/';

		$this->hooks();

	}

	public function hooks() {
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts_styles' ) );
		add_action( 'plugins_loaded', array( $this, 'includes' ) );
		add_action( 'wp_ajax_appp_wp_fblogin', array( $this, 'fb_login_user' ) );
		add_action( 'wp_ajax_nopriv_appp_wp_fblogin', array( $this, 'fb_login_user' ) );
		add_action( 'appp_login_modal_after', array( $this, 'modal_fb_button' ) );
		add_action( 'appbuddy_after_loginform', array( $this, 'modal_fb_button' ) );

		// oauth rewrite rule for Facebook's callback to oauthcallback.html (desktop web only)
		add_action( 'init', array( $this, 'oauth_callback_rewrite' ), 10, 0 );
		add_action( 'after_setup_theme', array( $this, 'plugin_activate' ) );
		register_activation_hook( __FILE__, array( $this, 'plugin_activate' ) );
		register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
	}

	/**
	 * scripts_styles function.
	 *
	 * @access public
	 * @return void
	 */
	public function scripts_styles() {

		$translation_array = $this->get_apppfb_settings();

		wp_enqueue_style( 'appfbconnect-css', $this->directory_url .'css/appfbconnect-styles.css', array(), self::VERSION );

		if( method_exists( 'AppPresser', 'is_min_ver' ) && AppPresser::is_min_ver( 2 ) ) { // only v2 or higher
			wp_localize_script( 'jquery', 'apppfb', $translation_array );
		} else {

			wp_register_script( 'appfbconnect', $this->directory_url .'js/facebook-connect.js', array('jquery'), self::VERSION );
			wp_register_script( 'openfb-appp', $this->directory_url .'js/openfb.js', array(), '1.0.0', true );

			wp_localize_script( 'appfbconnect', 'apppfb', $translation_array );

			wp_enqueue_script( 'appfbconnect' );
			wp_enqueue_script( 'openfb-appp' );

		}
	}

	/**
	 * @since 2.6.0
	 */
	public static function get_apppfb_settings() {

		$data = array(
			'id' => appp_get_setting( 'ap3_app_id' ),
		);

		return AppFBConnect_Settings_API::get_apppfb_settings( $data );
	}

	public function includes() {

		require_once $this->directory_path . 'inc/shortcodes.php';
		include $this->directory_path . 'inc/admin.php';
		include $this->directory_path . 'inc/AppFBConnect_Settings_API.php';
		$appFBConnect_Settings_API = new AppFBConnect_Settings_API();
		$appFBConnect_Settings_API->hooks();

		appp_updater_add( __FILE__, self::APPP_KEY, array(
			'item_name' => self::PLUGIN, // must match the extension name on the site
			'version'   => self::VERSION,
		) );

		self::$rewrite_disabled = (appp_get_setting('appfbconnect_disable_rewrite') == 'on');

		AppFBConnect_Shortcodes::run();

	}

	/**
	 * Creates a rewrite url like site-url.com/oauthcallback/
	 * and writes it to wp-content/plugins/appfbconnect/inc/oauthcallback.html
	 */
	public function oauth_callback_rewrite() {

		if( self::$rewrite_disabled ) {
			self::$callback_url = $this->directory_url . 'inc/oauthcallback.html';
			return;
		} else {
			self::$callback_url = site_url( '/oauthcallback/' );
		}

		$site  = site_url('/');
		$path = str_replace($site, '', $this->directory_url);

		add_rewrite_rule( '^oauthcallback/(.*)?', $path . 'inc/oauthcallback.html' );
	}

	public function plugin_activate() {

		if( self::$rewrite_disabled === true ) {
			$this->oauth_callback_rewrite();
		}
		flush_rewrite_rules();
	}

	public function apppresser_required() {
		echo '<div id="message" class="error"><p>'. sprintf( __( '%1$s requires the AppPresser Core plugin to be installed/activated. %1$s has been deactivated.', 'appfbconnect' ), self::PLUGIN ) .'</p></div>';
		deactivate_plugins( self::$this_plugin, true );
	}

	/**
	 * Login user to WordPress if approved through Facebook Connect
	 *
	 * @access public
	 * @return void
	 */
	public function fb_login_user() {

		$is_new_user = false;

		if( isset( $_GET['user_email'] ) ) {
			$user_email = $_GET['user_email'];
		} else if( isset( $_POST['user_email'] ) ) {
			$user_email = $_POST['user_email'];
		} else {
			$user_email = '';
		}


		if( $user_email ) {
			$user = get_user_by( 'email', $user_email );
		} else {
			$user = null;
		}

		if( $user ) {

			$user_id = $user->ID;

			$set_user = wp_set_current_user( $user->ID, $user->user_login );

			wp_set_auth_cookie( $user->ID, true );

			do_action( 'wp_login', $user->user_login, $user );

			update_user_meta( $user->ID, 'appp_fb_loggedin', true );

			if( isset( $_GET['fb_id'] ) ) {
				$fb_id = $_GET['fb_id'];
			} else if( isset( $_POST['fb_id'] ) ) {
				$fb_id = $_POST['fb_id'];
			} else {
				$fb_id = '';
			}

			if( $fb_id ) {
				update_user_meta( $user->ID, 'appp_fb_id', $fb_id );
			}
			
			do_action( 'appp_fb_loggedin', $user->ID );


		} elseif ( appp_get_setting( 'appfbconnect_register' ) == true ) {

			// Create our user

			if( isset( $_GET['full_name'] ) ) {
				$full_name = $_GET['full_name'];
			} else if( isset( $_POST['full_name'] ) ) {
				$full_name = $_POST['full_name'];
			} else {
				$full_name = '';
			}

			if( $full_name === '' ) {
				die('username is missing');
			}

			$user_name = preg_replace('/\s*/', '', $full_name );
			$user_name = strtolower( $user_name );
			$user_name = sanitize_user( $user_name );
			$is_new_user  = true;

			// If there is a duplicate username add 2 or higher to it and test again
			$original_usename = $user_name;
			$unique_username_count = 2;
			while( username_exists( $user_name ) ) {
				$user_name = $original_usename . $unique_username_count++;
			}

			$length=8;
			$include_standard_special_chars=false;
			$random_password = wp_generate_password( $length, $include_standard_special_chars );

			$user_id = wp_create_user( $user_name, $random_password, $user_email );

			// User created, now log them in

			$user = get_user_by( 'id', $user_id );

			$set_user = wp_set_current_user( $user_id, $user->user_login );

			wp_set_auth_cookie( $user_id, true );

			do_action( 'wp_login', $user->user_login, $user );

			update_user_meta( $user->ID, 'appp_fb_loggedin', true );

			if( isset( $_GET['fb_id'] ) ) {
				$fb_id = $_GET['fb_id'];
			} else if( isset( $_POST['fb_id'] ) ) {
				$fb_id = $_POST['fb_id'];
			} else {
				$fb_id = '';
			}

			if( $fb_id ) {
				update_user_meta( $user->ID, 'appp_fb_id', $fb_id );
			}
			
			do_action( 'appp_fb_loggedin', $user_id );
			
		}

		// Admin Setting
		$redirect_url = appp_get_setting( 'appfbconnect_redirect' );

		// New users could go somewhere else if you like
		$redirect_url = apply_filters( 'appfbconnect_redirect', $redirect_url, $user_id, $is_new_user );

		$return = array(
			'message' => sprintf( __('Welcome back %s!', 'apppresser'), $user->display_name),
			'username' => $user->user_login,
			'avatar' => get_avatar_url( $user->ID )
		);
		
		if( $redirect_url ) {

			if( method_exists(AppPresser, 'is_min_ver') && AppPresser::is_min_ver( 3 ) ) { // v3

				// the appfbconnect_redirect hook allows the title to be included with the URL
				// i.e. array( 'title' => 'Some Page', 'url' => 'https://example.com/some-page' )

				if( is_array( $redirect_url ) ) {
					$return['login_redirect'] = $redirect_url;
				} else if( is_string( $redirect_url ) ) {
					$return['login_redirect'] = (method_exists(AppPresser_Ajax_Extras, 'add_redirect_title')) ? AppPresser_Ajax_Extras::add_redirect_title($redirect_url) : $redirect_url;
				}
			} else { // v2
				$return['redirect_url']	= $redirect_url;
				$return['redirect']	= true;
				$return['login_redirect'] = $redirect_url;
			}	
		}

		// Send this to our appfbconnect.wplogin success function, so we know whether to redirect
		wp_send_json($return);

		wp_die();

	}

	public function modal_fb_button() {
		// Adds login with Facebook button to login modal
		echo do_shortcode( '[app-fb-login]' );
	}
}

AppFBConnect::run();