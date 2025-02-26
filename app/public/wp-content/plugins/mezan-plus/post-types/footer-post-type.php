<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'MezanPlusFooterPostType' ) ) {

	class MezanPlusFooterPostType {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {

			add_action ( 'init', array( $this, 'mezan_register_cpt' ) );
			add_filter ( 'template_include', array ( $this, 'mezan_template_include' ) );
		}

		function mezan_register_cpt() {

			$labels = array (
				'name'				 => __( 'Footers', 'mezan-plus' ),
				'singular_name'		 => __( 'Footer', 'mezan-plus' ),
				'menu_name'			 => __( 'Footers', 'mezan-plus' ),
				'add_new'			 => __( 'Add Footer', 'mezan-plus' ),
				'add_new_item'		 => __( 'Add New Footer', 'mezan-plus' ),
				'edit'				 => __( 'Edit Footer', 'mezan-plus' ),
				'edit_item'			 => __( 'Edit Footer', 'mezan-plus' ),
				'new_item'			 => __( 'New Footer', 'mezan-plus' ),
				'view'				 => __( 'View Footer', 'mezan-plus' ),
				'view_item' 		 => __( 'View Footer', 'mezan-plus' ),
				'search_items' 		 => __( 'Search Footers', 'mezan-plus' ),
				'not_found' 		 => __( 'No Footers found', 'mezan-plus' ),
				'not_found_in_trash' => __( 'No Footers found in Trash', 'mezan-plus' ),
			);

			$args = array (
				'labels' 				=> $labels,
				'public' 				=> true,
				'exclude_from_search'	=> true,
				'show_in_nav_menus' 	=> false,
				'show_in_rest' 			=> true,
				'menu_position'			=> 26,
				'menu_icon' 			=> 'dashicons-editor-insertmore',
				'hierarchical' 			=> false,
				'supports' 				=> array ( 'title', 'editor', 'revisions' ),
			);

			register_post_type ( 'wdt_footers', $args );
		}

		function mezan_template_include($template) {
			if ( is_singular( 'wdt_footers' ) ) {
				if ( ! file_exists ( get_stylesheet_directory () . '/single-wdt_footers.php' ) ) {
					$template = MEZAN_PLUS_DIR_PATH . 'post-types/templates/single-wdt_footers.php';
				}
			}

			return $template;
		}
	}
}

MezanPlusFooterPostType::instance();