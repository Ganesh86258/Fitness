<?php
/*
 * Author: AppPresser
 * Author URI: http://appresser.com
 * License: GPLv2
 */


/**
 * AppShare_Shortcodes class.
 */
class AppShare_Shortcodes extends AppShare {

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
		add_action( 'init', array( $this, 'register_shortcodes' ) );
	}


	/**
	 * register_shortcodes function.
	 *
	 * @access public
	 * @return void
	 */
	public function register_shortcodes(){
		add_shortcode('appshare', array( $this, 'appshare') );
	}


	/**
	 * appshare function.
	 *
	 * Gets shortcode params and then echos a button.
	 *
	 * @access public
	 * @param mixed $atts
	 * @return void
	 */
	public function appshare( $atts ) {

		$appshare_classes = 'btn btn-primary';

		$appshare_classes = apply_filters( 'appshare_default_classes', $appshare_classes );

		extract( $app_atts = shortcode_atts( array(
					'class'  => $appshare_classes, // button class for styling
					'message'	=> get_the_title(),
					'link'	 => wp_get_shortlink(),
					'button_text' =>  __( 'Share This', 'appshare' ),
				), $atts ) );

		ob_start();
		?>
		<?php if ( AppPresser::is_app() ) { ?>
			<button class="<?php echo $app_atts['class']; ?> appshare"
				data-msg="<?php echo $app_atts['message']; ?>" 
				data-link="<?php echo $app_atts['link']; ?>">
				<?php echo $app_atts['button_text']; ?>
			</button>
		<?php } ?>
		<?php
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

}


/**
 * appshareButton function.
 *
 * Echos a button. Use this in a template file for exact button placement.
 *
 * @access public
 * @param string $atts (default: '')
 * @return void
 */
function appshareButton( $atts = '' ) {
	if ( AppPresser::is_app() ) {
		echo do_shortcode('[appshare '. $atts .']');
	}
}