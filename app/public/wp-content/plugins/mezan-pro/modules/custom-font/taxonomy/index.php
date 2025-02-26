<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MezanProTaxonomyCustomFont' ) ) {
    class MezanProTaxonomyCustomFont {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            add_action( 'init', array( $this, 'register_taxonomy' ) );
            add_action( 'admin_menu', array( $this, 'admin_menu' ), 150 );

            add_action( 'admin_head', array( $this, 'taxonomy_css' ) );
            add_filter( 'manage_edit-mezan_custom_fonts_columns', array( $this, 'remove_fields' ) );
            add_filter( 'upload_mimes', array( $this, 'add_fonts_to_allowed_mimes' ) );
			add_filter( 'wp_check_filetype_and_ext', array( $this, 'update_mime_types' ), 10, 3 );
            add_filter( 'cs_taxonomy_options', array( $this, 'register_fields' ) );
        }

        function register_taxonomy() {

            $labels = array(
                'name'          => esc_html__('Custom Fonts', 'mezan-pro' ),
                'singular_name' => esc_html__( 'Font', 'mezan-pro' ),
                'menu_name'     => _x( 'Custom Fonts', 'Admin menu name', 'mezan-pro' ),
                'search_items'  => esc_html__( 'Search Fonts', 'mezan-pro' ),
                'all_items'     => esc_html__( 'All Fonts', 'mezan-pro' ),
                'edit_item'     => esc_html__( 'Edit Font', 'mezan-pro' ),
                'update_item'   => esc_html__( 'Update Font', 'mezan-pro' ),
                'add_new_item'  => esc_html__( 'Add New Font', 'mezan-pro' ),
                'new_item_name' => esc_html__( 'New Font Name', 'mezan-pro' ),
                'not_found'     => esc_html__( 'No fonts found', 'mezan-pro' ),
                'back_to_items' => esc_html__( 'Back to fonts', 'mezan-pro' ),
			);

            $args   = array(
				'hierarchical'      => false,
				'labels'            => $labels,
				'public'            => false,
				'show_in_nav_menus' => false,
				'show_ui'           => true,
				'capabilities'      => array( 'edit_theme_options' ),
				'query_var'         => false,
				'rewrite'           => false,
			);

            register_taxonomy( 'mezan_custom_fonts','', $args );
        }

        function admin_menu() {
            add_submenu_page( 'themes.php',
                esc_html__('DesingThemes Custom Fonts List', 'mezan-pro' ),
                esc_html__('Custom Fonts', 'mezan-pro' ),
                'edit_theme_options',
                'edit-tags.php?taxonomy=mezan_custom_fonts'
            );
        }

        function taxonomy_css() {
            global $parent_file, $submenu_file;

            if( $submenu_file == 'edit-tags.php?taxonomy=mezan_custom_fonts' ){
                $parent_file = 'themes.php';
            }

            if ( get_current_screen()->id != 'edit-mezan_custom_fonts' ) {
                return;
            }

            echo '<style>';
                echo '#addtag div.form-field.term-slug-wrap, #edittag tr.form-field.term-slug-wrap { display: none; }';
                echo '#addtag div.form-field.term-description-wrap, #edittag tr.form-field.term-description-wrap { display: none; }';
            echo '</style>';

        }

        function remove_fields( $columns ) {

            $screen = get_current_screen();

            if ( isset( $screen->base ) && 'edit-tags' == $screen->base ) {
				$old_columns = $columns;
				$columns     = array(
					'cb'   => $old_columns['cb'],
					'name' => $old_columns['name'],
				);
            }

            return $columns;
        }

		public function add_fonts_to_allowed_mimes( $mimes ) {
			$mimes['woff']  = 'application/x-font-woff';
			$mimes['woff2'] = 'application/x-font-woff2';
			$mimes['ttf']   = 'application/x-font-ttf';
			$mimes['eot']   = 'application/vnd.ms-fontobject';
			$mimes['otf']   = 'font/otf';

			return $mimes;
        }

		public function update_mime_types( $defaults, $file, $filename ) {
			if ( 'ttf' === pathinfo( $filename, PATHINFO_EXTENSION ) ) {
				$defaults['type'] = 'application/x-font-ttf';
				$defaults['ext']  = 'ttf';
			}

			if ( 'otf' === pathinfo( $filename, PATHINFO_EXTENSION ) ) {
				$defaults['type'] = 'application/x-font-otf';
				$defaults['ext']  = 'otf';
			}

			return $defaults;
		}

        function register_fields( $options ) {

            $options[] = array(
                'id'       => '_mezan_custom_font_options',
                'taxonomy' => 'mezan_custom_fonts',
                'fields'   => array(
                    array(
                        'id'       => 'woff',
                        'type'     => 'upload',
                        'title'    => esc_html__('Font .woff', 'mezan-pro' ),
                        'settings' => array(
                            'upload_type'  => 'application/x-font-woff',
                            'button_title' => esc_html__('Upload .woff file', 'mezan-pro' ),
                            'frame_title'  => esc_html__('Choose .woff font file', 'mezan-pro' ),
                            'insert_title' => esc_html__('Use File', 'mezan-pro' ),
                        )
                    ),
                    array(
                        'id'       => 'woff2',
                        'type'     => 'upload',
                        'title'    => esc_html__('Font .woff2', 'mezan-pro' ),
                        'settings' => array(
                            'upload_type'  => 'application/x-font-woff2',
                            'button_title' => esc_html__('Upload .woff2 file', 'mezan-pro' ),
                            'frame_title'  => esc_html__('Choose .woff2 font file', 'mezan-pro' ),
                            'insert_title' => esc_html__('Use File', 'mezan-pro' ),
                        )
                    ),
                    array(
                        'id'       => 'ttf',
                        'type'     => 'upload',
                        'title'    => esc_html__('Font .ttf', 'mezan-pro' ),
                        'settings' => array(
                            'upload_type'  => 'application/x-font-ttf',
                            'button_title' => esc_html__('Upload .ttf file', 'mezan-pro' ),
                            'frame_title'  => esc_html__('Choose .ttf font file', 'mezan-pro' ),
                            'insert_title' => esc_html__('Use File', 'mezan-pro' ),
                        )
                    ),
                    array(
                        'id'       => 'svg',
                        'type'     => 'upload',
                        'title'    => esc_html__('Font .svg', 'mezan-pro' ),
                        'settings' => array(
                            'upload_type'  => 'image/svg+xml',
                            'button_title' => esc_html__('Upload .svg file', 'mezan-pro' ),
                            'frame_title'  => esc_html__('Choose .svg font file', 'mezan-pro' ),
                            'insert_title' => esc_html__('Use File', 'mezan-pro' ),
                        )
                    ),
                    array(
                        'id'       => 'otf',
                        'type'     => 'upload',
                        'title'    => esc_html__('Font .otf', 'mezan-pro' ),
                        'settings' => array(
                            'upload_type'  => 'application/x-font-otf',
                            'button_title' => esc_html__('Upload .otf file', 'mezan-pro' ),
                            'frame_title'  => esc_html__('Choose .otf font file', 'mezan-pro' ),
                            'insert_title' => esc_html__('Use File', 'mezan-pro' ),
                        )
                    ),
                    array(
                        'id'      => 'display',
                        'type'    => 'select',
                        'title'   => esc_html__('Font Display', 'mezan-pro' ),
                        'options' => array(
                            'auto'     => esc_html__('Auto','mezan-pro'),
                            'block'    => esc_html__('Block','mezan-pro'),
                            'swap'     => esc_html__('Swap','mezan-pro'),
                            'fallback' => esc_html__('Fallback','mezan-pro'),
                            'optional' => esc_html__('Optional','mezan-pro'),
                        ),
                    )
                )
            );

            return $options;
        }
    }
}

MezanProTaxonomyCustomFont::instance();