<?php

if(!function_exists('topfit_mikado_header_top_bar_styles')) {
    /**
     * Generates styles for header top bar
     */
    function topfit_mikado_header_top_bar_styles() {
        global $topfit_options;

        if($topfit_options['top_bar_height'] !== '') {
            echo topfit_mikado_dynamic_css('.mkd-top-bar, .mkd-header-box .mkd-top-bar', array('height' => $topfit_options['top_bar_height'].'px'));
            echo topfit_mikado_dynamic_css('.mkd-top-bar .mkd-logo-wrapper a', array('max-height' => $topfit_options['top_bar_height'].'px'));
        }

        if($topfit_options['top_bar_in_grid'] == 'yes') {
            $top_bar_grid_selector = '.mkd-top-bar .mkd-grid .mkd-vertical-align-containers';
            $top_bar_grid_styles   = array();
            if($topfit_options['top_bar_grid_background_color'] !== '') {
                $grid_background_color        = $topfit_options['top_bar_grid_background_color'];
                $grid_background_transparency = 1;

                if(topfit_mikado_options()->getOptionValue('top_bar_grid_background_transparency')) {
                    $grid_background_transparency = topfit_mikado_options()->getOptionValue('top_bar_grid_background_transparency');
                }

                $grid_background_color                   = topfit_mikado_rgba_color($grid_background_color, $grid_background_transparency);
                $top_bar_grid_styles['background-color'] = $grid_background_color;
            }

            echo topfit_mikado_dynamic_css($top_bar_grid_selector, $top_bar_grid_styles);
        }

        $background_color = topfit_mikado_options()->getOptionValue('top_bar_background_color');
        $border_color     = topfit_mikado_options()->getOptionValue('top_bar_border_color');
        $top_bar_styles   = array();
        if($background_color !== '') {
            $background_transparency = 1;
            if(topfit_mikado_options()->getOptionValue('top_bar_background_transparency') !== '') {
                $background_transparency = topfit_mikado_options()->getOptionValue('top_bar_background_transparency');
            }

            $background_color                   = topfit_mikado_rgba_color($background_color, $background_transparency);
            $top_bar_styles['background-color'] = $background_color;

            echo topfit_mikado_dynamic_css('.mkd-top-bar-background', array('background-color'=>$background_color));
        }

        if(topfit_mikado_options()->getOptionValue('top_bar_border') == 'yes' && $border_color != '') {
            $top_bar_styles['border-bottom'] = '1px solid '.$border_color;
        }

        echo topfit_mikado_dynamic_css('.mkd-top-bar', $top_bar_styles);
    }

    add_action('topfit_mikado_style_dynamic', 'topfit_mikado_header_top_bar_styles');
}

if(!function_exists('topfit_mikado_header_standard_menu_area_styles')) {
    /**
     * Generates styles for header standard menu
     */
    function topfit_mikado_header_standard_menu_area_styles() {
        global $topfit_options;

        $menu_area_header_standard_styles = array();

        if($topfit_options['menu_area_background_color_header_standard'] !== '') {
            $menu_area_background_color        = $topfit_options['menu_area_background_color_header_standard'];
            $menu_area_background_transparency = 1;

            if($topfit_options['menu_area_background_transparency_header_standard'] !== '') {
                $menu_area_background_transparency = $topfit_options['menu_area_background_transparency_header_standard'];
            }

            $menu_area_header_standard_styles['background-color'] = topfit_mikado_rgba_color($menu_area_background_color, $menu_area_background_transparency);
        }

        if($topfit_options['menu_area_height_header_standard'] !== '') {
            $max_height = intval(topfit_mikado_filter_px($topfit_options['menu_area_height_header_standard']) * 0.9).'px';
            echo topfit_mikado_dynamic_css('.mkd-header-standard .mkd-page-header .mkd-logo-wrapper a', array('max-height' => $max_height));

            $menu_area_header_standard_styles['height'] = topfit_mikado_filter_px($topfit_options['menu_area_height_header_standard']).'px';

        }

        echo topfit_mikado_dynamic_css('.mkd-header-standard .mkd-page-header .mkd-menu-area', $menu_area_header_standard_styles);

        $menu_area_grid_header_standard_styles = array();

        if($topfit_options['menu_area_in_grid_header_standard'] == 'yes' && $topfit_options['menu_area_grid_background_color_header_standard'] !== '') {
            $menu_area_grid_background_color        = $topfit_options['menu_area_grid_background_color_header_standard'];
            $menu_area_grid_background_transparency = 1;

            if($topfit_options['menu_area_grid_background_transparency_header_standard'] !== '') {
                $menu_area_grid_background_transparency = $topfit_options['menu_area_grid_background_transparency_header_standard'];
            }

            $menu_area_grid_header_standard_styles['background-color'] = topfit_mikado_rgba_color($menu_area_grid_background_color, $menu_area_grid_background_transparency);
        }

        echo topfit_mikado_dynamic_css('.mkd-header-standard .mkd-page-header .mkd-menu-area .mkd-grid .mkd-vertical-align-containers', $menu_area_grid_header_standard_styles);
    }

    add_action('topfit_mikado_style_dynamic', 'topfit_mikado_header_standard_menu_area_styles');
}


if(!function_exists('topfit_mikado_header_minimal_menu_area_styles')) {
    /**
     * Generates styles for header minimal menu
     */
    function topfit_mikado_header_minimal_menu_area_styles() {
        global $topfit_options;

        $menu_area_header_minimal_styles = array();

        if($topfit_options['menu_area_background_color_header_minimal'] !== '') {
            $menu_area_background_color        = $topfit_options['menu_area_background_color_header_minimal'];
            $menu_area_background_transparency = 1;

            if($topfit_options['menu_area_background_transparency_header_minimal'] !== '') {
                $menu_area_background_transparency = $topfit_options['menu_area_background_transparency_header_minimal'];
            }

            $menu_area_header_minimal_styles['background-color'] = topfit_mikado_rgba_color($menu_area_background_color, $menu_area_background_transparency);
        }

        if($topfit_options['menu_area_height_header_minimal'] !== '') {
            $max_height = intval(topfit_mikado_filter_px($topfit_options['menu_area_height_header_minimal']) * 0.9).'px';
            echo topfit_mikado_dynamic_css('.mkd-header-minimal .mkd-page-header .mkd-logo-wrapper a', array('max-height' => $max_height));

            $menu_area_header_minimal_styles['height'] = topfit_mikado_filter_px($topfit_options['menu_area_height_header_minimal']).'px';

        }

        echo topfit_mikado_dynamic_css('.mkd-header-minimal .mkd-page-header .mkd-menu-area', $menu_area_header_minimal_styles);

        $menu_area_grid_header_minimal_styles = array();

        if($topfit_options['menu_area_in_grid_header_minimal'] == 'yes' && $topfit_options['menu_area_grid_background_color_header_minimal'] !== '') {
            $menu_area_grid_background_color        = $topfit_options['menu_area_grid_background_color_header_minimal'];
            $menu_area_grid_background_transparency = 1;

            if($topfit_options['menu_area_grid_background_transparency_header_minimal'] !== '') {
                $menu_area_grid_background_transparency = $topfit_options['menu_area_grid_background_transparency_header_minimal'];
            }

            $menu_area_grid_header_minimal_styles['background-color'] = topfit_mikado_rgba_color($menu_area_grid_background_color, $menu_area_grid_background_transparency);
        }

        echo topfit_mikado_dynamic_css('.mkd-header-minimal .mkd-page-header .mkd-menu-area .mkd-grid .mkd-vertical-align-containers', $menu_area_grid_header_minimal_styles);
    }

    add_action('topfit_mikado_style_dynamic', 'topfit_mikado_header_minimal_menu_area_styles');
}


