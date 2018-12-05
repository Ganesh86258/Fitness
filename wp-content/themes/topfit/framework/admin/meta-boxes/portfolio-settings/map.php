<?php

if (!function_exists('topfit_mikado_portfolio_settings_meta_box_map')) {
	function topfit_mikado_portfolio_settings_meta_box_map() {

		$meta_box = topfit_mikado_add_meta_box(array(
			'scope' => 'portfolio-item',
			'title' => esc_html__('Portfolio Settings', 'topfit'),
			'name'  => 'portfolio_settings_meta_box'
		));

		topfit_mikado_add_meta_box_field(array(
			'name'        => 'mkd_portfolio_single_template_meta',
			'type'        => 'select',
			'label'       => esc_html__('Portfolio Type', 'topfit'),
			'description' => esc_html__('Choose a default type for Single Project pages', 'topfit'),
			'parent'      => $meta_box,
			'options'     => array(
				''                  => esc_html__('Default', 'topfit'),
				'small-images'      => esc_html__('Portfolio small images', 'topfit'),
				'small-slider'      => esc_html__('Portfolio small slider', 'topfit'),
				'big-images'        => esc_html__('Portfolio big images', 'topfit'),
				'big-slider'        => esc_html__('Portfolio big slider', 'topfit'),
				'custom'            => esc_html__('Portfolio custom', 'topfit'),
				'full-width-custom' => esc_html__('Portfolio full width custom', 'topfit'),
				'gallery'           => esc_html__('Portfolio gallery', 'topfit'),
				'video'             => esc_html__('Portfolio video', 'topfit'),
			)
		));

		$all_pages = array();
		$pages = get_pages();
		foreach ($pages as $page) {
			$all_pages[$page->ID] = $page->post_title;
		}

		topfit_mikado_add_meta_box_field(array(
			'name'        => 'portfolio_single_back_to_link',
			'type'        => 'select',
			'label'       => esc_html__('"Back To" Link', 'topfit'),
			'description' => esc_html__('Choose "Back To" page to link from portfolio Single Project page', 'topfit'),
			'parent'      => $meta_box,
			'options'     => $all_pages
		));

		$group_portfolio_external_link = topfit_mikado_add_admin_group(array(
			'name'        => 'group_portfolio_external_link',
			'title'       => esc_html__('Portfolio External Link', 'topfit'),
			'description' => esc_html__('Enter URL to link from Portfolio List page', 'topfit'),
			'parent'      => $meta_box
		));

		$row_portfolio_external_link = topfit_mikado_add_admin_row(array(
			'name'   => 'row_gradient_overlay',
			'parent' => $group_portfolio_external_link
		));

		topfit_mikado_add_meta_box_field(array(
			'name'        => 'portfolio_external_link',
			'type'        => 'textsimple',
			'label'       => esc_html__('Link', 'topfit'),
			'description' => '',
			'parent'      => $row_portfolio_external_link,
			'args'        => array(
				'col_width' => 3
			)
		));

		topfit_mikado_add_meta_box_field(array(
			'name'        => 'portfolio_external_link_target',
			'type'        => 'selectsimple',
			'label'       => esc_html__('Target', 'topfit'),
			'description' => '',
			'parent'      => $row_portfolio_external_link,
			'options'     => array(
				'_self'  => esc_html__('Same Window', 'topfit'),
				'_blank' => esc_html__('New Window', 'topfit')
			)
		));

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'portfolio_masonry_dimenisions',
				'type'        => 'select',
				'label'       => esc_html__('Dimensions for Masonry', 'topfit'),
				'description' => esc_html__('Choose image layout when it appears in Masonry type portfolio lists', 'topfit'),
				'parent'      => $meta_box,
				'options'     => array(
					'default'            => esc_html__('Default', 'topfit'),
					'large_width'        => esc_html__('Large width', 'topfit'),
					'large_height'       => esc_html__('Large height', 'topfit'),
					'large_width_height' => esc_html__('Large width/height', 'topfit')
				)
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'portfolio_background_color',
				'type'        => 'color',
				'label'       => esc_html__('Portfolio Background Color', 'topfit'),
				'description' => esc_html__('Portfolio background color used for some portfolio list hover animations', 'topfit'),
				'parent'      => $meta_box,

			)
		);

	}


	add_action('topfit_mikado_meta_boxes_map', 'topfit_mikado_portfolio_settings_meta_box_map');
}