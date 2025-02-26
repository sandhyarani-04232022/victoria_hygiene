<?php
$sidebar_class   = mezan_get_secondary_classes();
$active_sidebars = mezan_get_active_sidebars();

if( $sidebar_class == 'content-full-width' || $sidebar_class == '' ) {
    return;
}

if( empty( $active_sidebars ) ) {
    return;
}?>
<!-- Secondary -->
<section id="secondary" class="<?php echo esc_attr( $sidebar_class ); ?>"><div class="wdt-sidebar-wrapper"><?php
    do_action( 'mezan_before_single_sidebar_wrap' );

    get_sidebar();

    do_action( 'mezan_after_single_sidebar_wrap' );?>
</div></section><!-- Secondary End -->