<div class="mkd-card-slide">
	<div class="mkd-card-slide-inner">
		<?php if ($image !== ''): ?>
			<div class="mkd-card-image">
				<?php if (!empty($link) && !empty($link_text)) :
					echo "<a href='" . $link . "'>";
				endif;
				?>
				<?php echo wp_get_attachment_image($image, 'full'); ?>
				<?php if (!empty($link) && !empty($link_text)) :
					echo "</a>";
				endif;
				?>
                <?php if(!empty($icon)): ?>
                    <div class="mkd-card-icon">
                        <?php echo topfit_mikado_icon_collections()->renderIcon($icon, $icon_pack, $params); ?>
                    </div>
                <?php endif; ?>
			</div>
		<?php endif; ?>
		<div class="mkd-card-content">
			<?php if ($title !== ''): ?>
			<?php if (!empty($link) && !empty($link_text)) :
				echo "<a href='" . $link . "'>";
			endif;
			?>
			<<?php echo esc_html($title_tag); ?>
			class="mkd-card-title" <?php topfit_mikado_inline_style($title_inline_styles); ?>>
			<?php echo esc_html($title); ?>
		</<?php echo esc_html($title_tag); ?>>
				<?php if (!empty($link) && !empty($link_text)) :
		echo "</a>";
	endif;
	?>
	<?php endif; ?>
		<?php if ($subtitle !== ''): ?>
			<p class="mkd-card-subtitle">
				<?php echo esc_html($subtitle); ?>
			</p>
		<?php endif; ?>
		<?php if ($text !== ''): ?>
			<p class="mkd-card-text">
				<?php echo esc_html($text); ?>
			</p>
		<?php endif; ?>
		<?php
		if (!empty($link) && !empty($link_text)) :
			echo topfit_mikado_get_button_html($button_parameters);
		endif;
		?>
	</div>
</div>
</div>