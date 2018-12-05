<?php
	/*
	Template Name: Blog: Masonry Full Width
	*/
?>
<?php get_header(); ?>

<?php topfit_mikado_get_title(); ?>
<?php get_template_part('slider'); ?>

	<div class="mkd-full-width">
		<div class="mkd-full-width-inner clearfix">
		<?php if (have_posts()) : while (have_posts()) : the_post();
			 the_content(); ?>
			<?php do_action('topfit_mikado_page_after_content'); ?>
			<?php topfit_mikado_get_blog('masonry-full-width'); ?>
		<?php
		endwhile;
		endif;
		?>
		</div>
	</div>
<?php get_footer(); ?>