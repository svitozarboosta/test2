<div class="slider">
    <h2><span>Our Customers</span><span>About</span><span>Their Experience</span></h2>
    <div class="container" id="slider">
        <?php
            $sliders = new WP_Query(array(
                'post_type'  => 'slider'
            ));
            while($sliders->have_posts()) : $sliders->the_post(); ?>
            <div class="slider__elem">
                <div class="slider__quote"><?= get_the_content(); ?></div>
                <div class="slider__sign">
                    <div class="slider__name"><?php the_title(); ?></div>
                    <div class="slider__position"><?= get_post_meta(get_the_ID(), 'slider_position', true); ?></div>
                    <div class="slider__country"><?= get_post_meta(get_the_ID(), 'slider_country', true); ?></div>
                </div>
                <svg>
                    <use xlink:href="<?= get_template_directory_uri(); ?>/assets/img/sprite.svg#ico-serpantino"></use>
                </svg>
            </div>
        <?php endwhile; wp_reset_query(); ?>
    </div>
</div>