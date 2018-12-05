<div class="mkd-events-list mkd-grid-row">
    <?php if($query->have_posts()) : ?>
        <?php while($query->have_posts()) : $query->the_post(); ?>
            <?php $caller->getEventItemTemplate($params); ?>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    <?php else: ?>
        <p><?php esc_html_e('Sorry, no posts matched your criteria.', 'topfit'); ?></p>
    <?php endif; ?>
</div>