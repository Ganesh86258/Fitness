<?php
if(!function_exists('topfit_mikado_contact_form7_text_styles_1')) {
	/**
	 * Generates custom styles for Contact Form 7 elements
	 */
	function topfit_mikado_contact_form7_text_styles_1() {
		$selector = array(
			'.cf7_custom_style_1 input.wpcf7-form-control.wpcf7-text',
			'.cf7_custom_style_1 input.wpcf7-form-control.wpcf7-number',
			'.cf7_custom_style_1 input.wpcf7-form-control.wpcf7-date',
			'.cf7_custom_style_1 textarea.wpcf7-form-control.wpcf7-textarea',
			'.cf7_custom_style_1 select.wpcf7-form-control.wpcf7-select',
			'.cf7_custom_style_1 input.wpcf7-form-control.wpcf7-quiz'
		);
		$styles   = array();

		$color = topfit_mikado_options()->getOptionValue('cf7_style_1_text_color');
		if($color !== '') {
			$styles['color'] = $color;
			echo topfit_mikado_dynamic_css(
				'.cf7_custom_style_1 ::-webkit-input-placeholder',
				array('color' => $color)
			);
			echo topfit_mikado_dynamic_css(
				'.cf7_custom_style_1 :-moz-placeholder',
				array('color' => $color)
			);
			echo topfit_mikado_dynamic_css(
				'.cf7_custom_style_1 ::-moz-placeholder',
				array('color' => $color)
			);
			echo topfit_mikado_dynamic_css(
				'.cf7_custom_style_1 :-ms-input-placeholder',
				array('color' => $color)
			);
		}

		$font_size = topfit_mikado_options()->getOptionValue('cf7_style_1_text_font_size');
		if($font_size !== '') {
			$styles['font-size'] = topfit_mikado_filter_px($font_size).'px';
		}

		$line_height = topfit_mikado_options()->getOptionValue('cf7_style_1_text_line_height');
		if($line_height !== '') {
			$styles['line-height'] = topfit_mikado_filter_px($line_height).'px';
		}

		$font_family = topfit_mikado_options()->getOptionValue('cf7_style_1_text_font_family');
		if(topfit_mikado_is_font_option_valid($font_family)) {
			$styles['font-family'] = topfit_mikado_get_font_option_val($font_family);
		}

		$font_style = topfit_mikado_options()->getOptionValue('cf7_style_1_text_font_style');
		if(!empty($font_style)) {
			$styles['font-style'] = $font_style;
		}

		$font_weight = topfit_mikado_options()->getOptionValue('cf7_style_1_text_font_weight');
		if(!empty($font_weight)) {
			$styles['font-weight'] = $font_weight;
		}

		$text_transform = topfit_mikado_options()->getOptionValue('cf7_style_1_text_text_transform');
		if(!empty($text_transform)) {
			$styles['text-transform'] = $text_transform;
		}

		$letter_spacing = topfit_mikado_options()->getOptionValue('cf7_style_1_text_letter_spacing');
		if($letter_spacing !== '') {
			$styles['letter-spacing'] = topfit_mikado_filter_px($letter_spacing).'px';
		}

		$background_color   = topfit_mikado_options()->getOptionValue('cf7_style_1_background_color');
		$background_opacity = 1;
		if($background_color !== '') {
			if(topfit_mikado_options()->getOptionValue('cf7_style_1_background_transparency')) {
				$background_opacity = topfit_mikado_options()->getOptionValue('cf7_style_1_background_transparency');
			}
			$styles['background-color'] = topfit_mikado_rgba_color($background_color, $background_opacity);
		}

		$border_color   = topfit_mikado_options()->getOptionValue('cf7_style_1_border_color');
		$border_opacity = 1;
		if($border_color !== '') {
			if(topfit_mikado_options()->getOptionValue('cf7_style_1_border_transparency')) {
				$border_opacity = topfit_mikado_options()->getOptionValue('cf7_style_1_border_transparency');
			}
			$styles['border-color'] = topfit_mikado_rgba_color($border_color, $border_opacity);
		}

		$border_width = topfit_mikado_options()->getOptionValue('cf7_style_1_border_width');
		if($border_width !== '') {
			$styles['border-width'] = topfit_mikado_filter_px($border_width).'px';
		}

		$border_radius = topfit_mikado_options()->getOptionValue('cf7_style_1_border_radius');
		if($border_radius !== '') {
			$styles['border-radius'] = topfit_mikado_filter_px($border_radius).'px';
		}

		$padding_top = topfit_mikado_options()->getOptionValue('cf7_style_1_padding_top');
		if($padding_top !== '') {
			$styles['padding-top'] = topfit_mikado_filter_px($padding_top).'px';
		}

		$padding_right = topfit_mikado_options()->getOptionValue('cf7_style_1_padding_right');
		if($padding_right !== '') {
			$styles['padding-right'] = topfit_mikado_filter_px($padding_right).'px';
		}

		$padding_bottom = topfit_mikado_options()->getOptionValue('cf7_style_1_padding_bottom');
		if($padding_bottom !== '') {
			$styles['padding-bottom'] = topfit_mikado_filter_px($padding_bottom).'px';
		}

		$padding_left = topfit_mikado_options()->getOptionValue('cf7_style_1_padding_left');
		if($padding_left !== '') {
			$styles['padding-left'] = topfit_mikado_filter_px($padding_left).'px';
		}

		$margin_top = topfit_mikado_options()->getOptionValue('cf7_style_1_margin_top');
		if($margin_top !== '') {
			$styles['margin-top'] = topfit_mikado_filter_px($margin_top).'px';
		}

		$margin_bottom = topfit_mikado_options()->getOptionValue('cf7_style_1_margin_bottom');
		if($margin_bottom !== '') {
			$styles['margin-bottom'] = topfit_mikado_filter_px($margin_bottom).'px';
		}

		if(topfit_mikado_options()->getOptionValue('cf7_style_1_textarea_height')) {
			$textarea_height = topfit_mikado_options()->getOptionValue('cf7_style_1_textarea_height');
			echo topfit_mikado_dynamic_css(
				'.cf7_custom_style_1 textarea.wpcf7-form-control.wpcf7-textarea',
				array('height' => topfit_mikado_filter_px($textarea_height).'px')
			);
		}

		echo topfit_mikado_dynamic_css($selector, $styles);
	}

	add_action('topfit_mikado_style_dynamic', 'topfit_mikado_contact_form7_text_styles_1');
}