if(!function_exists('topfit_mikado_header_divided_menu_area_styles')) {
    /**
     * Generates styles for header divided menu
     */
    function topfit_mikado_header_divided_menu_area_styles() {
        global $topfit_options;

        $menu_area_header_divided_styles = array();

        if($topfit_options['menu_area_background_color_header_divided'] !== '') {
            $menu_area_background_color        = $topfit_options['menu_area_background_color_header_divided'];
            $menu_area_background_transparency = 1;

            if($topfit_options['menu_area_background_transparency_header_divided'] !== '') {
                $menu_area_background_transparency = $topfit_options['menu_area_background_transparency_header_divided'];
            }

            $menu_area_header_divided_styles['background-color'] = topfit_mikado_rgba_color($menu_area_background_color, $menu_area_background_transparency);
        }

        if(topfit_mikado_options()->getOptionValue('menu_area_border_header_divided') == 'yes' &&
            topfit_mikado_options()->getOptionValue('menu_area_border_color_header_divided') !== ''
        ) {

            $menu_area_header_divided_styles['border-color'] = topfit_mikado_options()->getOptionValue('menu_area_border_color_header_divided');
        }

        if($topfit_options['menu_area_height_header_divided'] !== '') {
            $max_height = intval(topfit_mikado_filter_px($topfit_options['menu_area_height_header_divided']) * 0.9).'px';
            echo topfit_mikado_dynamic_css('.mkd-header-divided .mkd-page-header .mkd-logo-wrapper a', array('max-height' => $max_height));

            $menu_area_header_divided_styles['height'] = topfit_mikado_filter_px($topfit_options['menu_area_height_header_divided']).'px';

        }

        echo topfit_mikado_dynamic_css('.mkd-header-divided .mkd-page-header .mkd-menu-area', $menu_area_header_divided_styles);

        $menu_area_grid_header_divided_styles = array();

        if($topfit_options['menu_area_in_grid_header_divided'] == 'yes' && $topfit_options['menu_area_grid_background_color_header_divided'] !== '') {
            $menu_area_grid_background_color        = $topfit_options['menu_area_grid_background_color_header_divided'];
            $menu_area_grid_background_transparency = 1;

            if($topfit_options['menu_area_grid_background_transparency_header_divided'] !== '') {
                $menu_area_grid_background_transparency = $topfit_options['menu_area_grid_background_transparency_header_divided'];
            }

            $menu_area_grid_header_divided_styles['background-color'] = topfit_mikado_rgba_color($menu_area_grid_background_color, $menu_area_grid_background_transparency);
        }

        if(topfit_mikado_options()->getOptionValue('menu_area_in_grid_border_header_divided') == 'yes' &&
            topfit_mikado_options()->getOptionValue('menu_area_in_grid_border_color_header_divided') !== ''
        ) {

            $menu_area_grid_header_divided_styles['border-bottom'] = '1px solid '.topfit_mikado_options()->getOptionValue('menu_area_in_grid_border_color_header_divided');

        } else if(topfit_mikado_options()->getOptionValue('menu_area_in_grid_border_header_divided') == 'no') {
            $menu_area_grid_header_divided_styles['border'] = '0';
        }

        echo topfit_mikado_dynamic_css('.mkd-header-divided .mkd-page-header .mkd-menu-area .mkd-grid .mkd-vertical-align-containers', $menu_area_grid_header_divided_styles);
    }

    add_action('topfit_mikado_style_dynamic', 'topfit_mikado_header_divided_menu_area_styles');
}

if(!function_exists('topfit_mikado_header_centered_logo_area_styles')) {
    /**
     * Generates styles for header centered menu
     */
    function topfit_mikado_header_centered_logo_area_styles() {
        global $topfit_options;

        $logo_area_header_centered_styles = array();

        if($topfit_options['logo_area_background_color_header_centered'] !== '') {
            $logo_area_background_color        = $topfit_options['logo_area_background_color_header_centered'];
            $logo_area_background_transparency = 1;

            if($topfit_options['logo_area_background_transparency_header_centered'] !== '') {
                $logo_area_background_transparency = $topfit_options['logo_area_background_transparency_header_centered'];
            }

            $logo_area_header_centered_styles['background-color'] = topfit_mikado_rgba_color($logo_area_background_color, $logo_area_background_transparency);
        }

        if(topfit_mikado_options()->getOptionValue('logo_area_border_header_centered') == 'yes' &&
            topfit_mikado_options()->getOptionValue('logo_area_border_color_header_centered') !== ''
        ) {

            $logo_area_header_centered_styles['border-bottom'] = '1px solid '.topfit_mikado_options()->getOptionValue('logo_area_border_color_header_centered');
        }

        if($topfit_options['logo_area_height_header_centered'] !== '') {
            $max_height = intval(topfit_mikado_filter_px($topfit_options['logo_area_height_header_centered']) * 0.9).'px';
            echo topfit_mikado_dynamic_css('.mkd-header-centered .mkd-page-header .mkd-logo-area .mkd-logo-wrapper a', array('max-height' => $max_height));

            $logo_area_header_centered_styles['height'] = topfit_mikado_filter_px($topfit_options['logo_area_height_header_centered']).'px';

        }

        echo topfit_mikado_dynamic_css('.mkd-header-centered .mkd-page-header .mkd-logo-area', $logo_area_header_centered_styles);

        $logo_area_grid_header_centered_styles = array();

        if($topfit_options['logo_area_in_grid_header_centered'] == 'yes' && $topfit_options['logo_area_grid_background_color_header_centered'] !== '') {
            $logo_area_grid_background_color        = $topfit_options['logo_area_grid_background_color_header_centered'];
            $logo_area_grid_background_transparency = 1;

            if($topfit_options['logo_area_grid_background_transparency_header_centered'] !== '') {
                $logo_area_grid_background_transparency = $topfit_options['logo_area_grid_background_transparency_header_centered'];
            }

            $logo_area_grid_header_centered_styles['background-color'] = topfit_mikado_rgba_color($logo_area_grid_background_color, $logo_area_grid_background_transparency);
        }

        if(topfit_mikado_options()->getOptionValue('logo_area_in_grid_border_header_centered') == 'yes' &&
            topfit_mikado_options()->getOptionValue('logo_area_in_grid_border_color_header_centered') !== ''
        ) {

            $logo_area_grid_header_centered_styles['border-bottom'] = '1px solid '.topfit_mikado_options()->getOptionValue('logo_area_in_grid_border_color_header_centered');

        } else if(topfit_mikado_options()->getOptionValue('logo_area_in_grid_border_header_centered') == 'no') {
            $logo_area_grid_header_centered_styles['border'] = '0';
        }

        echo topfit_mikado_dynamic_css('.mkd-header-centered .mkd-page-header .mkd-logo-area .mkd-grid .mkd-vertical-align-containers', $logo_area_grid_header_centered_styles);

        if(topfit_mikado_options()->getOptionValue('logo_wrapper_padding_header_centered') !== '') {
            echo topfit_mikado_dynamic_css('.mkd-header-centered .mkd-logo-area .mkd-logo-wrapper', array('padding'=>topfit_mikado_options()->getOptionValue('logo_wrapper_padding_header_centered')));
        }

    }

    add_action('topfit_mikado_style_dynamic', 'topfit_mikado_header_centered_logo_area_styles');
}

