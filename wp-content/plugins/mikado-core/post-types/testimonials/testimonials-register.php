<?php
namespace MikadoCore\CPT\Testimonials;

use MikadoCore\Lib;


/**
 * Class TestimonialsRegister
 * @package MikadoCore\CPT\Testimonials
 */
class TestimonialsRegister implements Lib\PostTypeInterface {
	/**
	 * @var string
	 */
	private $base;

	public function __construct() {
		$this->base = 'testimonials';
		$this->taxBase = 'testimonials_category';
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
	 * Regsiters custom post type with WordPress
	 */
	private function registerPostType() {
		global $topfit_Framework;

		$menuPosition = 5;
		$menuIcon = 'dashicons-admin-post';

		if (mkd_core_theme_installed()) {
			$menuPosition = $topfit_Framework->getSkin()->getMenuItemPosition('testimonial');
			$menuIcon = $topfit_Framework->getSkin()->getMenuIcon('testimonial');
		}

		register_post_type('testimonials',
			array(
				'labels'        => array(
					'name'          => esc_html__('Testimonials', 'mkd-core'),
					'singular_name' => esc_html__('Testimonial', 'mkd-core'),
					'add_item'      => esc_html__('New Testimonial', 'mkd-core'),
					'add_new_item'  => esc_html__('Add New Testimonial', 'mkd-core'),
					'edit_item'     => esc_html__('Edit Testimonial', 'mkd-core')
				),
				'public'        => false,
				'show_in_menu'  => true,
				'rewrite'       => array('slug' => 'testimonials'),
				'menu_position' => $menuPosition,
				'show_ui'       => true,
				'has_archive'   => false,
				'hierarchical'  => false,
				'supports'      => array('title', 'thumbnail'),
				'menu_icon'     => $menuIcon
			)
		);
	}

	/**
	 * Registers custom taxonomy with WordPress
	 */
	private function registerTax() {
		$labels = array(
			'name'              => esc_html__('Testimonials Categories', 'mkd-core'),
			'singular_name'     => esc_html__('Testimonial Category', 'mkd-core'),
			'search_items'      => esc_html__('Search Testimonials Categories', 'mkd-core'),
			'all_items'         => esc_html__('All Testimonials Categories', 'mkd-core'),
			'parent_item'       => esc_html__('Parent Testimonial Category', 'mkd-core'),
			'parent_item_colon' => esc_html__('Parent Testimonial Category:', 'mkd-core'),
			'edit_item'         => esc_html__('Edit Testimonials Category', 'mkd-core'),
			'update_item'       => esc_html__('Update Testimonials Category', 'mkd-core'),
			'add_new_item'      => esc_html__('Add New Testimonials Category', 'mkd-core'),
			'new_item_name'     => esc_html__('New Testimonials Category Name', 'mkd-core'),
			'menu_name'         => esc_html__('Testimonials Categories', 'mkd-core'),
		);

		register_taxonomy($this->taxBase, array($this->base), array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'query_var'         => true,
			'show_admin_column' => true,
			'rewrite'           => array('slug' => 'testimonials-category'),
		));
	}

}