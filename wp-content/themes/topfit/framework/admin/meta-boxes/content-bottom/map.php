<?php

if (!function_exists('topfit_mikado_content_bottom_meta_box_map')) {
	function topfit_mikado_content_bottom_meta_box_map() {

		$content_bottom_meta_box = topfit_mikado_add_meta_box(
			array(
				'scope' => array('page', 'portfolio-item', 'post'),
				'title' => esc_html__('Content Bottom', 'topfit'),
				'name' => 'content_bottom_meta'
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name' => 'mkd_enable_content_bottom_area_meta',
				'type' => 'selectblank',
				'default_value' => '',
				'label' => esc_html__('Enable Content Bottom Area', 'topfit'),
				'description' => esc_html__('This option will enable Content Bottom area on pages', 'topfit'),
				'parent' => $content_bottom_meta_box,
				'options' => array(
					'no' => esc_html__('No', 'topfit'),
					'yes' => esc_html__('Yes',  'topfit')
				),
				'args' => array(
					'dependence' => true,
					'hide' => array(
						'' => '#mkd_mkd_show_content_bottom_meta_container',
						'no' => '#mkd_mkd_show_content_bottom_meta_container'
					),
					'show' => array(
						'yes' => '#mkd_mkd_show_content_bottom_meta_container'
					)
				)
			)
		);

		$show_content_bottom_meta_container = topfit_mikado_add_admin_container(
			array(
				'parent' => $content_bottom_meta_box,
				'name' => 'mkd_show_content_bottom_meta_container',
				'hidden_property' => 'mkd_enable_content_bottom_area_meta',
				'hidden_value' => '',
				'hidden_values' => array('','no')
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name' => 'mkd_content_bottom_sidebar_custom_display_meta',
				'type' => 'selectblank',
				'default_value' => '',
				'label' => esc_html__('Sidebar to Display', 'topfit'),
				'description' => esc_html__('Choose a Content Bottom sidebar to display', 'topfit'),
				'options' => topfit_mikado_get_custom_sidebars(),
				'parent' => $show_content_bottom_meta_container
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'type' => 'selectblank',
				'name' => 'mkd_content_bottom_in_grid_meta',
				'default_value' => '',
				'label' => esc_html__('Display in Grid', 'topfit'),
				'description' => esc_html__('Enabling this option will place Content Bottom in grid', 'topfit'),
				'options' => array(
					'no' => esc_html__('No', 'topfit'),
					'yes' => esc_html__('Yes', 'topfit')
				),
				'parent' => $show_content_bottom_meta_container
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'type' => 'color',
				'name' => 'mkd_content_bottom_background_color_meta',
				'default_value' => '',
				'label' => esc_html__('Background Color', 'topfit'),
				'description' => esc_html__('Choose a background color for Content Bottom area', 'topfit'),
				'parent' => $show_content_bottom_meta_container
			)
		);


	}
	add_action('topfit_mikado_meta_boxes_map', 'topfit_mikado_content_bottom_meta_box_map');
}