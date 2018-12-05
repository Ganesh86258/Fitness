<?php

if (!function_exists('topfit_mikado_tabs_map')) {
	function topfit_mikado_tabs_map() {

		$panel = topfit_mikado_add_admin_panel(array(
			'title' => esc_html__('Tabs', 'topfit'),
			'name'  => 'panel_tabs',
			'page'  => '_elements_page'
		));

		//Typography options
		topfit_mikado_add_admin_section_title(array(
			'name'   => 'typography_section_title',
			'title'  => esc_html__('Tabs Navigation Typography', 'topfit'),
			'parent' => $panel
		));

		$typography_group = topfit_mikado_add_admin_group(array(
			'name'        => 'typography_group',
			'title'       => esc_html__('Tabs Navigation Typography', 'topfit'),
			'description' => esc_html__('Setup typography for tabs navigation', 'topfit'),
			'parent'      => $panel
		));

		$typography_row = topfit_mikado_add_admin_row(array(
			'name'   => 'typography_row',
			'next'   => true,
			'parent' => $typography_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_row,
			'type'          => 'fontsimple',
			'name'          => 'tabs_font_family',
			'default_value' => '',
			'label'         => esc_html__('Font Family', 'topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_row,
			'type'          => 'selectsimple',
			'name'          => 'tabs_text_transform',
			'default_value' => '',
			'label'         => esc_html__('Text Transform', 'topfit'),
			'options'       => topfit_mikado_get_text_transform_array()
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_row,
			'type'          => 'selectsimple',
			'name'          => 'tabs_font_style',
			'default_value' => '',
			'label'         => esc_html__('Font Style', 'topfit'),
			'options'       => topfit_mikado_get_font_style_array()
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_row,
			'type'          => 'textsimple',
			'name'          => 'tabs_letter_spacing',
			'default_value' => '',
			'label'         => esc_html__('Letter Spacing', 'topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		$typography_row2 = topfit_mikado_add_admin_row(array(
			'name'   => 'typography_row2',
			'next'   => true,
			'parent' => $typography_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_row2,
			'type'          => 'selectsimple',
			'name'          => 'tabs_font_weight',
			'default_value' => '',
			'label'         => esc_html__('Font Weight', 'topfit'),
			'options'       => topfit_mikado_get_font_weight_array()
		));

		//Initial Tab Color Styles

		topfit_mikado_add_admin_section_title(array(
			'name'   => 'tab_color_section_title',
			'title'  => esc_html__('Tab Navigation Color Styles', 'topfit'),
			'parent' => $panel
		));
		$tabs_color_group = topfit_mikado_add_admin_group(array(
			'name'        => 'tabs_color_group',
			'title'       => esc_html__('Tab Navigation Color Styles', 'topfit'),
			'description' => esc_html__('Set color styles for tab navigation', 'topfit'),
			'parent'      => $panel
		));
		$tabs_color_row = topfit_mikado_add_admin_row(array(
			'name'   => 'tabs_color_row',
			'next'   => true,
			'parent' => $tabs_color_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $tabs_color_row,
			'type'          => 'colorsimple',
			'name'          => 'tabs_color',
			'default_value' => '',
			'label'         => esc_html__('Color', 'topfit')
		));
		topfit_mikado_add_admin_field(array(
			'parent'        => $tabs_color_row,
			'type'          => 'colorsimple',
			'name'          => 'tabs_back_color',
			'default_value' => '',
			'label'         => esc_html__('Background Color', 'topfit')
		));
		topfit_mikado_add_admin_field(array(
			'parent'        => $tabs_color_row,
			'type'          => 'colorsimple',
			'name'          => 'tabs_border_color',
			'default_value' => '',
			'label'         => esc_html__('Border Color', 'topfit')
		));

		//Active Tab Color Styles

		$active_tabs_color_group = topfit_mikado_add_admin_group(array(
			'name'        => 'active_tabs_color_group',
			'title'       => esc_html__('Active and Hover Navigation Color Styles', 'topfit'),
			'description' => esc_html__('Set color styles for active and hover tabs', 'topfit'),
			'parent'      => $panel
		));
		$active_tabs_color_row = topfit_mikado_add_admin_row(array(
			'name'   => 'active_tabs_color_row',
			'next'   => true,
			'parent' => $active_tabs_color_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $active_tabs_color_row,
			'type'          => 'colorsimple',
			'name'          => 'tabs_color_active',
			'default_value' => '',
			'label'         => esc_html__('Color', 'topfit')
		));
		topfit_mikado_add_admin_field(array(
			'parent'        => $active_tabs_color_row,
			'type'          => 'colorsimple',
			'name'          => 'tabs_back_color_active',
			'default_value' => '',
			'label'         => esc_html__('Background Color', 'topfit')
		));
		topfit_mikado_add_admin_field(array(
			'parent'        => $active_tabs_color_row,
			'type'          => 'colorsimple',
			'name'          => 'tabs_border_color_active',
			'default_value' => '',
			'label'         => esc_html__('Border Color', 'topfit')
		));

	}

	add_action('topfit_mikado_options_elements_map', 'topfit_mikado_tabs_map');
}