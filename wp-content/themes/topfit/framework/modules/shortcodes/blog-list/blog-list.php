<?php

namespace TopFit\Modules\BlogList;

use TopFit\Modules\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class BlogList
 */
class BlogList implements ShortcodeInterface {
	/**
	 * @var string
	 */
	private $base;

	function __construct() {
		$this->base = 'mkd_blog_list';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {

		vc_map(array(
			'name'                      => esc_html__('Blog List', 'topfit'),
			'base'                      => $this->base,
			'icon'                      => 'icon-wpb-blog-list extended-custom-icon',
			'category'                  => 'by MIKADO',
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
				array(
					'type'        => 'dropdown',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Type', 'topfit'),
					'param_name'  => 'type',
					'value'       => array(
						esc_html__('Minimal', 'topfit')      => 'minimal',
						esc_html__('Simple', 'topfit')       => 'simple',
						esc_html__('Masonry', 'topfit')      => 'masonry',
						esc_html__('Image in box', 'topfit') => 'image-in-box'
					),
					'description' => '',
					'save_always' => true
				),
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__('Columns', 'topfit'),
					'param_name'  => 'masonry_columns',
					'description' => '',
					'value'       => array(
						'3' => '3',
						'4' => '4',
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'masonry'
					),
					'save_always' => true
				),
				array(
					'type'        => 'checkbox',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Simple boxed', 'topfit'),
					'param_name'  => 'simple_boxed',
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'simple'
					),
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
					'dependency'  => array(
						'element'   => 'simple_boxed',
						'not_empty' => true
					),
					'description' => '',
					'save_always' => true
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
						'element' => 'type',
						'value'   => array('minimal', 'simple', 'image-in-box')
					),
				)
			)
		));

	}

	public function render($atts, $content = null) {

		$default_atts = array(
			'type'            => 'minimal',
			'masonry_columns' => '3',
			'simple_boxed'    => '',
			'skin'            => '',
			'number_of_posts' => '',
			'order_by'        => '',
			'order'           => '',
			'category'        => '',
			'text_length'     => '90',
		);

		$params = shortcode_atts($default_atts, $atts);
		$params['holder_classes'] = $this->getBlogHolderClasses($params);


		$queryArray = $this->generateBlogQueryArray($params);
		$query_result = new \WP_Query($queryArray);
		$params['query_result'] = $query_result;

		$html = '';
		$html .= topfit_mikado_get_shortcode_module_template_part('templates/blog-list-holder', 'blog-list', '', $params);

		return $html;

	}

	/**
	 * Generates holder classes
	 *
	 * @param $params
	 *
	 * @return string
	 */
	private function getBlogHolderClasses($params) {
		$holderClasses = array(
			'mkd-blog-list-holder',
			'mkd-' . $params['type'],
		);

		if ($params['type'] === 'simple' && $params['simple_boxed']) {
			$holderClasses[] = 'boxed';
		}

		if ($params['type'] === 'masonry') {
			if($params['masonry_columns'] == '4') {
				$holderClasses[] = 'mkd-four';
			}
			else {
				$holderClasses[] = 'mkd-three';
			}
		}


		if ($params['skin'] !== '') {
			$holderClasses[] = $params['skin'];
		}

		return $holderClasses;

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
}
