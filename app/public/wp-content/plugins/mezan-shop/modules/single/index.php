<?php

/**
 * WooCommerce - Single Core Class
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Shop_Single' ) ) {

    class Mezan_Shop_Single {

        private static $_instance = null;

        private $settings;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load WooCommerce Comments Template
                add_filter( 'comments_template',  array( $this, 'mezan_shop_comments_template' ), 20, 1 );

            // Load Modules
                $this->load_modules();

        }

        /**
         * Override WooCommerce comments template file
         */
            function mezan_shop_comments_template( $template ) {

                if ( get_post_type() !== 'product' ) {
                    return $template;
                }

                $plugin_path  = MEZAN_SHOP_PATH . 'templates/';

                if ( file_exists( $plugin_path . 'single-product-reviews.php' ) ) {
                    return $plugin_path . 'single-product-reviews.php';
                }

                return $template;

            }

        /*
        Load Modules
        */

            function load_modules() {

                // Customizer Widgets
                    include_once MEZAN_SHOP_PATH . 'modules/single/customizer/index.php';

                // Metabox Widgets
                    include_once MEZAN_SHOP_PATH . 'modules/single/metabox/index.php';

            }

    }

}

if( !function_exists('mezan_shop_single') ) {
	function mezan_shop_single() {
		return Mezan_Shop_Single::instance();
	}
}

mezan_shop_single();