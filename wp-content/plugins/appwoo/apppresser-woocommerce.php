<?php
/*
Plugin Name: AppWoo
Plugin URI: http://apppresser.com
Description: WooCommerce Add-on for AppPresser
Text Domain: apppresser-woocommerce
Domain Path: /languages
Version: 3.0.2
Author: AppPresser Team
Author URI: http://apppresser.com
License: GPLv2
*/

class AppPresser_WooCommerce {

	public $this_plugin = null;
	public $requires    = 'AppPresser Core';
	const APPP_KEY      = 'appwoo_key';
	const PLUGIN        = 'AppWoo';
	const VERSION       = '3.0.2';

	/**
	 * Initiate this plugin
	 * @since  1.0.0
	 */
	public function init() {
		$this->this_plugin = plugin_basename( __FILE__ );

		// Load translations
		load_plugin_textdomain( 'apppresser-woocommerce', false, dirname( $this->this_plugin ) . '/languages/' );

		// Get list of active plugins
		$active = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );

		// is main plugin active? If not, throw a notice and deactivate
		if ( ! in_array( 'apppresser/apppresser.php', $active ) ) {
			add_action( 'all_admin_notices', array( $this, 'apppresser_required' ) );
			return;
		}
		// is main plugin active? If not, throw a notice and deactivate
		elseif ( ! in_array( 'woocommerce/woocommerce.php', $active ) ) {
			$this->requires = 'WooCommerce';
			add_action( 'all_admin_notices', array( $this, 'apppresser_required' ) );
			return;
		}

		appp_updater_add( __FILE__, self::APPP_KEY, array(
			'item_name' => self::PLUGIN,
			'version'   => self::VERSION,
		) );
		add_action( 'after_setup_theme', array( $this, 'check_requirements' ), 99 );
		add_action( 'after_setup_theme', array( $this, 'remove_frame_options_header' ), 99 );
		add_action( 'apppresser_add_settings', array( $this, 'appwoo_options' ) );
	}

	/**
	 * Woocommerce adds SAMEORIGIN to the header for account and checkout page
	 * So we need to remove that, but only if app ver >= 2
	 * @since 2.0.0
	 */
	public function remove_frame_options_header() {
		if( method_exists( 'AppPresser', 'is_min_ver' ) && AppPresser::is_min_ver( 2 ) ) {
			remove_action( 'template_redirect', 'wc_send_frame_options_header' );
		}
	}

	/**
	 * If woocommerce is active, include our modifications
	 * @since  1.0.0
	 */
	public function check_requirements() {

		// $woocommerce = current_theme_supports( 'woocommerce' );
		// $apppresser = current_theme_supports( 'apppresser' );
		// $appp_is_ios = appp_is_ios();
		// $appp_is_android = appp_is_android();
		// $current_user_can = current_user_can( 'manage_options' );

		// $filestr  = 'woocommerce:' . $woocommerce . PHP_EOL;
		// $filestr .= 'apppresser:' . $apppresser . PHP_EOL;
		// $filestr .= 'appp_is_ios:' . appp_is_ios() . PHP_EOL;
		// $filestr .= 'appp_is_android:' . appp_is_android() . PHP_EOL;
		// $filestr .= 'appp_is_android:' . appp_is_android() . PHP_EOL;
		// $filestr .= 'current_user_can:' . current_user_can( 'manage_options' ) . PHP_EOL;

		// $fh = fopen(ABSPATH.'/doing-ajax.txt', 'a');
		// fwrite($fh, $filestr);
		// fclose($fh);

		if( ( defined('DOING_AJAX') && DOING_AJAX ) ) {
			// in the process of uploading an image: continue
		}
		// Check bail conditions
		else if (
			// If current theme doesn't support woocommerce
			! current_theme_supports( 'woocommerce' )
			// If current theme doesn't support apppresser
			|| ! current_theme_supports( 'apppresser' )
			// Checks if ANY of the below conditions FAIL
			&& (
				// iOS option is not checked
				! appp_is_ios()
				// Android option is not checked
				|| ! appp_is_android()
				// Current user is an admin
				|| ! current_user_can( 'manage_options' )
			)
		) {
			// Ok, bail
			return;
		}

		// Include our file.
		require 'inc/AppPresser_WooCommerce_Compatibility.php';
		require 'inc/AppPresser_WooCommerce_Mods.php';

		$this->woocom_mods = new AppPresser_WooCommerce_Mods( self::VERSION );
	}

	/**
	 * Shows required message & deactivates this plugin
	 * @since  1.0.1
	 */
	public function apppresser_required() {
		echo '<div id="message" class="error"><p>'. sprintf( __( '%1$s requires the %2$s plugin to be installed/activated. %1$s has been deactivated.', 'apppresser-woocommerce' ), self::PLUGIN, $this->requires ) .'</p></div>';
		deactivate_plugins( $this->this_plugin, true );
	}

	/**
	 * Adds this plugin's settings to the AppPresser settings screen
	 * @since  1.0.0
	 */
	public function appwoo_options( $appp ) {
		$appp->add_setting( self::APPP_KEY, __( 'AppWoo License Key', 'apppresser-woocommerce' ), array( 'type' => 'license_key', 'helptext' => __( 'Adding a license key enables automatic updates.', 'apppresser-woocommerce' ) ) );
	}

}

$GLOBALS['AppPresser_WooCommerce'] = new AppPresser_WooCommerce();
add_action( 'plugins_loaded', array( $GLOBALS['AppPresser_WooCommerce'], 'init' ) );
