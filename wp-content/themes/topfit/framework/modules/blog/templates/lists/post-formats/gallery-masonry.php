<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="mkd-post-content">
		<?php topfit_mikado_get_module_template_part('templates/lists/parts/gallery', 'blog','', array('image_size' => 'topfit_mikado_landscape')); ?>
		<div class="mkd-post-text">
			<div class="mkd-post-text-inner">
				<div class="mkd-categories-list">
					<?php topfit_mikado_get_module_template_part('templates/parts/post-info-category', 'blog'); ?>
				</div>
				<?php topfit_mikado_get_module_template_part('templates/lists/parts/title', 'blog'); ?>
				<?php
				topfit_mikado_excerpt($excerpt_length);
				$args_pages = array(
					'before'      => '<div class="mkd-single-links-pages"><div class="mkd-single-links-pages-inner">',
					'after'       => '</div></div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
					'pagelink'    => '%'
				);

				wp_link_pages($args_pages);
				?>
			</div>
			<div class="mkd-post-info">
				<?php topfit_mikado_post_info(array(
					'date'     => 'yes',
					'comments' => (topfit_mikado_options()->getOptionValue('blog_single_comments') == 'yes') ? 'yes' : 'no',
					'share'    => 'yes'));
				?>
			</div>
		</div>
	</div>
</article>