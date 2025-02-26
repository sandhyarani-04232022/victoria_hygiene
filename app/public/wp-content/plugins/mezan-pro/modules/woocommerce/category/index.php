<?php

/**
 * Listings - Category
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Pro_Listing_Category' ) ) {

    class Mezan_Pro_Listing_Category {

        private static $_instance = null;

        private $settings;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            /* Load Modules */
                $this->load_modules();

            /* Loop Shop Per Page */
                add_filter( 'loop_shop_per_page', array ( $this, 'woo_loop_shop_per_page' ) );

        }

        /*
        Load Modules
        */
            function load_modules() {

                /* Customizer */
                    include_once MEZAN_PRO_DIR_PATH.'modules/woocommerce/category/customizer/index.php';

            }

        /*
        Loop Shop Per Page
        */
            function woo_loop_shop_per_page( $count ) {

                if( is_product_category() ) {
                    $count = mezan_customizer_settings('wdt-woo-category-page-product-per-page' );
                }

                return $count;

            }

    }

}


if( !function_exists('mezan_listing_category') ) {
	function mezan_listing_category() {
		return Mezan_Pro_Listing_Category::instance();
	}
}

mezan_listing_category();