<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MezanPlusCustomizerSiteSkins' ) ) {
    class MezanPlusCustomizerSiteSkins {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15);
            $this->load_modules();
        }

        function register( $wp_customize ) {

            /**
             * Main Section
             */
            $wp_customize->add_section(
                new Mezan_Customize_Section(
                    $wp_customize,
                    'site-skin-main-section',
                    array(
                        'title'    => esc_html__('Site Skin', 'mezan-plus'),
                        'priority' => mezan_customizer_panel_priority( 'skin' )
                    )
                )
            );

        }

        function load_modules() {
            foreach( glob( MEZAN_PLUS_DIR_PATH. 'modules/skin/customizer/settings/*.php'  ) as $module ) {
                include_once $module;
            }
        }

    }
}

MezanPlusCustomizerSiteSkins::instance();