if(!function_exists('topfit_mikado_contact_form7_focus_styles_1')) {
	/**
	 * Generates custom styles for Contact Form 7 elements focus
	 */
	function topfit_mikado_contact_form7_focus_styles_1() {
		$selector = array(
			'.cf7_custom_style_1 input.wpcf7-form-control.wpcf7-text:focus',
			'.cf7_custom_style_1 input.wpcf7-form-control.wpcf7-number:focus',
			'.cf7_custom_style_1 input.wpcf7-form-control.wpcf7-date:focus',
			'.cf7_custom_style_1 textarea.wpcf7-form-control.wpcf7-textarea:focus',
			'.cf7_custom_style_1 select.wpcf7-form-control.wpcf7-select:focus',
			'.cf7_custom_style_1 input.wpcf7-form-control.wpcf7-quiz:focus'
		);
		$styles   = array();

		$color = topfit_mikado_options()->getOptionValue('cf7_style_1_focus_text_color');
		if($color !== '') {
			$styles['color'] = $color;
			echo topfit_mikado_dynamic_css(
				array(
					'.cf7_custom_style_1 input:focus::-webkit-input-placeholder',
					'.cf7_custom_style_1 textarea:focus::-webkit-input-placeholder'
				),
				array('color' => $color)
			);
			echo topfit_mikado_dynamic_css(
				array(
					'.cf7_custom_style_1 input:focus:-moz-placeholder',
					'.cf7_custom_style_1 textarea:focus:-moz-placeholder'
				),
				array('color' => $color)
			);
			echo topfit_mikado_dynamic_css(
				array(
					'.cf7_custom_style_1 input:focus::-moz-placeholder',
					'.cf7_custom_style_1 textarea:focus::-moz-placeholder'
				),
				array('color' => $color)
			);
			echo topfit_mikado_dynamic_css(
				array(
					'.cf7_custom_style_1 input:focus:-ms-input-placeholder',
					'.cf7_custom_style_1 textarea:focus:-ms-input-placeholder'
				),
				array('color' => $color)
			);
		}

		$background_color   = topfit_mikado_options()->getOptionValue('cf7_style_1_focus_background_color');
		$background_opacity = 1;
		if($background_color !== '') {
			if(topfit_mikado_options()->getOptionValue('cf7_style_1_focus_background_transparency')) {
				$background_opacity = topfit_mikado_options()->getOptionValue('cf7_style_1_focus_background_transparency');
			}
			$styles['background-color'] = topfit_mikado_rgba_color($background_color, $background_opacity);
		}

		$border_color   = topfit_mikado_options()->getOptionValue('cf7_style_1_focus_border_color');
		$border_opacity = 1;
		if($border_color !== '') {
			if(topfit_mikado_options()->getOptionValue('cf7_style_1_focus_border_transparency')) {
				$border_opacity = topfit_mikado_options()->getOptionValue('cf7_style_1_focus_border_transparency');
			}
			$styles['border-color'] = topfit_mikado_rgba_color($border_color, $border_opacity);
		}

		echo topfit_mikado_dynamic_css($selector, $styles);
	}

	add_action('topfit_mikado_style_dynamic', 'topfit_mikado_contact_form7_focus_styles_1');
}

