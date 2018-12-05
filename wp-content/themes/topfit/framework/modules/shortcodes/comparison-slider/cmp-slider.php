<?php
namespace TopFit\Modules\Shortcodes\ComparisonSlider;

use TopFit\Modules\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class ComparisonSlider
 */
class ComparisonSlider implements ShortcodeInterface {
	private $base;

	function __construct() {
		$this->base = 'mkd_comparison_slider';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	/**
	 * Returns base for shortcode
	 * @return string
	 */
	public function getBase() {
		return $this->base;
	}

	public function vcMap() {

		vc_map(array(
			'name'                      => esc_html__('Comparison Slider', 'topfit'),
			'base'                      => $this->base,
			'category'                  => 'by MIKADO',
			'icon'                      => 'icon-wpb-comparison-slider extended-custom-icon',
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
				array(
					'type'        => 'attach_image',
					'admin_label' => true,
					'heading'     => esc_html__('Image Before', 'topfit'),
					'param_name'  => 'image_before',
					'description' => ''
				),
				array(
					'type'        => 'attach_image',
					'admin_label' => true,
					'heading'     => esc_html__('Image After', 'topfit'),
					'param_name'  => 'image_after',
					'description' => ''
				),
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__('Orientation', 'topfit'),
					'param_name'  => 'orientation',
					'value'       => array(
						esc_html__('Horizontal', 'topfit') => 'horizontal',
						esc_html__('Vertical', 'topfit')   => 'vertical',
					),
					'save_always' => true
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Default Offset', 'topfit'),
					'param_name'  => 'offset',
					'description' => esc_html__('Default value is 50 (%)', 'topfit')
				),
			)
		));

	}

	public function render($atts, $content = null) {

		$args = array(
			'image_before' => '',
			'image_after'  => '',
			'orientation'  => 'horizontal',
			'offset'       => ''
		);

		$params = shortcode_atts($args, $atts);

		$params['data_attrs'] = $this->getDataAttribute($params);

		$html = topfit_mikado_get_shortcode_module_template_part('templates/cmp-slider-template', 'comparison-slider', '', $params);

		return $html;
	}

	private function getDataAttribute($params) {

		$data_attrs = array();

		if ($params['orientation'] !== '') {
			$data_attrs['data-orientation'] = $params['orientation'];
		}

		$data_attrs['data-offset'] = $params['offset'] !== '' ? $params['offset'] : 50;

		return $data_attrs;
	}
}