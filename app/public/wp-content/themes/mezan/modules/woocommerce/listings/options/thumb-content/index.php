<?php

/**
 * Listing Options - Product Thumb Content
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Woo_Listing_Option_Thumb_Content' ) ) {

    class Mezan_Woo_Listing_Option_Thumb_Content extends Mezan_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-thumb-content';
            $this->option_name          = esc_html__('Thumb Content', 'mezan');
            $this->option_type          = array ( 'html', 'value-css' );
            $this->option_default_value = '';
            $this->option_value_prefix  = '';

            $this->render_backend();

        }

        /*
        Backend Render
        */

            function render_backend() {
                add_filter( 'mezan_woo_custom_product_template_thumb_options', array( $this, 'woo_custom_product_template_thumb_options'), 10, 1 );
            }

        /*
        Custom Product Templates - Options
        */
            function woo_custom_product_template_thumb_options( $template_options ) {

                array_push( $template_options, $this->setting_args() );

                return $template_options;

            }

        /*
        Setting Group
        */
            function setting_group() {

                return 'thumb';

            }

        /*
        Setting Arguments
        */
            function setting_args() {

                $settings                =  array ();

                $settings['id']          =  $this->option_slug;
                $settings['type']        =  'sorter';
                $settings['title']       =  $this->option_name;
                $settings['default']     =  array (
                    'enabled'            => array(
                        'title'          => esc_html__('Title', 'mezan'),
                        'category'       => esc_html__('Category', 'mezan'),
                        'price'          => esc_html__('Price', 'mezan'),
                        'button_element' => esc_html__('Button Element', 'mezan'),
                        'icons_group'    => esc_html__('Icons Group', 'mezan'),
                    ),
                    'disabled'         => array(
                        'excerpt'        => esc_html__('Excerpt', 'mezan'),
                        'rating'         => esc_html__('Rating', 'mezan'),
                        'countdown'      => esc_html__('Count Down', 'mezan'),
                        'separator'      => esc_html__('Separator', 'mezan'),
                        'element_group'  => esc_html__('Element Group', 'mezan'),
                        'swatches'       => esc_html__('Swatches', 'mezan')
                    ),
                );

                return $settings;

            }

    }

}

if( !function_exists('mezan_woo_listing_option_thumb_content') ) {
	function mezan_woo_listing_option_thumb_content() {
		return Mezan_Woo_Listing_Option_Thumb_Content::instance();
	}
}

mezan_woo_listing_option_thumb_content();