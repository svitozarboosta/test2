<?php
// Add order banner for single page
if(!function_exists('home_testimonials_cta')) {
    add_filter('the_content', 'home_testimonials_cta');
    function home_testimonials_cta($content) {
        if (is_front_page())  {
            if (isset($_COOKIE['email'])) {
                $ahref = 'https://essays.paragraphica.com/fast-signup?email='.$_COOKIE['email'].'&utm_source=paragraphica.com&utm_campaign=testimonial&utm_medium=R&utm_term=order_now&utm_content=fast-signup';
            } else {
                $ahref = 'https://essays.paragraphica.com/?login-first=1&utm_source=paragraphica.com&utm_campaign=testimonial&utm_medium=R&utm_term=order_now&utm_content=login-first';
            }
            $content = explode('[vc_column_text]', $content);
            $content[1] .= '
                <div class="wpb_text_column wpb_content_element ">
                    <div class="wpb_wrapper test-cta">
                        <div class="pgp__testi-cta hide">
                            <div class="pgp__testi-cta-title">
                                Can’t Find The Essay<br>
                                You Need?
                            </div>
                            <div class="pgp__testi-cta-sub-title">
                                Get your custom essay sample<br>
                                for only $13.90/page</div>
                            <div class="pgp__testi-cta-btn-wrap">
                                <a class="cta__btn" href="'.$ahref.'" rel="nofollow" onclick="ga(\'send\', \'event\', \'CTA-new dis\', \'testimonials\', \'Order Now\');">Order Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            ';
            $content = implode('[vc_column_text]', $content);
            return $content;
        } else {
            return $content;
        }
    }
}