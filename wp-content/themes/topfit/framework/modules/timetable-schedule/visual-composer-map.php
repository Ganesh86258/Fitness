<?php

if(topfit_mikado_visual_composer_installed()) {
    if(!function_exists('topfit_mikado_ttsingle_hours_vc_map')) {
        function topfit_mikado_ttsingle_hours_vc_map() {
            vc_map(array(
                'name'                      => 'Timetable Event Hours',
                'base'                      => 'tt_event_hours',
                'category'                  => 'by MIKADO',
                'icon'                      => 'icon-wpb-timetable-event-hours extended-custom-icon',
                'allowed_container_element' => 'vc_row'
            ));
        }

        add_action('vc_before_init', 'topfit_mikado_ttsingle_hours_vc_map');
    }

    if(!function_exists('topfit_mikado_ttsingle_info_holder')) {
        function topfit_mikado_ttsingle_info_holder() {
            vc_map(array(
                "name"                    => esc_html__('Timetable Event Info Holder', 'topfit'),
                'base'                    => 'tt_items_list',
                'as_parent'               => array('only' => 'tt_item'),
                'content_element'         => true,
                'category'                => 'by MIKADO',
                'icon'                    => 'icon-wpb-timetable-event-info-holder extended-custom-icon',
                'show_settings_on_create' => true,
                'js_view'                 => 'VcColumnView'
            ));
        }

        add_action('vc_before_init', 'topfit_mikado_ttsingle_info_holder');
    }

    if(!function_exists('topfit_mikado_ttsingle_info_table_item')) {
        function topfit_mikado_ttsingle_info_table_item() {
            vc_map(array(
                'name'                    => esc_html__('Timetable Event Info Table Item', 'topfit'),
                'base'                    => 'tt_item',
                'as_child'                => array('only' => 'tt_items_list'),
                'category'                => 'by MIKADO',
                'icon'                    => 'icon-wpb-timetable-event-info-table-item extended-custom-icon',
                'show_settings_on_create' => true,
                'params'                  => array(
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Label', 'topfit'),
                        'param_name'  => 'content',
                        'admin_label' => true
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Value', 'topfit'),
                        'param_name'  => 'value',
                        'admin_label' => true
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => esc_html__('Type', 'topfit'),
                        'param_name'  => 'type',
                        'admin_label' => true,
                        'value'       => array(
                            'Table' => 'info'
                        ),
                        'save_always' => true
                    ),
                )
            ));
        }

        add_action('vc_before_init', 'topfit_mikado_ttsingle_info_table_item');
    }

    class WPBakeryShortCode_Tt_Items_List extends WPBakeryShortCodesContainer {
    }
}

