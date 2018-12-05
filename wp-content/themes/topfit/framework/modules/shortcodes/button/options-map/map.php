<?php

if(!function_exists('topfit_mikado_button_map')) {
	function topfit_mikado_button_map() {
		$panel = topfit_mikado_add_admin_panel(array(
			'title' => esc_html__('Button', 'topfit'),
			'name'  => 'panel_button',
			'page'  => '_elements_page'
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'button_hover_animation',
			'type'        => 'select',
			'label'       => esc_html__('Hover Animation', 'topfit'),
			'description' => esc_html__('Choose default hover animation type', 'topfit'),
			'parent'      => $panel,
			'options'     => topfit_mikado_get_btn_hover_animation_types()
		));

		//Typography options
		topfit_mikado_add_admin_section_title(array(
			'name'   => 'typography_section_title',
			'title'  => esc_html__('Typography', 'topfit'),
			'parent' => $panel
		));

		$typography_group = topfit_mikado_add_admin_group(array(
			'name'        => 'typography_group',
			'title'       => esc_html__('Typography', 'topfit'),
			'description' => esc_html__('Setup typography for all button types', 'topfit'),
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
			'name'          => 'button_font_family',
			'default_value' => '',
			'label'         => esc_html__('Font Family', 'topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_row,
			'type'          => 'selectsimple',
			'name'          => 'button_text_transform',
			'default_value' => '',
			'label'         => esc_html__('Text Transform', 'topfit'),
			'options'       => topfit_mikado_get_text_transform_array()
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_row,
			'type'          => 'selectsimple',
			'name'          => 'button_font_style',
			'default_value' => '',
			'label'         => esc_html__('Font Style', 'topfit'),
			'options'       => topfit_mikado_get_font_style_array()
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_row,
			'type'          => 'textsimple',
			'name'          => 'button_letter_spacing',
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
			'name'          => 'button_font_weight',
			'default_value' => '',
			'label'         => esc_html__('Font Weight', 'topfit'),
			'options'       => topfit_mikado_get_font_weight_array()
		));

		//Outline type options
		topfit_mikado_add_admin_section_title(array(
			'name'   => 'type_section_title',
			'title'  => esc_html__('Types', 'topfit'),
			'parent' => $panel
		));

		$outline_group = topfit_mikado_add_admin_group(array(
			'name'        => 'outline_group',
			'title'       => esc_html__('Outline Type', 'topfit'),
			'description' => esc_html__('Setup outline button type', 'topfit'),
			'parent'      => $panel
		));

		$outline_row = topfit_mikado_add_admin_row(array(
			'name'   => 'outline_row',
			'next'   => true,
			'parent' => $outline_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $outline_row,
			'type'          => 'colorsimple',
			'name'          => 'btn_outline_text_color',
			'default_value' => '',
			'label'         => esc_html__('Text Color', 'topfit'),
			'description'   => ''
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $outline_row,
			'type'          => 'colorsimple',
			'name'          => 'btn_outline_hover_text_color',
			'default_value' => '',
			'label'         => esc_html__('Text Hover Color', 'topfit'),
			'description'   => ''
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $outline_row,
			'type'          => 'colorsimple',
			'name'          => 'btn_outline_hover_bg_color',
			'default_value' => '',
			'label'         => esc_html__('Hover Background Color', 'topfit'),
			'description'   => ''
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $outline_row,
			'type'          => 'colorsimple',
			'name'          => 'btn_outline_border_color',
			'default_value' => '',
			'label'         => esc_html__('Border Color', 'topfit'),
			'description'   => ''
		));

		$outline_row2 = topfit_mikado_add_admin_row(array(
			'name'   => 'outline_row2',
			'next'   => true,
			'parent' => $outline_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $outline_row2,
			'type'          => 'colorsimple',
			'name'          => 'btn_outline_hover_border_color',
			'default_value' => '',
			'label'         => esc_html__('Hover Border Color', 'topfit'),
			'description'   => ''
		));

		//Solid type options
		$solid_group = topfit_mikado_add_admin_group(array(
			'name'        => 'solid_group',
			'title'       => esc_html__('Solid Type', 'topfit'),
			'description' => esc_html__('Setup solid button type', 'topfit'),
			'parent'      => $panel
		));

		$solid_row = topfit_mikado_add_admin_row(array(
			'name'   => 'solid_row',
			'next'   => true,
			'parent' => $solid_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $solid_row,
			'type'          => 'colorsimple',
			'name'          => 'btn_solid_text_color',
			'default_value' => '',
			'label'         => esc_html__('Text Color', 'topfit'),
			'description'   => ''
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $solid_row,
			'type'          => 'colorsimple',
			'name'          => 'btn_solid_hover_text_color',
			'default_value' => '',
			'label'         => esc_html__('Text Hover Color', 'topfit'),
			'description'   => ''
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $solid_row,
			'type'          => 'colorsimple',
			'name'          => 'btn_solid_bg_color',
			'default_value' => '',
			'label'         => esc_html__('Background Color', 'topfit'),
			'description'   => ''
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $solid_row,
			'type'          => 'colorsimple',
			'name'          => 'btn_solid_hover_bg_color',
			'default_value' => '',
			'label'         => esc_html__('Hover Background Color', 'topfit'),
			'description'   => ''
		));

		$solid_row2 = topfit_mikado_add_admin_row(array(
			'name'   => 'solid_row2',
			'next'   => true,
			'parent' => $solid_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $solid_row2,
			'type'          => 'colorsimple',
			'name'          => 'btn_solid_border_color',
			'default_value' => '',
			'label'         => esc_html__('Border Color', 'topfit'),
			'description'   => ''
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $solid_row2,
			'type'          => 'colorsimple',
			'name'          => 'btn_solid_hover_border_color',
			'default_value' => '',
			'label'         => esc_html__('Hover Border Color', 'topfit'),
			'description'   => ''
		));
	}

	add_action('topfit_mikado_options_elements_map', 'topfit_mikado_button_map');
}