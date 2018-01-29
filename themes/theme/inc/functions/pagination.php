<?php
use theme\Icon;

// Pagination function
if (!function_exists('pagination')) {
    function pagination() {
        global  $wp_query;
        $links = paginate_links(array(
            'base'					=> str_replace(999999, '%#%', esc_url(get_pagenum_link(999999))),
            'format'				=> '?paged=%#%',
            'current'				=> max(1, get_query_var('paged')),
            'type'					=> 'array',
            'total' 				=> $wp_query->max_num_pages,
            'mid_size'				=> 1,
            'end_size'				=> 1,
            'prev_next'				=> false,
        ));
        if (is_array($links)) {
            echo '<ul class="pagination">';
            // Add double arrow if page != 1
            if (get_query_var('paged') && get_query_var('paged') != 1) {
                if(is_search()) {
                    printf('<li><a href="/?s=%s">%s</a></li>',
                        get_search_query(),             // Search words
                        Icon::get_icon('angle-double-left')   // Once arrow form html
                    );
                    printf('<li><a href="/page/%s/?s=%s">%s</a></li>',
                        get_query_var('paged') - 1,		// Current page - 1
                        get_search_query(),             // Search words
                        Icon::get_icon('angle-left')	        // Once arrow form html
                    );
                } else {
                    printf('<li><a href="%spage/1/">%s</a></li>',
                        get_pagenum_link(),             // Current url with category slug
                        Icon::get_icon('angle-double-left')       // Once arrow form html
                    );
                    printf('<li><a href="%spage/%s/">%s</a></li>',
                        get_pagenum_link(),             // Current url with category slug
                        get_query_var('paged') - 1,     // Current page - 1
                        Icon::get_icon('angle-left')          // Once arrow form html
                    );
                }
            } else {
                // Not active links if page > 1
                printf('<li class="not-active">%s</li>',
                    Icon::get_icon('angle-double-left')       // Double arrow form html
                );
                printf('<li class="not-active">%s</li>',
                    Icon::get_icon('angle-left')	            // Once arrow form html
                );
            }
            // Center links function
            foreach ($links as $link) echo strpos($link, 'current') ? "<li class='current-page'>$link</li>" : "<li>$link</li>";
            // Add double arrow if page != max paginate page
            if (get_query_var('paged') != $wp_query->max_num_pages) {
                if(is_search()) {
                    printf('<li><a href="/page/%s/?s=%s">%s</a></li>',
                        get_query_var('paged') + 1,     // Current page + 1
                        get_search_query(),             // Search words
                        Icon::get_icon('angle-right')         // Once arrow form html
                    );
                    printf('<li><a href="/page/%s/?s=%s">%s</a></li>',
                        $wp_query->max_num_pages,       // Max number page
                        get_search_query(),             // Search words
                        Icon::get_icon('angle-double-right')	// Once arrow form html
                    );
                } else {
                    printf('<li><a href="%spage/%s/">%s</a></li>',
                        get_pagenum_link(),            // Current url with category slug
                        (get_query_var('paged') === 0 ? get_query_var('paged') + 2 :  get_query_var('paged') + 1),    // Current page + 1
                        Icon::get_icon('angle-right')            // Once arrow form html
                    );
                    printf('<li><a href="%spage/%s/">%s</a></li>',
                        get_pagenum_link(),             // Current url with category slug
                        $wp_query->max_num_pages,       // Max number page
                        Icon::get_icon('angle-double-right')  // Double arrow form html
                    );
                }
            } else {
                // Not active links if page < max pagination page
                printf('<li class="not-active">%s</li>',
                    Icon::get_icon('right')           	 // Once arrow form html
                ); // Once arrow
                printf('<li class="not-active">%s</li>',
                    Icon::get_icon('double-right')       // Double arrow form html
                );
            }
            echo '</ul>';
        }
    }
}

?>