if(!function_exists('topfit_mikado_contact_form7_label_styles_1')) {
	/**
	 * Generates custom styles for Contact Form 7 label
	 */
	function topfit_mikado_contact_form7_label_styles_1() {
		$selector = array('.cf7_custom_style_1 p');
		$styles   = array();

		$color = topfit_mikado_options()->getOptionValue('cf7_style_1_label_color');
		if($color !== '') {
			$styles['color'] = $color;
		}

		$font_size = topfit_mikado_options()->getOptionValue('cf7_style_1_label_font_size');
		if($font_size !== '') {
			$styles['font-size'] = topfit_mikado_filter_px($font_size).'px';
		}

		$line_height = topfit_mikado_options()->getOptionValue('cf7_style_1_label_line_height');
		if($line_height !== '') {
			$styles['line-height'] = topfit_mikado_filter_px($line_height).'px';
		}

		$font_family = topfit_mikado_options()->getOptionValue('cf7_style_1_label_font_family');
		if(topfit_mikado_is_font_option_valid($font_family)) {
			$styles['font-family'] = topfit_mikado_get_font_option_val($font_family);
		}

		$font_style = topfit_mikado_options()->getOptionValue('cf7_style_1_label_font_style');
		if(!empty($font_style)) {
			$styles['font-style'] = $font_style;
		}

		$font_weight = topfit_mikado_options()->getOptionValue('cf7_style_1_label_font_weight');
		if(!empty($font_weight)) {
			$styles['font-weight'] = $font_weight;
		}

		$text_transform = topfit_mikado_options()->getOptionValue('cf7_style_1_label_text_transform');
		if(!empty($text_transform)) {
			$styles['text-transform'] = $text_transform;
		}

		$letter_spacing = topfit_mikado_options()->getOptionValue('cf7_style_1_label_letter_spacing');
		if($letter_spacing !== '') {
			$styles['letter-spacing'] = topfit_mikado_filter_px($letter_spacing).'px';
		}

		echo topfit_mikado_dynamic_css($selector, $styles);
	}

	add_action('topfit_mikado_style_dynamic', 'topfit_mikado_contact_form7_label_styles_1');
}

