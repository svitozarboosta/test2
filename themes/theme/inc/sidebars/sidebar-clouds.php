<?php if(is_active_sidebar('clouds_widget')) : ?>
    <div class="tagcloud">
        <h3 class="aside__header">
            <span>Most</span>
            <span>popular</span>
            <span>topics</span>
        </h3>
		<?php //dynamic_sidebar('clouds_widget'); ?>
		<?php wp_tag_cloud(); ?>
    </div>
<?php endif; ?>
