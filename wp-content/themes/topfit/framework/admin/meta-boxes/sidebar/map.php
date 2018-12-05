<?php

if (!function_exists('topfit_mikado_sidebar_meta_box_map')) {
	function topfit_mikado_sidebar_meta_box_map() {

		$mkd_custom_sidebars = topfit_mikado_get_custom_sidebars();

		$mkd_sidebar_meta_box = topfit_mikado_add_meta_box(
			array(
				'scope' => array('page', 'portfolio-item', 'post'),
				'title' => esc_html__('Sidebar', 'topfit'),
				'name'  => 'sidebar_meta'
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_sidebar_meta',
				'type'        => 'select',
				'label'       => esc_html__('Layout', 'topfit'),
				'description' => esc_html__('Choose the sidebar layout', 'topfit'),
				'parent'      => $mkd_sidebar_meta_box,
				'options'     => array(
					''                 => esc_html__('Default', 'topfit'),
					'no-sidebar'       => esc_html__('No Sidebar', 'topfit'),
					'sidebar-33-right' => esc_html__('Sidebar 1/3 Right', 'topfit'),
					'sidebar-25-right' => esc_html__('Sidebar 1/4 Right', 'topfit'),
					'sidebar-33-left'  => esc_html__('Sidebar 1/3 Left', 'topfit'),
					'sidebar-25-left'  => esc_html__('Sidebar 1/4 Left', 'topfit'),
				)
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'    => 'mkd_boxed_widgets_meta',
				'type'    => 'selectblank',
				'label'   => esc_html__('Boxed Widgets', 'topfit'),
				'parent'  => $mkd_sidebar_meta_box,
				'options' => array(
					'no'  => esc_html__('No', 'topfit'),
					'yes' => esc_html__('Yes', 'topfit')
				)
			)
		);

		if (count($mkd_custom_sidebars) > 0) {
			topfit_mikado_add_meta_box_field(array(
				'name'        => 'mkd_custom_sidebar_meta',
				'type'        => 'selectblank',
				'label'       => esc_html__('Choose Widget Area in Sidebar', 'topfit'),
				'description' => esc_html__('Choose Custom Widget area to display in Sidebar', 'topfit'),
				'parent'      => $mkd_sidebar_meta_box,
				'options'     => $mkd_custom_sidebars
			));
		}

	}
	add_action('topfit_mikado_meta_boxes_map', 'topfit_mikado_sidebar_meta_box_map');
}