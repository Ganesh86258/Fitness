<li data-date="<?php echo esc_attr($date); ?>">
	<div class="mkd-horizontal-item">
		<div class="mkd-horizontal-item-left">
			<div class="mkd-horizontal-timeline-item-image">
				<?php echo wp_get_attachment_image($image, 'full'); ?>
			</div>
		</div>
		<div class="mkd-horizontal-item-right">
			<?php if (!empty($subtitle)) : ?>
				<div class="mkd-horizontal-timeline-item-subtitle">
					<p><?php echo esc_html($subtitle); ?></p>
				</div>
			<?php endif; ?>
			<?php if (!empty($title)) : ?>
				<h2 class="mkd-horizontal-timeline-item-title"><?php echo esc_html($title); ?></h2>
			<?php endif; ?>
			<?php echo topfit_mikado_remove_auto_ptag($content, true); ?>
		</div>
	</div>
</li>