<?php

if (!function_exists('topfit_mikado_title_meta_box_map')) {
	function topfit_mikado_title_meta_box_map() {

		$title_meta_box = topfit_mikado_add_meta_box(
			array(
				'scope' => array('page', 'portfolio-item', 'post', 'tribe_events', 'tt-events', 'events'),
				'title' => esc_html__('Title', 'topfit'),
				'name'  => 'title_meta'
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'          => 'mkd_show_title_area_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__('Show Title Area', 'topfit'),
				'description'   => esc_html__('Disabling this option will turn off page title area', 'topfit'),
				'parent'        => $title_meta_box,
				'options'       => array(
					''    => '',
					'no'  => esc_html__('No', 'topfit'),
					'yes' => esc_html__( 'Yes', 'topfit')
				),
				'args'          => array(
					"dependence" => true,
					"hide"       => array(
						""    => "",
						"no"  => "#mkd_mkd_show_title_area_meta_container",
						"yes" => ""
					),
					"show"       => array(
						""    => "#mkd_mkd_show_title_area_meta_container",
						"no"  => "",
						"yes" => "#mkd_mkd_show_title_area_meta_container"
					)
				)
			)
		);

		$show_title_area_meta_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $title_meta_box,
				'name'            => 'mkd_show_title_area_meta_container',
				'hidden_property' => 'mkd_show_title_area_meta',
				'hidden_value'    => 'no'
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'          => 'mkd_title_area_type_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__('Title Area Type', 'topfit'),
				'description'   => esc_html__('Choose title type', 'topfit'),
				'parent'        => $show_title_area_meta_container,
				'options'       => array(
					''           => '',
					'standard'   => esc_html__('Standard', 'topfit'),
					'breadcrumb' => esc_html__('Breadcrumb', 'topfit'),
				),
				'args'          => array(
					"dependence" => true,
					"hide"       => array(
						"standard"   => "",
						"standard"   => "",
						"breadcrumb" => "#mkd_mkd_title_area_type_meta_container"
					),
					"show"       => array(
						""           => "#mkd_mkd_title_area_type_meta_container",
						"standard"   => "#mkd_mkd_title_area_type_meta_container",
						"breadcrumb" => ""
					)
				)
			)
		);

		$title_area_type_meta_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $show_title_area_meta_container,
				'name'            => 'mkd_title_area_type_meta_container',
				'hidden_property' => 'mkd_title_area_type_meta',
				'hidden_value'    => '',
				'hidden_values'   => array('breadcrumb'),
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'          => 'mkd_title_area_enable_breadcrumbs_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__('Enable Breadcrumbs', 'topfit'),
				'description'   => esc_html__('This option will display Breadcrumbs in Title Area', 'topfit'),
				'parent'        => $title_area_type_meta_container,
				'options'       => array(
					''    => '',
					'no'  => esc_html__('No', 'topfit'),
					'yes' => esc_html__('Yes', 'topfit'),
				),
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'          => 'mkd_title_in_grid_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__('Title in Grid', 'topfit'),
				'description'   => esc_html__('Set title content to be in grid', 'topfit'),
				'parent'        => $show_title_area_meta_container,
				'options'       => array(
					''           => '',
					'no'  => esc_html__('No', 'topfit'),
					'yes' => esc_html__('Yes', 'topfit'),
				)
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'          => 'mkd_title_area_animation_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__('Animations', 'topfit'),
				'description'   => esc_html__('Choose an animation for Title Area', 'topfit'),
				'parent'        => $show_title_area_meta_container,
				'options'       => array(
					''           => '',
					'no'         => esc_html__('No Animation', 'topfit'),
					'right-left' => esc_html__('Text right to left', 'topfit'),
					'left-right' => esc_html__('Text left to right', 'topfit')
				)
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'          => 'mkd_title_area_vertial_alignment_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__('Vertical Alignment', 'topfit'),
				'description'   => esc_html__('Specify title vertical alignment', 'topfit'),
				'parent'        => $show_title_area_meta_container,
				'options'       => array(
					''              => '',
					'header_bottom' => esc_html__('From Bottom of Header', 'topfit'),
					'window_top'    => esc_html__('From Window Top', 'topfit')
				)
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'          => 'mkd_title_area_content_alignment_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__('Horizontal Alignment', 'topfit'),
				'description'   => esc_html__('Specify title horizontal alignment', 'topfit'),
				'parent'        => $show_title_area_meta_container,
				'options'       => array(
					''       => '',
					'left'   => esc_html__('Left', 'topfit'),
					'center' => esc_html__('Center', 'topfit'),
					'right'  => esc_html__('Right', 'topfit')
				)
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_title_text_color_meta',
				'type'        => 'color',
				'label'       => esc_html__('Title Color', 'topfit'),
				'description' => esc_html__('Choose a color for title text', 'topfit'),
				'parent'      => $show_title_area_meta_container
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_title_breadcrumb_color_meta',
				'type'        => 'color',
				'label'       => esc_html__('Breadcrumb Color', 'topfit'),
				'description' => esc_html__('Choose a color for breadcrumb text', 'topfit'),
				'parent'      => $show_title_area_meta_container
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_title_area_background_color_meta',
				'type'        => 'color',
				'label'       => esc_html__('Background Color', 'topfit'),
				'description' => esc_html__('Choose a background color for Title Area', 'topfit'),
				'parent'      => $show_title_area_meta_container
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'          => 'mkd_hide_background_image_meta',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__('Hide Background Image', 'topfit'),
				'description'   => esc_html__('Enable this option to hide background image in Title Area', 'topfit'),
				'parent'        => $show_title_area_meta_container,
				'args'          => array(
					"dependence"             => true,
					"dependence_hide_on_yes" => "#mkd_mkd_hide_background_image_meta_container",
					"dependence_show_on_yes" => ""
				)
			)
		);

		$hide_background_image_meta_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $show_title_area_meta_container,
				'name'            => 'mkd_hide_background_image_meta_container',
				'hidden_property' => 'mkd_hide_background_image_meta',
				'hidden_value'    => 'yes'
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_title_area_background_image_meta',
				'type'        => 'image',
				'label'       => esc_html__('Background Image', 'topfit'),
				'description' => esc_html__('Choose an Image for Title Area', 'topfit'),
				'parent'      => $hide_background_image_meta_container
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'          => 'mkd_title_area_background_image_responsive_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__('Background Responsive Image', 'topfit'),
				'description'   => esc_html__('Enabling this option will make Title background image responsive', 'topfit'),
				'parent'        => $hide_background_image_meta_container,
				'options'       => array(
					''    => '',
					'no'  => esc_html__('No', 'topfit'),
					'yes' => esc_html__('Yes', 'topfit')
				),
				'args'          => array(
					"dependence" => true,
					"hide"       => array(
						""    => "",
						"no"  => "",
						"yes" => "#mkd_mkd_title_area_background_image_responsive_meta_container, #mkd_mkd_title_area_height_meta"
					),
					"show"       => array(
						""    => "#mkd_mkd_title_area_background_image_responsive_meta_container, #mkd_mkd_title_area_height_meta",
						"no"  => "#mkd_mkd_title_area_background_image_responsive_meta_container, #mkd_mkd_title_area_height_meta",
						"yes" => ""
					)
				)
			)
		);

		$title_area_background_image_responsive_meta_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $hide_background_image_meta_container,
				'name'            => 'mkd_title_area_background_image_responsive_meta_container',
				'hidden_property' => 'mkd_title_area_background_image_responsive_meta',
				'hidden_value'    => 'yes'
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'          => 'mkd_title_area_background_image_parallax_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__('Background Image in Parallax', 'topfit'),
				'description'   => esc_html__('Enabling this option will make Title background image parallax', 'topfit'),
				'parent'        => $title_area_background_image_responsive_meta_container,
				'options'       => array(
					''         => '',
					'no'       => esc_html__('No', 'topfit'),
					'yes'      => esc_html__('Yes', 'topfit'),
					'yes_zoom' => esc_html__('Yes, with zoom out', 'topfit')
				)
			)
		);

		topfit_mikado_add_meta_box_field(array(
			'name'        => 'mkd_title_area_height_meta',
			'type'        => 'text',
			'label'       => esc_html__('Height', 'topfit'),
			'description' => esc_html__('Set a height for Title Area', 'topfit'),
			'parent'      => $show_title_area_meta_container,
			'args'        => array(
				'col_width' => 2,
				'suffix'    => 'px'
			)
		));

		topfit_mikado_add_meta_box_field(array(
			'name'          => 'mkd_disable_title_bottom_border_meta',
			'type'          => 'yesno',
			'label'         => esc_html__('Disable Title Bottom Border', 'topfit'),
			'description'   => esc_html__('This option will disable title area bottom border', 'topfit'),
			'parent'        => $show_title_area_meta_container,
			'default_value' => 'no'
		));

		topfit_mikado_add_meta_box_field(array(
			'name'          => 'mkd_title_area_subtitle_meta',
			'type'          => 'text',
			'default_value' => '',
			'label'         => esc_html__('Subtitle Text', 'topfit'),
			'description'   => esc_html__('Enter your subtitle text', 'topfit'),
			'parent'        => $show_title_area_meta_container,
			'args'          => array(
				'col_width' => 6
			)
		));

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_subtitle_color_meta',
				'type'        => 'color',
				'label'       => esc_html__('Subtitle Color', 'topfit'),
				'description' => esc_html__('Choose a color for subtitle text', 'topfit'),
				'parent'      => $show_title_area_meta_container
			)
		);

	}
	add_action('topfit_mikado_meta_boxes_map', 'topfit_mikado_title_meta_box_map');
}