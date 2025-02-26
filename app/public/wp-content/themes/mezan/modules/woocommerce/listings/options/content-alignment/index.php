<?php
/**
 * Listing Options - Image Effect
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Woo_Listing_Option_Content_Alignment' ) ) {

    class Mezan_Woo_Listing_Option_Content_Alignment extends Mezan_Woo_Listing_Option_Core {

        private static $_instance = null;

        public $option_slug;

        public $option_name;

        public $option_type;

        public $option_default_value;

        public $option_value_prefix;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            $this->option_slug          = 'product-content-alignment';
            $this->option_name          = esc_html__('Alignment', 'mezan');
            $this->option_type          = array ( 'class', 'value-css' );
            $this->option_default_value = 'product-content-alignment-left';
            $this->option_value_prefix  = 'product-content-alignment-';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'mezan_woo_custom_product_template_content_options', array( $this, 'woo_custom_product_template_content_options'), 15, 1 );
        }

        /**
         * Custom Product Templates - Options
         */
        function woo_custom_product_template_content_options( $template_options ) {

            array_push( $template_options, $this->setting_args() );

            return $template_options;
        }

        /**
         * Settings Group
         */
        function setting_group() {
            return 'content';
        }

        /**
         * Setting Args
         */
        function setting_args() {
            $settings            =  array ();
            $settings['id']      =  $this->option_slug;
            $settings['type']    =  'select';
            $settings['title']   =  $this->option_name;
            $settings['options'] =  array (
                'product-content-alignment-left'   => esc_html__('Left', 'mezan'),
                'product-content-alignment-center' => esc_html__('Center', 'mezan'),
                'product-content-alignment-right'  => esc_html__('Right', 'mezan')
            );
            $settings['default'] =  $this->option_default_value;

            return $settings;
        }
    }

}

if( !function_exists('mezan_woo_listing_option_content_alignment') ) {
	function mezan_woo_listing_option_content_alignment() {
		return Mezan_Woo_Listing_Option_Content_Alignment::instance();
	}
}

mezan_woo_listing_option_content_alignment();