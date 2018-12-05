<?php

if (!function_exists('topfit_mikado_footer_meta_box_map')) {
	function topfit_mikado_footer_meta_box_map() {

		$mkd_custom_widgets = topfit_mikado_get_custom_sidebars();
		$footer_meta_box = topfit_mikado_add_meta_box(
			array(
				'scope' => array('page', 'portfolio-item', 'post'),
				'title' => esc_html__('Footer', 'topfit'),
				'name'  => 'footer_meta'
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'          => 'mkd_enable_footer_image_meta',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__('Disable Footer Image for this Page', 'topfit'),
				'description'   => esc_html__('Enabling this option will hide footer image on this page', 'topfit'),
				'parent'        => $footer_meta_box,
				'args'          => array(
					'dependence'             => true,
					'dependence_hide_on_yes' => '#mkd_mkd_footer_background_image_meta',
					'dependence_show_on_yes' => ''
				)
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'            => 'mkd_footer_background_image_meta',
				'type'            => 'image',
				'label'           => esc_html__('Background Image', 'topfit'),
				'description'     => esc_html__('Choose Background Image for Footer Area on this page', 'topfit'),
				'parent'          => $footer_meta_box,
				'hidden_property' => 'mkd_enable_footer_image_meta',
				'hidden_value'    => 'yes'
			)
		);
		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_footer_background_color_meta',
				'type'        => 'color',
				'label'       => esc_html__('Background Color', 'topfit'),
				'description' => esc_html__('Choose Background Color for Footer Area on this page', 'topfit'),
				'parent'      => $footer_meta_box
			)
		);
		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_footer_background_color_transparency_meta',
				'type'        => 'text',
				'label'       => esc_html__('Background Color Transparency', 'topfit'),
				'description' => esc_html__('Choose Background Color Transparency(0-1) for Footer Area on this page', 'topfit'),
				'parent'      => $footer_meta_box,
				'args'        => array(
					'col_width' => 2
				)
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'type'          => 'select',
				'name'          => 'mkd_disable_footer_meta',
				'default_value' => '',
				'label'         => esc_html__('Disable Footer for this Page', 'topfit'),
				'description'   => esc_html__('Enabling this option will hide footer on this page', 'topfit'),
				'options'       => array(
					''    => esc_html__('Default', 'topfit'),
					'yes' => 'Yes',
					'no'  => 'No'
				),
				'parent'        => $footer_meta_box,
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'type'          => 'select',
				'name'          => 'mkd_uncovering_footer_meta',
				'default_value' => '',
				'label'         => esc_html__('Uncovering Footer', 'topfit'),
				'description'   => esc_html__('Enabling this option will make Footer gradually appear on scroll', 'topfit'),
				'options'       => array(
					''    => esc_html__('Default', 'topfit'),
					'yes' => 'Yes',
					'no'  => 'No'
				),
				'parent'        => $footer_meta_box,
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'type'          => 'select',
				'name'          => 'mkd_footer_in_grid_meta',
				'default_value' => '',
				'label'         => esc_html__('Footer in Grid', 'topfit'),
				'description'   => esc_html__('Enabling this option will place Footer content in grid', 'topfit'),
				'options'       => array(
					''    => esc_html__('Default', 'topfit'),
					'yes' => 'Yes',
					'no'  => 'No'
				),
				'parent'        => $footer_meta_box,
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'type'          => 'select',
				'name'          => 'mkd_show_footer_top_meta',
				'default_value' => '',
				'label'         => esc_html__('Show Footer Top', 'topfit'),
				'description'   => esc_html__('Enabling this option will show Footer Top area', 'topfit'),
				'options'       => array(
					''    => esc_html__('Default', 'topfit'),
					'yes' => 'Yes',
					'no'  => 'No'
				),
				'args'          => array(
					"dependence" => true,
					"hide"       => array(
						""    => "",
						"no"  => "#mkd_mkd_show_footer_top_container_meta",
						"yes" => ""
					),
					"show"       => array(
						""    => "#mkd_mkd_show_footer_top_container_meta",
						"no"  => "",
						"yes" => "#mkd_mkd_show_footer_top_container_meta"
					)
				),
				'parent'        => $footer_meta_box,
			)
		);

		$show_footer_top_container = topfit_mikado_add_admin_container(
			array(
				'name'            => 'mkd_show_footer_top_container_meta',
				'hidden_property' => 'mkd_show_footer_top_meta',
				'hidden_value'    => 'no',
				'parent'          => $footer_meta_box
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'type'          => 'select',
				'name'          => 'mkd_footer_top_columns_meta',
				'default_value' => '',
				'label'         => esc_html__('Footer Top Columns', 'topfit'),
				'description'   => esc_html__('Choose number of columns for Footer Top area', 'topfit'),
				'options'       => array(
					''  => esc_html__('Default', 'topfit'),
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'5' => '3(25%+25%+50%)',
					'6' => '3(50%+25%+25%)',
					'4' => '4'
				),
				'parent'        => $show_footer_top_container,
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'type'          => 'select',
				'name'          => 'mkd_footer_top_columns_alignment_meta',
				'default_value' => '',
				'label'         => esc_html__('Footer Top Columns Alignment', 'topfit'),
				'description'   => esc_html__('Text Alignment in Footer Columns', 'topfit'),
				'options'       => array(
					''       => esc_html__('Default', 'topfit'),
					'left'   => esc_html__('Left', 'topfit'),
					'center' => esc_html__('Center', 'topfit'),
					'right'  => esc_html__('Right', 'topfit')
				),
				'parent'        => $show_footer_top_container
			)
		);


		topfit_mikado_add_meta_box_field(
			array(
				'type'          => 'select',
				'name'          => 'mkd_show_footer_bottom_meta',
				'default_value' => '',
				'label'         => esc_html__('Show Footer Bottom', 'topfit'),
				'description'   => esc_html__('Enabling this option will show Footer Bottom area', 'topfit'),
				'options'       => array(
					''    => esc_html__('Default', 'topfit'),
					'yes' => 'Yes',
					'no'  => 'No'
				),
				'args'          => array(
					"dependence" => true,
					"hide"       => array(
						""    => "",
						"no"  => "#mkd_mkd_show_footer_bottom_container_meta",
						"yes" => ""
					),
					"show"       => array(
						""    => "#mkd_mkd_show_footer_bottom_container_meta",
						"no"  => "",
						"yes" => "#mkd_mkd_show_footer_bottom_container_meta"
					)
				),
				'parent'        => $footer_meta_box,
			)
		);

		$show_footer_bottom_container = topfit_mikado_add_admin_container(
			array(
				'name'            => 'mkd_show_footer_bottom_container_meta',
				'hidden_property' => 'mkd_show_footer_bottom_meta',
				'hidden_value'    => 'no',
				'parent'          => $footer_meta_box
			)
		);


		topfit_mikado_add_meta_box_field(
			array(
				'type'          => 'select',
				'name'          => 'mkd_footer_bottom_columns_meta',
				'default_value' => '',
				'label'         => esc_html__('Footer Bottom Columns', 'topfit'),
				'description'   => esc_html__('Choose number of columns for Footer Bottom area', 'topfit'),
				'options'       => array(
					''  => esc_html__('Default', 'topfit'),
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '3 (25%+50%+25%)',
				),
				'parent'        => $show_footer_bottom_container,
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'type'          => 'select',
				'name'          => 'mkd_footer_bottom_border_meta',
				'default_value' => '',
				'label'         => esc_html__('Border Top', 'topfit'),
				'description'   => esc_html__('Enable Border Top', 'topfit'),
				'options'       => array(
					'no'  => esc_html__('No', 'topfit'),
					'yes' => esc_html__('Yes', 'topfit'),
				),
				'parent'        => $show_footer_bottom_container,
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'type'          => 'yesno',
				'name'          => 'show_footer_custom_widget_areas',
				'default_value' => 'no',
				'label'         => esc_html__('Use Custom Widget Areas in Footer', 'topfit'),
				'description'   => '',
				'args'          => array(
					'dependence'             => true,
					'dependence_hide_on_yes' => '',
					'dependence_show_on_yes' => '#mkd_footer_custom_widget_areas'
				),
				'parent'        => $footer_meta_box,
			)
		);

		$show_footer_custom_widget_areas = topfit_mikado_add_admin_container(
			array(
				'name'            => 'footer_custom_widget_areas',
				'hidden_property' => 'show_footer_custom_widget_areas',
				'hidden_value'    => 'no',
				'parent'          => $footer_meta_box
			)
		);

		$top_cols_num = 4;

		for ($i = 1; $i <= $top_cols_num; $i++) {

			topfit_mikado_add_meta_box_field(array(
				'name'        => 'mkd_footer_top_meta_' . $i,
				'type'        => 'selectblank',
				'label'       => esc_html__('Choose Widget Area in Footer Top Column ', 'topfit') . $i,
				'description' => esc_html__('Choose Custom Widget area to display in Footer Top Column ', 'topfit') . $i,
				'parent'      => $show_footer_custom_widget_areas,
				'options'     => $mkd_custom_widgets
			));

		}

		topfit_mikado_add_meta_box_field(array(
			'name'        => 'mkd_footer_text_meta',
			'type'        => 'selectblank',
			'label'       => esc_html__('Choose Widget Area in Footer Bottom', 'topfit'),
			'description' => esc_html__('Choose Custom Widget area to display in Footer Bottom', 'topfit'),
			'parent'      => $show_footer_custom_widget_areas,
			'options'     => $mkd_custom_widgets
		));

		topfit_mikado_add_meta_box_field(array(
			'name'        => 'mkd_footer_bottom_left_meta',
			'type'        => 'selectblank',
			'label'       => esc_html__('Choose Widget Area in Footer Bottom Left', 'topfit'),
			'description' => esc_html__('Choose Custom Widget area to display in Footer Bottom', 'topfit'),
			'parent'      => $show_footer_custom_widget_areas,
			'options'     => $mkd_custom_widgets
		));

		topfit_mikado_add_meta_box_field(array(
			'name'        => 'mkd_footer_bottom_right_meta',
			'type'        => 'selectblank',
			'label'       => esc_html__('Choose Widget Area in Footer Bottom Right', 'topfit'),
			'description' => esc_html__('Choose Custom Widget area to display in Footer Right', 'topfit'),
			'parent'      => $show_footer_custom_widget_areas,
			'options'     => $mkd_custom_widgets
		));
	}

	add_action('topfit_mikado_meta_boxes_map', 'topfit_mikado_footer_meta_box_map');
}