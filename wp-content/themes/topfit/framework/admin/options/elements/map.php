<?php

if(!function_exists('topfit_mikado_load_elements_map')) {
	/**
	 * Add Elements option page for shortcodes
	 */
	function topfit_mikado_load_elements_map() {

		topfit_mikado_add_admin_page(
			array(
				'slug'  => '_elements_page',
				'title' => esc_html__('Elements','topfit'),
				'icon'  => 'icon_star_alt'
			)
		);

		do_action('topfit_mikado_options_elements_map');

	}

	add_action('topfit_mikado_options_map', 'topfit_mikado_load_elements_map');

}