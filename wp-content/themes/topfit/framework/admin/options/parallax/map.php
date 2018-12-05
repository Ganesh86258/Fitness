<?php

if(!function_exists('topfit_mikado_parallax_options_map')) {
	/**
	 * Parallax options page
	 */
	function topfit_mikado_parallax_options_map() {

		$panel_parallax = topfit_mikado_add_admin_panel(
			array(
				'page'  => '_elements_page',
				'name'  => 'panel_parallax',
				'title' => esc_html__('Parallax','topfit'),
			)
		);

		topfit_mikado_add_admin_field(array(
			'type'          => 'onoff',
			'name'          => 'parallax_on_off',
			'default_value' => 'off',
			'label'         => esc_html__('Parallax on touch devices','topfit'),
			'description'   => esc_html__('Enabling this option will allow parallax on touch devices','topfit'),
			'parent'        => $panel_parallax
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'text',
			'name'          => 'parallax_min_height',
			'default_value' => '400',
			'label'         => esc_html__('Parallax Min Height', 'topfit'),
			'description'   => esc_html__('Set a minimum height for parallax images on small displays (phones, tablets, etc.)', 'topfit'),
			'args'          => array(
				'col_width' => 3,
				'suffix'    => 'px'
			),
			'parent'        => $panel_parallax
		));

	}

	add_action('topfit_mikado_options_map', 'topfit_mikado_parallax_options_map');

}