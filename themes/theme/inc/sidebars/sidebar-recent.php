<div class="aside__recent">
    <h3 class="aside__header">
        <span>You</span>
        <span>may</span>
        <span>like</span>
    </h3>
        <?php $recent_posts = wp_get_recent_posts(array(
	        'post_type'     => 'post' ,
            'numberposts'   => '4' ,
	        'cat'           => '-1',
            'post_status'   => 'publish'
        ), OBJECT);
        foreach($recent_posts as $post) : setup_postdata($post);?>
        <div class="aside__preview">
            <a href="<?= get_permalink(get_the_ID()); ?>"></a>
            <a href="<?= get_permalink(get_the_ID()); ?>" class="aside__title">
                <?= \theme\Icon::get_icon('document'); ?>
                <?php the_title(); ?>
            </a>
            <div class="aside__text"><?php the_excerpt(); ?></div>
             <?php
/*             <a class="aside__view" href="<?= get_permalink(get_the_ID()); ?>">*/
//                <span>View</span>
//                <?= \theme\Icon::get_icon('arrow-right');
//<!--            <span>Essay</span>-->
//<!--            </a>-->
             ?>
        </div>
        <?php
            endforeach;
            unset($recent_posts);
            wp_reset_postdata();
        ?>
</div>
