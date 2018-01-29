<div class="search-results">
	<div class="search-results__title"><?php printf('About %s related essays samples for <b>%s</b>', $wp_query->found_posts, get_search_query()) ?></div>
	<?php
	if(have_posts()) :
		$i = get_query_var('paged') ? (get_query_var('paged') - 1) * $wp_query->query_vars['posts_per_page'] : 0; // Page number - 1 * count posts per page (5 - 1) * 3
		while(have_posts()) : the_post(); ?>
			<?php if(empty(wp_get_current_user()->membership_levels) && count_pages(get_the_content()) > 5) {
				$args['class'] = ' result--for-members';
				$args['link']   = '<a class="button open_login_form" href="/account/">Sign in / Sign up</a>';
			} else {
				$args['class'] = '';
				$args['link']   = '<a class="button" href="' . get_the_permalink() . '">Hire a writer</a>';
			}?>
			<div class="result<?= $args['class']; ?>">
				<div class="result__number"><?= ++$i; ?></div>
				<div class="result__content">
					<div class="result__title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</div>
					<div class="result__breadcrumbs">
						<?php $cats = get_the_category();
						foreach ($cats as $cat) { ?>
							<a href="<?= get_category_link($cat->term_id); ?>"><?= $cat->name; ?></a>
						<?php } ?>
					</div>
					<?php the_excerpt(); ?>
					<div class="result__footer">
						<div class="result__date"><?php the_time('j M Y'); ?></div>
						<div class="result__words"><?= count_words(get_the_content()); ?> Words</div>
						<div class="result__pages"><?= count_pages(get_the_content()); ?> Pages</div>
					</div>
				</div>
				<?= $args['link']; ?>
			</div>
		<?php endwhile; unset($i); unset($cats);
	else: ?>
		<div class="search-wrap-short">
			<form role="search" method="get" class="search-form form" action="/">
				<div class="form-group form-input-fields">
					<input type="search" class="search-field form-control" placeholder="What are you looking for?" value="" name="s">
					<div class="form-icon-serach">
						<svg>
							<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="img/sprite.svg#ico-search"></use>
						</svg>
					</div>
				</div>
				<div class="form-actions">
					<input type="submit" class="btn btn-default button" value="Search">
				</div>
			</form>
			<ul class="searching meta list-inline">
				<li>People searching:</li>
				<li>
					<a href="">Sypmtoms</a>,
				</li>
				<li>
					<a href="">Sypmtoms</a>,
				</li>
				<li>
					<a href="">Sypmtoms</a>
				</li>
			</ul>
		</div>
	<?php endif;
	pagination();
	?>
</div>