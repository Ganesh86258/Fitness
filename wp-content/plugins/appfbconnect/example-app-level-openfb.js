/**
 * Developers can modify each of these functions and then upload
 * the file in WordPress on the AppPresser settings page > advance tab
 * using the 'Add Custom JavaScript to Your App' feature.
 */

/**
 * This function is called right after the user logs into
 * Facebook
 *
 * A token gets saved in window.sessionStorage but you don't have to
 * worry about because openFB.api() will add it automatically to your call. 
 *
 * Test your FB API calls here:
 * https://developers.facebook.com/tools/explorer/
 */
appTop.AppFBConnect.customCallback = function(response) {

	
	var fb_id = ( typeof response.id != 'undefined' ) ? response.id : '';
	var name = ( typeof response.name != 'undefined' ) ? response.name : '';
	var email = ( typeof response.email != 'undefined' ) ? response.email : '';

	if( fb_id === '' ) {
		return;
	}

	my_fb_tools.set_vars( fb_id, name, email );
	my_fb_tools.request_profile_picture();

};

/**
 * These are some example tools using openFB and interacting with the iframed WordPress site
 */
var my_fb_tools = (function(window, document, undefined) {

	var my_fb = {
		_init: false,
		fb_id: '',
		name: '',
		email: '',
		profile_picture: '',
	};

	my_fb.init = function() {
		if( my_fb._init ) {
			return;
		}
		openFB.tokenStore = window.localStorage; // save this in localStorage instead of sessionStorage as default
		my_fb.add_listeners();
		my_fb._init = true;
	}

	my_fb.set_vars = function( fb_id, name, email ) {
		my_fb.fb_id = fb_id;
		my_fb.name  = name;
		my_fb.email = email;
	};

	my_fb.add_listeners = function() {
		window.addEventListener("message", my_fb.receiveMessage, false);
	};

	/**
	 * Because of browser security the iframe can not call javascript functions
	 * in the parent window, but it can send a message using the parent.postMessage('my_message', '*') function.
	 *
	 * This is how you can add a click event on a button to post a message 
	 * to trigger an event. So add this to your web page or a javascript file to your website.
	 * 
	 * jQuery('#my-button').on('click', function() { parent.postMessage('my_fb_get_public_profile', '*'); } );
	 *
	 * Then we need to use receiveMessage to receive that message.
	 */
	my_fb.receiveMessage = function(e) {
		if( e.data === 'my_fb_get_public_profile' ) {
			my_fb.request_public_profile();
		}
	};

	my_fb.request_profile_picture = function() {
		var params = {
			method:  'GET',
			path:    '/'+my_fb.fb_id+'/picture', // Required
			params:  {fields:'url',redirect:false,type:'large'}, // optional
			success: my_fb.get_profile_picture, // optional
			error:   my_fb.get_profile_picture_failed, // optional
		};
		// make any Facebook Graph API request
		openFB.api( params );
	};

	my_fb.request_public_profile = function() {

		if( my_fb.fb_id === '' ) {

			// TODO: improve handling missing FB token
			alert('You are missing the FB token.  Logout and login using Facebook');

			return;
		}

		var params = {
			method:  'GET',
			path:    '/'+my_fb.fb_id, // Required
			params:  {fields:'id,name,first_name,last_name,age_range,link,gender,locale,picture,timezone,updated_time,verified',redirect:false,type:'large'}, // optional
			success: my_fb.post_public_profile, // optional
			// error:   my_fb.get_public_profile_failed, // optional
		};
		// make any Facebook Graph API request
		openFB.api( params );
	};

	my_fb.post_public_profile = function(response) {
		var iframewin = document.getElementById('myApp').contentWindow.window;

		if( typeof iframewin.post_profile_response != 'undefined' ) {
			iframewin.post_profile_response(response);
		}
	}

	/**
	 * openFB.api callback when success
	 */
	my_fb.get_profile_picture = function(response) {
		if( typeof response.data != 'undefined' && typeof response.data.url != 'undefined' ) {
			my_fb.profile_picture = response.data.url;
			
			console.log( response.data.url );
		}
	};

	/**
	 * openFB.api callback when fails
	 */
	my_fb.get_profile_picture_failed = function( response ) {
		console.log(response);
	};

	/**
	 * An example use of ajax to send any details to WordPress.
	 * Requires you to write your own ajax handler (my_action) in PHP.
	 */
	my_fb.save_profile_picture = function() {
		var iframedoc = document.getElementById('myApp').contentWindow.document;
		var iframewin = document.getElementById('myApp').contentWindow.window;

		// Login to WordPress
		jQuery.ajax({
		   url: iframewin.apppCore.ajaxurl,
		   data: {
			  'action':'my_action',
			  'user_email': my_fb.email,
			  'security' : iframewin.apppfb.security,
			  'full_name': my_fb.name,
			  'fb_id': my_fb.fb_id,
			  'profile_picture': my_fb.profile_picture,
		   },
		   error: function(msg) {
				//
		   },
		   success: function(data) {
				// 
		   }
		});
	};

	my_fb.init();

	return my_fb;

})(window, document);