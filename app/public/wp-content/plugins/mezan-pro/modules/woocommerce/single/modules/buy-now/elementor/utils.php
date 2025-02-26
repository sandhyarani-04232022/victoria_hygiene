<?php

/*
* Update Summary - Options Filter
*/

if( ! function_exists( 'mezan_shop_woo_single_summary_options_bn_render' ) ) {
	function mezan_shop_woo_single_summary_options_bn_render( $options ) {

		$options['buy_now'] = esc_html__('Summary Buy Now', 'mezan-pro');
		return $options;

	}
	add_filter( 'mezan_shop_woo_single_summary_options', 'mezan_shop_woo_single_summary_options_bn_render', 10, 1 );

}

/*
* Update Summary - Styles Filter
*/

if( ! function_exists( 'mezan_shop_woo_single_summary_styles_bn_render' ) ) {
	function mezan_shop_woo_single_summary_styles_bn_render( $styles ) {

		array_push( $styles, 'wdt-shop-buy-now' );
		return $styles;

	}
	add_filter( 'mezan_shop_woo_single_summary_styles', 'mezan_shop_woo_single_summary_styles_bn_render', 10, 1 );

}

/*
* Update Summary - Scripts Filter
*/

if( ! function_exists( 'mezan_shop_woo_single_summary_scripts_bn_render' ) ) {
	function mezan_shop_woo_single_summary_scripts_bn_render( $scripts ) {

		array_push( $scripts, 'wdt-shop-buy-now' );
		return $scripts;

	}
	add_filter( 'mezan_shop_woo_single_summary_scripts', 'mezan_shop_woo_single_summary_scripts_bn_render', 10, 1 );

}