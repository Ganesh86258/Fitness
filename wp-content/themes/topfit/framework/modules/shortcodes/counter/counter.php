<?php
namespace TopFit\Modules\Counter;

use TopFit\Modules\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class Counter
 */
class Counter implements ShortcodeInterface {

	/**
	 * @var string
	 */
	private $base;

	public function __construct() {
		$this->base = 'mkd_counter';

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
	 * Maps shortcode to Visual Composer. Hooked on vc_before_init
	 *
	 * @see mkd_core_get_carousel_slider_array_vc()
	 */
	public function vcMap() {

		vc_map(array(
			'name'                      => esc_html__('Counter', 'topfit'),
			'base'                      => $this->getBase(),
			'category'                  => 'by MIKADO',
			'admin_enqueue_css'         => array(topfit_mikado_get_skin_uri() . '/assets/css/mkd-vc-extend.css'),
			'icon'                      => 'icon-wpb-counter extended-custom-icon',
			'allowed_container_element' => 'vc_row',
			'params'                    =>
				array(
					array(
						'type'        => 'dropdown',
						'admin_label' => true,
						'heading'     => esc_html__('Type', 'topfit'),
						'param_name'  => 'type',
						'value'       => array(
							esc_html__('Zero Counter', 'topfit')   => 'zero',
							esc_html__('Random Counter', 'topfit') => 'random'
						),
						'save_always' => true,
						'description' => ''
					),
					array(
						'type'        => 'dropdown',
						'admin_label' => true,
						'heading'     => esc_html__('Style', 'topfit'),
						'param_name'  => 'counter_style',
						'value'       => array(
							esc_html__('Dark', 'topfit')  => 'dark',
							esc_html__('Light', 'topfit') => 'light'
						),
						'description' => '',
						'save_always' => true
					),
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_html__('Digit', 'topfit'),
						'param_name'  => 'digit',
						'description' => ''
					),
                    array(
                        'type'        => 'dropdown',
                        'admin_label' => true,
                        'heading'     => esc_html__('Digit Position', 'topfit'),
                        'param_name'  => 'digit_position',
                        'value'       => array(
                            esc_html__('Left', 'topfit') => 'left',
                            esc_html__('Top', 'topfit')  => 'top',
                        ),
                        'description' => '',
                        'save_always' => true
                    ),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Title', 'topfit'),
						'param_name'  => 'title',
						'admin_label' => true,
						'description' => ''
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Text', 'topfit'),
						'param_name'  => 'text',
						'admin_label' => true,
						'description' => ''
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Link', 'topfit'),
						'param_name'  => 'link',
						'value'       => '',
						'admin_label' => true
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__('Link Text', 'topfit'),
						'param_name' => 'link_text',
						'dependency' => array(
							'element'   => 'link',
							'not_empty' => true
						)
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__('Target', 'topfit'),
						'param_name' => 'link_target',
						'value'      => array(
							''                              => '',
							esc_html__('Self', 'topfit')  => '_self',
							esc_html__('Blank', 'topfit') => '_blank'
						),
						'dependency' => array(
							'element'   => 'link',
							'not_empty' => true
						),
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__('Link Color', 'topfit'),
						'param_name'  => 'color',
						'dependency'  => array(
							'element'   => 'link',
							'not_empty' => true
						),
						'admin_label' => true
					)
				)
		));
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
			'type'          => '',
			'digit'         => '',
            'digit_position'=> 'left',
			'title'         => '',
			'text'          => '',
			'counter_style' => 'dark',
			'link'          => '',
			'link_text'     => '',
			'link_target'   => '_self',
			'color'         => ''
		);

		$params = shortcode_atts($args, $atts);

		$params['counter_classes'] = $this->getCounterClasses($params);
		$params['button_parameters'] = $this->getButtonParameters($params);

		//Get HTML from template
		$html = topfit_mikado_get_shortcode_module_template_part('templates/counter-template', 'counter', '', $params);

		return $html;

	}

	/**
	 * Returns array of holder classes
	 *
	 * @param $params
	 *
	 * @return array
	 */

	private function getCounterClasses($params) {
		$counter_classes = array('mkd-counter-holder');

		if ($params['counter_style'] === 'light') {
			$counter_classes[] = 'mkd-counter-light';
		}
        if ($params['digit_position'] === 'top') {
            $counter_classes[] = 'mkd-counter-top';
        }

		return $counter_classes;
	}

	private function getButtonParameters($params) {
		$button_params_array = array();

		$button_params_array['type'] = 'underline';
		$button_params_array['custom_class'] = 'mkd-counter-link';

		if (!empty($params['link_text'])) {
			$button_params_array['text'] = $params['link_text'];
		}

		if (!empty($params['link'])) {
			$button_params_array['link'] = $params['link'];
		}

		if (!empty($params['target'])) {
			$button_params_array['target'] = $params['target'];
		}

		if (!empty($params['color'])) {
			$button_params_array['color'] = $params['color'];
		}

		return $button_params_array;
	}

}