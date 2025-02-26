<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MezanPlusSiteWideLayout' ) ) {
    class MezanPlusSiteWideLayout {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'mezan_site_layouts', array( $this, 'add_wide_layout_option' ) );

        }

        function add_wide_layout_option( $options ) {
            $options['layout-wide'] = esc_html__('Wide', 'mezan-plus');
            return $options;
        }
    }
}

MezanPlusSiteWideLayout::instance();