<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * Please browse readme.txt for credits and forking information
 * @package cleanblog
 */

get_header(); ?>
<div class="container">
	<div class="row">
		<div id="primary" class="col-md-8 content-area">
			<main id="main" class="site-main" role="main">
				<article class="post-content">
					<section class="error-404 not-found">
						<header class="page-header">
							<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'cleanblog' ); ?></h1>
						</header><!-- .page-header -->

						<div class="page-content">
							<p class="text-center"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'cleanblog' ); ?></p>

							<?php get_search_form(); ?>

						</div><!-- .page-content -->
					</section><!-- .error-404 -->
				</article>

                <?php /* Start Banner */
                    get_template_part('inc/CTA/content');
                ?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar('sidebar-1'); ?>

	</div> <!--.row-->            
</div><!--.container-->
<?php get_footer(); ?>