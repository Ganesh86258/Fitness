=== AppCamera ===
Contributors: apppresser, webdevstudios, williamsba1, scottopolis, jtsternberg, Messenlehner, LisaSabinWilson, modemlooper, stillatmylinux
Author URI: http://apppresser.com
Requires at least: 3.5
Tested up to: 4.9.4
Stable tag: 2.0.4
License: General Public License
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==
Add a “Take Photo/Upload Photo” button anywhere in your app with a simple shortcode. Upload a photo to a custom post type and publish it in your app from your device. Works great with Woocommerce!

== Installation ==

1. Upload AppCamera to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. You will now find a new "Camera" tab in your AppPresser settings.

Please visit there to configure the Camera extension settings.

== Changelog ==

= 2.0.4 =
* Fix json message to tell the app when the image was uploaded and include the image URL.

= 2.0.3 =
* Add a json message to tell the app when the image was uploaded

= 2.0.2 =
* Fix jQuery vars from getting overwritten

= 2.0.1 =
* Fix moderating photos w parent IDs

= 2.0.0 =
* Add compatibility with Apppresser 2.0.0 moving cordova files to device
* Add filter icon button
* No longer includes uploaded images in a gallery if in the moderation queue

= 1.0.7 =
* Improve upload compatibility with appbuddy

= 1.0.6 =
* Bug fix: removed double image upload, and avoid displaying a previously uploading image with appbuddy when taken from an Android camera.

= 1.0.5 =
* Security patch for add_query_arg

= 1.0.4 =
* Fixes for AppBuddy
* Translation update
* Security update
* Bug fixes
* Compatibility with newest version of Phonegap

= 1.0.3 =
* Support for AppBuddy
* Script optimization support
* Security update
* Bug fixes

= 1.0.2 =
* Bug Fix: Don't add 'needs-moderating' class or 'Image is in moderation queue' title to images attached to post. (previous version didn't correaddress the issue in all cases)</li>

= 1.0.1 =
* Enhancement: `appp_after_camera_buttons` hook now accepts the shortcode attributes array as a parameter
* Enhancement: Save photos to featured image only if option is set. Default is to save to the post content.
* Enhancement: Approving/Denying photos also publishes or deletes corresponding posts (if the 'action="new"' <a href="https://appprecom/docs/api/shortcodes/app-camera/" target="_blank">shortcode parameter</a> is used).</li>
* Enhancement: User experience for uploading an image and admin experience for moderation is a bit more streamlined.
* Enhancement: New filter `appp_camera_photo_blog_embedded_img_size` for changing the embedded image size on new post creation.
* Bug Fix: Don't add 'needs-moderating' class or 'Image is in moderation queue' title to images attached to post.

= 1.0.0 =
* First official release.
