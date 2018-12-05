=== Eonet Manual User Approve ===
Contributors: alkaweb, webbaku
Tags: login, registration, sign up, approve, users, user management, user
Requires at least: 3.0.1
Tested up to: 4.9.8
Stable tag: 2.1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows the admin of the site to approve or deny users manually, after they have registered.

== Description ==

Eonet Manual User Approve changes the registration behavior of your WordPres site. When the plugin is active, if an user
signs up, any email containing password isn't sent to him, instead he is alerted that have to wait for the adminin
approvaation before be able to access.
Meantime, the admin is alerted that a new user requested an approvation, he will be able to see the user informations,
and decide if allow or deny to access. In both cases, the user is alerted by email about the admin action. If he
has been approved, he will receive an email containing credentials.

= Main features: =
* Allows the admin to approve or deny user sign up
* Disallow users to login if they are not approved
* Disallow users to reset password if they are not approved
* Send automatic emails to both users and admin on every important action
* You can change the content of all the messages
* Filter users by approval status
* SUPER easy to use, just install and active it, it's done.

= Featured compatibility: =
* Full compatible with BuddyPress

= For developers: =
* Hooks/Filters available in all the plugin code
* Documented code
* GPL license
* Secure development using tokens and WordPress native functions

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/eonet-manual-user-approve` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Go in "Eonet > Settins > Manual User Approve" and change the content of the messages
3. It's done, now you can approve or deny users from WordPress users screen.

== Frequently Asked Questions ==

= What are the variables allowed in the emails content? =

* {{$site_name}} - The name of the site
* {{$site_url}} - The url of the site
* {{$pending_users_url}} - The url to the lists of users in the backend, already filtered to show only the pending users
* {{$access_url}} - It should represents the url where the user can login. By default it points to the homepage
* {{$user_login}} - The username of the user involved in the message
* {{$user_email}} - The email of the user involved in the message
* {{$user_firstname}} - The first name of the user involved in the message (note that it might be empty if not filled)
* {{$user_lastname}} - The last name of the user involved in the message (note that it might be empty if not filled)
* {{$display_name}} - The display name of the user involved in the message

= How to disable the password reset after user approval? =

This can be useful if you are using some other third part membership plugin. You have to add this line in the
functions.php of your child theme:

`add_filter( 'eonet_mua_avoid_password_reset', '__return_true');`

== Screenshots ==

1. Login page with additional welcome message
2. Users list with additional filters and actions to approve or deny users
3. Options page

== Changelog ==

= 2.1.2 - October 2nd 2018 =
* (FIXED) Missing plugin name

= 2.1.1 - September 23th 2018 =
* (NEW) Multiple receivers support for the admin notification
* (IMPROVED) Activation workflow by removing confusion with the BuddyPress pending tab
* (FIXED) Unsent admin emails
* (FIXED) BuddyPress registration issues

= 2.1.0 – March 12th 2018 =
* (FIXED) Now the plugin can overrides the default email sent by BuddyPress to the admin when a new user signs up

= 2.0.5 - February 22th 2018 =
* (IMPROVED) Added a filter that allows to change easily the receivers of admin notifications
* (FIXED) Conflicts with Eonet theme settings

= 2.0.4 - September 21th 2017 =
* (FIXED) Dropdown menu doesn't open yet in certain conditions
* (FIXED) Some settings come back to default after saved them

= 2.0.3 - July 21th 2017 =
* (FIXED) An issue coming from the previous update

= 2.0.2 - July 21th 2017 =
* (FIXED) Javascript error in the backend (Woffice conflict)

= 2.0.2 - July 20th 2017 =
* (FIXED) A wrong folders structure

= 2.0.1 - July 20th 2017 =
* (IMPROVED) Added more variables to the custom messages (see the FAQ)
* (IMPROVED) Added a security check on every page, instead that only on sign up
* (UPDATED) The Eonet core inside the plugin
* (FIXED) The conflict with Bootstrap dropdown menu

= 2.0.0 - March 15th 2017 =
* (NEW) Now is possible to change the content of all the messages displayed and the emails sent by the plugin
* (NEW) Option to enable/disable email to the admin when a new user is waiting for approval

= 1.0.4 - March 12th 2017 =
* (C)(IMPROVED) Options Style

= 1.0.3 - February 10th 2017 =
* (IMPROVED) English grammar and spelling and updated .pot language file
* (IMPROVED) Added text color to the action links in users list
* (IMPROVED) Permissions check, now the users can be approved or denied from every user tat has capability "edit_users"
* (FIXED) Some notice errors in the users list
* (C)(IMPROVED) Translation management

= 1.0.2 - 6th January 2017 =
* (NEW) Translation file

= 1.0.1 - 1st November 2016 =
* Replaced constant definition with filters in order to improve extensibility
* (C)(FIXED) the built-in component installer
* (C)(FIXED) version number

= 1.0.0 - 28th October 2016 =
* Initial Release
