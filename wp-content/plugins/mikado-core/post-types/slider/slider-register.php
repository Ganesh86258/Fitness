<?php
namespace MikadoCore\CPT\Slider;

use MikadoCore\Lib;

/**
 * Class SliderRegister
 * @package MikadoCore\CPT\Slider
 */
class SliderRegister implements Lib\PostTypeInterface {
	/**
	 * @var string
	 */
	private $base;

	public function __construct() {
		$this->base    = 'slides';
		$this->taxBase = 'slides_category';
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
		$menuIcon     = 'dashicons-admin-post';

		if(mkd_core_theme_installed()) {
			$menuPosition = $topfit_Framework->getSkin()->getMenuItemPosition('slider');
			$menuIcon     = $topfit_Framework->getSkin()->getMenuIcon('slider');
		}

		register_post_type($this->base,
			array(
				'labels'        => array(
					'name'          => esc_html__('Mikado Slider', 'mkd-core'),
					'menu_name'     => esc_html__('Mikado Slider', 'mkd-core'),
					'all_items'     => esc_html__('Slides', 'mkd-core'),
					'add_new'       => esc_html__('Add New Slide', 'mkd-core'),
					'singular_name' => esc_html__('Slide', 'mkd-core'),
					'add_item'      => esc_html__('New Slide', 'mkd-core'),
					'add_new_item'  => esc_html__('Add New Slide', 'mkd-core'),
					'edit_item'     => esc_html__('Edit Slide', 'mkd-core')
				),
				'public'        => false,
				'show_in_menu'  => true,
				'rewrite'       => array('slug' => 'slides'),
				'menu_position' => $menuPosition,
				'show_ui'       => true,
				'has_archive'   => false,
				'hierarchical'  => false,
				'supports'      => array('title', 'thumbnail', 'page-attributes'),
				'menu_icon'     => $menuIcon
			)
		);
	}

	/**
	 * Registers custom taxonomy with WordPress
	 */
	private function registerTax() {
		$labels = array(
			'name'              => esc_html__('Sliders', 'mkd-core'),
			'singular_name'     => esc_html__('Slider', 'mkd-core'),
			'search_items'      => esc_html__('Search Sliders', 'mkd-core'),
			'all_items'         => esc_html__('All Sliders', 'mkd-core'),
			'parent_item'       => esc_html__('Parent Slider', 'mkd-core'),
			'parent_item_colon' => esc_html__('Parent Slider:', 'mkd-core'),
			'edit_item'         => esc_html__('Edit Slider', 'mkd-core'),
			'update_item'       => esc_html__('Update Slider', 'mkd-core'),
			'add_new_item'      => esc_html__('Add New Slider', 'mkd-core'),
			'new_item_name'     => esc_html__('New Slider Name', 'mkd-core'),
			'menu_name'         => esc_html__('Sliders', 'mkd-core'),
		);

		register_taxonomy($this->taxBase, array($this->base), array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'query_var'         => true,
			'show_admin_column' => true,
			'rewrite'           => array('slug' => 'slides-category'),
		));
	}
}