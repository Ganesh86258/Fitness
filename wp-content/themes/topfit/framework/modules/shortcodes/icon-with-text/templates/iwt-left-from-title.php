<div <?php topfit_mikado_class_attribute($holder_classes); ?>>
	<div class="mkd-iwt-content-holder" <?php topfit_mikado_inline_style($left_from_title_styles) ?>>
		<div class="mkd-iwt-icon-title-holder">
			<div class="mkd-iwt-icon-holder">
				<?php if(!empty($custom_icon)) : ?>
				<span class="mkd-iwt-custom-icon" <?php topfit_mikado_inline_style($custom_icon_styles);?>><?php echo wp_get_attachment_image($custom_icon, 'full'); ?></span>
				<?php else: ?>
					<?php echo topfit_mikado_get_shortcode_module_template_part('templates/icon', 'icon-with-text', '', array('icon_parameters' => $icon_parameters)); ?>
				<?php endif; ?>
			</div>
			<?php if ($title != ''){ ?>
			<div class="mkd-iwt-title-holder">
				<<?php echo esc_attr($title_tag); ?> <?php topfit_mikado_inline_style($title_styles); ?>><?php echo esc_html($title); ?></<?php echo esc_attr($title_tag); ?>>
		</div>
		<?php } ?>
	</div>
	<div class="mkd-iwt-text-holder">
		<p <?php topfit_mikado_inline_style($text_styles); ?>><?php echo esc_html($text); ?></p>

		<?php
		if (!empty($link) && !empty($link_text)) :
			echo topfit_mikado_get_button_html($button_parameters);
		endif;
		?>
	</div>
</div>
</div>