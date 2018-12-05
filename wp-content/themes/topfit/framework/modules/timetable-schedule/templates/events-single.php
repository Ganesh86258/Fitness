<div class="mkd-ttevents-single">
    <?php if(has_post_thumbnail()) : ?>
        <div class="mkd-ttevents-single-image-holder">
            <?php the_post_thumbnail('full'); ?>
        </div>
    <?php endif; ?>

    <div class="mkd-ttevents-single-holder">
        <?php if($subtitle !== '') : ?>
            <h5 class="mkd-ttevents-single-subtitle"><?php echo esc_html($subtitle); ?></h5>
        <?php endif; ?>
        <h3 class="mkd-ttevents-single-title"><?php the_title(); ?></h3>

        <div class="mkd-ttevents-single-content">
            <?php the_content(); ?>
        </div>
    </div>
</div>