<?php
namespace TopFit\Modules\Shortcodes\TableHolder;

use TopFit\Modules\Shortcodes\Lib\ShortcodeInterface;

class TableHolder implements ShortcodeInterface {
	private $base;

	function __construct() {
		$this->base = 'mkd_table_holder';
		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {

		vc_map(array(
			'name'                    => esc_html__('Table Holder', 'topfit'),
			'base'                    => $this->base,
			'as_parent'               => array('only' => 'mkd_table_item'),
			'content_element'         => true,
			'category'                => 'by MIKADO',
			'icon'                    => 'icon-wpb-table-holder extended-custom-icon',
			'show_settings_on_create' => true,
			'params'                  => array(
				array(
					'type'        => 'dropdown',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Columns', 'topfit'),
					'param_name'  => 'columns',
					'value'       => array(
						esc_html__('Two', 'topfit')   => 'mkd-two-columns',
						esc_html__('Three', 'topfit') => 'mkd-three-columns',
						esc_html__('Four', 'topfit')  => 'mkd-four-columns',
					),
					'save_always' => true,
					'description' => ''
				)
			),
			'js_view'                 => 'VcColumnView'
		));

	}

	public function render($atts, $content = null) {
		$args = array(
			'columns' => 'mkd-two-columns'
		);

		$params = shortcode_atts($args, $atts);
		extract($params);

		$html = '<div class="mkd-table-shortcode-holder clearfix ' . $columns . '">';
		$html .= do_shortcode($content);
		$html .= '</div>';

		return $html;
	}

}
