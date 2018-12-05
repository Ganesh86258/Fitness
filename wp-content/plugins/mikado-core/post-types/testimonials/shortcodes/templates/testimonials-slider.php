<div class="mkd-testimonial-content <?php echo esc_attr($testimonial_type); ?>">

	<?php if($show_image === 'yes' && has_post_thumbnail()): ?>
		<div class="mkd-testimonial-author-image"><?php the_post_thumbnail(); ?></div>
	<?php endif; ?>

	<div class="mkd-testimonial-content-inner">
		<div class="mkd-testimonial-text-holder">
			<div class="mkd-testimonial-text-inner <?php echo esc_attr($light_class); ?>">
				<h3 class="mkd-testimonial-text"><?php echo trim($text) ?></h3>
				<?php if($show_author == "yes") { ?>
					<div class="mkd-testimonial-author">
						<h5 class="mkd-testimonial-author-text <?php echo esc_attr($light_class); ?>"><?php echo esc_attr($author) ?></h5>
						<?php if($show_position == "yes" && $job !== '') { ?>
							<h6 class="mkd-testimonials-job <?php echo esc_attr($light_class); ?>"><?php echo esc_attr($job) ?></h6>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
