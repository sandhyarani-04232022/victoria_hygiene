<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MezanPlusSiteCustomLoader' ) ) {
    class MezanPlusSiteCustomLoader {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'mezan_loader_layouts', array( $this, 'add_option' ) );

            $site_loader = mezan_customizer_settings( 'site_loader' );

            if( $site_loader == 'custom-loader' ) {

                add_action( 'mezan_after_main_css', array( $this, 'enqueue_assets' ) );

                /**
                 * filter: mezan_primary_color_style - to use primary color
                 * filter: mezan_secondary_color_style - to use secondary color
                 * filter: mezan_tertiary_color_style - to use tertiary color
                 */
                add_filter( 'mezan_primary_color_style', array( $this, 'primary_color_css' ) );
                add_filter( 'mezan_tertiary_color_style', array( $this, 'tertiary_color_style' ) );
            }

        }

        function add_option( $options ) {
            $options['custom-loader'] = esc_html__('Custom Loader', 'mezan-plus');
            return $options;
        }

        function enqueue_assets() {
            wp_enqueue_style( 'site-loader', MEZAN_PLUS_DIR_URL . 'modules/site-loader/layouts/custom-loader/assets/css/custom-loader.css', false, MEZAN_PLUS_VERSION, 'all' );
        }

        function primary_color_css( $style ) {
            $style .= ".custom_loader { background-color:var( --wdtBodyBGColor );}";
            return $style;
        }

        function tertiary_color_style( $style ) {
            $style .= ".custom_loader:before { background-color:var( --wdtTertiaryColor );}";
            return $style;
        }
    }
}

MezanPlusSiteCustomLoader::instance();