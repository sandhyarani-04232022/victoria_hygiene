<?php

/**
 * WooCommerce - Single - Module - CountDown Timer
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Shop_Single_Module_Additional_Info' ) ) {

    class Mezan_Shop_Single_Module_Additional_Info {

        private static $_instance = null;

        private $product_additional_info;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load Modules
                $this->load_modules();

            // Enable Addiitonal Info - Default Single Page
                $settings = mezan_woo_single_core()->woo_default_settings();
                extract($settings);
                $this->product_additional_info = $product_additional_info;

            // Js Variables
                add_filter( 'mezan_woo_objects', array ( $this, 'woo_objects' ), 10, 1 );

            // CSS
                add_filter( 'mezan_woo_css', array( $this, 'woo_css'), 10, 1 );

            // JS
                add_filter( 'mezan_woo_js', array( $this, 'woo_js'), 10, 1 );

        }

        /*
        Module Paths
        */

            function module_dir_path() {

                if( mezan_is_file_in_theme( __FILE__ ) ) {
                    return MEZAN_MODULE_DIR . '/woocommerce/single/modules/additional-info/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( mezan_is_file_in_theme( __FILE__ ) ) {
                    return MEZAN_MODULE_URI . '/woocommerce/single/modules/additional-info/';
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


        /*
        Js Variables
        */

            function woo_objects( $woo_objects ) {

                $product_template = mezan_shop_woo_product_single_template_option();

                $woo_objects['enable_additional_info_scripts'] = esc_js(false);
                if( $this->product_additional_info && $product_template == 'woo-default' ) {
                    $woo_objects['enable_additional_info_scripts'] = esc_js(true);
                }

                return $woo_objects;

            }

        /*
        CSS
        */
            function woo_css( $css ) {

                $product_template = mezan_shop_woo_product_single_template_option();

                if( $this->product_additional_info && $product_template == 'woo-default' ) {

                    $css_file_path = $this->module_dir_path() . 'assets/css/style.css';

                    if( file_exists ( $css_file_path ) ) {

                        ob_start();
                        include( $css_file_path );
                        $css .= "\n\n".ob_get_clean();

                    }

                }

                return $css;

            }

        /*
        JS
        */
            function woo_js( $js ) {

                $product_template = mezan_shop_woo_product_single_template_option();

                if( $this->product_additional_info && $product_template == 'woo-default' ) {

                    $js_file_path = $this->module_dir_path() . 'assets/js/scripts.js';

                    if( file_exists ( $js_file_path ) ) {

                        ob_start();
                        include( $js_file_path );
                        $js .= "\n\n".ob_get_clean();

                    }

                }

                return $js;

            }

    }

}


if( !function_exists('mezan_shop_single_module_additional_info') ) {
	function mezan_shop_single_module_additional_info() {
        $reflection = new ReflectionClass('Mezan_Shop_Single_Module_Additional_Info');
        return $reflection->newInstanceWithoutConstructor();
	}
}

if( class_exists( 'Mezan_Shop_Single_Module_Custom_template' ) ) {
    Mezan_Shop_Single_Module_Additional_Info::instance();
}