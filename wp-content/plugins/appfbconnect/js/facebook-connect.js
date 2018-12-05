(function(window, document, $, undefined){

	window.appfbconnect = {
		login_scope: 'email,public_profile,user_friends',
		l10n:{
			login_msg:'Thanks for logging in, {{USERNAME}}!',
			fetch_user_fail:'Sorry, login failed',
			not_authorized:'Please log into this app.',
			fb_not_logged_in:'Please log into Facebook.',
			wp_login_error:'WordPress login error',
			login_fail:'Login error, please try again.'
		}
	};

	appfbconnect.init = function() {

	  if( typeof apppfb.l10n !== 'undefined' ) {
	  	appfbconnect.l10n = apppfb.l10n
	  }

	  if( openFB.init({appId: apppfb.app_id,oauthRedirectURL: apppfb.oauthRedirectURL}) ) {
	  	jQuery('.appfbconnectlogin').on('click', function(event) {
	  		event.preventDefault();
	  		appfbconnect.login();
	  	});
	  }

	}

	// Here we run a Graph API after login is successful.
	// See statusChangeCallback() for when this call is made.
	appfbconnect.graphAPI = function() {
	  
	}

	appfbconnect.fbMe = function() {

	/*
	 *  method:  HTTP method: GET, POST, etc. Optional - Default is 'GET'
     *  path:    path in the Facebook graph: /me, /me.friends, etc. - Required
     *  params:  queryString parameters as a map - Optional
     *  success: callback function when operation succeeds - Optional
     *  error:   callback function when operation fails - Optional
	 */

	 var params = {
	 	path: '/me',
	 	params: {fields:apppfb.me_fields},
	 	success: appfbconnect.fetchUser_Callback,
	 	error: appfbconnect.fetchUser_CallbackError
	 };

	  openFB.api( params );
	}

	// This function is called after a callback
	// from retreiving the user's email and fb_id
	appfbconnect.fetchUser_Callback = function(response) {
		if( document.getElementById('status') ) {
			document.getElementById('status').innerHTML = appfbconnect.l10n.login_msg.replace('{{USERNAME}}', response.name);
		}
		// Send user info to WordPress login function
		if( typeof response.name != 'undefined' && typeof response.email != 'undefined') {
			appfbconnect.wplogin( response.name, response.email );
		} else {
			console.log( response );
		}
	}

	// This function is called after a callback
	// from retreiving the user's email and fb_id
	appfbconnect.fetchUser_CallbackError = function(response) {
		apppCore.log( response );
		document.getElementById('status').innerHTML = appfbconnect.l10n.fetch_user_fail;
	}

	// This function is called when someone finishes with the Login
	// Button.  See the onlogin handler attached to it in the sample
	// code below.
	appfbconnect.checkLoginState = function() {
	  FB.getLoginStatus(function(response) {
	   appfbconnect.statusChangeCallback(response);
	   return false;
	  });
	}

	// This is called with the results from from FB.getLoginStatus().
    appfbconnect.statusChangeCallback = function(response) {
      console.log('statusChangeCallback');
      console.log(response);
      // The response object is returned with a status field that lets the
      // app know the current login status of the person.
      // Full docs on the response object can be found in the documentation
      // for FB.getLoginStatus().
      if (response.status === 'connected') {
        // Logged into your app and Facebook.
        appfbconnect.fbMe();
      } else if (response.status === 'not_authorized') {
        // The person is logged into Facebook, but not your app.
        document.getElementById('status').innerHTML = appfbconnect.l10n.not_authorized;
      } else {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
        document.getElementById('status').innerHTML = appfbconnect.l10n.fb_not_logged_in;
      }
    }

	// This is called with the results from from FB.getLoginStatus().
	appfbconnect.login = function(response) {

	  jQuery.event.trigger('fbconnect');

	  openFB.login(
		appfbconnect.statusChangeCallback,
		{scope: appfbconnect.login_scope});
	}

	appfbconnect.wplogin = function( name, email ) {

		// var loginResult = jQuery('#fb-login-result');

		// Login to WordPress
		jQuery.ajax({
		   url: apppCore.ajaxurl,
		   data: {
			  'action':'appp_wp_fblogin',
			  'user_email': email,
			  'security' : apppfb.security,
			  'full_name': name,
		   },
		   error: function(msg) {
				alert(appfbconnect.l10n.wp_login_error + ' ' + msg );

				loginResult.html(appfbconnect.l10n.login_fail);

		   },
		   success: function(data) {
				
				var context = window.location.pathname.substring(0, window.location.pathname.lastIndexOf("/"));
				var baseURL = location.protocol + '//' + location.hostname + (location.port ? ':' + location.port : '') + context;
				var app_ver = ( apppCore.ver ) ? apppCore.ver : '1';

				if(data && data.redirect_url) {
					var redirect_url = data.redirect_url;
					if( redirect_url.indexOf('?') === -1 && redirect_url.indexOf('appp=') === -1 ) {
						window.location.href = redirect_url+ "?appp=" + app_ver;
						return;
					} else if( redirect_url.indexOf('appp=') === -1 ) {
						window.location.href = redirect_url+ "&appp=" + app_ver;
						return;
					} else {
						window.location.href = data.redirect_url;
						return;
					}
				}

				window.location.href = baseURL + "?appp=" + app_ver;
		   }
		});
	}

})(window, document, jQuery);

jQuery(document).ready( appfbconnect.init ).on( 'load_ajax_content_done', appfbconnect.init );