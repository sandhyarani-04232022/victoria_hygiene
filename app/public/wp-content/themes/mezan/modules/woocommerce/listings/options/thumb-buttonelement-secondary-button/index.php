<?php
/**
 * Listing Options - Image Effect
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Woo_Listing_Option_Thumb_Button_Element_Secondary_button' ) ) {

    class Mezan_Woo_Listing_Option_Thumb_Button_Element_Secondary_button extends Mezan_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-thumb-buttonelement-secondary-button';
            $this->option_name          = esc_html__('Button Element - Secondary Button', 'mezan');
            $this->option_type          = array ( 'html', 'value-css' );
            $this->option_default_value = '';
            $this->option_value_prefix  = '';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'mezan_woo_custom_product_template_thumb_options', array( $this, 'woo_custom_product_template_thumb_options'), 40, 1 );
        }

        /**
         * Custom Product Templates - Options
         */
        function woo_custom_product_template_thumb_options( $template_options ) {

            array_push( $template_options, $this->setting_args() );

            return $template_options;
        }

        /**
         * Settings Group
         */
        function setting_group() {
            return 'thumb';
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
                ''          => esc_html__('None', 'mezan'),
                'cart'      => esc_html__('Cart', 'mezan'),
                'wishlist'  => esc_html__('Wishlist', 'mezan'),
                'compare'   => esc_html__('Compare', 'mezan'),
                'quickview' => esc_html__('Quick View', 'mezan')
            );
            $settings['default']    =  $this->option_default_value;

            return $settings;
        }
    }

}

if( !function_exists('mezan_woo_listing_option_thumb_buttonelement_secondary_button') ) {
	function mezan_woo_listing_option_thumb_buttonelement_secondary_button() {
		return Mezan_Woo_Listing_Option_Thumb_Button_Element_Secondary_button::instance();
	}
}

mezan_woo_listing_option_thumb_buttonelement_secondary_button();