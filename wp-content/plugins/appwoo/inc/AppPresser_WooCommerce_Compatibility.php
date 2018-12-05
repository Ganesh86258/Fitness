<?php
/**
 * WooCommerce Plugin Compatibility
 *
 * Originally developed by SkyVerge
 * https://github.com/skyverge/wc-plugin-compatibility
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * AppPresser WooCommerce Compatibility Class
 *
 * Version: 1.2
 * Current Compatibility: 2.0.x - 2.1
 */
class AppPresser_WooCommerce_Compatibility {


	/**
	 * Compatibility function to queue some JavaScript code to be output in the footer.
	 *
	 * @since 1.0
	 * @param string $code javascript
	 */
	public static function wc_enqueue_js( $code ) {
		if ( self::is_wc_version_gte_2_1() ) {
			wc_enqueue_js( $code );
		} else {
			global $woocommerce;
			$woocommerce->add_inline_js( $code );
		}
	}


	/**
	 * Returns true if on the pay page, false otherwise
	 *
	 * @since 1.0
	 * @return boolean true if on the pay page, false otherwise
	 */
	public static function is_checkout_pay_page() {
		if ( self::is_wc_version_gte_2_1() ) {
			return is_checkout_pay_page();
		} else {
			return is_page( woocommerce_get_page_id( 'pay' ) );
		}
	}


	/**
	 * Returns the value of the custom field named $name, if any.  $name should
	 * not have a leading underscore
	 *
	 * @since 1.0
	 * @param WC_Order $order WC Order object
	 * @param string $name meta key name without a leading underscore
	 * @return string|mixed order custom field value for field named $name
	 */
	public static function get_order_custom_field( $order, $name ) {
		if ( self::is_wc_version_gte_2_1() ) {
			return isset( $order->$name ) ? $order->$name : '';
		} else {
			return isset( $order->order_custom_fields[ '_' . $name ][0] ) ? $order->order_custom_fields[ '_' . $name ][0] : '';
		}
	}


	/**
	 * Returns a new instance of the woocommerce logger
	 *
	 * @since 1.0
	 * @return object logger
	 */
	public static function wc_logger() {
		if ( self::is_wc_version_gte_2_1() ) {
			return new WC_Logger();
		} else {
			global $woocommerce;
			return $woocommerce->logger();
		}
	}


	/**
	 * Get the count of notices added, either for all notices (default) or for one particular notice type specified
	 * by $notice_type.
	 *
	 * @since 1.0
	 * @param string $notice_type The name of the notice type - either error, success or notice. [optional]
	 * @return int the notice count
	 */
	public static function wc_notice_count( $notice_type = '' ) {
		if ( self::is_wc_version_gte_2_1() ) {
			return wc_notice_count( $notice_type );
		} else {
			global $woocommerce;

			if ( 'error' == $notice_type ) {
				return $woocommerce->error_count();
			} else {
				return $woocommerce->message_count();
			}
		}
	}


	/**
	 * Gets a product meta field value, regardless of product type
	 *
	 * @since 1.0
	 * @param WC_Product $product the product
	 * @param string $field_name the field name
	 * @return mixed meta value
	 */
	public static function get_product_meta( $product, $field_name ) {
		// even in WC >= 2.0 product variations still use the product_custom_fields array apparently
		if ( $product->variation_id && isset( $product->product_custom_fields[ '_' . $field_name ][0] ) && '' !== $product->product_custom_fields[ '_' . $field_name ][0] ) {
			return $product->product_custom_fields[ '_' . $field_name ][0];
		}

		// use magic __get
		return $product->$field_name;
	}


	/**
	 * Format the price with a currency symbol.
	 *
	 * @since 1.0
	 * @param float $price the price
	 * @param array $args (default: array())
	 * @return string formatted price
	 */
	public static function wc_price( $price, $args = array() ) {
		if ( self::is_wc_version_gte_2_1() ) {
			return wc_price( $price, $args );
		} else {
			return woocommerce_price( $price, $args );
		}
	}


	/**
	 * Generates a URL for the thanks page (order received)
	 *
	 * @since 1.1
	 * @param WC_Order $order
	 * @return string url to thanks page
	 */
	public static function get_checkout_order_received_url( $order ) {
		if ( self::is_wc_version_gte_2_1() ) {
			return $order->get_checkout_payment_url();
		} else {
			return get_permalink( woocommerce_get_page_id( 'pay' ) );
		}
	}


	/**
	 * Generates a URL for the pay page
	 *
	 * @since 1.2
	 * @param WC_Order $order
	 * @return string url to pay page
	 */
	public static function get_checkout_order_pay_url( $order ) {
		if ( self::is_wc_version_gte_2_1() ) {
			return $order->get_checkout_order_received_url();
		} else {
			return get_permalink( woocommerce_get_page_id( 'thanks' ) );
		}
	}


	/**
	 * Compatibility function to get the version of the currently installed WooCommerce
	 *
	 * @since 1.0
	 * @return string woocommerce version number or null
	 */
	public static function get_wc_version() {
		// WOOCOMMERCE_VERSION is now WC_VERSION, though WOOCOMMERCE_VERSION is still available for backwards compatibility, we'll disregard it on 2.1+
		if ( defined( 'WC_VERSION' )          && WC_VERSION )          return WC_VERSION;
		if ( defined( 'WOOCOMMERCE_VERSION' ) && WOOCOMMERCE_VERSION ) return WOOCOMMERCE_VERSION;

		return null;
	}

	public static function get_cart_url() {
		if( self::is_wc_version_gt( '2.5.0' ) ) {
			return wc_get_cart_url();
		} else {
			return WC()->cart->get_cart_url();
		}
	}

	/**
	 * Returns the WooCommerce instance
	 *
	 * @since 1.0
	 * @return WooCommerce woocommerce instance
	 */
	public static function WC() {
		if ( self::is_wc_version_gte_2_1() ) {
			return WC();
		} else {
			global $woocommerce;
			return $woocommerce;
		}
	}


	/**
	 * Returns true if the WooCommerce plugin is loaded
	 *
	 * @since 1.0
	 * @return boolean true if WooCommerce is loaded
	 */
	public static function is_wc_loaded() {
		if ( self::is_wc_version_gte_2_1() ) {
			return class_exists( 'WooCommerce' );
		} else {
			return class_exists( 'Woocommerce' );
		}
	}


	/**
	 * Returns true if the installed version of WooCommerce is 2.1 or greater
	 *
	 * @since 1.0
	 * @return boolean true if the installed version of WooCommerce is 2.1 or greater
	 */
	public static function is_wc_version_gte_2_1() {
		return self::is_wc_version_gt( '2.1.0' );
	}


	/**
	 * Returns true if the installed version of WooCommerce is greater than $version
	 *
	 * @since 1.0
	 * @param string $version the version to compare
	 * @return boolean true if the installed version of WooCommerce is > $version
	 */
	public static function is_wc_version_gt( $version ) {
		return self::get_wc_version() && version_compare( self::get_wc_version(), $version, '>' );
	}

}