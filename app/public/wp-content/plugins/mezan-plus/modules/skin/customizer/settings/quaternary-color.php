<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MezanPlusSkinQuaternaryColor' ) ) {
    class MezanPlusSkinQuaternaryColor {
        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'mezan_plus_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 15);

            add_filter( 'mezan_quaternary_color_css_var', array( $this, 'quaternary_color_var' ) );
            add_filter( 'mezan_quaternary_rgb_color_css_var', array( $this, 'quaternary_rgb_color_var' ) );
            add_filter( 'mezan_add_inline_style', array( $this, 'base_style' ) );
        }

        function default( $option ) {
            $theme_defaults = function_exists('mezan_theme_defaults') ? mezan_theme_defaults() : array ();
            $option['quaternary_color'] = $theme_defaults['quaternary_color'];
            return $option;
        }

        function register( $wp_customize ) {

                /**
                 * Option : Quaternary Color
                 */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[quaternary_color]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new mezan_Customize_Control_Color(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[quaternary_color]', array(
                            'section' => 'site-skin-main-section',
                            'label'   => esc_html__( 'Quaternary Color', 'mezan-plus' ),
                        )
                    )
                );

        }

        function quaternary_color_var( $var ) {
            $quaternary_color = mezan_customizer_settings( 'quaternary_color' );
            if( !empty( $quaternary_color ) ) {
                $var = '--wdtQuaternaryColor:'.esc_attr($quaternary_color).';';
            }

            return $var;
        }

        function quaternary_rgb_color_var( $var ) {
            $quaternary_color = mezan_customizer_settings( 'quaternary_color' );
            if( !empty( $quaternary_color ) ) {
                $var = '--wdtQuaternaryColorRgb:'.mezan_hex2rgba($quaternary_color, false).';';
            }

            return $var;
        }

        function base_style( $style ) {
            $style = apply_filters( 'mezan_quaternary_color_style', $style );

            return $style;
        }
    }
}

MezanPlusSkinQuaternaryColor::instance();