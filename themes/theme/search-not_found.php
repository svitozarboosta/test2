<div class="search-results">
    <div class="search-results__title"><?php printf('Sorry, no mathes found for <b>%s</b>', get_search_query()) ?></div>
    <div class="search-wrap-short">
        <form role="search" method="get" class="search-form form" action="/">
            <div class="form-group form-input-fields">
                <input type="search" class="search-field form-control" placeholder="What are you looking for?" value="" name="s">
                <div class="form-icon-serach">
                    <svg>
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/wp-content/themes/theme/assets/img/sprite.svg#ico-search"></use>
                    </svg>
                </div>
            </div>
            <div class="form-actions">
                <input type="submit" class="btn btn-default button" value="Search">
            </div>
        </form>
    </div>
	<?php do_action('search_order'); ?>
</div>