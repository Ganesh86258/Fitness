<?php
namespace MikadoCore\CPT\Portfolio;

use MikadoCore\Lib\PostTypeInterface;

/**
 * Class PortfolioRegister
 * @package MikadoCore\CPT\Portfolio
 */
class PortfolioRegister implements PostTypeInterface {
	/**
	 * @var string
	 */
	private $base;

	public function __construct() {
		$this->base    = 'portfolio-item';
		$this->taxBase = 'portfolio-category';

		add_filter('single_template', array($this, 'registerSingleTemplate'));
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
		$this->registerTagTax();
	}

	/**
	 * Registers portfolio single template if one does'nt exists in theme.
	 * Hooked to single_template filter
	 *
	 * @param $single string current template
	 *
	 * @return string string changed template
	 */
	public function registerSingleTemplate($single) {
		global $post;

		if($post->post_type == $this->base) {
			if(!file_exists(get_template_directory().'/single-portfolio-item.php')) {
				return MIKADO_CORE_CPT_PATH.'/portfolio/templates/single-'.$this->base.'.php';
			}
		}

		return $single;
	}

	/**
	 * Registers custom post type with WordPress
	 */
	private function registerPostType() {
		global $topfit_Framework, $topfit_options;

		$menuPosition = 5;
		$menuIcon     = 'dashicons-admin-post';
		$slug         = $this->base;

		if(mkd_core_theme_installed()) {
			$menuPosition = $topfit_Framework->getSkin()->getMenuItemPosition('portfolio');
			$menuIcon     = $topfit_Framework->getSkin()->getMenuIcon('portfolio');

			if(isset($topfit_options['portfolio_single_slug'])) {
				if($topfit_options['portfolio_single_slug'] != "") {
					$slug = $topfit_options['portfolio_single_slug'];
				}
			}
		}

		register_post_type($this->base,
			array(
				'labels'        => array(
					'name'          => esc_html__('Portfolio', 'mkd-core'),
					'singular_name' => esc_html__('Portfolio Item', 'mkd-core'),
					'add_item'      => __('New Portfolio Item', 'mkd-core'),
					'add_new_item'  => esc_html__('Add New Portfolio Item', 'mkd-core'),
					'edit_item'     => esc_html__('Edit Portfolio Item', 'mkd-core')
				),
				'public'        => true,
				'has_archive'   => true,
				'rewrite'       => array('slug' => $slug),
				'menu_position' => $menuPosition,
				'show_ui'       => true,
				'supports'      => array(
					'author',
					'title',
					'editor',
					'thumbnail',
					'excerpt',
					'page-attributes',
					'comments'
				),
				'menu_icon'     => $menuIcon
			)
		);
	}

	/**
	 * Registers custom taxonomy with WordPress
	 */
	private function registerTax() {
		$labels = array(
			'name'              => esc_html__('Portfolio Categories', 'taxonomy general name'),
			'singular_name'     => esc_html__('Portfolio Category', 'taxonomy singular name'),
			'search_items'      => esc_html__('Search Portfolio Categories', 'mkd-core'),
			'all_items'         => esc_html__('All Portfolio Categories', 'mkd-core'),
			'parent_item'       => esc_html__('Parent Portfolio Category', 'mkd-core'),
			'parent_item_colon' => esc_html__('Parent Portfolio Category:', 'mkd-core'),
			'edit_item'         => esc_html__('Edit Portfolio Category', 'mkd-core'),
			'update_item'       => esc_html__('Update Portfolio Category', 'mkd-core'),
			'add_new_item'      => esc_html__('Add New Portfolio Category', 'mkd-core'),
			'new_item_name'     => esc_html__('New Portfolio Category Name', 'mkd-core'),
			'menu_name'         => esc_html__('Portfolio Categories', 'mkd-core'),
		);

		register_taxonomy($this->taxBase, array($this->base), array(
			'hierarchical' => true,
			'labels'       => $labels,
			'show_ui'      => true,
			'query_var'    => true,
			'rewrite'      => array('slug' => 'portfolio-category'),
		));
	}

	/**
	 * Registers custom tag taxonomy with WordPress
	 */
	private function registerTagTax() {
		$labels = array(
			'name'              => esc_html__('Portfolio Tags', 'taxonomy general name'),
			'singular_name'     => esc_html__('Portfolio Tag', 'taxonomy singular name'),
			'search_items'      => esc_html__('Search Portfolio Tags', 'mkd-core'),
			'all_items'         => esc_html__('All Portfolio Tags', 'mkd-core'),
			'parent_item'       => esc_html__('Parent Portfolio Tag', 'mkd-core'),
			'parent_item_colon' => esc_html__('Parent Portfolio Tags:', 'mkd-core'),
			'edit_item'         => esc_html__('Edit Portfolio Tag', 'mkd-core'),
			'update_item'       => esc_html__('Update Portfolio Tag', 'mkd-core'),
			'add_new_item'      => esc_html__('Add New Portfolio Tag', 'mkd-core'),
			'new_item_name'     => esc_html__('New Portfolio Tag Name', 'mkd-core'),
			'menu_name'         => esc_html__('Portfolio Tags', 'mkd-core'),
		);

		register_taxonomy('portfolio-tag', array($this->base), array(
			'hierarchical' => false,
			'labels'       => $labels,
			'show_ui'      => true,
			'query_var'    => true,
			'rewrite'      => array('slug' => 'portfolio-tag'),
		));
	}
}