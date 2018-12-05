<?php

if (!function_exists('topfit_mikado_portfolio_options_map')) {

	function topfit_mikado_portfolio_options_map() {

		topfit_mikado_add_admin_page(array(
			'slug'  => '_portfolio',
			'title' => esc_html__('Portfolio', 'topfit'),
			'icon'  => 'icon_images'
		));

		$panel = topfit_mikado_add_admin_panel(array(
			'title' => esc_html__('Portfolio Single', 'topfit'),
			'name'  => 'panel_portfolio_single',
			'page'  => '_portfolio'
		));

		topfit_mikado_add_admin_field(array(
			'name'          => 'portfolio_single_template',
			'type'          => 'select',
			'label'         => esc_html__('Portfolio Type', 'topfit'),
			'default_value' => 'small-images',
			'description'   => esc_html__('Choose a default type for Single Project pages', 'topfit'),
			'parent'        => $panel,
			'options'       => array(
				'small-images'      => esc_html__('Portfolio small images', 'topfit'),
				'small-slider'      => esc_html__('Portfolio small slider', 'topfit'),
				'big-images'        => esc_html__('Portfolio big images', 'topfit'),
				'big-slider'        => esc_html__('Portfolio big slider', 'topfit'),
				'custom'            => esc_html__('Portfolio custom', 'topfit'),
				'full-width-custom' => esc_html__('Portfolio full width custom', 'topfit'),
				'gallery'           => esc_html__('Portfolio gallery', 'topfit'),
				'video'             => esc_html__('Portfolio video', 'topfit'),
			)
		));

		topfit_mikado_add_admin_field(array(
			'name'          => 'portfolio_single_lightbox_images',
			'type'          => 'yesno',
			'label'         => esc_html__('Lightbox for Images', 'topfit'),
			'description'   => esc_html__('Enabling this option will turn on lightbox functionality for projects with images.', 'topfit'),
			'parent'        => $panel,
			'default_value' => 'yes'
		));

		topfit_mikado_add_admin_field(array(
			'name'          => 'portfolio_single_lightbox_videos',
			'type'          => 'yesno',
			'label'         => esc_html__('Lightbox for Videos', 'topfit'),
			'description'   => esc_html__('Enabling this option will turn on lightbox functionality for YouTube/Vimeo projects.', 'topfit'),
			'parent'        => $panel,
			'default_value' => 'no'
		));

		topfit_mikado_add_admin_field(array(
			'name'          => 'portfolio_single_hide_categories',
			'type'          => 'yesno',
			'label'         => esc_html__('Hide Categories', 'topfit'),
			'description'   => esc_html__('Enabling this option will disable category meta description on Single Projects.', 'topfit'),
			'parent'        => $panel,
			'default_value' => 'no'
		));

		topfit_mikado_add_admin_field(array(
			'name'          => 'portfolio_single_hide_date',
			'type'          => 'yesno',
			'label'         => esc_html__('Hide Date', 'topfit'),
			'description'   => esc_html__('Enabling this option will disable date meta on Single Projects.', 'topfit'),
			'parent'        => $panel,
			'default_value' => 'no'
		));

		topfit_mikado_add_admin_field(array(
			'name'          => 'portfolio_single_hide_author',
			'type'          => 'yesno',
			'label'         => esc_html__('Hide Author', 'topfit'),
			'description'   => esc_html__('Enabling this option will disable author meta on Single Projects.', 'topfit'),
			'parent'        => $panel,
			'default_value' => 'no'
		));

		topfit_mikado_add_admin_field(array(
			'name'          => 'portfolio_single_comments',
			'type'          => 'yesno',
			'label'         => esc_html__('Show Comments', 'topfit'),
			'description'   => esc_html__('Enabling this option will show comments on your page.', 'topfit'),
			'parent'        => $panel,
			'default_value' => 'no'
		));

		topfit_mikado_add_admin_field(array(
			'name'          => 'portfolio_single_sticky_sidebar',
			'type'          => 'yesno',
			'label'         => esc_html__('Sticky Side Text', 'topfit'),
			'description'   => esc_html__('Enabling this option will make side text sticky on Single Project pages', 'topfit'),
			'parent'        => $panel,
			'default_value' => 'yes'
		));

		topfit_mikado_add_admin_field(array(
			'name'          => 'portfolio_single_hide_pagination',
			'type'          => 'yesno',
			'label'         => esc_html__('Hide Pagination', 'topfit'),
			'description'   => esc_html__('Enabling this option will turn off portfolio pagination functionality.', 'topfit'),
			'parent'        => $panel,
			'default_value' => 'no',
			'args'          => array(
				'dependence'             => true,
				'dependence_hide_on_yes' => '#mkd_navigate_same_category_container'
			)
		));

		$container_navigate_category = topfit_mikado_add_admin_container(array(
			'name'            => 'navigate_same_category_container',
			'parent'          => $panel,
			'hidden_property' => 'portfolio_single_hide_pagination',
			'hidden_value'    => 'yes'
		));

		topfit_mikado_add_admin_field(array(
			'name'          => 'portfolio_single_nav_same_category',
			'type'          => 'yesno',
			'label'         => esc_html__('Enable Pagination Through Same Category', 'topfit'),
			'description'   => esc_html__('Enabling this option will make portfolio pagination sort through current category.', 'topfit'),
			'parent'        => $container_navigate_category,
			'default_value' => 'no'
		));

		topfit_mikado_add_admin_field(array(
			'name'          => 'portfolio_single_numb_columns',
			'type'          => 'select',
			'label'         => esc_html__('Number of Columns', 'topfit'),
			'default_value' => 'three-columns',
			'description'   => esc_html__('Enter the number of columns for Portfolio Gallery type', 'topfit'),
			'parent'        => $panel,
			'options'       => array(
				'two-columns'   => esc_html__('2 columns', 'topfit'),
				'three-columns' => esc_html__('3 columns', 'topfit'),
				'four-columns'  => esc_html__('4 columns', 'topfit'),
			)
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'portfolio_single_slug',
			'type'        => 'text',
			'label'       => esc_html__('Portfolio Single Slug', 'topfit'),
			'description' => esc_html__('Enter if you wish to use a different Single Project slug (Note: After entering slug, navigate to Settings -> Permalinks and click "Save" in order for changes to take effect)', 'topfit'),
			'parent'      => $panel,
			'args'        => array(
				'col_width' => 3
			)
		));

	}

	add_action('topfit_mikado_options_map', 'topfit_mikado_portfolio_options_map', 14);

}