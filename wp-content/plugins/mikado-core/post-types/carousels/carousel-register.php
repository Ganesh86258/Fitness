<?php
namespace MikadoCore\CPT\Carousels;

use MikadoCore\Lib;

/**
 * Class CarouselRegister
 * @package MikadoCore\CPT\Carousels
 */
class CarouselRegister implements Lib\PostTypeInterface {
	/**
	 * @var string
	 */
	private $base;
	/**
	 * @var string
	 */
	private $taxBase;

	public function __construct() {
		$this->base = 'carousels';
		$this->taxBase = 'carousels_category';
	}

	/**
	 * @return string
	 */
	public function getBase() {
		return $this->base;
	}

	/**
	 * Registers custom post type with WordPress
	 */
	public function register() {
		$this->registerPostType();
		$this->registerTax();
	}

	/**
	 * Registers custom post type with WordPress
	 */
	private function registerPostType() {
		global $topfit_Framework;

		$menuPosition = 5;
		$menuIcon = 'dashicons-admin-post';
		if (mkd_core_theme_installed()) {
			$menuPosition = $topfit_Framework->getSkin()->getMenuItemPosition('carousel');
			$menuIcon = $topfit_Framework->getSkin()->getMenuIcon('carousel');
		}

		register_post_type($this->base,
			array(
				'labels'        => array(
					'name'          => esc_html__('Mikado Carousel', 'mkd-core'),
					'menu_name'     => esc_html__('Mikado Carousel', 'mkd-core'),
					'all_items'     => esc_html__('Carousel Items', 'mkd-core'),
					'add_new'       => esc_html__('Add New Carousel Item', 'mkd-core'),
					'singular_name' => esc_html__('Carousel Item', 'mkd-core'),
					'add_item'      => esc_html__('New Carousel Item', 'mkd-core'),
					'add_new_item'  => esc_html__('Add New Carousel Item', 'mkd-core'),
					'edit_item'     => esc_html__('Edit Carousel Item', 'mkd-core')
				),
				'public'        => false,
				'show_in_menu'  => true,
				'rewrite'       => array('slug' => 'carousels'),
				'menu_position' => $menuPosition,
				'show_ui'       => true,
				'has_archive'   => false,
				'hierarchical'  => false,
				'supports'      => array('title'),
				'menu_icon'     => $menuIcon
			)
		);
	}

	/**
	 * Registers custom taxonomy with WordPress
	 */
	private function registerTax() {
		$labels = array(
			'name'              => esc_html__('Carousels', 'mkd-core'),
			'singular_name'     => esc_html__('Carousel', 'mkd-core'),
			'search_items'      => esc_html__('Search Carousels', 'mkd-core'),
			'all_items'         => esc_html__('All Carousels', 'mkd-core'),
			'parent_item'       => esc_html__('Parent Carousel', 'mkd-core'),
			'parent_item_colon' => esc_html__('Parent Carousel:', 'mkd-core'),
			'edit_item'         => esc_html__('Edit Carousel', 'mkd-core'),
			'update_item'       => esc_html__('Update Carousel', 'mkd-core'),
			'add_new_item'      => esc_html__('Add New Carousel', 'mkd-core'),
			'new_item_name'     => esc_html__('New Carousel Name', 'mkd-core'),
			'menu_name'         => esc_html__('Carousels', 'mkd-core'),
		);

		register_taxonomy($this->taxBase, array($this->base), array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'query_var'         => true,
			'show_admin_column' => true,
			'rewrite'           => array('slug' => 'carousels-category'),
		));
	}

}