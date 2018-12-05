<?php

if (!function_exists('topfit_mikado_general_options_map')) {
	/**
	 * General options page
	 */
	function topfit_mikado_general_options_map() {

		topfit_mikado_add_admin_page(
			array(
				'slug'  => '',
				'title' => esc_html__('General', 'topfit'),
				'icon'  => 'icon_building'
			)
		);

		$panel_logo = topfit_mikado_add_admin_panel(
			array(
				'page'  => '',
				'name'  => 'panel_logo',
				'title' => esc_html__('Branding', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $panel_logo,
				'type'          => 'yesno',
				'name'          => 'hide_logo',
				'default_value' => 'no',
				'label'         => esc_html__('Hide Logo', 'topfit'),
				'description'   => esc_html__('Enabling this option will hide logo image', 'topfit'),
				'args'          => array(
					"dependence"             => true,
					"dependence_hide_on_yes" => "#mkd_hide_logo_container",
					"dependence_show_on_yes" => ""
				)
			)
		);

		$hide_logo_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $panel_logo,
				'name'            => 'hide_logo_container',
				'hidden_property' => 'hide_logo',
				'hidden_value'    => 'yes'
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'logo_image',
				'type'          => 'image',
				'default_value' => MIKADO_ASSETS_ROOT . "/img/logo.png",
				'label'         => esc_html__('Logo Image - Default', 'topfit'),
				'description'   => esc_html__('Choose a default logo image to display ', 'topfit'),
				'parent'        => $hide_logo_container
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'logo_image_dark',
				'type'          => 'image',
				'default_value' => MIKADO_ASSETS_ROOT . "/img/logo_black.png",
				'label'         => esc_html__('Logo Image - Dark', 'topfit'),
				'description'   => esc_html__('Choose a default logo image to display ', 'topfit'),
				'parent'        => $hide_logo_container
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'logo_image_light',
				'type'          => 'image',
				'default_value' => MIKADO_ASSETS_ROOT . "/img/logo_white.png",
				'label'         => esc_html__('Logo Image - Light', 'topfit'),
				'description'   => esc_html__('Choose a default logo image to display ', 'topfit'),
				'parent'        => $hide_logo_container
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'logo_image_sticky',
				'type'          => 'image',
				'default_value' => MIKADO_ASSETS_ROOT . "/img/logo.png",
				'label'         => esc_html__('Logo Image - Sticky', 'topfit'),
				'description'   => esc_html__('Choose a default logo image to display ', 'topfit'),
				'parent'        => $hide_logo_container
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'logo_image_mobile',
				'type'          => 'image',
				'default_value' => MIKADO_ASSETS_ROOT . "/img/logo.png",
				'label'         => esc_html__('Logo Image - Mobile', 'topfit'),
				'description'   => esc_html__('Choose a default logo image to display ', 'topfit'),
				'parent'        => $hide_logo_container
			)
		);

		$panel_design_style = topfit_mikado_add_admin_panel(
			array(
				'page'  => '',
				'name'  => 'panel_design_style',
				'title' => esc_html__('Appearance', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'google_fonts',
				'type'          => 'font',
				'default_value' => '-1',
				'label'         => esc_html__('Font Family', 'topfit'),
				'description'   => esc_html__('Choose a default Google font for your site', 'topfit'),
				'parent'        => $panel_design_style
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'additional_google_fonts',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__('Additional Google Fonts', 'topfit'),
				'description'   => '',
				'parent'        => $panel_design_style,
				'args'          => array(
					"dependence"             => true,
					"dependence_hide_on_yes" => "",
					"dependence_show_on_yes" => "#mkd_additional_google_fonts_container"
				)
			)
		);

		$additional_google_fonts_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $panel_design_style,
				'name'            => 'additional_google_fonts_container',
				'hidden_property' => 'additional_google_fonts',
				'hidden_value'    => 'no'
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'additional_google_font1',
				'type'          => 'font',
				'default_value' => '-1',
				'label'         => esc_html__('Font Family', 'topfit'),
				'description'   => esc_html__('Choose additional Google font for your site', 'topfit'),
				'parent'        => $additional_google_fonts_container
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'additional_google_font2',
				'type'          => 'font',
				'default_value' => '-1',
				'label'         => esc_html__('Font Family', 'topfit'),
				'description'   => esc_html__('Choose additional Google font for your site', 'topfit'),
				'parent'        => $additional_google_fonts_container
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'additional_google_font3',
				'type'          => 'font',
				'default_value' => '-1',
				'label'         => esc_html__('Font Family', 'topfit'),
				'description'   => esc_html__('Choose additional Google font for your site', 'topfit'),
				'parent'        => $additional_google_fonts_container
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'additional_google_font4',
				'type'          => 'font',
				'default_value' => '-1',
				'label'         => esc_html__('Font Family', 'topfit'),
				'description'   => esc_html__('Choose additional Google font for your site', 'topfit'),
				'parent'        => $additional_google_fonts_container
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'additional_google_font5',
				'type'          => 'font',
				'default_value' => '-1',
				'label'         => esc_html__('Font Family', 'topfit'),
				'description'   => esc_html__('Choose additional Google font for your site', 'topfit'),
				'parent'        => $additional_google_fonts_container
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'        => 'first_color',
				'type'        => 'color',
				'label'       => esc_html__('First Main Color', 'topfit'),
				'description' => esc_html__('Choose the most dominant theme color. Default color is #4564fd', 'topfit'),
				'parent'      => $panel_design_style
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'        => 'page_background_color',
				'type'        => 'color',
				'label'       => esc_html__('Page Background Color', 'topfit'),
				'description' => esc_html__('Choose the background color for page content. Default color is #ffffff', 'topfit'),
				'parent'      => $panel_design_style
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'        => 'comments_background_color',
				'type'        => 'color',
				'label'       => esc_html__('Comments Background Color', 'topfit'),
				'description' => esc_html__('Choose comments background color', 'topfit'),
				'parent'      => $panel_design_style
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'        => 'selection_color',
				'type'        => 'color',
				'label'       => esc_html__('Text Selection Color', 'topfit'),
				'description' => esc_html__('Choose the color users see when selecting text', 'topfit'),
				'parent'      => $panel_design_style
			)
		);

		$group_gradient = topfit_mikado_add_admin_group(array(
			'name'        => 'group_gradient',
			'title'       => esc_html__('Gradient Colors', 'topfit'),
			'description' => esc_html__('Define colors for gradient styles', 'topfit'),
			'parent'      => $panel_design_style
		));

		$row_gradient_style1 = topfit_mikado_add_admin_row(array(
			'name'   => 'row_gradient_style1',
			'parent' => $group_gradient
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'colorsimple',
			'name'          => 'gradient_style1_start_color',
			'default_value' => '#50d18e',
			'label'         => esc_html__('Style 1 - Start Color (def. #50d18e)', 'topfit'),
			'parent'        => $row_gradient_style1
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'colorsimple',
			'name'          => 'gradient_style1_end_color',
			'default_value' => '#0098ff',
			'label'         => esc_html__('Style 1 - End Color (def. #0098ff)', 'topfit'),
			'parent'        => $row_gradient_style1
		));

		$row_gradient_style2 = topfit_mikado_add_admin_row(array(
			'name'   => 'row_gradient_style2',
			'parent' => $group_gradient
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'colorsimple',
			'name'          => 'gradient_style2_start_color',
			'default_value' => '#ad6ef0',
			'label'         => esc_html__('Style 2 - Start Color (def. #ad6ef0)', 'topfit'),
			'parent'        => $row_gradient_style2
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'colorsimple',
			'name'          => 'gradient_style2_end_color',
			'default_value' => '#03a9f5',
			'label'         => esc_html__('Style 2 - End Color (def. #03a9f5)', 'topfit'),
			'parent'        => $row_gradient_style2
		));

		$row_gradient_style3 = topfit_mikado_add_admin_row(array(
			'name'   => 'row_gradient_style3',
			'parent' => $group_gradient
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'colorsimple',
			'name'          => 'gradient_style3_start_color',
			'default_value' => '#3b3860',
			'label'         => esc_html__('Style 3 - Start Color (def. #3b3860)', 'topfit'),
			'parent'        => $row_gradient_style3
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'colorsimple',
			'name'          => 'gradient_style3_end_color',
			'default_value' => '#5d569f',
			'label'         => esc_html__('Style 3 - End Color (def. #5d569f)', 'topfit'),
			'parent'        => $row_gradient_style3
		));

		$row_gradient_style4 = topfit_mikado_add_admin_row(array(
			'name'   => 'row_gradient_style4',
			'parent' => $group_gradient
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'colorsimple',
			'name'          => 'gradient_style4_start_color',
			'default_value' => '#32343a',
			'label'         => esc_html__('Style 4 - Start Color (def. #32343a)', 'topfit'),
			'parent'        => $row_gradient_style4
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'colorsimple',
			'name'          => 'gradient_style4_end_color',
			'default_value' => '#bfa155',
			'label'         => esc_html__('Style 4 - End Color (def. #bfa155)', 'topfit'),
			'parent'        => $row_gradient_style4
		));

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'boxed',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__('Boxed Layout', 'topfit'),
				'description'   => '',
				'parent'        => $panel_design_style,
				'args'          => array(
					"dependence"             => true,
					"dependence_hide_on_yes" => "",
					"dependence_show_on_yes" => "#mkd_boxed_container"
				)
			)
		);

		$boxed_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $panel_design_style,
				'name'            => 'boxed_container',
				'hidden_property' => 'boxed',
				'hidden_value'    => 'no'
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'        => 'page_background_color_in_box',
				'type'        => 'color',
				'label'       => esc_html__('Page Background Color', 'topfit'),
				'description' => esc_html__('Choose the page background color outside box.', 'topfit'),
				'parent'      => $boxed_container
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'        => 'boxed_background_image',
				'type'        => 'image',
				'label'       => esc_html__('Background Image', 'topfit'),
				'description' => esc_html__('Choose an image to be displayed in background', 'topfit'),
				'parent'      => $boxed_container
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'        => 'boxed_pattern_background_image',
				'type'        => 'image',
				'label'       => esc_html__('Background Pattern', 'topfit'),
				'description' => esc_html__('Choose an image to be used as background pattern', 'topfit'),
				'parent'      => $boxed_container
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'boxed_background_image_attachment',
				'type'          => 'select',
				'default_value' => 'fixed',
				'label'         => esc_html__('Background Image Attachment', 'topfit'),
				'description'   => esc_html__('Choose background image attachment', 'topfit'),
				'parent'        => $boxed_container,
				'options'       => array(
					'fixed'  => esc_html__('Fixed', 'topfit'),
					'scroll' => esc_html__('Scroll', 'topfit')
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'initial_content_width',
				'type'          => 'select',
                'parent'        => $panel_design_style,
				'default_value' => 'grid-1300',
				'label'         => esc_html__('Initial Width of Content', 'topfit'),
				'description'   => esc_html__('Choose the initial width of content which is in grid (Applies to pages set to "Default Template" and rows set to "In Grid"', 'topfit'),
				'options'       => array(
					"grid-1300" => esc_html__("1300px - default", 'topfit'),
					"grid-1200" => esc_html__("1200px", 'topfit'),
					""          => esc_html__("1100px", 'topfit'),
					"grid-1000" => esc_html__("1000px", 'topfit'),
					"grid-800"  => esc_html__("800px", 'topfit'),
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'        => 'preload_pattern_image',
				'type'        => 'image',
				'label'       => esc_html__('Preload Pattern Image', 'topfit'),
				'description' => esc_html__('Choose preload pattern image to be displayed until images are loaded ', 'topfit'),
				'parent'      => $panel_design_style
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'        => 'element_appear_amount',
				'type'        => 'text',
				'label'       => esc_html__('Element Appearance', 'topfit'),
				'description' => esc_html__('For animated elements, set distance (related to browser bottom) to start the animation', 'topfit'),
				'parent'      => $panel_design_style,
				'args'        => array(
					'col_width' => 2,
					'suffix'    => 'px'
				)
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'enable_paspartu',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__('Passepartout', 'topfit'),
				'description'   => esc_html__('Enabling this option will display passepartout around site content', 'topfit'),
				'parent'        => $panel_design_style,
				'args'          => array(
					"dependence"             => true,
					"dependence_hide_on_yes" => "",
					"dependence_show_on_yes" => "#mkd_paspartu_container"
				)
			)
		);

		$paspartu_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $panel_design_style,
				'name'            => 'paspartu_container',
				'hidden_property' => 'enable_paspartu',
				'hidden_value'    => 'no'
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'paspartu_color',
				'type'          => 'color',
				'default_value' => '',
				'label'         => esc_html__('Passepartout Color', 'topfit'),
				'description'   => esc_html__('Choose passepartout color. Default value is #fff', 'topfit'),
				'parent'        => $paspartu_container,
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'paspartu_size',
				'type'          => 'text',
				'default_value' => '',
				'label'         => esc_html__('Passepartout Size', 'topfit'),
				'description'   => esc_html__('Enter size amount for passepartout.Default value is 15px', 'topfit'),
				'parent'        => $paspartu_container,
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		topfit_mikado_add_admin_field(
			array(
				'name'          => 'paspartu_mobile_size',
				'type'          => 'text',
				'default_value' => '',
				'label'         => esc_html__('Passepartout Size on Mobile Devices', 'topfit'),
				'description'   => esc_html__('Enter size amount for passepartout on mobile devices. Default value is 10px', 'topfit'),
				'parent'        => $paspartu_container,
				'args'          => array(
					'col_width' => 3
				)
			)
		);


		$panel_settings = topfit_mikado_add_admin_panel(
			array(
				'page'  => '',
				'name'  => 'panel_settings',
				'title' => esc_html__('Behavior', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'smooth_scroll',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__('Smooth Scroll', 'topfit'),
				'description'   => esc_html__('Enabling this option will perform a smooth scrolling effect on every page (except on Mac and touch devices)', 'topfit'),
				'parent'        => $panel_settings
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'smooth_page_transitions',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__('Smooth Page Transitions', 'topfit'),
				'description'   => esc_html__('Enabling this option will perform a smooth transition between pages when clicking on links.', 'topfit'),
				'parent'        => $panel_settings,
				'args'          => array(
					"dependence"             => true,
					"dependence_hide_on_yes" => "",
					"dependence_show_on_yes" => "#mkd_page_transitions_container, #mkd_svg_path_container"
				)
			)
		);

		$page_transitions_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $panel_settings,
				'name'            => 'page_transitions_container',
				'hidden_property' => 'smooth_page_transitions',
				'hidden_value'    => 'no'
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'   => 'smooth_pt_bgnd_color',
				'type'   => 'color',
				'label'  => esc_html__('Page Loader Background Color', 'topfit'),
				'parent' => $page_transitions_container
			)
		);

		$group_pt_spinner_animation = topfit_mikado_add_admin_group(array(
			'name'        => 'group_pt_spinner_animation',
			'title'       => esc_html__('Loader Style', 'topfit'),
			'description' => esc_html__('Define styles for loader spinner animation', 'topfit'),
			'parent'      => $page_transitions_container
		));

		$row_pt_spinner_animation = topfit_mikado_add_admin_row(array(
			'name'   => 'row_pt_spinner_animation',
			'parent' => $group_pt_spinner_animation
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'selectsimple',
			'name'          => 'smooth_pt_spinner_type',
			'default_value' => 'svg_spinner',
			'label'         => esc_html__('Spinner Type', 'topfit'),
			'parent'        => $row_pt_spinner_animation,
			'options'       => array(
					"filling_circle" => esc_html__("Filling Circle", 'topfit'),
					"svg_spinner" => esc_html__("SVG Spinner", 'topfit'),
				    "pulse" => esc_html__("Pulse", "topfit"),
				    "double_pulse" => esc_html__("Double Pulse", "topfit"),
				    "cube" => esc_html__("Cube", "topfit"),
				    "rotating_cubes" => esc_html__("Rotating Cubes", "topfit"),
				    "stripes" => esc_html__("Stripes", "topfit"),
				    "wave" =>esc_html__( "Wave", "topfit"),
				    "two_rotating_circles" => esc_html__("2 Rotating Circles", "topfit"),
				    "five_rotating_circles" => esc_html__("5 Rotating Circles", "topfit"),
				    "atom" => esc_html__("Atom", "topfit"),
				    "clock" => esc_html__("Clock", "topfit"),
				    "mitosis" => esc_html__("Mitosis", "topfit"),
				    "lines" => esc_html__("Lines", "topfit"),
				    "fussion" => esc_html__("Fussion", "topfit"),
				    "wave_circles" => esc_html__("Wave Circles", "topfit"),
				    "pulse_circles" => esc_html__("Pulse Circles", "topfit")
				),
				'args'          => array(
				    "dependence"             => true,
				    'show'        => array(
				    	"filling_circle"		=> "",
						"svg_spinner"    		=> "#mkd_svg_path_container",
				        "pulse"                 => "",
				        "double_pulse"          => "",
				        "cube"                  => "",
				        "rotating_cubes"        => "",
				        "stripes"               => "",
				        "wave"                  => "",
				        "two_rotating_circles"  => "",
				        "five_rotating_circles" => "",
				        "atom"                  => "",
				        "clock"                 => "",
				        "mitosis"               => "",
				        "lines"                 => "",
				        "fussion"               => "",
				        "wave_circles"          => "",
				        "pulse_circles"         => ""
				    ),
				    'hide'        => array(
				        ""                 		=> "#mkd_svg_path_container",
				        "filling_circle"		=> "#mkd_svg_path_container",
				        "pulse"                 => "#mkd_svg_path_container",
				        "double_pulse"          => "#mkd_svg_path_container",
				        "cube"                  => "#mkd_svg_path_container",
				        "rotating_cubes"        => "#mkd_svg_path_container",
				        "stripes"               => "#mkd_svg_path_container",
				        "wave"                  => "#mkd_svg_path_container",
				        "two_rotating_circles"  => "#mkd_svg_path_container",
				        "five_rotating_circles" => "#mkd_svg_path_container",
				        "atom"                  => "#mkd_svg_path_container",
				        "clock"                 => "#mkd_svg_path_container",
				        "mitosis"               => "#mkd_svg_path_container",
				        "lines"                 => "#mkd_svg_path_container",
				        "fussion"               => "#mkd_svg_path_container",
				        "wave_circles"          => "#mkd_svg_path_container",
				        "pulse_circles"         => "#mkd_svg_path_container"
				    )
				)
		));

		topfit_mikado_add_admin_field(array(
			'type'          => 'colorsimple',
			'name'          => 'smooth_pt_spinner_color',
			'default_value' => '',
			'label'         => esc_html__('Spinner Color', 'topfit'),
			'parent'        => $row_pt_spinner_animation
		));

		$mkd_svg_path_container = topfit_mikado_add_admin_container(
		    array(
		        'parent'          => $panel_settings,
		        'name'            => 'svg_path_container',
		        'hidden_property' => 'smooth_pt_spinner_type',
		        'hidden_value'    => '',
		        'hidden_values'   =>array(
		            "",
		            "filling_circle",
		            "pulse",
		            "double_pulse",
		            "cube",
		            "rotating_cubes",
		            "stripes",
		            "wave",
		            "two_rotating_circles",
		            "five_rotating_circles",
		            "atom",
		            "clock",
		            "mitosis",
		            "lines",
		            "fussion",
		            "wave_circles",
		            "pulse_circles"
		        )
		    )
		);

		$group_pt_spinner_svg_path = topfit_mikado_add_admin_group(array(
		    'name'          => 'group_pt_spinner_svg_path',
		    'title'         => esc_html__('SVG Path', 'topfit'),
		    'parent'        => $mkd_svg_path_container
		));

		$row_pt_spinner_svg_path = topfit_mikado_add_admin_row(array(
		    'name'      => 'row_pt_spinner_additional_color',
		    'parent'    => $group_pt_spinner_svg_path
		));

		topfit_mikado_add_admin_field(
		    array(
		        'type'          => 'textarea',
		        'name'          => 'smooth_pt_spinner_svg_path',
		        'default_value' => '
		        <path d="M225,104.5c-58,0-105.3,47.2-105.3,105.3c0,5.7,4.6,10.4,10.4,10.4s10.4-4.6,10.4-10.4
		        	c0-46.6,37.9-84.5,84.5-84.5c46.6,0,84.5,37.9,84.5,84.5c0,9-1.4,17.8-4.1,26.2h-29.2l-42.1-75.4c-1.8-3.3-5.3-5.3-9.1-5.3
		        	c-3.8,0-7.2,2-9.1,5.3L173.8,236h-36.4c-5.7,0-10.4,4.7-10.4,10.4c0,1.4,0.3,2.7,0.8,4c16.4,39.3,54.6,64.6,97.1,64.6
		        	c26,0,50.9-9.5,70.2-26.8c4.3-3.8,4.6-10.4,0.8-14.7c-3.8-4.3-10.4-4.6-14.7-0.8c-15.5,13.9-35.5,21.5-56.4,21.5
		        	c-28.6,0-54.8-14.3-70.3-37.5h25.2c3.8,0,7.2-2,9.1-5.3l11.8-21.1c0.3,0,0.6,0,0.9,0h45.2c0.8,0,1.6-0.1,2.3-0.3l11.9,21.3
		        	c1.8,3.3,5.3,5.3,9.1,5.3h42.5c4.6,0,8.6-3,9.9-7.3c5.2-12.6,7.8-26,7.8-39.7C330.3,151.7,283,104.5,225,104.5z M211,212l14-25.2
		        	l14,25.2H211z"/>
		        ',
		        'label'         => esc_html__('Paste SVG path here', 'topfit'),
		        'parent'        => $row_pt_spinner_svg_path,
		    )
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'elements_animation_on_touch',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__('Elements Animation on Mobile/Touch Devices', 'topfit'),
				'description'   => esc_html__('Enabling this option will allow elements (shortcodes) to animate on mobile / touch devices', 'topfit'),
				'parent'        => $panel_settings
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'show_back_button',
				'type'          => 'yesno',
				'default_value' => 'yes',
				'label'         => esc_html__('Show "Back To Top Button"', 'topfit'),
				'description'   => esc_html__('Enabling this option will display a Back to Top button on every page', 'topfit'),
				'parent'        => $panel_settings
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'          => 'responsiveness',
				'type'          => 'yesno',
				'default_value' => 'yes',
				'label'         => esc_html__('Responsiveness', 'topfit'),
				'description'   => esc_html__('Enabling this option will make all pages responsive', 'topfit'),
				'parent'        => $panel_settings
			)
		);

		$panel_custom_code = topfit_mikado_add_admin_panel(
			array(
				'page'  => '',
				'name'  => 'panel_custom_code',
				'title' => esc_html__('Custom Code', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'        => 'custom_css',
				'type'        => 'textarea',
				'label'       => esc_html('Custom CSS', 'topfit'),
				'description' => esc_html('Enter your custom CSS here', 'topfit'),
				'parent'      => $panel_custom_code
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'        => 'custom_js',
				'type'        => 'textarea',
				'label'       => esc_html__('Custom JS', 'topfit'),
				'description' => esc_html__('Enter your custom Javascript here', 'topfit'),
				'parent'      => $panel_custom_code
			)
		);

		$panel_google_api = topfit_mikado_add_admin_panel(
			array(
				'page'  => '',
				'name'  => 'panel_google_api',
				'title' => esc_html__('Google API', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'        => 'google_maps_api_key',
				'type'        => 'text',
				'label'       => esc_html__('Google Maps Api Key', 'topfit'),
				'description' => esc_html__('Insert your Google Maps API key here. For instructions on how to create a Google Maps API key, please refer to our to our documentation.', 'topfit'),
				'parent'      => $panel_google_api
			)
		);
	}

	add_action('topfit_mikado_options_map', 'topfit_mikado_general_options_map', 1);

}