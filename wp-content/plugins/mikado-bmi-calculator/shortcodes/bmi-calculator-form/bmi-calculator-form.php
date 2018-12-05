<?php
namespace MikadoBmiCalculator\Shortcodes;

use MikadoBmiCalculator\Lib\ShortcodeInterface;

class BmiCalculatorForm implements ShortcodeInterface {
	private $base;

	/**
	 * BmiCalculatorForm constructor.
	 */
	public function __construct() {
		$this->base = 'mkd_bmi_calculator';

		add_action('vc_before_init', array($this, 'vcMap'));
	}


	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'                      => 'Mikado BMI Calculator Form',
			'base'                      => $this->base,
			'category'                  => 'by MIKADO',
			'icon'                      => 'icon-wpb-mikado-bmi-form extended-custom-icon',
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
				array(
					'type'        => 'dropdown',
					'heading'     => 'Display BMI Chart',
					'param_name'  => 'display_chart',
					'admin_label' => true,
					'value'       => array(
						'Yes' => 'yes',
						'No'  => 'no'
					),
					'save_always' => true
				),
                array(
                    'type' => 'dropdown',
                    'heading' => 'Skin',
                    'param_name' => 'skin',
                    'value' => array(
                        'Default' => 'default',
                        'Light' => 'light',
                    )
                ),
				array(
					'type'        => 'textfield',
					'heading'     => 'BMI Chart Title',
					'param_name'  => 'chart_title',
					'admin_label' => true,
					'value'       => '',
					'save_always' => true
				),
				array(
					'type'        => 'textfield',
					'heading'     => 'Form Title',
					'param_name'  => 'form_title',
					'admin_label' => true,
					'value'       => '',
					'save_always' => true
				),
				array(
					'type'        => 'textarea',
					'heading'     => 'Form Description',
					'param_name'  => 'form_description',
					'admin_label' => true,
					'value'       => '',
					'save_always' => true
				)
			)
		));
	}

	public function render($atts, $content = null) {
		$default_atts = array(
			'display_chart'    => '',
            'skin'             => '',
			'chart_title'      => '',
			'form_title'       => '',
			'form_description' => ''
		);

		$params = shortcode_atts($default_atts, $atts);

		return mkd_bmi_get_template_part('shortcodes/bmi-calculator-form/templates/bmi-calculator-form-template', '', $params, true);
	}
}