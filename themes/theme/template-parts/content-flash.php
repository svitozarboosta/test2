<?php
/**
 * The template used for displaying page content in page.php
 *
 * Please browse readme.txt for credits and forking information
 * @package cleanblog
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-content'); ?>>

	<?php cleanblog_featured_image_disaplay(); ?>

	<header class="entry-header">
		<span class="screen-reader-text"><?php the_title();?></span>
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta"></div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	
	<div class="entry-content">
        <div class="pgp-flashcards__single">

            <?php the_content(); ?>

        </div>

	</div><!-- .entry-content -->



</article><!-- #post-## -->

