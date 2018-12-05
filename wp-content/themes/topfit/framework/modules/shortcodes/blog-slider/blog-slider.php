<?php
namespace TopFit\Modules\Shortcodes\BlogSlider;

use TopFit\Modules\Shortcodes\Lib\ShortcodeInterface;

class BlogSlider implements ShortcodeInterface {
	/**
	 * @var string
	 */
	private $base;

	function __construct() {
		$this->base = 'mkd_blog_slider';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {

		vc_map(array(
			'name'                      => esc_html__('Blog Slider', 'topfit'),
			'base'                      => $this->base,
			'icon'                      => 'icon-wpb-blog-slider extended-custom-icon',
			'category'                  => 'by MIKADO',
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
				array(
					'type'        => 'dropdown',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Type', 'topfit'),
					'param_name'  => 'slider_type',
					'value'       => array(
						esc_html__('Simple', 'topfit')  => 'simple',
						esc_html__('Masonry', 'topfit') => 'masonry'
					),
					'save_always' => true,
					'description' => ''
				),
				array(
					'type'        => 'dropdown',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Skin', 'topfit'),
					'param_name'  => 'skin',
					'value'       => array(
						esc_html__('Light', 'topfit') => 'light',
						esc_html__('Dark', 'topfit')  => 'dark'
					),
					'description' => '',
					'dependency'  => array(
						'element' => 'slider_type',
						'value'   => 'simple'
					),
					'save_always' => true
				),
				array(
					'type'        => 'dropdown',
					'class'       => '',
					'heading'     => esc_html__('Enable Navigation?', 'topfit'),
					'param_name'  => 'dots',
					'value'       => array(
						esc_html__('Yes', 'topfit') => 'yes',
						esc_html__('No', 'topfit')  => 'no'
					),
					'save_always' => true,
					'description' => ''
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Number of Posts', 'topfit'),
					'param_name'  => 'number_of_posts',
					'description' => ''
				),
				array(
					'type'        => 'dropdown',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Order By', 'topfit'),
					'param_name'  => 'order_by',
					'value'       => array(
						esc_html__('Title', 'topfit') => 'title',
						esc_html__('Date', 'topfit')  => 'date'
					),
					'save_always' => true,
					'description' => ''
				),
				array(
					'type'        => 'dropdown',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Order', 'topfit'),
					'param_name'  => 'order',
					'value'       => array(
						esc_html__('ASC', 'topfit')  => 'ASC',
						esc_html__('DESC', 'topfit') => 'DESC'
					),
					'save_always' => true,
					'description' => ''
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Category Slug', 'topfit'),
					'param_name'  => 'category',
					'description' => esc_html__('Leave empty for all or use comma for list', 'topfit')
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Text length', 'topfit'),
					'param_name'  => 'text_length',
					'description' => esc_html__('Number of characters', 'topfit'),
					'dependency'  => array(
						'element' => 'slider_type',
						'value'   => array('simple')
					),
				)
			)
		));

	}

	public function render($atts, $content = null) {

		$default_atts = array(
			'slider_type'     => 'one',
			'dots'            => 'yes',
			'skin'            => '',
			'number_of_posts' => '',
			'order_by'        => '',
			'order'           => '',
			'category'        => '',
			'text_length'     => '90',
		);

		$params = shortcode_atts($default_atts, $atts);

		$queryParams = $this->generateBlogQueryArray($params);

		$query = new \WP_Query($queryParams);

		$params['query'] = $query;

		$params['holder_classes'] = $this->getHolderClasses($params);
		$params['holder_data'] = $this->getHolderData($params);

		return topfit_mikado_get_shortcode_module_template_part('templates/blog-slider-template-' . $params['slider_type'], 'blog-slider', '', $params);
	}


	/**
	 * Generates query array
	 *
	 * @param $params
	 *
	 * @return array
	 */
	public function generateBlogQueryArray($params) {

		$queryArray = array(
			'orderby'        => $params['order_by'],
			'order'          => $params['order'],
			'posts_per_page' => $params['number_of_posts'],
			'category_name'  => $params['category']
		);

		return $queryArray;
	}

	/**
	 * Returns array of holder classes
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getHolderClasses($params) {
		$classes = array('mkd-blog-slider-holder');

		$classes[] = $params['slider_type'];

		if ($params['skin'] !== '') {
			$classes[] = $params['skin'];
		}

		return $classes;
	}

	/**
	 * Returns array of holder data attributes
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getHolderData($params) {
		$data = array();

		$data['data-dots'] = $params['dots'];

		return $data;
	}
}