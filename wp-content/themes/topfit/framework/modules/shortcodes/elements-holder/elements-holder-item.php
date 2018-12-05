<?php
namespace TopFit\Modules\ElementsHolderItem;

use TopFit\Modules\Shortcodes\Lib\ShortcodeInterface;

class ElementsHolderItem implements ShortcodeInterface {
	private $base;

	function __construct() {
		$this->base = 'mkd_elements_holder_item';
		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		if (function_exists('vc_map')) {
			vc_map(
				array(
					'name'                    => esc_html__('Elements Holder Item', 'topfit'),
					'base'                    => $this->base,
					'class'                   => 'extra-class-name-eh',
					'as_child'                => array('only' => 'mkd_elements_holder'),
					'as_parent'               => array('except' => 'vc_row, vc_accordion, no_cover_boxes, no_portfolio_list, no_portfolio_slider'),
					'content_element'         => true,
					'category'                => 'by MIKADO',
					'icon'                    => 'icon-wpb-elements-holder-item extended-custom-icon',
					'show_settings_on_create' => true,
					'js_view'                 => 'VcColumnView',
					'params'                  => array(
						array(
							'type'        => 'dropdown',
							'class'       => '',
							'heading'     => esc_html__('Width', 'topfit'),
							'param_name'  => 'item_width',
							'value'       => array(
								'1/1' => '1-1',
								'1/2' => '1-2',
								'1/3' => '1-3',
								'2/3' => '2-3',
								'1/4' => '1-4',
								'3/4' => '3-4',
								'1/5' => '1-5',
								'2/5' => '2-5',
								'3/5' => '3-5',
								'4/5' => '4-5',
								'1/6' => '1-6',
								'5/6' => '5-6',
							),
							'save_always' => true,
							'description' => ''
						),
						array(
							'type'        => 'colorpicker',
							'class'       => '',
							'heading'     => esc_html__('Background Color', 'topfit'),
							'param_name'  => 'background_color',
							'value'       => '',
							'description' => ''
						),
						array(
							'type'        => 'attach_image',
							'class'       => '',
							'heading'     => esc_html__('Background Image', 'topfit'),
							'param_name'  => 'background_image',
							'value'       => '',
							'description' => ''
						),
						array(
							'type'        => 'textfield',
							'class'       => '',
							'heading'     => esc_html__('Padding', 'topfit'),
							'param_name'  => 'item_padding',
							'value'       => '',
							'description' => esc_html__('Please insert padding in format 0px 10px 0px 10px', 'topfit')
						),
						array(
							'type'        => 'dropdown',
							'class'       => '',
							'heading'     => esc_html__('Inner Border', 'topfit'),
							'param_name'  => 'inner_border',
							'value'       => array(
								esc_html__('No', 'topfit')  => 'no',
								esc_html__('Yes', 'topfit') => 'yes'
							),
							'description' => ''
						),
						array(
							'type'        => 'colorpicker',
							'class'       => '',
							'heading'     => esc_html__('Border Color', 'topfit'),
							'param_name'  => 'inner_border_color',
							'value'       => '',
							'description' => '',
							'dependency'  => array(
								'element' => 'inner_border',
								'value' => array('yes')
							)
						),
						array(
							'type'        => 'dropdown',
							'class'       => '',
							'heading'     => esc_html__('Horizontal Alignment', 'topfit'),
							'param_name'  => 'horizontal_aligment',
							'value'       => array(
								esc_html__('Left', 'topfit')   => 'left',
								esc_html__('Right', 'topfit')  => 'right',
								esc_html__('Center', 'topfit') => 'center'
							),
							'description' => ''
						),
						array(
							'type'        => 'dropdown',
							'class'       => '',
							'heading'     => esc_html__('Vertical Alignment', 'topfit'),
							'param_name'  => 'vertical_alignment',
							'value'       => array(
								esc_html__('Middle', 'topfit') => 'middle',
								esc_html__('Top', 'topfit')    => 'top',
								esc_html__('Bottom', 'topfit') => 'bottom'
							),
							'description' => ''
						),
						array(
							'type'        => 'dropdown',
							'class'       => '',
							'heading'     => esc_html__('Animation Name', 'topfit'),
							'param_name'  => 'animation_name',
							'value'       => array(
								esc_html__('No Animation', 'topfit')          => '',
								esc_html__('Flip In', 'topfit')               => 'flip-in',
								esc_html__('Grow In', 'topfit')               => 'grow-in',
								esc_html__('X Rotate', 'topfit')              => 'x-rotate',
								esc_html__('Z Rotate', 'topfit')              => 'z-rotate',
								esc_html__('Y Translate', 'topfit')           => 'y-translate',
								esc_html__('Fade In', 'topfit')               => 'fade-in',
								esc_html__('Fade In Down', 'topfit')          => 'fade-in-down',
								esc_html__('Fade In Left X Rotate', 'topfit') => 'fade-in-left-x-rotate'
							),
							'description' => ''
						),
						array(
							'type'        => 'textfield',
							'class'       => '',
							'heading'     => esc_html__('Animation Delay (ms)', 'topfit'),
							'param_name'  => 'animation_delay',
							'value'       => '',
							'description' => '',
							'dependency'  => array(
								'element'   => 'animation_name',
								'not_empty' => true
							)
						),
						array(
							'type'        => 'textfield',
							'class'       => '',
							'group'       => esc_html__('Width & Responsiveness', 'topfit'),
							'heading'     => esc_html__('Padding on screen size between 1280px-1440px', 'topfit'),
							'param_name'  => 'item_padding_1280_1440',
							'value'       => '',
							'description' => esc_html__('Please insert padding in format 0px 10px 0px 10px', 'topfit')
						),
						array(
							'type'        => 'textfield',
							'class'       => '',
							'group'       => esc_html__('Width & Responsiveness', 'topfit'),
							'heading'     => esc_html__('Padding on screen size between 1024px-1280px', 'topfit'),
							'param_name'  => 'item_padding_1024_1280',
							'value'       => '',
							'description' => esc_html__('Please insert padding in format 0px 10px 0px 10px', 'topfit')
						),
						array(
							'type'        => 'textfield',
							'class'       => '',
							'group'       => esc_html__('Width & Responsiveness', 'topfit'),
							'heading'     => esc_html__('Padding on screen size between 768px-1024px', 'topfit'),
							'param_name'  => 'item_padding_768_1024',
							'value'       => '',
							'description' => esc_html__('Please insert padding in format 0px 10px 0px 10px', 'topfit')
						),
						array(
							'type'        => 'textfield',
							'class'       => '',
							'group'       => esc_html__('Width & Responsiveness', 'topfit'),
							'heading'     => esc_html__('Padding on screen size between 600px-768px', 'topfit'),
							'param_name'  => 'item_padding_600_768',
							'value'       => '',
							'description' => esc_html__('Please insert padding in format 0px 10px 0px 10px', 'topfit')
						),
						array(
							'type'        => 'textfield',
							'class'       => '',
							'group'       => esc_html__('Width & Responsiveness', 'topfit'),
							'heading'     => esc_html__('Padding on screen size between 480px-600px', 'topfit'),
							'param_name'  => 'item_padding_480_600',
							'value'       => '',
							'description' => esc_html__('Please insert padding in format 0px 10px 0px 10px', 'topfit')
						),
						array(
							'type'        => 'textfield',
							'class'       => '',
							'group'       => esc_html__('Width & Responsiveness', 'topfit'),
							'heading'     => esc_html__('Padding on Screen Size Bellow 480px', 'topfit'),
							'param_name'  => 'item_padding_480',
							'value'       => '',
							'description' => esc_html__('Please insert padding in format 0px 10px 0px 10px', 'topfit')
						)
					)
				)
			);
		}
	}

