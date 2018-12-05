<?php

if (!function_exists('topfit_mikado_woocommerce_options_map')) {

	/**
	 * Add Woocommerce options page
	 */
	function topfit_mikado_woocommerce_options_map() {

		topfit_mikado_add_admin_page(
			array(
				'slug'  => '_woocommerce_page',
				'title' => esc_html__('Woocommerce', 'topfit'),
				'icon'  => 'icon_cart_alt'
			)
		);

		/**
		 * Product List Settings
		 */
		$panel_product_list = topfit_mikado_add_admin_panel(
			array(
				'page'  => '_woocommerce_page',
				'name'  => 'panel_product_list',
				'title' => esc_html__('Product List', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(array(
			'name'          => 'mkd_woo_product_list_columns',
			'type'          => 'select',
			'label'         => esc_html__('Product List Columns', 'topfit'),
			'default_value' => 'mkd-woocommerce-columns-4',
			'description'   => esc_html__('Choose number of columns for product listing and related products on single product', 'topfit'),
			'options'       => array(
				'mkd-woocommerce-columns-3' => esc_html__('3 Columns (2 with sidebar)', 'topfit'),
				'mkd-woocommerce-columns-4' => esc_html__('4 Columns (3 with sidebar)', 'topfit')
			),
			'parent'        => $panel_product_list,
		));

		topfit_mikado_add_admin_field(array(
			'name'          => 'mkd_woo_products_per_page',
			'type'          => 'text',
			'label'         => esc_html__('Number of products per page', 'topfit'),
			'default_value' => '',
			'description'   => esc_html__('Set number of products on shop page', 'topfit'),
			'parent'        => $panel_product_list,
			'args'          => array(
				'col_width' => 3
			)
		));

		topfit_mikado_add_admin_field(array(
			'name'          => 'mkd_products_list_title_tag',
			'type'          => 'select',
			'label'         => esc_html__('Products Title Tag', 'topfit'),
			'default_value' => 'h5',
			'description'   => '',
			'options'       => array(
				'h2' => 'h2',
				'h3' => 'h3',
				'h4' => 'h4',
				'h5' => 'h5',
				'h6' => 'h6',
			),
			'parent'        => $panel_product_list,
		));

		/**
		 * Single Product Settings
		 */
		$panel_single_product = topfit_mikado_add_admin_panel(
			array(
				'page'  => '_woocommerce_page',
				'name'  => 'panel_single_product',
				'title' => esc_html__('Single Product', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(array(
			'name'          => 'mkd_single_product_title_tag',
			'type'          => 'select',
			'label'         => esc_html__('Single Product Title Tag', 'topfit'),
			'default_value' => 'h3',
			'description'   => '',
			'options'       => array(
				'h2' => 'h2',
				'h3' => 'h3',
				'h4' => 'h4',
				'h5' => 'h5',
				'h6' => 'h6',
			),
			'parent'        => $panel_single_product,
		));

		/**
		 * DropDown Cart Widget Settings
		 */
		$panel_dropdown_cart = topfit_mikado_add_admin_panel(
			array(
				'page'  => '_woocommerce_page',
				'name'  => 'panel_dropdown_cart',
				'title' => esc_html__('Dropdown Cart Widget', 'topfit')
			)
		);

		topfit_mikado_add_admin_field(array(
			'name'          => 'mkd_woo_dropdown_cart_description',
			'type'          => 'text',
			'label'         => esc_html__('Cart Description', 'topfit'),
			'default_value' => '',
			'description'   => esc_html__('Enter dropdown cart description', 'topfit'),
			'parent'        => $panel_dropdown_cart
		));
	}

	add_action('topfit_mikado_options_map', 'topfit_mikado_woocommerce_options_map', 21);
}