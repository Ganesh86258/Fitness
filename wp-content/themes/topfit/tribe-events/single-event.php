<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */

if(!defined('ABSPATH')) {
    die('-1');
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();

$event_id = get_the_ID();

?>

<div id="tribe-events-content" class="tribe-events-single mkd-tribe-events-single">
    <!-- Notices -->
    <?php tribe_the_notices() ?>

    <div class="mkd-events-single-main-info clearfix">
        <div class="mkd-events-single-date-holder">
            <div class="mkd-events-single-date-inner">
				<span class="mkd-events-single-date-day">
					<?php echo tribe_get_start_date(null, true, 'd'); ?>
				</span>

				<span class="mkd-events-single-date-month">
					<?php echo tribe_get_start_date(null, true, 'M');
                    echo '.' ?>
				</span>
            </div>
        </div>
        <div class="mkd-events-single-title-holder">
            <h2 class="mkd-events-single-title"><?php the_title(); ?></h2>
            <div class="mkd-events-single-date">
				<span class="mkd-events-single-info-icon">
					<?php echo topfit_mikado_icon_collections()->renderIcon('icon-clock', 'simple_line_icons'); ?>
				</span>
                <?php echo tribe_events_event_schedule_details($event_id); ?>
            </div>
            <?php if(tribe_get_cost($event_id)) { ?>
                <div class="mkd-events-single-cost">
                    <?php echo tribe_get_cost(null, true); ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="mkd-events-single-main-content">
        <div class="mkd-grid-row mkd-events-single-media">
            <div class="mkd-events-single-featured-image mkd-grid-col-6">
                <?php echo tribe_event_featured_image($event_id, 'full', false); ?>
            </div>

            <div class="mkd-events-single-content-holder mkd-grid-col-6">
                <?php do_action('tribe_events_single_event_before_the_content') ?>
                <?php the_content(); ?>
                <h3><?php esc_html_e('Event Details', 'topfit'); ?></h3>

                <div class="mkd-events-single-meta-holder mkd-grid-row">
                    <div class="mkd-grid-col-6">
                        <div class="mkd-events-single-meta-item">
					<span class="mkd-events-single-meta-icon">
						<?php echo topfit_mikado_icon_collections()->renderIcon('lnr-calendar-full', 'linear_icons'); ?>
					</span>
                            <span class="mkd-events-single-meta-label"><?php esc_html_e('Date:', 'topfit'); ?></span>
					<span class="mkd-events-single-meta-value">
						<?php echo tribe_events_event_schedule_details(); ?>
					</span>
                        </div>

                        <div class="mkd-events-single-meta-item">
					<span class="mkd-events-single-meta-icon">
						<?php echo topfit_mikado_icon_collections()->renderIcon('icon-clock', 'simple_line_icons'); ?>
					</span>
                            <span class="mkd-events-single-meta-label"><?php esc_html_e('Time:', 'topfit'); ?></span>
					<span class="mkd-events-single-meta-value">
						<?php echo tribe_get_start_time(); ?> - <?php echo tribe_get_end_time(); ?>
					</span>
                        </div>

                        <?php if(tribe_has_venue()) : ?>
                        <div class="mkd-events-single-meta-item">
                            <span class="mkd-events-single-meta-icon">
                                <?php echo topfit_mikado_icon_collections()->renderIcon('lnr-apartment', 'linear_icons'); ?>
                            </span>
                            <span class="mkd-events-single-meta-label"><?php esc_html_e('Venue:', 'topfit'); ?></span>
                            <span class="mkd-events-single-meta-value">
                                <?php echo esc_html(tribe_get_venue()); ?>
                            </span>
                        </div>

                            <?php if(tribe_address_exists()) : ?>
                                <div class="mkd-events-single-meta-item">
							<span class="mkd-events-single-meta-icon">
								<?php echo topfit_mikado_icon_collections()->renderIcon('lnr-apartment', 'linear_icons'); ?>
							</span>
                                    <span class="mkd-events-single-meta-label"><?php esc_html_e('Address:', 'topfit'); ?></span>
							<span class="mkd-events-single-meta-value">
								<?php echo tribe_get_address(); ?>
							</span>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <div class="mkd-grid-col-6">
                        <?php if(tribe_has_organizer()) : ?>
                            <div class="mkd-events-single-meta-item">
						<span class="mkd-events-single-meta-icon">
							<?php echo topfit_mikado_icon_collections()->renderIcon('lnr-user', 'linear_icons'); ?>
						</span>
                                <span class="mkd-events-single-meta-label"><?php esc_html_e('Organizer Name:', 'topfit'); ?></span>
						<span class="mkd-events-single-meta-value">
							<?php echo esc_html(tribe_get_organizer()); ?>
						</span>
                            </div>
                        <?php endif; ?>

                        <?php if(tribe_get_organizer_phone()) : ?>
                            <div class="mkd-events-single-meta-item">
						<span class="mkd-events-single-meta-icon">
							<?php echo topfit_mikado_icon_collections()->renderIcon('lnr-phone-handset', 'linear_icons'); ?>
						</span>
                                <span class="mkd-events-single-meta-label"><?php esc_html_e('Phone:', 'topfit'); ?></span>
						<span class="mkd-events-single-meta-value">
							<?php echo esc_html(tribe_get_organizer_phone()); ?>
						</span>
                            </div>
                        <?php endif; ?>

                        <?php if(tribe_get_organizer_email()) : ?>
                            <div class="mkd-events-single-meta-item">
						<span class="mkd-events-single-meta-icon">
							<?php echo topfit_mikado_icon_collections()->renderIcon('lnr-bubble', 'linear_icons'); ?>
						</span>
                                <span class="mkd-events-single-meta-label"><?php esc_html_e('Email:', 'topfit'); ?></span>
						<span class="mkd-events-single-meta-value">
							<a href="mailto: <?php echo tribe_get_organizer_email(); ?>">
                                <?php echo esc_html(tribe_get_organizer_email()); ?>
                            </a>
						</span>
                            </div>
                        <?php endif; ?>

                        <?php if(tribe_get_organizer_website_link()) : ?>
                            <div class="mkd-events-single-meta-item">
						<span class="mkd-events-single-meta-icon">
							<?php echo topfit_mikado_icon_collections()->renderIcon('lnr-earth', 'linear_icons'); ?>
						</span>
                                <span class="mkd-events-single-meta-label"><?php esc_html_e('Website:', 'topfit'); ?></span>
						<span class="mkd-events-single-meta-value">
							<a target="_blank" href="<?php echo tribe_get_organizer_website_url(); ?>">
                                <?php echo tribe_get_organizer_website_url(); ?>
                            </a>
						</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

        <div class="mkd-events-single-meta">
            <?php do_action('tribe_events_single_event_before_the_meta') ?>

            <div class="mkd-events-single-navigation-holder clearfix">
                <div class="mkd-events-single-prev-event">
                    <?php tribe_the_prev_event_link('%title%'); ?>
                </div>

                <div class="mkd-events-single-next-event">
                    <?php tribe_the_next_event_link('%title%'); ?>
                </div>
            </div>

            <?php do_action('tribe_events_single_event_after_the_meta'); ?>
        </div>

        <div class="mkd-events-single-map">
            <?php tribe_get_template_part('modules/meta/map'); ?>
        </div>
        <?php do_action('tribe_events_single_event_after_the_content') ?>
    </div>

</div>
