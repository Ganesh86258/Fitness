<?php
/*
Plugin Name: AppShare
Plugin URI: http://apppresser.com
Description: Native device content sharing for AppPresser apps.
Text Domain: appshare
Domain Path: /languages
Version: 2.1.0
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


/**
 * AppShare class.
 */
class AppShare {

	// A single instance of this class.
	public static $instance    = null;
	public static $this_plugin = null;
	const APPP_KEY             = 'appshare_key';
	const PLUGIN               = 'AppShare';
	const VERSION              = '2.1.0';


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
		load_plugin_textdomain( 'appshare', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

		// Define plugin constants
		$this->basename			=	plugin_basename( __FILE__ );
		$this->directory_path	=	plugin_dir_path( __FILE__ );
		$this->directory_url	=	plugin_dir_url( __FILE__ );

		// Enqueue scripts & styles
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts_styles' ) );
		add_action( 'plugins_loaded', array( $this, 'includes' ) );


	}

	public function includes() {

		require_once $this->directory_path . 'inc/shortcodes.php';
		require_once $this->directory_path . 'inc/filters.php';
		include $this->directory_path . 'inc/admin.php' ;

		appp_updater_add( __FILE__, self::APPP_KEY, array(
			'item_name' => self::PLUGIN, // must match the extension name on the site
			'version'   => self::VERSION,
		) );

		AppShare_Shortcodes::run();
		AppShare_Filters::run();

	}


	/**
	 * apppresser_required function.
	 *
	 * @access public
	 * @return void
	 */
	public function apppresser_required() {
		echo '<div id="message" class="error"><p>'. sprintf( __( '%1$s requires the AppPresser Core plugin to be installed/activated. %1$s has been deactivated.', 'appshare' ), self::PLUGIN ) .'</p></div>';
		deactivate_plugins( self::$this_plugin, true );
	}


	/**
	 * scripts_styles function.
	 *
	 * @access public
	 * @return void
	 */
	function scripts_styles() {

		if( method_exists( 'AppPresser','is_min_ver' ) && AppPresser::is_min_ver( 2 ) ) { // only v2 or higher
			return;
		} else {
			wp_register_script( 'socialshare', $this->directory_url .'js/SocialSharing.js', array('cordova-core', 'jquery'), self::VERSION, true );
			wp_enqueue_script( 'socialshare' );
		}
	}


}
AppShare::run();
