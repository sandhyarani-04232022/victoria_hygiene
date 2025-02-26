<?php

/**
 * Listing Types - Default
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Mezan_Woo_Listing_Type_Default' ) ) {

    class Mezan_Woo_Listing_Type_Default {

        private static $_instance = null;

        private $type_slug;

        private $type_name;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            /* Initialize Type */
                $this->type_slug = 'default';
                $this->type_name = esc_html__('Default', 'mezan');

            /* Backend Render */
                $this->render_backend();

        }

        /*
        Module Paths
        */

            function module_dir_path() {

                if( mezan_is_file_in_theme( __FILE__ ) ) {
                    return MEZAN_MODULE_DIR . '/woocommerce/listings/types/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( mezan_is_file_in_theme( __FILE__ ) ) {
                    return MEZAN_MODULE_URI . '/woocommerce/listings/types/';
                } else {
                    return trailingslashit( plugin_dir_url( __FILE__ ) );
                }

            }

        /*
        Backend Render
        */
            function render_backend() {

                /* Custom Product Templates - Options */
                    add_filter( 'mezan_woo_default_product_templates', array( $this, 'woo_default_product_templates'), 10, 1 );

            }

        /*
        Custom Product Templates - Options
        */
            function woo_default_product_templates( $templates ) {

                $type_options = array_merge (
                    array( 'product-template-id' => $this->type_name ),
                    $this->set_type_options()
                );

                $default_template = array (
                    'id'              => 'mezan-woo-product-style-template-'.$this->type_slug,
                    'type'            => 'group',
                    'mezan_default_type' => true,
                    'title'           => sprintf( esc_html__( 'Product Templates - %1$s', 'mezan' ), $this->type_name ),
                    'button_title'    => esc_html__('Add New', 'mezan'),
                    'accordion_title' => esc_html__('Add New Template', 'mezan'),
                    'fields'          => mezan_woo_listing_fw_template_settings()->woo_get_options_params( $type_options, 'default' ),
                    'default'         => array ( 0 => $type_options )
                );

                array_push( $templates, $default_template );

                return $templates;

            }

        /*
        Set Type Options
        */
            function set_type_options() {

                $type_options = array ();

                $type_options['product-style']       = 'product-style-default';
                $type_options['product-hover-style'] = '';
                $type_options['product-hover-image-effect'] = '';
                $type_options['product-hover-secondary-image-effect'] = 'product-hover-secimage-fade';
                $type_options['product-overlay-effect'] = '';
                $type_options['product-overlay-bgcolor'] = '';
                $type_options['product-overlay-dark-bgcolor'] = 0;
                $type_options['product-icongroup-hover-effect'] = '';
                $type_options['product-content-hover-effect'] = '';
                $type_options['product-display-type'] = 'grid';
                $type_options['product-display-type-list-option'] = 'left-thumb';
                $type_options['product-space'] = 'product-with-space';
                $type_options['product-padding'] = 'product-padding-default';
                $type_options['product-background-bgcolor'] = '';
                $type_options['product-background-dark-bgcolor'] = 0;
                $type_options['product-borderorshadow'] = '';
                $type_options['product-border-type'] = 'product-border-type-default';
                $type_options['product-border-position'] = 'product-border-position-default';
                $type_options['product-shadow-type'] = 'product-shadow-type-default';
                $type_options['product-shadow-position'] = 'product-shadow-position-default';
                $type_options['product-bordershadow-highlight'] = '';
                $type_options['product-custom-class'] = 'custom-template-one';
                $type_options['product-show-label'] = 'true';
                $type_options['product-label-design'] = 'product-label-boxed';
                $type_options['product-show-offer-percentage'] = '';
                $type_options['product-show-custom-type'] = 'false';
                $type_options['product-empty-rating'] = 0;
                $type_options['product-thumb-image-display-type'] = 0;
                $type_options['product-thumb-secondary-image-onhover'] = 1;
                $type_options['product-thumb-content']          = array (
                    'enabled'      => array (
                    ),
                    'disabled'     => array (
                        'title'          => esc_html__('Title', 'mezan'),
                        'category'       => esc_html__('Category', 'mezan'),
                        'price'          => esc_html__('Price', 'mezan'),
                        'button_element' => esc_html__('Button Element', 'mezan'),
                        'icons_group'    => esc_html__('Icons Group', 'mezan'),
                        'excerpt'        => esc_html__('Excerpt', 'mezan'),
                        'rating'         => esc_html__('Rating', 'mezan'),
                        'countdown'      => esc_html__('Count Down', 'mezan'),
                        'separator'      => esc_html__('Separator', 'mezan'),
                        'element_group'  => esc_html__('Element Group', 'mezan'),
                        'swatches'       => esc_html__('Swatches', 'mezan')
                    )
                );
                $type_options['product-thumb-alignment'] = 'product-thumb-alignment-top';
                $type_options['product-thumb-iconsgroup-icons'] = array ();
                $type_options['product-thumb-iconsgroup-position'] = '';
                $type_options['product-thumb-iconsgroup-style'] = 'product-thumb-iconsgroup-style-simple';
                $type_options['product-thumb-buttonelement-button'] = '';
                $type_options['product-thumb-buttonelement-secondary-button'] = '';
                $type_options['product-thumb-buttonelement-style'] = 'product-thumb-buttonelement-style-simple';
                $type_options['product-thumb-buttonelement-stretch'] = 'false';
                $type_options['product-thumb-element-group'] = array (
                    'enabled'      => array (
                        'title'          => esc_html__('Title', 'mezan'),
                        'price'          => esc_html__('Price', 'mezan')
                    ),
                    'disabled'     => array (
                        'cart'           => esc_html__('Cart', 'mezan'),
                        'button_element' => esc_html__('Button Element', 'mezan'),
                        'wishlist'       => esc_html__('Wishlist', 'mezan'),
                        'compare'        => esc_html__('Compare', 'mezan'),
                        'quickview'      => esc_html__('Quick View', 'mezan'),
                        'category'       => esc_html__('Category', 'mezan'),
                        'icons_group'    => esc_html__('Icons Group', 'mezan'),
                        'excerpt'        => esc_html__('Excerpt', 'mezan'),
                        'rating'         => esc_html__('Rating', 'mezan'),
                        'separator'      => esc_html__('Separator', 'mezan'),
                        'swatches'       => esc_html__('Swatches', 'mezan'),
                    )
                );

                $type_options['product-content-enable'] = 1;
                $type_options['product-content-content'] = array (
                    'enabled'      => array (
                        'element_group'  => esc_html__('Element Group', 'mezan'),
                        'icons_group'    => esc_html__('Icons Group', 'mezan')
                    ),
                    'disabled'     => array (
                        'price'          => esc_html__('Price', 'mezan'),
                        'category'       => esc_html__('Category', 'mezan'),
                        'title'          => esc_html__('Title', 'mezan'),
                        'button_element' => esc_html__('Button Element', 'mezan'),
                        'excerpt'        => esc_html__('Excerpt', 'mezan'),
                        'rating'         => esc_html__('Rating', 'mezan'),
                        'countdown'      => esc_html__('Count Down', 'mezan'),
                        'separator'      => esc_html__('Separator', 'mezan'),
                        'swatches'       => esc_html__('Swatches', 'mezan')
                    )
                );
                $type_options['product-content-alignment'] = 'product-content-alignment-left';
                $type_options['product-content-iconsgroup-icons'] = array ( 'cart', 'wishlist' );
                $type_options['product-content-iconsgroup-style'] = 'product-content-iconsgroup-style-bgfill-rounded';
                $type_options['product-content-buttonelement-button'] = '';
                $type_options['product-content-buttonelement-secondary-button'] = '';
                $type_options['product-content-buttonelement-style'] = 'product-content-buttonelement-style-simple';
                $type_options['product-content-buttonelement-stretch'] = '';
                $type_options['product-content-element-group'] = array (
                    'enabled'      => array (
                        'title'          => esc_html__('Title', 'mezan'),
                        'price'          => esc_html__('Price', 'mezan'),
                    ),
                    'disabled'     => array (
                        'cart'           => esc_html__('Cart', 'mezan'),
                        'button_element' => esc_html__('Button Element', 'mezan'),
                        'wishlist'       => esc_html__('Wishlist', 'mezan'),
                        'compare'        => esc_html__('Compare', 'mezan'),
                        'quickview'      => esc_html__('Quick View', 'mezan'),
                        'category'       => esc_html__('Category', 'mezan'),
                        'icons_group'    => esc_html__('Icons Group', 'mezan'),
                        'excerpt'        => esc_html__('Excerpt', 'mezan'),
                        'rating'         => esc_html__('Rating', 'mezan'),
                        'separator'      => esc_html__('Separator', 'mezan'),
                        'swatches'       => esc_html__('Swatches', 'mezan')
                    )
                );

                return $type_options;


            }

        /*
        Frontend Render
        */
            function render_frontend() {

                $non_archive_listing = wc_get_loop_prop('non_archive_listing');

                if( $non_archive_listing ) {

                    /* Types CSS */
                        add_filter( 'mezan_woo_non_archive_css', array( $this, 'woo_listings_css_load'), 10, 1 );

                } else {

                    /* Types CSS */
                        add_filter( 'mezan_woo_archive_css', array( $this, 'woo_listings_css_load'), 10, 1 );

                }

            }

        /*
        Types CSS
        */
            function woo_listings_css_load( $css ) {

                $css .= $this->load_type_css();
                $css .= $this->load_type_skin_css();

                return $css;

            }

            // Type Main CSS
            function load_type_css() {

                $css = '';

                $css_file_path = $this->module_dir_path() . 'assets/css/'.$this->type_slug.'.css';

                if( file_exists ( $css_file_path ) ) {

                    ob_start();
                    include( $css_file_path );
                    $css .= "\n\n".ob_get_clean();

                }

                return $css;

            }

            // Type Skin CSS
            function load_type_skin_css() {

                $css = '';
                return $css;

            }

        /*
        For Non Archive Listing
        */
            function for_non_archive_listing() {

                /* Load Other Modules */

                    $sub_modules = array (
                        'includes' => 'listings/includes/index'
                    );

                    if( is_array( $sub_modules ) && !empty( $sub_modules ) ) {
                        foreach( $sub_modules as $sub_module ) {

                            if( $file_content = mezan_woo_locate_file( $sub_module ) ) {
                                include_once $file_content;
                            }

                        }
                    }


                /* Assets Load */

                    // CSS

                        wp_register_style( 'mezan-woo-non-archive', '', array (), MEZAN_THEME_VERSION, 'all' );
                        wp_enqueue_style( 'mezan-woo-non-archive' );

                        $css = '';

                        // Load common styles
                        if( !is_shop() && !is_product_category() && !is_product_tag() && !is_product() && !is_cart() && !is_checkout() ) {

                            $css_file_path = MEZAN_MODULE_DIR . '/woocommerce/assets/css/common.css';

                            if(!isset($GLOBALS['wdt_shop_loaded_files']) || (isset($GLOBALS['wdt_shop_loaded_files']) && !in_array($css_file_path, $GLOBALS['wdt_shop_loaded_files']))) {

                                if( file_exists ( $css_file_path ) ) {
                                    ob_start();
                                    include( $css_file_path );
                                    $css .= "\n\n".ob_get_clean();
                                }

                                if(!isset($GLOBALS['wdt_shop_loaded_files'])) {
                                    $GLOBALS['wdt_shop_loaded_files'] = array ();
                                }

                                array_push($GLOBALS['wdt_shop_loaded_files'], $css_file_path);

                            }


                            $css_file_path = MEZAN_MODULE_DIR . '/woocommerce/single/assets/css/common.css';

                            if(!isset($GLOBALS['wdt_shop_loaded_files']) || (isset($GLOBALS['wdt_shop_loaded_files']) && !in_array($css_file_path, $GLOBALS['wdt_shop_loaded_files']))) {

                                if( file_exists ( $css_file_path ) ) {
                                    ob_start();
                                    include( $css_file_path );
                                    $css .= "\n\n".ob_get_clean();
                                }

                                if(!isset($GLOBALS['wdt_shop_loaded_files'])) {
                                    $GLOBALS['wdt_shop_loaded_files'] = array ();
                                }

                                array_push($GLOBALS['wdt_shop_loaded_files'], $css_file_path);

                            }

                        }

                        $css = apply_filters( 'mezan_woo_non_archive_css', $css );

                        if( !empty($css) ) {
                            wp_add_inline_style( 'mezan-woo-non-archive', $css );
                        }

                    // JS

                        wp_register_script( 'mezan-woo-non-archive', '', array ('jquery'), false, true );
                        wp_enqueue_script( 'mezan-woo-non-archive' );

                        $js = '';

                        // Load common js
                        if( !is_shop() && !is_product_category() && !is_product_tag() && !is_product() && !is_cart() && !is_checkout() ) {

                            $js_file_path = MEZAN_MODULE_DIR . '/woocommerce/assets/js/common.js';
                            if(!isset($GLOBALS['wdt_shop_loaded_files']) || (isset($GLOBALS['wdt_shop_loaded_files']) && !in_array($js_file_path, $GLOBALS['wdt_shop_loaded_files']))) {

                                if( file_exists ( $js_file_path ) ) {
                                    ob_start();
                                    include( $js_file_path );
                                    $js .= "\n\n".ob_get_clean();
                                }

                                if(!isset($GLOBALS['wdt_shop_loaded_files'])) {
                                    $GLOBALS['wdt_shop_loaded_files'] = array ();
                                }

                                array_push($GLOBALS['wdt_shop_loaded_files'], $js_file_path);

                            }

                        }

                        $js = apply_filters( 'mezan_woo_non_archive_js', $js );

                        if( !empty($js) ) {
                            wp_add_inline_script( 'mezan-woo-non-archive', $js );
                        }

            }

    }

}

if( !function_exists('mezan_woo_listing_type_default') ) {
	function mezan_woo_listing_type_default() {
		return Mezan_Woo_Listing_Type_Default::instance();
	}
}

mezan_woo_listing_type_default();