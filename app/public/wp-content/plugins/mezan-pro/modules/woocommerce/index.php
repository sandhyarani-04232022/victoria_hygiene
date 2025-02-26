<?php

/**
 * WooCommerce
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Pro_WooCommerce' ) ) {

    class Mezan_Pro_WooCommerce {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            /* Load Modules */
                $this->load_modules();

            /* Set Defaults */
                add_action( 'init', array( $this, 'set_defaults' ) );

            /* Override WooCommerce default template files */
                add_filter( 'woocommerce_locate_template',  array( $this, 'woocommerce_locate_template' ), 20, 3 );

            /* Locate File */
                add_filter( 'mezan_woo_locate_file', array( $this, 'mezan_woo_pro_locate_file'), 1, 2 );

            /* Load Widget */
                add_action( 'widgets_init', array( $this, 'register_widgets_init' ) );

        }

        /*
        Set Defaults
        */
            function set_defaults() {

                // Updating customizer default values
                $saved_settings = get_option( MEZAN_CUSTOMISER_VAL );
                $saved_settings = (is_array($saved_settings) && !empty($saved_settings)) ? $saved_settings : array ();

                if(!array_key_exists('shop-pro-settings-updated',  $saved_settings)) {
                    $shop_pro_defaults = apply_filters( 'mezan_shop_pro_customizer_default', array( 'shop-pro-settings-updated' => true ) );
                    $saved_settings = array_merge($saved_settings, $shop_pro_defaults);
                }

                if(!empty($saved_settings)) {
                    update_option( constant( 'MEZAN_CUSTOMISER_VAL' ), $saved_settings );
                }

            }

        /*
        Load Modules
        */
            function load_modules() {

                /* Elementor */
                    require_once MEZAN_PRO_DIR_PATH . 'modules/woocommerce/elementor/index.php';

                /* Customizer */
                    include_once MEZAN_PRO_DIR_PATH . 'modules/woocommerce/customizer/index.php';

                /* Load Listing Helpers */
                    include_once MEZAN_PRO_DIR_PATH . 'modules/woocommerce/listings/index.php';

                /* Template Pages */
                    include_once MEZAN_PRO_DIR_PATH . 'modules/woocommerce/shop/index.php';
                    include_once MEZAN_PRO_DIR_PATH . 'modules/woocommerce/category/index.php';
                    include_once MEZAN_PRO_DIR_PATH . 'modules/woocommerce/tag/index.php';

                /* Single Page */
                    include_once MEZAN_PRO_DIR_PATH . 'modules/woocommerce/single/index.php';

                /* Others */
                    include_once MEZAN_PRO_DIR_PATH . 'modules/woocommerce/others/index.php';

            }

        /**
         * Override WooCommerce default template files
         */
            function woocommerce_locate_template( $template, $template_name, $template_path ) {

                global $woocommerce;

                $_template = $template;

                if ( ! $template_path ) $template_path = $woocommerce->template_url;

                $plugin_path  = MEZAN_PRO_DIR_PATH . 'modules/woocommerce/templates/';

                // Look within passed path within the theme - this is priority
                $template = locate_template(
                    array(
                        $template_path . $template_name,
                        $template_name
                    )
                );

                // Modification: Get the template from this plugin, if it exists
                if ( ! $template && file_exists( $plugin_path . $template_name ) )
                $template = $plugin_path . $template_name;

                // Use default template
                if ( ! $template )
                $template = $_template;

                // Return what we found
                return $template;

            }

        /*
        Locate File
        */
            function mezan_woo_pro_locate_file( $file_path, $module ) {

                $plugin_file_path = apply_filters( 'mezan_woo_pro_locate_file', '', $module);

                if( $plugin_file_path ) {
                    $file_path = $plugin_file_path;
                } else {
                    $file_path = MEZAN_PRO_DIR_PATH . 'modules/woocommerce/' . $module .'.php';
                }

                $located_file_path = false;
                if ( $file_path && file_exists( $file_path ) ) {
                    $located_file_path = $file_path;
                }

                return $located_file_path;

            }


        /*
        Widget Init
        */
            function register_widgets_init() {
                include_once MEZAN_PRO_DIR_PATH.'modules/woocommerce/widget/widget-orderby.php';
                register_widget('Mezan_Widget_OrderBy');
            }

    }

}

if( !function_exists('mezan_pro_woocommerce') ) {
	function mezan_pro_woocommerce() {
        return Mezan_Pro_WooCommerce::instance();
	}
}

$active_plugins = get_option('active_plugins');
if(in_array('woocommerce/woocommerce.php', $active_plugins)) {
    mezan_pro_woocommerce();
}