<?php
/*
	Template Name: Blog: Standard
*/
get_header();
topfit_mikado_get_title();
get_template_part('slider'); ?>
	<div class="mkd-container">

		<?php do_action('topfit_mikado_after_container_open');
		if (have_posts()) : while (have_posts()) : the_post();
			the_content();
			do_action('topfit_mikado_page_after_content'); ?>
			<div class="mkd-container-inner">
				<?php topfit_mikado_get_blog('standard'); ?>
			</div>
		<?php endwhile; endif;
		do_action('topfit_mikado_before_container_close'); ?>
	</div>
<?php get_footer(); ?>