if(!function_exists('topfit_mikado_header_centered_menu_area_styles')) {
    /**
     * Generates styles for header centered menu
     */
    function topfit_mikado_header_centered_menu_area_styles() {
        global $topfit_options;

        $menu_area_header_centered_styles = array();

        if($topfit_options['menu_area_background_color_header_centered'] !== '') {
            $menu_area_background_color        = $topfit_options['menu_area_background_color_header_centered'];
            $menu_area_background_transparency = 1;

            if($topfit_options['menu_area_background_transparency_header_centered'] !== '') {
                $menu_area_background_transparency = $topfit_options['menu_area_background_transparency_header_centered'];
            }

            $menu_area_header_centered_styles['background-color'] = topfit_mikado_rgba_color($menu_area_background_color, $menu_area_background_transparency);
        }

        if(topfit_mikado_options()->getOptionValue('menu_area_border_header_centered') == 'yes' &&
            topfit_mikado_options()->getOptionValue('menu_area_border_color_header_centered') !== ''
        ) {

            $menu_area_header_centered_styles['border-bottom'] = '1px solid '.topfit_mikado_options()->getOptionValue('menu_area_border_color_header_centered');
        }

        if($topfit_options['menu_area_height_header_centered'] !== '') {

            $menu_area_header_centered_styles['height'] = topfit_mikado_filter_px($topfit_options['menu_area_height_header_centered']).'px';

        }

        echo topfit_mikado_dynamic_css('.mkd-header-centered .mkd-page-header .mkd-menu-area', $menu_area_header_centered_styles);

        $menu_area_grid_header_centered_styles = array();

        if($topfit_options['menu_area_in_grid_header_centered'] == 'yes' && $topfit_options['menu_area_grid_background_color_header_centered'] !== '') {
            $menu_area_grid_background_color        = $topfit_options['menu_area_grid_background_color_header_centered'];
            $menu_area_grid_background_transparency = 1;

            if($topfit_options['menu_area_grid_background_transparency_header_centered'] !== '') {
                $menu_area_grid_background_transparency = $topfit_options['menu_area_grid_background_transparency_header_centered'];
            }

            $menu_area_grid_header_centered_styles['background-color'] = topfit_mikado_rgba_color($menu_area_grid_background_color, $menu_area_grid_background_transparency);
        }

        if(topfit_mikado_options()->getOptionValue('menu_area_in_grid_border_header_centered') == 'yes' &&
            topfit_mikado_options()->getOptionValue('menu_area_in_grid_border_color_header_centered') !== ''
        ) {

            $menu_area_grid_header_centered_styles['border-bottom'] = '1px solid '.topfit_mikado_options()->getOptionValue('menu_area_in_grid_border_color_header_centered');

        } else if(topfit_mikado_options()->getOptionValue('menu_area_in_grid_border_header_centered') == 'no') {
            $menu_area_grid_header_centered_styles['border'] = '0';
        }

        echo topfit_mikado_dynamic_css('.mkd-header-centered .mkd-page-header .mkd-menu-area .mkd-grid .mkd-vertical-align-containers', $menu_area_grid_header_centered_styles);
    }

    add_action('topfit_mikado_style_dynamic', 'topfit_mikado_header_centered_menu_area_styles');
}

if(!function_exists('topfit_mikado_vertical_menu_styles')) {
    /**
     * Generates styles for sticky haeder
     */
    function topfit_mikado_vertical_menu_styles() {

        $vertical_header_styles = array();

        $vertical_header_selectors = array(
            '.mkd-header-vertical .mkd-vertical-area-background'
        );

        if(topfit_mikado_options()->getOptionValue('vertical_header_background_color') !== '') {
            $vertical_header_styles['background-color'] = topfit_mikado_options()->getOptionValue('vertical_header_background_color');
        }

        if(topfit_mikado_options()->getOptionValue('vertical_header_background_image') !== '') {
            $vertical_header_styles['background-image'] = 'url('.topfit_mikado_options()->getOptionValue('vertical_header_background_image').')';
        }


        echo topfit_mikado_dynamic_css($vertical_header_selectors, $vertical_header_styles);
    }

    add_action('topfit_mikado_style_dynamic', 'topfit_mikado_vertical_menu_styles');
}


if(!function_exists('topfit_mikado_sticky_header_styles')) {
    /**
     * Generates styles for sticky haeder
     */
    function topfit_mikado_sticky_header_styles() {
        global $topfit_options;

        if($topfit_options['sticky_header_in_grid'] == 'yes' && $topfit_options['sticky_header_grid_background_color'] !== '') {
            $sticky_header_grid_background_color        = $topfit_options['sticky_header_grid_background_color'];
            $sticky_header_grid_background_transparency = 1;

            if($topfit_options['sticky_header_grid_transparency'] !== '') {
                $sticky_header_grid_background_transparency = $topfit_options['sticky_header_grid_transparency'];
            }

            echo topfit_mikado_dynamic_css('.mkd-page-header .mkd-sticky-header .mkd-grid .mkd-vertical-align-containers', array('background-color' => topfit_mikado_rgba_color($sticky_header_grid_background_color, $sticky_header_grid_background_transparency)));
        }

        if($topfit_options['sticky_header_background_color'] !== '') {

            $sticky_header_background_color              = $topfit_options['sticky_header_background_color'];
            $sticky_header_background_color_transparency = 1;

            if($topfit_options['sticky_header_transparency'] !== '') {
                $sticky_header_background_color_transparency = $topfit_options['sticky_header_transparency'];
            }

            echo topfit_mikado_dynamic_css('.mkd-page-header .mkd-sticky-header .mkd-sticky-holder', array('background-color' => topfit_mikado_rgba_color($sticky_header_background_color, $sticky_header_background_color_transparency)));
        }

        if($topfit_options['sticky_header_height'] !== '') {
            $max_height = intval(topfit_mikado_filter_px($topfit_options['sticky_header_height']) * 0.9).'px';

            echo topfit_mikado_dynamic_css('.mkd-page-header .mkd-sticky-header', array('height' => $topfit_options['sticky_header_height'].'px'));
            echo topfit_mikado_dynamic_css('.mkd-page-header .mkd-sticky-header .mkd-logo-wrapper a', array('max-height' => $max_height));
        }

        $sticky_menu_item_styles = array();
        if($topfit_options['sticky_color'] !== '') {
            $sticky_menu_item_styles['color'] = $topfit_options['sticky_color'];
        }
        if($topfit_options['sticky_google_fonts'] !== '-1') {
            $sticky_menu_item_styles['font-family'] = topfit_mikado_get_formatted_font_family($topfit_options['sticky_google_fonts']);
        }
        if($topfit_options['sticky_fontsize'] !== '') {
            $sticky_menu_item_styles['font-size'] = $topfit_options['sticky_fontsize'].'px';
        }
        if($topfit_options['sticky_lineheight'] !== '') {
            $sticky_menu_item_styles['line-height'] = $topfit_options['sticky_lineheight'].'px';
        }
        if($topfit_options['sticky_texttransform'] !== '') {
            $sticky_menu_item_styles['text-transform'] = $topfit_options['sticky_texttransform'];
        }
        if($topfit_options['sticky_fontstyle'] !== '') {
            $sticky_menu_item_styles['font-style'] = $topfit_options['sticky_fontstyle'];
        }
        if($topfit_options['sticky_fontweight'] !== '') {
            $sticky_menu_item_styles['font-weight'] = $topfit_options['sticky_fontweight'];
        }
        if($topfit_options['sticky_letterspacing'] !== '') {
            $sticky_menu_item_styles['letter-spacing'] = $topfit_options['sticky_letterspacing'].'px';
        }

        $sticky_menu_item_selector = array(
            '.mkd-page-header .mkd-sticky-header .mkd-main-menu > ul > li > a',
            '.mkd-page-header .mkd-sticky-header .mkd-main-menu > ul > li.mkd-active-item > a',
            '.mkd-page-header .mkd-sticky-header .mkd-main-menu > ul > li:hover > a',
        );

        $sticky_header_header_buttons_selsectors = array(
            '.mkd-page-header .mkd-sticky-header .mkd-side-menu-button-opener',
            '.mkd-page-header .mkd-sticky-header .mkd-search-opener',
            '.mkd-page-header .mkd-sticky-header .mkd-side-menu-button-opener:hover',
            '.mkd-page-header .mkd-sticky-header .mkd-search-opener:hover'
        );

        echo topfit_mikado_dynamic_css($sticky_menu_item_selector, $sticky_menu_item_styles);
        if($topfit_options['sticky_color'] !== '') {
            echo topfit_mikado_dynamic_css($sticky_header_header_buttons_selsectors, array('color' => $sticky_menu_item_styles['color']));
        }

    }

    add_action('topfit_mikado_style_dynamic', 'topfit_mikado_sticky_header_styles');
}

