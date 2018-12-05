<?php

//WooCommerce
if (topfit_mikado_is_woocommerce_installed()) {


	if (!function_exists('topfit_mikado_woocommerce_meta_box_map')) {
		function topfit_mikado_woocommerce_meta_box_map() {

			$woocommerce_meta_box = topfit_mikado_add_meta_box(
				array(
					'scope' => array('product'),
					'title' => esc_html__('Product Meta', 'topfit'),
					'name'  => 'woo_product_meta'
				)
			);

			topfit_mikado_add_meta_box_field(array(
				'name'        => 'mkd_single_product_new_meta',
				'type'        => 'select',
				'label'       => esc_html__('Enable New Product Mark', 'topfit'),
				'description' => esc_html__('Enabling this option will show new product mark on your product lists and product single', 'topfit'),
				'parent'      => $woocommerce_meta_box,
				'options'     => array(
					'no'  => esc_html__('No', 'topfit'),
					'yes' => esc_html__('Yes', 'topfit')
				)
			));

			topfit_mikado_add_meta_box_field(array(
				'name'          => 'mkd_masonry_product_list_dimensions_meta',
				'type'          => 'select',
				'label'         => esc_html__('Dimensions for Masonry Product list', 'topfit'),
				'description'   => esc_html__('Choose image layout when it appears in Masonry Product list', 'topfit'),
				'parent'        => $woocommerce_meta_box,
				'options'       => array(
					'standard'           => esc_html__('Standard', 'topfit'),
					'large-width'        => esc_html__('Large width', 'topfit'),
					'large-height'       => esc_html__('Large height', 'topfit'),
					'large-width-height' => esc_html__('Large width/height', 'topfit'),
				),
				'default_value' => 'standard'
			));

		}

		add_action('topfit_mikado_meta_boxes_map', 'topfit_mikado_woocommerce_meta_box_map');
	}
}