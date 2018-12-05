<?php
/*
 * Author: AppPresser
 * Author URI: http://appresser.com
 * License: GPLv2
 */


/**
 * AppFBConnect_Shortcodes class.
 */
class AppFBConnect_Shortcodes {

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
    add_shortcode('app-fb-login', array( $this, 'appfbconnect') );
  }

  /**
   * appfbconnect function.
   *
   * Gets shortcode params and then echos a button.
   *
   * @access public
   * @param mixed $atts
   * @return void
   */
  public function appfbconnect( $atts ) {

    $app_atts = shortcode_atts( array(
          'class'  => 'btn-primary',
          'button_text' =>  __( 'Login with Facebook', 'appfbconnect' ),
        ), $atts );

    ob_start();
    ?>
    <?php if ( AppPresser::is_app() ) { ?>
      <div id="fb-root"></div>

      <?php 

        $wploggedin = is_user_logged_in();
        
        // Deprecated in v 1.0 since posting now requires Facebook review
        // $statusbtn = appp_get_setting( 'appfbconnect_status' );

        $fb_appID = appp_get_setting( 'appfbconnect_appid' );
        
        if( $wploggedin ) {
          
          // If logged into WordPress, display user info
          
          $current_user = wp_get_current_user();
          
          $fbloggedin = get_user_meta( $current_user->ID, 'appp_fb_loggedin', true );
          
          ?>
  
          <p class="fb-loggedin-msg"><?php echo sprintf( '%s %s', __('Logged in as ', 'appfbconnect'), $current_user->user_login ); ?></p>
          
          <?php if( 1==0 /* $fbloggedin && $statusbtn == 'on' */ ) { // Deprecated in v 1.0 since posting now requires Facebook review
            
            // If logged into WP and FB, and setting is checked, display status update btn
            ?>
    
              <button class="appfbconnectstatus btn <?php echo $app_atts['class']; ?>">
                <?php _e('Post Status Update', 'appfbconnect'); ?>
              </button>
    
              <span id="fb-status"></span>
    
              <?php }
                
        } else if($fb_appID) { ?>

          <button class="appfbconnectlogin btn"><?php echo $app_atts['button_text']; ?></button>
          <div id="status"></div>
        
        <?php } else { ?>
          <!-- facebook app_id is not set -->
        <?php }
          
    }

    $content = ob_get_contents();
    ob_end_clean();

    return $content;
  }
}