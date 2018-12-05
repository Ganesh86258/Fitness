=== AppFBConnect - Facebook Login ===
Contributors: apppresser, webdevstudios, scottopolis, jtsternberg, Messenlehner, LisaSabinWilson, tw2113, modemlooper, stillatmylinux
Tags: mobile, app, ios, android, application, phonegap, iphone app, android app, mobile app, native app, wordpress mobile, ipad app, iOS app, login, facebook
Requires at least: 3.5
Tested up to: 4.9.4
Stable tag: 2.6.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Your WordPress site in an App.

== Description ==

AppFBConnect allows your app users to login to your AppPresser app using Facebook with the option to automatically create new accounts to speed up user signups on your site.

#### How do I use it?

*   Install and activate the plugin
*   The App Facebook Connect extension requires creating a Facebook App ID.
*   Advanced users can use javascript to add other functionality through the Facebook Connect API.
*   Please see our [documentation](http://docs.apppresser.com/article/136-fbconnect) for setup and usage information.

== Installation ==

1. Upload AppFBConnect to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to AppPresser settings page to configure by adding your Facebook App ID
4. Please see our [documentation](http://docs.apppresser.com/article/136-fbconnect) for setup and usage information.

== Changelog ==

= 2.6.1 =
* Add appfbconnect_redirect hook returns title/url array

= 2.6.0 =
* Add support for the app modal login
* Add login and logout redirects
* Add API endpoint for fb settings for app modal

= 2.5.1 =
* Send more user info to the app
* Fix bug to check for both _GET and _POST vars

= 2.5.0 =
* Add fb_id to user meta on login
* Bug fixes

= 2.4.0 =
* Add pot file for text-domain translation

= 2.3.0 =
* localize language
* Admin option to disable rewrite rule

= 2.2.0 =
* Add filter for Facebook graph fields
* Fix URL redirect after login

= 2.1.2 =
* Remove debugging code which may cause a file write error if using the redirect option

= 2.1.1 =
* Bug fix add ?appp= to URL on redirect

= 2.1.0 =
* Add an admin setting to redirect users after login
* Add a filter, 'appfbconnect_redirect' to redirect new users to different URL

= 2.0.2 =
* Bug fix on fbopen init to return true on success.

= 2.0.1 =
* Bug fix throwing fatal error if Facebook AppID is not set. Now returns false and logs to the console.

= 2.0.0 =
* Bug fix to check if a method is_min_ver exists before trying to use it.

= 1.0.1 =
* Removes the requirement for the phonegap facebookconnect plugin in favor of using the In App Browser

= 1.0.0 =
* Release into the wild!

== Upgrade Notice ==

= 2.0.1 =
* Bug fix throwing fatal error if Facebook AppID is not set. Now returns false and logs to the console.

= 2.0.0 =
* Bug fix to check if a method is_min_ver exists before trying to use it.

= 1.0.1 =
* Removes the requirement for the phonegap facebookconnect plugin in favor of using the In App Browser
