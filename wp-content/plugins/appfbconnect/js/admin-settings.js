jQuery('#apppresser--appfbconnect_disable_rewrite').on('click', function(event) {
	jQuery('.appp-rewrite-warning').fadeIn();
});

jQuery('.toggle-appp-rewrite-warning').on('click', function(event) {
	event.preventDefault();
	jQuery('.appfbc-more').fadeOut();
	jQuery('.appp-rewrite-warning').fadeIn();
});