<div class="mkd-pricing-table-wi" <?php topfit_mikado_inline_style($inline_styles); ?> <?php echo topfit_mikado_get_inline_attrs($data_attrs); ?>>
	<div class="mkd-pricing-table-wi-inner">
		<div class="mkd-pt-icon">
			<?php echo topfit_mikado_icon_collections()->renderIcon($icon, $icon_pack, $params); ?>
		</div>
		<h2 class="mkd-pt-title"><?php echo esc_html($title); ?></h2>

		<p class="mkd-pt-subtitle">
			<?php echo esc_html($subtitle); ?>
		</p>
		<?php if (!empty($price)) : ?>
			<div class="mkd-price-currency-period">
				<?php if (!empty($currency)) : ?>
					<span class="mkd-currency"><?php echo esc_html($currency); ?></span>
				<?php endif; ?>

				<span class="mkd-price"><?php echo esc_html($price); ?></span>

				<?php if (!empty($price_period)) : ?>
					<span class="mkd-price-period">/<?php echo esc_html($price_period) ?></span>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="mkd-pt-content">
			<ul>
				<li class="mkd-pt-content-inner">
					<?php echo do_shortcode(preg_replace('#^<\/p>|<p>$#', '', $content)); ?>
				</li>
			</ul>
		</div>
		<?php if (is_array($button_params) && count($button_params)) : ?>
			<div class="mkd-price-button">
				<?php echo topfit_mikado_get_button_html($button_params); ?>
			</div>
		<?php endif; ?>
	</div>
</div>