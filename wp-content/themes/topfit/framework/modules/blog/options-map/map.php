<?php

if (!function_exists('topfit_mikado_blog_options_map')) {

	function topfit_mikado_blog_options_map() {

		topfit_mikado_add_admin_page(
			array(
				'slug'  => '_blog_page',
				'title' => esc_html__('Blog','topfit'),
				'icon'  => 'icon_book_alt'
			)
		);

		/**
		 * Blog Lists
		 */

		$custom_sidebars = topfit_mikado_get_custom_sidebars();

		$panel_blog_lists = topfit_mikado_add_admin_panel(
			array(
				'page'  => '_blog_page',
				'name'  => 'panel_blog_lists',
				'title' => esc_html__('Blog Lists','topfit'),
			)
		);

		topfit_mikado_add_admin_field(array(
			'name'          => 'blog_list_type',
			'type'          => 'select',
			'label'         => esc_html__('Blog Layout for Archive Pages','topfit'),
			'description'   => esc_html__('Choose a default blog layout','topfit'),
			'default_value' => 'standard',
			'parent'        => $panel_blog_lists,
			'options'       => array(
				'standard'           => esc_html__('Blog: Standard','topfit'),
				'masonry'            => esc_html__('Blog: Masonry','topfit'),
				'masonry-full-width' => esc_html__('Blog: Masonry Full Width','topfit'),
			)
		));

		topfit_mikado_add_admin_field(array(
			'name'        => 'archive_sidebar_layout',
			'type'        => 'select',
			'label'       => esc_html__('Archive and Category Sidebar','topfit'),
			'description' => esc_html__('Choose a sidebar layout for archived Blog Post Lists and Category Blog Lists','topfit'),
			'parent'      => $panel_blog_lists,
			'options'     => array(
				'default'          => esc_html__('No Sidebar','topfit'),
				'sidebar-33-right' => esc_html__('Sidebar 1/3 Right','topfit'),
				'sidebar-25-right' => esc_html__('Sidebar 1/4 Right','topfit'),
				'sidebar-33-left'  => esc_html__('Sidebar 1/3 Left','topfit'),
				'sidebar-25-left'  => esc_html__('Sidebar 1/4 Left','topfit'),
			)
		));

		topfit_mikado_add_admin_field(array(
			'name'          => 'archive_boxed_widgets',
			'type'          => 'yesno',
			'default_value' => 'no',
			'label'         => esc_html__('Boxed Widgets','topfit'),
			'parent'        => $panel_blog_lists
		));


		if (count($custom_sidebars) > 0) {
			topfit_mikado_add_admin_field(array(
				'name'        => 'blog_custom_sidebar',
				'type'        => 'selectblank',
				'label'       => esc_html__('Sidebar to Display','topfit'),
				'description' => esc_html__('Choose a sidebar to display on Blog Post Lists and Category Blog Lists. Default sidebar is "Sidebar Page"','topfit'),
				'parent'      => $panel_blog_lists,
				'options'     => topfit_mikado_get_custom_sidebars()
			));
		}

		topfit_mikado_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'pagination',
				'default_value' => 'yes',
				'label'         => esc_html__('Pagination','topfit'),
				'parent'        => $panel_blog_lists,
				'description'   => esc_html__('Enabling this option will display pagination links on bottom of Blog Post List','topfit'),
				'args'          => array(
					'dependence'             => true,
					'dependence_hide_on_yes' => '',
					'dependence_show_on_yes' => '#mkd_mkd_pagination_container'
				)
			)
		);

		$pagination_container = topfit_mikado_add_admin_container(
			array(
				'name'            => 'mkd_pagination_container',
				'hidden_property' => 'pagination',
				'hidden_value'    => 'no',
				'parent'          => $panel_blog_lists,
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'parent'        => $pagination_container,
				'type'          => 'text',
				'name'          => 'blog_page_range',
				'default_value' => '',
				'label'         => esc_html__('Pagination Range limit','topfit'),
				'description'   => esc_html__('Enter a number that will limit pagination to a certain range of links','topfit'),
				'args'          => array(
					'col_width' => 3
				)
			)
		);

		topfit_mikado_add_admin_field(array(
			'name'          => 'blog_list_pagination',
			'type'          => 'select',
			'label'         => esc_html__('Pagination type','topfit'),
			'description'   => esc_html__('Choose pagination for Blog lists','topfit'),
			'parent'        => $pagination_container,
			'options'       => array(
				'standard'        => esc_html__('Standard','topfit'),
				'load_more'       => esc_html__('Load More','topfit'),
				'infinite_scroll' => esc_html__('Infinite scroll','topfit'),
			),
			'default_value' => 'standard'
		));

		topfit_mikado_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'masonry_filter',
				'default_value' => 'no',
				'label'         => esc_html__('Masonry Filter','topfit'),
				'parent'        => $panel_blog_lists,
				'description'   => esc_html__('Enabling this option will display category filter on Masonry and Masonry Full Width Templates','topfit'),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		topfit_mikado_add_admin_field(
			array(
				'type'          => 'text',
				'name'          => 'number_of_chars',
				'default_value' => '',
				'label'         => esc_html__('Number of Words in Excerpt','topfit'),
				'parent'        => $panel_blog_lists,
				'description'   => esc_html__('Enter a number of words in excerpt (article summary)','topfit'),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		topfit_mikado_add_admin_field(
			array(
				'type'          => 'text',
				'name'          => 'standard_number_of_chars',
				'default_value' => '45',
				'label'         => esc_html__('Standard Type Number of Words in Excerpt','topfit'),
				'parent'        => $panel_blog_lists,
				'description'   => esc_html__('Enter a number of words in excerpt (article summary)','topfit'),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		topfit_mikado_add_admin_field(
			array(
				'type'          => 'text',
				'name'          => 'masonry_number_of_chars',
				'default_value' => '45',
				'label'         => esc_html__('Masonry Type Number of Words in Excerpt','topfit'),
				'parent'        => $panel_blog_lists,
				'description'   => esc_html__('Enter a number of words in excerpt (article summary)','topfit'),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		topfit_mikado_add_admin_field(
			array(
				'type'          => 'text',
				'name'          => 'split_number_of_chars',
				'default_value' => '45',
				'label'         => esc_html__('Split Type Number of Words in Excerpt','topfit'),
				'parent'        => $panel_blog_lists,
				'description'   => esc_html__('Enter a number of words in excerpt (article summary)','topfit'),
				'args'          => array(
					'col_width' => 3
				)
			)
		);

		/**
		 * Blog Single
		 */
		$panel_blog_single = topfit_mikado_add_admin_panel(
			array(
				'page'  => '_blog_page',
				'name'  => 'panel_blog_single',
				'title' => esc_html__('Blog Single','topfit'),
			)
		);

		topfit_mikado_add_admin_field(array(
			'name'          => 'blog_single_type',
			'type'          => 'select',
			'label'         => esc_html__('Blog Single Type','topfit'),
			'description'   => esc_html__('Choose a layout type for Blog Single pages','topfit'),
			'parent'        => $panel_blog_single,
			'options'       => array(
				'standard'    => esc_html__('Standard','topfit'),
				'image-title' => esc_html__('Image Title','topfit')
			),
			'default_value' => 'standard'
		));

		topfit_mikado_add_admin_field(array(
			'name'          => 'blog_single_sidebar_layout',
			'type'          => 'select',
			'label'         => esc_html__('Sidebar Layout','topfit'),
			'description'   => esc_html__('Choose a sidebar layout for Blog Single pages','topfit'),
			'parent'        => $panel_blog_single,
			'options'       => array(
				'default'          => esc_html__('No Sidebar','topfit'),
				'sidebar-33-right' => esc_html__('Sidebar 1/3 Right','topfit'),
				'sidebar-25-right' => esc_html__('Sidebar 1/4 Right','topfit'),
				'sidebar-33-left'  => esc_html__('Sidebar 1/3 Left','topfit'),
				'sidebar-25-left'  => esc_html__('Sidebar 1/4 Left','topfit'),
			),
			'default_value' => 'default'
		));

		topfit_mikado_add_admin_field(array(
			'name'          => 'blog_single_boxed_widgets',
			'type'          => 'yesno',
			'default_value' => 'no',
			'label'         => esc_html__('Boxed Widgets','topfit'),
			'parent'        => $panel_blog_single
		));

		if (count($custom_sidebars) > 0) {
			topfit_mikado_add_admin_field(array(
				'name'        => 'blog_single_custom_sidebar',
				'type'        => 'selectblank',
				'label'       => esc_html__('Sidebar to Display','topfit'),
				'description' => esc_html__('Choose a sidebar to display on Blog Single pages. Default sidebar is "Sidebar"','topfit'),
				'parent'      => $panel_blog_single,
				'options'     => topfit_mikado_get_custom_sidebars()
			));
		}

		topfit_mikado_add_admin_field(array(
			'name'          => 'blog_single_title_in_title_area',
			'type'          => 'yesno',
			'label'         => esc_html__('Show Post Title in Title Area','topfit'),
			'description'   => esc_html__('Enabling this option will show post title in title area on single post pages','topfit'),
			'parent'        => $panel_blog_single,
			'default_value' => 'no'
		));

		topfit_mikado_add_admin_field(array(
			'name'          => 'blog_single_comments',
			'type'          => 'yesno',
			'label'         => esc_html__('Show Comments','topfit'),
			'description'   => esc_html__('Enabling this option will show comments on your page.','topfit'),
			'parent'        => $panel_blog_single,
			'default_value' => 'yes'
		));

		topfit_mikado_add_admin_field(array(
			'name'          => 'blog_single_related_posts',
			'type'          => 'yesno',
			'label'         => esc_html__('Show Related Posts','topfit'),
			'description'   => esc_html__('Enabling this option will show related posts on your single post.','topfit'),
			'parent'        => $panel_blog_single,
			'default_value' => 'no'
		));

		topfit_mikado_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'blog_single_navigation',
				'default_value' => 'no',
				'label'         => esc_html__('Enable Prev/Next Single Post Navigation Links','topfit'),
				'parent'        => $panel_blog_single,
				'description'   => esc_html__('Enable navigation links through the blog posts (left and right arrows will appear)','topfit'),
				'args'          => array(
					'dependence'             => true,
					'dependence_hide_on_yes' => '',
					'dependence_show_on_yes' => '#mkd_mkd_blog_single_navigation_container'
				)
			)
		);

		$blog_single_navigation_container = topfit_mikado_add_admin_container(
			array(
				'name'            => 'mkd_blog_single_navigation_container',
				'hidden_property' => 'blog_single_navigation',
				'hidden_value'    => 'no',
				'parent'          => $panel_blog_single,
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'blog_navigation_through_same_category',
				'default_value' => 'no',
				'label'         => esc_html__('Enable Navigation Only in Current Category','topfit'),
				'description'   => esc_html__('Limit your navigation only through current category','topfit'),
				'parent'        => $blog_single_navigation_container,
				'args'          => array(
					'col_width' => 3
				)
			)
		);

		topfit_mikado_add_admin_field(array(
			'type'          => 'yesno',
			'name'          => 'blog_enable_single_tags',
			'default_value' => 'yes',
			'label'         => esc_html__('Enable Tags on Single Post','topfit'),
			'description'   => esc_html__('Enabling this option will display posts\s tags on single post page','topfit'),
			'parent'        => $panel_blog_single
		));


		topfit_mikado_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'blog_author_info',
				'default_value' => 'no',
				'label'         => esc_html__('Show Author Info Box','topfit'),
				'parent'        => $panel_blog_single,
				'description'   => esc_html__('Enabling this option will display author name and descriptions on Blog Single pages','topfit'),
				'args'          => array(
					'dependence'             => true,
					'dependence_hide_on_yes' => '',
					'dependence_show_on_yes' => '#mkd_mkd_blog_single_author_info_container'
				)
			)
		);

		$blog_single_author_info_container = topfit_mikado_add_admin_container(
			array(
				'name'            => 'mkd_blog_single_author_info_container',
				'hidden_property' => 'blog_author_info',
				'hidden_value'    => 'no',
				'parent'          => $panel_blog_single,
			)
		);

		topfit_mikado_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'blog_author_info_email',
				'default_value' => 'no',
				'label'         => esc_html__('Show Author Email','topfit'),
				'description'   => esc_html__('Enabling this option will show author email','topfit'),
				'parent'        => $blog_single_author_info_container,
				'args'          => array(
					'col_width' => 3
				)
			)
		);

	}

	add_action('topfit_mikado_options_map', 'topfit_mikado_blog_options_map', 12);

}











