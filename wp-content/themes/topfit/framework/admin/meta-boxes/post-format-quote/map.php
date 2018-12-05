<?php

/*** Quote Post Format ***/

if (!function_exists('topfit_mikado_quote_post_meta_box_map')) {
	function topfit_mikado_quote_post_meta_box_map() {

		$quote_post_format_meta_box = topfit_mikado_add_meta_box(
			array(
				'scope' => array('post'),
				'title' => esc_html__('Quote Post Format', 'topfit'),
				'name'  => 'post_format_quote_meta'
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_post_quote_text_meta',
				'type'        => 'text',
				'label'       => esc_html__('Quote Text', 'topfit'),
				'description' => esc_html__('Enter Quote text', 'topfit'),
				'parent'      => $quote_post_format_meta_box,

			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_post_quote_color',
				'type'        => 'color',
				'label'       => esc_html__('Quote Background Color', 'topfit'),
				'description' => esc_html__('Post background color', 'topfit'),
				'parent'      => $quote_post_format_meta_box,

			)
		);
	}

	add_action('topfit_mikado_meta_boxes_map', 'topfit_mikado_quote_post_meta_box_map');
}