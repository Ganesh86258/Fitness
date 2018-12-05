<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Ion
 * @since   0.0.1
 */

if( !class_exists('AppPresser_MyAppp') ) {

	class AppPresser_MyAppp {

		public static $instance = null;

		public $app_update_version = 0;
		public $api_url;

		/**
		* Creates or returns an instance of this class.
		* @since  1.0.0
		* @return A single instance of this class.
		*/
		public function run() {
			if ( self::$instance === null )
			  self::$instance = new self();

			$this->hooks();

			return self::$instance;
		}

		/**
		* Setup
		* @since  1.0.0
		*/
		public function __construct() {
		}

		public function hooks() {
			add_action( 'init', array( $this, 'get_app_update_version' ) );
			add_action( 'wp_head', array( $this, 'myapppresser_css') );
		}

		/**
		 * Retrieves CSS from myapppresser.com
		 * either from cache OR API
		 */
		public function myapppresser_css() {

			// bypass cache?
			if( isset($_COOKIE['AppPresser_Preview'] ) ) {

				// Preview: always pull from API

				$design = $this->fetch_remote_css();

				if( is_object( $design ) ) {
					$design->source = 'API';
				}

			} else {
				
				// cached? or first time here
				if( false === ( $design = get_option( 'myapppresser_css' ) ) ) {

					// Not preview && not cache: pull from API

					// This step will most likely never get used because
					// of the async call to the API on the 'init' hook.
					// It's just a fallback.

					$design = $this->fetch_remote_css();
					
					if( is_object( $design ) ) {
						$design->source = 'API';
					}

				} else {

					// Not preview and cache exists
					if( is_object( $design ) ) {
						$design->source = 'cached';
					}
				}
			}

			if( $design ) {
				$this->output_remote_css( $design );
			} else {
				echo '<!-- myapppresser.com CSS not set -->'.PHP_EOL;
			}
		}

		public function output_remote_css( $design ) {

			// format data and output to site
			echo "\n".'<style type="text/css" media="screen">'. "\n
			 /* myapppresser.com CSS v{$design->version} ({$design->source}) */\n
			 body, body #page, .io-modal, #buddypress div.activity-comments form.ac-form { background-color: " . $design->body_bg . "; }\n
			 body, p, .item p, .entry-content p, .item, .input-label, .entry-meta, .list-group a, .list-group a:visited, .activity-list .activity-header p, .activity-list .activity-header a, .activity-list .acomment-meta, .activity-list .acomment-meta a, .activity-list .acomment-options a { color: " . $design->text_color . "; }\n
			 .button-primary, input[type=submit], #buddypress input[type=submit], .woocommerce .quantity .plus, .woocommerce .quantity .minus, .woocommerce .quantity input.qty, .woocommerce .single_add_to_cart_button, .woocommerce .checkout-button, .pager li a { background-color: " . $design->button_background . " !important; }\n
			 .button-primary, .menu-left a.button-primary, .button-primary i, .button-primary a, input[type=submit], #buddypress input[type=submit], .woocommerce .quantity .plus, .woocommerce .quantity .minus, .woocommerce .quantity input.qty, .woocommerce .single_add_to_cart_button, .woocommerce .checkout-button, .pager li a { color: " . $design->button_text . " !important; }\n
			 a,a:visited { color: " . $design->link_color . "; }\n
			 #main h1, #main h2, #main h3, #main h4, #main h1 a, #main h2 a, #main h3 a, #main h4 a, .item .item-title, .io-modal h4 { color: " . $design->headings_color . "; }\n

			 $design->custom_css;
			 
			 " . '</style>'."\n";

		}

		public function fetch_remote_css() {
			
			if( $this->get_api_url() ) {
				$data = wp_remote_retrieve_body( wp_remote_get( $this->get_api_url() ) );

				if( ! $data ) {
					return false;
				} else if( substr($data, 0, 1) != '{' ) {
					return false;
				}

				$data = json_decode( $data );

				$data->meta->design->version = $this->get_app_version($data);

				return $data->meta->design;	
			}
		}

		public function get_api_url() {
			if( is_null( $this->api_url ) ) {
				$option = get_option('appp_settings');

				// get API data. Should be setting for site and app id
				$site_slug = isset( $option['ap3_site_slug'] ) ? $option['ap3_site_slug'] : null;
				$app_id = isset( $option['ap3_app_id'] ) ? $option['ap3_app_id'] : null;

				if( empty( $site_slug ) || empty( $app_id ) ) {
					$this->api_url = false;
				} else {
					$api_url = ( defined( 'MYAPPPRESSER_DEV_DOMAIN' ) ) ? MYAPPPRESSER_DEV_DOMAIN : 'https://myapppresser.com/';
					$this->api_url = $api_url . $site_slug . '/wp-json/ap3/v1/app/' . $app_id;
				}
			}

			return $this->api_url;
		}

		public function get_app_version( $data ) {

			$design = get_option('myapppresser_css');

			if( $design === false || ((isset($data->meta, $data->meta->app_update_version)) && $design->version < $data->meta->app_update_version ) ) {
				$design = $data->meta->design;
				$design->version = $data->meta->app_update_version;
				update_option( 'myapppresser_css', $design );
			}

			return $design->version;
		}

		/**
		 * On every page load, do an async API call to get app_update_version.
		 * 
		 * This step is necessary to get immediate updates when a user press the 'Go Live' button.
		 */
		public function get_app_update_version() {

			if( isset($_COOKIE['AppPresser_Preview'] ) ) {
				return; // avoid two API calls
			}

			if( $this->get_api_url() ) {

				if( function_exists('curl_multi_exec') ) {

					// asynchronous api call

					require_once dirname(__FILE__) . "/../lib/CurlAsync.php";
					$http = new CurlAsync();
					$http->test($this->get_api_url());
					$data = $http->test();
				} else {

					// synchronous api call

					$data = wp_remote_retrieve_body( wp_remote_get( $this->get_api_url() ) );
				}

				if( ! $data ) {
					return false;
				} else if( substr($data, 0, 1) != '{' ) {
					return false;
				}

				$data = json_decode( $data );

				// update the design and app version
				$this->get_app_version($data);
			}

		}
	}

	$AppPresser_MyAppp = new AppPresser_MyAppp();
	$AppPresser_MyAppp->run();

}