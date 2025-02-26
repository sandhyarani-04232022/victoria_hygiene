<?php

/*
* Update Summary - Options Filter
*/

if( ! function_exists( 'mezan_shop_woo_single_summary_options_cmezan_render' ) ) {
	function mezan_shop_woo_single_summary_options_cmezan_render( $options ) {

		$options['countdown'] = esc_html__('Summary Count Down', 'mezan-pro');
		return $options;

	}
	add_filter( 'mezan_shop_woo_single_summary_options', 'mezan_shop_woo_single_summary_options_cmezan_render', 10, 1 );

}

/*
* Update Summary - Styles Filter
*/

if( ! function_exists( 'mezan_shop_woo_single_summary_styles_cmezan_render' ) ) {
	function mezan_shop_woo_single_summary_styles_cmezan_render( $styles ) {

		array_push( $styles, 'wdt-shop-coundown-timer' );
		return $styles;

	}
	add_filter( 'mezan_shop_woo_single_summary_styles', 'mezan_shop_woo_single_summary_styles_cmezan_render', 10, 1 );

}

/*
* Update Summary - Scripts Filter
*/

if( ! function_exists( 'mezan_shop_woo_single_summary_scripts_cmezan_render' ) ) {
	function mezan_shop_woo_single_summary_scripts_cmezan_render( $scripts ) {

		array_push( $scripts, 'jquery-downcount' );
		array_push( $scripts, 'wdt-shop-coundown-timer' );
		return $scripts;

	}
	add_filter( 'mezan_shop_woo_single_summary_scripts', 'mezan_shop_woo_single_summary_scripts_cmezan_render', 10, 1 );

}