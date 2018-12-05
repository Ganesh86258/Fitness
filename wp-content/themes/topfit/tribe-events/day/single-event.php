<?php
/**
 * List View Single Event
 * This file contains one event in the list view
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */
if(!defined('ABSPATH')) {
    die('-1');
}

// Setup an array of venue details for use later in the template
$venue_details = tribe_get_venue_details();

// Venue
$has_venue_address = (!empty($venue_details['address'])) ? ' location' : '';

// Organizer
$organizer = tribe_get_organizer();

?>

<div class="mkd-events-list-item-holder mkd-grid-row">
    <div class="mkd-grid-col-6">
        <div class="mkd-events-list-item-image-holder">
            <a href="<?php echo esc_url(tribe_get_event_link()); ?>">
                <?php the_post_thumbnail('large'); ?>

                <div class="mkd-events-list-item-date-holder">
                    <div class="mkd-events-list-item-date-inner">
						<span class="mkd-events-list-item-date-day">
							<?php echo tribe_get_start_date(null, true, 'd'); ?>
						</span>

						<span class="mkd-events-list-item-date-month">
							<?php echo tribe_get_start_date(null, true, 'M'); ?>
						</span>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="mkd-grid-col-6">
        <div class="mkd-events-list-item-content">
            <div class="mkd-events-list-item-title-holder">

                <?php do_action('tribe_events_before_the_event_title') ?>

                <h2 class="mkd-events-list-item-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>

				<span class="mkd-events-list-item-price">
					<?php echo esc_html(tribe_get_cost(null, true)); ?>
				</span>

                <?php do_action('tribe_events_after_the_event_title') ?>
            </div>

            <?php do_action('tribe_events_before_the_meta') ?>

            <div class="mkd-events-list-item-meta">
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
                        <span class="mkd-events-single-meta-label"><?php esc_html_e('Venue', 'topfit'); ?></span>
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

            <?php do_action('tribe_events_after_the_meta') ?>

            <?php if(tribe_events_get_the_excerpt()) : ?>

                <?php do_action('tribe_events_before_the_content') ?>

                <div class="mkd-events-list-item-excerpt">
                    <?php echo tribe_events_get_the_excerpt(); ?>
                </div>

                <?php do_action('tribe_events_after_the_content'); ?>

            <?php endif; ?>
        </div>
    </div>
</div>