if(!function_exists('topfit_mikado_contact_form7_button_styles_1')) {
	/**
	 * Generates custom styles for Contact Form 7 button
	 */
	function topfit_mikado_contact_form7_button_styles_1() {
		$selector = array(
			'.cf7_custom_style_1 input.wpcf7-form-control.wpcf7-submit'
		);
		$styles   = array();

		$color = topfit_mikado_options()->getOptionValue('cf7_style_1_button_color');
		if($color !== '') {
			$styles['color'] = $color;
		}

		$font_size = topfit_mikado_options()->getOptionValue('cf7_style_1_button_font_size');
		if($font_size !== '') {
			$styles['font-size'] = topfit_mikado_filter_px($font_size).'px';
		}

		$height = topfit_mikado_options()->getOptionValue('cf7_style_1_button_height');
		if($height !== '') {
			$styles['height'] = topfit_mikado_filter_px($height).'px';
		}

		$font_family = topfit_mikado_options()->getOptionValue('cf7_style_1_button_font_family');
		if(topfit_mikado_is_font_option_valid($font_family)) {
			$styles['font-family'] = topfit_mikado_get_font_option_val($font_family);
		}

		$font_style = topfit_mikado_options()->getOptionValue('cf7_style_1_button_font_style');
		if(!empty($font_style)) {
			$styles['font-style'] = $font_style;
		}

		$font_weight = topfit_mikado_options()->getOptionValue('cf7_style_1_button_font_weight');
		if(!empty($font_weight)) {
			$styles['font-weight'] = $font_weight;
		}

		$text_transform = topfit_mikado_options()->getOptionValue('cf7_style_1_button_text_transform');
		if(!empty($text_transform)) {
			$styles['text-transform'] = $text_transform;
		}

		$letter_spacing = topfit_mikado_options()->getOptionValue('cf7_style_1_button_letter_spacing');
		if($letter_spacing !== '') {
			$styles['letter-spacing'] = topfit_mikado_filter_px($letter_spacing).'px';
		}

		$background_color   = topfit_mikado_options()->getOptionValue('cf7_style_1_button_background_color');
		$background_opacity = 1;
		if($background_color !== '') {
			if(topfit_mikado_options()->getOptionValue('cf7_style_1_button_background_transparency')) {
				$background_opacity = topfit_mikado_options()->getOptionValue('cf7_style_1_button_background_transparency');
			}
			$styles['background-color'] = topfit_mikado_rgba_color($background_color, $background_opacity);
		}

		$border_color   = topfit_mikado_options()->getOptionValue('cf7_style_1_button_border_color');
		$border_opacity = 1;
		if($border_color !== '') {
			if(topfit_mikado_options()->getOptionValue('cf7_style_1_button_border_transparency')) {
				$border_opacity = topfit_mikado_options()->getOptionValue('cf7_style_1_button_border_transparency');
			}
			$styles['border-color'] = topfit_mikado_rgba_color($border_color, $border_opacity);
		}

		$border_width = topfit_mikado_options()->getOptionValue('cf7_style_1_button_border_width');
		if($border_width !== '') {
			$styles['border-width'] = topfit_mikado_filter_px($border_width).'px';
		}

		$border_radius = topfit_mikado_options()->getOptionValue('cf7_style_1_button_border_radius');
		if($border_radius !== '') {
			$styles['border-radius'] = topfit_mikado_filter_px($border_radius).'px';
		}

		$padding_left_right = topfit_mikado_options()->getOptionValue('cf7_style_1_button_padding');
		if($padding_left_right !== '') {
			$styles['padding-left']  = topfit_mikado_filter_px($padding_left_right).'px';
			$styles['padding-right'] = topfit_mikado_filter_px($padding_left_right).'px';
		}

		echo topfit_mikado_dynamic_css($selector, $styles);
	}

	add_action('topfit_mikado_style_dynamic', 'topfit_mikado_contact_form7_button_styles_1');
}

if(!function_exists('topfit_mikado_contact_form7_button_hover_styles_1')) {
	/**
	 * Generates custom styles for Contact Form 7 button
	 */
	function topfit_mikado_contact_form7_button_hover_styles_1() {
		$selector = array(
			'.cf7_custom_style_1 input.wpcf7-form-control.wpcf7-submit:not([disabled]):hover'
		);
		$styles   = array();

		$color = topfit_mikado_options()->getOptionValue('cf7_style_1_button_hover_color');
		if($color !== '') {
			$styles['color'] = $color;
		}

		$background_color   = topfit_mikado_options()->getOptionValue('cf7_style_1_button_hover_bckg_color');
		$background_opacity = 1;
		if($background_color !== '') {
			if(topfit_mikado_options()->getOptionValue('cf7_style_1_button_hover_bckg_transparency') !== '') {
				$background_opacity = topfit_mikado_options()->getOptionValue('cf7_style_1_button_hover_bckg_transparency');
			}
			$styles['background-color'] = topfit_mikado_rgba_color($background_color, $background_opacity);
		}

		$border_color   = topfit_mikado_options()->getOptionValue('cf7_style_1_button_hover_border_color');
		$border_opacity = 1;
		if($border_color !== '') {
			if(topfit_mikado_options()->getOptionValue('cf7_style_1_button_hover_border_transparency')) {
				$border_opacity = topfit_mikado_options()->getOptionValue('cf7_style_1_button_hover_border_transparency');
			}
			$styles['border-color'] = topfit_mikado_rgba_color($border_color, $border_opacity);
		}

		echo topfit_mikado_dynamic_css($selector, $styles);
	}

	add_action('topfit_mikado_style_dynamic', 'topfit_mikado_contact_form7_button_hover_styles_1');
}

