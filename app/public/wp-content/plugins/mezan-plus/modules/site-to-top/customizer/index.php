<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MezanPlusCustomizerSiteToTop' ) ) {
    class MezanPlusCustomizerSiteToTop {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            add_filter( 'mezan_plus_customizer_default', array( $this, 'default' ) );
            add_action( 'mezan_general_cutomizer_options', array( $this, 'register_general' ), 40 );
        }

        function default( $option ) {
            $option['show_site_to_top'] = '0';
            return $option;
        }

        function register_general( $wp_customize ) {

            $wp_customize->add_section(
                new Mezan_Customize_Section(
                    $wp_customize,
                    'site-to-top-section',
                    array(
                        'title'    => esc_html__('To Top', 'mezan-plus'),
                        'panel'    => 'site-general-main-panel',
                        'priority' => 40,
                    )
                )
            );

                /**
                 * Option : Enable Site To Top
                 */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[show_site_to_top]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Mezan_Customize_Control_Switch(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[show_site_to_top]', array(
                            'type'    => 'wdt-switch',
                            'section' => 'site-to-top-section',
                            'label'   => esc_html__( 'Enable To Top', 'mezan-plus' ),
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'mezan-plus' ),
                                'off' => esc_attr__( 'No', 'mezan-plus' )
                            )
                        )
                    )
                );
        }
    }
}

MezanPlusCustomizerSiteToTop::instance();