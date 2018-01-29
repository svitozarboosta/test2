<?php
/**
 * The template for displaying search results pages.
 *
 * Please browse readme.txt for credits and forking information
 * @package cleanblog
 */

get_header(); ?>
<div class="container">
	<div class="row">
		

		<?php if ( have_posts() ) : ?>


		<section id="primary" class="col-md-8 content-area">
			<header class="search-page-header">
				<h3 class="search-page-title"><?php printf( esc_html__( 'Search Results for: %s', 'cleanblog' ), '<span>' . get_search_query() . '</span>' ); ?></h3>
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
					</div>
				</main><!-- #main -->
			</section><!-- #primary -->

		<?php else : ?>

		<section id="primary" class="col-md-8 content-area">
			<main id="main" class="site-main" role="main">
				<article class="post-content">
					<?php get_template_part( 'template-parts/content', 'none' ); ?>
				</article>
			</main><!-- #main -->
		</section><!-- #primary -->


	<?php endif; ?>

	


	<?php get_sidebar('sidebar-1'); ?>

</div> <!--.row-->            
</div><!--.container-->
<?php get_footer(); ?>
