<?php do_action( 'bp_before_create_group_page' ); ?>

<div id="buddypress">

	<?php do_action( 'bp_before_create_group_content_template' ); ?>

	<form action="<?php bp_group_creation_form_action(); ?>" method="post" id="create-group-form" class="standard-form list" enctype="multipart/form-data">

		<?php do_action( 'bp_before_create_group' ); ?>

		<div class="item-list-tabs no-ajax" id="group-create-tabs" role="navigation">
			<ul>

				<?php bp_group_creation_tabs(); ?>

			</ul>
		</div>

		<?php do_action( 'template_notices' ); ?>

		<div class="item-body" id="group-create-body">

			<?php /* Group creation step 1: Basic group details */ ?>
			<?php if ( bp_is_group_creation_step( 'group-details' ) ) : ?>

				<?php do_action( 'bp_before_group_details_creation_step' ); ?>

					<label for="group-name" class="item item-input item-stacked-label">
						<span class="input-label"><?php _e( 'Group Name (required)', 'ap3-ion-theme' ); ?></span>

						<input type="text" name="group-name" id="group-name" aria-required="true" value="<?php bp_new_group_name(); ?>" />
					</label>

					<label for="group-desc"class="item item-input item-stacked-label">
						<span class="input-label"><?php _e( 'Group Description (required)', 'ap3-ion-theme' ); ?></span>
						<textarea name="group-desc" id="group-desc" aria-required="true"><?php bp_new_group_description(); ?></textarea>
					</label>

				<?php
				do_action( 'bp_after_group_details_creation_step' );
				do_action( 'groups_custom_group_fields_editable' ); // @Deprecated

				wp_nonce_field( 'groups_create_save_group-details' ); ?>

			<?php endif; ?>

			<?php /* Group creation step 2: Group settings */ ?>
			<?php if ( bp_is_group_creation_step( 'group-settings' ) ) : ?>

				<?php do_action( 'bp_before_group_settings_creation_step' ); ?>

				<h4><?php _e( 'Privacy Options', 'ap3-ion-theme' ); ?></h4>

				<div class="radio">
					<label><input type="radio" name="group-status" value="public"<?php if ( 'public' == bp_get_new_group_status() || !bp_get_new_group_status() ) { ?> checked="checked"<?php } ?> />
						<strong><?php _e( 'This is a public group', 'ap3-ion-theme' ); ?></strong>
						<ul>
							<li><?php _e( 'Any site member can join this group.', 'ap3-ion-theme' ); ?></li>
							<li><?php _e( 'This group will be listed in the groups directory and in search results.', 'ap3-ion-theme' ); ?></li>
							<li><?php _e( 'Group content and activity will be visible to any site member.', 'ap3-ion-theme' ); ?></li>
						</ul>
					</label>

					<label><input type="radio" name="group-status" value="private"<?php if ( 'private' == bp_get_new_group_status() ) { ?> checked="checked"<?php } ?> />
						<strong><?php _e( 'This is a private group', 'ap3-ion-theme' ); ?></strong>
						<ul>
							<li><?php _e( 'Only users who request membership and are accepted can join the group.', 'ap3-ion-theme' ); ?></li>
							<li><?php _e( 'This group will be listed in the groups directory and in search results.', 'ap3-ion-theme' ); ?></li>
							<li><?php _e( 'Group content and activity will only be visible to members of the group.', 'ap3-ion-theme' ); ?></li>
						</ul>
					</label>

					<label><input type="radio" name="group-status" value="hidden"<?php if ( 'hidden' == bp_get_new_group_status() ) { ?> checked="checked"<?php } ?> />
						<strong><?php _e('This is a hidden group', 'ap3-ion-theme' ); ?></strong>
						<ul>
							<li><?php _e( 'Only users who are invited can join the group.', 'ap3-ion-theme' ); ?></li>
							<li><?php _e( 'This group will not be listed in the groups directory or search results.', 'ap3-ion-theme' ); ?></li>
							<li><?php _e( 'Group content and activity will only be visible to members of the group.', 'ap3-ion-theme' ); ?></li>
						</ul>
					</label>
				</div>

				<h4><?php _e( 'Group Invitations', 'ap3-ion-theme' ); ?></h4>

				<p><?php _e( 'Which members of this group are allowed to invite others?', 'ap3-ion-theme' ); ?></p>

				<div class="radio">
					<label>
						<input type="radio" name="group-invite-status" value="members"<?php bp_group_show_invite_status_setting( 'members' ); ?> />
						<strong><?php _e( 'All group members', 'ap3-ion-theme' ); ?></strong>
					</label>

					<label>
						<input type="radio" name="group-invite-status" value="mods"<?php bp_group_show_invite_status_setting( 'mods' ); ?> />
						<strong><?php _e( 'Group admins and mods only', 'ap3-ion-theme' ); ?></strong>
					</label>

					<label>
						<input type="radio" name="group-invite-status" value="admins"<?php bp_group_show_invite_status_setting( 'admins' ); ?> />
						<strong><?php _e( 'Group admins only', 'ap3-ion-theme' ); ?></strong>
					</label>
				</div>

				<?php if ( bp_is_active( 'forums' ) ) : ?>

					<h4><?php _e( 'Group Forums', 'ap3-ion-theme' ); ?></h4>

					<?php if ( bp_forums_is_installed_correctly() ) : ?>

						<p><?php _e( 'Should this group have a forum?', 'ap3-ion-theme' ); ?></p>

						<div class="checkbox">
							<label><input type="checkbox" name="group-show-forum" id="group-show-forum" value="1"<?php checked( bp_get_new_group_enable_forum(), true, true ); ?> /> <?php _e( 'Enable discussion forum', 'ap3-ion-theme' ); ?></label>
						</div>
					<?php elseif ( is_super_admin() ) : ?>

						<p><?php printf( __( '<strong>Attention Site Admin:</strong> Group forums require the <a href="%s">correct setup and configuration</a> of a bbPress installation.', 'ap3-ion-theme' ), bp_core_do_network_admin() ? network_admin_url( 'settings.php?page=bb-forums-setup' ) :  admin_url( 'admin.php?page=bb-forums-setup' ) ); ?></p>

					<?php endif; ?>

				<?php endif; ?>

				<?php do_action( 'bp_after_group_settings_creation_step' ); ?>

				<?php wp_nonce_field( 'groups_create_save_group-settings' ); ?>

			<?php endif; ?>

			<?php /* Group creation step 3: Avatar Uploads */ ?>
			<?php if ( bp_is_group_creation_step( 'group-avatar' ) ) : ?>

				<?php do_action( 'bp_before_group_avatar_creation_step' ); ?>

				<?php if ( 'upload-image' == bp_get_avatar_admin_step() ) : ?>

					<div class="left-menu">

						<?php bp_new_group_avatar(); ?>

					</div><!-- .left-menu -->

					<div class="main-column">
						<p><?php _e( "Upload an image to use as an avatar for this group. The image will be shown on the main group page, and in search results.", 'ap3-ion-theme' ); ?></p>

						<p>
							<input type="file" name="file" id="file" />
							<input type="submit" name="upload" id="upload" value="<?php esc_attr_e( 'Upload Image', 'ap3-ion-theme' ); ?>" />
							<input type="hidden" name="action" id="action" value="bp_avatar_upload" />
						</p>

						<p><?php _e( 'To skip the avatar upload process, hit the "Next Step" button.', 'ap3-ion-theme' ); ?></p>
					</div><!-- .main-column -->

				<?php endif; ?>

				<?php if ( 'crop-image' == bp_get_avatar_admin_step() ) : ?>

					<h4><?php _e( 'Crop Group Avatar', 'ap3-ion-theme' ); ?></h4>

					<img src="<?php bp_avatar_to_crop(); ?>" id="avatar-to-crop" class="avatar" alt="<?php esc_attr_e( 'Avatar to crop', 'ap3-ion-theme' ); ?>" />

					<div id="avatar-crop-pane">
						<img src="<?php bp_avatar_to_crop(); ?>" id="avatar-crop-preview" class="avatar" alt="<?php esc_attr_e( 'Avatar preview', 'ap3-ion-theme' ); ?>" />
					</div>

					<input type="submit" name="avatar-crop-submit" id="avatar-crop-submit" value="<?php esc_attr_e( 'Crop Image', 'ap3-ion-theme' ); ?>" />

					<input type="hidden" name="image_src" id="image_src" value="<?php bp_avatar_to_crop_src(); ?>" />
					<input type="hidden" name="upload" id="upload" />
					<input type="hidden" id="x" name="x" />
					<input type="hidden" id="y" name="y" />
					<input type="hidden" id="w" name="w" />
					<input type="hidden" id="h" name="h" />

				<?php endif; ?>

				<?php do_action( 'bp_after_group_avatar_creation_step' ); ?>

				<?php wp_nonce_field( 'groups_create_save_group-avatar' ); ?>

			<?php endif; ?>

			<?php /* Group creation step 4: Cover image */ ?>
			<?php if ( bp_is_group_creation_step( 'group-cover-image' ) ) : ?>

				<?php

				/**
				 * Fires before the display of the group cover image creation step.
				 *
				 * @since 2.4.0
				 */
				do_action( 'bp_before_group_cover_image_creation_step' ); ?>

				<div id="header-cover-image"></div>

				<p><?php _e( 'The Cover Image will be used to customize the header of your group.', 'ap3-ion-theme' ); ?></p>

				<?php bp_attachments_get_template_part( 'cover-images/index' ); ?>

				<?php

				/**
				 * Fires after the display of the group cover image creation step.
				 *
				 * @since 2.4.0
				 */
				do_action( 'bp_after_group_cover_image_creation_step' ); ?>

				<?php wp_nonce_field( 'groups_create_save_group-cover-image' ); ?>

			<?php endif; ?>

			<?php /* Group creation step 5: Invite friends to group */ ?>
			<?php if ( bp_is_group_creation_step( 'group-invites' ) ) : ?>

				<?php do_action( 'bp_before_group_invites_creation_step' ); ?>

				<?php if ( bp_is_active( 'friends' ) && bp_get_total_friend_count( bp_loggedin_user_id() ) ) : ?>

					<div class="left-menu">

						<div id="invite-list">
							<ul>
								<?php bp_new_group_invite_friend_list(); ?>
							</ul>

							<?php wp_nonce_field( 'groups_invite_uninvite_user', '_wpnonce_invite_uninvite_user' ); ?>
						</div>

					</div><!-- .left-menu -->

					<div class="main-column">

						<div id="message" class="info">
							<p><?php _e('Select people to invite from your friends list.', 'ap3-ion-theme' ); ?></p>
						</div>

						<?php /* The ID 'friend-list' is important for AJAX support. */ ?>
						<ul id="friend-list" class="item-list" role="main">

						<?php if ( bp_group_has_invites() ) : ?>

							<?php while ( bp_group_invites() ) : bp_group_the_invite(); ?>

								<li id="<?php bp_group_invite_item_id(); ?>">

									<?php bp_group_invite_user_avatar(); ?>

									<h4><?php bp_group_invite_user_link(); ?></h4>
									<span class="activity"><?php bp_group_invite_user_last_active(); ?></span>

									<div class="action">
										<a class="remove" href="<?php bp_group_invite_user_remove_invite_url(); ?>" id="<?php bp_group_invite_item_id(); ?>"><?php _e( 'Remove Invite', 'ap3-ion-theme' ); ?></a>
									</div>
								</li>

							<?php endwhile; ?>

							<?php wp_nonce_field( 'groups_send_invites', '_wpnonce_send_invites' ); ?>

						<?php endif; ?>

						</ul>

					</div><!-- .main-column -->

				<?php else : ?>

					<div id="message" class="info">
						<p><?php _e( 'Once you have built up friend connections you will be able to invite others to your group.', 'ap3-ion-theme' ); ?></p>
					</div>

				<?php endif; ?>

				<?php wp_nonce_field( 'groups_create_save_group-invites' ); ?>

				<?php do_action( 'bp_after_group_invites_creation_step' ); ?>

			<?php endif; ?>

			<?php do_action( 'groups_custom_create_steps' ); // Allow plugins to add custom group creation steps ?>

			<?php do_action( 'bp_before_group_creation_step_buttons' ); ?>

			<?php if ( 'crop-image' != bp_get_avatar_admin_step() ) : ?>

				<div class="submit padding" id="previous-next">

					<?php /* Previous Button */ ?>
					<?php if ( !bp_is_first_group_creation_step() ) : ?>

						<input type="button" class="button button-primary" value="<?php esc_attr_e( 'Back to Previous Step', 'ap3-ion-theme' ); ?>" id="group-creation-previous" name="previous" onclick="location.href='<?php bp_group_creation_previous_link(); ?>'" />

					<?php endif; ?>

					<?php /* Next Button */ ?>
					<?php if ( !bp_is_last_group_creation_step() && !bp_is_first_group_creation_step() ) : ?>

						<input type="submit" class="button button-primary" value="<?php esc_attr_e( 'Next Step', 'ap3-ion-theme' ); ?>" id="group-creation-next" name="save" />

					<?php endif;?>

					<?php /* Create Button */ ?>
					<?php if ( bp_is_first_group_creation_step() ) : ?>

						<input type="submit" class="button button-primary" value="<?php esc_attr_e( 'Create Group and Continue', 'ap3-ion-theme' ); ?>" id="group-creation-create" name="save" />

					<?php endif; ?>

					<?php /* Finish Button */ ?>
					<?php if ( bp_is_last_group_creation_step() ) : ?>

						<input type="submit" class="button button-primary" value="<?php esc_attr_e( 'Finish', 'ap3-ion-theme' ); ?>" id="group-creation-finish" name="save" />

					<?php endif; ?>
				</div>

			<?php endif;?>

			<?php do_action( 'bp_after_group_creation_step_buttons' ); ?>

			<?php /* Don't leave out this hidden field */ ?>
			<input type="hidden" name="group_id" id="group_id" value="<?php bp_new_group_id(); ?>" />

			<?php do_action( 'bp_directory_groups_content' ); ?>

		</div><!-- .item-body -->

		<?php do_action( 'bp_after_create_group' ); ?>

	</form>

	<?php do_action( 'bp_after_create_group_content_template' ); ?>

</div>

<?php do_action( 'bp_after_create_group_page' ); ?>
