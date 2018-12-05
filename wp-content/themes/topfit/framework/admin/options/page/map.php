<?php

if(!function_exists('topfit_mikado_page_options_map')) {

	function topfit_mikado_page_options_map() {

		topfit_mikado_add_admin_page(
			array(
				'slug'  => '_page_page',
				'title' => esc_html__('Page','topfit'),
				'icon'  => 'icon_document_alt'
			)
		);

		$custom_sidebars = topfit_mikado_get_custom_sidebars();

		$panel_sidebar = topfit_mikado_add_admin_panel(
			array(
				'page'  => '_page_page',
				'name'  => 'panel_sidebar',
				'title' => esc_html__('Design Style','topfit')
			)
		);

		topfit_mikado_add_admin_field(array(
			'name'          => 'page_sidebar_layout',
			'type'          => 'select',
			'label'         => esc_html__('Sidebar Layout','topfit'),
			'description'   => esc_html__('Choose a sidebar layout for pages','topfit'),
			'default_value' => 'default',
			'parent'        => $panel_sidebar,
			'options'       => array(
				'default'          => esc_html__('No Sidebar','topfit'),
				'sidebar-33-right' => esc_html__('Sidebar 1/3 Right','topfit'),
				'sidebar-25-right' => esc_html__('Sidebar 1/4 Right','topfit'),
				'sidebar-33-left'  => esc_html__('Sidebar 1/3 Left','topfit'),
				'sidebar-25-left'  => esc_html__('Sidebar 1/4 Left','topfit'),
			)
		));


		if(count($custom_sidebars) > 0) {
			topfit_mikado_add_admin_field(array(
				'name'        => 'page_custom_sidebar',
				'type'        => 'selectblank',
				'label'       => esc_html__('Sidebar to Display','topfit'),
				'description' => esc_html__('Choose a sidebar to display on pages. Default sidebar is "Sidebar"','topfit'),
				'parent'      => $panel_sidebar,
				'options'     => $custom_sidebars
			));
		}

		topfit_mikado_add_admin_field(array(
			'name'          => 'page_show_comments',
			'type'          => 'yesno',
			'label'         => esc_html__('Show Comments','topfit'),
			'description'   => esc_html__('Enabling this option will show comments on your page', 'topfit'),
			'default_value' => 'yes',
			'parent'        => $panel_sidebar
		));

	}

	add_action('topfit_mikado_options_map', 'topfit_mikado_page_options_map', 9);

}