if(!function_exists('topfit_mikado_contact_form7_text_styles_2')) {
	/**
	 * Generates custom styles for Contact Form 7 elements
	 */
	function topfit_mikado_contact_form7_text_styles_2() {
		$selector = array(
			'.cf7_custom_style_2 input.wpcf7-form-control.wpcf7-text',
			'.cf7_custom_style_2 input.wpcf7-form-control.wpcf7-number',
			'.cf7_custom_style_2 input.wpcf7-form-control.wpcf7-date',
			'.cf7_custom_style_2 textarea.wpcf7-form-control.wpcf7-textarea',
			'.cf7_custom_style_2 select.wpcf7-form-control.wpcf7-select',
			'.cf7_custom_style_2 input.wpcf7-form-control.wpcf7-quiz'
		);
		$styles   = array();

		$color = topfit_mikado_options()->getOptionValue('cf7_style_2_text_color');
		if($color !== '') {
			$styles['color'] = $color;
			echo topfit_mikado_dynamic_css(
				'.cf7_custom_style_2 ::-webkit-input-placeholder',
				array('color' => $color)
			);
			echo topfit_mikado_dynamic_css(
				'.cf7_custom_style_2 :-moz-placeholder',
				array('color' => $color)
			);
			echo topfit_mikado_dynamic_css(
				'.cf7_custom_style_2 ::-moz-placeholder',
				array('color' => $color)
			);
			echo topfit_mikado_dynamic_css(
				'.cf7_custom_style_2 :-ms-input-placeholder',
				array('color' => $color)
			);
		}

		$font_size = topfit_mikado_options()->getOptionValue('cf7_style_2_text_font_size');
		if($font_size !== '') {
			$styles['font-size'] = topfit_mikado_filter_px($font_size).'px';
		}

		$line_height = topfit_mikado_options()->getOptionValue('cf7_style_2_text_line_height');
		if($line_height !== '') {
			$styles['line-height'] = topfit_mikado_filter_px($line_height).'px';
		}

		$font_family = topfit_mikado_options()->getOptionValue('cf7_style_2_text_font_family');
		if(topfit_mikado_is_font_option_valid($font_family)) {
			$styles['font-family'] = topfit_mikado_get_font_option_val($font_family);
		}

		$font_style = topfit_mikado_options()->getOptionValue('cf7_style_2_text_font_style');
		if(!empty($font_style)) {
			$styles['font-style'] = $font_style;
		}

		$font_weight = topfit_mikado_options()->getOptionValue('cf7_style_2_text_font_weight');
		if(!empty($font_weight)) {
			$styles['font-weight'] = $font_weight;
		}

		$text_transform = topfit_mikado_options()->getOptionValue('cf7_style_2_text_text_transform');
		if(!empty($text_transform)) {
			$styles['text-transform'] = $text_transform;
		}

		$letter_spacing = topfit_mikado_options()->getOptionValue('cf7_style_2_text_letter_spacing');
		if($letter_spacing !== '') {
			$styles['letter-spacing'] = topfit_mikado_filter_px($letter_spacing).'px';
		}

		$background_color   = topfit_mikado_options()->getOptionValue('cf7_style_2_background_color');
		$background_opacity = 1;
		if($background_color !== '') {
			if(topfit_mikado_options()->getOptionValue('cf7_style_2_background_transparency')) {
				$background_opacity = topfit_mikado_options()->getOptionValue('cf7_style_2_background_transparency');
			}
			$styles['background-color'] = topfit_mikado_rgba_color($background_color, $background_opacity);
		}

		$border_color   = topfit_mikado_options()->getOptionValue('cf7_style_2_border_color');
		$border_opacity = 1;
		if($border_color !== '') {
			if(topfit_mikado_options()->getOptionValue('cf7_style_2_border_transparency')) {
				$border_opacity = topfit_mikado_options()->getOptionValue('cf7_style_2_border_transparency');
			}
			$styles['border-color'] = topfit_mikado_rgba_color($border_color, $border_opacity);
		}

		$border_width = topfit_mikado_options()->getOptionValue('cf7_style_2_border_width');
		if($border_width !== '') {
			$styles['border-width'] = topfit_mikado_filter_px($border_width).'px';
		}

		$border_radius = topfit_mikado_options()->getOptionValue('cf7_style_2_border_radius');
		if($border_radius !== '') {
			$styles['border-radius'] = topfit_mikado_filter_px($border_radius).'px';
		}

		$padding_top = topfit_mikado_options()->getOptionValue('cf7_style_2_padding_top');
		if($padding_top !== '') {
			$styles['padding-top'] = topfit_mikado_filter_px($padding_top).'px';
		}

		$padding_right = topfit_mikado_options()->getOptionValue('cf7_style_2_padding_right');
		if($padding_right !== '') {
			$styles['padding-right'] = topfit_mikado_filter_px($padding_right).'px';
		}

		$padding_bottom = topfit_mikado_options()->getOptionValue('cf7_style_2_padding_bottom');
		if($padding_bottom !== '') {
			$styles['padding-bottom'] = topfit_mikado_filter_px($padding_bottom).'px';
		}

		$padding_left = topfit_mikado_options()->getOptionValue('cf7_style_2_padding_left');
		if($padding_left !== '') {
			$styles['padding-left'] = topfit_mikado_filter_px($padding_left).'px';
		}

		$margin_top = topfit_mikado_options()->getOptionValue('cf7_style_2_margin_top');
		if($margin_top !== '') {
			$styles['margin-top'] = topfit_mikado_filter_px($margin_top).'px';
		}

		$margin_bottom = topfit_mikado_options()->getOptionValue('cf7_style_2_margin_bottom');
		if($margin_bottom !== '') {
			$styles['margin-bottom'] = topfit_mikado_filter_px($margin_bottom).'px';
		}

		if(topfit_mikado_options()->getOptionValue('cf7_style_2_textarea_height')) {
			$textarea_height = topfit_mikado_options()->getOptionValue('cf7_style_2_textarea_height');
			echo topfit_mikado_dynamic_css(
				'.cf7_custom_style_2 textarea.wpcf7-form-control.wpcf7-textarea',
				array('height' => topfit_mikado_filter_px($textarea_height).'px')
			);
		}

		echo topfit_mikado_dynamic_css($selector, $styles);
	}

	add_action('topfit_mikado_style_dynamic', 'topfit_mikado_contact_form7_text_styles_2');
}

