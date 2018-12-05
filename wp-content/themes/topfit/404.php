<?php get_header(); ?>

<div class="mkd-container"
	 style="background-image:url(<?php echo esc_url(get_template_directory_uri() . '/assets/css/img/404-background.png') ?>)">
	<?php do_action('topfit_mikado_after_container_open'); ?>
	<div class="mkd-container-inner mkd-404-page">
		<div class="mkd-page-not-found">
			<h2>
				<?php if (topfit_mikado_options()->getOptionValue('404_title')) {
					echo esc_html(topfit_mikado_options()->getOptionValue('404_title'));
				} else {
					esc_html_e('PAGE NOT FOUND', 'topfit');
				} ?>
			</h2>

			<p>
				<?php if (topfit_mikado_options()->getOptionValue('404_text')) {
					echo esc_html(topfit_mikado_options()->getOptionValue('404_text'));
				} else {
					esc_html_e('The page requested couldn\'t be found. This could be a spelling error in the URL or a removed page.', 'topfit');
				} ?>
			</p>
			<?php
			if(topfit_mikado_core_installed()) {
                $params = array();
                if (topfit_mikado_options()->getOptionValue('404_back_to_home')) {
                    $params['text'] = topfit_mikado_options()->getOptionValue('404_back_to_home');
                } else {
                    $params['text'] = esc_html__('Back to Homepage', 'topfit');
                }

                $params['link'] = esc_url(home_url('/'));
                $params['target'] = '_self';
				$params['hover_type'] = 'solid';
                $params['hover_color'] = '#fff';
				$params['hover_border_color'] = 'transparent';
                echo topfit_mikado_execute_shortcode('mkd_button', $params);
            }?>
		</div>
	</div>
	<?php do_action('topfit_mikado_before_container_close'); ?>
</div>

<?php wp_footer(); ?>
