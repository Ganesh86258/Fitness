(function(window, document, $, undefined){

	if ( typeof window.apppresser === 'undefined' || ! window.apppresser )
		return;

	apppresser.paypal = {};
	apppresser.wooswipe = {};

	var paypal = apppresser.paypal;

	// $(document).ready(wooswiper);
	apppresser.wooswiper = function( $selector ){
		$selector = typeof $selector !== 'undefined' ? $selector : $('.product-gallery');
		// Show the carousel
		$selector.animate({'opacity': '1'}, 'slow');
		// If there is not more than one image, don't initiate a swiper object
		if ( $( 'img', $selector ).length < 2 )
			return;
		apppresser.wooswipe = $selector.swiper({
			pagination: '.pagination',
			mode: 'horizontal',
			calculateHeight: true,
			loop: true,
			paginationClickable: true
		});
	};

	paypal.Checkout = function() {
		
		console.log('paypal.Checkout');

		// only if paypal is enabled
		if ( ! apppwoo.do_paypal )
			return;

		var $form        = $('form.checkout');
		var checkout_url = typeof wc_checkout_params === 'undefined' ? woocommerce_params.checkout_url : wc_checkout_params.checkout_url;

		// Check for failed assignment of checkout_url
		if ( typeof checkout_url === 'undefined' ) {
			checkout_url = apppwoo.checkout_url+"?wc-ajax=checkout&appp="+apppCore.ver;
		}

		if ( ! $form.length )
			return;

		console.log( 'checkout_url', checkout_url );

		paypal.inAppBrowser = function( instance ) {
			// Cache our site host
			var site     = window.location.host;
			// Get our cart url (with appp query var since this is in the app)
			var app_ver = ( apppCore.is_appp_true ) ? apppCore.is_appp_true : '1';
			var cart_url = apppwoo.cart_url +'?appp=' + app_ver;
			// Initiate our redirect var
			var redirect = '';

			// What happens when in-app browser changes urls
			var loadstopEvent = function( event ) {

				apppresser.log( 'checkout_place_order loadstopEvent', { 'url': event.url } );

				var test_url = event.url.split('?')[0]; // ignore everything after the ? since the URL may contain a redirect param of our site

				// If url in in-app browser is one of our own,
				if ( site && test_url.indexOf( site ) >= 0 ) {
					// cache the url
					redirect = event.url;
					// and trigger the in-app browser to close
					instance.close();
				}

			};

			// What happens when we close the in-app browser
			var closeEvent = function(event) {
				apppresser.log( 'checkout_place_order exit', event );

				// Redirect our app to the url from the in-app browser, or our cart url by default
				window.location.href = redirect ? redirect : cart_url;

				// Clean up after ourselves
				instance.removeEventListener( 'loadstop', loadstopEvent );
				instance.removeEventListener( 'exit', closeEvent );
			};
			// Add listener events to in-app browser instance
			instance.addEventListener( 'loadstop', loadstopEvent );
			instance.addEventListener( 'exit', closeEvent );
		};

		paypal.successHandler = function( code ) {
			var result = '';

			try {
				// Get the valid JSON only from the returned string
				if (code.indexOf("<!--WC_START-->") >= 0)
					code = code.split("<!--WC_START-->")[1]; // Strip off before after WC_START
				if (code.indexOf("<!--WC_END-->") >= 0)
					code = code.split("<!--WC_END-->")[0]; // Strip off anything after WC_END

				// Parse
				result = $.parseJSON(code);

				// If result is successful
				if ( typeof result.result !== 'undefined' && result.result == 'success') {
					apppresser.log( 'result success', result );

					if( apppCore.ver == '1' ) {
					// Trigger in-app browser instance
					var browserInstance = window.open( result.redirect, '_blank' );
					// If we have an instance (only for app)
					if ( browserInstance ) {
						// Add our in-app browser events
						paypal.inAppBrowser( browserInstance );
					}
					} else {
						apppresser.paypal.redirect = result.redirect;
						parent.postMessage('paypal_place_order', '*');

						// only for AP3, should do a check
						var message = { paypal_url: result.redirect, redirect: window.apppwoo.cart_url };
						parent.postMessage( JSON.stringify(message), '*');

					}
				}
				else if (result.result == 'failure') {
					throw "Result failure";
				} else {
					throw "Invalid response";
				}
			} catch (err) {
				// Remove old errors
				$('.woocommerce-error, .woocommerce-message').remove();

				// Add new errors
				if (result.messages) $form.prepend(result.messages);
				else $form.prepend(code);

				// Cancel processing
				$form.removeClass('processing').unblock();
				$('.ajax-spinner').hide();

				// Lose focus for all fields
				$form.find('.input-text, select').blur();

				// Scroll to top
				$('html, body, #main').animate({
						scrollTop: ($form.offset().top - 100)
				}, 1000);

				// Trigger update in case we need a fresh nonce
				if (result.refresh == 'true') $('body').trigger('update_checkout');

				$('body').trigger('checkout_error');
			}
		};

		paypal.checkoutOverride = function() {

			apppresser.log( 'checkpayment_type', $('input[name=payment_method]:checked', $form ).length, $('input[name=payment_method]:checked', $form ).val() );
			// Only hijack processing if the payment_method is paypal
			if ( $('input[name=payment_method]:checked', $form ).val() !== 'paypal' ) {
				return;
			}

			$form.addClass('processing');
			var form_data = $form.data();

			
			if (form_data["blockUI.isBlocked"] != 1) {
				$form.block({
				message: null,
					css: {
						backgroundColor: '#fff',
					opacity: 0.6
				}
			});
				$('.ajax-spinner').show();
				setTimeout(function() {
					$('.ajax-spinner').hide();
				}, 10000);
			}

			$.ajax({
				type     : 'POST',
				url      : checkout_url,
				data     : $form.serialize(),
				success  : paypal.successHandler,
				dataType : "html"
			});

			// Return false to keep woocommerce from processing payment
			return false;
		};

		// Add submit listener only once
		console.log('Add submit listener only once');
		paypal.form_override_events = $._data($form[0],'events');
		switch(true) {
			case paypal.form_override_events === undefined:
			case paypal.form_override_events.length === 0:
			case -1 !== $.inArray(paypal.checkoutOverride, paypal.form_override_events.submit):
				console.log('Add submit listener only once (ADDED!!!)');
				$form.on( 'submit', paypal.checkoutOverride );
				break;	
		}

	};

	apppresser.wooappInit = function() {

		console.log('wooappinit');
		// init wooswiper
		apppresser.wooswiper();
		paypal.Checkout();
		apppresser.checkoutInit();

		// Set back button to go to the shop page
		apppresser.backhref = window.apppwoo && apppwoo.is_shop ? apppwoo.shop_url : apppresser.home_url;

		// Ajax panel
		$('body').on( 'click', 'ul.products li a, a.module, a.setting, .cart-items a, .panel-toggle a, a.panel-toggle, .product a', function(event) {

			$self = $(this);
			// var is_panel_item = $(this).is( '.app-panel ul.products li a' );
			// apppresser.backhref = ! is_panel_item ? window.location.href : apppresser.backhref;
			// apppresser.backhref = window.location.href;

			// @TODO get right side app panel functional in version 1.x
			if ( ! $('body').hasClass('single') && 1 == 2 ) {
				$selector = $('.item-content');

				// If the panel's not open yet
				if ( ! $('html').hasClass('open-panel') ) {

					// Show panel first, then start transition
					$('.app-panel').show();
					setTimeout(function (){
						apppresser.log('window.location.href', window.location.href );
						// open the panel
						$('html').addClass('open-panel');
					}, 1); // Delay is necessary or transition doesn't work right
				}
			} else {
				$selector = $('#main');
			}

			apppresser.woocall = true;
			if ( typeof apppresser.canAjax == 'function' && apppresser.canAjax( $self ) )
				apppresser.loadAjaxContent( $self.attr('href'), $selector, event );

			// Close left panel menu if it's open
			if (  ! apppresser.isWidth600 && apppresser.snapper &&  
				   apppresser.snapper.state().state == apppresser.lr_snap ||
				   ( typeof apppresser.sticky_ion_menu !== 'undefined' &&
				   apppresser.sticky_ion_menu === false ) )
				apppresser.snapper.close();

		});
	};

	apppresser.wooappAjaxDone = function(event, $, selector) {

		apppresser.checkoutInit();

		if ( ! apppresser.woocall )
			return;

		apppresser.wooswiper($('.product-gallery', selector));
		wooinit();

		var $form = $('.variations_form');
		var $select = $('.variations_form .variations select');

		// Checks for woocommerce product variations. If they exist, runs the variation script
		function doWooVariation( loop_count ) {
			if ( ! loop_count )
				apppresser.log( 'wooappAjaxDone variations exist?', $form.length, $select.length );

			if ( $form.length && $select.length ) {
				apppresser.log( 'loop_count = ', loop_count, '$.wc_variation_form =', typeof $.fn.wc_variation_form );
				if ( typeof $.fn.wc_variation_form === 'function' ) {
					$form.wc_variation_form();
					$select.change();
				} else {
					if ( loop_count++ <= 5 )
						setTimeout( function(){ doWooVariation( loop_count ); }, 500 );
				}
			}
		}
		doWooVariation(0);
	};

	apppresser.checkoutInit = function() {
		if( jQuery('body').hasClass('woocommerce-checkout') ) {
			console.log('paypal.Checkout call');
			$ = jQuery;

			apppresser.paypal.Checkout();

			
		}
	};

	apppresser.addCheckoutAjaxLogin = function() {

		if( !$('body').hasClass('woocommerce-checkout') )
			return;

		// The ajaxed loaded cart.js adds an event listener not meant to
		// be on the checkout page and it stops the login form submission.
		// Since there is no way to remove this anonymous listener,
		// we use the loginModal instead.

		$('body.not-logged-in .woocommerce-info .showlogin')
			.removeClass('showlogin')
			.addClass('no-ajax io-modal-open')
			.attr('href', '#loginModal');

	};

})(window, document, jQuery);

// Make it so
jQuery(document).ready( apppresser.wooappInit ).bind( 'load_ajax_content_done', apppresser.wooappAjaxDone );

jQuery(document).on( 'ready load_ajax_content_done', apppresser.addCheckoutAjaxLogin );

if( jQuery('body').hasClass('woocommerce-checkout') ) {
	console.log('paypal.Checkout call');
	$ = jQuery;

	apppresser.paypal.Checkout();

}
