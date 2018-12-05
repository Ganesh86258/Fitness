<?php get_header(); ?>
<?php topfit_mikado_get_title(); ?>
<?php get_template_part('slider'); ?>
<div class="mkd-container">
    <?php do_action('topfit_mikado_after_container_open'); ?>
    <div class="mkd-container-inner clearfix">
        <div id="tribe-events-pg-template">
            <?php tribe_events_before_html(); ?>
            <?php tribe_get_view(); ?>
            <?php tribe_events_after_html(); ?>
        </div> <!-- #tribe-events-pg-template -->
        <?php do_action('topfit_mikado_page_after_content'); ?>
    </div>
    <?php do_action('topfit_mikado_before_container_close'); ?>
</div>
<?php get_footer(); ?>
