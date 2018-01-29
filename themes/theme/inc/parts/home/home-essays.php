<div class="last-essays">
    <h2><span>Last</span><span>uploaded</span><span>essays</span></h2>
    <div class="container">
		<?php
		$posts = new WP_Query(array(
			'post_type'         => 'post',
			'posts_per_page'    => 6,
            'category_name'     => 'essays'
		));
		while($posts->have_posts()) : $posts->the_post(); ?>
            <div class="last-essays__elem">
                <div class="last-essays__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <svg>
                        <use xlink:href="<?= get_template_directory_uri(); ?>/assets/img/sprite.svg#ico-document"></use>
                    </svg>
                </div>
				<?php the_category(); ?>
                <div class="last-essays__text">
					<?php the_excerpt(); ?>
                </div>
                <?php
/*                <a class="last-essays__view" href="<?php the_permalink(); ?>"><span>View</span>*/
//                    <svg>
/*                        <use xlink:href="<?= get_template_directory_uri(); ?>/assets/img/sprite.svg#ico-arrow-right"></use>*/
//                    </svg><span>Essay</span>
//                </a>
                ?>
            </div>
		<?php endwhile;
		wp_reset_query(); ?>
    </div>
    <a class="button" href="<?= get_next_posts_page_link(); ?>">Older Posts</a>
</div>
