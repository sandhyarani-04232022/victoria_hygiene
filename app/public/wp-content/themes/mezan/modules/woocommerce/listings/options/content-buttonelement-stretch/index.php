<?php
/**
 * Listing Options - Image Effect
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Woo_Listing_Option_Content_Button_Element_Stretch' ) ) {

    class Mezan_Woo_Listing_Option_Content_Button_Element_Stretch extends Mezan_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-content-buttonelement-stretch';
            $this->option_name          = esc_html__('Button Element - Stretch', 'mezan');
            $this->option_type          = array ( 'class', 'value-css' );
            $this->option_default_value = '';
            $this->option_value_prefix  = 'product-content-buttonelement-';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'mezan_woo_custom_product_template_content_options', array( $this, 'woo_custom_product_template_content_options'), 45, 1 );
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
                ''                                    => esc_html__('False', 'mezan'),
                'product-content-buttonelement-stretch' => esc_html__('True', 'mezan'),
            );
            $settings['default']    =  $this->option_default_value;

            return $settings;
        }
    }

}

if( !function_exists('mezan_woo_listing_option_content_buttonelement_stretch') ) {
	function mezan_woo_listing_option_content_buttonelement_stretch() {
		return Mezan_Woo_Listing_Option_Content_Button_Element_Stretch::instance();
	}
}

mezan_woo_listing_option_content_buttonelement_stretch();