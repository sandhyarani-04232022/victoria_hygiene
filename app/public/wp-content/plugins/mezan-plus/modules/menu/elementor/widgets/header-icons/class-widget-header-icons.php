<?php
use MezanElementor\Widgets\MezanElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;

class Elementor_Header_Icons extends MezanElementorWidgetBase {

	public function get_name() {
		return 'wdt-header-icons';
	}

	public function get_title() {
		return esc_html__( 'Header Icons', 'mezan-plus' );
	}

	public function get_icon() {
		return 'eicon-menu-bar wdt-icon';
	}

	public function get_style_depends() {
		return array( 'wdt-header-icons', 'wdt-header-carticons' );
	}

	public function get_script_depends() {
		return array( 'jquery-nicescroll', 'wdt-header-icons' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'header_icons_general_section', array(
			'label' => esc_html__( 'General', 'mezan-plus' ),
		) );

			$this->add_control( 'show_search_icon', array(
				'label'        => esc_html__( 'Show Search Icon', 'mezan-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			) );

			$this->add_control( 'search_icon_src', array(
				'label'        => esc_html__( 'Search Icon', 'mezan-plus' ),
				'type'         => Controls_Manager::ICONS,
				'default' => array(
					'value' => 'fas fa-search',
					'library' => 'fa-solid',
				),
                'condition' => array( 'show_search_icon' => 'yes' )
			) );

			$this->add_control( 'search_type', array(
				'label'       => esc_html__( 'Search Type', 'mezan-plus' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose type of search form to use.', 'mezan-plus'),
				'default'     => '',
				'options'     => array(
					''      => esc_html__( 'Default', 'mezan-plus'),
					'expand' => esc_html__( 'Expand', 'mezan-plus' ),
					'overlay' => esc_html__( 'Overlay', 'mezan-plus' )
				),
				'condition' => array( 'show_search_icon' => 'yes' )
			) );

			$this->add_control( 'show_userauthlink_icon', array(
				'label'        => esc_html__( 'Show Login / Logout Icon', 'mezan-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			) );

			$this->add_control( 'userauthlink_icon_src', array(
				'label'        => esc_html__( 'User Logged Out Icon', 'mezan-plus' ),
				'type'         => Controls_Manager::ICONS,
				'default' => array(
					'value' => 'far fa-user',
					'library' => 'fa-regular',
				),
                'condition' => array( 'show_userauthlink_icon' => 'yes' )
			) );

            $this->add_control( 'userauthlink_loggedin_icon_src', array(
				'label'        => esc_html__( 'User Logged In Icon', 'mezan-plus' ),
				'type'         => Controls_Manager::ICONS,
				'default' => array(
					'value' => 'fas fa-user',
					'library' => 'fa-solid',
				),
                'condition' => array( 'show_userauthlink_icon' => 'yes' )
			) );

			$this->add_control( 'show_cart_icon', array(
				'label'        => esc_html__( 'Show Cart Icon', 'mezan-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			) );

			$this->add_control( 'cart_icon_src', array(
				'label'        => esc_html__( 'Cart Icon', 'mezan-plus' ),
				'type'         => Controls_Manager::ICONS,
				'default' => array(
					'value' => 'fas fa-shopping-cart',
					'library' => 'fa-solid',
				),
                'condition' => array( 'show_cart_icon' => 'yes' )
			) );

			$this->add_control( 'cart_action', array(
				'label'       => esc_html__( 'Cart Action', 'mezan-plus' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose how you want to display the cart content.', 'mezan-plus'),
				'default'     => '',
				'options'     => array(
					''                    => esc_html__( 'None', 'mezan-plus'),
					'notification_widget' => esc_html__( 'Notification Widget', 'mezan-plus' ),
					'sidebar_widget'      => esc_html__( 'Sidebar Widget', 'mezan-plus' ),
				),
				'condition' => array( 'show_cart_icon' => 'yes' )
	        ) );

			$this->add_control( 'show_wishlist_icon', array(
				'label'        => esc_html__( 'Show Wishlist Icon', 'mezan-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			) );

			$this->add_control( 'wishlist_icon_src', array(
				'label'        => esc_html__( 'Wishlist Icon', 'mezan-plus' ),
				'type'         => Controls_Manager::ICONS,
				'default' => array(
					'value' => 'far fa-heart',
					'library' => 'fa-regular',
				),
                'condition' => array( 'show_wishlist_icon' => 'yes' )
			) );

            $this->add_responsive_control( 'align', array(
                'label'        => esc_html__( 'Alignment', 'mezan-plus' ),
                'type'         => Controls_Manager::CHOOSE,
                'prefix_class' => 'elementor%s-align-',
                'options'      => array(
                    'left'   => array( 'title' => esc_html__('Left','mezan-plus'), 'icon' => 'eicon-h-align-left' ),
                    'center' => array( 'title' => esc_html__('Center','mezan-plus'), 'icon' => 'eicon-h-align-center' ),
                    'right'  => array( 'title' => esc_html__('Right','mezan-plus'), 'icon' => 'eicon-h-align-right' ),
                ),
            ) );

		$this->end_controls_section();


        $this->start_controls_section( 'wdt_section_color', array(
        	'label'      => esc_html__( 'Colors', 'mezan-plus' ),
			'tab'        => Controls_Manager::TAB_STYLE,
			'show_label' => false,
		) );

			$this->add_control( 'icons_color', array(
				'label'     => esc_html__( 'Icons Color', 'mezan-plus' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '',
				'selectors' => array( '{{WRAPPER}} .wdt-header-icons-list > div.search-item a.wdt-search-icon, {{WRAPPER}} .wdt-header-icons-list > div.search-item a.wdt-search-icon > *, {{WRAPPER}} .wdt-header-icons-list-item div[class*="menu-icon"] i, {{WRAPPER}} .wdt-header-icons-list > div.wdt-header-icons-list-item .wdt-shop-menu-cart-icon' => 'color: {{VALUE}}' )
			) );

			$this->add_control( 'icons_hover_color', array(
				'label'     => esc_html__( 'Icons Hover Color', 'mezan-plus' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '',
				'selectors' => array( '{{WRAPPER}} .wdt-header-icons-list-item a:hover i, {{WRAPPER}} .wdt-header-icons-list > div.search-item a.wdt-search-icon:hover > *, {{WRAPPER}} .wdt-header-icons-list > div.wdt-header-icons-list-item .wdt-shop-menu-icon:hover .wdt-shop-menu-cart-icon' => 'color: {{VALUE}}' )
			) );

        $this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();

		$output = '';

		if( ( function_exists( 'is_woocommerce' ) && $settings['show_cart_icon'] == 'yes' ) || $settings['show_userauthlink_icon'] == 'yes' || $settings['show_search_icon'] == 'yes' ) {

			if(is_page()) {
				$output .= '<div class="woocommerce">';
			}

				$output .= '<div class="wdt-header-icons-list">';

				if( $settings['show_search_icon'] == 'yes' ) {

					if( $settings['search_type'] == 'expand' ) {
						$output .= '<div class="wdt-header-icons-list-item search-item search-expand">';
					}elseif( $settings['search_type'] == 'overlay' ) {
						$output .= '<div class="wdt-header-icons-list-item search-item search-overlay">';
					} else {
						$output .= '<div class="wdt-header-icons-list-item search-item search-default">';
					}

						$output .= '<div class="wdt-search-menu-icon">';

							$output .= '<a href="javascript:void(0)" class="wdt-search-icon"><span>';
								ob_start();
								Icons_Manager::render_icon( $settings['search_icon_src'], [ 'aria-hidden' => 'true' ] );
								$icon = ob_get_clean();
								if($settings['search_icon_src']['library'] == 'svg') {
									$output .= '<i>'.$icon.'</i>';
								} else {
									$output .= $icon;
								}
							$output .= '</span></a>';

							if( $settings['search_type'] == 'expand' || $settings['search_type'] == 'overlay' ) {

								$output .= '<div class="wdt-search-form-container">';

									ob_start();
									get_search_form();
									$output .= ob_get_clean();

									$output .= '<div class="wdt-search-form-close"></div>';

								$output .= '</div>';

							} else {

								$output .= '<div class="wdt-search-form-container show">';

									ob_start();
									get_search_form();
									$output .= ob_get_clean();

								$output .= '</div>';

							}

						$output .= '</div>';

					$output .= '</div>';

				}

				if( $settings['show_userauthlink_icon'] == 'yes' ) {

					$output .= '<div class="wdt-header-icons-list-item user-authlink-item">';

						if (is_user_logged_in()) {

							$current_user = wp_get_current_user();
							$user_info = get_userdata($current_user->ID);

                            $output .= '<div class="wdt-user-authlink-menu-icon">';
                                $output .= '<a href="'.wp_logout_url().'"><span>';
                                ob_start();
                                Icons_Manager::render_icon( $settings['userauthlink_loggedin_icon_src'], [ 'aria-hidden' => 'true' ] );
                                $icon = ob_get_clean();
                                if($settings['userauthlink_loggedin_icon_src']['library'] == 'svg') {
                                    $output .= '<i>'.$icon.'</i>';
                                } else {
                                    $output .= $icon;
                                }
                                $output .= '<span class="icotype-label">'.esc_html__('Log Out', 'mezan-plus').'</span></span></a>';
                            $output .= '</div>';

						} else {
							$output .= '<div class="wdt-user-authlink-menu-icon">';
								$output .= '<a href="'.wp_login_url(get_permalink()).'"><span>';
									ob_start();
									Icons_Manager::render_icon( $settings['userauthlink_icon_src'], [ 'aria-hidden' => 'true' ] );
									$icon = ob_get_clean();
									if($settings['userauthlink_icon_src']['library'] == 'svg') {
										$output .= '<i>'.$icon.'</i>';
									} else {
										$output .= $icon;
									}
									$output .= '<span class="icotype-label">'.esc_html__('Log In', 'mezan-plus').'</span></span></a>';
							$output .= '</div>';
						}

					$output .= '</div>';

				}

				if( function_exists( 'is_woocommerce' ) && $settings['show_cart_icon'] == 'yes' ) {

					$output .= '<div class="wdt-header-icons-list-item cart-item">';

						$output .= '<div class="wdt-shop-menu-icon">';

							$output .= '<a href="'.esc_url( wc_get_cart_url() ).'">';
								$output .= '<span class="wdt-shop-menu-icon-wrapper">';
									$output .= '<span class="wdt-shop-menu-cart-inner">';
										$output .= '<span class="wdt-shop-menu-cart-icon">';
											ob_start();
											Icons_Manager::render_icon( $settings['cart_icon_src'], [ 'aria-hidden' => 'true' ] );
											$icon = ob_get_clean();
											if($settings['cart_icon_src']['library'] == 'svg') {
												$output .= '<i>'.$icon.'</i>';
											} else {
												$output .= $icon;
											}
										$output .= '</span>';
										if (class_exists ( 'MezanPro' )) {
											$output .= '<span class="wdt-shop-menu-cart-number">0</span>';
										}
									$output .= '</span>';
									$output .= '<span class="wdt-shop-menu-cart-totals"></span>';
								$output .= '</span>';
							$output .= '</a>';

							if($settings['cart_action'] == 'notification_widget') {

								$output .= '<div class="wdt-shop-menu-cart-content-wrapper">';
									$output .= '<div class="wdt-shop-menu-cart-content">'.esc_html__('No products added!', 'mezan-plus').'</div>';
								$output .= '</div>';

								set_site_transient( 'cart_action', 'notification_widget', 12 * HOUR_IN_SECONDS );

							} else if($settings['cart_action'] == 'sidebar_widget') {

								set_site_transient( 'cart_action', 'sidebar_widget', 12 * HOUR_IN_SECONDS );

							} else {

								set_site_transient( 'cart_action', 'none', 12 * HOUR_IN_SECONDS );

							}

						$output .= '</div>';

					$output .= '</div>';

				}

				if( $settings['show_wishlist_icon'] == 'yes' ) {

					// YITH product count 
					if(class_exists('YITH_WCWL')) {
						$count = YITH_WCWL()->count_products();
						$wishlist_page_id = get_option( 'yith_wcwl_wishlist_page_id' );
						$output .= '<div class="wdt-header-icons-list-item wishlist-item">';
							$output .= '<div class="wdt-wishlist-menu-icon">';
								$output .= '<a href="'.get_permalink($wishlist_page_id).'">';
									$output .= '<span>';
										ob_start();
										Icons_Manager::render_icon( $settings['wishlist_icon_src'], [ 'aria-hidden' => 'true' ] );
										$icon = ob_get_clean();
										if($settings['wishlist_icon_src']['library'] == 'svg') {
											$output .= '<i>'.$icon.'</i>';
										} else {
											$output .= $icon;
										}
										$output .= '<span class="icotype-label">'.esc_html__('Wishlist', 'mezan-plus').'</span>';
										$output .= '<span class="wdt-wishlist-count"> '.esc_html($count).'</span>';
									$output .= '</span>';
								$output .= '</a>';
							$output .= '</div>';
						$output .= '</div>';
					}

				}

				$output .= '</div>';

			if(is_page()) {
				$output .= '</div>';
			}

			global $post;
			if( get_option( 'yith_wcwl_wishlist_page_id' ) != $post->ID ) {
				wp_enqueue_style( 'elementor-icons-fa-regular' );
				wp_enqueue_style( 'elementor-icons-fa-solid' );
				wp_enqueue_style( 'elementor-icons-fa-brands' );
			}

		}

		echo mezan_html_output($output);

	}

}
