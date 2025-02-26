<?php

/**
 * Listings - Shop
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Pro_Listing_Shop' ) ) {

    class Mezan_Pro_Listing_Shop {

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
                add_filter( 'loop_shop_per_page', array ( $this, 'woo_loop_shop_per_page' ), 5 );

            /* Filter Widget Area */
                add_action( 'widgets_init', array ( $this, 'register_shop_filters_widget_area' ) );

        }

        /*
        Load Modules
        */
            function load_modules() {

                /* Customizer */
                    include_once MEZAN_PRO_DIR_PATH.'modules/woocommerce/shop/customizer/index.php';

            }

        /*
        Loop Shop Per Page
        */
            function woo_loop_shop_per_page( $count ) {

                if( is_shop() ) {
                    $count = mezan_customizer_settings('wdt-woo-shop-page-product-per-page' );
                }

                return $count;

            }

        /*
        Shop Filters Widget Area
        */
            function register_shop_filters_widget_area() {

                $sidebars = array(
                    'name'          => esc_html__( 'Shop Filters', 'mezan-pro' ),
                    'id'            => 'mezan-shop-filters',
                    'description'   => esc_html__( 'This widget area will be used in Shop sorting area.', 'mezan-pro' ),
                    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h2 class="widgettitle">',
                    'after_title'   => '</h2>'
                );

                if( !empty( $sidebars ) ) {
                    register_sidebar( $sidebars );
                }

            }

    }

}


if( !function_exists('mezan_listing_shop') ) {
	function mezan_listing_shop() {
		return Mezan_Pro_Listing_Shop::instance();
	}
}

mezan_listing_shop();