<?php

if(!function_exists('topfit_mikado_footer_bg_image_styles')) {
    /**
     * Outputs background image styles for footer
     */
    function topfit_mikado_footer_bg_image_styles() {
        $background_image = topfit_mikado_options()->getOptionValue('footer_background_image');

        if($background_image !== '') {
            $footer_bg_image_styles['background-image'] = 'url('.$background_image.')';

            echo topfit_mikado_dynamic_css('body.mkd-footer-with-bg-image .mkd-page-footer', $footer_bg_image_styles);
        }
    }

    add_action('topfit_mikado_style_dynamic', 'topfit_mikado_footer_bg_image_styles');
}
