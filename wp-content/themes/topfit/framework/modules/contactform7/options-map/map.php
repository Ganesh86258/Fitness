<?php

if(!function_exists('topfit_mikado_contact_form_7_options_map')) {

	function topfit_mikado_contact_form_7_options_map() {

		topfit_mikado_add_admin_page(array(
			'slug'  => '_contact_form7_page',
			'title' => esc_html__('Contact Form 7','topfit'),
			'icon'  => 'icon_mail_alt'
		));

		$panel_contact_form_style_1 = topfit_mikado_add_admin_panel(array(
			'page'  => '_contact_form7_page',
			'name'  => 'panel_contact_form_style_1',
			'title' => esc_html__('Custom Style 1','topfit'),
		));

		//Text Typography

		$typography_text_group = topfit_mikado_add_admin_group(array(
			'name'        => 'typography_text_group',
			'title'       => esc_html__('Form Text Typography','topfit'),
			'description' => esc_html__('Setup typography for form elements text','topfit'),
			'parent'      => $panel_contact_form_style_1
		));

		$typography_text_row1 = topfit_mikado_add_admin_row(array(
			'name'   => 'typography_text_row1',
			'parent' => $typography_text_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_text_row1,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_1_text_color',
			'default_value' => '',
			'label'         => esc_html__('Text Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_text_row1,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_1_focus_text_color',
			'default_value' => '',
			'label'         => esc_html__('Focus Text Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_text_row1,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_text_font_size',
			'default_value' => '',
			'label'         => esc_html__('Font Size','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_text_row1,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_text_line_height',
			'default_value' => '',
			'label'         => esc_html__('Line Height','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		$typography_text_row2 = topfit_mikado_add_admin_row(array(
			'name'   => 'typography_text_row2',
			'next'   => true,
			'parent' => $typography_text_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_text_row2,
			'type'          => 'fontsimple',
			'name'          => 'cf7_style_1_text_font_family',
			'default_value' => '',
			'label'         => esc_html__('Font Family','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_text_row2,
			'type'          => 'selectsimple',
			'name'          => 'cf7_style_1_text_font_style',
			'default_value' => '',
			'label'         => esc_html__('Font Style','topfit'),
			'options'       => topfit_mikado_get_font_style_array()
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_text_row2,
			'type'          => 'selectsimple',
			'name'          => 'cf7_style_1_text_font_weight',
			'default_value' => '',
			'label'         => esc_html__('Font Weight','topfit'),
			'options'       => topfit_mikado_get_font_weight_array()
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_text_row2,
			'type'          => 'selectsimple',
			'name'          => 'cf7_style_1_text_text_transform',
			'default_value' => '',
			'label'         => esc_html__('Text Transform','topfit'),
			'options'       => topfit_mikado_get_text_transform_array()
		));

		$typography_text_row3 = topfit_mikado_add_admin_row(array(
			'name'   => 'typography_text_row3',
			'next'   => true,
			'parent' => $typography_text_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_text_row3,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_text_letter_spacing',
			'default_value' => '',
			'label'         => esc_html__('Letter Spacing','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		// Labels Typography

		$typography_label_group = topfit_mikado_add_admin_group(array(
			'name'        => 'typography_label_group',
			'title'       => esc_html__('Form Label Typography','topfit'),
			'description' => esc_html__('Setup typography for form elements label','topfit'),
			'parent'      => $panel_contact_form_style_1
		));

		$typography_label_row1 = topfit_mikado_add_admin_row(array(
			'name'   => 'typography_label_row1',
			'parent' => $typography_label_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_label_row1,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_1_label_color',
			'default_value' => '',
			'label'         => esc_html__('Text Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_label_row1,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_label_font_size',
			'default_value' => '',
			'label'         => esc_html__('Font Size','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_label_row1,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_label_line_height',
			'default_value' => '',
			'label'         => esc_html__('Line Height','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_label_row1,
			'type'          => 'fontsimple',
			'name'          => 'cf7_style_1_label_font_family',
			'default_value' => '',
			'label'         => esc_html__('Font Family','topfit'),
		));

		$typography_label_row2 = topfit_mikado_add_admin_row(array(
			'name'   => 'typography_label_row2',
			'next'   => true,
			'parent' => $typography_label_group
		));


		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_label_row2,
			'type'          => 'selectsimple',
			'name'          => 'cf7_style_1_label_font_style',
			'default_value' => '',
			'label'         => esc_html__('Font Style','topfit'),
			'options'       => topfit_mikado_get_font_style_array()
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_label_row2,
			'type'          => 'selectsimple',
			'name'          => 'cf7_style_1_label_font_weight',
			'default_value' => '',
			'label'         => esc_html__('Font Weight','topfit'),
			'options'       => topfit_mikado_get_font_weight_array()
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_label_row2,
			'type'          => 'selectsimple',
			'name'          => 'cf7_style_1_label_text_transform',
			'default_value' => '',
			'label'         => esc_html__('Text Transform','topfit'),
			'options'       => topfit_mikado_get_text_transform_array()
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_label_row2,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_label_letter_spacing',
			'default_value' => '',
			'label'         => esc_html__('Letter Spacing','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		// Form Elements Background and Border

		$background_border_group = topfit_mikado_add_admin_group(array(
			'name'        => 'background_border_group',
			'title'       => esc_html__('Form Elements Background and Border','topfit'),
			'description' =>  esc_html__('Setup form elements background and border style','topfit'),
			'parent'      => $panel_contact_form_style_1
		));

		$background_border_row1 = topfit_mikado_add_admin_row(array(
			'name'   => 'background_border_row1',
			'parent' => $background_border_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $background_border_row1,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_1_background_color',
			'default_value' => '',
			'label'         => esc_html__('Background Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $background_border_row1,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_background_transparency',
			'default_value' => '',
			'label'         => esc_html__('Background Transparency','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $background_border_row1,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_1_focus_background_color',
			'default_value' => '',
			'label'         => esc_html__('Focus Background Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $background_border_row1,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_focus_background_transparency',
			'default_value' => '',
			'label'         => esc_html__('Focus Background Transparency','topfit'),
		));

		$background_border_row2 = topfit_mikado_add_admin_row(array(
			'name'   => 'background_border_row2',
			'next'   => true,
			'parent' => $background_border_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $background_border_row2,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_1_border_color',
			'default_value' => '',
			'label'         => esc_html__('Border Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $background_border_row2,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_border_transparency',
			'default_value' => '',
			'label'         => esc_html__('Border Transparency','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $background_border_row2,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_1_focus_border_color',
			'default_value' => '',
			'label'         => esc_html__('Focus Border Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $background_border_row2,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_focus_border_transparency',
			'default_value' => '',
			'label'         => esc_html__('Focus Border Transparency','topfit'),
		));

		$background_border_row3 = topfit_mikado_add_admin_row(array(
			'name'   => 'background_border_row3',
			'next'   => true,
			'parent' => $background_border_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $background_border_row3,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_border_width',
			'default_value' => '',
			'label'         => esc_html__('Border Width','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $background_border_row3,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_border_radius',
			'default_value' => '',
			'label'         => esc_html__('Border Radius','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		// Form Elements Padding

		$padding_group = topfit_mikado_add_admin_group(array(
			'name'        => 'padding_group',
			'title'       => esc_html__('Elements Padding','topfit'),
			'description' => esc_html__('Setup form elements padding','topfit'),
			'parent'      => $panel_contact_form_style_1
		));

		$padding_row = topfit_mikado_add_admin_row(array(
			'name'   => 'padding_row',
			'parent' => $padding_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $padding_row,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_padding_top',
			'default_value' => '',
			'label'         => esc_html__('Padding Top','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $padding_row,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_padding_right',
			'default_value' => '',
			'label'         => esc_html__('Padding Right','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $padding_row,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_padding_bottom',
			'default_value' => '',
			'label'         => esc_html__('Padding Bottom','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $padding_row,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_padding_left',
			'default_value' => '',
			'label'         => esc_html__('Padding Left','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		// Form Elements Margin

		$margin_group = topfit_mikado_add_admin_group(array(
			'name'        => 'margin_group',
			'title'       => esc_html__('Elements Margin','topfit'),
			'description' => esc_html__('Setup form elements margin','topfit'),
			'parent'      => $panel_contact_form_style_1
		));

		$margin_row = topfit_mikado_add_admin_row(array(
			'name'   => 'margin_row',
			'parent' => $margin_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $margin_row,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_margin_top',
			'default_value' => '',
			'label'         => esc_html__('Margin Top','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $margin_row,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_margin_bottom',
			'default_value' => '',
			'label'         => esc_html__('Margin Bottom','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		// Textarea

		topfit_mikado_add_admin_field(array(
			'parent'        => $panel_contact_form_style_1,
			'type'          => 'text',
			'name'          => 'cf7_style_1_textarea_height',
			'default_value' => '',
			'label'         => esc_html__('Textarea Height','topfit'),
			'description'   => esc_html__('Enter height for textarea form element','topfit'),
			'args'          => array(
				'col_width' => '3',
				'suffix'    => 'px'
			)
		));

		// Button Typography

		$button_typography_group = topfit_mikado_add_admin_group(array(
			'name'        => 'button_typography_group',
			'title'       => esc_html__('Button Typography','topfit'),
			'description' => esc_html__('Setup button text typography', 'topfit'),
			'parent'      => $panel_contact_form_style_1
		));

		$button_typography_row1 = topfit_mikado_add_admin_row(array(
			'name'   => 'button_typography_row1',
			'parent' => $button_typography_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_typography_row1,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_1_button_color',
			'default_value' => '',
			'label'         => esc_html__('Text Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_typography_row1,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_1_button_hover_color',
			'default_value' => '',
			'label'         => esc_html__('Text Hover Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_typography_row1,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_button_font_size',
			'default_value' => '',
			'label'         => esc_html__('Font Size','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_typography_row1,
			'type'          => 'fontsimple',
			'name'          => 'cf7_style_1_button_font_family',
			'default_value' => '',
			'label'         => esc_html__('Font Family','topfit'),
		));

		$button_typography_row2 = topfit_mikado_add_admin_row(array(
			'name'   => 'button_typography_row2',
			'next'   => true,
			'parent' => $button_typography_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_typography_row2,
			'type'          => 'selectsimple',
			'name'          => 'cf7_style_1_button_font_style',
			'default_value' => '',
			'label'         => esc_html__('Font Style','topfit'),
			'options'       => topfit_mikado_get_font_style_array()
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_typography_row2,
			'type'          => 'selectsimple',
			'name'          => 'cf7_style_1_button_font_weight',
			'default_value' => '',
			'label'         => esc_html__('Font Weight','topfit'),
			'options'       => topfit_mikado_get_font_weight_array()
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_typography_row2,
			'type'          => 'selectsimple',
			'name'          => 'cf7_style_1_button_text_transform',
			'default_value' => '',
			'label'         => esc_html__('Text Transform','topfit'),
			'options'       => topfit_mikado_get_text_transform_array()
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_typography_row2,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_button_letter_spacing',
			'default_value' => '',
			'label'         => esc_html__('Letter Spacing','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		// Button Background and Border

		$button_background_border_group = topfit_mikado_add_admin_group(array(
			'name'        => 'button_background_border_group',
			'title'       => esc_html__('Button Background and Border','topfit'),
			'description' => esc_html__('Setup button background and border style','topfit'),
			'parent'      => $panel_contact_form_style_1
		));

		$button_background_border_row1 = topfit_mikado_add_admin_row(array(
			'name'   => 'button_background_border_row1',
			'parent' => $button_background_border_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_background_border_row1,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_1_button_background_color',
			'default_value' => '',
			'label'         => esc_html__('Background Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_background_border_row1,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_button_background_transparency',
			'default_value' => '',
			'label'         => esc_html__('Background Transparency','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_background_border_row1,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_1_button_hover_bckg_color',
			'default_value' => '',
			'label'         => esc_html__('Background Hover Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_background_border_row1,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_button_hover_bckg_transparency',
			'default_value' => '',
			'label'         => esc_html__('Background Hover Transparency','topfit'),
		));

		$button_background_border_row2 = topfit_mikado_add_admin_row(array(
			'name'   => 'button_background_border_row2',
			'next'   => true,
			'parent' => $button_background_border_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_background_border_row2,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_1_button_border_color',
			'default_value' => '',
			'label'         => esc_html__('Border Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_background_border_row2,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_button_border_transparency',
			'default_value' => '',
			'label'         => esc_html__('Border Transparency','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_background_border_row2,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_1_button_hover_border_color',
			'default_value' => '',
			'label'         => esc_html__('Border Hover Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_background_border_row2,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_button_hover_border_transparency',
			'default_value' => '',
			'label'         => esc_html__('Border Hover Transparency','topfit'),
		));

		$button_background_border_row3 = topfit_mikado_add_admin_row(array(
			'name'   => 'button_background_border_row3',
			'next'   => true,
			'parent' => $button_background_border_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_background_border_row3,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_button_border_width',
			'default_value' => '',
			'label'         => esc_html__('Border Width','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_background_border_row3,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_1_button_border_radius',
			'default_value' => '',
			'label'         => esc_html__('Border Radius','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		// Button Height

		topfit_mikado_add_admin_field(array(
			'parent'        => $panel_contact_form_style_1,
			'type'          => 'text',
			'name'          => 'cf7_style_1_button_height',
			'default_value' => '',
			'label'         => esc_html__('Button Height','topfit'),
			'description'   => esc_html__('Insert form button height','topfit'),
			'args'          => array(
				'col_width' => '3',
				'suffix'    => 'px'
			)
		));

		// Button Padding

		topfit_mikado_add_admin_field(array(
			'parent'        => $panel_contact_form_style_1,
			'type'          => 'text',
			'name'          => 'cf7_style_1_button_padding',
			'default_value' => '',
			'label'         => esc_html__('Button Left/Right Padding','topfit'),
			'description'   => esc_html__('Enter value for button left and right padding','topfit'),
			'args'          => array(
				'col_width' => '3',
				'suffix'    => 'px'
			)
		));

		$panel_contact_form_style_2 = topfit_mikado_add_admin_panel(array(
			'page'  => '_contact_form7_page',
			'name'  => 'panel_contact_form_style_2',
			'title' => esc_html__('Custom Style 2','topfit'),
		));

		//Text Typography

		$typography_text_group = topfit_mikado_add_admin_group(array(
			'name'        => 'typography_text_group',
			'title'       => esc_html__('Form Text Typography','topfit'),
			'description' => esc_html__('Setup typography for form elements text','topfit'),
			'parent'      => $panel_contact_form_style_2
		));

		$typography_text_row1 = topfit_mikado_add_admin_row(array(
			'name'   => 'typography_text_row1',
			'parent' => $typography_text_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_text_row1,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_2_text_color',
			'default_value' => '',
			'label'         => esc_html__('Text Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_text_row1,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_2_focus_text_color',
			'default_value' => '',
			'label'         => esc_html__('Focus Text Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_text_row1,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_text_font_size',
			'default_value' => '',
			'label'         => esc_html__('Font Size','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_text_row1,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_text_line_height',
			'default_value' => '',
			'label'         => esc_html__('Line Height','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		$typography_text_row2 = topfit_mikado_add_admin_row(array(
			'name'   => 'typography_text_row2',
			'next'   => true,
			'parent' => $typography_text_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_text_row2,
			'type'          => 'fontsimple',
			'name'          => 'cf7_style_2_text_font_family',
			'default_value' => '',
			'label'         => esc_html__('Font Family','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_text_row2,
			'type'          => 'selectsimple',
			'name'          => 'cf7_style_2_text_font_style',
			'default_value' => '',
			'label'         => esc_html__('Font Style','topfit'),
			'options'       => topfit_mikado_get_font_style_array()
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_text_row2,
			'type'          => 'selectsimple',
			'name'          => 'cf7_style_2_text_font_weight',
			'default_value' => '',
			'label'         => esc_html__('Font Weight','topfit'),
			'options'       => topfit_mikado_get_font_weight_array()
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_text_row2,
			'type'          => 'selectsimple',
			'name'          => 'cf7_style_2_text_text_transform',
			'default_value' => '',
			'label'         => esc_html__('Text Transform','topfit'),
			'options'       => topfit_mikado_get_text_transform_array()
		));

		$typography_text_row3 = topfit_mikado_add_admin_row(array(
			'name'   => 'typography_text_row3',
			'next'   => true,
			'parent' => $typography_text_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_text_row3,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_text_letter_spacing',
			'default_value' => '',
			'label'         => esc_html__('Letter Spacing','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		// Labels Typography

		$typography_label_group = topfit_mikado_add_admin_group(array(
			'name'        => 'typography_label_group',
			'title'       => esc_html__('Form Label Typography','topfit'),
			'description' => esc_html__('Setup typography for form elements label','topfit'),
			'parent'      => $panel_contact_form_style_2
		));

		$typography_label_row1 = topfit_mikado_add_admin_row(array(
			'name'   => 'typography_label_row1',
			'parent' => $typography_label_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_label_row1,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_2_label_color',
			'default_value' => '',
			'label'         => esc_html__('Text Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_label_row1,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_label_font_size',
			'default_value' => '',
			'label'         => esc_html__('Font Size','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_label_row1,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_label_line_height',
			'default_value' => '',
			'label'         => esc_html__('Line Height','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_label_row1,
			'type'          => 'fontsimple',
			'name'          => 'cf7_style_2_label_font_family',
			'default_value' => '',
			'label'         => esc_html__('Font Family','topfit'),
		));

		$typography_label_row2 = topfit_mikado_add_admin_row(array(
			'name'   => 'typography_label_row2',
			'next'   => true,
			'parent' => $typography_label_group
		));


		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_label_row2,
			'type'          => 'selectsimple',
			'name'          => 'cf7_style_2_label_font_style',
			'default_value' => '',
			'label'         => esc_html__('Font Style','topfit'),
			'options'       => topfit_mikado_get_font_style_array()
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_label_row2,
			'type'          => 'selectsimple',
			'name'          => 'cf7_style_2_label_font_weight',
			'default_value' => '',
			'label'         => esc_html__('Font Weight','topfit'),
			'options'       => topfit_mikado_get_font_weight_array()
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_label_row2,
			'type'          => 'selectsimple',
			'name'          => 'cf7_style_2_label_text_transform',
			'default_value' => '',
			'label'         => esc_html__('Text Transform','topfit'),
			'options'       => topfit_mikado_get_text_transform_array()
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $typography_label_row2,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_label_letter_spacing',
			'default_value' => '',
			'label'         => esc_html__('Letter Spacing','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		// Form Elements Background and Border

		$background_border_group = topfit_mikado_add_admin_group(array(
			'name'        => 'background_border_group',
			'title'       => esc_html__('Form Elements Background and Border','topfit'),
			'description' => esc_html__('Setup form elements background and border style','topfit'),
			'parent'      => $panel_contact_form_style_2
		));

		$background_border_row1 = topfit_mikado_add_admin_row(array(
			'name'   => 'background_border_row1',
			'parent' => $background_border_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $background_border_row1,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_2_background_color',
			'default_value' => '',
			'label'         => esc_html__('Background Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $background_border_row1,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_background_transparency',
			'default_value' => '',
			'label'         => esc_html__('Background Transparency','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $background_border_row1,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_2_focus_background_color',
			'default_value' => '',
			'label'         => esc_html__('Focus Background Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $background_border_row1,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_focus_background_transparency',
			'default_value' => '',
			'label'         => esc_html__('Focus Background Transparency','topfit'),
		));

		$background_border_row2 = topfit_mikado_add_admin_row(array(
			'name'   => 'background_border_row2',
			'next'   => true,
			'parent' => $background_border_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $background_border_row2,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_2_border_color',
			'default_value' => '',
			'label'         => esc_html__('Border Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $background_border_row2,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_border_transparency',
			'default_value' => '',
			'label'         => esc_html__('Border Transparency','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $background_border_row2,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_2_focus_border_color',
			'default_value' => '',
			'label'         => esc_html__('Focus Border Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $background_border_row2,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_focus_border_transparency',
			'default_value' => '',
			'label'         => esc_html__('Focus Border Transparency','topfit'),
		));

		$background_border_row3 = topfit_mikado_add_admin_row(array(
			'name'   => 'background_border_row3',
			'next'   => true,
			'parent' => $background_border_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $background_border_row3,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_border_width',
			'default_value' => '',
			'label'         => esc_html__('Border Width','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $background_border_row3,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_border_radius',
			'default_value' => '',
			'label'         => esc_html__('Border Radius','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		// Form Elements Padding

		$padding_group = topfit_mikado_add_admin_group(array(
			'name'        => 'padding_group',
			'title'       => esc_html__('Elements Padding','topfit'),
			'description' => esc_html__('Setup form elements padding','topfit'),
			'parent'      => $panel_contact_form_style_2
		));

		$padding_row = topfit_mikado_add_admin_row(array(
			'name'   => 'padding_row',
			'parent' => $padding_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $padding_row,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_padding_top',
			'default_value' => '',
			'label'         => esc_html__('Padding Top','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $padding_row,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_padding_right',
			'default_value' => '',
			'label'         => esc_html__('Padding Right','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $padding_row,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_padding_bottom',
			'default_value' => '',
			'label'         => esc_html__('Padding Bottom','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $padding_row,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_padding_left',
			'default_value' => '',
			'label'         => esc_html__('Padding Left','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		// Form Elements Margin

		$margin_group = topfit_mikado_add_admin_group(array(
			'name'        => 'margin_group',
			'title'       => esc_html__('Elements Margin','topfit'),
			'description' => esc_html__('Setup form elements margin','topfit'),
			'parent'      => $panel_contact_form_style_2
		));

		$margin_row = topfit_mikado_add_admin_row(array(
			'name'   => 'margin_row',
			'parent' => $margin_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $margin_row,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_margin_top',
			'default_value' => '',
			'label'         => esc_html__('Margin Top','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $margin_row,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_margin_bottom',
			'default_value' => '',
			'label'         => esc_html__('Margin Bottom','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		// Textarea

		topfit_mikado_add_admin_field(array(
			'parent'        => $panel_contact_form_style_2,
			'type'          => 'text',
			'name'          => 'cf7_style_2_textarea_height',
			'default_value' => '',
			'label'         => esc_html__('Textarea Height','topfit'),
			'description'   => esc_html__('Enter height for textarea form element','topfit'),
			'args'          => array(
				'col_width' => '3',
				'suffix'    => 'px'
			)
		));

		// Button Typography

		$button_typography_group = topfit_mikado_add_admin_group(array(
			'name'        => 'button_typography_group',
			'title'       => esc_html__('Button Typography','topfit'),
			'description' => esc_html__('Setup button text typography','topfit'),
			'parent'      => $panel_contact_form_style_2
		));

		$button_typography_row1 = topfit_mikado_add_admin_row(array(
			'name'   => 'button_typography_row1',
			'parent' => $button_typography_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_typography_row1,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_2_button_color',
			'default_value' => '',
			'label'         => esc_html__('Text Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_typography_row1,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_2_button_hover_color',
			'default_value' => '',
			'label'         => esc_html__('Text Hover Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_typography_row1,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_button_font_size',
			'default_value' => '',
			'label'         => esc_html__('Font Size','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_typography_row1,
			'type'          => 'fontsimple',
			'name'          => 'cf7_style_2_button_font_family',
			'default_value' => '',
			'label'         => esc_html__('Font Family','topfit'),
		));

		$button_typography_row2 = topfit_mikado_add_admin_row(array(
			'name'   => 'button_typography_row2',
			'next'   => true,
			'parent' => $button_typography_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_typography_row2,
			'type'          => 'selectsimple',
			'name'          => 'cf7_style_2_button_font_style',
			'default_value' => '',
			'label'         => esc_html__('Font Style','topfit'),
			'options'       => topfit_mikado_get_font_style_array()
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_typography_row2,
			'type'          => 'selectsimple',
			'name'          => 'cf7_style_2_button_font_weight',
			'default_value' => '',
			'label'         => esc_html__('Font Weight','topfit'),
			'options'       => topfit_mikado_get_font_weight_array()
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_typography_row2,
			'type'          => 'selectsimple',
			'name'          => 'cf7_style_2_button_text_transform',
			'default_value' => '',
			'label'         => esc_html__('Text Transform','topfit'),
			'options'       => topfit_mikado_get_text_transform_array()
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_typography_row2,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_button_letter_spacing',
			'default_value' => '',
			'label'         => esc_html__('Letter Spacing','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		// Button Background and Border

		$button_background_border_group = topfit_mikado_add_admin_group(array(
			'name'        => 'button_background_border_group',
			'title'       => esc_html__('Button Background and Border','topfit'),
			'description' => esc_html__('Setup button background and border style','topfit'),
			'parent'      => $panel_contact_form_style_2
		));

		$button_background_border_row1 = topfit_mikado_add_admin_row(array(
			'name'   => 'button_background_border_row1',
			'parent' => $button_background_border_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_background_border_row1,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_2_button_background_color',
			'default_value' => '',
			'label'         => esc_html__('Background Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_background_border_row1,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_button_background_transparency',
			'default_value' => '',
			'label'         => esc_html__('Background Transparency','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_background_border_row1,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_2_button_hover_bckg_color',
			'default_value' => '',
			'label'         => esc_html__('Background Hover Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_background_border_row1,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_button_hover_bckg_transparency',
			'default_value' => '',
			'label'         => esc_html__('Background Hover Transparency','topfit'),
		));

		$button_background_border_row2 = topfit_mikado_add_admin_row(array(
			'name'   => 'button_background_border_row2',
			'next'   => true,
			'parent' => $button_background_border_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_background_border_row2,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_2_button_border_color',
			'default_value' => '',
			'label'         => esc_html__('Border Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_background_border_row2,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_button_border_transparency',
			'default_value' => '',
			'label'         => esc_html__('Border Transparency','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_background_border_row2,
			'type'          => 'colorsimple',
			'name'          => 'cf7_style_2_button_hover_border_color',
			'default_value' => '',
			'label'         => esc_html__('Border Hover Color','topfit'),
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_background_border_row2,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_button_hover_border_transparency',
			'default_value' => '',
			'label'         => esc_html__('Border Hover Transparency','topfit'),
		));

		$button_background_border_row3 = topfit_mikado_add_admin_row(array(
			'name'   => 'button_background_border_row3',
			'next'   => true,
			'parent' => $button_background_border_group
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_background_border_row3,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_button_border_width',
			'default_value' => '',
			'label'         => esc_html__('Border Width','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		topfit_mikado_add_admin_field(array(
			'parent'        => $button_background_border_row3,
			'type'          => 'textsimple',
			'name'          => 'cf7_style_2_button_border_radius',
			'default_value' => '',
			'label'         => esc_html__('Border Radius','topfit'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		// Button Height

		topfit_mikado_add_admin_field(array(
			'parent'        => $panel_contact_form_style_2,
			'type'          => 'text',
			'name'          => 'cf7_style_2_button_height',
			'default_value' => '',
			'label'         => esc_html__('Button Height','topfit'),
			'description'   => esc_html__('Insert form button height','topfit'),
			'args'          => array(
				'col_width' => '3',
				'suffix'    => 'px'
			)
		));

		// Button Padding

		topfit_mikado_add_admin_field(array(
			'parent'        => $panel_contact_form_style_2,
			'type'          => 'text',
			'name'          => 'cf7_style_2_button_padding',
			'default_value' => '',
			'label'         => esc_html__('Button Left/Right Padding','topfit'),
			'description'   => esc_html__('Enter value for button left and right padding','topfit'),
			'args'          => array(
				'col_width' => '3',
				'suffix'    => 'px'
			)
		));

	}

	add_action('topfit_mikado_options_map', 'topfit_mikado_contact_form_7_options_map', 18);

}