if(!function_exists('topfit_mikado_fixed_header_styles')) {
    /**
     * Generates styles for fixed haeder
     */
    function topfit_mikado_fixed_header_styles() {
        global $topfit_options;

        if($topfit_options['fixed_header_grid_background_color'] !== '') {

            $fixed_header_grid_background_color              = $topfit_options['fixed_header_grid_background_color'];
            $fixed_header_grid_background_color_transparency = 1;

            if($topfit_options['fixed_header_grid_transparency'] !== '') {
                $fixed_header_grid_background_color_transparency = $topfit_options['fixed_header_grid_transparency'];
            }

            echo topfit_mikado_dynamic_css('.mkd-header-type1 .mkd-fixed-wrapper.fixed .mkd-grid .mkd-vertical-align-containers,
                                    .mkd-header-type3 .mkd-fixed-wrapper.fixed .mkd-grid .mkd-vertical-align-containers',
                array('background-color' => topfit_mikado_rgba_color($fixed_header_grid_background_color, $fixed_header_grid_background_color_transparency)));
        }

        if($topfit_options['fixed_header_background_color'] !== '') {

            $fixed_header_background_color              = $topfit_options['fixed_header_background_color'];
            $fixed_header_background_color_transparency = 1;

            if($topfit_options['fixed_header_transparency'] !== '') {
                $fixed_header_background_color_transparency = $topfit_options['fixed_header_transparency'];
            }

            echo topfit_mikado_dynamic_css('.mkd-header-type1 .mkd-fixed-wrapper.fixed .mkd-menu-area,
                                    .mkd-header-type3 .mkd-fixed-wrapper.fixed .mkd-menu-area',
                array('background-color' => topfit_mikado_rgba_color($fixed_header_background_color, $fixed_header_background_color_transparency)));
        }

    }

    add_action('topfit_mikado_style_dynamic', 'topfit_mikado_fixed_header_styles');
}

