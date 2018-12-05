<div class="mkd-section-title-holder">
	<<?php echo esc_attr($title_tag); ?> <?php topfit_mikado_class_attribute($section_title_classes); ?> <?php topfit_mikado_inline_style($section_title_styles); ?>>
	<?php echo esc_html($title); ?><?php if ($highlighted_text !== ''){ ?><span class="mkd-section-highlighted" <?php topfit_mikado_inline_style($highlighted_style)?>><?php echo esc_html($highlighted_text);?></span><?php } ?>
</<?php echo esc_attr($title_tag); ?>>
</div>