if(!function_exists('topfit_mikado_contact_form7_focus_styles_2')) {
	/**
	 * Generates custom styles for Contact Form 7 elements focus
	 */
	function topfit_mikado_contact_form7_focus_styles_2() {
		$selector = array(
			'.cf7_custom_style_2 input.wpcf7-form-control.wpcf7-text:focus',
			'.cf7_custom_style_2 input.wpcf7-form-control.wpcf7-number:focus',
			'.cf7_custom_style_2 input.wpcf7-form-control.wpcf7-date:focus',
			'.cf7_custom_style_2 textarea.wpcf7-form-control.wpcf7-textarea:focus',
			'.cf7_custom_style_2 select.wpcf7-form-control.wpcf7-select:focus',
			'.cf7_custom_style_2 input.wpcf7-form-control.wpcf7-quiz:focus'
		);
		$styles   = array();

		$color = topfit_mikado_options()->getOptionValue('cf7_style_2_focus_text_color');
		if($color !== '') {
			$styles['color'] = $color;
			echo topfit_mikado_dynamic_css(
				array(
					'.cf7_custom_style_2 input:focus::-webkit-input-placeholder',
					'.cf7_custom_style_2 textarea:focus::-webkit-input-placeholder'
				),
				array('color' => $color)
			);
			echo topfit_mikado_dynamic_css(
				array(
					'.cf7_custom_style_2 input:focus:-moz-placeholder',
					'.cf7_custom_style_2 textarea:focus:-moz-placeholder'
				),
				array('color' => $color)
			);
			echo topfit_mikado_dynamic_css(
				array(
					'.cf7_custom_style_2 input:focus::-moz-placeholder',
					'.cf7_custom_style_2 textarea:focus::-moz-placeholder'
				),
				array('color' => $color)
			);
			echo topfit_mikado_dynamic_css(
				array(
					'.cf7_custom_style_2 input:focus:-ms-input-placeholder',
					'.cf7_custom_style_2 textarea:focus:-ms-input-placeholder'
				),
				array('color' => $color)
			);
		}

		$background_color   = topfit_mikado_options()->getOptionValue('cf7_style_2_focus_background_color');
		$background_opacity = 1;
		if($background_color !== '') {
			if(topfit_mikado_options()->getOptionValue('cf7_style_2_focus_background_transparency')) {
				$background_opacity = topfit_mikado_options()->getOptionValue('cf7_style_2_focus_background_transparency');
			}
			$styles['background-color'] = topfit_mikado_rgba_color($background_color, $background_opacity);
		}

		$border_color   = topfit_mikado_options()->getOptionValue('cf7_style_2_focus_border_color');
		$border_opacity = 1;
		if($border_color !== '') {
			if(topfit_mikado_options()->getOptionValue('cf7_style_2_focus_border_transparency')) {
				$border_opacity = topfit_mikado_options()->getOptionValue('cf7_style_2_focus_border_transparency');
			}
			$styles['border-color'] = topfit_mikado_rgba_color($border_color, $border_opacity);
		}

		echo topfit_mikado_dynamic_css($selector, $styles);
	}

	add_action('topfit_mikado_style_dynamic', 'topfit_mikado_contact_form7_focus_styles_2');
}

