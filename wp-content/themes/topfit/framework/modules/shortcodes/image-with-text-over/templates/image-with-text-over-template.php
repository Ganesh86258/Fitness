<div class="mkd-iwt-over">
	<?php if ($link != '') { ?>
		<a href="<?php echo esc_attr($link) ?>" target="<?php echo esc_attr($link_target) ?>"></a>
	<?php } ?>
	<div class="mkd-image-holder">
		<?php echo wp_get_attachment_image($image, 'full'); ?>
	</div>
	<div class="mkd-text-holder">
		<div class="mkd-text-holder-inner">
			<p class="mkd-text" <?php topfit_mikado_inline_style($text_style); ?>>
				<?php echo esc_html($text); ?>
			</p>
		</div>
	</div>
</div>