if(!function_exists('topfit_mikado_main_menu_styles')) {
    /**
     * Generates styles for main menu
     */
    function topfit_mikado_main_menu_styles() {
        global $topfit_options;

        if($topfit_options['menu_color'] !== '' || $topfit_options['menu_fontsize'] != '' || $topfit_options['menu_fontstyle'] !== '' || $topfit_options['menu_fontweight'] !== '' || $topfit_options['menu_texttransform'] !== '' || $topfit_options['menu_letterspacing'] !== '' || $topfit_options['menu_google_fonts'] != "-1") { ?>
            .mkd-main-menu.mkd-default-nav > ul > li > a,
            .mkd-page-header #lang_sel > ul > li > a,
            .mkd-page-header #lang_sel_click > ul > li > a,
            .mkd-page-header #lang_sel ul > li:hover > a{
            <?php if($topfit_options['menu_color']) { ?> color: <?php echo esc_attr($topfit_options['menu_color']); ?>; <?php } ?>
            <?php if($topfit_options['menu_google_fonts'] != "-1") { ?>
                font-family: '<?php echo esc_attr(str_replace('+', ' ', $topfit_options['menu_google_fonts'])); ?>', sans-serif;
            <?php } ?>
            <?php if($topfit_options['menu_fontsize'] !== '') { ?> font-size: <?php echo esc_attr($topfit_options['menu_fontsize']); ?>px; <?php } ?>
            <?php if($topfit_options['menu_fontstyle'] !== '') { ?> font-style: <?php echo esc_attr($topfit_options['menu_fontstyle']); ?>; <?php } ?>
            <?php if($topfit_options['menu_fontweight'] !== '') { ?> font-weight: <?php echo esc_attr($topfit_options['menu_fontweight']); ?>; <?php } ?>
            <?php if($topfit_options['menu_texttransform'] !== '') { ?> text-transform: <?php echo esc_attr($topfit_options['menu_texttransform']); ?>;  <?php } ?>
            <?php if($topfit_options['menu_letterspacing'] !== '') { ?> letter-spacing: <?php echo esc_attr($topfit_options['menu_letterspacing']); ?>px; <?php } ?>
            }
        <?php } ?>

        <?php if($topfit_options['menu_google_fonts'] != "-1") { ?>
            .mkd-page-header #lang_sel_list{
            font-family: '<?php echo esc_attr(str_replace('+', ' ', $topfit_options['menu_google_fonts'])); ?>', sans-serif !important;
            }
        <?php } ?>

        <?php if($topfit_options['menu_hovercolor'] !== '') { ?>
            .mkd-main-menu.mkd-default-nav > ul > li:hover > a,
            .mkd-main-menu.mkd-default-nav > ul > li.mkd-active-item:hover > a,
            body:not(.mkd-menu-item-first-level-bg-color) .mkd-main-menu.mkd-default-nav > ul > li:hover > a,
            body:not(.mkd-menu-item-first-level-bg-color) .mkd-main-menu.mkd-default-nav > ul > li.mkd-active-item:hover > a,
            .mkd-page-header #lang_sel ul li a:hover,
            .mkd-page-header #lang_sel_click > ul > li a:hover{
            color: <?php echo esc_attr($topfit_options['menu_hovercolor']); ?> !important;
            }
        <?php } ?>

        <?php if($topfit_options['menu_activecolor'] !== '') { ?>
            .mkd-main-menu.mkd-default-nav > ul > li.mkd-active-item > a,
            body:not(.mkd-menu-item-first-level-bg-color) .mkd-main-menu.mkd-default-nav > ul > li.mkd-active-item > a{
            color: <?php echo esc_attr($topfit_options['menu_activecolor']); ?>;
            }
        <?php } ?>

        <?php if($topfit_options['menu_text_background_color'] !== '') { ?>
            .mkd-main-menu.mkd-default-nav > ul > li > a span.item_inner,
            .mkd-page-header #lang_sel .lang_sel_sel,
            .mkd-top-bar #lang_sel .lang_sel_sel{
            background-color: <?php echo esc_attr($topfit_options['menu_text_background_color']); ?>;
            }
        <?php } ?>

        <?php if($topfit_options['menu_hover_background_color'] !== '') {
            $menu_hover_background_color = $topfit_options['menu_hover_background_color'];

            if($topfit_options['menu_hover_background_color_transparency'] !== '') {
                $menu_hover_background_color_rgb = topfit_mikado_hex2rgb($menu_hover_background_color);
                $menu_hover_background_color     = 'rgba('.$menu_hover_background_color_rgb[0].', '.$menu_hover_background_color_rgb[1].', '.$menu_hover_background_color_rgb[2].', '.$topfit_options['menu_hover_background_color_transparency'].')';
            } ?>

            .mkd-main-menu.mkd-default-nav > ul > li:hover > a span.item_inner,
            .mkd-main-menu.mkd-default-nav > ul > li.mkd-active-item:hover > a span.item_inner,
            .mkd-page-header #lang_sel li:hover .lang_sel_sel {
            background-color: <?php echo esc_attr($menu_hover_background_color); ?>;
            }
        <?php } ?>

        <?php if($topfit_options['menu_active_background_color'] !== '') {
            $menu_active_background_color = $topfit_options['menu_active_background_color'];

            if($topfit_options['menu_active_background_color_transparency'] !== '') {
                $menu_active_background_color_rgb = topfit_mikado_hex2rgb($menu_active_background_color);
                $menu_active_background_color     = 'rgba('.$menu_active_background_color_rgb[0].', '.$menu_active_background_color_rgb[1].', '.$menu_active_background_color_rgb[2].', '.$topfit_options['menu_active_background_color_transparency'].')';
            }
            ?>
            .mkd-main-menu.mkd-default-nav > ul > li.mkd-active-item > a span.item_inner {
            background-color: <?php echo esc_attr($menu_active_background_color); ?>;
            }
        <?php } ?>


        <?php if($topfit_options['menu_light_hovercolor'] !== '') { ?>
            .light .mkd-main-menu.mkd-default-nav > ul > li:hover > a,
            .light .mkd-main-menu.mkd-default-nav > ul > li.mkd-active-item:hover > a{
            color: <?php echo esc_attr($topfit_options['menu_light_hovercolor']); ?> !important;
            }
        <?php } ?>

        <?php if($topfit_options['menu_light_activecolor'] !== '') { ?>
            .light .mkd-main-menu.mkd-default-nav > ul > li.mkd-active-item > a{
            color: <?php echo esc_attr($topfit_options['menu_light_activecolor']); ?> !important;
            }
        <?php } ?>

        <?php if($topfit_options['menu_dark_hovercolor'] !== '') { ?>
            .dark .mkd-main-menu.mkd-default-nav > ul > li:hover > a,
            .dark .mkd-main-menu.mkd-default-nav > ul > li.mkd-active-item:hover > a{
            color: <?php echo esc_attr($topfit_options['menu_dark_hovercolor']); ?> !important;
            }
        <?php } ?>

        <?php if($topfit_options['menu_dark_activecolor'] !== '') { ?>
            .dark .mkd-main-menu.mkd-default-nav > ul > li.mkd-active-item > a{
            color: <?php echo esc_attr($topfit_options['menu_dark_activecolor']); ?>;
            }
        <?php } ?>

        <?php if($topfit_options['menu_lineheight'] != "" || $topfit_options['menu_padding_left_right'] !== '') { ?>
            .mkd-main-menu.mkd-default-nav > ul > li > a span.item_inner{
            <?php if($topfit_options['menu_lineheight'] !== '') { ?> line-height: <?php echo esc_attr($topfit_options['menu_lineheight']); ?>px; <?php } ?>
            <?php if($topfit_options['menu_padding_left_right']) { ?> padding: 0  <?php echo esc_attr($topfit_options['menu_padding_left_right']); ?>px; <?php } ?>
            }
        <?php } ?>

        <?php if($topfit_options['menu_margin_left_right'] !== '') { ?>
            .mkd-main-menu.mkd-default-nav > ul > li{
            margin: 0  <?php echo esc_attr($topfit_options['menu_margin_left_right']); ?>px;
            }
        <?php } ?>

        <?php
        $dropdown_styles = array();
        if($topfit_options['dropdown_background_color'] != "" || $topfit_options['dropdown_background_transparency'] != "") {

            //dropdown background and transparency styles
            $dropdown_bg_color_initial        = '#fff';
            $dropdown_bg_transparency_initial = 1;

            $dropdown_bg_color        = $topfit_options['dropdown_background_color'] !== "" ? $topfit_options['dropdown_background_color'] : $dropdown_bg_color_initial;
            $dropdown_bg_transparency = $topfit_options['dropdown_background_transparency'] !== "" ? $topfit_options['dropdown_background_transparency'] : $dropdown_bg_transparency_initial;

            $dropdown_bg_color_rgb = topfit_mikado_hex2rgb($dropdown_bg_color);

            $dropdown_styles['background-color'] = 'rgba('.$dropdown_bg_color_rgb[0].','.$dropdown_bg_color_rgb[1].','.$dropdown_bg_color_rgb[2].','.$dropdown_bg_transparency.')';

        } //end dropdown background and transparency styles

        $dropdown_selector = array(
            '.mkd-full-width-wide-menu .mkd-drop-down .wide .second',
            '.mkd-drop-down .second .inner > ul',
            '.mkd-drop-down .second .inner ul li ul',
            '.mkd-drop-down li.narrow .second .inner ul',
            '.shopping_cart_dropdown',
            '.mkd-page-header #lang_sel ul ul',
            '.mkd-top-bar #lang_sel ul ul',
            '.mkd-drop-down .wide.wide_background .second'
        );

        echo topfit_mikado_dynamic_css($dropdown_selector, $dropdown_styles);


        ?>

        <?php
        if($topfit_options['dropdown_top_padding'] !== '') {

            if($topfit_options['dropdown_top_padding'] !== '') {
                ?>
                li.narrow .second .inner ul,
                .mkd-drop-down .wide .second .inner > ul{
                padding-top: <?php echo esc_attr($topfit_options['dropdown_top_padding']); ?>px;
                }
            <?php } ?>
        <?php } ?>

        <?php if($topfit_options['dropdown_bottom_padding'] !== '') { ?>
            li.narrow .second .inner ul,
            .mkd-drop-down .wide .second .inner > ul{
            padding-bottom: <?php echo esc_attr($topfit_options['dropdown_bottom_padding']); ?>px;
            }
        <?php } ?>

        <?php if($topfit_options['dropdown_top_position'] !== '') { ?>
            header .mkd-drop-down .second {
            top: <?php echo esc_attr($topfit_options['dropdown_top_position']).'%;'; ?>
            }
        <?php } ?>

        <?php if($topfit_options['dropdown_color'] !== '' || $topfit_options['dropdown_fontsize'] !== '' || $topfit_options['dropdown_lineheight'] !== '' || $topfit_options['dropdown_fontstyle'] !== '' || $topfit_options['dropdown_fontweight'] !== '' || $topfit_options['dropdown_google_fonts'] != "-1" || $topfit_options['dropdown_texttransform'] !== '' || $topfit_options['dropdown_letterspacing'] !== '') { ?>
            .mkd-drop-down .second .inner > ul > li > a,
            .mkd-drop-down .second .inner > ul > li > h4,
            .mkd-main-menu.mkd-default-nav #lang_sel ul li li a,
            .mkd-main-menu.mkd-default-nav #lang_sel_click ul li ul li a,
            .mkd-main-menu.mkd-default-nav #lang_sel ul ul a,
            .mkd-main-menu.mkd-default-nav #lang_sel_click ul ul a{
            <?php if(!empty($topfit_options['dropdown_color'])) { ?> color: <?php echo esc_attr($topfit_options['dropdown_color']); ?>; <?php } ?>
            <?php if($topfit_options['dropdown_google_fonts'] != "-1") { ?>
                font-family: '<?php echo esc_attr(str_replace('+', ' ', $topfit_options['dropdown_google_fonts'])); ?>', sans-serif !important;
            <?php } ?>
            <?php if($topfit_options['dropdown_fontsize'] !== '') { ?> font-size: <?php echo esc_attr($topfit_options['dropdown_fontsize']); ?>px; <?php } ?>
            <?php if($topfit_options['dropdown_lineheight'] !== '') { ?> line-height: <?php echo esc_attr($topfit_options['dropdown_lineheight']); ?>px; <?php } ?>
            <?php if($topfit_options['dropdown_fontstyle'] !== '') { ?> font-style: <?php echo esc_attr($topfit_options['dropdown_fontstyle']); ?>;  <?php } ?>
            <?php if($topfit_options['dropdown_fontweight'] !== '') { ?>font-weight: <?php echo esc_attr($topfit_options['dropdown_fontweight']); ?>; <?php } ?>
            <?php if($topfit_options['dropdown_texttransform'] !== '') { ?> text-transform: <?php echo esc_attr($topfit_options['dropdown_texttransform']); ?>;  <?php } ?>
            <?php if($topfit_options['dropdown_letterspacing'] !== '') { ?> letter-spacing: <?php echo esc_attr($topfit_options['dropdown_letterspacing']); ?>px;  <?php } ?>
            }
        <?php } ?>

        <?php if($topfit_options['dropdown_color'] !== '') { ?>
            .shopping_cart_dropdown ul li
            .item_info_holder .item_left a,
            .shopping_cart_dropdown ul li .item_info_holder .item_right .amount,
            .shopping_cart_dropdown .cart_bottom .subtotal_holder .total,
            .shopping_cart_dropdown .cart_bottom .subtotal_holder .total_amount{
            color: <?php echo esc_attr($topfit_options['dropdown_color']); ?>;
            }
        <?php } ?>

        <?php if(!empty($topfit_options['dropdown_hovercolor'])) { ?>
            .mkd-drop-down .narrow .second .inner > ul > li:hover > a,
            .mkd-main-menu.mkd-default-nav #lang_sel ul li li:hover a,
            .mkd-main-menu.mkd-default-nav #lang_sel_click ul li ul li:hover a,
            .mkd-main-menu.mkd-default-nav #lang_sel ul li:hover > a,
            .mkd-main-menu.mkd-default-nav #lang_sel_click ul li:hover > a{
            color: <?php echo esc_attr($topfit_options['dropdown_hovercolor']); ?> !important;
            }

            .mkd-drop-down .narrow .second .inner > ul > li > a .item_text:after{
                background-color: <?php echo esc_attr($topfit_options['dropdown_hovercolor']); ?> !important;
            }
        <?php } ?>

        <?php if(!empty($topfit_options['dropdown_background_hovercolor'])) { ?>
            .mkd-drop-down li:not(.wide) .second .inner > ul > li:hover{
            background-color: <?php echo esc_attr($topfit_options['dropdown_background_hovercolor']); ?>;
            }
        <?php } ?>

        <?php if(!empty($topfit_options['dropdown_padding_top_bottom'])) { ?>
            .mkd-drop-down .wide .second>.inner>ul>li.sub>ul>li>a,
            .mkd-drop-down .second .inner ul li a,
            .mkd-drop-down .wide .second ul li a,
            .mkd-drop-down .second .inner ul.right li a{
            padding-top: <?php echo esc_attr($topfit_options['dropdown_padding_top_bottom']); ?>px;
            padding-bottom: <?php echo esc_attr($topfit_options['dropdown_padding_top_bottom']); ?>px;
            }
        <?php } ?>

        <?php if($topfit_options['dropdown_wide_color'] !== '' || $topfit_options['dropdown_wide_fontsize'] !== '' || $topfit_options['dropdown_wide_lineheight'] !== '' || $topfit_options['dropdown_wide_fontstyle'] !== '' || $topfit_options['dropdown_wide_fontweight'] !== '' || $topfit_options['dropdown_wide_google_fonts'] !== "-1" || $topfit_options['dropdown_wide_texttransform'] !== '' || $topfit_options['dropdown_wide_letterspacing'] !== '') { ?>
            .mkd-drop-down .wide .second .inner > ul > li > a{
            <?php if($topfit_options['dropdown_wide_color'] !== '') { ?> color: <?php echo esc_attr($topfit_options['dropdown_wide_color']); ?>; <?php } ?>
            <?php if($topfit_options['dropdown_wide_google_fonts'] != "-1") { ?>
                font-family: '<?php echo esc_attr(str_replace('+', ' ', $topfit_options['dropdown_wide_google_fonts'])); ?>', sans-serif !important;
            <?php } ?>
            <?php if($topfit_options['dropdown_wide_fontsize'] !== '') { ?> font-size: <?php echo esc_attr($topfit_options['dropdown_wide_fontsize']); ?>px; <?php } ?>
            <?php if($topfit_options['dropdown_wide_lineheight'] !== '') { ?> line-height: <?php echo esc_attr($topfit_options['dropdown_wide_lineheight']); ?>px; <?php } ?>
            <?php if($topfit_options['dropdown_wide_fontstyle'] !== '') { ?> font-style: <?php echo esc_attr($topfit_options['dropdown_wide_fontstyle']); ?>;  <?php } ?>
            <?php if($topfit_options['dropdown_wide_fontweight'] !== '') { ?>font-weight: <?php echo esc_attr($topfit_options['dropdown_wide_fontweight']); ?>; <?php } ?>
            <?php if($topfit_options['dropdown_wide_texttransform'] !== '') { ?> text-transform: <?php echo esc_attr($topfit_options['dropdown_wide_texttransform']); ?>;  <?php } ?>
            <?php if($topfit_options['dropdown_wide_letterspacing'] !== '') { ?> letter-spacing: <?php echo esc_attr($topfit_options['dropdown_wide_letterspacing']); ?>px;  <?php } ?>
            }
        <?php } ?>

        <?php if($topfit_options['dropdown_wide_hovercolor'] !== '') { ?>
            .mkd-drop-down .wide .second .inner > ul > li:hover > a {
            color: <?php echo esc_attr($topfit_options['dropdown_wide_hovercolor']); ?> !important;
            }
        <?php } ?>

        <?php if(!empty($topfit_options['dropdown_wide_background_hovercolor'])) { ?>
            .mkd-drop-down .wide .second .inner > ul > li:hover > a{
            background-color: <?php echo esc_attr($topfit_options['dropdown_wide_background_hovercolor']); ?>
            }
        <?php } ?>

        <?php if($topfit_options['dropdown_wide_padding_top_bottom'] !== '') { ?>
            .mkd-drop-down .wide .second>.inner > ul > li.sub > ul > li > a,
            .mkd-drop-down .wide .second .inner ul li a,
            .mkd-drop-down .wide .second ul li a,
            .mkd-drop-down .wide .second .inner ul.right li a{
            padding-top: <?php echo esc_attr($topfit_options['dropdown_wide_padding_top_bottom']); ?>px;
            padding-bottom: <?php echo esc_attr($topfit_options['dropdown_wide_padding_top_bottom']); ?>px;
            }
        <?php } ?>

        <?php if($topfit_options['dropdown_color_thirdlvl'] !== '' || $topfit_options['dropdown_fontsize_thirdlvl'] !== '' || $topfit_options['dropdown_lineheight_thirdlvl'] !== '' || $topfit_options['dropdown_fontstyle_thirdlvl'] !== '' || $topfit_options['dropdown_fontweight_thirdlvl'] !== '' || $topfit_options['dropdown_google_fonts_thirdlvl'] != "-1" || $topfit_options['dropdown_texttransform_thirdlvl'] !== '' || $topfit_options['dropdown_letterspacing_thirdlvl'] !== '') { ?>
            .mkd-drop-down .narrow .second .inner ul li.sub ul li a{
            <?php if($topfit_options['dropdown_color_thirdlvl'] !== '') { ?> color: <?php echo esc_attr($topfit_options['dropdown_color_thirdlvl']); ?>;  <?php } ?>
            <?php if($topfit_options['dropdown_google_fonts_thirdlvl'] != "-1") { ?>
                font-family: '<?php echo esc_attr(str_replace('+', ' ', $topfit_options['dropdown_google_fonts_thirdlvl'])); ?>', sans-serif;
            <?php } ?>
            <?php if($topfit_options['dropdown_fontsize_thirdlvl'] !== '') { ?> font-size: <?php echo esc_attr($topfit_options['dropdown_fontsize_thirdlvl']); ?>px;  <?php } ?>
            <?php if($topfit_options['dropdown_lineheight_thirdlvl'] !== '') { ?> line-height: <?php echo esc_attr($topfit_options['dropdown_lineheight_thirdlvl']); ?>px;  <?php } ?>
            <?php if($topfit_options['dropdown_fontstyle_thirdlvl'] !== '') { ?> font-style: <?php echo esc_attr($topfit_options['dropdown_fontstyle_thirdlvl']); ?>;   <?php } ?>
            <?php if($topfit_options['dropdown_fontweight_thirdlvl'] !== '') { ?> font-weight: <?php echo esc_attr($topfit_options['dropdown_fontweight_thirdlvl']); ?>;  <?php } ?>
            <?php if($topfit_options['dropdown_texttransform_thirdlvl'] !== '') { ?> text-transform: <?php echo esc_attr($topfit_options['dropdown_texttransform_thirdlvl']); ?>;  <?php } ?>
            <?php if($topfit_options['dropdown_letterspacing_thirdlvl'] !== '') { ?> letter-spacing: <?php echo esc_attr($topfit_options['dropdown_letterspacing_thirdlvl']); ?>px;  <?php } ?>
            }
        <?php } ?>
        <?php if($topfit_options['dropdown_hovercolor_thirdlvl'] !== '') { ?>
            .mkd-drop-down .narrow .second .inner ul li.sub ul li:not(.flex-active-slide):hover > a:not(.flex-prev):not(.flex-next),
            .mkd-drop-down .narrow .second .inner ul li ul li:not(.flex-active-slide):hover > a:not(.flex-prev):not(.flex-next){
                color: <?php echo esc_attr($topfit_options['dropdown_hovercolor_thirdlvl']); ?> !important;
            }

            .mkd-drop-down .narrow .second .inner ul li.sub ul li:not(.flex-active-slide) > a:not(.flex-prev):not(.flex-next) .item_text:after{
                background-color: <?php echo esc_attr($topfit_options['dropdown_hovercolor_thirdlvl']); ?> !important;
            }
        <?php } ?>

        <?php if($topfit_options['dropdown_background_hovercolor_thirdlvl'] !== '') { ?>
            .mkd-drop-down .narrow .second .inner ul li.sub ul li:hover,
            .mkd-drop-down .narrow .second .inner ul li ul li:hover{
            background-color: <?php echo esc_attr($topfit_options['dropdown_background_hovercolor_thirdlvl']); ?>;
            }
        <?php } ?>

        <?php if($topfit_options['dropdown_wide_color_thirdlvl'] !== '' || $topfit_options['dropdown_wide_fontsize_thirdlvl'] !== '' || $topfit_options['dropdown_wide_lineheight_thirdlvl'] !== '' || $topfit_options['dropdown_wide_fontstyle_thirdlvl'] !== '' || $topfit_options['dropdown_wide_fontweight_thirdlvl'] !== '' || $topfit_options['dropdown_wide_google_fonts_thirdlvl'] != "-1" || $topfit_options['dropdown_wide_texttransform_thirdlvl'] !== '' || $topfit_options['dropdown_wide_letterspacing_thirdlvl'] !== '') { ?>
            .mkd-drop-down .wide .second .inner ul li.sub ul li a,
            .mkd-drop-down .wide .second ul li ul li a{
            <?php if($topfit_options['dropdown_wide_color_thirdlvl'] !== '') { ?> color: <?php echo esc_attr($topfit_options['dropdown_wide_color_thirdlvl']); ?>;  <?php } ?>
            <?php if($topfit_options['dropdown_wide_google_fonts_thirdlvl'] != "-1") { ?>
                font-family: '<?php echo esc_attr(str_replace('+', ' ', $topfit_options['dropdown_wide_google_fonts_thirdlvl'])); ?>', sans-serif;
            <?php } ?>
            <?php if($topfit_options['dropdown_wide_fontsize_thirdlvl'] !== '') { ?> font-size: <?php echo esc_attr($topfit_options['dropdown_wide_fontsize_thirdlvl']); ?>px;  <?php } ?>
            <?php if($topfit_options['dropdown_wide_lineheight_thirdlvl'] !== '') { ?> line-height: <?php echo esc_attr($topfit_options['dropdown_wide_lineheight_thirdlvl']); ?>px;  <?php } ?>
            <?php if($topfit_options['dropdown_wide_fontstyle_thirdlvl'] !== '') { ?> font-style: <?php echo esc_attr($topfit_options['dropdown_wide_fontstyle_thirdlvl']); ?>;   <?php } ?>
            <?php if($topfit_options['dropdown_wide_fontweight_thirdlvl'] !== '') { ?> font-weight: <?php echo esc_attr($topfit_options['dropdown_wide_fontweight_thirdlvl']); ?>;  <?php } ?>
            <?php if($topfit_options['dropdown_wide_texttransform_thirdlvl'] !== '') { ?> text-transform: <?php echo esc_attr($topfit_options['dropdown_wide_texttransform_thirdlvl']); ?>;  <?php } ?>
            <?php if($topfit_options['dropdown_wide_letterspacing_thirdlvl'] !== '') { ?> letter-spacing: <?php echo esc_attr($topfit_options['dropdown_wide_letterspacing_thirdlvl']); ?>px;  <?php } ?>
            }
        <?php } ?>
        <?php if($topfit_options['dropdown_wide_hovercolor_thirdlvl'] !== '') { ?>
            .mkd-drop-down .wide .second .inner ul li.sub ul li:not(.flex-active-slide) > a:not(.flex-prev):not(.flex-next):hover,
            .mkd-drop-down .wide .second .inner ul li ul li:not(.flex-active-slide) > a:not(.flex-prev):not(.flex-next):hover{
            color: <?php echo esc_attr($topfit_options['dropdown_wide_hovercolor_thirdlvl']); ?> !important;
            }

            .mkd-drop-down .wide .second .inner ul li.sub ul li:not(.flex-active-slide) > a:not(.flex-prev):not(.flex-next) .item_text:after{
                background-color: <?php echo esc_attr($topfit_options['dropdown_hovercolor_thirdlvl']); ?> !important;
            }
        <?php } ?>

        <?php if($topfit_options['dropdown_wide_background_hovercolor_thirdlvl'] !== '') { ?>
            .mkd-drop-down .wide .second .inner ul li.sub ul li:hover,
            .mkd-drop-down .wide .second .inner ul li ul li:hover{
            background-color: <?php echo esc_attr($topfit_options['dropdown_wide_background_hovercolor_thirdlvl']); ?>;
            }
        <?php }
    }

    add_action('topfit_mikado_style_dynamic', 'topfit_mikado_main_menu_styles');
}

