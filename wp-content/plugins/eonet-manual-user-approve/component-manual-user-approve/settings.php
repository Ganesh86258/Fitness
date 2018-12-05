<?php
/**
 * Component settings, used in the Eonet admin pages
 */


use ComponentManualUserApprove\classes\Eonet_MUA_Message;

$settings = array(
	array(
		'name'      => 'mua_email_to_admin_enabled',
		'type'      => 'switch',
		'label'     => __('Send email to admin', 'eonet-manual-user-approve'),
		'desc'      => __('Send an email to the admin when a new user is waiting for approval', 'eonet-manual-user-approve'),
		'val'       => true
	),

	array(
		'name'      => 'mua_heading_messages',
		'type'      => 'heading',
		'label'     => __('Messages', 'eonet-manual-user-approve'),
	),
	array(
		'name'      => 'mua_welcome_message',
		'type'      => 'textarea',
		'label'     => __('Welcome Message', 'eonet-manual-user-approve'),
		'desc'      => __('Displayed on the registration page.', 'eonet-manual-user-approve'),
		'val'       => Eonet_MUA_Message::get_message_content('welcome_message')
	),
	array(
		'name'      => 'mua_registration_completed',
		'type'      => 'textarea',
		'label'     => __('Registration completed', 'eonet-manual-user-approve'),
		'desc'      => __('Displayed when the registration process has been completed.', 'eonet-manual-user-approve'),
		'val'       => Eonet_MUA_Message::get_message_content('registration_completed')
	),
	array(
		'name'      => 'mua_authentication_pending',
		'type'      => 'textarea',
		'label'     => __('Authentication Pending', 'eonet-manual-user-approve'),
		'desc'      => __('Displayed if an user tries to login but his account is still waiting for approval.', 'eonet-manual-user-approve'),
		'val'       => Eonet_MUA_Message::get_message_content('authentication_pending')
	),
	array(
		'name'      => 'mua_authentication_denied',
		'type'      => 'textarea',
		'label'     => __('Authentication Denied', 'eonet-manual-user-approve'),
		'desc'      => __('Displayed if an user tries to login but his account has been denied.', 'eonet-manual-user-approve'),
		'val'       => Eonet_MUA_Message::get_message_content('authentication_denied')
	),

	array(
		'name'      => 'mua_heading_emails',
		'type'      => 'heading',
		'label'     => __('Emails', 'eonet-manual-user-approve'),
	),

	array(
		'name'      => 'mua_email_subject_admin_alert',
		'type'      => 'text',
		'label'     => __('Email to admin (Subject)', 'eonet-manual-user-approve'),
		'desc'      => __('The subject of the email sent to the admin to alert him that a new user is waiting for approval.', 'eonet-manual-user-approve'),
		'val'       => Eonet_MUA_Message::get_message_content('email_subject_approval_request_to_admin')
	),
	array(
		'name'      => 'mua_email_body_admin_alert',
		'type'      => 'textarea',
		'label'     => __('Email to admin (Content)', 'eonet-manual-user-approve'),
		'desc'      => __('The content of the email sent to the admin to alert him that a new user is waiting for approval.', 'eonet-manual-user-approve'),
		'val'       => Eonet_MUA_Message::get_message_content('email_body_approval_request_to_admin', null, false)
	),

	array(
		'name'      => 'mua_email_subject_approved',
		'type'      => 'text',
		'label'     => __('Registration approved (Subject)', 'eonet-manual-user-approve'),
		'desc'      => __('The subject of the email sent to the user when his account is approved.', 'eonet-manual-user-approve'),
		'val'       => Eonet_MUA_Message::get_message_content('email_subject_account_has_been_approved')
	),
	array(
		'name'      => 'mua_email_body_approved',
		'type'      => 'textarea',
		'label'     => __('Registration approved (Content)', 'eonet-manual-user-approve'),
		'desc'      => __('The content of the email sent to the user when his account is approved.', 'eonet-manual-user-approve'),
		'val'       => Eonet_MUA_Message::get_message_content('email_body_account_has_been_approved', null, false)
	),

	array(
		'name'      => 'mua_email_subject_denied',
		'type'      => 'text',
		'label'     => __('Registration denied (Subject)', 'eonet-manual-user-approve'),
		'desc'      => __('The subject of the email sent to the user when his account is denied.', 'eonet-manual-user-approve'),
		'val'       => Eonet_MUA_Message::get_message_content('email_subject_account_has_been_denied')
	),
	array(
		'name'      => 'mua_email_body_denied',
		'type'      => 'textarea',
		'label'     => __('Registration denied (Content)', 'eonet-manual-user-approve'),
		'desc'      => __('The content of the email sent to the user when his account is denied.', 'eonet-manual-user-approve'),
		'val'       => Eonet_MUA_Message::get_message_content('email_body_account_has_been_denied', null, false)
	),

);