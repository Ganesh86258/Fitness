<?php
namespace TopFit\Modules\Shortcodes\CardSliderItem;

use TopFit\Modules\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class Card Slider Item
 */
class CardSliderItem implements ShortcodeInterface {
	/**
	 * @var string
	 */
	private $base;

	public function __construct() {
		$this->base = 'mkd_card_slider_item';

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
			'name'                      => esc_html__('Card Slider Item', 'topfit'),
			'base'                      => $this->base,
			'category'                  => 'by MIKADO',
			'as_child'                  => array('only' => 'mkd_card_slider'),
			'icon'                      => 'icon-wpb-card-slider-item extended-custom-icon',
			'allowed_container_element' => 'vc_row',
			'params'                    => array_merge(
			    array(
                    array(
                        'type'       => 'attach_image',
                        'heading'    => esc_html__('Image', 'topfit'),
                        'param_name' => 'image',
                    ),
                ),
                topfit_mikado_icon_collections()->getVCParamsArray(array('element' => 'image', 'not_empty' => true), '', true),
                array(
                    array(
                        'type'       => 'textfield',
                        'heading'    => esc_html__('Title', 'topfit'),
                        'param_name' => 'title'
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => esc_html__('Title tag', 'topfit'),
                        'param_name'  => 'title_tag',
                        'value'       => array(
                            'h3' => 'h3',
                            'h4' => 'h4',
                            'h5' => 'h5'
                        ),
                        'save_always' => true,
                    ),
                    array(
                        'type'       => 'textfield',
                        'heading'    => esc_html__('Title Font Family', 'topfit'),
                        'param_name' => 'title_font_family'
                    ),
                    array(
                        'type'       => 'textfield',
                        'heading'    => esc_html__('Subtitle', 'topfit'),
                        'param_name' => 'subtitle'
                    ),
                    array(
                        'type'       => 'textfield',
                        'heading'    => esc_html__('Text', 'topfit'),
                        'param_name' => 'text'
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
                            ''                                 => '',
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
		$default_atts = array(
			'image'             => '',
			'title'             => '',
			'title_tag'         => 'h3',
			'title_font_family' => '',
			'subtitle'          => '',
			'text'              => '',
			'link'              => '',
			'link_text'         => '',
			'link_target'       => '_self',
			'color'             => '',
		);

        $default_atts = array_merge($default_atts, topfit_mikado_icon_collections()->getShortcodeParams());
		$params = shortcode_atts($default_atts, $atts);

        extract($params);

        $iconPackName = topfit_mikado_icon_collections()->getIconCollectionParamNameByKey($params['icon_pack']);
        if($iconPackName) {
            $params['icon'] = $params[$iconPackName];
        }
		$params['button_parameters'] = $this->getButtonParameters($params);
		$params['title_inline_styles'] = $this->getInlineStyles($params);

		return topfit_mikado_get_shortcode_module_template_part('templates/card-slide', 'card-slider', '', $params);
	}

	private function getButtonParameters($params) {
		$button_params_array = array();

		$button_params_array['type'] = 'underline';
		$button_params_array['custom_class'] = 'mkd-card-slider-link';

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

	private function getInlineStyles($params) {
		$styles = array();

		if (!empty($params['title_font_family'])) {
			$styles[] = 'font-family: ' . $params['title_font_family'];
		}

		return $styles;
	}
}