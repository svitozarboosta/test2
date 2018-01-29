<?php get_header(); ?>
<div class="single">
	<div class="container">
		<main>
			<?php while(have_posts()) : the_post(); ?>
				<h1 class="single__title"><?php the_title(); ?></h1>
				<div class="single__content">
					<div class="single__text">
						<?php the_content(); ?>
					</div>
				</div>
			<?php endwhile; ?>
			<?php if(yarpp_get_related()) get_template_part('/inc/parts/single/single','related'); ?>
			<div class="posts-nav">
				<div class="prepost"><?php previous_post_link('%link', '<span>&lsaquo; Previous Post</span> %title'); ?></div>
				<div class="nextpost"><?php next_post_link('%link', '<span>Next post &rsaquo;</span> %title'); ?></div>
			</div>
		</main>
		<aside>
			<?php get_theme_sidebar('single'); ?>
		</aside>
	</div>
</div>
<?php get_footer(); ?>
