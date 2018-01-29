<?php
/*
 * Template Name: Archives page
 */
get_header(); ?>
<div class="single">
    <div class="container">
        <main>
            <h1 class="single__title">Archives</h1>
            <div class="accordion-container">
                <div class="set">
                    <a href="#">LATEST POSTS<svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?= get_template_directory_uri(); ?>/assets/img/sprite.svg#ico-angle-down"></use></svg>
                    </a>
                    <div class="content">
                        <?php $recent_post = wp_get_recent_posts(array(
                            'numberposts'   => 10,
                            'post_status'   => 'publish'
                        ), OBJECT); ?>
                        <ul class="archive month-archive">
                            <?php foreach($recent_post as $post) : ?>
                                <li><a href="<?php the_permalink($post->ID); ?>"><?= $post->post_title ?></a></li>
                            <?php endforeach; unset($recent_post); ?>
                        </ul>
                    </div>
                </div>
                <div class="set">
                    <a href="#">
                        ARCHIVES BY MONTH
                        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?= get_template_directory_uri(); ?>/assets/img/sprite.svg#ico-angle-down"></use></svg>
                    </a>
                    <div class="content">
                        <ul class="archive month-archive">
                            <?php wp_get_archives(array(
                            'type'            => 'monthly',
                            'show_post_count' => true,
                            'post_type'       => 'post'
                            )); ?>
                        </ul>
                    </div>
                </div>
                <div class="set">
                    <a href="#">
                        ARCHIVES BY YEAR
                        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?= get_template_directory_uri(); ?>/assets/img/sprite.svg#ico-angle-down"></use></svg>
                    </a>
                    <div class="content">
                        <ul class="archive month-archive">
                            <?php wp_get_archives(array(
                                'type'            => 'yearly',
                                'show_post_count' => true,
                                'post_type'       => 'post'
                            )); ?>
                        </ul>
                    </div>
                </div>
                <div class="set">
                    <a href="#">
                        CATEGORIES
                        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?= get_template_directory_uri(); ?>/assets/img/sprite.svg#ico-angle-down"></use></svg>
                    </a>
                    <div class="content">
                        <ul class="archive month-archive">
                            <?php $categories = get_terms(array(
                                'taxonomy'  => array('category'),
                                'number'    => 10,
                                'order'     => 'DESC',
                                'orderby'   => 'count',
                                'count'     => true
                            ));
                            foreach ($categories as $cat) : ?>
                                <li><a href="<?= get_term_link($cat->term_id); ?>"><?= $cat->name; ?></a> [<?= $cat->count; ?>]</li>
                            <?php endforeach; unset($categories); ?>
                        </ul>
                    </div>
                </div>
                <div class="set">
                    <a href="#">
                        AUTHORS
                        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?= get_template_directory_uri(); ?>/assets/img/sprite.svg#ico-angle-down"></use></svg>
                    </a>
                    <div class="content">
                        <ul class="archive month-archive">
                            <?= wp_list_authors( array(
                                'show_fullname' => 1,
                                'optioncount'   => 1,
                                'orderby'       => 'post_count',
                                'order'         => 'DESC',
                                'exclude_admin' => false,
                                'number'        => 10
                            ));
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?php get_footer(); ?>