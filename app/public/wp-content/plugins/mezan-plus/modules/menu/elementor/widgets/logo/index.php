<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MezanPlusLogoWidget' ) ) {
    class MezanPlusLogoWidget {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
            add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_widget_styles' ) );
            add_action( 'elementor/preview/enqueue_styles', array( $this, 'register_preview_styles') );
        }

        function register_widgets( $widgets_manager ) {
            require MEZAN_PLUS_DIR_PATH. 'modules/menu/elementor/widgets/logo/class-widget-logo.php';
            $widgets_manager->register( new \Elementor_logo() );
        }

        function register_widget_styles() {
            wp_register_style( 'wdt-logo',
                MEZAN_PLUS_DIR_URL . 'modules/menu/elementor/widgets/assets/css/logo.css', array(), MEZAN_PLUS_VERSION );
        }

        function register_preview_styles() {
            wp_enqueue_style( 'wdt-logo' );
        }
    }
}

MezanPlusLogoWidget::instance();