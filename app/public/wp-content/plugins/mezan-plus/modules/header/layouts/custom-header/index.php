<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MezanPlusCustomHeader' ) ) {
    class MezanPlusCustomHeader {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'mezan_header_layouts', array( $this, 'add_custom_header_option' ), 20 );
            add_action( 'customize_register', array( $this, 'register' ), 20 );
            add_filter( 'mezan_header_get_template_part', array( $this, 'register_header_template' ), 10 );
        }

        function add_custom_header_option( $options ) {
            $options['custom-header'] = esc_html__('Custom Header', 'mezan-plus');
            return $options;
        }

        function register( $wp_customize ) {
            /**
             * Option :Site Elementor Header
             */
            $wp_customize->add_setting(
                MEZAN_CUSTOMISER_VAL . '[site_custom_header]', array(
                    'type'    => 'option',
                )
            );

            $wp_customize->add_control(
                new Mezan_Customize_Control(
                    $wp_customize, MEZAN_CUSTOMISER_VAL . '[site_custom_header]', array(
                        'type'       => 'select',
                        'section'    => 'site-header-section',
                        'label'      => esc_html__( 'Header Template', 'mezan-plus' ),
                        'dependency' => array( 'site_header', '==', 'custom-header' ),
                        'choices'    => $this->header_template_list()
                    )
                )
            );
        }

        function header_template_list() {
            $choices = array();
            $choices[''] = esc_html__('Select Header Template', 'mezan-plus' );

            $args = array(
                'post_type'      => 'wdt_headers',
                'orderby'        => 'title',
                'order'          => 'ASC',
                'posts_per_page' => -1,
                'post_status'    => 'publish'
            );

            $pages = get_posts($args);

            if ( ! is_wp_error( $pages ) && ! empty( $pages ) ) {

                foreach( $pages as $page ):
                    $choices[$page->ID]	= $page->post_title;
                endforeach;
            }

            return $choices;
        }

        function register_header_template( $template ) {

            $header_type = mezan_customizer_settings( 'site_header' );

            if( 'custom-header' == $header_type ) :

                $id = mezan_customizer_settings( 'site_custom_header' );
                if( $id > 0 ):
                    return apply_filters( 'mezan_print_header_template', $id );
                endif;

            endif;

            return $template;
        }
    }
}

MezanPlusCustomHeader::instance();