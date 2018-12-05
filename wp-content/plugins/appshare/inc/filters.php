<?php

class AppShare_Filters {

		// A single instance of this class.
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
		add_action( 'init', array( $this, 'register_filters' ) );
	}


	/**
	 * register_filters function.
	 *
	 * @access public
	 * @return void
	 */
	public function register_filters() {
		add_filter('appshare_btn', array( $this, 'appshare_btn'), 10, 2 );
		add_filter('the_excerpt',  array( $this, 'appshareButtonExcerpt' ) );
	}

	/**
	 * Gets the setting value of the display preference of the share button per post_type
	 * 
	 * if( apply_filters( 'appshare_btn', false, 'post' ) ) {
	 * 		echo 'button html';
	 * }
	 * 
	 * @since 1.2.1
	 * 
	 * @param boolean false Allows false by default
	 * @param string post_type
	 * 
	 * @return boolean true|false
	 */
	public function appshare_btn( $display, $post_type ) {

		if ( AppPresser::is_app() ) {

			$appshare_options = appp_get_setting();

			if ( $post_type == 'post' && isset( $appshare_options['appshare_setting_content'] ) && $appshare_options['appshare_setting_content'] ) {
				return true;
			}
			
			if ( isset( $appshare_options['appshare_setting_'.$post_type] ) && $appshare_options['appshare_setting_'.$post_type] ) {
				return true;
			}

		}

		return false;	
	}

	/**
	 * appshareButtonExcerpt function.
	 *
	 * Places a share button after the_excerpt
	 *
	 * @access public
	 * @param mixed $content
	 * @return void
	 */
	public function appshareButtonExcerpt( $content ) {

		$appshare_options = appp_get_setting();

		$class = !empty( $appshare_options['appshare_setting_buttonclass'] ) ? 'class="' . $appshare_options['appshare_setting_buttonclass'] . '"' : '' ;
		$text = !empty( $appshare_options['appshare_setting_buttontext'] ) ? 'button_text="' . $appshare_options['appshare_setting_buttontext'] . '"' : '' ;

		if ( isset( $appshare_options['appshare_setting_excerpt'] ) ) {
			$content .= do_shortcode('[appshare ' . $class . ' ' . $text . ']');
		}

		return $content;

	}
}

	