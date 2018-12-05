<?php
namespace TopFit\Modules\Shortcodes\TableItem;

use TopFit\Modules\Shortcodes\Lib\ShortcodeInterface;

class TableItem implements ShortcodeInterface {
	private $base;

	function __construct() {
		$this->base = 'mkd_table_item';
		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		if(function_exists('vc_map')) {
			vc_map(
				array(
					'name'                    => esc_html__('Table Item', 'topfit'),
					'base'                    => $this->base,
					'as_parent'               => array('only' => 'mkd_table_content_item'),
					'as_child'                => array('only' => 'mkd_table_holder'),
					'content_element'         => true,
					'category'                => esc_html__('by MIKADO', 'topfit'),
					'icon'                    => 'icon-wpb-table-item extended-custom-icon',
					'show_settings_on_create' => false,
					'js_view'                 => 'VcColumnView',
					'params'                  => array(
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__('Title', 'topfit'),
							'admin_label' => true,
							'save_always' => true,
							'param_name'  => 'table_item_title'
						),
					)
				)
			);
		}
	}

	public function render($atts, $content = null) {
		$args   = array(
			'table_item_title' => ''
		);

		$params = shortcode_atts($args, $atts);
		extract($params);
		$params['content'] = $content;

		$html = topfit_mikado_get_shortcode_module_template_part('templates/table-item', 'table', '', $params);

		return $html;
	}

}
