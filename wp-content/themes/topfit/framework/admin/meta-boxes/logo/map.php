<?php

if (!function_exists('topfit_mikado_logo_meta_box_map')) {
    function topfit_mikado_logo_meta_box_map() {

        $logo_meta_box = topfit_mikado_add_meta_box(
            array(
                'scope' => array('page', 'portfolio-item', 'post'),
                'title' => esc_html__('Logo', 'topfit'),
                'name'  => 'logo_meta'
            )
        );


        topfit_mikado_add_meta_box_field(
            array(
                'name'          => 'mkd_logo_image_meta',
                'type'          => 'image',
                'label'         => esc_html__('Logo Image - Default', 'topfit'),
                'description'   => esc_html__('Choose a default logo image to display ', 'topfit'),
                'parent'        => $logo_meta_box
            )
        );

        topfit_mikado_add_meta_box_field(
            array(
                'name'          => 'mkd_logo_image_dark_meta',
                'type'          => 'image',
                'label'         => esc_html__('Logo Image - Dark', 'topfit'),
                'description'   => esc_html__('Choose a default logo image to display ', 'topfit'),
                'parent'        => $logo_meta_box
            )
        );

        topfit_mikado_add_meta_box_field(
            array(
                'name'          => 'mkd_logo_image_light_meta',
                'type'          => 'image',
                'label'         => esc_html__('Logo Image - Light', 'topfit'),
                'description'   => esc_html__('Choose a default logo image to display ', 'topfit'),
                'parent'        => $logo_meta_box
            )
        );

        topfit_mikado_add_meta_box_field(
            array(
                'name'          => 'mkd_logo_image_sticky_meta',
                'type'          => 'image',
                'label'         => esc_html__('Logo Image - Sticky', 'topfit'),
                'description'   => esc_html__('Choose a default logo image to display ', 'topfit'),
                'parent'        => $logo_meta_box
            )
        );

        topfit_mikado_add_meta_box_field(
            array(
                'name'          => 'mkd_logo_image_mobile_meta',
                'type'          => 'image',
                'label'         => esc_html__('Logo Image - Mobile', 'topfit'),
                'description'   => esc_html__('Choose a default logo image to display ', 'topfit'),
                'parent'        => $logo_meta_box
            )
        );
    }

    add_action('topfit_mikado_meta_boxes_map', 'topfit_mikado_logo_meta_box_map');
}