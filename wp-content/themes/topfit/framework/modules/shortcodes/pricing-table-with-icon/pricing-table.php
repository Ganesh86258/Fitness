<?php
namespace TopFit\Modules\PricingTableWithIcon;

use TopFit\Modules\Shortcodes\Lib\ShortcodeInterface;

class PricingTableWithIcon implements ShortcodeInterface {
	private $base;

	function __construct() {
		$this->base = 'mkd_pricing_table_with_icon';
		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'                      => esc_html__('Pricing Table With Icon', 'topfit'),
			'base'                      => $this->base,
			'icon'                      => 'icon-wpb-pricing-table-wi extended-custom-icon',
			'category'                  => 'by MIKADO',
			'allowed_container_element' => 'vc_row',
			'as_child'                  => array('only' => 'mkd_pricing_tables_with_icon'),
			'params'                    => array_merge(
				topfit_mikado_icon_collections()->getVCParamsArray(array(), '', true),
				array(
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_html__('Title', 'topfit'),
						'param_name'  => 'title',
						'value'       => esc_html__('Basic Package', 'topfit'),
						'description' => ''
					),
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_html__('Subtitle', 'topfit'),
						'param_name'  => 'subtitle',
						'value'       => '',
						'description' => ''
					),
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_html__('Price', 'topfit'),
						'param_name'  => 'price'
					),
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_html__('Currency', 'topfit'),
						'param_name'  => 'currency'
					),
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_html__('Price Period', 'topfit'),
						'param_name'  => 'price_period'
					),
					array(
						'type'        => 'dropdown',
						'admin_label' => true,
						'heading'     => esc_html__('Show Button', 'topfit'),
						'param_name'  => 'show_button',
						'value'       => array(
							esc_html__('Default', 'topfit') => '',
							esc_html__('Yes', 'topfit')     => 'yes',
							esc_html__('No', 'topfit')      => 'no'
						),
						'description' => '',
						'group'       => esc_html__('Button Options', 'topfit')
					),
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_html__('Button Text', 'topfit'),
						'param_name'  => 'button_text',
						'dependency'  => array(
							'element' => 'show_button',
							'value'   => 'yes'
						),
						'group'       => esc_html__('Button Options', 'topfit')
					),
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_html__('Button Link', 'topfit'),
						'param_name'  => 'link',
						'dependency'  => array(
							'element' => 'show_button',
							'value'   => 'yes'
						),
						'group'       => esc_html__('Button Options', 'topfit')
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__('Color', 'topfit'),
						'param_name'  => 'button_color',
						'dependency'  => array(
							'element' => 'show_button',
							'value'   => 'yes'
						),
						'group'       => esc_html__('Button Options', 'topfit'),
						'admin_label' => true
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__('Hover Color', 'topfit'),
						'param_name'  => 'button_hover_color',
						'dependency'  => array(
							'element' => 'show_button',
							'value'   => 'yes'
						),
						'group'       => esc_html__('Button Options', 'topfit'),
						'admin_label' => true
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__('Background Color', 'topfit'),
						'param_name'  => 'button_background_color',
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'show_button',
							'value'   => 'yes'
						),
						'group'       => esc_html__('Button Options', 'topfit')
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__('Hover Background Color', 'topfit'),
						'param_name'  => 'button_hover_background_color',
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'show_button',
							'value'   => 'yes'
						),
						'group'       => esc_html__('Button Options', 'topfit')
					),
					array(
						'type'       => 'colorpicker',
						'holder'     => 'div',
						'class'      => '',
						'heading'    => esc_html__('Background color', 'topfit'),
						'param_name' => 'background_color',
						'value'      => '',
					),
					array(
						'type'       => 'colorpicker',
						'holder'     => 'div',
						'class'      => '',
						'heading'    => esc_html__('Hover background color', 'topfit'),
						'param_name' => 'hover_background_color',
						'value'      => '',
					),
					array(
						'type'        => 'textarea_html',
						'holder'      => 'div',
						'class'       => '',
						'heading'     => esc_html__('Content', 'topfit'),
						'param_name'  => 'content',
						'value'       => '<li>' . esc_html__('content content content', 'topfit') . '</li><li>' . esc_html__('content content content', 'topfit') . '</li><li>' . esc_html__('content content content', 'topfit') . '</li>',
						'description' => ''
					)
				)
			)
		));
	}

	public function render($atts, $content = null) {
		$args = array(
			'title'                         => esc_html__('Basic Package', 'topfit'),
			'subtitle'                      => '',
			'price'                         => '100',
			'currency'                      => '',
			'price_period'                  => '',
			'link'                          => '',
			'button_text'                   => 'purchase',
			'background_color'              => '',
			'hover_background_color'        => '',
			'show_button'                   => 'yes',
			'button_color'                  => '',
			'button_hover_color'            => '',
			'button_background_color'       => '',
			'button_hover_background_color' => '',
		);

		$args = array_merge($args, topfit_mikado_icon_collections()->getShortcodeParams());
		$params = shortcode_atts($args, $atts);
		extract($params);

		$iconPackName = topfit_mikado_icon_collections()->getIconCollectionParamNameByKey($params['icon_pack']);
		$params['icon'] = $params[$iconPackName];

		$params['button_params'] = $this->getButtonParams($params);
		$params['button_data'] = $this->getButtonDataAttr($params);

		$params['content'] = $content;

		$params['inline_styles'] = $this->getInlineStyles($params);
		$params['data_attrs'] = $this->getDataAttr($params);

		$html = '';

		$html .= topfit_mikado_get_shortcode_module_template_part('templates/pricing-table-template', 'pricing-table-with-icon', '', $params);

		return $html;
	}


	/**
	 *
	 * Returns array of button data attr
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getButtonDataAttr($params) {
		$data = array();

		if (!empty($params['button_hover_background_color'])) {
			$data['data-hover-bg-color'] = $params['button_hover_background_color'];
		}

		if (!empty($params['button_hover_color'])) {
			$data['data-hover-color'] = $params['button_hover_color'];
		}

		return $data;
	}

	private function getButtonParams($params) {
		$buttonParams = array();

		if ($params['show_button'] === 'yes' && $params['button_text'] !== '') {
			$buttonParams = array(
				'link'       => $params['link'],
				'text'       => $params['button_text'],
				'size'       => 'medium',
				'type'       => 'solid',
				'hover_type' => 'solid',
			);

			if (!empty($params['button_color'])) {
				$buttonParams['color'] = $params['button_color'];
			}

			if (!empty($params['button_hover_color'])) {
				$buttonParams['hover_color'] = $params['button_hover_color'];
			}

			if (!empty($params['button_background_color'])) {
				$buttonParams['background_color'] = $params['button_background_color'];
				$buttonParams['border_color'] = $params['button_background_color'];
			}

			if (!empty($params['button_hover_background_color'])) {
				$buttonParams['hover_background_color'] = $params['button_hover_background_color'];
				$buttonParams['hover_border_color'] = $params['button_hover_background_color'];
			}
		}

		return $buttonParams;
	}

	private function getInlineStyles($params) {
		$styles = array();
		if (!empty($params['background_color'])) {
			$styles[] = 'background-color: ' . $params['background_color'];
		}

		return $styles;
	}

	private function getDataAttr($params) {
		$data = array();

		if (!empty($params['hover_background_color'])) {
			$data['data-hover-bg-color'] = $params['hover_background_color'];
		}

		return $data;
	}
}