<?php

/*** Post Options ***/

if (!function_exists('topfit_mikado_blog_post_meta_box_map')) {
	function topfit_mikado_blog_post_meta_box_map() {

		$post_meta_box = topfit_mikado_add_meta_box(
			array(
				'scope' => array('post'),
				'title' => esc_html__('Post', 'topfit'),
				'name'  => 'post_meta'
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'          => 'mkd_blog_single_type_meta',
				'type'          => 'select',
				'label'         => esc_html__('Post Type', 'topfit'),
				'description'   => esc_html__('Choose post type', 'topfit'),
				'parent'        => $post_meta_box,
				'default_value' => 'youtube',
				'options'       => array(
					''             => '',
					'standard'     => esc_html__('Standard', 'topfit'),
					'image-title' => esc_html__('Image Title', 'topfit'),
				)
			)
		);

		topfit_mikado_add_meta_box_field(array(
			'name'          => 'mkd_blog_masonry_gallery_dimensions',
			'type'          => 'select',
			'label'         => esc_html__('Dimensions for Masonry Gallery', 'topfit'),
			'description'   => esc_html__('Choose image layout when it appears in Masonry Gallery list', 'topfit'),
			'parent'        => $post_meta_box,
			'options'       => array(
				'square'             => esc_html__('Square', 'topfit'),
				'large-width'        => esc_html__('Large width', 'topfit'),
				'large-height'       => esc_html__('Large height', 'topfit'),
				'large-width-height' => esc_html__('Large width/height', 'topfit'),
			),
			'default_value' => 'square'
		));


	}
	add_action('topfit_mikado_meta_boxes_map', 'topfit_mikado_blog_post_meta_box_map');
}