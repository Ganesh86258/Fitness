<?php
/**
 * Custom Font shortcode template
 */
?>
<<?php echo esc_attr($custom_font_tag); ?> class="mkd-custom-font-holder" <?php topfit_mikado_inline_style($custom_font_style);
    echo esc_attr($custom_font_data); ?>>
        <?php if($custom_font_shadow_effect == 'yes') { ?>
            <span class="mkd-custom-font-holder-top-shadow-clone">
            <?php echo esc_html($content_custom_font); ?>
            </span>
        <?php } ?>
    <?php echo esc_html($content_custom_font); ?>
        <?php if($custom_font_shadow_effect == 'yes') { ?>
            <span class="mkd-custom-font-holder-bottom-shadow-clone">
            <?php echo esc_html($content_custom_font); ?>
            </span>
        <?php } ?>
</<?php echo esc_attr($custom_font_tag); ?>>