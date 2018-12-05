=== AppWoo ===
Contributors: apppresser, webdevstudios, williamsba1, scottopolis, jtsternberg, Messenlehner, LisaSabinWilson, modemlooper, stillatmylinux
Author URI: http://apppresser.com
Requires at least: 3.5
Tested up to: 4.9.1
Stable tag: 3.0.2
License: General Public License
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==
Create an ecommerce app with Woocommerce. The AppWoo extension adds styling, extra features, and other integration to create a turnkey ecommerce app for your Woocommerce store.

== Installation ==

1. Upload AppWoo to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Changelog ==

= 3.0.2 =
* Remove version 1 conflict with 3rd-party payment opt 
* Fix updating variation gallery images
* Add submit listener only once
* Fix deprecated WC_Cart::get_cart_url() warning.

= 3.0.1 =
* Fix add to cart and compatibility with WooCommerce 3.0

= 3.0.0 =
* Add compatibility with AppPresser 3.0

= 2.2.1 =
* Fix login and coupon toggles on checkout
* Fix the login form on checkout

= 2.2.0 =
* Add js handler for the sticky_ion_menu hook
* Improve same domain logic when using dynamic page loading
* Remove the post activity button from a product page if AppBuddy activated

= 2.1.0 =
* Updates for the new admin settings layout

= 2.0.1 =

* Fix product variations

= 2.0.0 =

* Add compatibility with Apppresser 2.0.0 moving cordova files to device
* Add filter hook for buttons
* Set checkout and cart URLs in js for woocommerce updates compatibility
* Remove woocommerce select2 UI for compatibility
* Add filter hook for icon classes
* Css fix for scrolling

= 1.0.7 =

* Use newer woocommerce.css

= 1.0.6 =

* Fix coupon and login toggle on checkout page

= 1.0.5 =

* Fix state field duplication on checkout
* Fix Paypal checkout
* Misc bug fixes, styling updates
* Translation updates

= 1.0.4 =

* Enhancement: new (much improved) login modal
* Script optimization support
* Bug fixes

= 1.0.3 =

* Overhaul to make AppWoo compatible with WooCommerce 2.1, while also maintaining backwards-compatibility.

= 1.0.2 =

* NOTICE: AppWoo is not currently compatible with WooCommerce 2.1. We're working hard to make the necessary changes.
* Bug fix: Only override WooCommerce CSS and enqueue our own if viewing AppTheme
* Enhancement: New filter, `apppresser_replace_woo_styles` for even more control of the WooCommerce CSS replacement.
* Bug fix: Compensation for WooCommerce changing the way to disable their css in version 2.1.
* Enhancement: Minified scripts for WooCommerce JS.
* Bug fix: Gallery not working in all instances.

= 1.0.1 =

* Bug Fix: WooCommerce product variations script wasn't firing properly.
* Bug Fix: WooCommerce product description tabs weren't being displayed properly.
* Improvement: Minified CSS

= 1.0.0 =

* First official release.
