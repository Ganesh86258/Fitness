<?php

//top line
add_action('topfit_mikado_before_page_header', 'topfit_mikado_get_header_top_line');

//top header bar
add_action('topfit_mikado_before_page_header', 'topfit_mikado_get_header_top');

//mobile header
add_action('topfit_mikado_after_page_header', 'topfit_mikado_get_mobile_header');