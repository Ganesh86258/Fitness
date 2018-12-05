<?php

if (!function_exists('topfit_mikado_footer_options_map')) {
	/**
	 * Add footer options
	 */
	function topfit_mikado_footer_options_map() {

		topfit_mikado_add_admin_page(
			array(
				'slug'  => '_footer_page',
				'title' => esc_html__('Footer', 'topfit'),
				'icon'  => 'icon_cone_alt'
			)
		);

		$footer_panel = topfit_mikado_add_admin_panel(
			array(
				'title' => esc_html__('Footer', 'topfit'),
				'name'  => 'footer',
				'page'  => '_footer_page'
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'uncovering_footer',
				'default_value' => 'no',
				'label'         => esc_html__('Uncovering Footer', 'topfit'),
				'description'   => esc_html__('Enabling this option will make Footer gradually appear on scroll', 'topfit'),
				'parent'        => $footer_panel,
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'name'        => 'footer_background_image',
				'type'        => 'image',
				'label'       => esc_html__('Background Image', 'topfit'),
				'description' => esc_html__('Choose Background Image for Footer Area', 'topfit'),
				'parent'      => $footer_panel
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'footer_in_grid',
				'default_value' => 'yes',
				'label'         => esc_html__('Footer in Grid', 'topfit'),
				'description'   => esc_html__('Enabling this option will place Footer content in grid', 'topfit'),
				'parent'        => $footer_panel,
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'show_footer_top',
				'default_value' => 'yes',
				'label'         => esc_html__('Show Footer Top', 'topfit'),
				'description'   => esc_html__('Enabling this option will show Footer Top area', 'topfit'),
				'args'          => array(
					'dependence'             => true,
					'dependence_hide_on_yes' => '',
					'dependence_show_on_yes' => '#mkd_show_footer_top_container'
				),
				'parent'        => $footer_panel,
			)
		);

		$show_footer_top_container = topfit_mikado_add_admin_container(
			array(
				'name'            => 'show_footer_top_container',
				'hidden_property' => 'show_footer_top',
				'hidden_value'    => 'no',
				'parent'          => $footer_panel
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'footer_top_columns',
				'default_value' => '4',
				'label'         => esc_html__('Footer Top Columns', 'topfit'),
				'description'   => esc_html__('Choose number of columns for Footer Top area', 'topfit'),
				'options'       => array(
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

		topfit_mikado_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'footer_top_columns_alignment',
				'default_value' => '',
				'label'         => esc_html__('Footer Top Columns Alignment', 'topfit'),
				'description'   => esc_html__('Text Alignment in Footer Columns', 'topfit'),
				'options'       => array(
					'left'   => esc_html__('Left', 'topfit'),
					'center' => esc_html__('Center', 'topfit'),
					'right'  => esc_html__('Right', 'topfit'),
				),
				'parent'        => $show_footer_top_container,
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'show_footer_bottom',
				'default_value' => 'yes',
				'label'         => esc_html__('Show Footer Bottom', 'topfit'),
				'description'   => esc_html__('Enabling this option will show Footer Bottom area', 'topfit'),
				'args'          => array(
					'dependence'             => true,
					'dependence_hide_on_yes' => '',
					'dependence_show_on_yes' => '#mkd_show_footer_bottom_container'
				),
				'parent'        => $footer_panel,
			)
		);

		$show_footer_bottom_container = topfit_mikado_add_admin_container(
			array(
				'name'            => 'show_footer_bottom_container',
				'hidden_property' => 'show_footer_bottom',
				'hidden_value'    => 'no',
				'parent'          => $footer_panel
			)
		);


		topfit_mikado_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'footer_bottom_columns',
				'default_value' => '3',
				'label'         => esc_html__('Footer Bottom Columns', 'topfit'),
				'description'   => esc_html__('Choose number of columns for Footer Bottom area', 'topfit'),
				'options'       => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '3 (25%+50%+25%)',

				),
				'parent'        => $show_footer_bottom_container,
			)
		);

	}

	add_action('topfit_mikado_options_map', 'topfit_mikado_footer_options_map');

}