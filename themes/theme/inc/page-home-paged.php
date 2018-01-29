<?php get_header(); ?>
	<div class="category">
		<div class="category__teaser"><h1><?php single_cat_title(); ?></h1></div>
		<div class="container">
			<main>
				<?php
				$wp_query = new WP_Query(array(
					'post_type'         => 'post',
					'posts_per_page'    => 12,
					'category_name'     => 'essays',
					'paged'             => get_query_var('page')
				));
				while(have_posts()) : the_post(); ?>
					<div class="category__elem">
						<a href="<?php the_permalink(); ?>" class="category__title"><?php the_title(); ?> — Free Essay</a>
						<div class="category__text"><?php the_excerpt(); ?></div>
						<div class="category__footer">
							<div class="category__words"><?= count_words(get_the_content()); ?> Words</div>
							<div class="category__pages"><?= count_pages(get_the_content()) > 1 ? count_pages(get_the_content()) . ' Pages' : count_pages(get_the_content()) . ' Page'; ?></div>
						</div>
					</div>
				<?php endwhile; ?>
			</main>
			<aside class="sidebar">
				<?php get_theme_sidebar('archive'); ?>
			</aside>
		</div>
		<?php pagination(); ?>
	</div>
<?php get_footer(); ?>