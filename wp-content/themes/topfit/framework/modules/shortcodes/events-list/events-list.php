<?php
namespace TopFit\Modules\Shortcodes\EventsList;

use TopFit\Modules\Events\Lib\EventsQuery;
use TopFit\Modules\Shortcodes\Lib\ShortcodeInterface;

class EventsList implements ShortcodeInterface {
    private $base;

    public function __construct() {
        $this->base = 'mkd_events_list';

        add_action('vc_before_init', array($this, 'vcMap'));
    }

    public function getBase() {
        return $this->base;
    }

    public function vcMap() {
        vc_map(array(
                'name'                      => esc_html__('Mikado Events List', 'topfit'),
                'base'                      => $this->getBase(),
                'category'                  => 'by MIKADO',
                'icon'                      => 'icon-wpb-events extended-custom-icon',
                'allowed_container_element' => 'vc_row',
                'params'                    => array_merge(
                    array(
                        array(
                            'type'        => 'dropdown',
                            'heading'     => esc_html__('Number of Columns', 'topfit'),
                            'param_name'  => 'columns',
                            'value'       => array(
                                ''                             => '',
                                esc_html__('One', 'topfit')   => 'one',
                                esc_html__('Two', 'topfit')   => 'two',
                                esc_html__('Three', 'topfit') => 'three',
                                esc_html__('Four', 'topfit')  => 'four',
                                esc_html__('Five', 'topfit')  => 'five',
                                esc_html__('Six', 'topfit')   => 'six'
                            ),
                            'admin_label' => true,
                            'description' => esc_html__('Default value is Three', 'topfit'),
                            'group'       => esc_html__('Layout Options', 'topfit')
                        ),
                        array(
                            'type'        => 'dropdown',
                            'heading'     => esc_html__('Image Proportions', 'topfit'),
                            'param_name'  => 'image_size',
                            'value'       => array(
                                esc_html__('Original', 'topfit')  => 'full',
                                esc_html__('Square', 'topfit')    => 'square',
                                esc_html__('Landscape', 'topfit') => 'landscape',
                                esc_html__('Portrait', 'topfit')  => 'portrait'
                            ),
                            'save_always' => true,
                            'admin_label' => true,
                            'description' => '',
                            'group'       => esc_html__('Layout Options', 'topfit')
                        ),
                    ),
                    EventsQuery::getInstance()->queryVCParams()
                )
            )
        );
    }

    public function render($atts, $content = null) {
        $default_atts = array(
            'columns'    => '',
            'image_size' => ''
        );

        $eventsQuery = EventsQuery::getInstance();

        $default_atts = array_merge($default_atts, $eventsQuery->getShortcodeAtts());
        $params       = shortcode_atts($default_atts, $atts);

        $queryResults = $eventsQuery->buildQueryObject($params);

        $params['query']  = $queryResults;
        $params['caller'] = $this;

        $itemClass[] = 'mkd-events-list-item';

        switch($params['columns']) {
            case 'one':
                $itemClass[] = 'mkd-grid-col-12';
                break;
            case 'two':
                $itemClass[] = 'mkd-grid-col-6';
                break;
            case 'three':
                $itemClass[] = 'mkd-grid-col-4';
                break;
            case 'four':
                $itemClass[] = 'mkd-grid-col-3';
                $itemClass[] = 'mkd-grid-col-ipad-landscape-6';
                $itemClass[] = 'mkd-grid-col-ipad-portrait-12';
                break;
            default:
                $itemClass[] = 'mkd-grid-col-4';
                break;
        }

        $params['item_class'] = implode(' ', $itemClass);

        $params['image_size'] = $this->getImageSize($params);

        return topfit_mikado_get_shortcode_module_template_part('templates/events-list-holder', 'events-list', '', $params);
    }

    public function getEventItemTemplate($params) {
        echo topfit_mikado_get_shortcode_module_template_part('templates/events-list-item', 'events-list', '', $params);
    }

    private function getImageSize($params) {

        if(!empty($params['image_size'])) {
            $image_size = $params['image_size'];

            switch($image_size) {
                case 'landscape':
                    $thumb_size = 'topfit_mikado_landscape';
                    break;
                case 'portrait':
                    $thumb_size = 'topfit_mikado_portrait';
                    break;
                case 'square':
                    $thumb_size = 'topfit_mikado_square';
                    break;
                case 'full':
                    $thumb_size = 'full';
                    break;
                case 'custom':
                    $thumb_size = 'custom';
                    break;
                default:
                    $thumb_size = 'full';
                    break;
            }

            return $thumb_size;
        }
    }
}