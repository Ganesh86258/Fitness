<?php

/*** Audio Post Format ***/

if (!function_exists('topfit_mikado_audio_post_meta_box_map')) {
	function topfit_mikado_audio_post_meta_box_map() {

		$audio_post_format_meta_box = topfit_mikado_add_meta_box(
			array(
				'scope' => array('post'),
				'title' => esc_html__('Audio Post Format', 'topfit'),
				'name'  => 'post_format_audio_meta'
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_post_audio_link_meta',
				'type'        => 'text',
				'label'       => esc_html__('Link', 'topfit'),
				'description' => esc_html__('Enter audion link', 'topfit'),
				'parent'      => $audio_post_format_meta_box,

			)
		);

	}
	add_action('topfit_mikado_meta_boxes_map', 'topfit_mikado_audio_post_meta_box_map');
}