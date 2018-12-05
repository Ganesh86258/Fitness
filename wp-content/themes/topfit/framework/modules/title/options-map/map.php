<?php

if (!function_exists('topfit_mikado_title_options_map')) {

	function topfit_mikado_title_options_map() {

		topfit_mikado_add_admin_page(
			array(
				'slug'  => '_title_page',
				'title' => esc_html__('Title', 'topfit'),
				'icon'  => 'icon_archive_alt'
			)
		);

		$panel_title = topfit_mikado_add_admin_panel(
			array(
				'page'  => '_title_page',
				'name'  => 'panel_title',
				'title' => esc_html__('Title Settings', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'show_title_area',
				'type'          => 'yesno',
				'default_value' => 'yes',
				'label'         => esc_html__('Show Title Area', 'topfit'),
				'description'   => esc_html__('This option will enable/disable Title Area', 'topfit'),
				'parent'        => $panel_title,
				'args'          => array(
					"dependence"             => true,
					"dependence_hide_on_yes" => "",
					"dependence_show_on_yes" => "#mkd_show_title_area_container"
				)
			)
		);

		$show_title_area_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $panel_title,
				'name'            => 'show_title_area_container',
				'hidden_property' => 'show_title_area',
				'hidden_value'    => 'no'
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'title_area_type',
				'type'          => 'select',
				'default_value' => 'standard',
				'label'         => esc_html__('Title Area Type', 'topfit'),
				'description'   => esc_html__('Choose title type', 'topfit'),
				'parent'        => $show_title_area_container,
				'options'       => array(
					'standard'   => esc_html__('Standard', 'topfit'),
					'breadcrumb' => esc_html__('Breadcrumb','topfit'),
				),
				'args'          => array(
			"dependence" => true,
			"hide"       => array(
				"standard"   => "",
				"breadcrumb" => "#mkd_title_area_type_container"
			),
			"show"       => array(
				"standard"   => "#mkd_title_area_type_container",
				"breadcrumb" => ""
			)
		)
			)
		);

		$title_area_type_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $show_title_area_container,
				'name'            => 'title_area_type_container',
				'hidden_property' => 'title_area_type',
				'hidden_value'    => '',
				'hidden_values'   => array('breadcrumb'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'title_area_enable_breadcrumbs',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__('Enable Breadcrumbs', 'topfit'),
				'description'   => esc_html__('This option will display Breadcrumbs in Title Area', 'topfit'),
				'parent'        => $title_area_type_container,
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'title_in_grid',
				'type'          => 'yesno',
				'default_value' => 'yes',
				'label'         => esc_html__('Title in Grid', 'topfit'),
				'description'   => esc_html__('Set title content to be in grid', 'topfit'),
				'parent'        => $show_title_area_container
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'title_area_animation',
				'type'          => 'select',
				'default_value' => 'no',
				'label'         => esc_html__('Animations', 'topfit'),
				'description'   => esc_html__('Choose an animation for Title Area', 'topfit'),
				'parent'        => $show_title_area_container,
				'options'       => array(
					'no'         => esc_html__('No Animation', 'topfit'),
					'right-left' => esc_html__('Text right to left', 'topfit'),
					'left-right' => esc_html__('Text left to right', 'topfit'),
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'title_area_vertial_alignment',
				'type'          => 'select',
				'default_value' => 'header_bottom',
				'label'         => esc_html__('Vertical Alignment', 'topfit'),
				'description'   => esc_html__('Specify title vertical alignment', 'topfit'),
				'parent'        => $show_title_area_container,
				'options'       => array(
					'header_bottom' => esc_html__('From Bottom of Header', 'topfit'),
					'window_top'    => esc_html__('From Window Top', 'topfit'),
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'title_area_content_alignment',
				'type'          => 'select',
				'default_value' => 'left',
				'label'         => esc_html__('Horizontal Alignment', 'topfit'),
				'description'   => esc_html__('Specify title horizontal alignment', 'topfit'),
				'parent'        => $show_title_area_container,
				'options'       => array(
					'left'   => esc_html__('Left', 'topfit'),
					'center' => esc_html__('Center', 'topfit'),
					'right'  => esc_html__('Right', 'topfit'),
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'        => 'title_area_background_color',
				'type'        => 'color',
				'label'       => esc_html__('Background Color', 'topfit'),
				'description' => esc_html__('Choose a background color for Title Area', 'topfit'),
				'parent'      => $show_title_area_container
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'        => 'title_area_background_image',
				'type'        => 'image',
				'label'       => esc_html__('Background Image', 'topfit'),
				'description' => esc_html__('Choose an Image for Title Area', 'topfit'),
				'parent'      => $show_title_area_container
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'title_area_background_image_responsive',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__('Background Responsive Image', 'topfit'),
				'description'   => esc_html__('Enabling this option will make Title background image responsive', 'topfit'),
				'parent'        => $show_title_area_container,
				'args'          => array(
					"dependence"             => true,
					"dependence_hide_on_yes" => "#mkd_title_area_background_image_responsive_container",
					"dependence_show_on_yes" => ""
				)
			)
		);

		$title_area_background_image_responsive_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $show_title_area_container,
				'name'            => 'title_area_background_image_responsive_container',
				'hidden_property' => 'title_area_background_image_responsive',
				'hidden_value'    => 'yes'
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'title_area_background_image_parallax',
				'type'          => 'select',
				'default_value' => 'no',
				'label'         => esc_html__('Background Image in Parallax', 'topfit'),
				'description'   => esc_html__('Enabling this option will make Title background image parallax', 'topfit'),
				'parent'        => $title_area_background_image_responsive_container,
				'options'       => array(
					'no'       => esc_html__('No', 'topfit'),
					'yes'      => esc_html__('Yes', 'topfit'),
					'yes_zoom' => esc_html__('Yes, with zoom out', 'topfit'),
				)
			)
		);

		topfit_mikado_add_admin_field(array(
			'name'        => 'title_area_height',
			'type'        => 'text',
			'label'       => esc_html__('Height', 'topfit'),
			'description' => esc_html__('Set a height for Title Area', 'topfit'),
			'parent'      => $title_area_background_image_responsive_container,
			'args'        => array(
				'col_width' => 2,
				'suffix'    => 'px'
			)
		));


		$panel_typography = topfit_mikado_add_admin_panel(
			array(
				'page'  => '_title_page',
				'name'  => 'panel_title_typography',
				'title' => esc_html__('Typography', 'topfit'),
			)
		);

		$group_page_title_styles = topfit_mikado_add_admin_group(array(
			'name'        => 'group_page_title_styles',
			'title'       => esc_html__('Title', 'topfit'),
			'description' => esc_html__('Define styles for page title', 'topfit'),
			'parent'      => $panel_typography
		));

		$row_page_title_styles_1 = topfit_mikado_add_admin_row(array(
			'name'   => 'row_page_title_styles_1',
			'parent' => $group_page_title_styles
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'colorsimple',
			'name'          => 'page_title_color',
			'default_value' => '',
			'label'         => esc_html__('Text Color', 'topfit'),
			'parent'        => $row_page_title_styles_1
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'textsimple',
			'name'          => 'page_title_fontsize',
			'default_value' => '',
			'label'         => esc_html__('Font Size', 'topfit'),
			'args'          => array(
				'suffix' => 'px'
			),
			'parent'        => $row_page_title_styles_1
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'textsimple',
			'name'          => 'page_title_lineheight',
			'default_value' => '',
			'label'         => esc_html__('Line Height', 'topfit'),
			'args'          => array(
				'suffix' => 'px'
			),
			'parent'        => $row_page_title_styles_1
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'selectblanksimple',
			'name'          => 'page_title_texttransform',
			'default_value' => '',
			'label'         => esc_html__('Text Transform', 'topfit'),
			'options'       => topfit_mikado_get_text_transform_array(),
			'parent'        => $row_page_title_styles_1
		));

		$row_page_title_styles_2 = topfit_mikado_add_admin_row(array(
			'name'   => 'row_page_title_styles_2',
			'parent' => $group_page_title_styles,
			'next'   => true
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'fontsimple',
			'name'          => 'page_title_google_fonts',
			'default_value' => '-1',
			'label'         => esc_html__('Font Family', 'topfit'),
			'parent'        => $row_page_title_styles_2
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'selectblanksimple',
			'name'          => 'page_title_fontstyle',
			'default_value' => '',
			'label'         => esc_html__('Font Style', 'topfit'),
			'options'       => topfit_mikado_get_font_style_array(),
			'parent'        => $row_page_title_styles_2
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'selectblanksimple',
			'name'          => 'page_title_fontweight',
			'default_value' => '',
			'label'         => esc_html__('Font Weight', 'topfit'),
			'options'       => topfit_mikado_get_font_weight_array(),
			'parent'        => $row_page_title_styles_2
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'textsimple',
			'name'          => 'page_title_letter_spacing',
			'default_value' => '',
			'label'         => esc_html__('Letter Spacing', 'topfit'),
			'args'          => array(
				'suffix' => 'px'
			),
			'parent'        => $row_page_title_styles_2
		));

		$group_page_subtitle_styles = topfit_mikado_add_admin_group(array(
			'name'        => 'group_page_subtitle_styles',
			'title'       => esc_html__('Subtitle', 'topfit'),
			'description' => esc_html__('Define styles for page subtitle', 'topfit'),
			'parent'      => $panel_typography
		));

		$row_page_subtitle_styles_1 = topfit_mikado_add_admin_row(array(
			'name'   => 'row_page_subtitle_styles_1',
			'parent' => $group_page_subtitle_styles
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'colorsimple',
			'name'          => 'page_subtitle_color',
			'default_value' => '',
			'label'         => esc_html__('Text Color', 'topfit'),
			'parent'        => $row_page_subtitle_styles_1
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'textsimple',
			'name'          => 'page_subtitle_fontsize',
			'default_value' => '',
			'label'         => esc_html__('Font Size', 'topfit'),
			'args'          => array(
				'suffix' => 'px'
			),
			'parent'        => $row_page_subtitle_styles_1
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'textsimple',
			'name'          => 'page_subtitle_lineheight',
			'default_value' => '',
			'label'         => esc_html__('Line Height', 'topfit'),
			'args'          => array(
				'suffix' => 'px'
			),
			'parent'        => $row_page_subtitle_styles_1
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'selectblanksimple',
			'name'          => 'page_subtitle_texttransform',
			'default_value' => '',
			'label'         => esc_html__('Text Transform', 'topfit'),
			'options'       => topfit_mikado_get_text_transform_array(),
			'parent'        => $row_page_subtitle_styles_1
		));

		$row_page_subtitle_styles_2 = topfit_mikado_add_admin_row(array(
			'name'   => 'row_page_subtitle_styles_2',
			'parent' => $group_page_subtitle_styles,
			'next'   => true
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'fontsimple',
			'name'          => 'page_subtitle_google_fonts',
			'default_value' => '-1',
			'label'         => esc_html__('Font Family', 'topfit'),
			'parent'        => $row_page_subtitle_styles_2
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'selectblanksimple',
			'name'          => 'page_subtitle_fontstyle',
			'default_value' => '',
			'label'         => esc_html__('Font Style', 'topfit'),
			'options'       => topfit_mikado_get_font_style_array(),
			'parent'        => $row_page_subtitle_styles_2
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'selectblanksimple',
			'name'          => 'page_subtitle_fontweight',
			'default_value' => '',
			'label'         => esc_html__('Font Weight', 'topfit'),
			'options'       => topfit_mikado_get_font_weight_array(),
			'parent'        => $row_page_subtitle_styles_2
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'textsimple',
			'name'          => 'page_subtitle_letter_spacing',
			'default_value' => '',
			'label'         => esc_html__('Letter Spacing', 'topfit'),
			'args'          => array(
				'suffix' => 'px'
			),
			'parent'        => $row_page_subtitle_styles_2
		));

		$group_page_breadcrumbs_styles = topfit_mikado_add_admin_group(array(
			'name'        => 'group_page_breadcrumbs_styles',
			'title'       => esc_html__('Breadcrumbs', 'topfit'),
			'description' => esc_html__('Define styles for page breadcrumbs', 'topfit'),
			'parent'      => $panel_typography
		));

		$row_page_breadcrumbs_styles_1 = topfit_mikado_add_admin_row(array(
			'name'   => 'row_page_breadcrumbs_styles_1',
			'parent' => $group_page_breadcrumbs_styles
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'colorsimple',
			'name'          => 'page_breadcrumb_color',
			'default_value' => '',
			'label'         => esc_html__('Text Color', 'topfit'),
			'parent'        => $row_page_breadcrumbs_styles_1
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'textsimple',
			'name'          => 'page_breadcrumb_fontsize',
			'default_value' => '',
			'label'         => esc_html__('Font Size', 'topfit'),
			'args'          => array(
				'suffix' => 'px'
			),
			'parent'        => $row_page_breadcrumbs_styles_1
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'textsimple',
			'name'          => 'page_breadcrumb_lineheight',
			'default_value' => '',
			'label'         => esc_html__('Line Height', 'topfit'),
			'args'          => array(
				'suffix' => 'px'
			),
			'parent'        => $row_page_breadcrumbs_styles_1
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'selectblanksimple',
			'name'          => 'page_breadcrumb_texttransform',
			'default_value' => '',
			'label'         => esc_html__('Text Transform', 'topfit'),
			'options'       => topfit_mikado_get_text_transform_array(),
			'parent'        => $row_page_breadcrumbs_styles_1
		));

		$row_page_breadcrumbs_styles_2 = topfit_mikado_add_admin_row(array(
			'name'   => 'row_page_breadcrumbs_styles_2',
			'parent' => $group_page_breadcrumbs_styles,
			'next'   => true
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'fontsimple',
			'name'          => 'page_breadcrumb_google_fonts',
			'default_value' => '-1',
			'label'         => esc_html__('Font Family', 'topfit'),
			'parent'        => $row_page_breadcrumbs_styles_2
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'selectblanksimple',
			'name'          => 'page_breadcrumb_fontstyle',
			'default_value' => '',
			'label'         => esc_html__('Font Style', 'topfit'),
			'options'       => topfit_mikado_get_font_style_array(),
			'parent'        => $row_page_breadcrumbs_styles_2
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'selectblanksimple',
			'name'          => 'page_breadcrumb_fontweight',
			'default_value' => '',
			'label'         => esc_html__('Font Weight', 'topfit'),
			'options'       => topfit_mikado_get_font_weight_array(),
			'parent'        => $row_page_breadcrumbs_styles_2
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'textsimple',
			'name'          => 'page_breadcrumb_letter_spacing',
			'default_value' => '',
			'label'         => esc_html__('Letter Spacing', 'topfit'),
			'args'          => array(
				'suffix' => 'px'
			),
			'parent'        => $row_page_breadcrumbs_styles_2
		));

		$row_page_breadcrumbs_styles_3 = topfit_mikado_add_admin_row(array(
			'name'   => 'row_page_breadcrumbs_styles_3',
			'parent' => $group_page_breadcrumbs_styles,
			'next'   => true
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'colorsimple',
			'name'          => 'page_breadcrumb_hovercolor',
			'default_value' => '',
			'label'         => esc_html__('Hover/Active Color', 'topfit'),
			'parent'        => $row_page_breadcrumbs_styles_3
		));

	}

	add_action('topfit_mikado_options_map', 'topfit_mikado_title_options_map', 7);

}