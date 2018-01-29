<?php
/**
 * The sidebar containing the main widget area.
 *
 * Please browse readme.txt for credits and forking information
 * @package cleanblog
 */
?>

<div id="secondary" class="col-md-4 sidebar widget-area" role="complementary">
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
<div class="secondary-inner">
		<?php do_action( 'cleanblog_before_sidebar' ); ?>
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
        <?php get_template_part('inc/CTA/sidebar'); ?>
	</div><!-- #secondary .widget-area -->
<?php endif; ?>
</div>


