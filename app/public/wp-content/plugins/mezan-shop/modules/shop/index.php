<?php

/**
 * Listings - Shop
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Shop_Listing_Shop' ) ) {

    class Mezan_Shop_Listing_Shop {

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

        }

        /*
        Load Modules
        */
            function load_modules() {

                /* Customizer */
                    include_once MEZAN_SHOP_PATH . 'modules/shop/customizer/index.php';

            }

    }

}


if( !function_exists('mezan_shop_listing_shop') ) {
	function mezan_shop_listing_shop() {
		return Mezan_Shop_Listing_Shop::instance();
	}
}

mezan_shop_listing_shop();