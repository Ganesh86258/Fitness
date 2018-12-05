<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="mkd-post-content">
		<div class="mkd-post-text">
			<div class="mkd-post-text-inner">
				<?php topfit_mikado_get_module_template_part('templates/lists/parts/title', 'blog'); ?>
				<?php topfit_mikado_excerpt($excerpt_length); ?>
				<div class="mkd-post-info">
					<?php topfit_mikado_post_info(array('date' => 'yes')) ?>
				</div>
			</div>
		</div>
	</div>
</article>