if(!function_exists('topfit_mikado_vertical_main_menu_styles')) {
    /**
     * Generates styles for vertical main main menu
     */
    function topfit_mikado_vertical_main_menu_styles() {
        $dropdown_styles = array();

        if(topfit_mikado_options()->getOptionValue('vertical_dropdown_background_color') !== '' || topfit_mikado_options()->getOptionValue('vertical_dropdown_transparency') !== '') {

            //dropdown background and transparency styles
            $dropdown_bg_color_initial        = '#fff';
            $dropdown_bg_transparency_initial = 1;

            $dropdown_bg_color        = topfit_mikado_options()->getOptionValue('vertical_dropdown_background_color') !== "" ? topfit_mikado_options()->getOptionValue('vertical_dropdown_background_color') : $dropdown_bg_color_initial;
            $dropdown_bg_transparency = topfit_mikado_options()->getOptionValue('vertical_dropdown_transparency') !== "" ? topfit_mikado_options()->getOptionValue('vertical_dropdown_transparency') : $dropdown_bg_transparency_initial;

            $dropdown_bg_color_rgb = topfit_mikado_hex2rgb($dropdown_bg_color);

            $dropdown_styles['background-color'] = 'rgba('.$dropdown_bg_color_rgb[0].','.$dropdown_bg_color_rgb[1].','.$dropdown_bg_color_rgb[2].','.$dropdown_bg_transparency.')';

        }

        if(topfit_mikado_options()->getOptionValue('vertical_dropdown_border_color') !== '') {
            $dropdown_styles['border-color'] = topfit_mikado_options()->getOptionValue('vertical_dropdown_border_color');
        }

        $dropdown_selector = array(
            '.mkd-header-vertical .mkd-vertical-dropdown-float .menu-item .second',
            '.mkd-header-vertical .mkd-vertical-dropdown-float .second .inner ul ul'
        );

        echo topfit_mikado_dynamic_css($dropdown_selector, $dropdown_styles);

        $fist_level_styles       = array();
        $fist_level_hover_styles = array();

        if(topfit_mikado_options()->getOptionValue('vertical_menu_1st_color') !== '') {
            $fist_level_styles['color'] = topfit_mikado_options()->getOptionValue('vertical_menu_1st_color');
        }
        if(topfit_mikado_options()->getOptionValue('vertical_menu_1st_google_fonts') !== '-1') {
            $fist_level_styles['font-family'] = topfit_mikado_get_formatted_font_family(topfit_mikado_options()->getOptionValue('vertical_menu_1st_google_fonts'));
        }
        if(topfit_mikado_options()->getOptionValue('vertical_menu_1st_fontsize') !== '') {
            $fist_level_styles['font-size'] = topfit_mikado_options()->getOptionValue('vertical_menu_1st_fontsize').'px';
        }
        if(topfit_mikado_options()->getOptionValue('vertical_menu_1st_lineheight') !== '') {
            $fist_level_styles['line-height'] = topfit_mikado_options()->getOptionValue('vertical_menu_1st_lineheight').'px';
        }
        if(topfit_mikado_options()->getOptionValue('vertical_menu_1st_texttransform') !== '') {
            $fist_level_styles['text-transform'] = topfit_mikado_options()->getOptionValue('vertical_menu_1st_texttransform');
        }
        if(topfit_mikado_options()->getOptionValue('vertical_menu_1st_fontstyle') !== '') {
            $fist_level_styles['font-style'] = topfit_mikado_options()->getOptionValue('vertical_menu_1st_fontstyle');
        }
        if(topfit_mikado_options()->getOptionValue('vertical_menu_1st_fontweight') !== '') {
            $fist_level_styles['font-weight'] = topfit_mikado_options()->getOptionValue('vertical_menu_1st_fontweight');
        }
        if(topfit_mikado_options()->getOptionValue('vertical_menu_1st_letter_spacing') !== '') {
            $fist_level_styles['letter-spacing'] = topfit_mikado_options()->getOptionValue('vertical_menu_1st_letter_spacing').'px';
        }

        if(topfit_mikado_options()->getOptionValue('vertical_menu_1st_hover_color') !== '') {
            $fist_level_hover_styles['color'] = topfit_mikado_options()->getOptionValue('vertical_menu_1st_hover_color');
        }

        $first_level_selector       = array(
            '.mkd-header-vertical .mkd-vertical-menu > ul > li > a'
        );
        $first_level_hover_selector = array(
            '.mkd-header-vertical .mkd-vertical-menu > ul > li:hover > a',
            '.mkd-header-vertical .mkd-vertical-menu > ul > li > a.mkd-active-item'
        );

        echo topfit_mikado_dynamic_css($first_level_selector, $fist_level_styles);
        echo topfit_mikado_dynamic_css($first_level_hover_selector, $fist_level_hover_styles);
        if(topfit_mikado_options()->getOptionValue('vertical_menu_1st_hover_background_color') !== '') {

            $rgba = topfit_mikado_hex2rgb(topfit_mikado_options()->getOptionValue('vertical_menu_1st_hover_background_color'));
            echo topfit_mikado_dynamic_css('.mkd-header-vertical .mkd-vertical-menu > ul > li:hover', array('background-color' => 'rgba('.$rgba[0].','.$rgba[1].','.$rgba[2].',0.07)'));
        }

        $second_level_styles       = array();
        $second_level_hover_styles = array();

        if(topfit_mikado_options()->getOptionValue('vertical_menu_2nd_color') !== '') {
            $second_level_styles['color'] = topfit_mikado_options()->getOptionValue('vertical_menu_2nd_color');
        }
        if(topfit_mikado_options()->getOptionValue('vertical_menu_2nd_google_fonts') !== '-1') {
            $second_level_styles['font-family'] = topfit_mikado_get_formatted_font_family(topfit_mikado_options()->getOptionValue('vertical_menu_2nd_google_fonts'));
        }
        if(topfit_mikado_options()->getOptionValue('vertical_menu_2nd_fontsize') !== '') {
            $second_level_styles['font-size'] = topfit_mikado_options()->getOptionValue('vertical_menu_2nd_fontsize').'px';
        }
        if(topfit_mikado_options()->getOptionValue('vertical_menu_2nd_lineheight') !== '') {
            $second_level_styles['line-height'] = topfit_mikado_options()->getOptionValue('vertical_menu_2nd_lineheight').'px';
        }
        if(topfit_mikado_options()->getOptionValue('vertical_menu_2nd_texttransform') !== '') {
            $second_level_styles['text-transform'] = topfit_mikado_options()->getOptionValue('vertical_menu_2nd_texttransform');
        }
        if(topfit_mikado_options()->getOptionValue('vertical_menu_2nd_fontstyle') !== '') {
            $second_level_styles['font-style'] = topfit_mikado_options()->getOptionValue('vertical_menu_2nd_fontstyle');
        }
        if(topfit_mikado_options()->getOptionValue('vertical_menu_2nd_fontweight') !== '') {
            $second_level_styles['font-weight'] = topfit_mikado_options()->getOptionValue('vertical_menu_2nd_fontweight');
        }
        if(topfit_mikado_options()->getOptionValue('vertical_menu_2nd_letter_spacing') !== '') {
            $second_level_styles['letter-spacing'] = topfit_mikado_options()->getOptionValue('vertical_menu_2nd_letter_spacing').'px';
        }

        if(topfit_mikado_options()->getOptionValue('vertical_menu_2nd_hover_color') !== '') {
            $second_level_hover_styles['color'] = topfit_mikado_options()->getOptionValue('vertical_menu_2nd_hover_color');
        }

        $second_level_selector = array(
            '.mkd-header-vertical .mkd-vertical-menu .second .inner > ul > li > a'
        );

        $second_level_hover_selector = array(
            '.mkd-header-vertical .mkd-vertical-menu .second .inner > ul > li:hover > a',
            '.mkd-header-vertical .mkd-vertical-menu .second .inner > ul > li > a.mkd-active-item'
        );

        echo topfit_mikado_dynamic_css($second_level_selector, $second_level_styles);
        echo topfit_mikado_dynamic_css($second_level_hover_selector, $second_level_hover_styles);
        if(topfit_mikado_options()->getOptionValue('vertical_menu_2nd_hover_background_color') !== '') {
            echo topfit_mikado_dynamic_css('.mkd-header-vertical .mkd-vertical-dropdown-float .second .inner > ul > li:hover', array('background-color' => topfit_mikado_options()->getOptionValue('vertical_menu_2nd_hover_background_color')));
        }

        $third_level_styles       = array();
        $third_level_hover_styles = array();

        if(topfit_mikado_options()->getOptionValue('vertical_menu_3rd_color') !== '') {
            $third_level_styles['color'] = topfit_mikado_options()->getOptionValue('vertical_menu_3rd_color');
        }
        if(topfit_mikado_options()->getOptionValue('vertical_menu_3rd_google_fonts') !== '-1') {
            $third_level_styles['font-family'] = topfit_mikado_get_formatted_font_family(topfit_mikado_options()->getOptionValue('vertical_menu_3rd_google_fonts'));
        }
        if(topfit_mikado_options()->getOptionValue('vertical_menu_3rd_fontsize') !== '') {
            $third_level_styles['font-size'] = topfit_mikado_options()->getOptionValue('vertical_menu_3rd_fontsize').'px';
        }
        if(topfit_mikado_options()->getOptionValue('vertical_menu_3rd_lineheight') !== '') {
            $third_level_styles['line-height'] = topfit_mikado_options()->getOptionValue('vertical_menu_3rd_lineheight').'px';
        }
        if(topfit_mikado_options()->getOptionValue('vertical_menu_3rd_texttransform') !== '') {
            $third_level_styles['text-transform'] = topfit_mikado_options()->getOptionValue('vertical_menu_3rd_texttransform');
        }
        if(topfit_mikado_options()->getOptionValue('vertical_menu_3rd_fontstyle') !== '') {
            $third_level_styles['font-style'] = topfit_mikado_options()->getOptionValue('vertical_menu_3rd_fontstyle');
        }
        if(topfit_mikado_options()->getOptionValue('vertical_menu_3rd_fontweight') !== '') {
            $third_level_styles['font-weight'] = topfit_mikado_options()->getOptionValue('vertical_menu_3rd_fontweight');
        }
        if(topfit_mikado_options()->getOptionValue('vertical_menu_3rd_letter_spacing') !== '') {
            $third_level_styles['letter-spacing'] = topfit_mikado_options()->getOptionValue('vertical_menu_3rd_letter_spacing').'px';
        }

        if(topfit_mikado_options()->getOptionValue('vertical_menu_3rd_hover_color') !== '') {
            $third_level_hover_styles['color'] = topfit_mikado_options()->getOptionValue('vertical_menu_3rd_hover_color');
        }

        $third_level_selector = array(
            '.mkd-header-vertical .mkd-vertical-menu .second .inner ul li ul li a'
        );

        $third_level_hover_selector = array(
            '.mkd-header-vertical .mkd-vertical-menu .second .inner ul li ul li:hover a',
            '.mkd-header-vertical .mkd-vertical-menu .second .inner ul li ul li a.mkd-active-item'
        );

        echo topfit_mikado_dynamic_css($third_level_selector, $third_level_styles);
        echo topfit_mikado_dynamic_css($third_level_hover_selector, $third_level_hover_styles);
        if(topfit_mikado_options()->getOptionValue('vertical_menu_3rd_hover_background_color') !== '') {
            echo topfit_mikado_dynamic_css('.mkd-header-vertical .mkd-vertical-dropdown-float .second .inner ul li.sub ul li:hover', array('background-color' => topfit_mikado_options()->getOptionValue('vertical_menu_3rd_hover_background_color')));
        }
    }

    add_action('topfit_mikado_style_dynamic', 'topfit_mikado_vertical_main_menu_styles');
}