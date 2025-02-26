<?php
/**
 * Recommends plugins for use with the theme via the TGMA Script
 *
 * @package Mezan WordPress theme
 */

function mezan_tgmpa_plugins_register() {

	// Get array of recommended plugins.

	$plugins_list = array(
        array(
            'name'               => esc_html__('Mezan Plus', 'mezan'),
            'slug'               => 'mezan-plus',
            'source'             => MEZAN_MODULE_DIR . '/plugins/mezan-plus.zip',
            'required'           => true,
            'version'            => '1.0.2',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'               => esc_html__('Mezan Pro', 'mezan'),
            'slug'               => 'mezan-pro',
            'source'             => MEZAN_MODULE_DIR . '/plugins/mezan-pro.zip',
            'required'           => true,
            'version'            => '1.0.1',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'               => esc_html__('Mezan Shop', 'mezan'),
            'slug'               => 'mezan-shop',
            'source'             => MEZAN_MODULE_DIR . '/plugins/mezan-shop.zip',
            'required'           => true,
            'version'            => '1.0.0',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'     => esc_html__('Elementor', 'mezan'),
            'slug'     => 'elementor',
            'required' => true,
        ),
        array(
            'name'               => esc_html__('Mezan WeDesignTech Elementor Addon', 'mezan'),
            'slug'               => 'mezan-wedesigntech-elementor-addon',
            'source'             => MEZAN_MODULE_DIR . '/plugins/mezan-wedesigntech-elementor-addon.zip',
            'required'           => true,
            'version'            => '1.0.4',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'               => esc_html__('Mezan WeDesignTech Portfolio', 'mezan'),
            'slug'               => 'mezan-wedesigntech-portfolio',
            'source'             => MEZAN_MODULE_DIR . '/plugins/mezan-wedesigntech-portfolio.zip',
            'required'           => true,
            'version'            => '1.0.1',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'     => esc_html__('Contact Form 7', 'mezan'),
            'slug'     => 'contact-form-7',
            'required' => true,
        ),
        array(
            'name'     => esc_html__('One Click Demo Import', 'mezan'),
            'slug'     => 'one-click-demo-import',
            'required' => true,
        ),
        array(
            'name'     => esc_html__('WooCommerce', 'mezan'),
            'slug'     => 'woocommerce',
            'required' => true,
        ),
        array(
            'name'     => esc_html__('TI WooCommerce Wishlist', 'mezan'),
            'slug'     => 'ti-woocommerce-wishlist',
            'required' => true,
        )
	);

    $plugins = apply_filters('mezan_required_plugins_list', $plugins_list);

	// Register notice
	tgmpa( $plugins, array(
		'id'           => 'mezan_theme',
		'domain'       => 'mezan',
		'menu'         => 'install-required-plugins',
		'has_notices'  => true,
		'is_automatic' => true,
		'dismissable'  => true,
	) );

}
add_action( 'tgmpa_register', 'mezan_tgmpa_plugins_register' );