<?php
	$template_args['post_ID'] = $ID;
	$template_args['post_Style'] = $Post_Style;
	$template_args = array_merge( $template_args, mezan_single_post_params() ); ?>

	<!-- Post Header -->
	<div class="post-header">

	   	<?php if( $template_args['enable_title'] ) : ?>
		        <?php mezan_template_part( 'post', 'templates/'.$Post_Style.'/parts/title', '', $template_args ); ?>
		<?php endif; ?>

	</div><!-- Post Header -->

    <?php mezan_template_part( 'post', 'templates/'.$Post_Style.'/parts/image', '', $template_args ); ?>

    <!-- Post Meta -->
    <div class="post-date-author-group">

    	<div class="post-date-comment">
			<?php mezan_template_part( 'post', 'templates/'.$Post_Style.'/parts/date', '', $template_args ); ?>

			<?php mezan_template_part( 'post', 'templates/'.$Post_Style.'/parts/comment', '', $template_args ); ?>
    	</div>

    	<div class="post-author">
		<?php mezan_template_part( 'post', 'templates/'.$Post_Style.'/parts/author', '', $template_args ); ?>
    	</div>

    </div>

    <!-- Post Dynamic -->
    <?php echo apply_filters( 'mezan_single_post_dynamic_template_part', mezan_get_template_part( 'post', 'templates/'.$Post_Style.'/parts/dynamic', '', $template_args ) ); ?><!-- Post Dynamic -->