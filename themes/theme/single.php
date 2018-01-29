<?php
/**
 * The template for displaying all single posts.
 *
 * Please browse readme.txt for credits and forking information
 * @package cleanblog
 */

get_header(); ?>

<div class="container">
	<div class="row">
		<div id="primary" class="col-md-8 content-area">
			<main id="main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

				<?php if ( has_post_thumbnail() ) : ?>
				<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );?>
				<img class="single-header-img" src="<?php echo $thumb['0'];?>">
			<?php endif; ?>
			<?php get_template_part( 'template-parts/content',get_post_format()); ?>
		


		</main><!-- #main -->				

		<div>
			<?php
						// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

			if(!comments_open())

				?>
		</div>			

		<div class="post-navigation">				
			<?php cleanblog_post_navigation(); ?>
		</div>

	<?php endwhile; // End of the loop. ?>


</div><!-- #primary -->

<?php get_sidebar('sidebar-1'); ?>
</div> <!--.row-->            
</div><!--.container-->
<?php get_footer(); ?>
