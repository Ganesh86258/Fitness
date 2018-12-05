<?php if ($query_results->max_num_pages > 1) { ?>
	<div class="mkd-ptf-list-paging">
		<span class="mkd-ptf-list-load-more">
			<?php if (mkd_core_theme_installed()) : ?>
				<?php
				echo topfit_mikado_get_button_html(array(
					'link' => 'javascript: void(0)',
					'text' => esc_html__('Load More', 'mkd-core'),
					'size' => 'small'
				));
				?>
			<?php else: ?>
				<a href="javascript: void(0)"><?php esc_html_e('Load More', 'mkd-core'); ?></a>
			<?php endif; ?>
		</span>
	</div>
<?php }