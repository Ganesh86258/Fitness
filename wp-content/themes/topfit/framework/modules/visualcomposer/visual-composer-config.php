<?php

/**
 * Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
 */
if (function_exists('vc_set_as_theme')) {
	vc_set_as_theme(true);
}

/**
 * Change path for overridden templates
 */
if (function_exists('vc_set_shortcodes_templates_dir')) {
	$dir = MIKADO_ROOT_DIR . '/vc-templates';
	vc_set_shortcodes_templates_dir($dir);
}

if (!function_exists('topfit_mikado_configure_visual_composer')) {
	/**
	 * Configuration for Visual Composer
	 * Hooks on vc_after_init action
	 */
	function topfit_mikado_configure_visual_composer() {

		/**
		 * Removing shortcodes
		 */
		vc_remove_element('vc_wp_search');
		vc_remove_element('vc_wp_meta');
		vc_remove_element('vc_wp_recentcomments');
		vc_remove_element('vc_wp_calendar');
		vc_remove_element('vc_wp_pages');
		vc_remove_element('vc_wp_tagcloud');
		vc_remove_element('vc_wp_custommenu');
		vc_remove_element('vc_wp_text');
		vc_remove_element('vc_wp_posts');
		vc_remove_element('vc_wp_links');
		vc_remove_element('vc_wp_categories');
		vc_remove_element('vc_wp_archives');
		vc_remove_element('vc_wp_rss');
		vc_remove_element('vc_teaser_grid');
		vc_remove_element('vc_button');
		vc_remove_element('vc_cta_button');
		vc_remove_element('vc_cta_button2');
		vc_remove_element('vc_message');
		vc_remove_element('vc_tour');
		vc_remove_element('vc_progress_bar');
		vc_remove_element('vc_pie');
		vc_remove_element('vc_posts_slider');
		vc_remove_element('vc_toggle');
		vc_remove_element('vc_images_carousel');
		vc_remove_element('vc_posts_grid');
		vc_remove_element('vc_carousel');
		vc_remove_element('vc_gmaps');
		vc_remove_element('vc_btn');
		vc_remove_element('vc_cta');
		vc_remove_element('vc_round_chart');
		vc_remove_element('vc_line_chart');
		vc_remove_element('vc_tta_accordion');
		vc_remove_element('vc_tta_tour');
		vc_remove_element('vc_tta_tabs');
		vc_remove_element('vc_separator');
		vc_remove_element("vc_section");

		/**
		 * Remove unused parameters
		 */
		if (function_exists('vc_remove_param')) {
			vc_remove_param('vc_row', 'full_width');
			vc_remove_param('vc_row', 'full_height');
			vc_remove_param('vc_row', 'content_placement');
			vc_remove_param('vc_row', 'video_bg');
			vc_remove_param('vc_row', 'video_bg_url');
			vc_remove_param('vc_row', 'video_bg_parallax');
			vc_remove_param('vc_row', 'parallax');
			vc_remove_param('vc_row', 'parallax_image');
			vc_remove_param('vc_row', 'gap');
			vc_remove_param('vc_row', 'columns_placement');
			vc_remove_param('vc_row', 'equal_height');
			vc_remove_param('vc_row', 'parallax_speed_bg');
			vc_remove_param('vc_row', 'parallax_speed_video');
			vc_remove_param('vc_row', 'disable_element');
			vc_remove_param('vc_row', 'css_animation');

			vc_remove_param('vc_row_inner', 'content_placement');
			vc_remove_param('vc_row_inner', 'equal_height');
			vc_remove_param('vc_row_inner', 'gap');
			vc_remove_param('vc_row_inner', 'disable_element');

			vc_remove_param('vc_text_separator', 'add_icon');
			vc_remove_param('vc_text_separator', 'vc_icon');
			vc_remove_param('vc_text_separator', 'i_icon_material');
			vc_remove_param('vc_text_separator', 'i_icon_monosocial');
			vc_remove_param('vc_text_separator', 'i_type');
			vc_remove_param('vc_text_separator', 'i_icon_fontawesome');
			vc_remove_param('vc_text_separator', 'i_icon_openiconic');
			vc_remove_param('vc_text_separator', 'i_icon_typicons');
			vc_remove_param('vc_text_separator', 'i_icon_entypo');
			vc_remove_param('vc_text_separator', 'i_icon_linecons');
			vc_remove_param('vc_text_separator', 'i_color');
			vc_remove_param('vc_text_separator', 'i_custom_color');
			vc_remove_param('vc_text_separator', 'i_background_color');
			vc_remove_param('vc_text_separator', 'i_background_style');
			vc_remove_param('vc_text_separator', 'i_custom_background_color');
			vc_remove_param('vc_text_separator', 'i_size');
			vc_remove_param('vc_text_separator', 'i_css_animation');
		}

	}

	add_action('vc_after_init', 'topfit_mikado_configure_visual_composer');

}


