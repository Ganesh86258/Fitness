<div <?php topfit_mikado_class_attribute($holder_classes); ?>>
	<div
		class="mkd-team-slider <?php echo esc_attr($slider_type); ?>" <?php echo topfit_mikado_get_inline_attrs($data_attrs); ?>>
		<?php echo do_shortcode($content); ?>
	</div>
</div>