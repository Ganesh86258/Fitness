var wooobject = (function(window, document, $, undefined){
	'use strict';

	var wc_country_select_params = woocommerce_params.wc_country_select_params;
	var woo    = {};
	var $doc   = $(document);
	var $body  = $('body');
	// State/Country select boxes
	var states = wc_country_select_params ? jQuery.parseJSON( wc_country_select_params.countries.replace(/&quot;/g, '"') ) : false;

	woo.init = function() {

		// Reset states; WC 2.3+ (2.4, 2.5) wc_country_select_params was moved out the wc_country_select_params object into the window object
		if( states === false && typeof wc_country_select_params == 'object' ){
			states = wc_country_select_params.countries;
		}
		else if( states === false && 
			woocommerce_params.wc_country_select_params.countries && 
			woocommerce_params.wc_country_select_params.countries.countries ) {
			wc_country_select_params = woocommerce_params.wc_country_select_params.countries;
			states = jQuery.parseJSON( wc_country_select_params.countries.replace(/&quot;/g, '"') );
		}

		// Orderby
		$('.woocommerce-ordering').on( 'change', 'select.orderby', function() {
			$(this).closest('form').submit();
		});

		// Quantity buttons
		$("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").addClass('buttons_added').append('<input type="button" value="+" class="plus" />').prepend('<input type="button" value="-" class="minus" />');

		// Target quantity inputs on product pages
		$("input.qty:not(.product-quantity input.qty)").each(function(){

			var min = parseFloat( $(this).attr('min') );

			if ( min && min > 0 && parseFloat( $(this).val() ) < min ) {
				$(this).val( min );
			}

		});

		$doc.trigger('wooinit_after', $);

	},

	woo.dowoo = function($) {

		// $( 'form.checkout' ).submit(function( event ) {
		// 	event.preventDefault();
		// 	window.open('https://www.paypal.com', '_blank');
		// });

		woo.init();

		$doc.on( 'click', '.plus, .minus', function() {

			// Get values
			var $qty       = $(this).closest('.quantity').find(".qty");
			var currentVal = parseFloat( $qty.val() );
			var max        = parseFloat( $qty.attr('max') );
			var min        = parseFloat( $qty.attr('min') );
			var step       = $qty.attr('step');

			// Format values
			if ( ! currentVal || currentVal == "" || currentVal == "NaN" ) currentVal = 0;
			if ( max == "" || max == "NaN" ) max = '';
			if ( min == "" || min == "NaN" ) min = 0;
			if ( step == 'any' || step == "" || step == undefined || parseFloat( step ) == "NaN" ) step = 1;

			// Change the value
			if ( $(this).is('.plus') ) {

				if ( max && ( max == currentVal || currentVal > max ) ) {
					$qty.val( max );
				} else {
					$qty.val( currentVal + parseFloat( step ) );
				}

			} else {

				if ( min && ( min==currentVal || currentVal < min ) ) {
					$qty.val( min );
				} else if ( currentVal > 0 ) {
					$qty.val( currentVal - parseFloat( step ) );
				}

			}

			// Trigger change event
			$qty.trigger('change');
		})
		// Orderby
		.on( 'change', '.woocommerce-ordering select.orderby', function() {
			$(this).closest('form').submit();
		})
		.on( 'change', 'select.country_to_state, input.country_to_state', function() {

			// if wc ( 2.3 || 2.4 || 2.5 ) && ( appp=2 || appp=1 ) && dynamic page loading is ( enabled || disabled ) return
			return;

			var country = $(this).val();

			var $statebox = $(this).closest('div').find('#billing_state, #shipping_state, #calc_shipping_state');
			var $parent = $statebox.parent();

			var state_textarea = $.find('input#billing_state, input#shipping_state');

			var state_select_val = $('.state_select').val();

			// state_textarea.val( state_select_val );

			if( state_textarea.length > 0 ) {
				$.each(state_textarea, function(index, value) {
					$(value).val(state_select_val);
				});
			}

			var input_name = $statebox.attr('name');
			var input_id = $statebox.attr('id');
			var value = $statebox.val();
			var placeholder = $statebox.attr('placeholder');

			// Reset states; WC 2.3+ (2.4+, 2.5.0) wc_country_select_params was moved out the wc_country_select_params object into the window object
			if( states === false && window.wc_country_select_params && window.wc_country_select_params.countries ) {
				states = jQuery.parseJSON( window.wc_country_select_params.countries.replace(/&quot;/g, '"') );
				wc_country_select_params = window.wc_country_select_params;
			}

			if (states[country]) {
				if (states[country].length == 0) {

					$statebox.parent().hide().find('.chosen-container').remove();
					$statebox.replaceWith('<input type="hidden" class="hidden" name="' + input_name + '" id="' + input_id + '" value="" placeholder="' + placeholder + '" />');

					$body.trigger('country_to_state_changed', [country, $(this).closest('div')]);

				} else {

					var options = '';
					var state = states[country];
					for(var index in state) {
						options = options + '<option value="' + index + '">' + state[index] + '</option>';
					}
					$statebox.parent().show();
					if ($statebox.is('input')) {
						// Change for select
						$statebox.replaceWith('<select name="' + input_name + '" id="' + input_id + '" class="state_select" placeholder="' + placeholder + '"></select>');
						$statebox = $(this).closest('div').find('#billing_state, #shipping_state, #calc_shipping_state');
					}
					$statebox.html( '<option value="">' + wc_country_select_params.i18n_select_state_text + '</option>' + options);

					$statebox.val(value);

					$body.trigger('country_to_state_changed', [country, $(this).closest('div')]);

				}
			} else {
				if ($statebox.is('select')) {

					$parent.show().find('.chosen-container').remove();
					$statebox.replaceWith('<input type="text" class="input-text" name="' + input_name + '" id="' + input_id + '" placeholder="' + placeholder + '" />');

					$body.trigger('country_to_state_changed', [country, $(this).closest('div')]);

				} else if ($statebox.is('.hidden')) {

					$parent.show().find('.chosen-container').remove();
					$statebox.replaceWith('<input type="text" class="input-text" name="' + input_name + '" id="' + input_id + '" placeholder="' + placeholder + '" />');

					$body.trigger('country_to_state_changed', [country, $(this).closest('div')]);

				}
			}

			$body.trigger('country_to_state_changing', [country, $(this).closest('div')]);

		});
		// Trigger change
		$('select.country_to_state, input.country_to_state').change();

	}

	$doc.ready(woo.dowoo);

	return woo;

})(window, document, jQuery);

function wooinit() {
	wooobject.init();
}    