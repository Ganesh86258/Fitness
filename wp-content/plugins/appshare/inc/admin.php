<?php
/*
 * Author: AppPresser
 * Author URI: http://appresser.com
 * License: GPLv2
 */


/**
 * AppShare_Admin_Settings class.
 * 
 * @extends AppShare
 */
class AppShare_Admin_Settings extends AppShare {

	public static $instance = null;

	
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
		add_action( 'apppresser_add_settings', array( $this, 'appshare_settings' ) );
	}


	/**
	 * appshare_settings function.
	 * 
	 * @access public
	 * @param mixed $appp
	 * @return void
	 */
	public function appshare_settings( $appp ) {
	
		$appp->add_setting( 'paragraph', __( '', 'appcustom' ), 
			array( 
				'type' => 'h3',
				'description' => 'AppShare allows you to use native device sharing to share content from inside your app. A link will be shared to the url of the content the share button originates from.',
				'tab' => 'appshare' 
			) 
		);
		
		$appp->add_setting_tab( __( 'AppShare', 'appshare' ), 'appshare' );
		
		$appp->add_setting( self::APPP_KEY, __( 'AppShare License Key', 'appshare' ), 
			array( 'type' => 'license_key', 
			'tab' => 'appshare', 
			'helptext' => __( 'Adding a license key enables automatic updates.', 'appshare' ) 
			) 
		);

		$appp->add_setting( 'appshare_setting_page', __( 'Add Share Button after page content', 'appshare' ), 
			array( 'type' => 'checkbox', 'tab' => 'appshare' 
			) 
		);
		
		$appp->add_setting( 'appshare_setting_content', __( 'Add Share Button after post content', 'appshare' ), 
			array( 'type' => 'checkbox', 'tab' => 'appshare' 
			) 
		);
		
		$appp->add_setting( 'appshare_setting_excerpt', __( 'Add Share Button after post excerpt', 'appshare' ), 
			array( 'type' => 'checkbox', 'tab' => 'appshare' 
			) 
		);
		
		$appp->add_setting( 'appshare_setting_buttontext', __( 'Button Text. (Default text: Share This)', 'appshare' ), 
			array( 'tab' => 'appshare' 
			) 
		);
		
		$appp->add_setting( 'appshare_setting_buttonclass', __( 'Button class for custom styles', 'appshare' ), 
			array( 'tab' => 'appshare'
			) 
		);
	}

}
AppShare_Admin_Settings::run();