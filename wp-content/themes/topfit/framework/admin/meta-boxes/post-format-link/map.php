<?php

/*** Link Post Format ***/
if (!function_exists('topfit_mikado_link_post_meta_box_map')) {
	function topfit_mikado_link_post_meta_box_map() {

		$link_post_format_meta_box = topfit_mikado_add_meta_box(
			array(
				'scope' => array('post'),
				'title' => esc_html__('Link Post Format', 'topfit'),
				'name'  => 'post_format_link_meta'
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_post_link_link_meta',
				'type'        => 'text',
				'label'       => esc_html__('Link', 'topfit'),
				'description' => esc_html__('Enter link', 'topfit'),
				'parent'      => $link_post_format_meta_box,

			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_post_link_color',
				'type'        => 'color',
				'label'       => esc_html__('Link Background Color', 'topfit'),
				'description' => esc_html__('Post background color', 'topfit'),
				'parent'      => $link_post_format_meta_box,

			)
		);
	}

	add_action('topfit_mikado_meta_boxes_map', 'topfit_mikado_link_post_meta_box_map');
}