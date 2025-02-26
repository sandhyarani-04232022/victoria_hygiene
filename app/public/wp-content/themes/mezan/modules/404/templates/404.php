<?php
    if( isset( $enable_404message ) && ( $enable_404message == 1 || $enable_404message == true )  ) {
        $class = $notfound_style;
        $class .= ( isset( $notfound_darkbg ) && ( $notfound_darkbg == 1 ) ) ? " wdt-dark-bg" :"";
    ?>
    <div class="wrapper <?php echo esc_attr( $class );?>">
        <div class="container">
            <div class="center-content-wrapper">
                <div class="center-content">
                    <div class="error-box square">
                        <div class="error-box-inner">
                        <img class="error-image" alt="The Page Not Found" src="<?php echo esc_url(MEZAN_ROOT_URI.'/assets/images/404.png');?>"/>
                            <h2>Oops ! The Page Not Found.</h2> 
                        </div>
                    </div>
                    <div class="wdt-hr-invisible-xsmall"></div>
                    <p><?php esc_html_e("We apologize for the inconvenience. You can use our search bar to find what you're looking for, or contact us for further assistance.", 'mezan'); ?></p>
                    <div class="wdt-hr-invisible-xsmall"></div>
                    <a class="wdt-button filled small" target="_self" href="<?php echo esc_url(home_url('/'));?>"><?php esc_html_e("Back to Home",'mezan');?></a>
                </div>
            </div>
        </div>
    </div><?php
}?>