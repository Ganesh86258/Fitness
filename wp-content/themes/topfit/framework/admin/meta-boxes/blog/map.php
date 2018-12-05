<?php
if (!function_exists('topfit_mikado_blog_meta_box_map')) {
	function topfit_mikado_blog_meta_box_map() {

		$mkd_blog_categories = array();
		$categories = get_categories();
		foreach ($categories as $category) {
			$mkd_blog_categories[$category->term_id] = $category->name;
		}

		$blog_meta_box = topfit_mikado_add_meta_box(
			array(
				'scope' => array('page'),
				'title' => esc_html__('Blog', 'topfit'),
				'name'  => 'blog_meta'
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_blog_category_meta',
				'type'        => 'selectblank',
				'label'       => esc_html__('Blog Category', 'topfit'),
				'description' => esc_html__('Choose category of posts to display (leave empty to display all categories)', 'topfit'),
				'parent'      => $blog_meta_box,
				'options'     => $mkd_blog_categories
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_show_posts_per_page_meta',
				'type'        => 'text',
				'label'       => esc_html__('Number of Posts', 'topfit'),
				'description' => esc_html__('Enter the number of posts to display', 'topfit'),
				'parent'      => $blog_meta_box,
				'options'     => $mkd_blog_categories,
				'args'        => array("col_width" => 3)
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_blog_split_background_image_meta',
				'type'        => 'image',
				'label'       => esc_html__('Blog Split Background Image', 'topfit'),
				'description' => esc_html__('Set background image if Blog Split page template is selected', 'topfit'),
				'parent'      => $blog_meta_box,
				'options'     => $mkd_blog_categories,
				'args'        => array("col_width" => 3)
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_blog_split_title_meta',
				'type'        => 'text',
				'label'       => esc_html__('Blog Split Title', 'topfit'),
				'description' => esc_html__('Set title if Blog Split page template is selected', 'topfit'),
				'parent'      => $blog_meta_box,
				'options'     => $mkd_blog_categories,
				'args'        => array("col_width" => 12)
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_blog_split_subtitle_meta',
				'type'        => 'text',
				'label'       => esc_html__('Blog Split Subtitle', 'topfit'),
				'description' => esc_html__('Set subtitle if Blog Split page template is selected', 'topfit'),
				'parent'      => $blog_meta_box,
				'options'     => $mkd_blog_categories,
				'args'        => array("col_width" => 12)
			)
		);

	}
	add_action('topfit_mikado_meta_boxes_map', 'topfit_mikado_blog_meta_box_map');
}