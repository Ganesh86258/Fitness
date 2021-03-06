<?php
namespace TopFit\Modules\ImageWithTextOver;

use TopFit\Modules\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class ImageWithTextOver
 */
class ImageWithTextOver implements ShortcodeInterface {
	private $base;

	function __construct() {
		$this->base = 'mkd_image_with_text_over';

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
			'name'                      => esc_html__('Image With Text Over', 'topfit'),
			'base'                      => $this->base,
			'category'                  => 'by MIKADO',
			'icon'                      => 'icon-wpb-image-with-text-over extended-custom-icon',
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
				array(
					'type'        => 'attach_image',
					'admin_label' => true,
					'heading'     => esc_html__('Image', 'topfit'),
					'param_name'  => 'image',
					'description' => ''
				),
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__('Text', 'topfit'),
					'param_name'  => 'text',
					'description' => ''
				),
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__('Link', 'topfit'),
					'param_name'  => 'link',
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Link Target', 'topfit'),
					'param_name'  => 'link_target',
					'value'       => array(
						esc_html__('Same Window', 'topfit')     => '_self',
						esc_html__('New Window', 'topfit')      => '_blank'
					),
					'dependency'  => array(
						'element'   => 'link',
						'not_empty' => true
					),
					'save_always' => true
				),
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__('Font size (px)', 'topfit'),
					'param_name'  => 'font_size',
					'description' => ''
				),
			)
		));

	}

	public function render($atts, $content = null) {

		$args = array(
			'image'     => '',
			'text'      => '',
			'link'      => '',
			'link_target'      => '_self',
			'font_size' => ''
		);

		$params = shortcode_atts($args, $atts);

		$params['text_style'] = $this->getTextStyle($params);

		$html = topfit_mikado_get_shortcode_module_template_part('templates/image-with-text-over-template', 'image-with-text-over', '', $params);

		return $html;
	}

	/* Return Style for text
	*
	* @param $params
	*
	* @return string
	*/
	private function getTextStyle($params) {

		$styles = array();

		if (!empty($params['font_size'])) {
			$styles[] = 'font-size: ' . topfit_mikado_filter_px($params['font_size']) . 'px';
		}

		return $styles;
	}
}