<div class="wdt_follow_us_icons">

    <?php
        $youtube_link   = mezan_customizer_settings('youtube_link');
        $facebook_link  = mezan_customizer_settings('facebook_link');
        $instagram_link = mezan_customizer_settings('instagram_link');
    ?>
    <?php 
        if( $youtube_link != '' || $facebook_link != '' || $instagram_link != '' ) {
    ?>
    <div class="wdt_follow_us">
        <span><?php esc_html_e('Follow Us - ', 'mezan-plus'); ?></span>
        <div class="wdt-follow-icon">
            <?php if( isset($youtube_link) && $youtube_link != '' ) { ?>
                <a href="<?php echo esc_url($youtube_link); ?>"><span class="youtube"><?php esc_html_e('Yt', 'mezan-plus'); ?></span></a>
            <?php } ?>
            <?php if( isset($facebook_link) && $facebook_link != '' ) { ?>
                <a href="<?php echo esc_url($facebook_link); ?>"><span class="facebook"><?php esc_html_e('Fb', 'mezan-plus'); ?></span></a>
            <?php } ?>
            <?php if( isset($instagram_link) && $instagram_link != '' ) { ?>
                <a href="<?php echo esc_url($instagram_link); ?>"><span class="instagram"><?php esc_html_e('Ig', 'mezan-plus'); ?></span></a>
            <?php } ?>
        </div>
    </div>
    <?php 
        }
    ?>

</div>