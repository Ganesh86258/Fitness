<div <?php post_class($item_class); ?>>
    <div class="mkd-events-list-item-holder">
        <?php if(has_post_thumbnail()) : ?>
            <div class="mkd-events-list-item-image-holder">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail($image_size); ?>

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
        <?php endif; ?>
        <div class="mkd-events-list-item-content">
            <div class="mkd-events-list-item-title-holder">
                <h5 class="mkd-events-list-item-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h5>
				<span class="mkd-events-list-item-price">
					<?php echo esc_html(tribe_get_cost(null, true)); ?>
				</span>
            </div>
            <div class="mkd-events-list-item-info">
                <div class="mkd-events-list-item-date">
					<span class="mkd-events-item-info-icon">
						<?php echo topfit_mikado_icon_collections()->renderIcon('icon-clock', 'simple_line_icons'); ?>
					</span>
                    <?php echo tribe_events_event_schedule_details(); ?>
                </div>
                <div class="mkd-events-list-item-location-holdere">
					<span class="mkd-events-item-info-icon">
						<?php echo topfit_mikado_icon_collections()->renderIcon('icon-location-pin', 'simple_line_icons'); ?>
					</span>
                    <span class="qpdef-events-list-item-location"><?php echo esc_html(tribe_get_address()); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>