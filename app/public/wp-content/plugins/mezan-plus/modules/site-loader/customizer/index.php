<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MezanPlusCustomizerSiteLoader' ) ) {
    class MezanPlusCustomizerSiteLoader {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'mezan_plus_customizer_default', array( $this, 'default' ) );
            add_action( 'mezan_general_cutomizer_options', array( $this, 'register_general' ), 30 );
        }

        function default( $option ) {

            $option['show_site_loader'] = '1';
            $option['site_loader']      = '';
            $option['site_loader_image'] = '';

            return $option;
        }

        function register_general( $wp_customize ) {

            $wp_customize->add_section(
                new Mezan_Customize_Section(
                    $wp_customize,
                    'site-loader-section',
                    array(
                        'title'    => esc_html__('Loader', 'mezan-plus'),
                        'panel'    => 'site-general-main-panel',
                        'priority' => 30,
                    )
                )
            );

                /**
                 * Option : Enable Site Loader
                 */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[show_site_loader]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Mezan_Customize_Control_Switch(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[show_site_loader]', array(
                            'type'    => 'wdt-switch',
                            'section' => 'site-loader-section',
                            'label'   => esc_html__( 'Enable Loader', 'mezan-plus' ),
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'mezan-plus' ),
                                'off' => esc_attr__( 'No', 'mezan-plus' )
                            )
                        )
                    )
                );

                /**
                 * Option :Site Loader
                 */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[site_loader]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Mezan_Customize_Control(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[site_loader]', array(
                            'type'       => 'select',
                            'section'    => 'site-loader-section',
                            'label'      => esc_html__( 'Select Loader', 'mezan-plus' ),
                            'choices'    => apply_filters( 'mezan_loader_layouts', array() ),
                            'dependency' => array( 'show_site_loader', '!=', '' ),
                        )
                    )
                );

                /**
                 * Option :Site Image
                 */
                $wp_customize->add_setting(
                    MEZAN_CUSTOMISER_VAL . '[site_loader_image]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Mezan_Customize_Control_Upload(
                        $wp_customize, MEZAN_CUSTOMISER_VAL . '[site_loader_image]', array(
                            'type'       => 'wdt-upload',
                            'section'    => 'site-loader-section',
                            'label'      => esc_html__( 'Upload Loader Image', 'mezan-plus' ),
                            'dependency' => array( 'site_loader|show_site_loader', '==|!=', 'custom-loader|' ),
                        )
                    )
                );
        }

    }
}

MezanPlusCustomizerSiteLoader::instance();