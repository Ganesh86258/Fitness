<?php

namespace MikadoCore\CPT\Testimonials\Shortcodes;


use MikadoCore\Lib;

/**
 * Class Testimonials
 * @package MikadoCore\CPT\Testimonials\Shortcodes
 */
class Testimonials implements Lib\ShortcodeInterface {
	/**
	 * @var string
	 */
	private $base;

	public function __construct() {
		$this->base = 'mkd_testimonials';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	/**
	 * Returns base for shortcode
	 * @return string
	 */
	public function getBase() {
		return $this->base;
	}

	/**
	 * Maps shortcode to Visual Composer
	 *
	 * @see vc_map()
	 */
	public function vcMap() {
		if (function_exists('vc_map')) {
			vc_map(array(
				'name'                      => esc_html__('Testimonials', 'mkd-core'),
				'base'                      => $this->base,
				'category'                  => 'by MIKADO',
				'icon'                      => 'icon-wpb-testimonials extended-custom-icon',
				'allowed_container_element' => 'vc_row',
				'params'                    => array(
					array(
						'type'        => 'dropdown',
						'admin_label' => true,
						'heading'     => esc_html__('Choose Testimonial Type', 'mkd-core'),
						'param_name'  => 'testimonial_type',
						'value'       => array(
							esc_html__('Testimonials Grid', 'mkd-core')          => 'testimonials-grid',
							esc_html__('Testimonials Slider Simple', 'mkd-core') => 'testimonials-slider',
							esc_html__('Testimonials Slider Boxed', 'mkd-core')  => 'testimonials-slider-boxed'
						),
						'save_always' => true
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__('Set Dark/Light type', 'mkd-core'),
						'param_name'  => 'dark_light_type',
						'value'       => array(
							esc_html__('Dark', 'mkd-core')  => 'dark',
							esc_html__('Light', 'mkd-core') => 'light',
						),
						'dependency'  => Array('element' => 'testimonial_type', 'value' => array('testimonials-grid', 'testimonials-slider')),
						'save_always' => true
					),
					array(
						'type'        => 'dropdown',
						'holder'      => 'div',
						'class'       => '',
						'heading'     => esc_html__('Items to Show', 'mkd-core'),
						'param_name'  => 'items_to_show',
						'value'       => array(
							esc_html__('Two', 'mkd-core')   => '2',
							esc_html__('Three', 'mkd-core') => '3',
							esc_html__('Four', 'mkd-core')  => '4'
						),
						'description' => '',
						'dependency'  => Array('element' => 'testimonial_type', 'value' => 'testimonials-slider-boxed'),
						'save_always' => true
					),
					array(
						'type'        => 'dropdown',
						'holder'      => 'div',
						'class'       => '',
						'heading'     => esc_html__('Number of Columns', 'mkd-core'),
						'param_name'  => 'number_of_columns',
						'value'       => array(
							esc_html__('Two', 'mkd-core')   => '2',
							esc_html__('Three', 'mkd-core') => '3',
							esc_html__('Four', 'mkd-core')  => '4'
						),
						'description' => '',
						'dependency'  => Array('element' => 'testimonial_type', 'value' => 'testimonials-grid'),
						'save_always' => true
					),
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_html__('Category', 'mkd-core'),
						'param_name'  => 'category',
						'value'       => '',
						'description' => esc_html__('Category Slug (leave empty for all)', 'mkd-core')
					),
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_html__('Number', 'mkd-core'),
						'param_name'  => 'number',
						'value'       => '',
						'description' => esc_html__('Number of Testimonials', 'mkd-core')
					),
					array(
						'type'        => 'dropdown',
						'admin_label' => true,
						'heading'     => esc_html__('Show Image', 'mkd-core'),
						'param_name'  => 'show_image',
						'value'       => array(
							esc_html__('Yes', 'mkd-core') => 'yes',
							esc_html__('No', 'mkd-core')  => 'no'
						),
						'save_always' => true,
						'description' => ''
					),
					array(
						'type'        => 'dropdown',
						'admin_label' => true,
						'heading'     => esc_html__('Show Author', 'mkd-core'),
						'param_name'  => 'show_author',
						'value'       => array(
							esc_html__('Yes', 'mkd-core') => 'yes',
							esc_html__('No', 'mkd-core')  => 'no'
						),
						'save_always' => true,
						'description' => ''
					),
					array(
						'type'        => 'dropdown',
						'admin_label' => true,
						'heading'     => esc_html__('Show Author Job Position', 'mkd-core'),
						'param_name'  => 'show_position',
						'value'       => array(
							esc_html__('Yes', 'mkd-core') => 'yes',
							esc_html__('No', 'mkd-core')  => 'no',
						),
						'save_always' => true,
						'dependency'  => array('element' => 'show_author', 'value' => array('yes')),
						'description' => ''
					)
				)
			));
		}
	}

	/**
	 * Renders shortcodes HTML
	 *
	 * @param $atts array of shortcode params
	 * @param $content string shortcode content
	 *
	 * @return string
	 */
	public function render($atts, $content = null) {

		$args = array(
			'testimonial_type'  => 'testimonials-grid',
			'number'            => '-1',
			'category'          => '',
			'show_image'        => 'yes',
			'show_author'       => 'yes',
			'show_position'     => 'yes',
			'animation_speed'   => '',
			'dark_light_type'   => '',
			'items_to_show'     => '',
			'number_of_columns' => ''
		);

		$params = shortcode_atts($args, $atts);

		//Extract params for use in method
		extract($params);

		$data_attr = $this->getDataParams($params);
		$query_args = $this->getQueryParams($params);

		$html = '';
		$html .= '<div class="mkd-testimonials-holder clearfix ' . $dark_light_type . '">';
		$html .= '<div class="mkd-testimonials ' . $testimonial_type . '" ' . $data_attr . '>';

		query_posts($query_args);
		if (have_posts()) :
			while (have_posts()) : the_post();
				$logo_image = get_post_meta(get_the_ID(), 'mkd_testimonaial_logo_image', true);
				$author = get_post_meta(get_the_ID(), 'mkd_testimonial_author', true);
				$text = get_post_meta(get_the_ID(), 'mkd_testimonial_text', true);
				$title = get_post_meta(get_the_ID(), 'mkd_testimonial_title', true);
				$job = get_post_meta(get_the_ID(), 'mkd_testimonial_author_position', true);

				$counter_classes = '';

				if ($params['dark_light_type'] == 'light') {
					$counter_classes .= 'light';
				}

				$params['light_class'] = $counter_classes;


				$params['columns_number'] = $this->getColumnNumberClass($params);

				$params['logo_image'] = $logo_image;
				$params['author'] = $author;
				$params['text'] = $text;
				$params['title'] = $title;
				$params['job'] = $job;
				$params['current_id'] = get_the_ID();

				$html .= mkd_core_get_shortcode_module_template_part('templates/' . $params['testimonial_type'], 'testimonials', '', $params);

			endwhile;
		else:
			$html .= esc_html__('Sorry, no posts matched your criteria.', 'mkd-core');
		endif;

		wp_reset_query();
		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}

	/**
	 * Generates testimonial data attribute array
	 *
	 * @param $params
	 *
	 * @return string
	 */
	private function getDataParams($params) {
		$data_attr = '';

		if (!empty($params['items_to_show'])) {
			$data_attr .= ' data-items-to-show ="' . $params['items_to_show'] . '"';
		}

		return $data_attr;
	}

	/**
	 * Generates testimonials query attribute array
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getQueryParams($params) {

		$args = array(
			'post_type'      => 'testimonials',
			'orderby'        => 'date',
			'order'          => 'ASC',
			'posts_per_page' => $params['number']
		);

		if ($params['category'] != '') {
			$args['testimonials_category'] = $params['category'];
		}

		return $args;
	}

	private function getColumnNumberClass($params) {

		$columnsNumber = '';
		$columns = $params['number_of_columns'];

		switch ($columns) {
			case 2:
				$columnsNumber = ' mkd-two-columns';
				break;
			case 3:
				$columnsNumber = ' mkd-three-columns';
				break;
			case 4:
				$columnsNumber = ' mkd-four-columns';
				break;
			default:
				$columnsNumber = ' mkd-three-column';
				break;
		}

		return $columnsNumber;
	}

}