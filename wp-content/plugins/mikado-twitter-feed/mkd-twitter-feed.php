<?php
/*
Plugin Name: Mikado Twitter Feed
Description: Plugin that adds Twitter feed functionality to our theme
Author: Mikado Themes
Version: 1.0
*/
define('MIKADO_TWITTER_FEED_VERSION', '1.0');

include_once 'load.php';

if (!function_exists('mkd_twitter_feed_text_domain')) {
	/**
	 * Loads plugin text domain so it can be used in translation
	 */
	function mkd_twitter_feed_text_domain() {
		load_plugin_textdomain('mkd-twitter-feed', false, MIKADO_INSTAGRAM_FEED_REL_PATH . '/languages');
	}

	add_action('plugins_loaded', 'mkd_twitter_feed_text_domain');
}