if (!function_exists('topfit_mikado_configure_visual_composer_grid_elemets')) {

	/**
	 * Configuration for Visual Composer for Grid Elements
	 * Hooks on vc_after_init action
	 */

	function topfit_mikado_configure_visual_composer_grid_elemets() {

		/**
		 * Remove Grid Elements if grid elements disabled
		 */
		vc_remove_element('vc_basic_grid');
		vc_remove_element('vc_media_grid');
		vc_remove_element('vc_masonry_grid');
		vc_remove_element('vc_masonry_media_grid');
		vc_remove_element('vc_icon');
		vc_remove_element('vc_button2');
		vc_remove_element("vc_custom_heading");


		/**
		 * Remove unused parameters from grid elements
		 */
		if (function_exists('vc_remove_param')) {
			vc_remove_param('vc_basic_grid', 'button_style');
			vc_remove_param('vc_basic_grid', 'button_color');
			vc_remove_param('vc_basic_grid', 'button_size');
			vc_remove_param('vc_basic_grid', 'filter_color');
			vc_remove_param('vc_basic_grid', 'filter_style');
			vc_remove_param('vc_media_grid', 'button_style');
			vc_remove_param('vc_media_grid', 'button_color');
			vc_remove_param('vc_media_grid', 'button_size');
			vc_remove_param('vc_media_grid', 'filter_color');
			vc_remove_param('vc_media_grid', 'filter_style');
			vc_remove_param('vc_masonry_grid', 'button_style');
			vc_remove_param('vc_masonry_grid', 'button_color');
			vc_remove_param('vc_masonry_grid', 'button_size');
			vc_remove_param('vc_masonry_grid', 'filter_color');
			vc_remove_param('vc_masonry_grid', 'filter_style');
			vc_remove_param('vc_masonry_media_grid', 'button_style');
			vc_remove_param('vc_masonry_media_grid', 'button_color');
			vc_remove_param('vc_masonry_media_grid', 'button_size');
			vc_remove_param('vc_masonry_media_grid', 'filter_color');
			vc_remove_param('vc_masonry_media_grid', 'filter_style');
			vc_remove_param('vc_basic_grid', 'paging_color');
			vc_remove_param('vc_basic_grid', 'arrows_color');
			vc_remove_param('vc_media_grid', 'paging_color');
			vc_remove_param('vc_media_grid', 'arrows_color');
			vc_remove_param('vc_masonry_grid', 'paging_color');
			vc_remove_param('vc_masonry_grid', 'arrows_color');
			vc_remove_param('vc_masonry_media_grid', 'paging_color');
			vc_remove_param('vc_masonry_media_grid', 'arrows_color');
		}
	}

	add_action('vc_after_init', 'topfit_mikado_configure_visual_composer_grid_elemets');
}


if (!function_exists('topfit_mikado_configure_visual_composer_frontend_editor')) {
	/**
	 * Configuration for Visual Composer FrontEnd Editor
	 * Hooks on vc_after_init action
	 */
	function topfit_mikado_configure_visual_composer_frontend_editor() {

		/**
		 * Remove frontend editor
		 */
		if (function_exists('vc_disable_frontend')) {
			vc_disable_frontend();
		}

	}

	add_action('vc_after_init', 'topfit_mikado_configure_visual_composer_frontend_editor');
}


if (class_exists('WPBakeryShortCodesContainer')) {
	class WPBakeryShortCode_Mkd_Elements_Holder extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Elements_Holder_Item extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Tabs extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Tab extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Tab_Slider extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Tab_Slider_Item extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Accordion extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Accordion_Tab extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Pricing_Tables extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Restaurant_Menu extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Pricing_Tables_With_Icon extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Team_Slider extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Card_Slider extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Horizontal_Timeline extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Animations_Holder extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Process_Holder extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Comparison_Pricing_Tables_Holder extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Vertical_Split_Slider extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Vertical_Split_Slider_Left_Panel extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Vertical_Split_Slider_Right_Panel extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Vertical_Split_Slider_Content_Item extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Table_Holder extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Table_Item extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Table_Content_Item extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Mini_Text_Slider extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Playlist extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Mkd_Advanced_Slider extends WPBakeryShortCodesContainer {
	}
}

