<?php
if(!function_exists('topfit_mikado_events_options_map')) {

    /**
     * Add Evetns options page
     */
    if(topfit_mikado_the_events_calendar_installed()) {
        function topfit_mikado_events_options_map() {

            topfit_mikado_add_admin_page(
                array(
                    'slug'  => '_events_page',
                    'title' => esc_html__('Events', 'topfit'),
                    'icon'  => 'icon_calendar'
                )
            );


            $panel_title = topfit_mikado_add_admin_panel(
                array(
                    'page'  => '_events_page',
                    'name'  => 'panel_title',
                    'title' => esc_html__('Title Settings', 'topfit')
                )
            );

            $show_events_title_area_container = topfit_mikado_add_admin_container(
                array(
                    'parent'          => $panel_title,
                    'name'            => 'show_events_title_area_container',
                    'hidden_property' => 'show_title_area',
                    'hidden_value'    => 'no'
                )
            );

            topfit_mikado_add_admin_field(
                array(
                    'name'          => 'title_events_area_type',
                    'type'          => 'select',
                    'default_value' => 'breadcrumb',
                    'label'         => esc_html__('Title Area Type', 'topfit'),
                    'description'   => esc_html__('Choose title type', 'topfit'),
                    'parent'        => $show_events_title_area_container,
                    'options'       => array(
                        'standard'   => esc_html__('Standard', 'topfit'),
                        'breadcrumb' => esc_html__('Breadcrumb', 'topfit')
                    ),
                    'args'          => array(
                        "dependence" => true,
                        "hide"       => array(
                            "standard"   => "",
                            "breadcrumb" => "#mkd_title_events_area_type_container"
                        ),
                        "show"       => array(
                            "standard"   => "#mkd_title_events_area_type_container",
                            "breadcrumb" => ""
                        )
                    )
                )
            );
            topfit_mikado_add_admin_field(
                array(
                    'name'        => 'title_events_area_background_image',
                    'type'        => 'image',
                    'label'       => esc_html__('Background Image', 'topfit'),
                    'description' => esc_html__('Choose an Image for Title Area', 'topfit'),
                    'parent'      => $show_events_title_area_container
                )
            );

            topfit_mikado_add_admin_field(
                array(
                    'name'        => 'title_events_area_background_color',
                    'type'        => 'color',
                    'label'       => esc_html__('Background Color', 'topfit'),
                    'description' => esc_html__('Choose a background color for Title Area', 'topfit'),
                    'parent'      => $show_events_title_area_container
                )
            );

            topfit_mikado_add_admin_field(array(
                'name'        => 'title_events_area_height',
                'type'        => 'text',
                'label'       => esc_html__('Height', 'topfit'),
                'description' => esc_html__('Set a height for Title Area', 'topfit'),
                'parent'      => $show_events_title_area_container,
                'args'        => array(
                    'col_width' => 2,
                    'suffix'    => 'px'
                )
            ));

            topfit_mikado_add_admin_field(
                array(
                    'name'          => 'title_events_area_content_alignment',
                    'type'          => 'select',
                    'default_value' => 'left',
                    'label'         => esc_html__('Horizontal Alignment', 'topfit'),
                    'description'   => esc_html__('Specify title horizontal alignment', 'topfit'),
                    'parent'        => $show_events_title_area_container,
                    'options'       => array(
                        'center' => esc_html__('Center', 'topfit'),
                        'left'   => esc_html__('Left', 'topfit'),
                        'right'  => esc_html__('Right', 'topfit')
                    )
                )
            );

        }

        add_action('topfit_mikado_options_map', 'topfit_mikado_events_options_map', 19);
    }
}