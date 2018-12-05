<div class="mkd-team-slide">
	<div class="mkd-team-slide-inner">
		<?php if ($team_member_image !== '') { ?>
			<div class="mkd-member-image">
				<?php echo wp_get_attachment_image($team_member_image, 'full'); ?>
			</div>
		<?php } ?>
		<div class="mkd-team-info">
			<div class="mkd-team-info-tb">
				<div class="mkd-team-info-tc">
					<?php if ($name !== '' || $position !== '') { ?>
						<div class="mkd-team-title-holder">
							<?php if ($name !== '') { ?>
								<h2 class="mkd-name"><?php echo esc_attr($name); ?></h2>
							<?php } ?>
							<?php if ($position !== "") { ?>
								<h5 class="mkd-position"><?php echo esc_attr($position) ?></h5>
							<?php } ?>
						</div>
					<?php } ?>
					<?php if ($text !== '') { ?>
						<div class="mkd-text">
							<?php echo esc_html($text); ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>