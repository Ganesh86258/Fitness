<?php if(topfit_mikado_options()->getOptionValue('portfolio_single_hide_date') !== 'yes') : ?>

	<div class="mkd-portfolio-info-item mkd-portfolio-date clearfix">
		<h6><?php esc_html_e('Date', 'topfit'); ?></h6>

		<p><?php the_time(get_option('date_format')); ?></p>
	</div>

<?php endif; ?>