if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_Mkd_Pricing_Table extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_Mkd_Restaurant_Item extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_Mkd_Pricing_Table_With_Icon extends WPBakeryShortCode {
	}

	class WPBakeryShortCodeMkd_Team_Slider_Item extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_Mkd_Card_Slider_Item extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_Mkd_Horizontal_Timeline_Item extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_Mkd_Playlist_Item extends WPBakeryShortCode {
	}
}

/*** Row ***/
if (!function_exists('topfit_mikado_vc_row_map')) {
	/**
	 * Map VC Row shortcode
	 * Hooks on vc_after_init action
	 */
	function topfit_mikado_vc_row_map() {

		$animations = array(
			esc_html__('No animation', 'topfit')                    => '',
			esc_html__('Elements Shows From Left Side', 'topfit')   => 'mkd-element-from-left',
			esc_html__('Elements Shows From Right Side', 'topfit')  => 'mkd-element-from-right',
			esc_html__('Elements Shows From Top Side', 'topfit')    => 'mkd-element-from-top',
			esc_html__('Elements Shows From Bottom Side', 'topfit') => 'mkd-element-from-bottom',
			esc_html__('Elements Shows From Fade', 'topfit')        => 'mkd-element-from-fade'
		);

		vc_add_param('vc_row', array(
			'type'       => 'dropdown',
			'class'      => '',
			'heading'    => esc_html__('Row Type', 'topfit'),
			'param_name' => 'row_type',
			'value'      => array(
				esc_html__('Row', 'topfit')      => 'row',
				esc_html__('Parallax', 'topfit') => 'parallax'
			)
		));

		vc_add_param('vc_row', array(
			'type'       => 'dropdown',
			'class'      => '',
			'heading'    => esc_html__('Content Width', 'topfit'),
			'param_name' => 'content_width',
			'value'      => array(
				esc_html__('Full Width', 'topfit') => 'full-width',
				esc_html__('In Grid', 'topfit')    => 'grid'
			)
		));

		vc_add_param('vc_row', array(
			'type'       => 'dropdown',
			'class'      => '',
			'heading'    => esc_html__('Header Style', 'topfit'),
			'param_name' => 'header_style',
			'value'      => array(
				esc_html__('Default', 'topfit') => '',
				esc_html__('Light', 'topfit')   => 'mkd-light-header',
				esc_html__('Dark', 'topfit')    => 'mkd-dark-header'
			),
			'dependency' => array(
				'element' => 'row_type',
				'value'   => array('row', 'parallax')
			)
		));

		vc_add_param('vc_row', array(
			'type'        => 'textfield',
			'class'       => '',
			'heading'     => esc_html__('Anchor ID', 'topfit'),
			'param_name'  => 'anchor',
			'value'       => '',
			'description' => esc_html__('For example "home"', 'topfit')
		));

		vc_add_param('vc_row', array(
			'type'       => 'dropdown',
			'class'      => '',
			'heading'    => esc_html__('Content Aligment', 'topfit'),
			'param_name' => 'content_aligment',
			'value'      => array(
				esc_html__('Left', 'topfit')   => 'left',
				esc_html__('Center', 'topfit') => 'center',
				esc_html__('Right', 'topfit')  => 'right'
			)
		));

		vc_add_param('vc_row', array(
			'type'        => 'dropdown',
			'class'       => '',
			'heading'     => esc_html__('Video Background', 'topfit'),
			'value'       => array(
				esc_html__('No', 'topfit')  => '',
				esc_html__('Yes', 'topfit') => 'show_video'
			),
			'param_name'  => 'video',
			'description' => '',
			'dependency'  => array(
				'element' => 'row_type',
				'value'   => array('row')
			)
		));

		vc_add_param('vc_row', array(
			'type'        => 'dropdown',
			'class'       => '',
			'heading'     => esc_html__('Video Overlay', 'topfit'),
			'value'       => array(
				esc_html__('No', 'topfit')  => '',
				esc_html__('Yes', 'topfit') => 'show_video_overlay'
			),
			'param_name'  => 'video_overlay',
			'description' => '',
			'dependency'  => array(
				'element' => 'video',
				'value'   => array('show_video')
			)
		));

		vc_add_param('vc_row', array(
			'type'        => 'attach_image',
			'class'       => '',
			'heading'     => esc_html__('Video Overlay Image (pattern)', 'topfit'),
			'value'       => '',
			'param_name'  => 'video_overlay_image',
			'description' => '',
			'dependency'  => array(
				'element' => 'video_overlay',
				'value'   => array('show_video_overlay')
			)
		));

		vc_add_param('vc_row', array(
			'type'        => 'textfield',
			'class'       => '',
			'heading'     => esc_html__('Video Background (webm) File URL', 'topfit'),
			'value'       => '',
			'param_name'  => 'video_webm',
			'description' => '',
			'dependency'  => array(
				'element' => 'video',
				'value'   => array('show_video')
			)
		));

		vc_add_param('vc_row', array(
			'type'        => 'textfield',
			'class'       => '',
			'heading'     => esc_html__('Video Background (mp4) file URL', 'topfit'),
			'value'       => '',
			'param_name'  => 'video_mp4',
			'description' => '',
			'dependency'  => array(
				'element' => 'video',
				'value'   => array('show_video')
			)
		));

		vc_add_param('vc_row', array(
			'type'        => 'textfield',
			'class'       => '',
			'heading'     => esc_html__('Video Background (ogv) file URL', 'topfit'),
			'value'       => '',
			'param_name'  => 'video_ogv',
			'description' => '',
			'dependency'  => array(
				'element' => 'video',
				'value'   => array('show_video')
			)
		));

		vc_add_param('vc_row', array(
			'type'        => 'attach_image',
			'class'       => '',
			'heading'     => esc_html__('Video Preview Image', 'topfit'),
			'value'       => '',
			'param_name'  => 'video_image',
			'description' => '',
			'dependency'  => array(
				'element' => 'video',
				'value'   => array('show_video')
			)
		));

		vc_add_param("vc_row", array(
			'type'        => 'dropdown',
			'class'       => '',
			'heading'     => esc_html__('Full Screen Height', 'topfit'),
			'param_name'  => 'full_screen_section_height',
			'value'       => array(
				esc_html__('No', 'topfit')  => 'no',
				esc_html__('Yes', 'topfit') => 'yes'
			),
			'save_always' => true,
			'dependency'  => array(
				'element' => 'row_type',
				'value'   => array('parallax')
			)
		));

		vc_add_param('vc_row', array(
			'type'       => 'dropdown',
			'class'      => '',
			'heading'    => esc_html__('Vertically Align Content In Middle', 'topfit'),
			'param_name' => 'vertically_align_content_in_middle',
			'value'      => array(
				esc_html__('No', 'topfit')  => 'no',
				esc_html__('Yes', 'topfit') => 'yes'
			),
			'dependency' => array(
				'element' => 'full_screen_section_height',
				'value'   => 'yes'
			)
		));

		vc_add_param('vc_row', array(
			'type'       => 'textfield',
			'class'      => '',
			'heading'    => esc_html__('Section Height', 'topfit'),
			'param_name' => 'section_height',
			'value'      => '',
			'dependency' => array(
				'element' => 'full_screen_section_height',
				'value'   => array('no')
			)
		));

		vc_add_param('vc_row', array(
			'type'        => 'attach_image',
			'class'       => '',
			'heading'     => esc_html__('Parallax Background image', 'topfit'),
			'value'       => '',
			'param_name'  => 'parallax_background_image',
			'description' => esc_html__('Please note that for parallax row type, background image from Design Options will not work so you should to fill this field', 'topfit'),
			'dependency'  => array(
				'element' => 'row_type',
				'value'   => array('parallax')
			)
		));

		vc_add_param('vc_row', array(
			'type'       => 'textfield',
			'class'      => '',
			'heading'    => esc_html__('Parallax speed', 'topfit'),
			'param_name' => 'parallax_speed',
			'value'      => '',
			'dependency' => array(
				'element' => 'row_type',
				'value'   => array('parallax')
			)
		));


		vc_add_param('vc_row', array(
			'type'        => 'dropdown',
			'heading'     => esc_html__('CSS Animation', 'topfit'),
			'param_name'  => 'css_animation',
			'value'       => $animations,
			'description' => '',
			'dependency'  => array(
				'element' => 'row_type',
				'value'   => array('row')
			)
		));

		vc_add_param('vc_row', array(
			'type'        => 'textfield',
			'heading'     => esc_html__('Transition delay (ms)', 'topfit'),
			'param_name'  => 'transition_delay',
			'admin_label' => true,
			'value'       => '',
			'description' => '',
			'dependency'  => array(
				'element'   => 'css_animation',
				'not_empty' => true
			)
		));

		/*** Row Inner ***/

		vc_add_param('vc_row_inner', array(
			'type'       => 'dropdown',
			'class'      => '',
			'heading'    => esc_html__('Row Type', 'topfit'),
			'param_name' => 'row_type',
			'value'      => array(
				esc_html__('Row', 'topfit')      => 'row',
				esc_html__('Parallax', 'topfit') => 'parallax'
			)
		));

		vc_add_param('vc_row_inner', array(
			'type'       => 'dropdown',
			'class'      => '',
			'heading'    => esc_html__('Content Width', 'topfit'),
			'param_name' => 'content_width',
			'value'      => array(
				esc_html__('Full Width', 'topfit') => 'full-width',
				esc_html__('In Grid', 'topfit')    => 'grid'
			)
		));

		vc_add_param("vc_row_inner", array(
			'type'        => 'dropdown',
			'class'       => '',
			'heading'     => esc_html__('Full Screen Height', 'topfit'),
			'param_name'  => 'full_screen_section_height',
			'value'       => array(
				esc_html__('No', 'topfit')  => 'no',
				esc_html__('Yes', 'topfit') => 'yes'
			),
			'save_always' => true,
			'dependency'  => array(
				'element' => 'row_type',
				'value'   => array('parallax')
			)
		));

		vc_add_param('vc_row_inner', array(
			'type'       => 'dropdown',
			'class'      => '',
			'heading'    => esc_html__('Vertically Align Content In Middle', 'topfit'),
			'param_name' => 'vertically_align_content_in_middle',
			'value'      => array(
				esc_html__('No', 'topfit')  => 'no',
				esc_html__('Yes', 'topfit') => 'yes'
			),
			'dependency' => array(
				'element' => 'full_screen_section_height',
				'value'   => 'yes'
			)
		));

		vc_add_param('vc_row_inner', array(
			'type'       => 'textfield',
			'class'      => '',
			'heading'    => esc_html__('Section Height', 'topfit'),
			'param_name' => 'section_height',
			'value'      => '',
			'dependency' => array(
				'element' => 'full_screen_section_height',
				'value'   => array('no')
			)
		));

		vc_add_param('vc_row_inner', array(
			'type'        => 'attach_image',
			'class'       => '',
			'heading'     => esc_html__('Parallax Background image', 'topfit'),
			'value'       => '',
			'param_name'  => 'parallax_background_image',
			'description' => esc_html__('Please note that for parallax row type, background image from Design Options will not work so you should to fill this field', 'topfit'),
			'dependency'  => array(
				'element' => 'row_type',
				'value'   => array('parallax')
			)
		));

		vc_add_param('vc_row_inner', array(
			'type'       => 'textfield',
			'class'      => '',
			'heading'    => esc_html__('Parallax speed', 'topfit'),
			'param_name' => 'parallax_speed',
			'value'      => '',
			'dependency' => array(
				'element' => 'row_type',
				'value'   => array('parallax')
			)
		));

		vc_add_param('vc_row_inner', array(
			'type'       => 'dropdown',
			'class'      => '',
			'heading'    => esc_html__('Content Aligment', 'topfit'),
			'param_name' => 'content_aligment',
			'value'      => array(
				esc_html__('Left', 'topfit')   => 'left',
				esc_html__('Center', 'topfit') => 'center',
				esc_html__('Right', 'topfit')  => 'right'
			)
		));

		vc_add_param('vc_row_inner', array(
			'type'        => 'dropdown',
			'heading'     => esc_html__('CSS Animation', 'topfit'),
			'param_name'  => 'css_animation',
			'admin_label' => true,
			'value'       => $animations,
			'description' => '',
			'dependency'  => array(
				'element' => 'row_type',
				'value'   => array('row')
			)
		));

		vc_add_param('vc_row_inner', array(
			'type'        => 'textfield',
			'heading'     => esc_html__('Transition delay (ms)', 'topfit'),
			'param_name'  => 'transition_delay',
			'admin_label' => true,
			'value'       => '',
			'description' => '',
			'dependency'  => array(
				'element' => 'row_type',
				'value'   => array('row')
			)
		));
	}

	add_action('vc_after_init', 'topfit_mikado_vc_row_map');
}
