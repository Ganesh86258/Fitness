<?php
/*
 * Author: AppPresser
 * Author URI: http://appresser.com
 * License: GPLv2
 */


/**
 * AppFBConnect_Admin_Settings class.
 * 
 * @extends AppFBConnect
 */
class AppFBConnect_Admin_Settings extends AppFBConnect {

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
		add_action( 'apppresser_add_settings', array( $this, 'appfbconnect_settings' ), 70 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ) );
	}


	/**
	 * appfbconnect_settings function.
	 * 
	 * @access public
	 * @param mixed $appp
	 * @return void
	 */
	public function appfbconnect_settings( $appp ) {

		$appp->add_setting_label( __( 'Facebook Connect', 'appfbconnect' ), array(
		
		) );
	
		$appp->add_setting( 'paragraph', '', 
			array( 
				'type' => 'h3',
				'description' => 'Login and get user information from Facebook.',
			) 
		);
		
		//$appp->add_setting_tab( __( 'Facebook Connect', 'appfbconnect' ), 'appfbconnect' );
		
		$appp->add_setting( self::APPP_KEY, __( 'AppFBConnect License Key', 'appfbconnect' ), 
			array( 'type' => 'license_key', 
				//'tab' => 'appfbconnect', 
				'helptext' => __( 'Adding a license key enables automatic updates.', 'appfbconnect' ),
			) 
		);
		
		$appp->add_setting( 'appfbconnect_appid', __( 'App ID', 'appfbconnect' ), 
			array( 
				'type' => 'text',
				'helptext' => __( 'Get your app ID on the Facebook Developer App Dashboard. Create an app if you don\'t have one already.', 'appfbconnect' ),
			) 
		);

		$appp->add_setting( 'appfbconnect_disable_rewrite', __( 'Disable rewrite', 'appfbconnect' ),
			array(
				'type' => 'checkbox',
				'description' => sprintf( 
						__( 'Disable rewrite rule to %s. %s(%smore%s)%s', 'appfbconnect' ),
						'<a href="'.site_url( '/oauthcallback/' ).'" target="_blank">/oauthcallback/</a>',
						'<span class="appfbc-more">',
						'<a class="toggle-appp-rewrite-warning" href="">',
						'</a>',
						'</span>'
					) . 
					'<div class="appp-rewrite-warning">' .
						'<h4>' . __( 'Important!', 'appfbconnect' ) . '</h4>' . 
						'<ol><li>' . 
							sprintf( __( 'Changes to this setting requires you to press the "Save Settings" button on the %sSettings:Permalinks%s page to flush WordPress\'s rewrite rules.', 'appfbconnect' ), 
								'<a href="'.admin_url( 'options-permalink.php' ).'">',
								'</a>'
							) .
						'</li><li>' .
							__( 'Disabling the rewrite requires using the following url in your Facebook app\'s "Valid OAuth redirect URIs" field: ', 'appfbconnect' ),							
							'<br>'.plugin_dir_url( __FILE__ ).'oauthcallback.html' .
						'</li></ol>' .
					'</div>',

				'helptext' => sprintf( __( 'A blank page with JavaScript which closes the launched FB login window after login. If your server has trouble with the rewrite rule to the callback page you can disable this feature and update the url in your FB app. Requires you to press the Save Changes button on the Settings:Permalinks page to flush the rewrite rules.', 'appfbconnect'), '<a href="'.site_url( '/oauthcallback/' ).'" target="_blank">/oauthcallback/</a>', admin_url( 'options-permalink.php' ) ),
			)
		);

		// Deprecated from appfbconnect after FB API 2.3
		// To post to Facebook requires review by Facebook
		// $appp->add_setting( 'appfbconnect_status', __( 'Display Status Update Button', 'appfbconnect' ), 
		// 	array( 
		// 		'type' => 'checkbox',
		// 		'description' => __( 'Displays a Post Status Update button after user logs in.', 'appfbconnect' ),
		// 	) 
		// );

		$appp->add_setting( 'appfbconnect_register', __( 'Register New Users', 'appfbconnect' ), 
			array( 
				'type' => 'checkbox',
				'description' => __( 'Register new users automatically.', 'appfbconnect' ),
			) 
		);

		$appp->add_setting( 'appfbconnect_redirect', __( 'Redirect URL After Login', 'appfbconnect' ), 
			array( 
				'type' => 'text_url',
				'description' => __( 'Redirect the logged in user to this page. Must be https.', 'appfbconnect' ),
				'helptext' => __('There are options to redirect new users or existing users to different URLs using hooks see the documentations. Note: this setting only redirects Facebook logins, see documentation for other login redirect options.', 'appfbconnect'),
			) 
		);
		
	}

	public function admin_enqueue() {
		    wp_enqueue_script( 'appfbconnect-admin', AppFBConnect::$js_dir_url.'admin-settings.js', array( 'jquery' ), false, true);
			wp_enqueue_style( 'appfbconnect-admin', AppFBConnect::$css_dir_url.'admin-settings.css' );
	}
}
AppFBConnect_Admin_Settings::run();