<div class="related-samples">
    <h3>
        <span>Related</span>
        <span>essay</span>
        <span>samples</span>
    </h3>
    <div class="related-samples__wrapper">
        <?php foreach(yarpp_get_related() as $related) : setup_postdata($related); ?>
            <div class="related-samples__preview">
                <a class="related-samples__title" href="<?= get_permalink($related->ID); ?>">
                    <?= \theme\Icon::get_icon('document'); ?>
                    <?= $related->post_title ?>
                </a>
                <div class="related-samples__text">
                    <?= substr(get_the_excerpt(), 0, 150) . '...'; ?>
                </div>
                <?php
/*                <a href="<?= get_permalink($related->ID); ?>" class="related-samples__view">*/
//                    <span>View</span>
//                    <?= \theme\Icon::get_icon('arrow-right');
//                <span>Essay</span>
//                </a>
                ?>
            </div>
        <?php
            endforeach;
            wp_reset_postdata();
            wp_reset_query();
        ?>
    </div>
</div>
