<div id="mkd-testimonials<?php echo esc_attr($current_id) ?>" class="mkd-testimonial-content <?php echo esc_attr($testimonial_type); ?>">
    <div class="mkd-testimonial-slide-inner">
        <div class="mkd-logo-text">
            <div class="mkd-testimonial-text">
                <?php if ($logo_image !== ''): ?>
                    <div class="mkd-logo-image">
                        <img src="<?php echo esc_attr($logo_image); ?>" alt="" />
                    </div>
                <?php endif; ?>
                <h3 class="mkd-testimonial-title">
                    <?php echo esc_attr($title) ?>
                </h3>
                <p><?php esc_html_e($text); ?></p>
            </div>
        </div>
        <div class="mkd-testimonial-info">
            <?php if($show_image === 'yes' && has_post_thumbnail()): ?>
                <div class="mkd-testimonial-author-image">
                    <?php the_post_thumbnail(); ?>
                </div>
            <?php endif; ?>
            <h4 class="mkd-testimonial-author-text">
                <?php echo esc_attr($author) ?>
            </h4>
            <?php if($show_position == "yes" && $job !== ''): ?>
                <div class="mkd-testimonials-job">
                    <?php echo esc_attr($job) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
