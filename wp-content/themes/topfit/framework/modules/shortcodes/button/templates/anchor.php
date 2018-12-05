<a href="<?php echo esc_url($link); ?>"
   target="<?php echo esc_attr($target); ?>" <?php topfit_mikado_inline_style($button_styles); ?> <?php topfit_mikado_class_attribute($button_classes); ?> <?php echo topfit_mikado_get_inline_attrs($button_data); ?> <?php echo topfit_mikado_get_inline_attrs($button_custom_attrs); ?>>
	<span class="mkd-btn-text"><?php echo esc_html($text); ?></span>
	<?php if ($params['type'] === 'underline'): ?>
		<span
			class="mkd-btn-underline-line" <?php if (!empty($color)) echo 'style="background-color:' . $color . '"'; ?>></span>
	<?php endif; ?>

	<?php if ($show_icon) : ?>
		<span class="mkd-btn-icon-holder" <?php if (!empty($icon_styles)) echo 'style="'. $icon_styles.'"'; ?>>
			<?php echo topfit_mikado_icon_collections()->renderIcon($icon, $icon_pack, array(
				'icon_attributes' => array(
					'class' => 'mkd-btn-icon-elem'
				)
			)); ?>
		</span>
	<?php endif; ?>

	<?php if ($display_helper) : ?>
		<span class="mkd-btn-helper" <?php topfit_mikado_inline_style($helper_styles); ?>></span>
	<?php endif; ?>
</a>