<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MezanProAuth' ) ) {

	class MezanProAuth {
		
		private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
			add_filter ( 'theme_page_templates', array( $this, 'mezan_auth_template_attribute' ) );
			add_filter ( 'template_include', array( $this, 'mezan_registration_template' ) );

			$this->load_modules();
			$this->frontend();

			add_action('wp_ajax_mezan_pro_register_user_front_end', array( $this, 'mezan_pro_register_user_front_end', 0 ) );
			add_action('wp_ajax_nopriv_mezan_pro_register_user_front_end', array( $this, 'mezan_pro_register_user_front_end' ) );

        }

		/**
		 * Add Custom Templates to page template array
		*/
		function mezan_auth_template_attribute($templates) {
			$templates = array_merge($templates, array(
				'tpl-registration.php' => esc_html__('Registration Page Template', 'mezan-pro') ,
			));
			return $templates;
		}

		/**
		 * Include Custom Templates page from plugin
		*/
		function mezan_registration_template($template){

			global $post;
			$id = get_the_ID();
			$file = get_post_meta($id, '_wp_page_template', true);
			if ('tpl-registration.php' == $file){
				$template = MEZAN_PRO_DIR_PATH . 'modules/auth/templates/tpl-registration.php';
			}
			return $template;

		}

		function load_modules() {
			include_once MEZAN_PRO_DIR_PATH.'modules/auth/customizer/index.php';
		}

		function frontend() {
			add_action( 'mezan_after_main_css', array( $this, 'enqueue_css_assets' ), 30 );
			add_action( 'mezan_before_enqueue_js', array( $this, 'enqueue_js_assets' ) );
		}

		function enqueue_css_assets() {
			wp_enqueue_style( 'mezan-pro-auth', MEZAN_PRO_DIR_URL . 'modules/auth/assets/css/style.css', false, MEZAN_PRO_VERSION, 'all');
		}

		function enqueue_js_assets() {
			wp_enqueue_script( 'mezan-pro-auth', MEZAN_PRO_DIR_URL . 'modules/auth/assets/js/script.js', array(), MEZAN_PRO_VERSION, true );
		}

		/**
		 * User Registration Save Data
		 */

		function mezan_pro_register_user_front_end() {

			$first_name = isset( $_POST['first_name'] ) ? mezan_sanitization($_POST['first_name']) : '';
			$last_name  = isset( $_POST['last_name'] )  ? mezan_sanitization($_POST['last_name'])  : '';
			$password   = isset( $_POST['password'] )   ? mezan_sanitization($_POST['password'] )  : '';
			$user_name  = isset( $_POST['user_name'] )  ? mezan_sanitization($_POST['user_name'])  : '';
			$user_email = isset( $_POST['user_email'] ) ? mezan_sanitization($_POST['user_email']) : '';

			$user = array(
				'user_login'  =>  $user_name,
				'user_email'  =>  $user_email,
				'user_pass'   =>  $password,
				'first_name'  =>  $first_name,
				'last_name'   =>  $last_name
			);

			$result = wp_insert_user( $user );
			if (!is_wp_error($result)) {
				echo 'Your registration is completed successfully! To get your credential please check you mail!.';
				$mezan_to = $user_email;
				$mezan_subject = 'Welcome to Our Website';

			   // Email content
			   $mezan_body =  "Hello $user_name, <br><br>";
			   $mezan_body .= "Welcome to our website! Here are your account details: <br>";
			   $mezan_body .= "Username: $user_name <br>";
			   $mezan_body .= "Password: $password <br>";
			   $mezan_body .= "Please log in using this information and consider changing your password for security reasons. <br><br>";
			   $mezan_body .= "Thank you for joining us! <br>";
			   $mezan_body .= "Best regards, <br>";
			   $mezan_body .= get_site_url();
			   $mezan_headers = array('Content-Type: text/html; charset=UTF-8');

				wp_mail($mezan_to, $mezan_subject, $mezan_body, $mezan_headers);
			} else {
				echo 'Error creating user: ' . $result->get_error_message();
			}
			exit();
		}
		
		function mezan_pro_registration_mail($user_id , $user_name , $password ) {

			$mezan_pro_user = get_userdata($user_id);
			$mezan_pro_user_email = $mezan_pro_user->mezan_pro_user_email;

			// email will send registers
			$mezan_pro_to = $mezan_pro_user_email;
			$mezan_pro_subject = "Hi";
			$mezan_pro_body = '
						<p>
						We have successfully registered you as a Student.
						Username ='.$user_name.';
						Password ='.$password .';
						</p>
			';
			$mezan_pro_headers = array('Content-Type: text/html; charset=UTF-8');
			wp_mail($mezan_pro_to, $mezan_pro_subject, $mezan_pro_body, $mezan_pro_headers);

		}

	}

	add_action( 'wp_ajax_mezan_pro_show_login_form_popup', 'mezan_pro_show_login_form_popup' );
	add_action( 'wp_ajax_nopriv_mezan_pro_show_login_form_popup', 'mezan_pro_show_login_form_popup' );
	function mezan_pro_show_login_form_popup() {
		echo mezan_pro_login_form();

		die();
	}

	// Login form
	if(!function_exists('mezan_pro_login_form')) {
		function mezan_pro_login_form() {

			$out = '<div class="mezan-pro-login-form-container">';

				$out .= '<div class="mezan-pro-login-form">';

					$out .= '<div class="mezan-pro-login-form-wrapper">';
						$out .= '<div class="mezan-pro-title mezan-pro-login-title"><h2><span class="mezan-pro-login-title"><strong>'.esc_html__('Create Your Account', 'mezan-pro').'</strong></span></h2>
							<span class="mezan-pro-login-description">'.esc_html__('Please enter your login credentials to access your account.', 'mezan-pro').'</span></div>';
							
								$enable_auth_logo = (mezan_customizer_settings( 'enable_auth_logo' ) !== null) && !empty(mezan_customizer_settings( 'enable_auth_logo' )) ? mezan_customizer_settings( 'enable_auth_logo' ) : 0;
								if($enable_auth_logo){
									$out .= '<div class="login-form-custom-logo">'; 
										$out .= '<img class="pre_loader_image" alt="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" src="'.mezan_customizer_settings('enable_auth_logo').'"/>';
									$out .= '</div>';
								}
								
						$social_logins = (mezan_customizer_settings( 'enable_social_logins' ) !== null) && !empty(mezan_customizer_settings( 'enable_social_logins' )) ? mezan_customizer_settings( 'enable_social_logins' ) : 0;
						$enable_facebook_login = (mezan_customizer_settings( 'enable_facebook_login' ) !== null) && !empty(mezan_customizer_settings( 'enable_facebook_login' )) ? mezan_customizer_settings( 'enable_facebook_login' ) : 0;
						$facebook_app_id = (mezan_customizer_settings( 'facebook_app_id' ) !== null) && !empty(mezan_customizer_settings( 'facebook_app_id' )) ? mezan_customizer_settings( 'facebook_app_id' ) : '';
						$facebook_app_secret = (mezan_customizer_settings( 'facebook_app_secret' ) !== null) && !empty(mezan_customizer_settings( 'facebook_app_secret' )) ? mezan_customizer_settings( 'facebook_app_secret' ) : '';
						$enable_google_login = (mezan_customizer_settings( 'enable_google_login' ) !== null) && !empty( mezan_customizer_settings( 'enable_google_login' ) ) ? mezan_customizer_settings( 'enable_google_login' ) : 0;

						if( $social_logins ) {
							if( $enable_google_login ) {
								$out .= '<div class="mezan-pro-social-google-logins-container">';
									if($enable_google_login) {
										$out .= '<a href="'.mezan_pro_google_login_url().'" class="mezan-pro-social-google-connect"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">

										<g>
											<path class="google-color-1" d="M95,51.1c0-3.1-0.3-6.3-0.8-9.3H50.9v17.7h24.8c-1,5.7-4.3,10.7-9.2,13.9l14.8,11.5C90,76.8,95,65,95,51.1   L95,51.1z"/>
											<path class="google-color-2" d="M50.9,95.9c12.4,0,22.8-4.1,30.4-11.1L66.5,73.4c-4.1,2.8-9.4,4.4-15.6,4.4c-12,0-22.1-8.1-25.8-18.9L9.9,70.6   C17.7,86.1,33.5,95.9,50.9,95.9z"/>
											<path class="google-color-3" d="M25.1,58.8c-1.9-5.7-1.9-11.9,0-17.6L9.9,29.4c-6.5,13-6.5,28.3,0,41.2L25.1,58.8z"/>
											<path class="google-color-4" d="M50.9,22.3c6.5-0.1,12.9,2.4,17.6,6.9L81.6,16C73.3,8.2,62.3,4,50.9,4.1c-17.4,0-33.2,9.8-41,25.3l15.2,11.8   C28.8,30.3,38.9,22.3,50.9,22.3z"/>
										</g>
										</svg></i>'.esc_html__('Google', 'mezan-pro').'</a>';
									}
									$out .= '<div class="mezan-pro-social-logins-divider">'.esc_html__('Or', 'mezan-pro').'</div>';
								$out .= '</div>';
		
							}
						}
						$out .= '<div class="mezan-pro-login-form-holder">';

						$is_admin = is_admin() || is_super_admin();
						$redirect_url = $is_admin ? admin_url() : home_url();
						$my_login_args = apply_filters( 'login_form_defaults', array(
							'echo'           => false,
							'redirect'       => wp_login_url( $redirect_url ),
							'form_id'        => 'loginform',
							'label_username' => '',
							'label_password' => '',
							'label_remember' => esc_html__( 'Remember Me' ),
							'label_log_in'   => esc_html__( 'Sign In' ),
							'id_username'    => 'user_login',
							'id_password'    => 'user_pass',
							'id_remember'    => 'rememberme',
							'id_submit'      => 'wp-submit',
							'remember'       => true,
							'value_username' => NULL,
							'value_remember' => false
						) );

							$out .= wp_login_form( $my_login_args );
							$out .= '<p class="tpl-forget-pwd"><a href="'.wp_lostpassword_url( get_permalink() ).'">'.esc_html__('Forgot password ?','mezan-pro').'</a></p>';

						$out .= '</div>';

						if( $social_logins ) {
							$out .= '<div class="mezan-pro-social-logins-divider">'.esc_html__('Or', 'mezan-pro').'</div>';
							if( $enable_facebook_login ) {
								$out .= '<div class="mezan-pro-social-facebook-logins-container">';
									if($enable_facebook_login) {
										if(!session_id()) {
											session_start();
										}

										include_once MEZAN_PRO_DIR_PATH.'modules/auth/apis/facebook/Facebook/autoload.php';

										$appId     = $facebook_app_id; //Facebook App ID
										$appSecret = $facebook_app_secret; // Facebook App Secret
		
										$fb = new Facebook\Facebook([
											'app_id' => $appId,
											'app_secret' => $appSecret,
											'default_graph_version' => 'v2.10',
										]);
		
										$helper = $fb->getRedirectLoginHelper();
										$permissions = ['email'];
										$loginUrl = $helper->getLoginUrl( site_url('wp-login.php') . '?dtLMSFacebookLogin=1', $permissions);
		
										$out .= '<a href="'.htmlspecialchars($loginUrl).'" class="mezan-pro-social-facebook-connect"><i class="fab fa-facebook-f"></i>'.esc_html__('Facebook', 'mezan-pro').'</a>';
									}
								$out .= '</div>';
		
							}
						}

					$out .= '</div>';
				$out .= '</div>';

			$out .= '</div>';

			$out .= '<div class="mezan-pro-login-form-overlay"></div>';

			return $out;

		}
	}

	/* ---------------------------------------------------------------------------
	* Google login utils
	* --------------------------------------------------------------------------- */

	if( !function_exists( 'mezan_pro_google_login_url' ) ) {
		function mezan_pro_google_login_url() {
			return site_url('wp-login.php') . '?dtLMSGoogleLogin=1';
		}
	}

	function mezan_pro_google_login() {

		$dtLMSGoogleLogin = isset($_REQUEST['dtLMSGoogleLogin']) ? mezan_sanitization($_REQUEST['dtLMSGoogleLogin']) : '';
		if ($dtLMSGoogleLogin == '1') {
			mezan_pro_google_login_action();
		}
	
	}
	add_action('login_init', 'mezan_pro_google_login');

	if( !function_exists('mezan_pro_google_login_action') ) {
		function mezan_pro_google_login_action() {

			require_once MEZAN_PRO_DIR_URL.'modules/auth/apis/google/Google_Client.php';
			require_once MEZAN_PRO_DIR_URL.'modules/auth/apis/google/contrib/Google_Oauth2Service.php';
			
			$google_client_id = (mezan_customizer_settings( 'google_client_id' ) !== null) && !empty(mezan_customizer_settings( 'google_client_id' )) ? mezan_customizer_settings( 'google_client_id' ) : '';
			$google_client_secret = (mezan_customizer_settings( 'google_client_secret' ) !== null) && !empty(mezan_customizer_settings( 'google_client_secret' )) ? mezan_customizer_settings( 'google_client_secret' ) : '';

			$clientId     = $google_client_id; //Google CLIENT ID
			$clientSecret = $google_client_secret; //Google CLIENT SECRET
			$redirectUrl  = mezan_pro_google_login_url();  //return url (url to script)
		
			$gClient = new Google_Client();
			$gClient->setApplicationName(esc_html__('Login To Website', 'mezan-pro'));
			$gClient->setClientId($clientId);
			$gClient->setClientSecret($clientSecret);
			$gClient->setRedirectUri($redirectUrl);
		
			$google_oauthV2 = new Google_Oauth2Service($gClient);
		
			if(isset($google_oauthV2)){
		
				$gClient->authenticate();
				$_SESSION['token'] = $gClient->getAccessToken();
		
				if (isset($_SESSION['token'])) {
					$gClient->setAccessToken($_SESSION['token']);
				}
		
				$user_profile = $google_oauthV2->userinfo->get();
		
				$args = array(
					'meta_key'     => 'google_id',
					'meta_value'   => $user_profile['id'],
					'meta_compare' => '=',
				 );
				$users = get_users( $args );
		
				if(is_array($users) && !empty($users)) {
					$ID = $users[0]->data->ID;
				} else {
					$ID = NULL;
				}
		
				if ($ID == NULL) {
		
					if (!isset($user_profile['email'])) {
						$user_profile['email'] = $user_profile['id'] . '@gmail.com';
					}
		
					$random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
		
					$username = strtolower($user_profile['name']);
					$username = trim(str_replace(' ', '', $username));
		
					$sanitized_user_login = sanitize_user('google-'.$username);
		
					if (!validate_username($sanitized_user_login)) {
						$sanitized_user_login = sanitize_user('google-' . $user_profile['id']);
					}
		
					$defaul_user_name = $sanitized_user_login;
					$i = 1;
					while (username_exists($sanitized_user_login)) {
					  $sanitized_user_login = $defaul_user_name . $i;
					  $i++;
					}
		
					$ID = wp_create_user($sanitized_user_login, $random_password, $user_profile['email']);
		
					if (!is_wp_error($ID)) {
		
						wp_new_user_notification($ID, $random_password);
						$user_info = get_userdata($ID);
						wp_update_user(array(
							'ID' => $ID,
							'display_name' => $user_profile['name'],
							'first_name' => $user_profile['name'],
						));
		
						update_user_meta($ID, 'google_id', $user_profile['id']);
		
					}
		
				}
		
				// Login
				if ($ID) {
		
				  $secure_cookie = is_ssl();
				  $secure_cookie = apply_filters('secure_signon_cookie', $secure_cookie, array());
				  global $auth_secure_cookie;
		
				  $auth_secure_cookie = $secure_cookie;
				  wp_set_auth_cookie($ID, false, $secure_cookie);
				  $user_info = get_userdata($ID);
				  update_user_meta($ID, 'google_profile_picture', $user_profile['picture']);
				  do_action('wp_login', $user_info->user_login, $user_info, 10, 2);
				  update_user_meta($ID, 'google_user_access_token', $_SESSION['token']);
		
				//   wp_redirect(mezan_pro_get_login_redirect_url($user_info));
				wp_redirect(home_url());
		
				}
		
			} else {
		
				$authUrl = $gClient->createAuthUrl();
				header('Location: ' . $authUrl);
				exit;
		
			}
		
		}
	}

	/* if( !function_exists( 'mezan_pro_get_login_redirect_url' ) ) {
		function mezan_pro_get_login_redirect_url($user_info) {

			$dtlms_redirect_url = '';
			if(isset($user_info->data->ID)) {
				$current_user = $user_info;

			}

		}
	} */

}

MezanProAuth::instance();