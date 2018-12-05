<?php

//if(!function_exists('topfit_mikado_events_assets')) {
//    /**
//     * Loads all necessary styles for events calendar plugin
//     */
//    function topfit_mikado_events_assets() {
//        wp_enqueue_style('topfit_mikado_events_calendar', MIKADO_ASSETS_ROOT.'/css/events-calendar.min.css');
//
//        if(topfit_mikado_is_responsive_on()) {
//            wp_enqueue_style('topfit_mikado_events_calendar_responsive', MIKADO_ASSETS_ROOT.'/css/events-calendar-responsive.min.css');
//        }
//    }
//
//    add_action('wp_enqueue_scripts', 'topfit_mikado_events_assets');
//}

if(!function_exists('topfit_mikado_events_style_dynamic_deps')) {
    /**
     * Adds Events Calendar styles to deps array for style dynamic
     *
     * @param $deps
     *
     * @return array
     */
    function topfit_mikado_events_style_dynamic_deps($deps) {
        $deps[] = 'topfit_mikado_events_calendar';

        return $deps;
    }

    add_filter('topfit_mikado_style_dynamic_dependencies', 'topfit_mikado_events_style_dynamic_deps');
}

if(!function_exists('topfit_mikado_events_deregister_theme_map_script')) {
    /**
     * Deregisters theme's google map api script when on single event page or on calendar page
     */
    function topfit_mikado_events_deregister_theme_map_script() {
        if(tribe_is_event() || is_post_type_archive('tribe_events')) {
            wp_dequeue_script('google_map_api');
        }
    }

    add_action('wp_enqueue_scripts', 'topfit_mikado_events_deregister_theme_map_script');
}

if(!function_exists('topfit_mikado_events_archive_sidebar_layout')) {
    /**
     * Resets sidebar layout for events archive page
     *
     * @param $layout
     *
     * @return string
     */
    function topfit_mikado_events_archive_sidebar_layout($layout) {
        if(is_post_type_archive('tribe_events')) {
            $layout = '';
        }

        return $layout;
    }

    add_filter('topfit_mikado_sidebar_layout', 'topfit_mikado_events_archive_sidebar_layout');
}

if(!function_exists('topfit_mikado_events_archive_sidebar')) {
    /**
     * Resets sidebar for events archive page
     *
     * @param $sidebar
     *
     * @return string
     */
    function topfit_mikado_events_archive_sidebar($sidebar) {
        if(is_post_type_archive('tribe_events')) {
            $sidebar = '';
        }

        return $sidebar;
    }

    add_filter('topfit_mikado_sidebar', 'topfit_mikado_events_archive_sidebar');
}

if(!function_exists('topfit_mikado_events_archive_title_text')) {
    /**
     * Hooks to title text filter and alters it for events calendar page
     *
     * @param $text
     *
     * @return string
     */
    function topfit_mikado_events_archive_title_text($text) {
        if(is_post_type_archive('tribe_events')) {
            $text = esc_html__('Events Calendar', 'topfit');
        }

        return $text;
    }

    add_filter('topfit_mikado_title_text', 'topfit_mikado_events_archive_title_text');
}

if(!function_exists('topfit_mikado_events_tooltip_image')) {
    /**
     * Hooks to tribe_events_template_data_array and changes tooltip image size
     *
     * @param $json
     * @param $event
     *
     * @return mixed
     */
    function topfit_mikado_events_tooltip_image($json, $event) {
        if(isset($json['imageTooltipSrc'])) {
            $image_tool_arr = wp_get_attachment_image_src(get_post_thumbnail_id($event->ID), 'medium');
            $image_tool_src = $image_tool_arr[0];

            $json['imageTooltipSrc'] = $image_tool_src;
        }

        return $json;
    }

    add_filter('tribe_events_template_data_array', 'topfit_mikado_events_tooltip_image', 10, 2);
}