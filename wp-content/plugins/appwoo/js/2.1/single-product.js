(function(window, document, $, undefined){

	// This will only allow apppresser.singleProduct to be run only once, but at least once.
	var singleProductDone = false;

	apppresser.singleProductInit = function() {

		// wc_single_product_params is required to continue, ensure the object exists
		if (typeof wc_single_product_params === "undefined")
			return false;

		apppresser.singleProduct();
		apppresser.singleProductAjax();

	}

	apppresser.singleProduct = function() {
		if ( singleProductDone )
			return;

		$('body')
			// Ratings
			.on( 'click', '#respond p.stars a', function(e){
				e.preventDefault();

				var $star   = $(this);
				var $rating = $(this).closest('#respond').find('#rating');

				$rating.val( $star.text() );
				$star.siblings('a').removeClass('active');
				$star.addClass('active');
			})
			// Tabs
			.on( 'click', '.woocommerce-tabs ul.tabs li a', function(e) {
				e.preventDefault();

				var $tab = $(this);
				var $tabs_wrapper = $tab.closest('.woocommerce-tabs');

				$('ul.tabs li', $tabs_wrapper).removeClass('active');
				$('div.panel', $tabs_wrapper).hide();
				$('div' + $tab.attr('href')).show();
				$tab.parent().addClass('active');

			})
			// Comment Form
			.on( 'click', '#respond #submit', function(){
				var $rating = $(this).closest('#respond').find('#rating');
				var rating  = $rating.val();

				if ( $rating.size() > 0 && ! rating && wc_single_product_params.review_rating_required == 'yes' ) {
					alert(wc_single_product_params.i18n_required_rating_text);
					return false;
				}
			})
			// prevent double form submission. This breaks WC 3.0+
			// .on( 'submit', 'form.cart', function(){
			// 	$(this).find(':submit').attr( 'disabled','disabled' );
			// })
			// If clicking review link, show the right tab
			.on( 'click', 'a.woocommerce-review-link', function(){
				$('.reviews_tab a').click();
			});

		singleProductDone = true;
	};

	apppresser.singleProductAjax = function() {

		// Star ratings for comments
		$('#rating').hide().before('<p class="stars"><span><a class="star-1" href="#">1</a><a class="star-2" href="#">2</a><a class="star-3" href="#">3</a><a class="star-4" href="#">4</a><a class="star-5" href="#">5</a></span></p>');

		// Tabs
		$('.woocommerce-tabs .panel').hide();

		// Check for active tab
		$('.woocommerce-tabs').each(function() {
			var hash 	= window.location.hash;
			var url		= window.location.href;

			if (hash.toLowerCase().indexOf("comment-") >= 0) {
				$('ul.tabs li.reviews_tab a', $(this)).click();
			} else {
				$('ul.tabs li:first a', $(this)).click();
			}

			if ( url.indexOf("comment-page-") > 0 || url.indexOf("cpage=") > 0 ) {
				$( 'ul.tabs li.reviews_tab a', $( this ) ).click();
			} else {
				$( 'ul.tabs li:first a', $( this ) ).click();
			}
		});

	};

})(window, document, jQuery);

jQuery(document).ready( apppresser.singleProductInit ).bind( 'load_ajax_content_done', apppresser.singleProductInit );
