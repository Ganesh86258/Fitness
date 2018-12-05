<?php

namespace TopFit\Modules\Shortcodes\TextMarquee;

use TopFit\Modules\Shortcodes\Lib\ShortcodeInterface;

class TextMarquee implements ShortcodeInterface
{
    private $base;

    public function __construct() {
        $this->base = 'mkd_text_marquee';

        add_action('vc_before_init', array($this, 'vcMap'));
    }

    /**
     * @return string
     */
    public function getBase() {
        return $this->base;
    }

    /**
     *
     */
    public function vcMap() {
        vc_map(array(
            'name' => esc_html__('Text Marquee', 'topfit'),
            'base' => $this->base,
            'icon' => 'icon-wpb-text-marquee extended-custom-icon',
            'category' => esc_html__('by MIKADO', 'topfit'),
            'allowed_container_element' => 'vc_row',
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Title', 'topfit'),
                    'param_name' => 'title',
                    'description' => '',
                    'admin_label' => true
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__('Title Color', 'topfit'),
                    'param_name' => 'title_color',
                    'description' => ''
                )
            )
        ));
    }


    /**
     * @param array $atts
     * @param null $content
     *
     * @return string
     */
    public function render($atts, $content = null) {
        $params = array(
            'title' => '',
            'title_color' => ''
        );

        $params = shortcode_atts($params, $atts);

        $params['title_style'] = $this->getTitleStyle($params);

        $html = '';

        $html .= topfit_mikado_get_shortcode_module_template_part('templates/text-marquee', 'text-marquee', '', $params);

        return $html;
    }

    private function getTitleStyle($params) {

        $title_styles = array();

        if (!empty($params['title_color'])) {
            $title_styles[] = 'color: ' . $params['title_color'];
        }

        return implode(';', $title_styles);
    }
}