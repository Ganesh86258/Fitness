<div class="<?php echo esc_attr($blog_classes) ?>"   <?php echo esc_attr($blog_data_params) ?> >
	<?php
	if ($blog_query->have_posts()) : while ($blog_query->have_posts()) : $blog_query->the_post();
		topfit_mikado_get_post_format_html($blog_type);
	endwhile;
		wp_reset_postdata();
	else:
		topfit_mikado_get_module_template_part('templates/parts/no-posts', 'blog');
	endif;

	/*pagination*/
	if (topfit_mikado_options()->getOptionValue('pagination') == 'yes') :
		topfit_mikado_pagination($blog_query->max_num_pages, $blog_page_range, $paged);
	endif;

	do_action('topfit_mikado_generate_load_more_button');
	do_action('topfit_mikado_generate_scroll_trigger');
	?>
</div>