	public function render($atts, $content = null) {
		$args = array(
			'item_width'             => '1-1',
			'background_color'       => '',
			'background_image'       => '',
			'item_padding'           => '',
			'inner_border'           => '',
			'inner_border_color'     => '',
			'horizontal_aligment'    => 'left',
			'vertical_alignment'     => '',
			'animation_name'         => '',
			'animation_delay'        => '',
			'item_padding_1280_1440' => '',
			'item_padding_1024_1280' => '',
			'item_padding_768_1024'  => '',
			'item_padding_600_768'   => '',
			'item_padding_480_600'   => '',
			'item_padding_480'       => ''
		);

		$params = shortcode_atts($args, $atts);
		extract($params);
		$params['content'] = $content;

		$rand_class = 'mkd-elements-holder-custom-' . mt_rand(100000, 1000000);

		$params['elements_holder_item_style'] = $this->getElementsHolderItemStyle($params);
		$params['elements_holder_item_content_style'] = $this->getElementsHolderItemContentStyle($params);
		$params['elements_holder_item_content_inner_style'] = $this->getElementsHolderItemContentInnerStyle($params);
		$params['elements_holder_item_class'] = $this->getElementsHolderItemClass($params);
		$params['elements_holder_item_content_class'] = $rand_class;
		$params['elements_holder_item_content_responsive'] = $this->getElementsHolderItemContentResponsiveStyle($params);
		$params['elements_holder_item_data'] = $this->getData($params);

		$html = topfit_mikado_get_shortcode_module_template_part('templates/elements-holder-item-template', 'elements-holder', '', $params);

		return $html;
	}


