<?php
namespace TopFit\Modules\GoogleMap;

use TopFit\Modules\Shortcodes\Lib\ShortcodeInterface;

class GoogleMap implements ShortcodeInterface {
	private $base;

	function __construct() {
		$this->base = 'mkd_google_map';
		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {

		vc_map(
			array(
				'name'                    => esc_html__('Google Map', 'topfit'),
				'base'                    => $this->base,
				'category'                => 'by MIKADO',
				'icon'                    => 'icon-wpb-google-map extended-custom-icon',
				'show_settings_on_create' => true,
				'params'                  => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Address 1', 'topfit'),
						'param_name'  => 'address1',
						'admin_label' => true
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Address 2', 'topfit'),
						'param_name'  => 'address2',
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'address1',
							'not_empty' => true
						)
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Address 3', 'topfit'),
						'param_name'  => 'address3',
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'address2',
							'not_empty' => true
						)
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Address 4', 'topfit'),
						'param_name'  => 'address4',
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'address3',
							'not_empty' => true
						)
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Address 5', 'topfit'),
						'param_name'  => 'address5',
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'address4',
							'not_empty' => true
						)
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__('Custom Map Style', 'topfit'),
						'param_name'  => 'custom_map_style',
						'value'       => array(
							esc_html__('No', 'topfit')  => 'false',
							esc_html__('Yes', 'topfit') => 'true'
						),
						'save_always' => true,
						'description' => esc_html__('Enabling this option will allow Map editing', 'topfit')
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__('Color Overlay', 'topfit'),
						'param_name'  => 'color_overlay',
						'description' => esc_html__('Choose a Map color overlay', 'topfit'),
						'dependency'  => array(
							'element' => 'custom_map_style',
							'value' => array('true')
						)
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Saturation', 'topfit'),
						'param_name'  => 'saturation',
						'description' => esc_html__('Choose a level of saturation (-100 = least saturated, 100 = most saturated)', 'topfit'),
						'dependency'  => array(
							'element' => 'custom_map_style',
							'value' => array('true')
						)
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Lightness', 'topfit'),
						'param_name'  => 'lightness',
						'description' => esc_html__('Choose a level of lightness (-100 = darkest, 100 = lightest)', 'topfit'),
						'dependency'  => array(
							'element' => 'custom_map_style',
							'value' => array('true')
						)
					),
					array(
						'type'        => 'attach_image',
						'heading'     => esc_html__('Pin', 'topfit'),
						'param_name'  => 'pin',
						'description' => esc_html__('Select a pin image to be used on Google Map', 'topfit')
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Map Zoom', 'topfit'),
						'param_name'  => 'zoom',
						'description' => esc_html__('Enter a zoom factor for Google Map (0 = whole worlds, 19 = individual buildings)', 'topfit')
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__('Zoom Map on Mouse Wheel', 'topfit'),
						'param_name'  => 'scroll_wheel',
						'value'       => array(
							esc_html__('No', 'topfit')  => 'false',
							esc_html__('Yes', 'topfit') => 'true'
						),
						'save_always' => true,
						'description' => esc_html__('Enabling this option will allow users to zoom in on Map using mouse wheel', 'topfit')
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__('Map Height', 'topfit'),
						'param_name' => 'map_height'
					)

				)
			));
	}

	public function render($atts, $content = null) {
		$args = array(
			'address1'         => '',
			'address2'         => '',
			'address3'         => '',
			'address4'         => '',
			'address5'         => '',
			'custom_map_style' => false,
			'color_overlay'    => '#eaeaea',
			'saturation'       => '-100',
			'lightness'        => '0',
			'zoom'             => '12',
			'pin'              => '',
			'scroll_wheel'     => false,
			'map_height'       => '477'
		);

		$params = shortcode_atts($args, $atts);
		extract($params);

		$rand_id = mt_rand(100000, 3000000);

		$params['map_data'] = $this->getMapDate($params, $rand_id);
		$params['map_id'] = 'mkd-map-' . $rand_id;

		$html = topfit_mikado_get_shortcode_module_template_part('templates/google-map-template', 'google-map', '', $params);

		return $html;
	}


	/**
	 * Return Elements Holder Item style
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getMapDate($params, $id) {

		$map_data = array();

		$addresses_array = array();
		if ($params['address1'] != '') {
			array_push($addresses_array, esc_attr($params['address1']));
		}
		if ($params['address2'] != '') {
			array_push($addresses_array, esc_attr($params['address2']));
		}
		if ($params['address3'] != '') {
			array_push($addresses_array, esc_attr($params['address3']));
		}
		if ($params['address4'] != '') {
			array_push($addresses_array, esc_attr($params['address4']));
		}
		if ($params['address5'] != '') {
			array_push($addresses_array, esc_attr($params['address5']));
		}

		if ($params['pin'] != "") {
			$map_pin = wp_get_attachment_image_src($params['pin'], 'full', true);
			$map_pin = $map_pin[0];
		} else {
			$map_pin = get_template_directory_uri() . "/assets/img/pin.png";
		}

		$map_data[] = "data-addresses='[\"" . implode('","', $addresses_array) . "\"]'";
		$map_data[] = 'data-custom-map-style=' . $params['custom_map_style'];
		$map_data[] = 'data-color-overlay=' . $params['color_overlay'];
		$map_data[] = 'data-saturation=' . $params['saturation'];
		$map_data[] = 'data-lightness=' . $params['lightness'];
		$map_data[] = 'data-zoom=' . $params['zoom'];
		$map_data[] = 'data-pin=' . $map_pin;
		$map_data[] = 'data-unique-id=' . $id;
		$map_data[] = 'data-scroll-wheel=' . $params['scroll_wheel'];
		$map_data[] = 'data-height=' . $params['map_height'];

		return implode(' ', $map_data);

	}


}
