<?php

if( !function_exists('mezan_pro_get_template_plugin_part') ) {
    function mezan_pro_get_template_plugin_part( $file_path, $module, $template, $slug ) {

        $html             = '';
        $template_path    = MEZAN_PRO_DIR_PATH . 'modules/' . esc_attr($module);
        $temp_path        = $template_path . '/' . esc_attr($template);
        $plugin_file_path = '';

        if ( ! empty( $temp_path ) ) {
            if ( ! empty( $slug ) ) {
                $plugin_file_path = "{$temp_path}-{$slug}.php";
                if ( ! file_exists( $plugin_file_path ) ) {
                    $plugin_file_path = $temp_path . '.php';
                }
            } else {
                $plugin_file_path = $temp_path . '.php';
            }
        }

        if ( $plugin_file_path && file_exists( $plugin_file_path ) ) {
            return $plugin_file_path;
        }

        return $file_path;

    }
    add_filter( 'mezan_get_template_plugin_part', 'mezan_pro_get_template_plugin_part', 20, 4 );
}

if( !function_exists('mezan_pro_before_after_widget') ) {
    function mezan_pro_before_after_widget ( $content ) {
        $allowed_html = array(
            'aside' => array(
                'id'    => array(),
                'class' => array()
            ),
            'div' => array(
                'id'    => array(),
                'class' => array(),
            )
        );

        $data = wp_kses( $content, $allowed_html );

        return $data;
    }
}

if( !function_exists('mezan_pro_widget_title') ) {
    function mezan_pro_widget_title( $content ) {

        $allowed_html = array(
            'div' => array(
                'id'    => array(),
                'class' => array()
            ),
            'h2' => array(
                'class' => array()
            ),
            'h3' => array(
                'class' => array()
            ),
            'h4' => array(
                'class' => array()
            ),
            'h5' => array(
                'class' => array()
            ),
            'h6' => array(
                'class' => array()
            ),
            'span' => array(
                'id'    => array(),
                'class' => array()
            ),
            'p' => array(
                'id'    => array(),
                'class' => array()
            ),
        );

        $data = wp_kses( $content, $allowed_html );

        return $data;
    }
}

if( !function_exists('mezan_custom_post_type_elementor_support') ) {
    function mezan_custom_post_type_elementor_support() {
        $custom_post_types = array('wdt_headers', 'wdt_footers');
        $elementor_supported_post_types = get_option('elementor_cpt_support', array('page', 'post'));
        $supported_post_types = array_merge($elementor_supported_post_types, $custom_post_types);
        $supported_post_types = array_unique($supported_post_types);
        update_option('elementor_cpt_support', $supported_post_types);
    }
}
add_action('init', 'mezan_custom_post_type_elementor_support');

# Filter HTML Output
if(!function_exists('mezan_html_output')) {
	function mezan_html_output( $html ) {
		return apply_filters( 'mezan_html_output', $html );
	}
}