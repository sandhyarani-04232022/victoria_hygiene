<?php
use MezanElementor\Widgets\MezanElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Post_Comments extends MezanElementorWidgetBase {

    public function get_name() {
        return 'wdt-post-comments';
    }

    public function get_title() {
        return esc_html__('Post - Comments', 'mezan-pro');
    }

    protected function register_controls() {

        $this->start_controls_section( 'wdt_section_general', array(
            'label' => esc_html__( 'General', 'mezan-pro'),
        ) );

            $this->add_control( 'style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Style', 'mezan-pro'),
                'default' => '',
                'options' => array(
                    ''  => esc_html__('Default', 'mezan-pro'),
                    'meta-elements-space'		 => esc_html__('Space', 'mezan-pro'),
                    'meta-elements-boxed'  		 => esc_html__('Boxed', 'mezan-pro'),
                    'meta-elements-boxed-curvy'  => esc_html__('Curvy', 'mezan-pro'),
                    'meta-elements-boxed-round'  => esc_html__('Round', 'mezan-pro'),
					'meta-elements-filled'  	 => esc_html__('Filled', 'mezan-pro'),
					'meta-elements-filled-curvy' => esc_html__('Filled Curvy', 'mezan-pro'),
					'meta-elements-filled-round' => esc_html__('Filled Round', 'mezan-pro'),
                ),
            ) );

            $this->add_control( 'el_class', array(
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__('Extra class name', 'mezan-pro'),
                'description' => esc_html__('Style particular element differently - add a class name and refer to it in custom CSS', 'mezan-pro')
            ) );

        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        extract($settings);

		$out = '';

        global $post;
        $post_id =  $post->ID;

        $Post_Style = mezan_get_single_post_style( $post_id );

		$template_args['post_ID'] = $post_id;
		$template_args['post_Style'] = $Post_Style;
        $template_args = array_merge( $template_args, mezan_single_post_params() );

		$out .= '<div class="entry-comments-wrapper '.$style.' '.$el_class.'">';
            $out .= mezan_get_template_part( 'post', 'templates/'.$Post_Style.'/parts/comment', '', $template_args );
		$out .= '</div>';

		echo $out;
	}

}