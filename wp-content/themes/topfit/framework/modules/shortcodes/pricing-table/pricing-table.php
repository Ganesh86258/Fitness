<?php
namespace TopFit\Modules\PricingTable;

use TopFit\Modules\Shortcodes\Lib\ShortcodeInterface;

class PricingTable implements ShortcodeInterface {
	private $base;

	function __construct() {
		$this->base = 'mkd_pricing_table';
		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'                      => esc_html__('Pricing Table', 'topfit'),
			'base'                      => $this->base,
			'icon'                      => 'icon-wpb-pricing-table extended-custom-icon',
			'category'                  => 'by MIKADO',
			'allowed_container_element' => 'vc_row',
			'as_child'                  => array('only' => 'mkd_pricing_tables'),
			'params'                    => array(
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__('Title', 'topfit'),
					'param_name'  => 'title',
					'value'       => esc_html__('Basic Plan', 'topfit'),
					'description' => ''
				),
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__('Title Size (px)', 'topfit'),
					'param_name'  => 'title_size',
					'value'       => '',
					'description' => '',
					'dependency'  => array(
						'element'   => 'title',
						'not_empty' => true
					)
				),
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__('Price', 'topfit'),
					'param_name'  => 'price'
				),
				array(
					'type'        => 'colorpicker',
					'admin_label' => true,
					'heading'     => esc_html__('Price color', 'topfit'),
					'param_name'  => 'price_color',
					'value'       => '',
					'description' => '',
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
					'description' => ''
				),
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__('Button Text', 'topfit'),
					'param_name'  => 'button_text',
					'dependency'  => array(
						'element' => 'show_button',
						'value'   => 'yes'
					)
				),
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__('Button Link', 'topfit'),
					'param_name'  => 'link',
					'dependency'  => array(
						'element' => 'show_button',
						'value'   => 'yes'
					)
				),
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__('Active', 'topfit'),
					'param_name'  => 'active',
					'value'       => array(
						esc_html__('No', 'topfit')  => 'no',
						esc_html__('Yes', 'topfit') => 'yes'
					),
					'save_always' => true,
					'description' => ''
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
		));
	}

	public function render($atts, $content = null) {

		$args = array(
			'title'        => esc_html__('Basic Plan', 'topfit'),
			'title_size'   => '',
			'price'        => '100',
			'price_color'  => '',
			'currency'     => '',
			'price_period' => '',
			'active'       => 'no',
			'show_button'  => 'yes',
			'link'         => '',
			'button_text'  => 'button'
		);
		$params = shortcode_atts($args, $atts);
		extract($params);

		$html = '';
		$pricing_table_clasess = 'mkd-price-table';

		if ($active == 'yes') {
			$pricing_table_clasess .= ' mkd-pt-active';
		}

		$params['pricing_table_classes'] = $pricing_table_clasess;
		$params['content'] = $content;
		$params['button_params'] = $this->getButtonParams($params);

		$params['price_styles'] = array();

		if (!empty($params['price_color'])) {
			$params['price_styles'][] = 'color: ' . $params['price_color'];
		}

		$params['title_styles'] = array();

		if (!empty($params['title_size'])) {
			$params['title_styles'][] = 'font-size: ' . topfit_mikado_filter_px($params['title_size']) . 'px';
		}

		$html .= topfit_mikado_get_shortcode_module_template_part('templates/pricing-table-template', 'pricing-table', '', $params);

		return $html;

	}

	private function getButtonParams($params) {
		$buttonParams = array();

		if ($params['show_button'] === 'yes' && $params['button_text'] !== '') {
			$buttonParams = array(
				'link'       => $params['link'],
				'text'       => $params['button_text'],
				'size'       => 'small',
				'type'       => 'solid',
				'hover_type' => 'solid'
			);
		}

		return $buttonParams;
	}

}
