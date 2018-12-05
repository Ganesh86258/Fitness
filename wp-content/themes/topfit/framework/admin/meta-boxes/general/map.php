<?php

if (!function_exists('topfit_mikado_general_meta_box_map')) {
	function topfit_mikado_general_meta_box_map() {

		$general_meta_box = topfit_mikado_add_meta_box(
			array(
				'scope' => array('page', 'portfolio-item', 'post', 'tribe_events', 'tt-events', 'events'),
				'title' => esc_html__('General', 'topfit'),
				'name'  => 'general_meta'
			)
		);


		topfit_mikado_add_meta_box_field(
			array(
				'name'          => 'mkd_first_color_meta',
				'type'          => 'color',
				'default_value' => '',
				'label'         => esc_html__('Page Main Color', 'topfit'),
				'description'   => esc_html__('Choose page main color', 'topfit'),
				'parent'        => $general_meta_box
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'          => 'mkd_page_background_color_meta',
				'type'          => 'color',
				'default_value' => '',
				'label'         => esc_html__('Page Background Color', 'topfit'),
				'description'   => esc_html__('Choose background color for page content', 'topfit'),
				'parent'        => $general_meta_box
			)
		);

		topfit_mikado_add_meta_box_field(array(
			'name'          => 'mkd_comments_background_color_meta',
			'type'          => 'color',
			'label'         => esc_html__('Comments Background Color', 'topfit'),
			'description'   => esc_html__('Choose comments background color', 'topfit'),
			'parent'        => $general_meta_box,
		));

		topfit_mikado_add_meta_box_field(
			array(
				'name'          => 'mkd_page_padding_meta',
				'type'          => 'text',
				'default_value' => '',
				'label'         => esc_html__('Page Padding', 'topfit'),
				'description'   => esc_html__('Insert padding in format 10px 10px 10px 10px', 'topfit'),
				'parent'        => $general_meta_box
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'          => 'mkd_page_content_behind_header_meta',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__('Always put content behind header', 'topfit'),
				'description'   => esc_html__('Enabling this option will put page content behind page header', 'topfit'),
				'parent'        => $general_meta_box,
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'          => 'mkd_enable_paspartu_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__('Passepartout', 'topfit'),
				'description'   => esc_html__('Enabling this option will display passepartout around site content', 'topfit'),
				'parent'        => $general_meta_box,
				'options'       => array(
					''    => '',
					'no'  => esc_html__('No', 'topfit'),
					'yes' => esc_html__('Yes', 'topfit')
				),
				'args'          => array(
					'dependence' => true,
					'hide'       => array(
						''    => '',
						'no'  => '#mkd_mkd_paspartu_meta_container',
						'yes' => ''
					),
					'show'       => array(
						''    => '#mkd_mkd_paspartu_meta_container',
						'no'  => '',
						'yes' => '#mkd_mkd_paspartu_meta_container'
					)
				)
			)
		);

		$paspartu_meta_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $general_meta_box,
				'name'            => 'mkd_paspartu_meta_container',
				'hidden_property' => 'mkd_enable_paspartu_meta',
				'hidden_values'   => array('', 'no')
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'          => 'mkd_paspartu_color_meta',
				'type'          => 'color',
				'default_value' => '',
				'label'         => esc_html__('Passepartout Color', 'topfit'),
				'description'   => esc_html__('Choose passepartout color. Default value is #fff', 'topfit'),
				'parent'        => $paspartu_meta_container,
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'          => 'mkd_paspartu_size_meta',
				'type'          => 'text',
				'default_value' => '',
				'label'         => esc_html__('Passepartout Size', 'topfit'),
				'description'   => esc_html__('Enter size amount for passepartout.Default value is 15px', 'topfit'),
				'parent'        => $paspartu_meta_container,
				'args'          => array(
					'col_width' => 3
				)
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'          => 'mkd_page_slider_meta',
				'type'          => 'text',
				'default_value' => '',
				'label'         => esc_html__('Slider Shortcode', 'topfit'),
				'description'   => esc_html__('Paste your slider shortcode here', 'topfit'),
				'parent'        => $general_meta_box
			)
		);

		if (topfit_mikado_options()->getOptionValue('smooth_pt_true_ajax') === 'yes') {
			topfit_mikado_add_meta_box_field(
				array(
					'name'          => 'mkd_page_transition_type',
					'type'          => 'selectblank',
					'label'         => esc_html__('Page Transition', 'topfit'),
					'description'   => esc_html__('Choose the type of transition to this page', 'topfit'),
					'parent'        => $general_meta_box,
					'default_value' => '',
					'options'       => array(
						'no-animation' => esc_html__('No animation', 'topfit'),
						'fade'         => esc_html__('Fade', 'topfit')
					)
				)
			);
		}

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_page_comments_meta',
				'type'        => 'selectblank',
				'label'       => esc_html__('Show Comments', 'topfit'),
				'description' => esc_html__('Enabling this option will show comments on your page', 'topfit'),
				'parent'      => $general_meta_box,
                'default_value' => '',
				'options'     => array(
					'yes' => esc_html__('Yes', 'topfit'),
					'no'  => esc_html__('No', 'topfit')
				)
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'          => 'mkd_boxed_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__('Boxed Layout', 'topfit'),
				'description'   => '',
				'parent'        => $general_meta_box,
				'options'       => array(
					''    => '',
					'yes' => esc_html__('Yes', 'topfit'),
					'no'  => esc_html__('No', 'topfit'),
				),
				'args'          => array(
					"dependence" => true,
					'show'       => array(
						''    => '',
						'yes' => '#mkd_mkd_boxed_container_meta',
						'no'  => '',

					),
					'hide'       => array(
						''    => '#mkd_mkd_boxed_container_meta',
						'yes' => '',
						'no'  => '#mkd_mkd_boxed_container_meta',
					)
				)
			)
		);

		$boxed_container = topfit_mikado_add_admin_container(
			array(
				'parent'          => $general_meta_box,
				'name'            => 'mkd_boxed_container_meta',
				'hidden_property' => 'mkd_boxed_meta',
				'hidden_values'   => array('', 'no')
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_page_background_color_in_box_meta',
				'type'        => 'color',
				'label'       => esc_html__('Page Background Color', 'topfit'),
				'description' => esc_html__('Choose the page background color outside box.', 'topfit'),
				'parent'      => $boxed_container
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_boxed_pattern_background_image_meta',
				'type'        => 'image',
				'label'       => esc_html__('Background Pattern', 'topfit'),
				'description' => esc_html__('Choose an image to be used as background pattern', 'topfit'),
				'parent'      => $boxed_container
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_boxed_background_image_meta',
				'type'        => 'image',
				'label'       => esc_html__('Background Image', 'topfit'),
				'description' => esc_html__('Choose an image to be displayed in background', 'topfit'),
				'parent'      => $boxed_container,
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'          => 'mkd_boxed_background_image_attachment_meta',
				'type'          => 'select',
				'default_value' => 'fixed',
				'label'         => esc_html__('Background Image Attachment', 'topfit'),
				'description'   => esc_html__('Choose background image attachment if background image option is set', 'topfit'),
				'parent'        => $boxed_container,
				'options'       => array(
					'fixed'  => esc_html__('Fixed', 'topfit'),
					'scroll' => esc_html__('Scroll', 'topfit')
				)
			)
		);

	}

	add_action('topfit_mikado_meta_boxes_map', 'topfit_mikado_general_meta_box_map');
}