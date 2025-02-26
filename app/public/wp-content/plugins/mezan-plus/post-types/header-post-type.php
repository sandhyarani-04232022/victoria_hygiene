<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'MezanPlusHeaderPostType' ) ) {

	class MezanPlusHeaderPostType {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {

			add_action ( 'init', array( $this, 'mezan_register_cpt' ), 5 );
			add_filter ( 'template_include', array ( $this, 'mezan_template_include' ) );
		}

		function mezan_register_cpt() {

			$labels = array (
				'name'				 => __( 'Headers', 'mezan-plus' ),
				'singular_name'		 => __( 'Header', 'mezan-plus' ),
				'menu_name'			 => __( 'Headers', 'mezan-plus' ),
				'add_new'			 => __( 'Add Header', 'mezan-plus' ),
				'add_new_item'		 => __( 'Add New Header', 'mezan-plus' ),
				'edit'				 => __( 'Edit Header', 'mezan-plus' ),
				'edit_item'			 => __( 'Edit Header', 'mezan-plus' ),
				'new_item'			 => __( 'New Header', 'mezan-plus' ),
				'view'				 => __( 'View Header', 'mezan-plus' ),
				'view_item' 		 => __( 'View Header', 'mezan-plus' ),
				'search_items' 		 => __( 'Search Headers', 'mezan-plus' ),
				'not_found' 		 => __( 'No Headers found', 'mezan-plus' ),
				'not_found_in_trash' => __( 'No Headers found in Trash', 'mezan-plus' ),
			);

			$args = array (
				'labels' 				=> $labels,
				'public' 				=> true,
				'exclude_from_search'	=> true,
				'show_in_nav_menus' 	=> false,
				'show_in_rest' 			=> true,
				'menu_position'			=> 25,
				'menu_icon' 			=> 'dashicons-heading',
				'hierarchical' 			=> false,
				'supports' 				=> array ( 'title', 'editor', 'revisions' ),
			);

			register_post_type ( 'wdt_headers', $args );
		}

		function mezan_template_include($template) {
			if ( is_singular( 'wdt_headers' ) ) {
				if ( ! file_exists ( get_stylesheet_directory () . '/single-wdt_headers.php' ) ) {
					$template = MEZAN_PLUS_DIR_PATH . 'post-types/templates/single-wdt_headers.php';
				}
			}

			return $template;
		}
	}
}

MezanPlusHeaderPostType::instance();