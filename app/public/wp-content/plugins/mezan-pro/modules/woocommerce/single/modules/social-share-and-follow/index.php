<?php

/**
 * WooCommerce - Single - Module - Social Share And Follow
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Shop_Single_Module_Social_Share_And_Follow' ) ) {

    class Mezan_Shop_Single_Module_Social_Share_And_Follow {

        private static $_instance = null;

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
        Module Paths
        */

            function module_dir_path() {

                if( mezan_is_file_in_theme( __FILE__ ) ) {
                    return MEZAN_MODULE_DIR . '/woocommerce/single/modules/social-share-and-follow/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( mezan_is_file_in_theme( __FILE__ ) ) {
                    return MEZAN_MODULE_URI . '/woocommerce/single/modules/social-share-and-follow/';
                } else {
                    return trailingslashit( plugin_dir_url( __FILE__ ) );
                }

            }


        /*
        Load Modules
        */

            function load_modules() {

                // If Theme-Plugin is activated

                    if( function_exists( 'mezan_pro' ) ) {

                        // Customizer
                            include_once $this->module_dir_path() . 'customizer/index.php';

                        // Elementor
                            include_once $this->module_dir_path() . 'elementor/index.php';

                    }

                // Includes
                    include_once $this->module_dir_path() . 'includes/index.php';

            }

    }

}

if( !function_exists('mezan_shop_single_module_social_share_and_follow') ) {
	function mezan_shop_single_module_social_share_and_follow() {
        return Mezan_Shop_Single_Module_Social_Share_And_Follow::instance();
	}
}

if( class_exists( 'Mezan_Shop_Single_Module_Custom_template' ) ) {
    mezan_shop_single_module_social_share_and_follow();
}