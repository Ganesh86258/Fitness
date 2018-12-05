<?php
namespace TopFit\Modules\OrderedList;

use TopFit\Modules\Shortcodes\Lib\ShortcodeInterface;

class OrderedList implements ShortcodeInterface {
	private $base;

	function __construct() {
		$this->base = 'mkd_list_ordered';
		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {

		vc_map(array(
			'name'                      => esc_html__('List - Ordered', 'topfit'),
			'base'                      => $this->base,
			'icon'                      => 'icon-wpb-ordered-list extended-custom-icon',
			'category'                  => 'by MIKADO',
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
				array(
					'type'        => 'textarea_html',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => esc_html__('Content', 'topfit'),
					'param_name'  => 'content',
					'value'       => '<ol><li>' . esc_html__('Lorem Ipsum', 'topfit') . '</li><li>' . esc_html__('Lorem Ipsum', 'topfit') . '</li><li>' . esc_html__('Lorem Ipsum', 'topfit') . '</li></ol>',
					'description' => ''
				)
			)
		));

	}

	public function render($atts, $content = null) {
		$html = '';
		$html .= '<div class= "mkd-ordered-list" >' . topfit_mikado_remove_auto_ptag($content, true) . '</div>';

		return $html;
	}

}

