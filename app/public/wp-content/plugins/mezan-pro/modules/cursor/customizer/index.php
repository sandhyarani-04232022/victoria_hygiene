<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MezanProCustomizerCursor' ) ) {
    class MezanProCustomizerCursor {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'mezan_pro_customizer_default', array( $this, 'default' ) );
            add_action( 'mezan_general_cutomizer_options', array( $this, 'register_general' ), 30 );
        }

        function default( $option ) {

            $option['enable_cursor_effect'] = '1';
            $option['cursor_type'] = 'type-1';
            $option['cursor_link_hover_effect'] = 'link-hover-effect-1';
            $option['cursor_lightbox_hover_effect'] = 'image-hover-effect-1';

            return $option;
        }

        function register_general( $wp_customize ) {

            $wp_customize->add_section(
                new Mezan_Customize_Section(
                    $wp_customize,
                    'cursor-section',
                    array(
                        'title'    => esc_html__('Cursor', 'mezan-pro'),
                        'panel'    => 'site-general-main-panel',
                        'priority' => 30,
                    )
                )
            );

                /**
                 * Option : Enable Cursor
                 */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[enable_cursor_effect]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Mezan_Customize_Control_Switch(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[enable_cursor_effect]', array(
                            'type'    => 'wdt-switch',
                            'section' => 'cursor-section',
                            'label'   => esc_html__( 'Enable Cursor Effect', 'mezan-pro' ),
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'mezan-pro' ),
                                'off' => esc_attr__( 'No', 'mezan-pro' )
                            )
                        )
                    )
                );

                /**
                 * Option : Type
                 */
                /* $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[cursor_type]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Mezan_Customize_Control(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[cursor_type]', array(
                            'type'       => 'select',
                            'section'    => 'cursor-section',
                            'label'      => esc_html__( 'Type', 'mezan-pro' ),
                            'desc'      => esc_html__( 'Choose one of the available cursor types.', 'mezan-pro' ),
                            'choices'    => array (
                                'type-1' => esc_html__('Type 1', 'mezan-pro'),
                                'type-2' => esc_html__('Type 2', 'mezan-pro'),
                            ),
                            'dependency' => array( 'enable_cursor_effect', '!=', '' ),
                        )
                    )
                ); */

                /**
                 * Option : Link Hover Effect
                 */
                /* $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[cursor_link_hover_effect]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Mezan_Customize_Control(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[cursor_link_hover_effect]', array(
                            'type'       => 'select',
                            'section'    => 'cursor-section',
                            'label'      => esc_html__( 'Link Hover Effect', 'mezan-pro' ),
                            'desc'      => esc_html__( 'Effects to use if cursor hovers on links.', 'mezan-pro' ),
                            'choices'    => array (
                                '' => esc_html__('None', 'mezan-pro'),
                                'link-hover-effect-1' => esc_html__('Effect 1', 'mezan-pro'),
                                'link-hover-effect-2' => esc_html__('Effect 2', 'mezan-pro'),
                            ),
                            'dependency' => array( 'enable_cursor_effect', '!=', '' ),
                        )
                    )
                ); */

                /**
                 * Option : LightBox Hover Effect
                 */
                /* $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[cursor_lightbox_hover_effect]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Mezan_Customize_Control(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[cursor_lightbox_hover_effect]', array(
                            'type'       => 'select',
                            'section'    => 'cursor-section',
                            'label'      => esc_html__( 'LightBox Hover Effect', 'mezan-pro' ),
                            'desc'      => esc_html__( 'Effects to use if cursor hovers on images.', 'mezan-pro' ),
                            'choices'    => array (
                                '' => esc_html__('None', 'mezan-pro'),
                                'image-hover-effect-1' => esc_html__('Effect 1', 'mezan-pro'),
                                'image-hover-effect-2' => esc_html__('Effect 2', 'mezan-pro'),
                            ),
                            'dependency' => array( 'enable_cursor_effect', '!=', '' ),
                        )
                    )
                ); */

        }

    }
}

MezanProCustomizerCursor::instance();