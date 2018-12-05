<?php

if(!function_exists('topfit_mikado_search_body_class')) {
    /**
     * Function that adds body classes for different search types
     *
     * @param $classes array original array of body classes
     *
     * @return array modified array of classes
     */
    function topfit_mikado_search_body_class($classes) {

        if(is_active_widget(false, false, 'mkd_search_opener')) {

            $classes[] = 'mkd-'.topfit_mikado_options()->getOptionValue('search_type');

            if(topfit_mikado_options()->getOptionValue('search_type') == 'fullscreen-search') {

                $is_fullscreen_bg_image_set = topfit_mikado_options()->getOptionValue('fullscreen_search_background_image') !== '';

                if($is_fullscreen_bg_image_set) {
                    $classes[] = 'mkd-fullscreen-search-with-bg-image';
                }

                $classes[] = 'mkd-search-fade';

            }

        }

        return $classes;

    }

    add_filter('body_class', 'topfit_mikado_search_body_class');
}

if(!function_exists('topfit_mikado_get_search')) {
    /**
     * Loads search HTML based on search type option.
     */
    function topfit_mikado_get_search() {

        if(topfit_mikado_active_widget(false, false, 'mkd_search_opener')) {

            $search_type = topfit_mikado_options()->getOptionValue('search_type');

            if($search_type == 'search-covers-header') {
                topfit_mikado_set_position_for_covering_search();

                return;
            } else if($search_type == 'search-slides-from-window-top') {
                topfit_mikado_set_search_position_in_menu($search_type);
                if(topfit_mikado_is_responsive_on()) {
                    topfit_mikado_set_search_position_mobile();
                }

                return;
            } elseif($search_type === 'search-dropdown') {
                topfit_mikado_set_dropdown_search_position();

                return;
            }

            topfit_mikado_load_search_template();

        }
    }

}

if(!function_exists('topfit_mikado_set_position_for_covering_search')) {
    /**
     * Finds part of header where search template will be loaded
     */
    function topfit_mikado_set_position_for_covering_search() {

        $containing_sidebar = topfit_mikado_active_widget(false, false, 'mkd_search_opener');

        foreach($containing_sidebar as $sidebar) {

            if(strpos($sidebar, 'top-bar') !== false) {
                add_action('topfit_mikado_after_header_top_html_open', 'topfit_mikado_load_search_template');
            } else if(strpos($sidebar, 'main-menu') !== false) {
                add_action('topfit_mikado_after_header_menu_area_html_open', 'topfit_mikado_load_search_template');
            } else if(strpos($sidebar, 'mobile-logo') !== false) {
                add_action('topfit_mikado_after_mobile_header_html_open', 'topfit_mikado_load_search_template');
            } else if(strpos($sidebar, 'logo') !== false) {
                add_action('topfit_mikado_after_header_logo_area_html_open', 'topfit_mikado_load_search_template');
            } else if(strpos($sidebar, 'sticky') !== false) {
                add_action('topfit_mikado_after_sticky_menu_html_open', 'topfit_mikado_load_search_template');
            }

        }

    }

}

if(!function_exists('topfit_mikado_set_search_position_in_menu')) {
    /**
     * Finds part of header where search template will be loaded
     */
    function topfit_mikado_set_search_position_in_menu($type) {

        add_action('topfit_mikado_after_header_menu_area_html_open', 'topfit_mikado_load_search_template');

    }
}

if(!function_exists('topfit_mikado_set_search_position_mobile')) {
    /**
     * Hooks search template to mobile header
     */
    function topfit_mikado_set_search_position_mobile() {

        add_action('topfit_mikado_after_mobile_header_html_open', 'topfit_mikado_load_search_template');

    }

}

if(!function_exists('topfit_mikado_load_search_template')) {
    /**
     * Loads HTML template with parameters
     */
    function topfit_mikado_load_search_template() {
        global $topfit_IconCollections;

        $search_type = topfit_mikado_options()->getOptionValue('search_type');

        $search_icon       = '';
        $search_icon_close = '';
        if(topfit_mikado_options()->getOptionValue('search_icon_pack') !== '') {
            $search_icon       = $topfit_IconCollections->getSearchIcon(topfit_mikado_options()->getOptionValue('search_icon_pack'), true);
            $search_icon_close = $topfit_IconCollections->getSearchClose(topfit_mikado_options()->getOptionValue('search_icon_pack'), true);
        }

        $parameters = array(
            'search_in_grid'    => topfit_mikado_options()->getOptionValue('search_in_grid') == 'yes' ? true : false,
            'search_icon'       => $search_icon,
            'search_icon_close' => $search_icon_close
        );

        topfit_mikado_get_module_template_part('templates/types/'.$search_type, 'search', '', $parameters);

    }

}

if(!function_exists('topfit_mikado_set_dropdown_search_position')) {
    function topfit_mikado_set_dropdown_search_position() {
        add_action('topfit_mikado_after_search_opener', 'topfit_mikado_load_search_template');
    }
}