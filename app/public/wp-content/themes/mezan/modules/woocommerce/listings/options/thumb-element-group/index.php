<?php

/**
 * Listing Options - Product Thumb Content
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Woo_Listing_Option_Thumb_Element_Group' ) ) {

    class Mezan_Woo_Listing_Option_Thumb_Element_Group extends Mezan_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-thumb-element-group';
            $this->option_name          = esc_html__('Element Group Content', 'mezan');
            $this->option_type          = array ( 'html', 'value-css' );
            $this->option_default_value = '';
            $this->option_value_prefix  = '';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {

            /* Custom Product Templates - Options */
            add_filter( 'mezan_woo_custom_product_template_thumb_options', array( $this, 'woo_custom_product_template_thumb_options'), 55, 1 );
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
         * Setting Arguments
         */
        function setting_args() {

            $settings            =  array ();
            $settings['id']      =  $this->option_slug;
            $settings['type']    =  'sorter';
            $settings['title']   =  $this->option_name;
            $settings['default'] =  array (
                'enabled' => array(
                    'title' => esc_html__('Title', 'mezan'),
                    'price' => esc_html__('Price', 'mezan'),
                ),
                'disabled'         => array(
                    'cart'           => esc_html__('Cart', 'mezan'),
                    'wishlist'       => esc_html__('Wishlist', 'mezan'),
                    'compare'        => esc_html__('Compare', 'mezan'),
                    'quickview'      => esc_html__('Quick View', 'mezan'),
                    'category'       => esc_html__('Category', 'mezan'),
                    'button_element' => esc_html__('Button Element', 'mezan'),
                    'icons_group'    => esc_html__('Icons Group', 'mezan'),
                    'excerpt'        => esc_html__('Excerpt', 'mezan'),
                    'rating'         => esc_html__('Rating', 'mezan'),
                    'separator'      => esc_html__('Separator', 'mezan'),
                    'swatches'       => esc_html__('Swatches', 'mezan')
                ),
            );
            $settings['enabled_title']  =  esc_html__('Active Elements', 'mezan');
            $settings['disabled_title'] =  esc_html__('Deatcive Elements', 'mezan');

            return $settings;
        }
    }

}

if( !function_exists('mezan_woo_listing_option_thumb_element_group') ) {
	function mezan_woo_listing_option_thumb_element_group() {
		return Mezan_Woo_Listing_Option_Thumb_Element_Group::instance();
	}
}

mezan_woo_listing_option_thumb_element_group();