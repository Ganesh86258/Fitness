<?php

if (!function_exists('topfit_mikado_woocommerce_products_per_page')) {
	/**
	 * Function that sets number of products per page. Default is 12
	 * @return int number of products to be shown per page
	 */
	function topfit_mikado_woocommerce_products_per_page() {

		$products_per_page = 12;

		if (topfit_mikado_options()->getOptionValue('mkd_woo_products_per_page')) {
			$products_per_page = topfit_mikado_options()->getOptionValue('mkd_woo_products_per_page');
		}
		if (isset($_GET['woo-products-count']) && $_GET['woo-products-count'] === 'view-all') {
			$products_per_page = 9999;
		}

		return $products_per_page;
	}
}

if (!function_exists('topfit_mikado_woocommerce_related_products_args')) {
	/**
	 * Function that sets number of displayed related products. Hooks to woocommerce_output_related_products_args filter
	 * @param $args array array of args for the query
	 * @return mixed array of changed args
	 */
	function topfit_mikado_woocommerce_related_products_args($args) {

		if (topfit_mikado_options()->getOptionValue('mkd_woo_product_list_columns')) {

			$related = topfit_mikado_options()->getOptionValue('mkd_woo_product_list_columns');
			switch ($related) {
				case 'mkd-woocommerce-columns-4':
					$args['posts_per_page'] = 4;
					break;
				case 'mkd-woocommerce-columns-3':
					$args['posts_per_page'] = 3;
					break;
				default:
					$args['posts_per_page'] = 3;
			}

		} else {
			$args['posts_per_page'] = 3;
		}

		return $args;
	}
}

if (!function_exists('topfit_mikado_woocommerce_template_loop_product_title')) {
	/**
	 * Function for overriding product title template in Product List Loop
	 */
	function topfit_mikado_woocommerce_template_loop_product_title() {

		$tag = topfit_mikado_options()->getOptionValue('mkd_products_list_title_tag');
		if ($tag === '') {
			$tag = 'h5';
		}
		the_title('<' . $tag . ' class="mkd-product-list-title"><a href="' . get_the_permalink() . '">', '</a></' . $tag . '>');
	}
}

if (!function_exists('topfit_mikado_woocommerce_template_single_title')) {
	/**
	 * Function for overriding product title template in Single Product template
	 */
	function topfit_mikado_woocommerce_template_single_title() {

		$tag = topfit_mikado_options()->getOptionValue('mkd_single_product_title_tag');
		if ($tag === '') {
			$tag = 'h3';
		}
		the_title('<' . $tag . '  itemprop="name" class="mkd-single-product-title">', '</' . $tag . '>');
	}
}

if (!function_exists('topfit_mikado_woocommerce_sale_flash')) {
	/**
	 * Function for overriding Sale Flash Template
	 *
	 * @return string
	 */
	function topfit_mikado_woocommerce_sale_flash() {
		if (!is_single()) {
			return '<span class="mkd-on-sale">' . esc_html__('SALE', 'topfit') . '</span>';
		}
	}
}

if (!function_exists('topfit_mikado_woocommerce_sale_flash_single')) {
	/**
	 * Function for overriding Sale Flash Template on Single product page
	 * @return string
	 */
	function topfit_mikado_woocommerce_sale_flash_single() {
		global $product;
		if ($product->is_on_sale()) {
			print '<span class="mkd-on-sale">' . esc_html__('SALE', 'topfit') . '</span>';
		}
	}
}

if (!function_exists('topfit_mikado_woocommerce_product_out_of_stock')) {
	/**
	 * Function for adding Out Of Stock Template
	 *
	 * @return string
	 */
	function topfit_mikado_woocommerce_product_out_of_stock() {

		global $product;

		if (!$product->is_in_stock()) {
			print '<span class="mkd-out-of-stock">' . esc_html__('SOLD', 'topfit') . '</span>';
		}
	}
}

if (!function_exists('topfit_mikado_woo_view_all_pagination_additional_tag_before')) {
	function topfit_mikado_woo_view_all_pagination_additional_tag_before() {

		print '<div class="mkd-woo-pagination-holder"><div class="mkd-woo-pagination-inner">';
	}
}

if (!function_exists('topfit_mikado_woo_view_all_pagination_additional_tag_after')) {
	function topfit_mikado_woo_view_all_pagination_additional_tag_after() {

		print '</div></div>';
	}
}

if (!function_exists('topfit_mikado_single_product_content_additional_tag_before')) {
	function topfit_mikado_single_product_content_additional_tag_before() {

		print '<div class="mkd-single-product-content">';
	}
}

if (!function_exists('topfit_mikado_single_product_content_additional_tag_after')) {
	function topfit_mikado_single_product_content_additional_tag_after() {

		print '</div>';
	}
}

if (!function_exists('topfit_mikado_single_product_summary_additional_tag_before')) {
	function topfit_mikado_single_product_summary_additional_tag_before() {

		print '<div class="mkd-single-product-summary">';
	}
}

