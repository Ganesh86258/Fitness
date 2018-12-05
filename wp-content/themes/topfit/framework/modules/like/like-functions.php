<?php

if ( ! function_exists('topfit_mikado_like') ) {
	/**
	 * Returns TopFitMikadoLike instance
	 *
	 * @return TopFitMikadoLike
	 */
	function topfit_mikado_like() {
		return TopFitMikadoLike::get_instance();
	}

}

function topfit_mikado_get_like() {

	echo wp_kses(topfit_mikado_like()->add_like(), array(
		'span' => array(
			'class' => true,
			'aria-hidden' => true,
			'style' => true,
			'id' => true
		),
		'i' => array(
			'class' => true,
			'style' => true,
			'id' => true
		),
		'a' => array(
			'href' => true,
			'class' => true,
			'id' => true,
			'title' => true,
			'style' => true
		)
	));
}

if ( ! function_exists('topfit_mikado_like_latest_posts') ) {
	/**
	 * Add like to latest post
	 *
	 * @return string
	 */
	function topfit_mikado_like_latest_posts() {
		return topfit_mikado_like()->add_like();
	}

}

if ( ! function_exists('topfit_mikado_like_portfolio_list') ) {
	/**
	 * Add like to portfolio project
	 *
	 * @param $portfolio_project_id
	 * @return string
	 */
	function topfit_mikado_like_portfolio_list($portfolio_project_id) {
		return topfit_mikado_like()->add_like_portfolio_list($portfolio_project_id);
	}

}