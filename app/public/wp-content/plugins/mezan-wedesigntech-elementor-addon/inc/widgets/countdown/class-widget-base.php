<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Countdown {

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

    function __construct() {
		// Initialize depandant class
	}

    public function name() {
		return 'wdt-countdown';
	}

	public function title() {
		return esc_html__( 'Countdown', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'eicon-apps';
	}

    public function init_styles() {
		return array (
				$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/countdown/assets/css/style.css'
			);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array (
			$this->name() => WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/countdown/assets/js/script.js'
		);
	}

    public function create_elementor_controls($elementor_object) {

        $elementor_object->start_controls_section( 'wdt_section_features', array(
        'label' => esc_html__( 'Content', 'wdt-elementor-addon'),
        ) );

            $elementor_object->add_control( 'end_date', array(
                'label'       => esc_html__('End Date', 'wdt-elementor-addon'),
                'type' => \Elementor\Controls_Manager::DATE_TIME,
            ) );
          
        $elementor_object->end_controls_section();

    }

    public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}

		$output = $due_date = '';

        $due_date = strtotime( $settings['end_date'] );

		$due_date =  $settings['end_date'];
		 $output .= '<div class="wdt-countdown-holder">';
			 $output .= '<p class="wdt-countdown-label">'.esc_html__( 'Hurry up! Deals end up :', 'wdt-elementor-addon' ).'</p>';
			 $output .= '<div class="wdt-downcount" data-date="'.esc_attr( date( 'm/d/Y H:i:s', strtotime($settings['end_date'] )) ).'">';
				 $output .= '<div class="wdt-counter-wrapper">';
					$output .= '<div class="wdt-counter-inner-wrapper">';
						$output .= '<div class="wdt-counter-icon-wrapper">';
							$output .= '<div class="wdt-counter-number days">00</div>';
						$output .= '</div>';
						$output .= '<h3 class="title">'.esc_html__('Days', 'wdt-elementor-addon').'</h3>';
					$output .= '</div>';
					$output .= '<span class="wdt-counter-divider">:</span>';
				 $output .= '</div>';
				 $output .= '<div class="wdt-counter-wrapper">';
					$output .= '<div class="wdt-counter-inner-wrapper">';
						$output .= '<div class="wdt-counter-icon-wrapper">';
							$output .= '<div class="wdt-counter-number hours">00</div>';
						$output .= '</div>';
						$output .= '<h3 class="title">'.esc_html__('Hrs', 'wdt-elementor-addon').'</h3>';
					$output .= '</div>';
					$output .= '<span class="wdt-counter-divider">:</span>';
				 $output .= '</div>';
				 $output .= '<div class="wdt-counter-wrapper">';
					$output .= '<div class="wdt-counter-inner-wrapper">';
						$output .= '<div class="wdt-counter-icon-wrapper">';
							$output .= '<div class="wdt-counter-number minutes">00</div>';
						$output .= '</div>';
						$output .= '<h3 class="title">'.esc_html__('Mins', 'wdt-elementor-addon').'</h3>';
					$output .= '</div>';
					$output .= '<span class="wdt-counter-divider">:</span>';
				 $output .= '</div>';
				 $output .= '<div class="wdt-counter-wrapper last">';
					$output .= '<div class="wdt-counter-inner-wrapper">';
						$output .= '<div class="wdt-counter-icon-wrapper">';
							$output .= '<div class="wdt-counter-number seconds">00</div>';
						$output .= '</div>';
						$output .= '<h3 class="title">'.esc_html__('Secs', 'wdt-elementor-addon').'</h3>';
					$output .= '</div>';
				 $output .= '</div>';
			 $output .= '</div>';
		 $output .= '</div>';

        return $output;

	}

}

if( !function_exists( 'wedesigntech_widget_base_countdown' ) ) {
    function wedesigntech_widget_base_countdown() {
        return WeDesignTech_Widget_Base_Countdown::instance();
    }
}