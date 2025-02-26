<?php

# Elementor template list
if(!function_exists('mezan_elementor_page_list')) {
    function mezan_elementor_page_list(){
        $pagelist = get_posts(array(
            'post_type' => 'elementor_library',
            'showposts' => 999,
        ));

        $options[''] = esc_html__('None', 'mezan-shop');
        if ( ! empty( $pagelist ) && ! is_wp_error( $pagelist ) ){
            foreach ( $pagelist as $post ) {
                $options[ $post->ID ] = esc_html( $post->post_title );
            }
            return $options;
        }
    }
}