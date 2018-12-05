<?php

/**
 * @since 2.6.0
 */
class AppFBConnect_Settings_API {
	
	public function hooks() {

		add_action( 'rest_api_init', array( $this, 'api_init' ) );
	}

	public function api_init() {
		self::ap3_api_routes();

		self::modify_cors_headers();
	}

	/*
	 * Avoid CORS errors in app preview on the web
	 *
	 */
	public function modify_cors_headers() {

		remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );

		add_filter( 'rest_pre_serve_request', function( $value ) {
			header( 'Access-Control-Allow-Origin: *' );
			header( 'Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE' );
			header( 'Access-Control-Allow-Credentials: true' );

			// don't cache the API, causes issues in the preview
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");

			return $value;
			
		});

	}

	public function ap3_api_routes() {
		register_rest_route( 'ap3/v1', '/appfbconnect/settings', array(
			'methods' => 'POST',
			'callback' => array( $this, 'get_apppfb_settings' ),
		) );
	}

	public static function get_apppfb_settings( $data = null ) {

		$app_id = appp_get_setting( 'ap3_app_id' );

		// minor security check
		if($data && isset( $data['id'] ) && $data['id'] == $app_id ) {
			$response = apply_filters( 'apppfb_settings', array(
				'version' => AppFBConnect::VERSION,
				'app_id' => appp_get_setting( 'appfbconnect_appid' ),
				'security' => wp_create_nonce( 'appfbconnect-nonce' ),
				'oauthRedirectURL' => apply_filters( 'appfbconnect_oathcallback', AppFBConnect::$callback_url ),
				'me_fields' => apply_filters( 'appfbconnect_me_fields', 'email,name' ),
				'l10n' => array(
					'login_msg' => sprintf( __('Thanks for logging in, %s!', 'appfbconnect'), '{{USERNAME}}' ), // .replace('{{USERNAME}}') will occur in js
					'fetch_user_fail' => __( 'Sorry, login failed', 'appfbconnect'),
					'not_authorized' => __( 'Please log into this app.', 'appfbconnect'),
					'fb_not_logged_in' => __( 'Please log into Facebook.', 'appfbconnect'),
					'wp_login_error' => __( 'WordPress login error', 'appfbconnect'),
					'login_fail' => __( 'Login error, please try again.', 'appfbconnect')
				),
			));
		} else {
			$response = array(
				'version' => AppFBConnect::VERSION,
				'error' => 'On your WordPress site, ' . get_bloginfo( 'wpurl' ) . ', the AppPresser 3 Settings are not set correctly. Please visit the AppPresser settings page in your wp-admin to fix.'
			);
		}

		return $response;
	}
}