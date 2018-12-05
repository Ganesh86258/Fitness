<?php

/*** Gallery Post Format ***/


if (!function_exists('topfit_mikado_gallery_post_meta_box_map')) {
	function topfit_mikado_gallery_post_meta_box_map() {
		$gallery_post_format_meta_box = topfit_mikado_add_meta_box(
			array(
				'scope' => array('post'),
				'title' => esc_html__('Gallery Post Format', 'topfit'),
				'name'  => 'post_format_gallery_meta'
			)
		);

		topfit_mikado_add_multiple_images_field(
			array(
				'name'        => 'mkd_post_gallery_images_meta',
				'label'       => esc_html__('Gallery Images', 'topfit'),
				'description' => esc_html__('Choose your gallery images', 'topfit'),
				'parent'      => $gallery_post_format_meta_box,
			)
		);
	}
	add_action('topfit_mikado_meta_boxes_map', 'topfit_mikado_gallery_post_meta_box_map');
}