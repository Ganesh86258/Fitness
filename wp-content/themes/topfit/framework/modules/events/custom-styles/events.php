<?php

if(!function_exists('topfit_mikado_events_custom_styles')) {
    /**
     * Outputs custom styles for events
     */
    function topfit_mikado_events_custom_styles() {
        if(topfit_mikado_options()->getOptionValue('first_color') !== "") {
            $color_selector = array(
                '.mkd-tribe-events-single .mkd-events-single-meta .mkd-events-single-next-event a:hover',
                '.mkd-tribe-events-single .mkd-events-single-meta .mkd-events-single-prev-event a:hover',
                '#tribe-events-content-wrapper .tribe-bar-views-list li.tribe-bar-active a',
                '#tribe-events-content-wrapper .tribe-bar-views-list li a:hover',
                '#tribe-events-content-wrapper .tribe-events-sub-nav .tribe-events-nav-previous a:hover',
                '#tribe-events-content-wrapper .tribe-events-sub-nav .tribe-events-nav-next a:hover',
                '#tribe-events-content-wrapper .tribe-events-calendar td div[id*=tribe-events-daynum-] a:hover'
            );

            $color_important_selector = array();

            $background_color_selector = array(
                '.mkd-tribe-events-single .mkd-events-single-main-info .mkd-events-single-date-holder'
            );

            $background_color_important_selector = array();

            $border_color_selector = array(
                '#tribe-events-content-wrapper .tribe-bar-filters input[type=text]:focus'
            );

            echo topfit_mikado_dynamic_css($color_selector, array('color' => topfit_mikado_options()->getOptionValue('first_color')));
            echo topfit_mikado_dynamic_css($color_important_selector, array('color' => topfit_mikado_options()->getOptionValue('first_color').'!important'));
            echo topfit_mikado_dynamic_css($background_color_selector, array('background-color' => topfit_mikado_options()->getOptionValue('first_color')));
            echo topfit_mikado_dynamic_css($background_color_important_selector, array('background-color' => topfit_mikado_options()->getOptionValue('first_color').'!important'));
            echo topfit_mikado_dynamic_css($border_color_selector, array('border-color' => topfit_mikado_options()->getOptionValue('first_color')));
        }
    }

    //add_action('topfit_mikado_style_dynamic', 'topfit_mikado_events_custom_styles');
}