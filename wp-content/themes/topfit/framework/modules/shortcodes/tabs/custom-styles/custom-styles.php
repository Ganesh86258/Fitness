<?php
if(!function_exists('topfit_mikado_tabs_typography_styles')) {
	function topfit_mikado_tabs_typography_styles() {
		$selector              = '.mkd-tabs .mkd-tabs-nav li a';
		$tabs_tipography_array = array();
		$font_family           = topfit_mikado_options()->getOptionValue('tabs_font_family');

		if(topfit_mikado_is_font_option_valid($font_family)) {
			$tabs_tipography_array['font-family'] = topfit_mikado_is_font_option_valid($font_family);
		}

		$text_transform = topfit_mikado_options()->getOptionValue('tabs_text_transform');
		if(!empty($text_transform)) {
			$tabs_tipography_array['text-transform'] = $text_transform;
		}

		$font_style = topfit_mikado_options()->getOptionValue('tabs_font_style');
		if(!empty($font_style)) {
			$tabs_tipography_array['font-style'] = $font_style;
		}

		$letter_spacing = topfit_mikado_options()->getOptionValue('tabs_letter_spacing');
		if($letter_spacing !== '') {
			$tabs_tipography_array['letter-spacing'] = topfit_mikado_filter_px($letter_spacing).'px';
		}

		$font_weight = topfit_mikado_options()->getOptionValue('tabs_font_weight');
		if(!empty($font_weight)) {
			$tabs_tipography_array['font-weight'] = $font_weight;
		}

		echo topfit_mikado_dynamic_css($selector, $tabs_tipography_array);
	}

	add_action('topfit_mikado_style_dynamic', 'topfit_mikado_tabs_typography_styles');
}

if(!function_exists('topfit_mikado_tabs_inital_color_styles')) {
	function topfit_mikado_tabs_inital_color_styles() {
		$selector = '.mkd-tabs .mkd-tabs-nav li a';
		$styles   = array();

		if(topfit_mikado_options()->getOptionValue('tabs_color')) {
			$styles['color'] = topfit_mikado_options()->getOptionValue('tabs_color');
		}
		if(topfit_mikado_options()->getOptionValue('tabs_back_color')) {
			$styles['background-color'] = topfit_mikado_options()->getOptionValue('tabs_back_color');
		}
		if(topfit_mikado_options()->getOptionValue('tabs_border_color')) {
			$styles['border-color'] = topfit_mikado_options()->getOptionValue('tabs_border_color');
		}

		echo topfit_mikado_dynamic_css($selector, $styles);
	}

	add_action('topfit_mikado_style_dynamic', 'topfit_mikado_tabs_inital_color_styles');
}
if(!function_exists('topfit_mikado_tabs_active_color_styles')) {
	function topfit_mikado_tabs_active_color_styles() {
		$selector = '.mkd-tabs .mkd-tabs-nav li.ui-state-active a, .mkd-tabs .mkd-tabs-nav li.ui-state-hover a';
		$styles   = array();

		if(topfit_mikado_options()->getOptionValue('tabs_color_active')) {
			$styles['color'] = topfit_mikado_options()->getOptionValue('tabs_color_active');
		}
		if(topfit_mikado_options()->getOptionValue('tabs_back_color_active')) {
			$styles['background-color'] = topfit_mikado_options()->getOptionValue('tabs_back_color_active');
		}
		if(topfit_mikado_options()->getOptionValue('tabs_border_color_active')) {
			$styles['border-color'] = topfit_mikado_options()->getOptionValue('tabs_border_color_active');
		}

		echo topfit_mikado_dynamic_css($selector, $styles);
	}

	add_action('topfit_mikado_style_dynamic', 'topfit_mikado_tabs_active_color_styles');
}