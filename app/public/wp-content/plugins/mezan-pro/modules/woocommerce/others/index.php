<?php

/**
 * WooCommerce - Others Class
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Pro_Others' ) ) {

    class Mezan_Pro_Others {

        private static $_instance = null;

        private $settings;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load Modules
                $this->load_modules();

        }

        /*
        Load Modules
        */
        function load_modules() {

            // Customizer
                include_once MEZAN_PRO_DIR_PATH . 'modules/woocommerce/others/customizer/index.php';

        }

    }

}

if( !function_exists('mezan_others') ) {
	function mezan_others() {
		return Mezan_Pro_Others::instance();
	}
}

mezan_others();