<?php
    if (is_category()) {
        if (isset($_COOKIE['email'])) {
            $ahref = 'https://essays.paragraphica.com/fast-signup?email=' . $_COOKIE['email'] . '&utm_source=paragraphica.com&utm_campaign=category_page&utm_medium=R&utm_term=order_now&utm_content=fast-signup';
        } else {
            $ahref = 'https://essays.paragraphica.com/?login-first=1&utm_source=paragraphica.com&utm_campaign=category_page&utm_medium=R&utm_term=order_now&utm_content=login-first';
        }

        ?>

            <article class="post-content category__cta">
                <div class="category__cta-top-title">Can’t Find The Essay You Need?</div>
                <div class="category__cta-title">
                    Get your custom essay sample <br>
                    for only $13.90/page
                </div>
                <div class="category__cta-btn-wrap">
                    <a class="cta__btn" href="<?= $ahref ?>" rel="nofollow"  onclick="ga('send', 'event', 'CTA', 'click', 'category topic');">Write My Essay</a>
                </div>
            </article>

<?php

    } elseif (is_search() || is_404()) {
        if (is_search()) {
            if (isset($_COOKIE['email'])) {
                $ahref = 'https://essays.paragraphica.com/fast-signup?email=' . $_COOKIE['email'] . '&utm_source=paragraphica.com&utm_campaign=search_page&utm_medium=R&utm_term=order_now&utm_content=fast-signup';
            } else {
                $ahref = 'https://essays.paragraphica.com/?login-first=1&utm_source=paragraphica.com&utm_campaign=search_page&utm_medium=R&utm_term=order_now&utm_content=login-first';
            }
            $ga_btn = 'search page';
        }
        if (is_404()) {
            if (isset($_COOKIE['email'])) {
                $ahref = 'https://essays.paragraphica.com/fast-signup?email='.$_COOKIE['email'].'&utm_source=paragraphica.com&utm_campaign=404_page&utm_medium=R&utm_term=order_now&utm_content=fast-signup';
            } else {
                $ahref = 'https://essays.paragraphica.com/?login-first=1&utm_source=paragraphica.com&utm_campaign=404_page&utm_medium=R&utm_term=order_now&utm_content=login-first';
            }
            $ga_btn = '404 page';
        }
?>
        <article class="post-content category__cta">
            <div class="category__cta-top-title">Can’t Find The Essay You Need?</div>
            <div class="category__cta-title">
                Get your custom essay sample <br>
                for only $13.90/page
            </div>
            <div class="category__cta-btn-wrap">
                <a class="cta__btn" href="<?= $ahref ?>" rel="nofollow" onclick="ga('send', 'event', 'CTA', 'click', '<?= $ga_btn ?>');">Write My Essay</a>
            </div>
        </article>
<?php
    }
?>