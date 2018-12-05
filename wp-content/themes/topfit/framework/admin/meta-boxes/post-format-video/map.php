<?php

/*** Video Post Format ***/

if (!function_exists('topfit_mikado_video_post_meta_box_map')) {
	function topfit_mikado_video_post_meta_box_map() {

		$video_post_format_meta_box = topfit_mikado_add_meta_box(
			array(
				'scope' => array('post'),
				'title' => esc_html__('Video Post Format', 'topfit'),
				'name'  => 'post_format_video_meta'
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'          => 'mkd_video_type_meta',
				'type'          => 'select',
				'label'         => esc_html__('Video Type', 'topfit'),
				'description'   => esc_html__('Choose video type', 'topfit'),
				'parent'        => $video_post_format_meta_box,
				'default_value' => 'youtube',
				'options'       => array(
					'youtube' => esc_html__('Youtube', 'topfit'),
					'vimeo'   => esc_html__('Vimeo', 'topfit'),
					'self'    => esc_html__('Self Hosted', 'topfit')
				),
				'args'          => array(
					'dependence' => true,
					'hide'       => array(
						'youtube' => '#mkd_mkd_video_self_hosted_container',
						'vimeo'   => '#mkd_mkd_video_self_hosted_container',
						'self'    => '#mkd_mkd_video_embedded_container'
					),
					'show'       => array(
						'youtube' => '#mkd_mkd_video_embedded_container',
						'vimeo'   => '#mkd_mkd_video_embedded_container',
						'self'    => '#mkd_mkd_video_self_hosted_container'
					)
				)
			)
		);

		$mkd_video_embedded_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $video_post_format_meta_box,
				'name'            => 'mkd_video_embedded_container',
				'hidden_property' => 'mkd_video_type_meta',
				'hidden_value'    => 'self'
			)
		);

		$mkd_video_self_hosted_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $video_post_format_meta_box,
				'name'            => 'mkd_video_self_hosted_container',
				'hidden_property' => 'mkd_video_type_meta',
				'hidden_values'   => array('youtube', 'vimeo')
			)
		);


		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_post_video_id_meta',
				'type'        => 'text',
				'label'       => esc_html__('Video ID', 'topfit'),
				'description' => esc_html__('Enter Video ID', 'topfit'),
				'parent'      => $mkd_video_embedded_container,

			)
		);


		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_post_video_image_meta',
				'type'        => 'image',
				'label'       => esc_html__('Video Image', 'topfit'),
				'description' => esc_html__('Upload video image', 'topfit'),
				'parent'      => $mkd_video_self_hosted_container,

			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_post_video_webm_link_meta',
				'type'        => 'text',
				'label'       => esc_html__('Video WEBM', 'topfit'),
				'description' => esc_html__('Enter video URL for WEBM format', 'topfit'),
				'parent'      => $mkd_video_self_hosted_container,

			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_post_video_mp4_link_meta',
				'type'        => 'text',
				'label'       => esc_html__('Video MP4', 'topfit'),
				'description' => esc_html__('Enter video URL for MP4 format', 'topfit'),
				'parent'      => $mkd_video_self_hosted_container,

			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_post_video_ogv_link_meta',
				'type'        => 'text',
				'label'       => esc_html__('Video OGV', 'topfit'),
				'description' => esc_html__('Enter video URL for OGV format', 'topfit'),
				'parent'      => $mkd_video_self_hosted_container,

			)
		);
	}

	add_action('topfit_mikado_meta_boxes_map', 'topfit_mikado_video_post_meta_box_map');
}