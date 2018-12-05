<?php
namespace TopFit\Modules\ElementsHolder;

use TopFit\Modules\Shortcodes\Lib\ShortcodeInterface;

class ElementsHolder implements ShortcodeInterface {
	private $base;

	function __construct() {
		$this->base = 'mkd_elements_holder';
		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'      => esc_html__('Elements Holder', 'topfit'),
			'base'      => $this->base,
			'icon'      => 'icon-wpb-elements-holder extended-custom-icon',
			'category'  => 'by MIKADO',
			'as_parent' => array('only' => 'mkd_elements_holder_item, mkd_info_box'),
			'js_view'   => 'VcColumnView',
			'params'    => array(
				array(
					'type'        => 'colorpicker',
					'class'       => '',
					'heading'     => esc_html__('Background Color', 'topfit'),
					'param_name'  => 'background_color',
					'value'       => '',
					'description' => ''
				),
				array(
					'type'        => 'checkbox',
					'class'       => '',
					'heading'     => esc_html__('Items Float Left', 'topfit'),
					'param_name'  => 'items_float_left',
					'value'       => array(esc_html__('Make Items Float Left?', 'topfit') => 'yes'),
					'description' => ''
				),
				array(
					'type'        => 'dropdown',
					'class'       => '',
					'group'       => esc_html__('Width & Responsiveness', 'topfit'),
					'heading'     => esc_html__('Switch to One Column', 'topfit'),
					'param_name'  => 'switch_to_one_column',
					'value'       => array(
						esc_html__('Default', 'topfit')      => '',
						esc_html__('Below 1440px', 'topfit') => '1440',
						esc_html__('Below 1280px', 'topfit') => '1280',
						esc_html__('Below 1024px', 'topfit') => '1024',
						esc_html__('Below 768px', 'topfit')  => '768',
						esc_html__('Below 600px', 'topfit')  => '600',
						esc_html__('Below 480px', 'topfit')  => '480',
						esc_html__('Never', 'topfit')        => 'never'
					),
					'description' => esc_html__('Choose on which stage item will be in one column', 'topfit')
				),
				array(
					'type'        => 'dropdown',
					'class'       => '',
					'group'       => esc_html__('Width & Responsiveness', 'topfit'),
					'heading'     => esc_html__('Choose Alignment In Responsive Mode', 'topfit'),
					'param_name'  => 'alignment_one_column',
					'value'       => array(
						esc_html__('Default', 'topfit') => '',
						esc_html__('Left', 'topfit')    => 'left',
						esc_html__('Center', 'topfit')  => 'center',
						esc_html__('Right', 'topfit')   => 'right'
					),
					'description' => esc_html__('Alignment When Items are in One Column', 'topfit')
				)
			)
		));
	}

	public function render($atts, $content = null) {

		$args = array(
			'switch_to_one_column' => '',
			'alignment_one_column' => '',
			'items_float_left'     => '',
			'background_color'     => ''
		);
		$params = shortcode_atts($args, $atts);
		extract($params);

		$html = '';

		$elements_holder_classes = array();
		$elements_holder_classes[] = 'mkd-elements-holder';
		$elements_holder_style = '';

		if ($switch_to_one_column != '') {
			$elements_holder_classes[] = 'mkd-responsive-mode-' . $switch_to_one_column;
		} else {
			$elements_holder_classes[] = 'mkd-responsive-mode-768';
		}

		if ($alignment_one_column != '') {
			$elements_holder_classes[] = 'mkd-one-column-alignment-' . $alignment_one_column;
		}

		if ($items_float_left !== '') {
			$elements_holder_classes[] = 'mkd-elements-items-float';
		}

		if ($background_color != '') {
			$elements_holder_style .= 'background-color:' . $background_color . ';';
		}

		$elements_holder_class = implode(' ', $elements_holder_classes);

		$html .= '<div ' . topfit_mikado_get_class_attribute($elements_holder_class) . ' ' . topfit_mikado_get_inline_attr($elements_holder_style, 'style') . '>';
		$html .= do_shortcode($content);
		$html .= '</div>';

		return $html;

	}

}
