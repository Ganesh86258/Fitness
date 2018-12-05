<?php
namespace TopFit\Modules\Shortcodes\SectionTitle;

use TopFit\Modules\Shortcodes\Lib;

class SectionTitle implements Lib\ShortcodeInterface {
	private $base;

	/**
	 * SectionTitle constructor.
	 */
	public function __construct() {
		$this->base = 'mkd_section_title';

		add_action('vc_before_init', array($this, 'vcMap'));
	}


	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'                      => esc_html__('Section Title', 'topfit'),
			'base'                      => $this->base,
			'category'                  => 'by MIKADO',
			'icon'                      => 'icon-wpb-section-title extended-custom-icon',
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Title', 'topfit'),
					'param_name'  => 'title',
					'value'       => '',
					'save_always' => true,
					'admin_label' => true,
					'description' => esc_html__('Enter title text', 'topfit')
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Size', 'topfit'),
					'param_name'  => 'title_size',
					'value'       => array(
                        esc_html__('Medium', 'topfit') => 'medium',
						esc_html__('Large', 'topfit')  => 'large',
						esc_html__('Small', 'topfit')  => 'small',
					),
					'save_always' => true,
					'admin_label' => true,
					'description' => esc_html__('Choose one of predefined title sizes', 'topfit')
				),
				array(
					'type'        => 'colorpicker',
					'heading'     => esc_html__('Color', 'topfit'),
					'param_name'  => 'title_color',
					'value'       => '',
					'save_always' => true,
					'admin_label' => true,
					'description' => esc_html__('Choose color of your title', 'topfit')
				),
                array(
                    'type'			=> 'textfield',
                    'heading'		=> esc_html__('Highlighted Title Text','topfit'),
                    'param_name'	=> 'highlighted_text',
                    'value'			=> '',
                    'admin_label'	=> true,
                    'description'   =>esc_html__('Highlighted title text will be appended to title text','topfit'),
                ),
                array(
                    'type'        => 'colorpicker',
                    'heading'     => esc_html__('Highlighted text color', 'topfit'),
                    'param_name'  => 'highlighted_color',
                    'value'       => '',
                    'save_always' => true,
                    'admin_label' => true,
                    'description' => esc_html__('Choose color of highlighted text', 'topfit')
                ),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Text Align', 'topfit'),
					'param_name'  => 'title_text_align',
					'value'       => array(
						''                                  => '',
						esc_html__('Center', 'topfit') => 'center',
						esc_html__('Left', 'topfit')   => 'left',
						esc_html__('Right', 'topfit')  => 'right'
					),
					'save_always' => true,
					'admin_label' => true,
					'description' => esc_html__('Choose text align for title', 'topfit')
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Margin Bottom', 'topfit'),
					'param_name'  => 'margin_bottom',
					'value'       => '',
					'save_always' => true,
					'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Width (%)', 'topfit'),
					'param_name'  => 'width',
					'description' => esc_html__('Adjust the width of section title in percentages. Ommit the unit', 'topfit'),
					'value'       => '',
					'save_always' => true,
					'admin_label' => true
				)
			)
		));
	}

	public function render($atts, $content = null) {
		$default_atts = array(
			'title'            => '',
			'title_size'       => 'medium',
			'title_color'      => '',
            'highlighted_text' => '',
            'highlighted_color'=> '',
			'title_text_align' => '',
			'margin_bottom'    => '',
			'width'            => ''
		);

		$params = shortcode_atts($default_atts, $atts);

		if ($params['title'] !== '') {
			$params['section_title_classes'] = array('mkd-section-title');

			if ($params['title_size'] !== '') {
				$params['section_title_classes'][] = 'mkd-section-title-' . $params['title_size'];
			}

			$params['section_title_styles'] = array();

			if ($params['title_color'] !== '') {
				$params['section_title_styles'][] = 'color: ' . $params['title_color'];
			}

			if ($params['title_text_align'] !== '') {
				$params['section_title_styles'][] = 'text-align: ' . $params['title_text_align'];

				$params['section_title_classes'][] = 'mkd-section-title-' . $params['title_text_align'];
			}

			if ($params['width'] !== '') {
				$params['section_title_styles'][] = 'width: ' . $params['width'] . '%';
			}


			if ($params['margin_bottom'] !== '') {
				$params['section_title_styles'][] = 'margin-bottom: ' . topfit_mikado_filter_px($params['margin_bottom']) . 'px';
			}

			$params['title_tag'] = $this->getTitleTag($params);
            $params['highlighted_style'] = $this->getTitleHighlightedStyle($params);

			return topfit_mikado_get_shortcode_module_template_part('templates/section-title-template', 'section-title', '', $params);
		}
	}

	private function getTitleTag($params) {
		switch ($params['title_size']) {
			case 'large':
				$titleTag = 'h1';
				break;
			case 'medium':
				$titleTag = 'h2';
				break;
			case 'small':
				$titleTag = 'h3';
				break;
			default:
				$titleTag = 'h2';
		}

		return $titleTag;
	}

    /**
     * Generates style for title highlighted text
     *
     * @param $params
     *
     * @return string
     */
    private function getTitleHighlightedStyle($params){
        $highlighted_style = array();

        if ($params['highlighted_color'] != ''){
            $highlighted_style[] = 'color: '.$params['highlighted_color'];
        }

        return implode(';', $highlighted_style);
    }
}