<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<!-- Entry Author -->
<div class="entry-author">
    <div class="entry-author-pic">
        <?php echo get_avatar( get_the_author_meta( 'ID' ), 25 ); ?>
    </div>
    <span><?php esc_html_e('By', 'mezan-pro'); ?></span>
	<a href="<?php echo get_author_posts_url(get_the_author_meta('ID'));?>" title="<?php esc_attr_e('View all posts by ', 'mezan-pro'); echo get_the_author();?>">
		<?php echo get_the_author();?>
    </a>
</div><!-- Entry Author -->