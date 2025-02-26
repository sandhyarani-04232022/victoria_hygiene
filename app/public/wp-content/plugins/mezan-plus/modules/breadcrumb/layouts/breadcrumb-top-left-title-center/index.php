<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MezanPlusBreadcrumbTLTC' ) ) {
    class MezanPlusBreadcrumbTLTC {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'mezan_plus_breadcrumb_layouts', array( $this, 'add_option' ) );
        }

        function add_option( $options ) {
            $options['breadcrumb-top-left-title-center'] = esc_html__('Top Left Title Center', 'mezan-plus');
            return $options;
        }
    }
}

MezanPlusBreadcrumbTLTC::instance();