if(!function_exists('topfit_mikado_contact_form7_label_styles_2')) {
	/**
	 * Generates custom styles for Contact Form 7 label
	 */
	function topfit_mikado_contact_form7_label_styles_2() {
		$selector = array('.cf7_custom_style_2 p');
		$styles   = array();

		$color = topfit_mikado_options()->getOptionValue('cf7_style_2_label_color');
		if($color !== '') {
			$styles['color'] = $color;
		}

		$font_size = topfit_mikado_options()->getOptionValue('cf7_style_2_label_font_size');
		if($font_size !== '') {
			$styles['font-size'] = topfit_mikado_filter_px($font_size).'px';
		}

		$line_height = topfit_mikado_options()->getOptionValue('cf7_style_2_label_line_height');
		if($line_height !== '') {
			$styles['line-height'] = topfit_mikado_filter_px($line_height).'px';
		}

		$font_family = topfit_mikado_options()->getOptionValue('cf7_style_2_label_font_family');
		if(topfit_mikado_is_font_option_valid($font_family)) {
			$styles['font-family'] = topfit_mikado_get_font_option_val($font_family);
		}

		$font_style = topfit_mikado_options()->getOptionValue('cf7_style_2_label_font_style');
		if(!empty($font_style)) {
			$styles['font-style'] = $font_style;
		}

		$font_weight = topfit_mikado_options()->getOptionValue('cf7_style_2_label_font_weight');
		if(!empty($font_weight)) {
			$styles['font-weight'] = $font_weight;
		}

		$text_transform = topfit_mikado_options()->getOptionValue('cf7_style_2_label_text_transform');
		if(!empty($text_transform)) {
			$styles['text-transform'] = $text_transform;
		}

		$letter_spacing = topfit_mikado_options()->getOptionValue('cf7_style_2_label_letter_spacing');
		if($letter_spacing !== '') {
			$styles['letter-spacing'] = topfit_mikado_filter_px($letter_spacing).'px';
		}

		echo topfit_mikado_dynamic_css($selector, $styles);
	}

	add_action('topfit_mikado_style_dynamic', 'topfit_mikado_contact_form7_label_styles_2');
}

