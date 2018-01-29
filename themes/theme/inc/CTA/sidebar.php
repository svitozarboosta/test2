<?php
echo $_COOKIE['email'];
//    set params for CTA

//set param frontpage
    if (is_front_page() || is_category()) {
        //    cta href
        if (isset($_COOKIE['email'])) {
            $ahref = 'https://essays.paragraphica.com/fast-signup?email='.$_COOKIE['email'].'&utm_source=paragraphica.com&utm_campaign=sidebar&utm_medium=R&utm_term=hire_writer&utm_content=fast-signup';
        } else {
            $ahref = 'https://essays.paragraphica.com/?login-first=1&utm_source=paragraphica.com&utm_campaign=sidebar&utm_medium=R&utm_term=hire_writer&utm_content=login-first';
        }
        $title = 'A LIMITED TIME OFFER!';
        $text  = 'Get a custom Essay sample written according to your requirements<br> URGENT 6H DELIVERY GUARANTEED';
        $button_name = 'Hire Writer';
        $cta_type = 'CTA';
        $cta_postition = 'sidebar';
        $ga_btn = 'Hire Writer';
    }
//set param single
    if (is_single()) {
        //    cta href
        if (isset($_COOKIE['email'])) {
            $ahref = 'https://essays.paragraphica.com/fast-signup?email='.$_COOKIE['email'].'&utm_source=paragraphica.com&utm_campaign=sidebar&utm_medium=R&utm_term=hire_writert&utm_content=fast-signup';
        } else {
            $ahref = 'https://essays.paragraphica.com/?login-first=1&utm_source=paragraphica.com&utm_campaign=sidebar&utm_medium=R&utm_term=hire_writer&utm_content=login-first';
        }
        $title = 'A LIMITED TIME OFFER!';
        $text  = 'Get a custom Essay sample written according to your requirements<br> URGENT 6H DELIVERY GUARANTEED';
        $button_name = 'Hire Writer ';
        $cta_type = 'CTA';
        $cta_postition = 'sidebar';
        $ga_btn = 'Hire Writer';
    }
//    output CTA
    if (is_front_page() || is_single() || is_category()) {
?>
        <aside class="widget-odd widget-last widget-3 widget__cta hidden-xs hidden-sm widget widget_text showed "> 
            <div class="pgp__sidebar-cta hidden-xs hidden-sm">
                <div class="pgp__sidebar-cta-top-title"><?= $title ?></div>
                <div class="pgp__sidebar-cta-title"><?= $text ?></div>
                <div class="pgp__sidebar-cta-btn-wrap">
                    <a class="cta__btn" href="<?= $ahref ?>" rel="nofollow" onclick="ga('send','event','<?= $cta_type ?>','<?= $cta_postition ?>','<?= $ga_btn ?>');"><?= $button_name ?></a>
                    <a class="cta__not" href="#" rel="nofollow">Not Now</a>
                </div>
            </div>
        </aside>
<?php
    }