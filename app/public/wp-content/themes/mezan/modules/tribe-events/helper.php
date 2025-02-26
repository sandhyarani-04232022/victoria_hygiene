<?php

if( ! function_exists('mezan_event_breadcrumb_title') ) {
    function mezan_event_breadcrumb_title($title) {
        if( get_post_type() == 'tribe_events' && is_single()) {
            $etitle = esc_html__( 'Event Detail', 'mezan' );
            return '<h1>'.$etitle.'</h1>';
        } else {
            return $title;
        }
    }

    add_filter( 'mezan_breadcrumb_title', 'mezan_event_breadcrumb_title', 20, 1 );
}

?>