<?php

//Testimonials

if (!function_exists('topfit_mikado_testimonial_meta_box_map')) {
	function topfit_mikado_testimonial_meta_box_map() {

		$testimonial_meta_box = topfit_mikado_add_meta_box(
			array(
				'scope' => array('testimonials'),
				'title' => esc_html__('Testimonial', 'topfit'),
				'name'  => 'testimonial_meta'
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_testimonaial_logo_image',
				'type'        => 'image',
				'label'       => esc_html__('Logo Image', 'topfit'),
				'description' => esc_html__('Choose testimonial logo image ', 'topfit'),
				'parent'      => $testimonial_meta_box
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_testimonial_title',
				'type'        => 'text',
				'label'       => esc_html__('Title', 'topfit'),
				'description' => esc_html__('Enter testimonial title', 'topfit'),
				'parent'      => $testimonial_meta_box,
			)
		);


		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_testimonial_author',
				'type'        => 'text',
				'label'       => esc_html__('Author', 'topfit'),
				'description' => esc_html__('Enter author name', 'topfit'),
				'parent'      => $testimonial_meta_box,
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_testimonial_author_position',
				'type'        => 'text',
				'label'       => esc_html__('Job Position', 'topfit'),
				'description' => esc_html__('Enter job position', 'topfit'),
				'parent'      => $testimonial_meta_box,
			)
		);

		topfit_mikado_add_meta_box_field(
			array(
				'name'        => 'mkd_testimonial_text',
				'type'        => 'text',
				'label'       => esc_html__('Text', 'topfit'),
				'description' => esc_html__('Enter testimonial text', 'topfit'),
				'parent'      => $testimonial_meta_box,
			)
		);
	}
	add_action('topfit_mikado_meta_boxes_map', 'topfit_mikado_testimonial_meta_box_map');
}