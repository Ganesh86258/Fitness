<?php

//Carousels

if (!function_exists('topfit_mikado_carousel_meta_box_map')) {
    function topfit_mikado_carousel_meta_box_map() {

        $carousel_meta_box = topfit_mikado_add_meta_box(
            array(
                'scope' => array('carousels'),
                'title' => esc_html__('Carousel', 'topfit'),
                'name' => 'carousel_meta'
            )
        );

        topfit_mikado_add_meta_box_field(
            array(
                'name'        => 'mkd_carousel_image',
                'type'        => 'image',
                'label'       => esc_html__('Carousel Image', 'topfit'),
                'description' => esc_html__('Choose carousel image (min width needs to be 215px)', 'topfit'),
                'parent'      => $carousel_meta_box
            )
        );

        topfit_mikado_add_meta_box_field(
            array(
                'name'        => 'mkd_carousel_hover_image',
                'type'        => 'image',
                'label'       => esc_html__('Carousel Hover Image', 'topfit'),
                'description' => esc_html__('Choose carousel hover image (min width needs to be 215px)', 'topfit'),
                'parent'      => $carousel_meta_box
            )
        );

        topfit_mikado_add_meta_box_field(
            array(
                'name'        => 'mkd_carousel_item_link',
                'type'        => 'text',
                'label'       => esc_html__('Link', 'topfit'),
                'description' => esc_html__('Enter the URL to which you want the image to link to (e.g. http://www.example.com)', 'topfit'),
                'parent'      => $carousel_meta_box
            )
        );

        topfit_mikado_add_meta_box_field(
            array(
                'name'        => 'mkd_carousel_item_target',
                'type'        => 'selectblank',
                'label'       => esc_html__('Target', 'topfit'),
                'description' => esc_html__('Specify where to open the linked document', 'topfit'),
                'parent'      => $carousel_meta_box,
                'options' => array(
                    '_self' => esc_html__('Self', 'topfit'),
                    '_blank' => esc_html__('Blank', 'topfit')
                )
            )
        );

    }
    add_action('topfit_mikado_meta_boxes_map', 'topfit_mikado_carousel_meta_box_map');
}