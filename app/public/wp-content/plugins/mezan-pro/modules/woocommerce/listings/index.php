<?php

/**
 * Listing
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Pro_Listing' ) ) {

    class Mezan_Pro_Listing {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            /* Update Options Location Path Array */
                add_filter( 'mezan_woo_option_locations', array( $this, 'option_locations_update'), 10, 1 );

            /* Update Types Location Path Array */
                add_filter( 'mezan_woo_type_locations', array( $this, 'type_locations_update'), 10, 1 );

            /* Load Modules */
                $this->load_modules();

        }

        /*
        Options Location Path Update
        */

            function option_locations_update( $paths ) {

                array_push( $paths, MEZAN_PRO_DIR_PATH . 'modules/woocommerce/listings/options/*/index.php' );

                return $paths;

            }

        /*
        Types Location Path Update
        */

            function type_locations_update( $paths ) {

                array_push( $paths, MEZAN_PRO_DIR_PATH . 'modules/woocommerce/listings/types/*/index.php' );

                return $paths;

            }

        /*
        Load Modules
        */

            function load_modules() {

                // Elementor Widgets
                    include_once MEZAN_PRO_DIR_PATH . 'modules/woocommerce/listings/elementor/index.php';

                // Sidebar
                    include_once MEZAN_PRO_DIR_PATH . 'modules/woocommerce/listings/sidebar/index.php';

            }

    }

}

if( !function_exists('mezan_listing') ) {
	function mezan_listing() {
		return Mezan_Pro_Listing::instance();
	}
}

mezan_listing();