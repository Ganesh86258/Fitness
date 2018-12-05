<?php

if (!function_exists('topfit_mikado_sidearea_options_map')) {

	function topfit_mikado_sidearea_options_map() {

		topfit_mikado_add_admin_page(
			array(
				'slug'  => '_side_area_page',
				'title' => esc_html__('Side Area', 'topfit'),
				'icon'  => 'icon_menu'
			)
		);

		$side_area_panel = topfit_mikado_add_admin_panel(
			array(
				'title' => esc_html__('Side Area', 'topfit'),
				'name'  => 'side_area',
				'page'  => '_side_area_page'
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $side_area_panel,
				'type'          => 'select',
				'name'          => 'side_area_type',
				'default_value' => 'side-menu-slide-with-content',
				'label'         => esc_html__('Side Area Type', 'topfit'),
				'description'   => esc_html__('Choose a type of Side Area', 'topfit'),
				'options'       => array(
					'side-menu-slide-from-right'       => esc_html__('Slide from Right Over Content', 'topfit'),
					'side-menu-slide-with-content'     => esc_html__('Slide from Right With Content', 'topfit'),
					'side-area-uncovered-from-content' => esc_html__('Side Area Uncovered from Content', 'topfit'),
				),
				'args'          => array(
					'dependence' => true,
					'hide'       => array(
						'side-menu-slide-from-right'       => '#mkd_side_area_slide_with_content_container',
						'side-menu-slide-with-content'     => '#mkd_side_area_width_container',
						'side-area-uncovered-from-content' => '#mkd_side_area_width_container, #mkd_side_area_slide_with_content_container'
					),
					'show'       => array(
						'side-menu-slide-from-right'       => '#mkd_side_area_width_container',
						'side-menu-slide-with-content'     => '#mkd_side_area_slide_with_content_container',
						'side-area-uncovered-from-content' => ''
					)
				)
			)
		);

		$side_area_width_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $side_area_panel,
				'name'            => 'side_area_width_container',
				'hidden_property' => 'side_area_type',
				'hidden_value'    => '',
				'hidden_values'   => array(
					'side-menu-slide-with-content',
					'side-area-uncovered-from-content'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $side_area_width_container,
				'type'          => 'text',
				'name'          => 'side_area_width',
				'default_value' => '',
				'label'         => esc_html__('Side Area Width', 'topfit'),
				'description'   => esc_html__('Enter a width for Side Area (in percentages, enter more than 30)', 'topfit'),
				'args'          => array(
					'col_width' => 3,
					'suffix'    => '%'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $side_area_width_container,
				'type'          => 'color',
				'name'          => 'side_area_content_overlay_color',
				'default_value' => '',
				'label'         => esc_html__('Content Overlay Background Color', 'topfit'),
				'description'   => esc_html__('Choose a background color for a content overlay', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $side_area_width_container,
				'type'          => 'text',
				'name'          => 'side_area_content_overlay_opacity',
				'default_value' => '',
				'label'         => esc_html__('Content Overlay Background Transparency', 'topfit'),
				'description'   => esc_html__('Choose a transparency for the content overlay background color (0 = fully transparent, 1 = opaque)', 'topfit'),
				'args'          => array(
					'col_width' => 3
				)
			)
		);

		$side_area_slide_with_content_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $side_area_panel,
				'name'            => 'side_area_slide_with_content_container',
				'hidden_property' => 'side_area_type',
				'hidden_value'    => '',
				'hidden_values'   => array(
					'side-menu-slide-from-right',
					'side-area-uncovered-from-content'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $side_area_slide_with_content_container,
				'type'          => 'select',
				'name'          => 'side_area_slide_with_content_width',
				'default_value' => 'width-470',
				'label'         => esc_html__('Side Area Width', 'topfit'),
				'description'   => esc_html__('Choose width for Side Area', 'topfit'),
				'options'       => array(
					'width-270' => '270px',
					'width-370' => '370px',
					'width-470' => '470px'
				)
			)
		);

		topfit_mikado_add_admin_field(array(
				'parent'      => $side_area_panel,
				'type'        => 'image',
				'name'        => 'side_area_bakground_image',
				'label'       => esc_html__('Side Area Background Image', 'topfit'),
				'description' => esc_html__('Choose background image for Side Area', 'topfit'),
			)
		);

//init icon pack hide and show array. It will be populated dinamically from collections array
		$side_area_icon_pack_hide_array = array();
		$side_area_icon_pack_show_array = array();

//do we have some collection added in collections array?
		if (is_array(topfit_mikado_icon_collections()->iconCollections) && count(topfit_mikado_icon_collections()->iconCollections)) {
			//get collections params array. It will contain values of 'param' property for each collection
			$side_area_icon_collections_params = topfit_mikado_icon_collections()->getIconCollectionsParams();

			//foreach collection generate hide and show array
			foreach (topfit_mikado_icon_collections()->iconCollections as $dep_collection_key => $dep_collection_object) {
				$side_area_icon_pack_hide_array[$dep_collection_key] = '';

				//we need to include only current collection in show string as it is the only one that needs to show
				$side_area_icon_pack_show_array[$dep_collection_key] = '#mkd_side_area_icon_' . $dep_collection_object->param . '_container';

				//for all collections param generate hide string
				foreach ($side_area_icon_collections_params as $side_area_icon_collections_param) {
					//we don't need to include current one, because it needs to be shown, not hidden
					if ($side_area_icon_collections_param !== $dep_collection_object->param) {
						$side_area_icon_pack_hide_array[$dep_collection_key] .= '#mkd_side_area_icon_' . $side_area_icon_collections_param . '_container,';
					}
				}

				//remove remaining ',' character
				$side_area_icon_pack_hide_array[$dep_collection_key] = rtrim($side_area_icon_pack_hide_array[$dep_collection_key], ',');
			}

		}

		$side_area_icon_style_group = topfit_mikado_add_admin_group(
			array(
				'parent'      => $side_area_panel,
				'name'        => 'side_area_icon_style_group',
				'title'       => esc_html__('Side Area Icon Style', 'topfit'),
				'description' => esc_html__('Define styles for Side Area icon', 'topfit'),
			)
		);

		$side_area_icon_style_row1 = topfit_mikado_add_admin_row(
			array(
				'parent' => $side_area_icon_style_group,
				'name'   => 'side_area_icon_style_row1'
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $side_area_icon_style_row1,
				'type'          => 'colorsimple',
				'name'          => 'side_area_icon_color',
				'default_value' => '',
				'label'         => esc_html__('Color', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $side_area_icon_style_row1,
				'type'          => 'colorsimple',
				'name'          => 'side_area_icon_hover_color',
				'default_value' => '',
				'label'         => esc_html__('Hover Color', 'topfit'),
			)
		);

		$side_area_icon_style_row2 = topfit_mikado_add_admin_row(
			array(
				'parent' => $side_area_icon_style_group,
				'name'   => 'side_area_icon_style_row2',
				'next'   => true
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $side_area_icon_style_row2,
				'type'          => 'colorsimple',
				'name'          => 'side_area_light_icon_color',
				'default_value' => '',
				'label'         => esc_html__('Light Menu Icon Color', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $side_area_icon_style_row2,
				'type'          => 'colorsimple',
				'name'          => 'side_area_light_icon_hover_color',
				'default_value' => '',
				'label'         => esc_html__('Light Menu Icon Hover Color', 'topfit'),
			)
		);

		$side_area_icon_style_row3 = topfit_mikado_add_admin_row(
			array(
				'parent' => $side_area_icon_style_group,
				'name'   => 'side_area_icon_style_row3',
				'next'   => true
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $side_area_icon_style_row3,
				'type'          => 'colorsimple',
				'name'          => 'side_area_dark_icon_color',
				'default_value' => '',
				'label'         => esc_html__('Dark Menu Icon Color', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $side_area_icon_style_row3,
				'type'          => 'colorsimple',
				'name'          => 'side_area_dark_icon_hover_color',
				'default_value' => '',
				'label'         => esc_html__('Dark Menu Icon Hover Color', 'topfit'),
			)
		);

		$icon_spacing_group = topfit_mikado_add_admin_group(
			array(
				'parent'      => $side_area_panel,
				'name'        => 'icon_spacing_group',
				'title'       => esc_html__('Side Area Icon Spacing', 'topfit'),
				'description' => esc_html__('Define padding and margin for side area icon', 'topfit'),
			)
		);

		$icon_spacing_row = topfit_mikado_add_admin_row(
			array(
				'parent' => $icon_spacing_group,
				'name'   => 'icon_spancing_row',
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $icon_spacing_row,
				'type'          => 'textsimple',
				'name'          => 'side_area_icon_padding_left',
				'default_value' => '',
				'label'         => esc_html__('Padding Left', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $icon_spacing_row,
				'type'          => 'textsimple',
				'name'          => 'side_area_icon_padding_right',
				'default_value' => '',
				'label'         => esc_html__('Padding Right', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $icon_spacing_row,
				'type'          => 'textsimple',
				'name'          => 'side_area_icon_margin_left',
				'default_value' => '',
				'label'         => esc_html__('Margin Left', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $icon_spacing_row,
				'type'          => 'textsimple',
				'name'          => 'side_area_icon_margin_right',
				'default_value' => '',
				'label'         => esc_html__('Margin Right', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $side_area_panel,
				'type'          => 'selectblank',
				'name'          => 'side_area_aligment',
				'default_value' => '',
				'label'         => esc_html__('Text Aligment', 'topfit'),
				'description'   => esc_html__('Choose text aligment for side area', 'topfit'),
				'options'       => array(
					'center' => esc_html__('Center', 'topfit'),
					'left'   => esc_html__('Left', 'topfit'),
					'right'  => esc_html__('Right', 'topfit'),
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $side_area_panel,
				'type'          => 'text',
				'name'          => 'side_area_title',
				'default_value' => '',
				'label'         => esc_html__('Side Area Title', 'topfit'),
				'description'   => esc_html__('Enter a title to appear in Side Area', 'topfit'),
				'args'          => array(
					'col_width' => 3,
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $side_area_panel,
				'type'          => 'color',
				'name'          => 'side_area_background_color',
				'default_value' => '',
				'label'         => esc_html__('Background Color', 'topfit'),
				'description'   => esc_html__('Choose a background color for Side Area', 'topfit'),
			)
		);

		$padding_group = topfit_mikado_add_admin_group(
			array(
				'parent'      => $side_area_panel,
				'name'        => 'padding_group',
				'title'       => esc_html__('Padding', 'topfit'),
				'description' => esc_html__('Define padding for Side Area', 'topfit'),
			)
		);

		$padding_row = topfit_mikado_add_admin_row(
			array(
				'parent' => $padding_group,
				'name'   => 'padding_row',
				'next'   => true
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $padding_row,
				'type'          => 'textsimple',
				'name'          => 'side_area_padding_top',
				'default_value' => '',
				'label'         => esc_html__('Top Padding', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $padding_row,
				'type'          => 'textsimple',
				'name'          => 'side_area_padding_right',
				'default_value' => '',
				'label'         => esc_html__('Right Padding', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $padding_row,
				'type'          => 'textsimple',
				'name'          => 'side_area_padding_bottom',
				'default_value' => '',
				'label'         => esc_html__('Bottom Padding', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $padding_row,
				'type'          => 'textsimple',
				'name'          => 'side_area_padding_left',
				'default_value' => '',
				'label'         => esc_html__('Left Padding', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $side_area_panel,
				'type'          => 'select',
				'name'          => 'side_area_close_icon',
				'default_value' => 'light',
				'label'         => esc_html__('Close Icon Style', 'topfit'),
				'description'   => esc_html__('Choose a type of close icon', 'topfit'),
				'options'       => array(
					'light' => esc_html__('Light', 'topfit'),
					'dark'  => esc_html__('Dark', 'topfit'),
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $side_area_panel,
				'type'          => 'text',
				'name'          => 'side_area_close_icon_size',
				'default_value' => '',
				'label'         => esc_html__('Close Icon Size', 'topfit'),
				'description'   => esc_html__('Define close icon size', 'topfit'),
				'args'          => array(
					'col_width' => 3,
					'suffix'    => 'px'
				)
			)
		);

		$title_group = topfit_mikado_add_admin_group(
			array(
				'parent'      => $side_area_panel,
				'name'        => 'title_group',
				'title'       => esc_html__('Title', 'topfit'),
				'description' => esc_html__('Define Style for Side Area title', 'topfit'),
			)
		);

		$title_row_1 = topfit_mikado_add_admin_row(
			array(
				'parent' => $title_group,
				'name'   => 'title_row_1',
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $title_row_1,
				'type'          => 'colorsimple',
				'name'          => 'side_area_title_color',
				'default_value' => '',
				'label'         => esc_html__('Text Color', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $title_row_1,
				'type'          => 'textsimple',
				'name'          => 'side_area_title_fontsize',
				'default_value' => '',
				'label'         => esc_html__('Font Size', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $title_row_1,
				'type'          => 'textsimple',
				'name'          => 'side_area_title_lineheight',
				'default_value' => '',
				'label'         => esc_html__('Line Height', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $title_row_1,
				'type'          => 'selectblanksimple',
				'name'          => 'side_area_title_texttransform',
				'default_value' => '',
				'label'         => esc_html__('Text Transform', 'topfit'),
				'options'       => topfit_mikado_get_text_transform_array()
			)
		);

		$title_row_2 = topfit_mikado_add_admin_row(
			array(
				'parent' => $title_group,
				'name'   => 'title_row_2',
				'next'   => true
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $title_row_2,
				'type'          => 'fontsimple',
				'name'          => 'side_area_title_google_fonts',
				'default_value' => '-1',
				'label'         => esc_html__('Font Family', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $title_row_2,
				'type'          => 'selectblanksimple',
				'name'          => 'side_area_title_fontstyle',
				'default_value' => '',
				'label'         => esc_html__('Font Style', 'topfit'),
				'options'       => topfit_mikado_get_font_style_array()
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $title_row_2,
				'type'          => 'selectblanksimple',
				'name'          => 'side_area_title_fontweight',
				'default_value' => '',
				'label'         => esc_html__('Font Weight', 'topfit'),
				'options'       => topfit_mikado_get_font_weight_array()
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $title_row_2,
				'type'          => 'textsimple',
				'name'          => 'side_area_title_letterspacing',
				'default_value' => '',
				'label'         => esc_html__('Letter Spacing', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);


		$text_group = topfit_mikado_add_admin_group(
			array(
				'parent'      => $side_area_panel,
				'name'        => 'text_group',
				'title'       => esc_html__('Text', 'topfit'),
				'description' => esc_html__('Define Style for Side Area text', 'topfit'),
			)
		);

		$text_row_1 = topfit_mikado_add_admin_row(
			array(
				'parent' => $text_group,
				'name'   => 'text_row_1',
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $text_row_1,
				'type'          => 'colorsimple',
				'name'          => 'side_area_text_color',
				'default_value' => '',
				'label'         => esc_html__('Text Color', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $text_row_1,
				'type'          => 'textsimple',
				'name'          => 'side_area_text_fontsize',
				'default_value' => '',
				'label'         => esc_html__('Font Size', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $text_row_1,
				'type'          => 'textsimple',
				'name'          => 'side_area_text_lineheight',
				'default_value' => '',
				'label'         => esc_html__('Line Height', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $text_row_1,
				'type'          => 'selectblanksimple',
				'name'          => 'side_area_text_texttransform',
				'default_value' => '',
				'label'         => esc_html__('Text Transform', 'topfit'),
				'options'       => topfit_mikado_get_text_transform_array()
			)
		);

		$text_row_2 = topfit_mikado_add_admin_row(
			array(
				'parent' => $text_group,
				'name'   => 'text_row_2',
				'next'   => true
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $text_row_2,
				'type'          => 'fontsimple',
				'name'          => 'side_area_text_google_fonts',
				'default_value' => '-1',
				'label'         => esc_html__('Font Family', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $text_row_2,
				'type'          => 'fontsimple',
				'name'          => 'side_area_text_google_fonts',
				'default_value' => '-1',
				'label'         => esc_html__('Font Family', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $text_row_2,
				'type'          => 'selectblanksimple',
				'name'          => 'side_area_text_fontstyle',
				'default_value' => '',
				'label'         => esc_html__('Font Style', 'topfit'),
				'options'       => topfit_mikado_get_font_style_array()
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $text_row_2,
				'type'          => 'selectblanksimple',
				'name'          => 'side_area_text_fontweight',
				'default_value' => '',
				'label'         => esc_html__('Font Weight', 'topfit'),
				'options'       => topfit_mikado_get_font_weight_array()
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $text_row_2,
				'type'          => 'textsimple',
				'name'          => 'side_area_text_letterspacing',
				'default_value' => '',
				'label'         => esc_html__('Letter Spacing', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		$widget_links_group = topfit_mikado_add_admin_group(
			array(
				'parent'      => $side_area_panel,
				'name'        => 'widget_links_group',
				'title'       => esc_html__('Link Style', 'topfit'),
				'description' => esc_html__('Define styles for Side Area widget links', 'topfit'),
			)
		);

		$widget_links_row_1 = topfit_mikado_add_admin_row(
			array(
				'parent' => $widget_links_group,
				'name'   => 'widget_links_row_1',
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $widget_links_row_1,
				'type'          => 'colorsimple',
				'name'          => 'sidearea_link_color',
				'default_value' => '',
				'label'         => esc_html__('Text Color', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $widget_links_row_1,
				'type'          => 'textsimple',
				'name'          => 'sidearea_link_font_size',
				'default_value' => '',
				'label'         => esc_html__('Font Size', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $widget_links_row_1,
				'type'          => 'textsimple',
				'name'          => 'sidearea_link_line_height',
				'default_value' => '',
				'label'         => esc_html__('Line Height', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $widget_links_row_1,
				'type'          => 'selectblanksimple',
				'name'          => 'sidearea_link_text_transform',
				'default_value' => '',
				'label'         => esc_html__('Text Transform', 'topfit'),
				'options'       => topfit_mikado_get_text_transform_array()
			)
		);

		$widget_links_row_2 = topfit_mikado_add_admin_row(
			array(
				'parent' => $widget_links_group,
				'name'   => 'widget_links_row_2',
				'next'   => true
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $widget_links_row_2,
				'type'          => 'fontsimple',
				'name'          => 'sidearea_link_font_family',
				'default_value' => '-1',
				'label'         => esc_html__('Font Family', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $widget_links_row_2,
				'type'          => 'selectblanksimple',
				'name'          => 'sidearea_link_font_style',
				'default_value' => '',
				'label'         => esc_html__('Font Style', 'topfit'),
				'options'       => topfit_mikado_get_font_style_array()
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $widget_links_row_2,
				'type'          => 'selectblanksimple',
				'name'          => 'sidearea_link_font_weight',
				'default_value' => '',
				'label'         => esc_html__('Font Weight', 'topfit'),
				'options'       => topfit_mikado_get_font_weight_array()
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $widget_links_row_2,
				'type'          => 'textsimple',
				'name'          => 'sidearea_link_letter_spacing',
				'default_value' => '',
				'label'         => esc_html__('Letter Spacing', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		$widget_links_row_3 = topfit_mikado_add_admin_row(
			array(
				'parent' => $widget_links_group,
				'name'   => 'widget_links_row_3',
				'next'   => true
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $widget_links_row_3,
				'type'          => 'colorsimple',
				'name'          => 'sidearea_link_hover_color',
				'default_value' => '',
				'label'         => esc_html__('Hover Color', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $side_area_panel,
				'type'          => 'yesno',
				'name'          => 'side_area_enable_bottom_border',
				'default_value' => 'no',
				'label'         => esc_html__('Border Bottom on Elements', 'topfit'),
				'description'   => esc_html__('Enable border bottom on elements in side area', 'topfit'),
				'args'          => array(
					'dependence'             => true,
					'dependence_hide_on_yes' => '',
					'dependence_show_on_yes' => '#mkd_side_area_bottom_border_container'
				)
			)
		);

		$side_area_bottom_border_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $side_area_panel,
				'name'            => 'side_area_bottom_border_container',
				'hidden_property' => 'side_area_enable_bottom_border',
				'hidden_value'    => 'no'
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $side_area_bottom_border_container,
				'type'          => 'color',
				'name'          => 'side_area_bottom_border_color',
				'default_value' => '',
				'label'         => esc_html__('Border Bottom Color', 'topfit'),
				'description'   => esc_html__('Choose color for border bottom on elements in sidearea', 'topfit'),
			)
		);

	}

	add_action('topfit_mikado_options_map', 'topfit_mikado_sidearea_options_map', 5);

}