if(!function_exists('topfit_mikado_contact_form7_button_styles_2')) {
	/**
	 * Generates custom styles for Contact Form 7 button
	 */
	function topfit_mikado_contact_form7_button_styles_2() {
		$selector = array(
			'.cf7_custom_style_2 input.wpcf7-form-control.wpcf7-submit'
		);
		$styles   = array();

		$color = topfit_mikado_options()->getOptionValue('cf7_style_2_button_color');
		if($color !== '') {
			$styles['color'] = $color;
		}

		$font_size = topfit_mikado_options()->getOptionValue('cf7_style_2_button_font_size');
		if($font_size !== '') {
			$styles['font-size'] = topfit_mikado_filter_px($font_size).'px';
		}

		$height = topfit_mikado_options()->getOptionValue('cf7_style_2_button_height');
		if($height !== '') {
			$styles['height'] = topfit_mikado_filter_px($height).'px';
		}

		$font_family = topfit_mikado_options()->getOptionValue('cf7_style_2_button_font_family');
		if(topfit_mikado_is_font_option_valid($font_family)) {
			$styles['font-family'] = topfit_mikado_get_font_option_val($font_family);
		}

		$font_style = topfit_mikado_options()->getOptionValue('cf7_style_2_button_font_style');
		if(!empty($font_style)) {
			$styles['font-style'] = $font_style;
		}

		$font_weight = topfit_mikado_options()->getOptionValue('cf7_style_2_button_font_weight');
		if(!empty($font_weight)) {
			$styles['font-weight'] = $font_weight;
		}

		$text_transform = topfit_mikado_options()->getOptionValue('cf7_style_2_button_text_transform');
		if(!empty($text_transform)) {
			$styles['text-transform'] = $text_transform;
		}

		$letter_spacing = topfit_mikado_options()->getOptionValue('cf7_style_2_button_letter_spacing');
		if($letter_spacing !== '') {
			$styles['letter-spacing'] = topfit_mikado_filter_px($letter_spacing).'px';
		}

		$background_color   = topfit_mikado_options()->getOptionValue('cf7_style_2_button_background_color');
		$background_opacity = 1;
		if($background_color !== '') {
			if(topfit_mikado_options()->getOptionValue('cf7_style_2_button_background_transparency')) {
				$background_opacity = topfit_mikado_options()->getOptionValue('cf7_style_2_button_background_transparency');
			}
			$styles['background-color'] = topfit_mikado_rgba_color($background_color, $background_opacity);
		}

		$border_color   = topfit_mikado_options()->getOptionValue('cf7_style_2_button_border_color');
		$border_opacity = 1;
		if($border_color !== '') {
			if(topfit_mikado_options()->getOptionValue('cf7_style_2_button_border_transparency')) {
				$border_opacity = topfit_mikado_options()->getOptionValue('cf7_style_2_button_border_transparency');
			}
			$styles['border-color'] = topfit_mikado_rgba_color($border_color, $border_opacity);
		}

		$border_width = topfit_mikado_options()->getOptionValue('cf7_style_2_button_border_width');
		if($border_width !== '') {
			$styles['border-width'] = topfit_mikado_filter_px($border_width).'px';
		}

		$border_radius = topfit_mikado_options()->getOptionValue('cf7_style_2_button_border_radius');
		if($border_radius !== '') {
			$styles['border-radius'] = topfit_mikado_filter_px($border_radius).'px';
		}

		$padding_left_right = topfit_mikado_options()->getOptionValue('cf7_style_2_button_padding');
		if($padding_left_right !== '') {
			$styles['padding-left']  = topfit_mikado_filter_px($padding_left_right).'px';
			$styles['padding-right'] = topfit_mikado_filter_px($padding_left_right).'px';
		}

		echo topfit_mikado_dynamic_css($selector, $styles);
	}

	add_action('topfit_mikado_style_dynamic', 'topfit_mikado_contact_form7_button_styles_2');
}

if(!function_exists('topfit_mikado_contact_form7_button_hover_styles_2')) {
	/**
	 * Generates custom styles for Contact Form 7 button
	 */
	function topfit_mikado_contact_form7_button_hover_styles_2() {
		$selector = array(
			'.cf7_custom_style_2 input.wpcf7-form-control.wpcf7-submit:not([disabled]):hover'
		);
		$styles   = array();

		$color = topfit_mikado_options()->getOptionValue('cf7_style_2_button_hover_color');
		if($color !== '') {
			$styles['color'] = $color;
		}

		$background_color   = topfit_mikado_options()->getOptionValue('cf7_style_2_button_hover_bckg_color');
		$background_opacity = 1;
		if($background_color !== '') {
			if(topfit_mikado_options()->getOptionValue('cf7_style_2_button_hover_bckg_transparency') !== '') {
				$background_opacity = topfit_mikado_options()->getOptionValue('cf7_style_2_button_hover_bckg_transparency');
			}
			$styles['background-color'] = topfit_mikado_rgba_color($background_color, $background_opacity);
		}

		$border_color   = topfit_mikado_options()->getOptionValue('cf7_style_2_button_hover_border_color');
		$border_opacity = 1;
		if($border_color !== '') {
			if(topfit_mikado_options()->getOptionValue('cf7_style_2_button_hover_border_transparency')) {
				$border_opacity = topfit_mikado_options()->getOptionValue('cf7_style_2_button_hover_border_transparency');
			}
			$styles['border-color'] = topfit_mikado_rgba_color($border_color, $border_opacity);
		}

		echo topfit_mikado_dynamic_css($selector, $styles);
	}

	add_action('topfit_mikado_style_dynamic', 'topfit_mikado_contact_form7_button_hover_styles_2');
}