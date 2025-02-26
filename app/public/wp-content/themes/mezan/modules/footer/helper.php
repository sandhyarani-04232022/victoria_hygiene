<?php
add_action( 'mezan_after_main_css', 'footer_style' );
function footer_style() {
    wp_enqueue_style( 'mezan-footer', get_theme_file_uri('/modules/footer/assets/css/footer.css'), false, MEZAN_THEME_VERSION, 'all');
}

add_action( 'mezan_footer', 'footer_content' );
function footer_content() {
    mezan_template_part( 'content', 'content', 'footer' );
}