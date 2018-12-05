<?php
namespace TopFit\Modules\Shortcodes\Process;

use TopFit\Modules\Shortcodes\Lib\ShortcodeInterface;

class ProcessItem implements ShortcodeInterface {
	private $base;

	public function __construct() {
		$this->base = 'mkd_process_item';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'                    => esc_html__('Process Item', 'topfit'),
			'base'                    => $this->getBase(),
			'as_child'                => array('only' => 'mkd_process_holder'),
			'category'                => 'by MIKADO',
			'icon'                    => 'icon-wpb-call-to-action extended-custom-icon',
			'show_settings_on_create' => true,
			'params'                  => array_merge(
				\TopFitMikadoIconCollections::get_instance()->getVCParamsArray(),
				array(
					array(
						'type'       => 'attach_image',
						'heading'    => esc_html__('Image', 'topfit'),
						'param_name' => 'image'
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Title', 'topfit'),
						'param_name'  => 'title',
						'save_always' => true,
						'admin_label' => true
					),
					array(
						'type'        => 'textarea',
						'heading'     => esc_html__('Text', 'topfit'),
						'param_name'  => 'text',
						'save_always' => true,
						'admin_label' => true
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
						'param_name' => 'target',
						'value'      => array(
							''                                 => '',
							esc_html__('Self', 'topfit')  => '_self',
							esc_html__('Blank', 'topfit') => '_blank'
						),
						'dependency' => array(
							'element'   => 'link',
							'not_empty' => true
						)
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
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__('Highlight Item?', 'topfit'),
						'param_name'  => 'highlighted',
						'value'       => array(
							esc_html__('No', 'topfit')  => 'no',
							esc_html__('Yes', 'topfit') => 'yes'
						),
						'save_always' => true,
						'admin_label' => true
					)
				))
		));
	}

	public function render($atts, $content = null) {
		$default_atts = array(
			'image'       => '',
			'title'       => '',
			'text'        => '',
			'link'        => '',
			'link_text'   => '',
			'color'       => '',
			'target'      => '_self',
			'highlighted' => ''
		);

		$default_atts = array_merge($default_atts, topfit_mikado_icon_collections()->getShortcodeParams());

		$params = shortcode_atts($default_atts, $atts);

		$params['icon_parameters'] = $this->getIconParameters($params);

		$params['button_parameters'] = $this->getButtonParameters($params);

		$params['item_classes'] = array(
			'mkd-process-item-holder'
		);

		if ($params['highlighted'] === 'yes') {
			$params['item_classes'][] = 'mkd-pi-highlighted';
		}

		return topfit_mikado_get_shortcode_module_template_part('templates/process-item-template', 'process', '', $params);
	}

	/**
	 * Returns parameters for icon shortcode as a string
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getIconParameters($params) {
		$params_array = array();

		if (empty($params['custom_icon'])) {
			$iconPackName = topfit_mikado_icon_collections()->getIconCollectionParamNameByKey($params['icon_pack']);

			$params_array['icon_pack'] = $params['icon_pack'];
			$params_array[$iconPackName] = $params[$iconPackName];

			$params_array['size'] = 'mkd-icon-medium';
		}

		return $params_array;
	}

	private function getButtonParameters($params) {
		$button_params_array = array();

		$button_params_array['type'] = 'underline';

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