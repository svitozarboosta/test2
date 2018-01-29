<?php
/**
 * The template for displaying archive pages.
 *
 * 
 * Please browse readme.txt for credits and forking information
 *
 * @package cleanblog
 */

get_header(); ?>
<div class="container">
	<div class="row">
		

		<?php if ( have_posts() ) : ?>

			<div id="primary" class="col-md-8 content-area">
			<header class="archive-page-header">
				<?php						
				the_archive_title( '<h3 class="archive-page-title">', '</h3>' );
				the_archive_description ( '<div class="taxonomy-description">', '</div>' )
				?>
			</header><!-- .page-header -->
				<main id="main" class="site-main" role="main">
					<div class="article-grid-container">
						<?php /* Start the Loop */ ?>

						<?php
                            $i = 0;
                            while ( have_posts() ) : the_post(); ?>

							<?php

								if ($i == 2) get_template_part('inc/CTA/content');
								get_template_part( 'template-parts/content','excerpt');
                                $i++;
							?>

							<?php endwhile; ?>

							<?php cleanblog_posts_navigation(); ?>

						<?php else : ?>

							<?php get_template_part( 'template-parts/content', 'none' ); ?>

						<?php endif; ?>
					</div>
				</main><!-- #main -->
			</div><!-- #primary -->
							<?php get_sidebar('sidebar-1'); ?>		

		</div> <!--.row-->            
	</div><!--.container-->
	<?php get_footer(); ?>