	/**
	 * Return Elements Holder Item style
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getElementsHolderItemStyle($params) {

		$element_holder_item_style = array();

		if ($params['background_color'] !== '') {
			$element_holder_item_style[] = 'background-color: ' . $params['background_color'];
		}
		if ($params['background_image'] !== '') {
			$element_holder_item_style[] = 'background-image: url(' . wp_get_attachment_url($params['background_image']) . ')';
		}
		if ($params['animation_delay'] !== '') {
			$element_holder_item_style[] = 'transition-delay:' . $params['animation_delay'] . 'ms;' . '-webkit-transition-delay:' . $params['animation_delay'] . 'ms';
		}

		return implode(';', $element_holder_item_style);

	}

	/**
	 * Return Elements Holder Item Content style
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getElementsHolderItemContentStyle($params) {

		$element_holder_item_content_style = array();

		if ($params['item_padding'] !== '') {
			$element_holder_item_content_style[] = 'padding: ' . $params['item_padding'];
		}

		return implode(';', $element_holder_item_content_style);

	}

	/**
	 * Return Elements Holder Item Content Responssive style
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getElementsHolderItemContentResponsiveStyle($params) {

		$element_holder_item_responsive_style = array();

		if ($params['item_padding_1280_1440'] !== '') {
			$element_holder_item_responsive_style['item_padding_1280_1440'] = $params['item_padding_1280_1440'];
		}
		if ($params['item_padding_1024_1280'] !== '') {
			$element_holder_item_responsive_style['item_padding_1024_1280'] = $params['item_padding_1024_1280'];
		}
		if ($params['item_padding_768_1024'] !== '') {
			$element_holder_item_responsive_style['item_padding_768_1024'] = $params['item_padding_768_1024'];
		}
		if ($params['item_padding_600_768'] !== '') {
			$element_holder_item_responsive_style['item_padding_600_768'] = $params['item_padding_600_768'];
		}
		if ($params['item_padding_480_600'] !== '') {
			$element_holder_item_responsive_style['item_padding_480_600'] = $params['item_padding_480_600'];
		}
		if ($params['item_padding_480'] !== '') {
			$element_holder_item_responsive_style['item_padding_480'] = $params['item_padding_480'];
		}

		return $element_holder_item_responsive_style;

	}

	/**
	 * Return Elements Holder Item classes
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getElementsHolderItemClass($params) {

		$element_holder_item_class = array();

		if ($params['item_width'] !== '') {
			$element_holder_item_class[] = 'mkd-width-' . $params['item_width'];
		}

		if ($params['vertical_alignment'] !== '') {
			$element_holder_item_class[] = 'mkd-vertical-alignment-' . $params['vertical_alignment'];
		}

		if ($params['horizontal_aligment'] !== '') {
			$element_holder_item_class[] = 'mkd-horizontal-alignment-' . $params['horizontal_aligment'];
		}

		if ($params['animation_name'] !== '') {
			$element_holder_item_class[] = 'mkd-' . $params['animation_name'];
		}


		return implode(' ', $element_holder_item_class);

	}

	private function getData($params) {
		$data = array();

		if ($params['animation_name'] !== '') {
			$data['data-animation'] = 'mkd-' . $params['animation_name'];
		}

		return $data;
	}

	/**
	 * Return Elements Holder Item Content style
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getElementsHolderItemContentInnerStyle($params) {

		$element_holder_item_content_inner_style = array();

		if ($params['inner_border_color'] !== '') {
			$element_holder_item_content_inner_style[] = 'border-color: ' . $params['inner_border_color'];
		}

		return implode(';', $element_holder_item_content_inner_style);

	}
}