if (!function_exists('topfit_mikado_single_product_summary_additional_tag_after')) {
	function topfit_mikado_single_product_summary_additional_tag_after() {

		print '</div>';
	}
}

if (!function_exists('topfit_mikado_pl_holder_additional_tag_before')) {
	function topfit_mikado_pl_holder_additional_tag_before() {

		print '<div class="mkd-pl-main-holder">';
	}
}

if (!function_exists('topfit_mikado_pl_holder_additional_tag_after')) {
	function topfit_mikado_pl_holder_additional_tag_after() {

		print '</div>';
	}
}

if (!function_exists('topfit_mikado_pl_outer_additional_tag_before')) {
	function topfit_mikado_pl_outer_additional_tag_before() {
		global $product;

		$rating = $product->get_average_rating();

		if ($rating > 0) {
			print '<div class="mkd-pl-outer rating">';
		} else {
			print '<div class="mkd-pl-outer">';
		}
	}
}

if (!function_exists('topfit_mikado_pl_inner_additional_tag_before')) {
	function topfit_mikado_pl_inner_additional_tag_before() {

		print '<div class="mkd-pl-inner">';
	}
}

if (!function_exists('topfit_mikado_pl_inner_additional_tag_after')) {
	function topfit_mikado_pl_inner_additional_tag_after() {

		print '</div>';
	}
}

if (!function_exists('topfit_mikado_pl_outer_additional_tag_after')) {
	function topfit_mikado_pl_outer_additional_tag_after() {

		print '</div>';
	}
}

if (!function_exists('topfit_mikado_pl_image_additional_tag_before')) {
	function topfit_mikado_pl_image_additional_tag_before() {

		print '<div class="mkd-pl-image">';
	}
}

if (!function_exists('topfit_mikado_pl_image_additional_tag_after')) {
	function topfit_mikado_pl_image_additional_tag_after() {

		print '</div>';
	}
}

if (!function_exists('topfit_mikado_pl_inner_text_additional_tag_before')) {
	function topfit_mikado_pl_inner_text_additional_tag_before() {

		print '<div class="mkd-pl-cart">';
	}
}

if (!function_exists('topfit_mikado_pl_inner_text_additional_tag_after')) {
	function topfit_mikado_pl_inner_text_additional_tag_after() {

		print '</div>';
	}
}

if (!function_exists('topfit_mikado_pl_text_wrapper_additional_tag_before')) {
	function topfit_mikado_pl_text_wrapper_additional_tag_before() {

		print '<div class="mkd-pl-text-wrapper"><div class="mkd-pl-text-wrapper-inner">';
	}
}

if (!function_exists('topfit_mikado_pl_text_wrapper_additional_tag_after')) {
	function topfit_mikado_pl_text_wrapper_additional_tag_after() {

		print '</div></div>';
	}
}

if (!function_exists('topfit_mikado_pl_rating_additional_tag_before')) {
	function topfit_mikado_pl_rating_additional_tag_before() {
		global $product;

		if (get_option('woocommerce_enable_review_rating') !== 'no') {

            $rating_html = wc_get_rating_html($product->get_average_rating());

			if ($rating_html !== '') {
				print '<div class="mkd-pl-rating-holder">';
			}
		}
	}
}

if (!function_exists('topfit_mikado_pl_rating_additional_tag_after')) {
	function topfit_mikado_pl_rating_additional_tag_after() {
		global $product;

		if (get_option('woocommerce_enable_review_rating') !== 'no') {

            $rating_html = wc_get_rating_html($product->get_average_rating());

			if ($rating_html !== '') {
				print '</div>';
			}
		}
	}
}

if (!function_exists('topfit_mikado_woocommerce__new_product_mark')) {
	/**
	 * Function for adding New Product Template
	 *
	 * @return string
	 */
	function topfit_mikado_woocommerce__new_product_mark() {
		global $product;

		if (get_post_meta($product->get_id(), 'mkd_single_product_new_meta', true) === 'yes') {
			print '<span class="mkd-new-product">' . esc_html__('NEW', 'topfit') . '</span>';
		}
	}
}


if (!function_exists('topfit_mikado_share_like_tag_before')) {
	/**
	 * Function that adds tag before share and like section
	 */
	function topfit_mikado_share_like_tag_before() {
		print '<div class="mkd-single-product-share-like">';
	}
}

if (!function_exists('topfit_mikado_share_like_tag_after')) {
	/**
	 * Function that adds tag before share and like section
	 */
	function topfit_mikado_share_like_tag_after() {
		print '</div>';
	}
}

if (!function_exists('topfit_mikado_woocommerce_stock_html')) {
	function topfit_mikado_woocommerce_stock_html($availability_html, $availability = false, $product = null) {
		global $product;

		$availability = $product->get_availability();

		return empty($availability['availability']) ? '' : '</td><td class="stock">' . $availability_html;
	}
}