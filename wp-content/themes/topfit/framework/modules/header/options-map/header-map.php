<?php

if (!function_exists('topfit_mikado_header_options_map')) {

	function topfit_mikado_header_options_map() {

		topfit_mikado_add_admin_page(
			array(
				'slug'  => '_header_page',
				'title' => esc_html__('Header', 'topfit'),
				'icon'  => 'icon_folder-open_alt',
			)
		);

		$panel_header = topfit_mikado_add_admin_panel(
			array(
				'page'  => '_header_page',
				'name'  => 'panel_header',
				'title' => esc_html__('Header', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header,
				'type'          => 'radiogroup',
				'name'          => 'header_type',
				'default_value' => 'header-standard',
				'label'         => esc_html__('Choose Header Type', 'topfit'),
				'description'   => esc_html__('Select the type of header you would like to use', 'topfit'),
				'options'       => array(
					'header-standard'          => array(
						'image' => MIKADO_FRAMEWORK_ROOT . '/admin/assets/img/header-standard.png',
						'label' => esc_html__('Standard', 'topfit')
					),
					'header-minimal'           => array(
						'image' => MIKADO_FRAMEWORK_ROOT . '/admin/assets/img/header-minimal.png',
						'label' => esc_html__('Minimal', 'topfit')
					),
					'header-divided'           => array(
						'image' => MIKADO_FRAMEWORK_ROOT . '/admin/assets/img/header-divided.png',
						'label' => esc_html__('Divided', 'topfit')
					),
					'header-centered'          => array(
						'image' => MIKADO_FRAMEWORK_ROOT . '/admin/assets/img/header-centered.png',
						'label' => esc_html__('Centered', 'topfit')
					),
					'header-vertical'          => array(
						'image' => MIKADO_FRAMEWORK_ROOT . '/admin/assets/img/header-vertical.png',
						'label' => esc_html__('Vertical', 'topfit')
					)
				),
				'args'          => array(
					'use_images'  => true,
					'hide_labels' => true,
					'dependence'  => true,
					'show'        => array(
						'header-standard'          => '#mkd_panel_header_standard,#mkd_header_behaviour,#mkd_panel_sticky_header,#mkd_panel_main_menu',
						'header-minimal'           => '#mkd_panel_header_minimal,#mkd_header_behaviour,#mkd_panel_fullscreen_menu,#mkd_panel_sticky_header',
						'header-divided'           => '#mkd_panel_header_divided,#mkd_header_behaviour,#mkd_panel_sticky_header,#mkd_panel_main_menu',
						'header-centered'          => '#mkd_panel_header_centered,#mkd_header_behaviour,#mkd_panel_sticky_header,#mkd_panel_main_menu',
						'header-vertical'          => '#mkd_panel_header_vertical,#mkd_panel_vertical_main_menu',
					),
					'hide'        => array(
						'header-standard'          => '#mkd_panel_header_vertical,#mkd_panel_vertical_main_menu,#mkd_panel_header_minimal,#mkd_panel_header_centered,#mkd_panel_fullscreen_menu,#mkd_panel_fixed_header,#mkd_panel_header_divided',
						'header-minimal'           => '#mkd_panel_header_standard,#mkd_panel_main_menu,#mkd_panel_header_vertical,#mkd_panel_fixed_header,#mkd_panel_header_divided,#mkd_panel_header_centered',
						'header-divided'           => '#mkd_panel_header_standard,#mkd_panel_header_minimal,#mkd_panel_header_centered,#mkd_panel_header_vertical,#mkd_panel_vertical_main_menu,#mkd_panel_fullscreen_menu,#mkd_panel_fixed_header',
						'header-centered'          => '#mkd_panel_header_standard,#mkd_panel_header_minimal,#mkd_panel_header_divided,#mkd_panel_header_vertical,#mkd_panel_vertical_main_menu,#mkd_panel_fullscreen_menu,#mkd_panel_fixed_header',
						'header-vertical'          => '#mkd_panel_header_standard,#mkd_header_behaviour,#mkd_panel_fixed_header,#mkd_panel_sticky_header,#mkd_panel_main_menu,#mkd_panel_header_minimal,#mkd_panel_header_centered,#mkd_panel_fullscreen_menu,#mkd_panel_header_divided',
					)
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'          => $panel_header,
				'type'            => 'select',
				'name'            => 'header_behaviour',
				'default_value'   => 'sticky-header-on-scroll-up',
				'label'           => esc_html__('Choose Header behaviour', 'topfit'),
				'description'     => esc_html__('Select the behaviour of header when you scroll down to page', 'topfit'),
				'options'         => array(
					'no-behavior'                     => esc_html__('No Behavior', 'topfit'),
					'sticky-header-on-scroll-up'      => esc_html__('Sticky on scrol up', 'topfit'),
					'sticky-header-on-scroll-down-up' => esc_html__('Sticky on scrol up/down', 'topfit'),
					'fixed-on-scroll'                 => esc_html__('Fixed on scroll', 'topfit')
				),
				'hidden_property' => 'header_type',
				'hidden_value'    => '',
				'hidden_values'   => array('header-vertical'),
				'args'            => array(
					'dependence' => true,
					'show'       => array(
						'sticky-header-on-scroll-up'      => '#mkd_panel_sticky_header',
						'sticky-header-on-scroll-down-up' => '#mkd_panel_sticky_header',
						'fixed-on-scroll'                 => '',
					),
					'hide'       => array(
						'sticky-header-on-scroll-up'      => '#mkd_panel_fixed_header',
						'sticky-header-on-scroll-down-up' => '#mkd_panel_fixed_header',
						'no-behavior'                     => '#mkd_panel_fixed_header, #mkd_panel_fixed_header, #mkd_panel_sticky_header',
						'fixed-on-scroll'                 => '#mkd_panel_sticky_header',
					)
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'top_line',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__('Top Line', 'topfit'),
				'description'   => esc_html__('Enabling this option will show top line above header', 'topfit'),
				'parent'        => $panel_header,
				'args'          => array(
					"dependence"             => true,
					"dependence_hide_on_yes" => "",
					"dependence_show_on_yes" => "#mkd_top_line_container"
				)
			)
		);

		$top_line_container = topfit_mikado_add_admin_container(array(
			'name'            => 'top_line_container',
			'parent'          => $panel_header,
			'hidden_property' => 'top_line',
			'hidden_value'    => 'no'
		));

		$group_top_line_colors = topfit_mikado_add_admin_group(array(
			'name'        => 'group_top_colors',
			'title'       => esc_html__('Top Line Colors', 'topfit'),
			'description' => esc_html__('Define colors for top line (not all of them are mandatory)', 'topfit'),
			'parent'      => $top_line_container
		));

		topfit_mikado_add_admin_field(array(
			'name'   => 'top_line_color_1',
			'type'   => 'colorsimple',
			'label'  => esc_html__('Color 1', 'topfit'),
			'parent' => $group_top_line_colors
		));

		topfit_mikado_add_admin_field(array(
			'name'   => 'top_line_color_2',
			'type'   => 'colorsimple',
			'label'  => esc_html__('Color 2', 'topfit'),
			'parent' => $group_top_line_colors
		));

		topfit_mikado_add_admin_field(array(
			'name'   => 'top_line_color_3',
			'type'   => 'colorsimple',
			'label'  => esc_html__('Color 3', 'topfit'),
			'parent' => $group_top_line_colors
		));

		topfit_mikado_add_admin_field(array(
			'name'   => 'top_line_color_4',
			'type'   => 'colorsimple',
			'label'  => esc_html__('Color 4', 'topfit'),
			'parent' => $group_top_line_colors
		));

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'top_bar',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__('Top Bar', 'topfit'),
				'description'   => esc_html__('Enabling this option will show top bar area', 'topfit'),
				'parent'        => $panel_header,
				'args'          => array(
					"dependence"             => true,
					"dependence_hide_on_yes" => "",
					"dependence_show_on_yes" => "#mkd_top_bar_container"
				)
			)
		);

		$top_bar_container = topfit_mikado_add_admin_container(array(
			'name'            => 'top_bar_container',
			'parent'          => $panel_header,
			'hidden_property' => 'top_bar',
			'hidden_value'    => 'no'
		));

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $top_bar_container,
				'type'          => 'select',
				'name'          => 'top_bar_layout',
				'default_value' => 'three-columns',
				'label'         => esc_html__('Choose top bar layout', 'topfit'),
				'description'   => esc_html__('Select the layout for top bar', 'topfit'),
				'options'       => array(
					'two-columns'   => esc_html__('Two columns', 'topfit'),
					'three-columns' => esc_html__('Three columns', 'topfit')
				),
				'args'          => array(
					'dependence' => true,
					'hide'       => array(
						'two-columns'   => '#mkd_top_bar_layout_container',
						'three-columns' => '#mkd_top_bar_two_columns_layout_container'
					),
					'show'       => array(
						'two-columns'   => '#mkd_top_bar_two_columns_layout_container',
						'three-columns' => '#mkd_top_bar_layout_container'
					)
				)
			)
		);

		$top_bar_layout_container = topfit_mikado_add_admin_container(array(
			'name'            => 'top_bar_layout_container',
			'parent'          => $top_bar_container,
			'hidden_property' => 'top_bar_layout',
			'hidden_value'    => '',
			'hidden_values'   => array('two-columns'),
		));

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $top_bar_layout_container,
				'type'          => 'select',
				'name'          => 'top_bar_column_widths',
				'default_value' => '30-30-30',
				'label'         => esc_html__('Choose column widths', 'topfit'),
				'description'   => '',
				'options'       => array(
					'30-30-30' => '33% - 33% - 33%',
					'25-50-25' => '25% - 50% - 25%'
				)
			)
		);

		$top_bar_two_columns_layout = topfit_mikado_add_admin_container(array(
			'name'            => 'top_bar_two_columns_layout_container',
			'parent'          => $top_bar_container,
			'hidden_property' => 'top_bar_layout',
			'hidden_value'    => '',
			'hidden_values'   => array('three-columns'),
		));

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $top_bar_two_columns_layout,
				'type'          => 'select',
				'name'          => 'top_bar_two_column_widths',
				'default_value' => '50-50',
				'label'         => esc_html__('Choose column widths', 'topfit'),
				'description'   => '',
				'options'       => array(
					'50-50' => '50% - 50%',
					'33-66' => '33% - 66%',
					'66-33' => '66% - 33%'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'top_bar_in_grid',
				'type'          => 'yesno',
				'default_value' => 'yes',
				'label'         => esc_html__('Top Bar in grid', 'topfit'),
				'description'   => esc_html__('Set top bar content to be in grid', 'topfit'),
				'parent'        => $top_bar_container,
				'args'          => array(
					"dependence"             => true,
					"dependence_hide_on_yes" => "",
					"dependence_show_on_yes" => "#mkd_top_bar_in_grid_container"
				)
			)
		);

		$top_bar_in_grid_container = topfit_mikado_add_admin_container(array(
			'name'            => 'top_bar_in_grid_container',
			'parent'          => $top_bar_container,
			'hidden_property' => 'top_bar_in_grid',
			'hidden_value'    => 'no'
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'top_bar_grid_background_color',
			'type'        => 'color',
			'label'       => esc_html__('Grid Background Color', 'topfit'),
			'description' => esc_html__('Set grid background color for top bar', 'topfit'),
			'parent'      => $top_bar_in_grid_container
		));


		topfit_mikado_add_admin_field(array(
			'name'        => 'top_bar_grid_background_transparency',
			'type'        => 'text',
			'label'       => esc_html__('Grid Background Transparency', 'topfit'),
			'description' => esc_html__('Set grid background transparency for top bar', 'topfit'),
			'parent'      => $top_bar_in_grid_container,
			'args'        => array('col_width' => 3)
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'top_bar_background_color',
			'type'        => 'color',
			'label'       => esc_html__('Background Color', 'topfit'),
			'description' => esc_html__('Set background color for top bar', 'topfit'),
			'parent'      => $top_bar_container
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'top_bar_background_transparency',
			'type'        => 'text',
			'label'       => esc_html__('Background Transparency', 'topfit'),
			'description' => esc_html__('Set background transparency for top bar', 'topfit'),
			'parent'      => $top_bar_container,
			'args'        => array('col_width' => 3)
		));

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'top_bar_border',
				'type'          => 'yesno',
				'default_value' => 'yes',
				'label'         => esc_html__('Top Bar Border', 'topfit'),
				'description'   => esc_html__('Set top bar border', 'topfit'),
				'parent'        => $top_bar_container,
				'args'          => array(
					"dependence"             => true,
					"dependence_hide_on_yes" => "",
					"dependence_show_on_yes" => "#mkd_top_bar_border_container"
				)
			)
		);

		$top_bar_border_container = topfit_mikado_add_admin_container(array(
			'name'            => 'top_bar_border_container',
			'parent'          => $top_bar_container,
			'hidden_property' => 'top_bar_border',
			'hidden_value'    => 'no'
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'top_bar_border_color',
			'type'        => 'color',
			'label'       => esc_html__('Top Bar Border', 'topfit'),
			'description' => esc_html__('Set border color for top bar', 'topfit'),
			'parent'      => $top_bar_border_container
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'top_bar_height',
			'type'        => 'text',
			'label'       => esc_html__('Top bar height', 'topfit'),
			'description' => esc_html__('Enter top bar height (Default is 37px)', 'topfit'),
			'parent'      => $top_bar_container,
			'args'        => array(
				'col_width' => 2,
				'suffix'    => 'px'
			)
		));

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header,
				'type'          => 'select',
				'name'          => 'header_style',
				'default_value' => '',
				'label'         => esc_html__('Header Skin', 'topfit'),
				'description'   => esc_html__('Choose a header style to make header elements (logo, main menu, side menu button) in that predefined style', 'topfit'),
				'options'       => array(
					''             => '',
					'light-header' => esc_html__('Light', 'topfit'),
					'dark-header'  => esc_html__('Dark', 'topfit')
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header,
				'type'          => 'yesno',
				'name'          => 'enable_header_style_on_scroll',
				'default_value' => 'no',
				'label'         => esc_html__('Enable Header Style on Scroll', 'topfit'),
				'description'   => esc_html__('Enabling this option, header will change style depending on row settings for dark/light style', 'topfit'),
			)
		);

		$panel_header_standard = topfit_mikado_add_admin_panel(
			array(
				'page'            => '_header_page',
				'name'            => 'panel_header_standard',
				'title'           => esc_html__('Header Standard', 'topfit'),
				'hidden_property' => 'header_type',
				'hidden_value'    => '',
				'hidden_values'   => array(
					'header-vertical',
					'header-minimal',
					'header-centered',
					'header-divided',
				)
			)
		);

		topfit_mikado_add_admin_section_title(
			array(
				'parent' => $panel_header_standard,
				'name'   => 'menu_area_title',
				'title'  => esc_html__('Menu Area', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_standard,
				'type'          => 'yesno',
				'name'          => 'menu_area_in_grid_header_standard',
				'default_value' => 'yes',
				'label'         => esc_html__('Header In Grid', 'topfit'),
				'description'   => esc_html__('Set header content to be in grid', 'topfit'),
				'args'          => array(
					'dependence'             => true,
					'dependence_hide_on_yes' => '',
					'dependence_show_on_yes' => '#mkd_menu_area_in_grid_header_standard_container'
				)
			)
		);

		$menu_area_in_grid_header_standard_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $panel_header_standard,
				'name'            => 'menu_area_in_grid_header_standard_container',
				'hidden_property' => 'menu_area_in_grid_header_standard',
				'hidden_value'    => 'no'
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $menu_area_in_grid_header_standard_container,
				'type'          => 'color',
				'name'          => 'menu_area_grid_background_color_header_standard',
				'default_value' => '',
				'label'         => esc_html__('Grid Background Color', 'topfit'),
				'description'   => esc_html__('Set grid background color for header area', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $menu_area_in_grid_header_standard_container,
				'type'          => 'text',
				'name'          => 'menu_area_grid_background_transparency_header_standard',
				'default_value' => '',
				'label'         => esc_html__('Grid Background Transparency', 'topfit'),
				'description'   => esc_html__('Set grid background transparency for header', 'topfit'),
				'args'          => array(
					'col_width' => 3
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $menu_area_in_grid_header_standard_container,
				'type'          => 'yesno',
				'name'          => 'menu_area_in_grid_shadow_header_standard',
				'default_value' => 'no',
				'label'         => esc_html__('Grid Area Shadow', 'topfit'),
				'description'   => esc_html__('Set shadow on grid area', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_standard,
				'type'          => 'color',
				'name'          => 'menu_area_background_color_header_standard',
				'default_value' => '',
				'label'         => esc_html__('Background color', 'topfit'),
				'description'   => esc_html__('Set background color for header', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_standard,
				'type'          => 'text',
				'name'          => 'menu_area_background_transparency_header_standard',
				'default_value' => '',
				'label'         => esc_html__('Background transparency', 'topfit'),
				'description'   => esc_html__('Set background transparency for header', 'topfit'),
				'args'          => array(
					'col_width' => 3
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_standard,
				'type'          => 'yesno',
				'name'          => 'menu_area_shadow_header_standard',
				'default_value' => 'yes',
				'label'         => esc_html__('Header Area Shadow', 'topfit'),
				'description'   => esc_html__('Set shadow on header area', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_standard,
				'type'          => 'text',
				'name'          => 'menu_area_height_header_standard',
				'default_value' => '',
				'label'         => esc_html__('Height', 'topfit'),
				'description'   => esc_html__('Enter header height (default is 98px)', 'topfit'),
				'args'          => array(
					'col_width' => 3,
					'suffix'    => 'px'
				)
			)
		);

		$panel_header_minimal = topfit_mikado_add_admin_panel(
			array(
				'page'            => '_header_page',
				'name'            => 'panel_header_minimal',
				'title'           => esc_html__('Header Minimal', 'topfit'),
				'hidden_property' => 'header_type',
				'hidden_value'    => '',
				'hidden_values'   => array(
					'header-vertical',
					'header-standard',
					'header-centered',
					'header-divided',
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_minimal,
				'type'          => 'yesno',
				'name'          => 'menu_area_in_grid_header_minimal',
				'default_value' => 'no',
				'label'         => esc_html__('Header In Grid', 'topfit'),
				'description'   => esc_html__('Set header content to be in grid', 'topfit'),
				'args'          => array(
					'dependence'             => true,
					'dependence_hide_on_yes' => '',
					'dependence_show_on_yes' => '#mkd_menu_area_in_grid_header_minimal_container'
				)
			)
		);

		$menu_area_in_grid_header_minimal_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $panel_header_minimal,
				'name'            => 'menu_area_in_grid_header_minimal_container',
				'hidden_property' => 'menu_area_in_grid_header_minimal',
				'hidden_value'    => 'no'
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $menu_area_in_grid_header_minimal_container,
				'type'          => 'color',
				'name'          => 'menu_area_grid_background_color_header_minimal',
				'default_value' => '',
				'label'         => esc_html__('Grid Background Color', 'topfit'),
				'description'   => esc_html__('Set grid background color for header area', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $menu_area_in_grid_header_minimal_container,
				'type'          => 'text',
				'name'          => 'menu_area_grid_background_transparency_header_minimal',
				'default_value' => '',
				'label'         => esc_html__('Grid Background Transparency', 'topfit'),
				'description'   => esc_html__('Set grid background transparency for header', 'topfit'),
				'args'          => array(
					'col_width' => 3
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $menu_area_in_grid_header_minimal_container,
				'type'          => 'yesno',
				'name'          => 'menu_area_in_grid_shadow_header_minimal',
				'default_value' => 'no',
				'label'         => esc_html__('Grid Area Shadow', 'topfit'),
				'description'   => esc_html__('Set shadow on grid area', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_minimal,
				'type'          => 'color',
				'name'          => 'menu_area_background_color_header_minimal',
				'default_value' => '',
				'label'         => esc_html__('Background color', 'topfit'),
				'description'   => esc_html__('Set background color for header', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_minimal,
				'type'          => 'text',
				'name'          => 'menu_area_background_transparency_header_minimal',
				'default_value' => '',
				'label'         => esc_html__('Background transparency', 'topfit'),
				'description'   => esc_html__('Set background transparency for header', 'topfit'),
				'args'          => array(
					'col_width' => 3
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_minimal,
				'type'          => 'yesno',
				'name'          => 'menu_area_shadow_header_minimal',
				'default_value' => 'yes',
				'label'         => esc_html__('Header Area Shadow', 'topfit'),
				'description'   => esc_html__('Set shadow on header area', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_minimal,
				'type'          => 'text',
				'name'          => 'menu_area_height_header_minimal',
				'default_value' => '',
				'label'         => esc_html__('Height', 'topfit'),
				'description'   => esc_html__('Enter header height (default is 98px)', 'topfit'),
				'args'          => array(
					'col_width' => 3,
					'suffix'    => 'px'
				)
			)
		);

		/***************** Divided Header Layout *******************/

		$panel_header_divided = topfit_mikado_add_admin_panel(
			array(
				'page'            => '_header_page',
				'name'            => 'panel_header_divided',
				'title'           => esc_html__('Header Divided', 'topfit'),
				'hidden_property' => 'header_type',
				'hidden_value'    => '',
				'hidden_values'   => array(
					'header-standard',
					'header-minimal',
					'header-centered',
					'header-vertical',
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_divided,
				'type'          => 'yesno',
				'name'          => 'menu_area_in_grid_header_divided',
				'default_value' => 'no',
				'label'         => esc_html__('Header In Grid', 'topfit'),
				'description'   => esc_html__('Set header content to be in grid', 'topfit'),
				'args'          => array(
					'dependence'             => true,
					'dependence_hide_on_yes' => '',
					'dependence_show_on_yes' => '#mkd_menu_area_in_grid_header_divided_container'
				)
			)
		);

		$menu_area_in_grid_header_divided_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $panel_header_divided,
				'name'            => 'menu_area_in_grid_header_divided_container',
				'hidden_property' => 'menu_area_in_grid_header_divided',
				'hidden_value'    => 'no'
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $menu_area_in_grid_header_divided_container,
				'type'          => 'color',
				'name'          => 'menu_area_grid_background_color_header_divided',
				'default_value' => '',
				'label'         => esc_html__('Grid Background Color', 'topfit'),
				'description'   => esc_html__('Set grid background color for header area', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $menu_area_in_grid_header_divided_container,
				'type'          => 'text',
				'name'          => 'menu_area_grid_background_transparency_header_divided',
				'default_value' => '',
				'label'         => esc_html__('Grid Background Transparency', 'topfit'),
				'description'   => esc_html__('Set grid background transparency for header', 'topfit'),
				'args'          => array(
					'col_width' => 3
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $menu_area_in_grid_header_divided_container,
				'type'          => 'yesno',
				'name'          => 'menu_area_in_grid_shadow_header_divided',
				'default_value' => 'no',
				'label'         => esc_html__('Grid Area Shadow', 'topfit'),
				'description'   => esc_html__('Set shadow on grid area', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_divided,
				'type'          => 'color',
				'name'          => 'menu_area_background_color_header_divided',
				'default_value' => '',
				'label'         => esc_html__('Background Color', 'topfit'),
				'description'   => esc_html__('Set background color for header', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_divided,
				'type'          => 'text',
				'name'          => 'menu_area_background_transparency_header_divided',
				'default_value' => '',
				'label'         => esc_html__('Background Transparency', 'topfit'),
				'description'   => esc_html__('Set background transparency for header', 'topfit'),
				'args'          => array(
					'col_width' => 3
				)
			)
		);


		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_divided,
				'type'          => 'yesno',
				'name'          => 'menu_area_shadow_header_divided',
				'default_value' => 'yes',
				'label'         => esc_html__('Header Area Shadow', 'topfit'),
				'description'   => esc_html__('Set shadow on header area', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_divided,
				'type'          => 'text',
				'name'          => 'menu_area_height_header_divided',
				'default_value' => '',
				'label'         => esc_html__('Height', 'topfit'),
				'description'   => esc_html__('Enter Header Height (default is 98px)', 'topfit'),
				'args'          => array(
					'col_width' => 3,
					'suffix'    => 'px'
				)
			)
		);

		/***************** Divided Header Layout - end *******************/

		/***************** Centered Header Layout - start ****************/

		$panel_header_centered = topfit_mikado_add_admin_panel(
			array(
				'page'            => '_header_page',
				'name'            => 'panel_header_centered',
				'title'           => esc_html__('Header Centered', 'topfit'),
				'hidden_property' => 'header_type',
				'hidden_value'    => '',
				'hidden_values'   => array(
					'header-vertical',
					'header-standard',
					'header-minimal',
					'header-divided',
				)
			)
		);

		topfit_mikado_add_admin_section_title(
			array(
				'parent' => $panel_header_centered,
				'name'   => 'logo_menu_area_title',
				'title'  => esc_html__('Logo Area', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_centered,
				'type'          => 'yesno',
				'name'          => 'logo_area_in_grid_header_centered',
				'default_value' => 'no',
				'label'         => esc_html__('Logo Area In Grid', 'topfit'),
				'description'   => esc_html__('Set menu area content to be in grid', 'topfit'),
				'args'          => array(
					'dependence'             => true,
					'dependence_hide_on_yes' => '',
					'dependence_show_on_yes' => '#mkd_logo_area_in_grid_header_centered_container'
				)
			)
		);

		$logo_area_in_grid_header_centered_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $panel_header_centered,
				'name'            => 'logo_area_in_grid_header_centered_container',
				'hidden_property' => 'logo_area_in_grid_header_centered',
				'hidden_value'    => 'no'
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $logo_area_in_grid_header_centered_container,
				'type'          => 'color',
				'name'          => 'logo_area_grid_background_color_header_centered',
				'default_value' => '',
				'label'         => esc_html__('Grid Background Color', 'topfit'),
				'description'   => esc_html__('Set grid background color for logo area', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $logo_area_in_grid_header_centered_container,
				'type'          => 'text',
				'name'          => 'logo_area_grid_background_transparency_header_centered',
				'default_value' => '',
				'label'         => esc_html__('Grid Background Transparency', 'topfit'),
				'description'   => esc_html__('Set grid background transparency', 'topfit'),
				'args'          => array(
					'col_width' => 3
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $logo_area_in_grid_header_centered_container,
				'type'          => 'yesno',
				'name'          => 'logo_area_in_grid_border_header_centered',
				'default_value' => 'no',
				'label'         => esc_html__('Grid Area Border', 'topfit'),
				'description'   => esc_html__('Set border on grid area', 'topfit'),
				'args'          => array(
					'dependence'             => true,
					'dependence_hide_on_yes' => '',
					'dependence_show_on_yes' => '#mkd_logo_area_in_grid_border_header_centered_container'
				)
			)
		);

		$logo_area_in_grid_border_header_centered_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $logo_area_in_grid_header_centered_container,
				'name'            => 'logo_area_in_grid_border_header_centered_container',
				'hidden_property' => 'logo_area_in_grid_border_header_centered',
				'hidden_value'    => 'no'
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $logo_area_in_grid_border_header_centered_container,
				'type'          => 'color',
				'name'          => 'logo_area_in_grid_border_color_header_centered',
				'default_value' => '',
				'label'         => esc_html__('Border Color', 'topfit'),
				'description'   => esc_html__('Set border color for grid area', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_centered,
				'type'          => 'color',
				'name'          => 'logo_area_background_color_header_centered',
				'default_value' => '',
				'label'         => esc_html__('Background color', 'topfit'),
				'description'   => esc_html__('Set background color for logo area', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_centered,
				'type'          => 'text',
				'name'          => 'logo_area_background_transparency_header_centered',
				'default_value' => '',
				'label'         => esc_html__('Background transparency', 'topfit'),
				'description'   => esc_html__('Set background transparency for logo area', 'topfit'),
				'args'          => array(
					'col_width' => 3
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_centered,
				'type'          => 'yesno',
				'name'          => 'logo_area_border_header_centered',
				'default_value' => 'no',
				'label'         => esc_html__('Logo Area Border', 'topfit'),
				'description'   => esc_html__('Set border on logo area', 'topfit'),
				'args'          => array(
					'dependence'             => true,
					'dependence_hide_on_yes' => '',
					'dependence_show_on_yes' => '#mkd_logo_area_border_header_centered_container'
				)
			)
		);

		$logo_area_border_header_centered_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $panel_header_centered,
				'name'            => 'logo_area_border_header_centered_container',
				'hidden_property' => 'logo_area_border_header_centered',
				'hidden_value'    => 'no'
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $logo_area_border_header_centered_container,
				'type'          => 'color',
				'name'          => 'logo_area_border_color_header_centered',
				'default_value' => '',
				'label'         => esc_html__('Border Color', 'topfit'),
				'description'   => esc_html__('Set border color for logo area', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_centered,
				'type'          => 'text',
				'name'          => 'logo_wrapper_padding_header_centered',
				'default_value' => '',
				'label'         => esc_html__('Logo Padding', 'topfit'),
				'description'   => esc_html__('Insert padding in format: 0px 0px 1px 0px', 'topfit'),
				'args'          => array(
					'col_width' => 3
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_centered,
				'type'          => 'text',
				'name'          => 'logo_area_height_header_centered',
				'default_value' => '',
				'label'         => esc_html__('Height', 'topfit'),
				'description'   => esc_html__('Enter logo area height (default is 155px)', 'topfit'),
				'args'          => array(
					'col_width' => 3,
					'suffix'    => 'px'
				)
			)
		);


		topfit_mikado_add_admin_section_title(
			array(
				'parent' => $panel_header_centered,
				'name'   => 'main_menu_area_title',
				'title'  => esc_html__('Menu Area', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_centered,
				'type'          => 'yesno',
				'name'          => 'menu_area_in_grid_header_centered',
				'default_value' => 'no',
				'label'         => esc_html__('Menu Area In Grid', 'topfit'),
				'description'   => esc_html__('Set menu area content to be in grid', 'topfit'),
				'args'          => array(
					'dependence'             => true,
					'dependence_hide_on_yes' => '',
					'dependence_show_on_yes' => '#mkd_menu_area_in_grid_header_centered_container'
				)
			)
		);

		$menu_area_in_grid_header_centered_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $panel_header_centered,
				'name'            => 'menu_area_in_grid_header_centered_container',
				'hidden_property' => 'menu_area_in_grid_header_centered',
				'hidden_value'    => 'no'
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $menu_area_in_grid_header_centered_container,
				'type'          => 'color',
				'name'          => 'menu_area_grid_background_color_header_centered',
				'default_value' => '',
				'label'         => esc_html__('Grid Background Color', 'topfit'),
				'description'   => esc_html__('Set grid background color for menu area', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $menu_area_in_grid_header_centered_container,
				'type'          => 'text',
				'name'          => 'menu_area_grid_background_transparency_header_centered',
				'default_value' => '',
				'label'         => esc_html__('Grid Background Transparency', 'topfit'),
				'description'   => esc_html__('Set grid background transparency', 'topfit'),
				'args'          => array(
					'col_width' => 3
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $menu_area_in_grid_header_centered_container,
				'type'          => 'yesno',
				'name'          => 'menu_area_in_grid_shadow_header_centered',
				'default_value' => 'no',
				'label'         => esc_html__('Grid Area Shadow', 'topfit'),
				'description'   => esc_html__('Set shadow on grid area', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_centered,
				'type'          => 'color',
				'name'          => 'menu_area_background_color_header_centered',
				'default_value' => '',
				'label'         => esc_html__('Background color', 'topfit'),
				'description'   => esc_html__('Set background color for menu area', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_centered,
				'type'          => 'text',
				'name'          => 'menu_area_background_transparency_header_centered',
				'default_value' => '',
				'label'         => esc_html__('Background transparency', 'topfit'),
				'description'   => esc_html__('Set background transparency for menu area', 'topfit'),
				'args'          => array(
					'col_width' => 3
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_centered,
				'type'          => 'yesno',
				'name'          => 'menu_area_shadow_header_centered',
				'default_value' => 'no',
				'label'         => esc_html__('Menu Area Shadow', 'topfit'),
				'description'   => esc_html__('Set border on menu area', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_centered,
				'type'          => 'text',
				'name'          => 'menu_area_height_header_centered',
				'default_value' => '',
				'label'         => esc_html__('Height', 'topfit'),
				'description'   => esc_html__('Enter menu area height (default is 98px)', 'topfit'),
				'args'          => array(
					'col_width' => 3,
					'suffix'    => 'px'
				)
			)
		);

		/***************** Centered Header Layout - end ****************/


		do_action('topfit_mikado_header_options_map');

		$panel_header_vertical = topfit_mikado_add_admin_panel(
			array(
				'page'            => '_header_page',
				'name'            => 'panel_header_vertical',
				'title'           => esc_html__('Header Vertical', 'topfit'),
				'hidden_property' => 'header_type',
				'hidden_value'    => '',
				'hidden_values'   => array(
					'header-standard',
					'header-minimal',
					'header-centered',
					'header-divided',
				)
			)
		);

		topfit_mikado_add_admin_field(array(
			'name'        => 'vertical_header_background_color',
			'type'        => 'color',
			'label'       => esc_html__('Background Color', 'topfit'),
			'description' => esc_html__('Set background color for vertical menu', 'topfit'),
			'parent'      => $panel_header_vertical
		));

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'vertical_header_background_image',
				'type'          => 'image',
				'default_value' => '',
				'label'         => esc_html__('Background Image', 'topfit'),
				'description'   => esc_html__('Set background image for vertical menu', 'topfit'),
				'parent'        => $panel_header_vertical
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_vertical,
				'type'          => 'yesno',
				'name'          => 'vertical_header_shadow',
				'default_value' => 'yes',
				'label'         => esc_html__('Shadow', 'topfit'),
				'description'   => esc_html__('Set shadow on vertical header', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_header_vertical,
				'type'          => 'yesno',
				'name'          => 'vertical_header_center_content',
				'default_value' => 'no',
				'label'         => esc_html__('Center Content', 'topfit'),
				'description'   => esc_html__('Set content in vertical center', 'topfit'),
			)
		);

		$panel_sticky_header = topfit_mikado_add_admin_panel(
			array(
				'title'           => esc_html__('Sticky Header', 'topfit'),
				'name'            => 'panel_sticky_header',
				'page'            => '_header_page',
				'hidden_property' => 'header_behaviour',
				'hidden_values'   => array(
					'no-behavior',
					'fixed-on-scroll'

				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'        => 'scroll_amount_for_sticky',
				'type'        => 'text',
				'label'       => esc_html__('Scroll Amount for Sticky', 'topfit'),
				'description' => esc_html__('Enter scroll amount for Sticky Menu to appear (deafult is header height)', 'topfit'),
				'parent'      => $panel_sticky_header,
				'args'        => array(
					'col_width' => 2,
					'suffix'    => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'sticky_header_in_grid',
				'type'          => 'yesno',
				'default_value' => 'yes',
				'label'         => esc_html__('Sticky Header in grid', 'topfit'),
				'description'   => esc_html__('Set sticky header content to be in grid', 'topfit'),
				'parent'        => $panel_sticky_header,
				'args'          => array(
					"dependence"             => true,
					"dependence_hide_on_yes" => "",
					"dependence_show_on_yes" => "#mkd_sticky_header_in_grid_container"
				)
			)
		);

		$sticky_header_in_grid_container = topfit_mikado_add_admin_container(array(
			'name'            => 'sticky_header_in_grid_container',
			'parent'          => $panel_sticky_header,
			'hidden_property' => 'sticky_header_in_grid',
			'hidden_value'    => 'no'
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'sticky_header_grid_background_color',
			'type'        => 'color',
			'label'       => esc_html__('Grid Background Color', 'topfit'),
			'description' => esc_html__('Set grid background color for sticky header', 'topfit'),
			'parent'      => $sticky_header_in_grid_container
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'sticky_header_grid_transparency',
			'type'        => 'text',
			'label'       => esc_html__('Sticky Header Grid Transparency', 'topfit'),
			'description' => esc_html__('Enter transparency for sticky header grid (value from 0 to 1)', 'topfit'),
			'parent'      => $sticky_header_in_grid_container,
			'args'        => array(
				'col_width' => 1
			)
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'sticky_header_background_color',
			'type'        => 'color',
			'label'       => esc_html__('Background Color', 'topfit'),
			'description' => esc_html__('Set background color for sticky header', 'topfit'),
			'parent'      => $panel_sticky_header
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'sticky_header_transparency',
			'type'        => 'text',
			'label'       => esc_html__('Sticky Header Transparency', 'topfit'),
			'description' => esc_html__('Enter transparency for sticky header (value from 0 to 1)', 'topfit'),
			'parent'      => $panel_sticky_header,
			'args'        => array(
				'col_width' => 1
			)
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'sticky_header_height',
			'type'        => 'text',
			'label'       => esc_html__('Sticky Header Height', 'topfit'),
			'description' => esc_html__('Enter height for sticky header (default is 98px)', 'topfit'),
			'parent'      => $panel_sticky_header,
			'args'        => array(
				'col_width' => 2,
				'suffix'    => 'px'
			)
		));

		$group_sticky_header_menu = topfit_mikado_add_admin_group(array(
			'title'       => esc_html__('Sticky Header Menu', 'topfit'),
			'name'        => 'group_sticky_header_menu',
			'parent'      => $panel_sticky_header,
			'description' => esc_html__('Define styles for sticky menu items', 'topfit'),
		));

		$row1_sticky_header_menu = topfit_mikado_add_admin_row(array(
			'name'   => 'row1',
			'parent' => $group_sticky_header_menu
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'sticky_color',
			'type'        => 'colorsimple',
			'label'       => esc_html__('Text Color', 'topfit'),
			'description' => '',
			'parent'      => $row1_sticky_header_menu
		));

		$row2_sticky_header_menu = topfit_mikado_add_admin_row(array(
			'name'   => 'row2',
			'parent' => $group_sticky_header_menu
		));

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'sticky_google_fonts',
				'type'          => 'fontsimple',
				'label'         => esc_html__('Font Family', 'topfit'),
				'default_value' => '-1',
				'parent'        => $row2_sticky_header_menu,
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'type'          => 'textsimple',
				'name'          => 'sticky_fontsize',
				'label'         => esc_html__('Font Size', 'topfit'),
				'default_value' => '',
				'parent'        => $row2_sticky_header_menu,
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'type'          => 'textsimple',
				'name'          => 'sticky_lineheight',
				'label'         => esc_html__('Line height', 'topfit'),
				'default_value' => '',
				'parent'        => $row2_sticky_header_menu,
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'type'          => 'selectblanksimple',
				'name'          => 'sticky_texttransform',
				'label'         => esc_html__('Text transform', 'topfit'),
				'default_value' => '',
				'options'       => topfit_mikado_get_text_transform_array(),
				'parent'        => $row2_sticky_header_menu
			)
		);

		$row3_sticky_header_menu = topfit_mikado_add_admin_row(array(
			'name'   => 'row3',
			'parent' => $group_sticky_header_menu
		));

		topfit_mikado_add_admin_field(
			array(
				'type'          => 'selectblanksimple',
				'name'          => 'sticky_fontstyle',
				'default_value' => '',
				'label'         => esc_html__('Font Style', 'topfit'),
				'options'       => topfit_mikado_get_font_style_array(),
				'parent'        => $row3_sticky_header_menu
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'type'          => 'selectblanksimple',
				'name'          => 'sticky_fontweight',
				'default_value' => '',
				'label'         => esc_html__('Font Weight', 'topfit'),
				'options'       => topfit_mikado_get_font_weight_array(),
				'parent'        => $row3_sticky_header_menu
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'type'          => 'textsimple',
				'name'          => 'sticky_letterspacing',
				'label'         => esc_html__('Letter Spacing', 'topfit'),
				'default_value' => '',
				'parent'        => $row3_sticky_header_menu,
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		$panel_fixed_header = topfit_mikado_add_admin_panel(
			array(
				'title'           => esc_html__('Fixed Header', 'topfit'),
				'name'            => 'panel_fixed_header',
				'page'            => '_header_page',
				'hidden_property' => 'header_behaviour',
				'hidden_values'   => array(
					'sticky-header-on-scroll-up',
					'sticky-header-on-scroll-down-up',
					'no-behavior',
					'fixed-on-scroll'
				)
			)
		);

		topfit_mikado_add_admin_field(array(
			'name'          => 'fixed_header_grid_background_color',
			'type'          => 'color',
			'default_value' => '',
			'label'         => esc_html__('Grid Background Color', 'topfit'),
			'description'   => esc_html__('Set grid background color for fixed header', 'topfit'),
			'parent'        => $panel_fixed_header
		));

		topfit_mikado_add_admin_field(array(
			'name'          => 'fixed_header_grid_transparency',
			'type'          => 'text',
			'default_value' => '',
			'label'         => esc_html__('Header Transparency Grid', 'topfit'),
			'description'   => esc_html__('Enter transparency for fixed header grid (value from 0 to 1)', 'topfit'),
			'parent'        => $panel_fixed_header,
			'args'          => array(
				'col_width' => 1
			)
		));

		topfit_mikado_add_admin_field(array(
			'name'          => 'fixed_header_background_color',
			'type'          => 'color',
			'default_value' => '',
			'label'         => esc_html__('Background Color', 'topfit'),
			'description'   => esc_html__('Set background color for fixed header', 'topfit'),
			'parent'        => $panel_fixed_header
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'fixed_header_transparency',
			'type'        => 'text',
			'label'       => esc_html__('Header Transparency', 'topfit'),
			'description' => esc_html__('Enter transparency for fixed header (value from 0 to 1)', 'topfit'),
			'parent'      => $panel_fixed_header,
			'args'        => array(
				'col_width' => 1
			)
		));


		$panel_main_menu = topfit_mikado_add_admin_panel(
			array(
				'title'           => esc_html__('Main Menu', 'topfit'),
				'name'            => 'panel_main_menu',
				'page'            => '_header_page',
				'hidden_property' => 'header_type',
				'hidden_values'   => array('header-vertical', 'header-minimal')
			)
		);

		topfit_mikado_add_admin_section_title(
			array(
				'parent' => $panel_main_menu,
				'name'   => 'main_menu_area_title',
				'title'  => esc_html__('Main Menu General Settings', 'topfit')
			)
		);

		$drop_down_group = topfit_mikado_add_admin_group(
			array(
				'parent'      => $panel_main_menu,
				'name'        => 'drop_down_group',
				'title'       => esc_html__('Main Dropdown Menu', 'topfit'),
				'description' => esc_html__('Choose a color and transparency for the main menu background (0 = fully transparent, 1 = opaque)', 'topfit')
			)
		);

		$drop_down_row1 = topfit_mikado_add_admin_row(
			array(
				'parent' => $drop_down_group,
				'name'   => 'drop_down_row1',
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $drop_down_row1,
				'type'          => 'colorsimple',
				'name'          => 'dropdown_background_color',
				'default_value' => '',
				'label'         => esc_html__('Background Color', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $drop_down_row1,
				'type'          => 'textsimple',
				'name'          => 'dropdown_background_transparency',
				'default_value' => '',
				'label'         => esc_html__('Transparency', 'topfit'),
			)
		);

		$drop_down_padding_group = topfit_mikado_add_admin_group(
			array(
				'parent'      => $panel_main_menu,
				'name'        => 'drop_down_padding_group',
				'title'       => esc_html__('Main Dropdown Menu Padding', 'topfit'),
				'description' => esc_html__('Choose a top/bottom padding for dropdown menu', 'topfit')
			)
		);

		$drop_down_padding_row = topfit_mikado_add_admin_row(
			array(
				'parent' => $drop_down_padding_group,
				'name'   => 'drop_down_padding_row',
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $drop_down_padding_row,
				'type'          => 'textsimple',
				'name'          => 'dropdown_top_padding',
				'default_value' => '',
				'label'         => esc_html__('Top Padding', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $drop_down_padding_row,
				'type'          => 'textsimple',
				'name'          => 'dropdown_bottom_padding',
				'default_value' => '',
				'label'         => esc_html__('Bottom Padding', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_main_menu,
				'type'          => 'select',
				'name'          => 'menu_dropdown_appearance',
				'default_value' => 'default',
				'label'         => esc_html__('Main Dropdown Menu Appearance', 'topfit'),
				'description'   => esc_html__('Choose appearance for dropdown menu', 'topfit'),
				'options'       => array(
					'dropdown-default'           => esc_html__('Default', 'topfit'),
					'dropdown-slide-from-bottom' => esc_html__('Slide From Bottom', 'topfit'),
					'dropdown-slide-from-top'    => esc_html__('Slide From Top', 'topfit'),
					'dropdown-animate-height'    => esc_html__('Animate Height', 'topfit'),
					'dropdown-slide-from-left'   => esc_html__('Slide From Left', 'topfit')
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_main_menu,
				'type'          => 'text',
				'name'          => 'dropdown_top_position',
				'default_value' => '',
				'label'         => esc_html__('Dropdown position', 'topfit'),
				'description'   => esc_html__('Enter value in percentage of entire header height', 'topfit'),
				'args'          => array(
					'col_width' => 3,
					'suffix'    => '%'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_main_menu,
				'type'          => 'yesno',
				'name'          => 'enable_wide_menu_background',
				'default_value' => 'no',
				'label'         => esc_html__('Enable Full Width Background for Wide Dropdown Type', 'topfit'),
				'description'   => esc_html__('Enabling this option will show full width background  for wide dropdown type', 'topfit'),
			)
		);

		$first_level_group = topfit_mikado_add_admin_group(
			array(
				'parent'      => $panel_main_menu,
				'name'        => 'first_level_group',
				'title'       => esc_html__('1st Level Menu', 'topfit'),
				'description' => esc_html__('Define styles for 1st level in Top Navigation Menu', 'topfit')
			)
		);

		$first_level_row1 = topfit_mikado_add_admin_row(
			array(
				'parent' => $first_level_group,
				'name'   => 'first_level_row1'
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $first_level_row1,
				'type'          => 'colorsimple',
				'name'          => 'menu_color',
				'default_value' => '',
				'label'         => esc_html__('Text Color', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $first_level_row1,
				'type'          => 'colorsimple',
				'name'          => 'menu_hovercolor',
				'default_value' => '',
				'label'         => esc_html__('Hover Text Color', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $first_level_row1,
				'type'          => 'colorsimple',
				'name'          => 'menu_activecolor',
				'default_value' => '',
				'label'         => esc_html__('Active Text Color', 'topfit'),
			)
		);

		$first_level_row2 = topfit_mikado_add_admin_row(
			array(
				'parent' => $first_level_group,
				'name'   => 'first_level_row2',
				'next'   => true
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $first_level_row2,
				'type'          => 'colorsimple',
				'name'          => 'menu_text_background_color',
				'default_value' => '',
				'label'         => esc_html__('Text Background Color', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $first_level_row2,
				'type'          => 'colorsimple',
				'name'          => 'menu_hover_background_color',
				'default_value' => '',
				'label'         => esc_html__('Hover Text Background Color', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $first_level_row2,
				'type'          => 'colorsimple',
				'name'          => 'menu_active_background_color',
				'default_value' => '',
				'label'         => esc_html__('Active Text Background Color', 'topfit'),
			)
		);

		$first_level_row3 = topfit_mikado_add_admin_row(
			array(
				'parent' => $first_level_group,
				'name'   => 'first_level_row3',
				'next'   => true
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $first_level_row3,
				'type'          => 'colorsimple',
				'name'          => 'menu_light_hovercolor',
				'default_value' => '',
				'label'         => esc_html__('Light Menu Hover Text Color', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $first_level_row3,
				'type'          => 'colorsimple',
				'name'          => 'menu_light_activecolor',
				'default_value' => '',
				'label'         => esc_html__('Light Menu Active Text Color', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $first_level_row3,
				'type'          => 'colorsimple',
				'name'          => 'menu_light_border_color',
				'default_value' => '',
				'label'         => esc_html__('Light Menu Border Hover/Active Color', 'topfit'),
			)
		);

		$first_level_row4 = topfit_mikado_add_admin_row(
			array(
				'parent' => $first_level_group,
				'name'   => 'first_level_row4',
				'next'   => true
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $first_level_row4,
				'type'          => 'colorsimple',
				'name'          => 'menu_dark_hovercolor',
				'default_value' => '',
				'label'         => esc_html__('Dark Menu Hover Text Color', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $first_level_row4,
				'type'          => 'colorsimple',
				'name'          => 'menu_dark_activecolor',
				'default_value' => '',
				'label'         => esc_html__('Dark Menu Active Text Color', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $first_level_row4,
				'type'          => 'colorsimple',
				'name'          => 'menu_dark_border_color',
				'default_value' => '',
				'label'         => esc_html__('Dark Menu Border Hover/Active Color', 'topfit'),
			)
		);

		$first_level_row5 = topfit_mikado_add_admin_row(
			array(
				'parent' => $first_level_group,
				'name'   => 'first_level_row5',
				'next'   => true
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $first_level_row5,
				'type'          => 'fontsimple',
				'name'          => 'menu_google_fonts',
				'default_value' => '-1',
				'label'         => esc_html__('Font Family', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $first_level_row5,
				'type'          => 'textsimple',
				'name'          => 'menu_fontsize',
				'default_value' => '',
				'label'         => esc_html__('Font Size', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $first_level_row5,
				'type'          => 'textsimple',
				'name'          => 'menu_hover_background_color_transparency',
				'default_value' => '',
				'label'         => esc_html__('Hover Background Color Transparency', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $first_level_row5,
				'type'          => 'textsimple',
				'name'          => 'menu_active_background_color_transparency',
				'default_value' => '',
				'label'         => esc_html__('Active Background Color Transparency', 'topfit'),
			)
		);

		$first_level_row6 = topfit_mikado_add_admin_row(
			array(
				'parent' => $first_level_group,
				'name'   => 'first_level_row6',
				'next'   => true
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $first_level_row6,
				'type'          => 'selectblanksimple',
				'name'          => 'menu_fontstyle',
				'default_value' => '',
				'label'         => esc_html__('Font Style', 'topfit'),
				'options'       => topfit_mikado_get_font_style_array()
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $first_level_row6,
				'type'          => 'selectblanksimple',
				'name'          => 'menu_fontweight',
				'default_value' => '',
				'label'         => esc_html__('Font Weight', 'topfit'),
				'options'       => topfit_mikado_get_font_weight_array()
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $first_level_row6,
				'type'          => 'textsimple',
				'name'          => 'menu_letterspacing',
				'default_value' => '',
				'label'         => esc_html__('Letter Spacing', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $first_level_row6,
				'type'          => 'selectblanksimple',
				'name'          => 'menu_texttransform',
				'default_value' => '',
				'label'         => esc_html__('Text Transform', 'topfit'),
				'options'       => topfit_mikado_get_text_transform_array()
			)
		);

		$first_level_row7 = topfit_mikado_add_admin_row(
			array(
				'parent' => $first_level_group,
				'name'   => 'first_level_row7',
				'next'   => true
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $first_level_row7,
				'type'          => 'textsimple',
				'name'          => 'menu_lineheight',
				'default_value' => '',
				'label'         => esc_html__('Line Height', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $first_level_row7,
				'type'          => 'textsimple',
				'name'          => 'menu_padding_left_right',
				'default_value' => '',
				'label'         => esc_html__('Padding Left/Right', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $first_level_row7,
				'type'          => 'textsimple',
				'name'          => 'menu_margin_left_right',
				'default_value' => '',
				'label'         => esc_html__('Margin Left/Right', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		$second_level_group = topfit_mikado_add_admin_group(
			array(
				'parent'      => $panel_main_menu,
				'name'        => 'second_level_group',
				'title'       => esc_html__('2nd Level Menu', 'topfit'),
				'description' => esc_html__('Define styles for 2nd level in Top Navigation Menu', 'topfit')
			)
		);

		$second_level_row1 = topfit_mikado_add_admin_row(
			array(
				'parent' => $second_level_group,
				'name'   => 'second_level_row1'
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $second_level_row1,
				'type'          => 'colorsimple',
				'name'          => 'dropdown_color',
				'default_value' => '',
				'label'         => esc_html__('Text Color', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $second_level_row1,
				'type'          => 'colorsimple',
				'name'          => 'dropdown_hovercolor',
				'default_value' => '',
				'label'         => esc_html__('Hover/Active Color', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $second_level_row1,
				'type'          => 'colorsimple',
				'name'          => 'dropdown_background_hovercolor',
				'default_value' => '',
				'label'         => esc_html__('Hover/Active Background Color', 'topfit')
			)
		);

		$second_level_row2 = topfit_mikado_add_admin_row(
			array(
				'parent' => $second_level_group,
				'name'   => 'second_level_row2',
				'next'   => true
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $second_level_row2,
				'type'          => 'fontsimple',
				'name'          => 'dropdown_google_fonts',
				'default_value' => '-1',
				'label'         => esc_html__('Font Family', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $second_level_row2,
				'type'          => 'textsimple',
				'name'          => 'dropdown_fontsize',
				'default_value' => '',
				'label'         => esc_html__('Font Size', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $second_level_row2,
				'type'          => 'textsimple',
				'name'          => 'dropdown_lineheight',
				'default_value' => '',
				'label'         => esc_html__('Line Height', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $second_level_row2,
				'type'          => 'textsimple',
				'name'          => 'dropdown_padding_top_bottom',
				'default_value' => '',
				'label'         => esc_html__('Padding Top/Bottom', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		$second_level_row3 = topfit_mikado_add_admin_row(
			array(
				'parent' => $second_level_group,
				'name'   => 'second_level_row3',
				'next'   => true
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $second_level_row3,
				'type'          => 'selectblanksimple',
				'name'          => 'dropdown_fontstyle',
				'default_value' => '',
				'label'         => esc_html__('Font style', 'topfit'),
				'options'       => topfit_mikado_get_font_style_array()
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $second_level_row3,
				'type'          => 'selectblanksimple',
				'name'          => 'dropdown_fontweight',
				'default_value' => '',
				'label'         => esc_html__('Font weight', 'topfit'),
				'options'       => topfit_mikado_get_font_weight_array()
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $second_level_row3,
				'type'          => 'textsimple',
				'name'          => 'dropdown_letterspacing',
				'default_value' => '',
				'label'         => esc_html__('Letter spacing', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $second_level_row3,
				'type'          => 'selectblanksimple',
				'name'          => 'dropdown_texttransform',
				'default_value' => '',
				'label'         => esc_html__('Text Transform', 'topfit'),
				'options'       => topfit_mikado_get_text_transform_array()
			)
		);

		$second_level_wide_group = topfit_mikado_add_admin_group(
			array(
				'parent'      => $panel_main_menu,
				'name'        => 'second_level_wide_group',
				'title'       => esc_html__('2nd Level Wide Menu', 'topfit'),
				'description' => esc_html__('Define styles for 2nd level in Wide Menu', 'topfit')
			)
		);

		$second_level_wide_row1 = topfit_mikado_add_admin_row(
			array(
				'parent' => $second_level_wide_group,
				'name'   => 'second_level_wide_row1'
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $second_level_wide_row1,
				'type'          => 'colorsimple',
				'name'          => 'dropdown_wide_color',
				'default_value' => '',
				'label'         => esc_html__('Text Color', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $second_level_wide_row1,
				'type'          => 'colorsimple',
				'name'          => 'dropdown_wide_hovercolor',
				'default_value' => '',
				'label'         => esc_html__('Hover/Active Color', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $second_level_wide_row1,
				'type'          => 'colorsimple',
				'name'          => 'dropdown_wide_background_hovercolor',
				'default_value' => '',
				'label'         => esc_html__('Hover/Active Background Color', 'topfit')
			)
		);

		$second_level_wide_row2 = topfit_mikado_add_admin_row(
			array(
				'parent' => $second_level_wide_group,
				'name'   => 'second_level_wide_row2',
				'next'   => true
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $second_level_wide_row2,
				'type'          => 'fontsimple',
				'name'          => 'dropdown_wide_google_fonts',
				'default_value' => '-1',
				'label'         => esc_html__('Font Family', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $second_level_wide_row2,
				'type'          => 'textsimple',
				'name'          => 'dropdown_wide_fontsize',
				'default_value' => '',
				'label'         => esc_html__('Font Size', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $second_level_wide_row2,
				'type'          => 'textsimple',
				'name'          => 'dropdown_wide_lineheight',
				'default_value' => '',
				'label'         => esc_html__('Line Height', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $second_level_wide_row2,
				'type'          => 'textsimple',
				'name'          => 'dropdown_wide_padding_top_bottom',
				'default_value' => '',
				'label'         => esc_html__('Padding Top/Bottom', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		$second_level_wide_row3 = topfit_mikado_add_admin_row(
			array(
				'parent' => $second_level_wide_group,
				'name'   => 'second_level_wide_row3',
				'next'   => true
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $second_level_wide_row3,
				'type'          => 'selectblanksimple',
				'name'          => 'dropdown_wide_fontstyle',
				'default_value' => '',
				'label'         => esc_html__('Font style', 'topfit'),
				'options'       => topfit_mikado_get_font_style_array()
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $second_level_wide_row3,
				'type'          => 'selectblanksimple',
				'name'          => 'dropdown_wide_fontweight',
				'default_value' => '',
				'label'         => esc_html__('Font weight', 'topfit'),
				'options'       => topfit_mikado_get_font_weight_array()
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $second_level_wide_row3,
				'type'          => 'textsimple',
				'name'          => 'dropdown_wide_letterspacing',
				'default_value' => '',
				'label'         => esc_html__('Letter spacing', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $second_level_wide_row3,
				'type'          => 'selectblanksimple',
				'name'          => 'dropdown_wide_texttransform',
				'default_value' => '',
				'label'         => esc_html__('Text Transform', 'topfit'),
				'options'       => topfit_mikado_get_text_transform_array()
			)
		);

		$third_level_group = topfit_mikado_add_admin_group(
			array(
				'parent'      => $panel_main_menu,
				'name'        => 'third_level_group',
				'title'       => esc_html__('3nd Level Menu', 'topfit'),
				'description' => esc_html__('Define styles for 3nd level in Top Navigation Menu', 'topfit')
			)
		);

		$third_level_row1 = topfit_mikado_add_admin_row(
			array(
				'parent' => $third_level_group,
				'name'   => 'third_level_row1'
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $third_level_row1,
				'type'          => 'colorsimple',
				'name'          => 'dropdown_color_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__('Text Color', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $third_level_row1,
				'type'          => 'colorsimple',
				'name'          => 'dropdown_hovercolor_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__('Hover/Active Color', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $third_level_row1,
				'type'          => 'colorsimple',
				'name'          => 'dropdown_background_hovercolor_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__('Hover/Active Background Color', 'topfit')
			)
		);

		$third_level_row2 = topfit_mikado_add_admin_row(
			array(
				'parent' => $third_level_group,
				'name'   => 'third_level_row2',
				'next'   => true
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $third_level_row2,
				'type'          => 'fontsimple',
				'name'          => 'dropdown_google_fonts_thirdlvl',
				'default_value' => '-1',
				'label'         => esc_html__('Font Family', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $third_level_row2,
				'type'          => 'textsimple',
				'name'          => 'dropdown_fontsize_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__('Font Size', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $third_level_row2,
				'type'          => 'textsimple',
				'name'          => 'dropdown_lineheight_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__('Line Height', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		$third_level_row3 = topfit_mikado_add_admin_row(
			array(
				'parent' => $third_level_group,
				'name'   => 'third_level_row3',
				'next'   => true
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $third_level_row3,
				'type'          => 'selectblanksimple',
				'name'          => 'dropdown_fontstyle_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__('Font style', 'topfit'),
				'options'       => topfit_mikado_get_font_style_array()
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $third_level_row3,
				'type'          => 'selectblanksimple',
				'name'          => 'dropdown_fontweight_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__('Font weight', 'topfit'),
				'options'       => topfit_mikado_get_font_weight_array()
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $third_level_row3,
				'type'          => 'textsimple',
				'name'          => 'dropdown_letterspacing_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__('Letter spacing', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $third_level_row3,
				'type'          => 'selectblanksimple',
				'name'          => 'dropdown_texttransform_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__('Text Transform', 'topfit'),
				'options'       => topfit_mikado_get_text_transform_array()
			)
		);


		/***********************************************************/
		$third_level_wide_group = topfit_mikado_add_admin_group(
			array(
				'parent'      => $panel_main_menu,
				'name'        => 'third_level_wide_group',
				'title'       => esc_html__('3rd Level Wide Menu', 'topfit'),
				'description' => esc_html__('Define styles for 3rd level in Wide Menu', 'topfit')
			)
		);

		$third_level_wide_row1 = topfit_mikado_add_admin_row(
			array(
				'parent' => $third_level_wide_group,
				'name'   => 'third_level_wide_row1'
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $third_level_wide_row1,
				'type'          => 'colorsimple',
				'name'          => 'dropdown_wide_color_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__('Text Color', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $third_level_wide_row1,
				'type'          => 'colorsimple',
				'name'          => 'dropdown_wide_hovercolor_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__('Hover/Active Color', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $third_level_wide_row1,
				'type'          => 'colorsimple',
				'name'          => 'dropdown_wide_background_hovercolor_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__('Hover/Active Background Color', 'topfit')
			)
		);

		$third_level_wide_row2 = topfit_mikado_add_admin_row(
			array(
				'parent' => $third_level_wide_group,
				'name'   => 'third_level_wide_row2',
				'next'   => true
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $third_level_wide_row2,
				'type'          => 'fontsimple',
				'name'          => 'dropdown_wide_google_fonts_thirdlvl',
				'default_value' => '-1',
				'label'         => esc_html__('Font Family', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $third_level_wide_row2,
				'type'          => 'textsimple',
				'name'          => 'dropdown_wide_fontsize_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__('Font Size', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $third_level_wide_row2,
				'type'          => 'textsimple',
				'name'          => 'dropdown_wide_lineheight_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__('Line Height', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		$third_level_wide_row3 = topfit_mikado_add_admin_row(
			array(
				'parent' => $third_level_wide_group,
				'name'   => 'third_level_wide_row3',
				'next'   => true
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $third_level_wide_row3,
				'type'          => 'selectblanksimple',
				'name'          => 'dropdown_wide_fontstyle_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__('Font style', 'topfit'),
				'options'       => topfit_mikado_get_font_style_array()
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $third_level_wide_row3,
				'type'          => 'selectblanksimple',
				'name'          => 'dropdown_wide_fontweight_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__('Font weight', 'topfit'),
				'options'       => topfit_mikado_get_font_weight_array()
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $third_level_wide_row3,
				'type'          => 'textsimple',
				'name'          => 'dropdown_wide_letterspacing_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__('Letter spacing', 'topfit'),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $third_level_wide_row3,
				'type'          => 'selectblanksimple',
				'name'          => 'dropdown_wide_texttransform_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__('Text Transform', 'topfit'),
				'options'       => topfit_mikado_get_text_transform_array()
			)
		);

		$panel_vertical_main_menu = topfit_mikado_add_admin_panel(
			array(
				'title'           => esc_html__('Vertical Main Menu', 'topfit'),
				'name'            => 'panel_vertical_main_menu',
				'page'            => '_header_page',
				'hidden_property' => 'header_type',
				'hidden_values'   => array(
					'header-standard',
					'header-minimal'
				)
			)
		);

		$drop_down_group = topfit_mikado_add_admin_group(
			array(
				'parent'      => $panel_vertical_main_menu,
				'name'        => 'vertical_drop_down_group',
				'title'       => esc_html__('Main Dropdown Menu', 'topfit'),
				'description' => esc_html__('Set a style for dropdown menu', 'topfit')
			)
		);

		$vertical_drop_down_row1 = topfit_mikado_add_admin_row(
			array(
				'parent' => $drop_down_group,
				'name'   => 'mkd_drop_down_row1',
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $vertical_drop_down_row1,
				'type'          => 'colorsimple',
				'name'          => 'vertical_dropdown_background_color',
				'default_value' => '',
				'label'         => esc_html__('Background Color', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $vertical_drop_down_row1,
				'type'          => 'colorsimple',
				'name'          => 'vertical_dropdown_border_color',
				'default_value' => '',
				'label'         => esc_html__('Border Color', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $vertical_drop_down_row1,
				'type'          => 'textsimple',
				'name'          => 'vertical_dropdown_transparency',
				'default_value' => '',
				'label'         => esc_html__('Transparency', 'topfit'),
			)
		);

		$group_vertical_first_level = topfit_mikado_add_admin_group(array(
			'name'        => 'group_vertical_first_level',
			'title'       => esc_html__('1st level', 'topfit'),
			'description' => esc_html__('Define styles for 1st level menu', 'topfit'),
			'parent'      => $panel_vertical_main_menu
		));

		$row_vertical_first_level_1 = topfit_mikado_add_admin_row(array(
			'name'   => 'row_vertical_first_level_1',
			'parent' => $group_vertical_first_level
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'colorsimple',
			'name'          => 'vertical_menu_1st_color',
			'default_value' => '',
			'label'         => esc_html__('Text Color', 'topfit'),
			'parent'        => $row_vertical_first_level_1
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'colorsimple',
			'name'          => 'vertical_menu_1st_hover_color',
			'default_value' => '',
			'label'         => esc_html__('Hover Color', 'topfit'),
			'parent'        => $row_vertical_first_level_1
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'colorsimple',
			'name'          => 'vertical_menu_1st_hover_background_color',
			'default_value' => '',
			'label'         => esc_html__('Hover Background Color', 'topfit'),
			'parent'        => $row_vertical_first_level_1
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'textsimple',
			'name'          => 'vertical_menu_1st_fontsize',
			'default_value' => '',
			'label'         => esc_html__('Font Size', 'topfit'),
			'args'          => array(
				'suffix' => 'px'
			),
			'parent'        => $row_vertical_first_level_1
		));

		$row_vertical_first_level_2 = topfit_mikado_add_admin_row(array(
			'name'   => 'row_vertical_first_level_2',
			'parent' => $group_vertical_first_level,
			'next'   => true
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'textsimple',
			'name'          => 'vertical_menu_1st_lineheight',
			'default_value' => '',
			'label'         => esc_html__('Line Height', 'topfit'),
			'args'          => array(
				'suffix' => 'px'
			),
			'parent'        => $row_vertical_first_level_2
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'selectblanksimple',
			'name'          => 'vertical_menu_1st_texttransform',
			'default_value' => '',
			'label'         => esc_html__('Text Transform', 'topfit'),
			'options'       => topfit_mikado_get_text_transform_array(),
			'parent'        => $row_vertical_first_level_2
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'fontsimple',
			'name'          => 'vertical_menu_1st_google_fonts',
			'default_value' => '-1',
			'label'         => esc_html__('Font Family', 'topfit'),
			'parent'        => $row_vertical_first_level_2
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'selectblanksimple',
			'name'          => 'vertical_menu_1st_fontstyle',
			'default_value' => '',
			'label'         => esc_html__('Font Style', 'topfit'),
			'options'       => topfit_mikado_get_font_style_array(),
			'parent'        => $row_vertical_first_level_2
		));

		$row_vertical_first_level_3 = topfit_mikado_add_admin_row(array(
			'name'   => 'row_vertical_first_level_3',
			'parent' => $group_vertical_first_level,
			'next'   => true
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'selectblanksimple',
			'name'          => 'vertical_menu_1st_fontweight',
			'default_value' => '',
			'label'         => esc_html__('Font Weight', 'topfit'),
			'options'       => topfit_mikado_get_font_weight_array(),
			'parent'        => $row_vertical_first_level_3
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'textsimple',
			'name'          => 'vertical_menu_1st_letter_spacing',
			'default_value' => '',
			'label'         => esc_html__('Letter Spacing', 'topfit'),
			'args'          => array(
				'suffix' => 'px'
			),
			'parent'        => $row_vertical_first_level_3
		));

		$group_vertical_second_level = topfit_mikado_add_admin_group(array(
			'name'        => 'group_vertical_second_level',
			'title'       => esc_html__('2nd level', 'topfit'),
			'description' => esc_html__('Define styles for 2nd level menu', 'topfit'),
			'parent'      => $panel_vertical_main_menu
		));

		$row_vertical_second_level_1 = topfit_mikado_add_admin_row(array(
			'name'   => 'row_vertical_second_level_1',
			'parent' => $group_vertical_second_level
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'colorsimple',
			'name'          => 'vertical_menu_2nd_color',
			'default_value' => '',
			'label'         => esc_html__('Text Color', 'topfit'),
			'parent'        => $row_vertical_second_level_1
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'colorsimple',
			'name'          => 'vertical_menu_2nd_hover_color',
			'default_value' => '',
			'label'         => esc_html__('Hover Color', 'topfit'),
			'parent'        => $row_vertical_second_level_1
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'colorsimple',
			'name'          => 'vertical_menu_2nd_hover_background_color',
			'default_value' => '',
			'label'         => esc_html__('Hover Background Color', 'topfit'),
			'parent'        => $row_vertical_second_level_1
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'textsimple',
			'name'          => 'vertical_menu_2nd_fontsize',
			'default_value' => '',
			'label'         => esc_html__('Font Size', 'topfit'),
			'args'          => array(
				'suffix' => 'px'
			),
			'parent'        => $row_vertical_second_level_1
		));

		$row_vertical_second_level_2 = topfit_mikado_add_admin_row(array(
			'name'   => 'row_vertical_second_level_2',
			'parent' => $group_vertical_second_level,
			'next'   => true
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'textsimple',
			'name'          => 'vertical_menu_2nd_lineheight',
			'default_value' => '',
			'label'         => esc_html__('Line Height', 'topfit'),
			'args'          => array(
				'suffix' => 'px'
			),
			'parent'        => $row_vertical_second_level_2
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'selectblanksimple',
			'name'          => 'vertical_menu_2nd_texttransform',
			'default_value' => '',
			'label'         => esc_html__('Text Transform', 'topfit'),
			'options'       => topfit_mikado_get_text_transform_array(),
			'parent'        => $row_vertical_second_level_2
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'fontsimple',
			'name'          => 'vertical_menu_2nd_google_fonts',
			'default_value' => '-1',
			'label'         => esc_html__('Font Family', 'topfit'),
			'parent'        => $row_vertical_second_level_2
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'selectblanksimple',
			'name'          => 'vertical_menu_2nd_fontstyle',
			'default_value' => '',
			'label'         => esc_html__('Font Style', 'topfit'),
			'options'       => topfit_mikado_get_font_style_array(),
			'parent'        => $row_vertical_second_level_2
		));

		$row_vertical_second_level_3 = topfit_mikado_add_admin_row(array(
			'name'   => 'row_vertical_second_level_3',
			'parent' => $group_vertical_second_level,
			'next'   => true
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'selectblanksimple',
			'name'          => 'vertical_menu_2nd_fontweight',
			'default_value' => '',
			'label'         => esc_html__('Font Weight', 'topfit'),
			'options'       => topfit_mikado_get_font_weight_array(),
			'parent'        => $row_vertical_second_level_3
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'textsimple',
			'name'          => 'vertical_menu_2nd_letter_spacing',
			'default_value' => '',
			'label'         => esc_html__('Letter Spacing', 'topfit'),
			'args'          => array(
				'suffix' => 'px'
			),
			'parent'        => $row_vertical_second_level_3
		));

		$group_vertical_third_level = topfit_mikado_add_admin_group(array(
			'name'        => 'group_vertical_third_level',
			'title'       => esc_html__('3rd level', 'topfit'),
			'description' => esc_html__('Define styles for 3rd level menu', 'topfit'),
			'parent'      => $panel_vertical_main_menu
		));

		$row_vertical_third_level_1 = topfit_mikado_add_admin_row(array(
			'name'   => 'row_vertical_third_level_1',
			'parent' => $group_vertical_third_level
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'colorsimple',
			'name'          => 'vertical_menu_3rd_color',
			'default_value' => '',
			'label'         => esc_html__('Text Color', 'topfit'),
			'parent'        => $row_vertical_third_level_1
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'colorsimple',
			'name'          => 'vertical_menu_3rd_hover_color',
			'default_value' => '',
			'label'         => esc_html__('Hover Color', 'topfit'),
			'parent'        => $row_vertical_third_level_1
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'colorsimple',
			'name'          => 'vertical_menu_3rd_hover_background_color',
			'default_value' => '',
			'label'         => esc_html__('Hover Background Color', 'topfit'),
			'parent'        => $row_vertical_third_level_1
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'textsimple',
			'name'          => 'vertical_menu_3rd_fontsize',
			'default_value' => '',
			'label'         => esc_html__('Font Size', 'topfit'),
			'args'          => array(
				'suffix' => 'px'
			),
			'parent'        => $row_vertical_third_level_1
		));

		$row_vertical_third_level_2 = topfit_mikado_add_admin_row(array(
			'name'   => 'row_vertical_third_level_2',
			'parent' => $group_vertical_third_level,
			'next'   => true
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'textsimple',
			'name'          => 'vertical_menu_3rd_lineheight',
			'default_value' => '',
			'label'         => esc_html__('Line Height', 'topfit'),
			'args'          => array(
				'suffix' => 'px'
			),
			'parent'        => $row_vertical_third_level_2
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'selectblanksimple',
			'name'          => 'vertical_menu_3rd_texttransform',
			'default_value' => '',
			'label'         => esc_html__('Text Transform', 'topfit'),
			'options'       => topfit_mikado_get_text_transform_array(),
			'parent'        => $row_vertical_third_level_2
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'fontsimple',
			'name'          => 'vertical_menu_3rd_google_fonts',
			'default_value' => '-1',
			'label'         => esc_html__('Font Family', 'topfit'),
			'parent'        => $row_vertical_third_level_2
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'selectblanksimple',
			'name'          => 'vertical_menu_3rd_fontstyle',
			'default_value' => '',
			'label'         => esc_html__('Font Style', 'topfit'),
			'options'       => topfit_mikado_get_font_style_array(),
			'parent'        => $row_vertical_third_level_2
		));

		$row_vertical_third_level_3 = topfit_mikado_add_admin_row(array(
			'name'   => 'row_vertical_third_level_3',
			'parent' => $group_vertical_third_level,
			'next'   => true
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'selectblanksimple',
			'name'          => 'vertical_menu_3rd_fontweight',
			'default_value' => '',
			'label'         => esc_html__('Font Weight', 'topfit'),
			'options'       => topfit_mikado_get_font_weight_array(),
			'parent'        => $row_vertical_third_level_3
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'textsimple',
			'name'          => 'vertical_menu_3rd_letter_spacing',
			'default_value' => '',
			'label'         => esc_html__('Letter Spacing', 'topfit'),
			'args'          => array(
				'suffix' => 'px'
			),
			'parent'        => $row_vertical_third_level_3
		));

		$panel_mobile_header = topfit_mikado_add_admin_panel(array(
			'title' => esc_html__('Mobile header', 'topfit'),
			'name'  => 'panel_mobile_header',
			'page'  => '_header_page'
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'mobile_header_height',
			'type'        => 'text',
			'label'       => esc_html__('Mobile Header Height', 'topfit'),
			'description' => esc_html__('Enter height for mobile header in pixels', 'topfit'),
			'parent'      => $panel_mobile_header,
			'args'        => array(
				'col_width' => 3,
				'suffix'    => 'px'
			)
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'mobile_header_background_color',
			'type'        => 'color',
			'label'       => esc_html__('Mobile Header Background Color', 'topfit'),
			'description' => esc_html__('Choose color for mobile header', 'topfit'),
			'parent'      => $panel_mobile_header
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'mobile_menu_background_color',
			'type'        => 'color',
			'label'       => esc_html__('Mobile Menu Background Color', 'topfit'),
			'description' => esc_html__('Choose color for mobile menu', 'topfit'),
			'parent'      => $panel_mobile_header
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'mobile_menu_separator_color',
			'type'        => 'color',
			'label'       => esc_html__('Mobile Menu Item Separator Color', 'topfit'),
			'description' => esc_html__('Choose color for mobile menu horizontal separators', 'topfit'),
			'parent'      => $panel_mobile_header
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'mobile_logo_height',
			'type'        => 'text',
			'label'       => esc_html__('Logo Height For Mobile Header', 'topfit'),
			'description' => esc_html__('Define logo height for screen size smaller than 98px', 'topfit'),
			'parent'      => $panel_mobile_header,
			'args'        => array(
				'col_width' => 3,
				'suffix'    => 'px'
			)
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'mobile_logo_height_phones',
			'type'        => 'text',
			'label'       => esc_html__('Logo Height For Mobile Devices', 'topfit'),
			'description' => esc_html__('Define logo height for screen size smaller than 480px', 'topfit'),
			'parent'      => $panel_mobile_header,
			'args'        => array(
				'col_width' => 3,
				'suffix'    => 'px'
			)
		));

		topfit_mikado_add_admin_section_title(array(
			'parent' => $panel_mobile_header,
			'name'   => 'mobile_header_fonts_title',
			'title'  => esc_html__('Typography', 'topfit')
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'mobile_text_color',
			'type'        => 'color',
			'label'       => esc_html__('Navigation Text Color', 'topfit'),
			'description' => esc_html__('Define color for mobile navigation text', 'topfit'),
			'parent'      => $panel_mobile_header
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'mobile_text_hover_color',
			'type'        => 'color',
			'label'       => esc_html__('Navigation Hover/Active Color', 'topfit'),
			'description' => esc_html__('Define hover/active color for mobile navigation text', 'topfit'),
			'parent'      => $panel_mobile_header
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'mobile_font_family',
			'type'        => 'font',
			'label'       => esc_html__('Navigation Font Family', 'topfit'),
			'description' => esc_html__('Define font family for mobile navigation text', 'topfit'),
			'parent'      => $panel_mobile_header
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'mobile_font_size',
			'type'        => 'text',
			'label'       => esc_html__('Navigation Font Size', 'topfit'),
			'description' => esc_html__('Define font size for mobile navigation text', 'topfit'),
			'parent'      => $panel_mobile_header,
			'args'        => array(
				'col_width' => 3,
				'suffix'    => 'px'
			)
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'mobile_line_height',
			'type'        => 'text',
			'label'       => esc_html__('Navigation Line Height', 'topfit'),
			'description' => esc_html__('Define line height for mobile navigation text', 'topfit'),
			'parent'      => $panel_mobile_header,
			'args'        => array(
				'col_width' => 3,
				'suffix'    => 'px'
			)
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'mobile_text_transform',
			'type'        => 'select',
			'label'       => esc_html__('Navigation Text Transform', 'topfit'),
			'description' => esc_html__('Define text transform for mobile navigation text', 'topfit'),
			'parent'      => $panel_mobile_header,
			'options'     => topfit_mikado_get_text_transform_array(true)
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'mobile_font_style',
			'type'        => 'select',
			'label'       => esc_html__('Navigation Font Style', 'topfit'),
			'description' => esc_html__('Define font style for mobile navigation text', 'topfit'),
			'parent'      => $panel_mobile_header,
			'options'     => topfit_mikado_get_font_style_array(true)
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'mobile_font_weight',
			'type'        => 'select',
			'label'       => esc_html__('Navigation Font Weight', 'topfit'),
			'description' => esc_html__('Define font weight for mobile navigation text', 'topfit'),
			'parent'      => $panel_mobile_header,
			'options'     => topfit_mikado_get_font_weight_array(true)
		));

		topfit_mikado_add_admin_section_title(array(
			'name'   => 'mobile_opener_panel',
			'parent' => $panel_mobile_header,
			'title'  => esc_html__('Mobile Menu Opener', 'topfit')
		));

		topfit_mikado_add_admin_field(array(
			'name'          => 'mobile_icon_pack',
			'type'          => 'select',
			'label'         => esc_html__('Mobile Navigation Icon Pack', 'topfit'),
			'default_value' => 'font_awesome',
			'description'   => esc_html__('Choose icon pack for mobile navigation icon', 'topfit'),
			'parent'        => $panel_mobile_header,
			'options'       => topfit_mikado_icon_collections()->getIconCollectionsExclude(array(
				'linea_icons',
				'simple_line_icons',
				'linear_icons'
			))
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'mobile_icon_color',
			'type'        => 'color',
			'label'       => esc_html__('Mobile Navigation Icon Color', 'topfit'),
			'description' => esc_html__('Choose color for icon header', 'topfit'),
			'parent'      => $panel_mobile_header
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'mobile_icon_hover_color',
			'type'        => 'color',
			'label'       => esc_html__('Mobile Navigation Icon Hover Color', 'topfit'),
			'description' => esc_html__('Choose hover color for mobile navigation icon ', 'topfit'),
			'parent'      => $panel_mobile_header
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'mobile_icon_size',
			'type'        => 'text',
			'label'       => esc_html__('Mobile Navigation Icon size', 'topfit'),
			'description' => esc_html__('Choose size for mobile navigation icon', 'topfit'),
			'parent'      => $panel_mobile_header,
			'args'        => array(
				'col_width' => 3,
				'suffix'    => 'px'
			)
		));
	}

	add_action('topfit_mikado_options_map', 'topfit_mikado_header_options_map', 3);

}