<?php
/**
 * If woocommerce is active, load woocommerce customizations.
 * @version  1.0.4
 */

class AppPresser_WooCommerce_Mods {

	public $woo_localized     = array();
	public $single_localized  = array();
	public $country_localized = array();

	/**
	 * Setup our plugin
	 * @since 1.0.0
	 */
	public function __construct( $version ) {
		$this->version = $version;
		$this->dir_url = plugins_url( '/', dirname( __FILE__ ) );

		$this->compatibility = new AppPresser_WooCommerce_Compatibility;

		// Add after woocommerce is already loaded
		add_action( 'init', array( $this, 'woo_mods' ) );
	}

	/**
	 * Woo! Do our mods!
	 * @since  1.0.0
	 */
	public function woo_mods() {
		// check if woocommerce is active
		if ( ! class_exists( 'Woocommerce' ) )
			return;

		$this->remove_actions();
		$this->do_hooks();

	}

	/**
	 * Remove WooCommerce hooks to make way for our own.
	 * @since  1.0.3
	 */
	public function remove_actions() {
		// Remove wrappers
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

		// Remove sidebar
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

		// Remove breadcrumbs
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

		// Remove add to cart button from shop page
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
	}

	/**
	 * Add our hooks
	 * @since  1.0.3
	 */
	public function do_hooks() {
		// Add user profile and cart items to left panel menu
		add_action( 'appp_left_panel_before', array( $this, 'woo_profile' ), 30 );

		// Change woocomm image sizes on theme activation
		add_action( 'admin_init', array( $this, 'image_dimensions' ) );
		// Enqueue our scripts/styles
		add_action( 'init', array( $this, 'enqueue_styles_scripts' ), 20 );

		// Add wrapper around shop product meta (for padding)
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'product_meta_wrap_open' ) );
		add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'product_meta_wrap_close' ) );

		// Custom image gallery on single product page
		add_action( 'woocommerce_before_single_product_summary', array( $this, 'product_image_gallery' ), 20 );
		add_action( 'woocommerce_after_single_product_summary', array( $this, 'close_product_info' ), 50 );

		// cache localized data
		add_filter( 'wc_single_product_params', array( $this, 'cache_localized_single_prod_data' ) );
		add_filter( 'wc_country_select_params', array( $this, 'cache_localized_country_data' ) );
		add_filter( 'woocommerce_params', array( $this, 'cache_woo_params' ) );

		// Add woocommerce body class to all pages (so ajax loaded content gets styling)
		add_filter( 'body_class', array( $this, 'woocommerce_class' ) );
		// Send users from wp-login to the woo account page instead
		add_filter( 'login_url', array( $this, 'woo_account_page' ) );
		// Send users back to the product page after logging in
		add_action( 'template_redirect', array( $this, 'template_redirect' ) );

		// Add upload to product gallery if we have camera addon
		if( function_exists( 'appp_camera' ) ){
			add_action( 'appp_after_product_images', array( $this, 'product_upload_images' ) );
			add_action( 'appp_after_process_uploads', array( $this, 'product_process_uploaded_images' ), 0, 2 );

			// Now remove the activity modal because the upload buttons can only be used once per page
			if( class_exists( 'AppBuddy' ) ) {
				add_action( 'appp_remove_status_modal_btn', array( $this, 'remove_status_modal_btn' ) );
			}
		}
	}

	/**
	 * Cache the wc_single_product_params
	 * @since  1.0.3
	 * @param  array  $data Localized data
	 * @return array        Localized data
	 */
	public function cache_localized_single_prod_data( $data ) {
		$this->single_localized = $data;
		return $data;
	}

	/**
	 * Cache the wc_country_select_params
	 * @since  1.0.3
	 * @param  array  $data Localized data
	 * @return array        Localized data
	 */
	public function cache_localized_country_data( $data ) {
		$this->country_localized = $data;
		return $data;
	}

	/**
	 * Cache the woocommerce_params and replace woocommerce JS with our own
	 * @since  1.0.0
	 * @param  array  $data Localized data
	 * @return array        Localized data
	 */
	public function cache_woo_params( $data ) {
		$min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		$ver = $this->compatibility->is_wc_version_gt( '2.1.0' ) ? '2.1' : 'pre-2.1';

		// Adjust dependancies based on the WC version
		$deps =  array( 'jquery', 'jquery-blockui' );
		if( ! $this->compatibility->is_wc_version_gt( '2.1.0' ) ) $deps[] = 'jquery-placeholder';

		// Re-Register woocommerce.js as custom version
		wp_deregister_script( 'woocommerce' );
		wp_register_script( 'woocommerce', $this->dir_url ."js/{$ver}/woocommerce{$min}.js", $deps, $this->version, true );

		$this->woo_localized = $data;
		return $data;
	}

	/**
	 * Add user profile and cart items to left panel menu
	 * @since  1.0.0
	 */
	public function woo_profile() {
		$user         = wp_get_current_user();
		$display_name = isset( $user->display_name ) ? $user->display_name : '';
		$user_email   = isset( $user->user_email ) ? $user->user_email : '';
		$user_first   = isset( $user->user_firstname ) ? $user->user_firstname : '';
		$user_last    = isset( $user->user_lastname ) ? $user->user_lastname : '';
		if ( is_user_logged_in() && $user_email ) {
			echo get_avatar( $user_email, 50 );
		}
		if ( $user_first || $user_last ) {
			$name = $user_last;
			$name = $user_first ? $user_first .' '. $name : $name;
			echo '<h4 class="user-name">'. $name .'</h4>';
		} elseif ( $display_name ) {
			echo '<h4 class="user-name">'. $display_name .'</h4>';
		}

		$woo_profile_icon_classes = 'fa fa-shopping-cart';
		$woo_profile_icon_classes = apply_filters( 'appp_woo_profile_icon_classes', $woo_profile_icon_classes );

		global $woocommerce;
		?>
		<div class="cart-items">
			<i class="<?php echo $woo_profile_icon_classes; ?>"></i>
			<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'apppresser-woocommerce'); ?>"><?php echo '<span class="cart-item-total">' . sprintf( _n( '%d item', '%d items', $woocommerce->cart->cart_contents_count, 'apppresser-woocommerce' ), $woocommerce->cart->cart_contents_count ) . '</span>';?> <?php echo $woocommerce->cart->get_cart_total(); ?></a>
		</div><!-- .cart-items -->
		<?php
	}

	/**
	 * Define image sizes
	 * @todo  Need to filter these values rather than update the option because
	 *        1) The option won't get updated when using AppTheme as app-only
	 *        and 2) We wouldn't want it to overrider their main theme's settings
	 * @since  1.0.0
	 */
	public function image_dimensions() {
		global $pagenow;
		// make sure we're on the activated theme page
		if ( ! is_admin() || ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' )
			return;

	  	$catalog = array(
			'width' 	=> '208',	// px
			'height'	=> '208',	// px
			'crop'		=> 1 		// true
		);

		$single = array(
			'width' 	=> '470',	// px
			'height'	=> '470',	// px
			'crop'		=> 1 		// true
		);

		$thumbnail = array(
			'width' 	=> '100',	// px
			'height'	=> '100',	// px
			'crop'		=> 0 		// false
		);

		// Update image size options
		update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
		update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
		update_option( 'shop_single_image_size', $single ); 		// Single product image
		update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
		add_image_size( 'appp_shop_single', 470, 470 ); 			// Custom shop single product image
	}

	/**
	 * Add wrapper around shop product meta (for padding)
	 * @since  1.0.0
	 * @return string  Html div opening markup
	 */
	public function product_meta_wrap_open() { echo '<div class="product-meta-wrap">'; }

	/**
	 * Add wrapper around shop product meta (for padding)
	 * @since  1.0.0
	 * @return string  Html div closing markup
	 */
	public function product_meta_wrap_close() { echo '</div>'; }

	/**
	 * Upload to image gallery on single product page
	 * @since  1.0.0
	 */
	public function product_upload_images(){
		// load camera buttons
		appp_camera();

		
	}

	/**
	 * Process images uploaded to the image gallery on single product page
	 * @since  1.0.0
	 */
	public function product_process_uploaded_images( $post_id, $attachment_id ){
		$attachment_ids = get_post_meta( $post_id, '_product_image_gallery', 1 );
		if ( $attachment_ids ) {
			$attachment_ids = explode( ',', $attachment_ids );
			$attachment_ids = array_merge( $attachment_ids, array( $attachment_id ) );
			$attachment_ids = implode( ',', $attachment_ids );
		} else {
			$attachment_ids = $attachment_id;
		}
		update_post_meta( $post_id, '_product_image_gallery', $attachment_ids  );
	}

	/**
	 * The upload buttons can only appear once per page so if they are added to the product page
	 * remove the modal icon from the header
	 * @since 2.1.1
	 * 
	 * @param boolean $remove_button
	 * @return boolean
	 */
	public function remove_status_modal_btn( $remove_button ) {
		global $post;

		return ( isset( $post, $post->post_type ) && $post->post_type == 'product' );
	}

	/**
	 * Gets product image ids
	 * @since  1.0.0
	 * @return array Product image ids
	 */
	public function gallery_image_ids() {
		global $product;

		// Get images including featured image
		if( method_exists($product,'get_gallery_image_ids') ) {
			$gallery_ids = $product->get_gallery_image_ids();
		} else {
			// deprecated, leave for backwards compatibility
			$gallery_ids = $product->get_gallery_attachment_ids();
		}
		

		// this filter removes images uploaded by the device camera if moderation is on
		return apply_filters( 'apppresser_woocom_gallery_ids', $gallery_ids );
	}

	/**
	 * Gets product images and creates gallery markup
	 * @since  1.0.0
	 * @param  boolean $echo Whether to echo or not
	 * @return string        Gallery slides markup
	 */
	public function gallery_images( $echo = true ) {

		// Get images including featured image
		$attachment_ids = $this->gallery_image_ids();
		if( is_array( $attachment_ids ) ){
			// If we only have one image, give it a class for styling
			$single_class = count( $attachment_ids ) == 0
				? ' single'
				: '';
			$gallery = '';
			$post_thumb = get_the_post_thumbnail( get_the_ID(), 'shop_single' );
			$gallery .= '<div class="swiper-slide woocommerce-product-gallery__image'. $single_class .'">'. $post_thumb .'</div>';
			foreach ( $attachment_ids as $attachment_id ) {
				// format our slide/image
				// @todo filter?
				$gallery .= sprintf( '<div class="swiper-slide%s">%s</div>'."\n", $single_class, wp_get_attachment_image( $attachment_id, 'shop_single' ) );
			}

			if ( $echo )
				echo $gallery;

			return $gallery;
		}
	}

	/**
	 * Custom image gallery on single product page
	 * @since  1.0.0
	 */
	public function product_image_gallery() {
		?>

	<div class="images">
		<section class="swiper-container product-gallery woocommerce-product-gallery__wrapper" data-snap-ignore="true">
			<div class="swiper-wrapper">
				<?php $this->gallery_images(); ?>
			</div><!-- swiper-wrapper -->

			<div class="pagination">
			</div>
		</section>
		<?php do_action('appp_after_product_images'); ?>
	</div>
	<?php wp_enqueue_script( 'appp-woo' ); ?>
	<div class="single-product-info">

		<?php
	}

	/**
	 * Add closing div for .single-product-info
	 * @since  1.0.0
	 * @return string  Html div closing markup
	 */
	public function close_product_info() { echo '</div><!-- .single-product-info -->'; }

	/**
	 * Handles the hooking of the script and (maybe) style enqueues
	 * @since  1.0.2
	 */
	public function enqueue_styles_scripts(){
		// http://docs.woothemes.com/document/disable-the-default-stylesheet/
		$this->maybe_replace_woo_styles();
 		// Scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 50 );
	}

	/**
	 * Replaces woo css if AppTheme is loaded
	 * @see    http://docs.woothemes.com/document/disable-the-default-stylesheet/
	 * @since  1.0.0
	 */
	public function maybe_replace_woo_styles() {

		// If current theme supports apppresser-woocommerce, disable the woocommerce styles
		$disable = $this->is_appp_theme();

		// Allow other devs to override this
		if ( ! $disable_woo_styles = apply_filters( 'apppresser_replace_woo_styles', $disable ) )
			return;

		// WC 2.1 uses a filter to disable WC CSS rather than constant
		if ( $this->compatibility->is_wc_version_gt( '2.1.0' ) ) {
			add_filter( 'woocommerce_enqueue_styles', '__return_false' );
		} else {
			define( 'WOOCOMMERCE_USE_CSS', false );
		}

		// Enqueue our own styles
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 50 );

		// Update the option as well.. (bad idea)
		// update_option( 'woocommerce_frontend_css', 'no' );
	}

	/**
	 * Determines if AppTheme is being viewed
	 * @since  1.0.2
	 * @return boolean
	 */
	public function is_appp_theme() {
		$theme_name = appp_get_setting( 'appp_theme' )
			? appp_get_setting( 'appp_theme' )
			: null;
		$theme = wp_get_theme( $theme_name );

		return 0 === strcasecmp( $theme->get_template(), 'AppPresser' ) || 0 === strcasecmp( $theme->get_template(), 'AppTheme' );
	}

	/**
	 * Enqueues our JS and localizes data
	 * @since  1.0.0
	 */
	public function enqueue_scripts(){

		// Only use minified files if SCRIPT_DEBUG is off
		$min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		
		
		if( AppPresser::get_apv( 2 ) || AppPresser::get_apv( 1 ) ) {

			$ver = $this->compatibility->is_wc_version_gt( '2.1.0' ) ? '2.1' : 'pre-2.1';
	
			// Enqueue WC scripts required for ajaxification in WC 2.1+
	 		if ( $this->compatibility->is_wc_version_gt( '2.1.0' ) )
	 			wp_enqueue_script( 'wc-country-select' );
	
			wp_deregister_script( 'wc-single-product' );
	
			// This works fine in a web browser, but the app conflicts with what's 
			// in focus (country search field or device's keyboard).
			wp_deregister_script( 'select2' );
	
			wp_register_script( 'wc-single-product', $this->dir_url ."js/{$ver}/single-product{$min}.js", array( 'appp-woo' ), $this->version, true );
	
			// woocommerce uses wp.template for product variations
			wp_enqueue_script( 'wp-util' );
			
		}

		wp_register_script( 'idangerous-swiper', $this->dir_url .'js/idangerous.swiper-2.2.min.js', '', '', true );
		wp_register_script( 'appp-woo', $this->dir_url .'js/appp-woo.js', array( 'idangerous-swiper', 'appp-js', 'woocommerce' ), $this->version, true );
		wp_enqueue_script( 'appp-woo' );

		$localized = array(
			'is_shop' => is_shop(),
			'do_paypal' => $this->do_payment_popup(),
			'shop_url' => get_permalink( $this->get_wc_page_id( 'shop' ) ),
			'cart_url' => get_permalink( $this->get_wc_page_id( 'cart' ) ),
			'checkout_url' => get_permalink( $this->get_wc_page_id( 'checkout' ) ),
		);

		$localized['thanks_url'] = !$this->compatibility->is_wc_version_gt( '2.1.0' ) ? get_permalink( woocommerce_get_page_id( 'pay' ) ): false;

		wp_localize_script( 'appp-woo', 'apppwoo', $localized );

		$this->woo_localized['wc_country_select_params'] = $this->country_localized;
		$this->woo_localized['cart_url'] = AppPresser_WooCommerce_Compatibility::get_cart_url();
		wp_localize_script( 'appp-woo', 'woocommerce_params', $this->woo_localized );
		// Re-localize > 2.1 data
		wp_localize_script( 'appp-woo', 'wc_single_product_params', $this->single_localized );

	}

	/**
	 * Determines if Paypal is used
	 *
	 * @todo Make considerations for othe payment gateways needing a separate window
	 *
	 * @since  1.0.3
	 * @return bool  True if paypal is used
	 */
	public function do_payment_popup() {
		if ( isset( $this->_do_payment_popup ) )
			return $this->_do_payment_popup;

		global $woocommerce;
		// @todo Make considerations for othe payment gateways needing a separate window
		$do_payment_popup = is_callable( array( $woocommerce, 'payment_gateways' ) ) && is_callable( array( $woocommerce->payment_gateways, 'payment_gateways' ) ) ? $woocommerce->payment_gateways->payment_gateways() : false;

		$this->_do_payment_popup = isset( $do_payment_popup['paypal'], $do_payment_popup['paypal']->enabled ) && $do_payment_popup['paypal']->enabled == 'yes';

		return $this->_do_payment_popup;
	}

	/**
	 * Include Phonegap in-app browser plugins
	 * @since  1.0.3
	 */
	public function phonegap_plugins( $plugins ) {
		// @todo conditionally include these only when needed
		if( AppPresser::get_apv( 1 ) ) {
			$plugins[] = 'org.apache.cordova.inappbrowser.InAppBrowser';
		}
		return $plugins;
	}

	/**
	 * Enqueues our CSS (if conditions met)
	 * @since  1.0.2
	 */
	public function enqueue_styles(){
		wp_deregister_style( 'woocommerce' );
		wp_register_style( 'appp_woocommerce', $this->dir_url .'css/woocommerce.css' );
		wp_enqueue_style( 'appp_woocommerce' );
	}

	/**
	 * Add woocommerce body class to all pages (so ajax loaded content gets styling)
	 * @since  1.0.0
	 * @param  array  $classes Body classes
	 * @return array           Ammended body classes
	 */
	public function woocommerce_class( $classes ) {
		$classes[] = 'woocommerce';
		return $classes;
	}

	/**
	 * Relink wp-login urls to the woo account page if there is one.
	 * @since  1.0.0
	 * @param  string  $url Login url
	 * @return string       Modified url
	 */
	public function woo_account_page( $url ) {
		if ( ( $id = get_option('woocommerce_myaccount_page_id') ) && ( $permalink = get_permalink( $id ) ) ) {
			$original_login_url = site_url('wp-login.php', 'login');
			return str_ireplace( $original_login_url, $permalink, $url );
		}

		return $url;
	}

	/**
	 * If user is sent to the myaccount page AND there's a redirect_to query arg AND user is signed in, send them back
	 * @since  1.0.0
	 */
	public function template_redirect() {
		// Back to redirect_to page
		if ( isset( $_GET['redirect_to'] ) && is_page( $this->get_wc_page_id( 'myaccount' ) ) && is_user_logged_in() ) {
			wp_redirect( $_GET['redirect_to'] );
			exit;
		}
	}

	/**
	 * Retrieve page ids - used for myaccount, edit_address, shop, cart, checkout, pay, view_order, terms. returns -1 if no page is found
	 *
	 * @param string $page
	 * @return int
	 */
	public function get_wc_page_id( $page ) {
		// woocommerce_get_page_id is soft deprecated in WC 2.1
		if ( $this->compatibility->is_wc_version_gt( '2.1.0' ) )
			return wc_get_page_id( $page );
		else
			return woocommerce_get_page_id( $page );
	}

}
