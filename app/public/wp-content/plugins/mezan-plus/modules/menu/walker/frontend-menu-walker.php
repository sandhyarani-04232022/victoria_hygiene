<?php
if ( ! class_exists( 'MezanPlusFrontendMenuWalker' ) ) {

	class MezanPlusFrontendMenuWalker {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
        	$this->frontend();
        }

        function frontend() {
        	add_action( 'mezan_after_main_css', array( $this, 'enqueue_css_assets' ), 20 );
        	add_action( 'mezan_before_enqueue_js', array( $this, 'enqueue_js_assets' ) );
        }

		function enqueue_css_assets() {
			wp_enqueue_style( 'dtplugin-nav-menu-animations', MEZAN_PLUS_DIR_URL . 'modules/menu/assets/css/nav-menu-animations.css', false, MEZAN_PLUS_VERSION, 'all');
			wp_enqueue_style( 'dtplugin-nav-menu', MEZAN_PLUS_DIR_URL . 'modules/menu/assets/css/nav-menu.css', false, MEZAN_PLUS_VERSION, 'all');
		}

		function enqueue_js_assets() {
			wp_enqueue_script( 'dtplugin-mega-menu', MEZAN_PLUS_DIR_URL . 'modules/menu/assets/js/mega-menu.js', array(), MEZAN_PLUS_VERSION, true );
		}
	}
}

MezanPlusFrontendMenuWalker::instance();

if( ! class_exists( 'Mezan_Walker_Nav_Menu' ) ) {

	class Mezan_Walker_Nav_Menu extends Walker_Nav_Menu {

		private $currentParent;

		public function start_lvl( &$output, $depth = 0, $args = null ) {

			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = str_repeat( $t, $depth );
            $parent = $this->currentParent;

			// Default class.
			$classes = array( 'sub-menu', 'is-hidden' );

			if(isset($parent->child_menu_animation) && !empty($parent->child_menu_animation)) {
				array_push($classes, 'animate-menu-item');
			}

			$class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			$data_animation = ( !empty($parent->child_menu_animation) ) ? ' data-animation="'.esc_attr($parent->child_menu_animation).'"' : '';

			$output .= "{$n}{$indent}<ul$class_names{$data_animation}>{$n}";
			$output .= '<li class="close-nav"><a href="javascript:void(0);"></a></li>';
			$output .= '<li class="go-back"><a href="javascript:void(0);"></a></li>';
			$output .= '<li class="see-all"></li>';
		}

		public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {

			$this->currentParent = $item;

			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}

			$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

			$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . esc_attr($item->ID);

			$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );

			$li_attrs          = array();
			$id                = apply_filters( 'nav_menu_item_id', 'menu-item-' . esc_attr($item->ID), $item, $args, $depth );
			$li_attrs['id']    = $id ? esc_attr( $id ) : '';
			$li_attrs['class'] = $class_names ? esc_attr( $class_names ) : '';

			$li_attrs = apply_filters( 'nav_menu_li_attributes', $li_attrs, $item, $args, $depth );

			$li_attributes = '';
			foreach ( $li_attrs as $attr => $value ) {
				if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
					$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$li_attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
				}
			}

			$output .= $indent . '<li'. $li_attributes . '>';

			$atts           = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target ) ? $item->target : '';
			if ( '_blank' === $item->target && empty( $item->xfn ) ) {
				$atts['rel'] = 'noopener noreferrer';
			} else {
				$atts['rel'] = $item->xfn;
			}
			$atts['href']         = ! empty( $item->url ) ? $item->url : '';
			$atts['aria-current'] = $item->current ? 'page' : '';

            // add class for icon positions
			if( !empty( $item->icon ) || !empty( $item->image ) ) {
            	$atts['class']   = ! empty( $item->icon_position ) ? 'item-has-icon icon-position-'.esc_attr($item->icon_position) : '';
            }

			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
					$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
				}
			}

			/** This filter is documented in wp-includes/post-template.php */
			$title = apply_filters( 'the_title', $item->title, $item->ID );
			$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
			$item_output = '';
			$args_object = (object) $args;
			$item_output .= isset($args_object->before) ? $args_object->before : '';	

			$item_output .= '<a' . mezan_html_output($attributes) . '>';

				if( !empty( $item->icon ) || !empty( $item->image ) ) {
					if( !empty( $item->icon ) ) {
						$item_output .= '<i class="menu-item-icon '.esc_attr($item->icon).'"></i>';
					}

					if( !empty( $item->image ) ) {
						$item_output .= '<i class="menu-item-image">';
							$item_output .= '<img src="'.esc_url( $item->image ).'" alt="'.esc_attr( 'Image', 'mezan-plus' ).'"/>';
						$item_output .= '</i>';
					}
				}
				
			$args_object = (object) $args;
			$link_before = isset($args_object->link_before) ? $args_object->link_before : '';
			$link_after = isset($args_object->link_after) ? $args_object->link_after : '';
            $item_output .= $link_before . $title . $link_after;
			

			if( !empty( $item->custom_label ) ) {
				$item_output .= '<label class="menu-custom-label '.esc_attr( $item->custom_label_type).'">';
					$item_output .= '<span>'.esc_html( $item->custom_label ).'</span>';
				$item_output .= '</label>';
			}


			$item_output .= '</a>';
			$item_output .= isset($args_object->after) ? $args_object->after : '';	

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
}