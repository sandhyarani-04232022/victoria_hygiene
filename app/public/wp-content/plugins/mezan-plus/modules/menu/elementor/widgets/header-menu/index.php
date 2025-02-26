<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MezanPlusHeaderMenuWidget' ) ) {
    class MezanPlusHeaderMenuWidget {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
        }

        function register_widgets( $widgets_manager ) {
            require MEZAN_PLUS_DIR_PATH. 'modules/menu/elementor/widgets/header-menu/class-widget-header-menu.php';
            $widgets_manager->register( new \Elementor_Header_Menu() );
        }
    }
}

MezanPlusHeaderMenuWidget::instance();