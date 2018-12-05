(function ($) {
	'use strict';

	var woocommerce = {};
	mkd.modules.woocommerce = woocommerce;

	woocommerce.mkdInitQuantityButtons = mkdInitQuantityButtons;
	woocommerce.mkdInitSelect2 = mkdInitSelect2;

	woocommerce.mkdOnDocumentReady = mkdOnDocumentReady;
	woocommerce.mkdOnWindowLoad = mkdOnWindowLoad;
	woocommerce.mkdOnWindowResize = mkdOnWindowResize;
	woocommerce.mkdOnWindowScroll = mkdOnWindowScroll;

	woocommerce.mkdProductImagesMinHeight = mkdProductImagesMinHeight;

	$(document).ready(mkdOnDocumentReady);
	$(window).load(mkdOnWindowLoad);
	$(window).resize(mkdOnWindowResize);
	$(window).scroll(mkdOnWindowScroll);

	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function mkdOnDocumentReady() {
		mkdInitQuantityButtons();
		mkdInitSelect2();
		mkdProductImagesMinHeight();
		mkdInitSingleProductLightbox();
	}

	/*
	 All functions to be called on $(window).load() should be in this function
	 */
	function mkdOnWindowLoad() {

	}

	/*
	 All functions to be called on $(window).resize() should be in this function
	 */
	function mkdOnWindowResize() {
		mkdProductImagesMinHeight();
	}

	/*
	 All functions to be called on $(window).scroll() should be in this function
	 */
	function mkdOnWindowScroll() {

	}


	function mkdInitQuantityButtons() {

		$(document).on( 'click', '.mkd-quantity-minus, .mkd-quantity-plus', function(e) {
			e.stopPropagation();

			var button = $(this),
				inputField = button.siblings('.mkd-quantity-input'),
				step = parseFloat(inputField.attr('step')),
				max = parseFloat(inputField.attr('max')),
				minus = false,
				inputValue = parseFloat(inputField.val()),
				newInputValue;

			if (button.hasClass('mkd-quantity-minus')) {
				minus = true;
			}

			if (minus) {
				newInputValue = inputValue - step;
				if (newInputValue >= 1) {
					inputField.val(newInputValue);
				} else {
					inputField.val(1);
				}
			} else {
				newInputValue = inputValue + step;
				if ( max === undefined ) {
					inputField.val(newInputValue);
				} else {
					if ( newInputValue >= max ) {
						inputField.val(max);
					} else {
						inputField.val(newInputValue);
					}
				}
			}

			inputField.trigger( 'change' );
		});
	}

	function mkdInitSelect2() {

		if ($('.woocommerce-ordering .orderby').length || $('#calc_shipping_country').length) {

			$('.woocommerce-ordering .orderby').select2({
				minimumResultsForSearch: Infinity
			});

			$('#calc_shipping_country').select2();
		}

		$('.variations_form.cart select').select2({
			minimumResultsForSearch: Infinity
		});
	}


	/* calculate product images section min height because of absolute position */
	function mkdProductImagesMinHeight() {
		var hh = $('.mkd-woo-single-page .product .images a.woocommerce-main-image').height();
		$('.mkd-woo-single-page .product .images').css({'min-height': hh});
	}


    /*
     ** Init Product Single Pretty Photo attributes
     */
    function mkdInitSingleProductLightbox() {
        var item = $('.mkd-woo-single-page .images .woocommerce-product-gallery__image');

        if(item.length) {
            item.children('a').attr('data-rel', 'prettyPhoto[woo_single_pretty_photo]');

            if (typeof mkd.modules.common.mkdPrettyPhoto === "function") {
                mkd.modules.common.mkdPrettyPhoto();
            }
        }
    }


})(jQuery);