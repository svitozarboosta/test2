<?php
//    cta href
if (isset($_COOKIE['email'])) {
    $ahref = 'https://essays.paragraphica.com/fast-signup?email='.$_COOKIE['email'].'&utm_source=paragraphica.com&utm_campaign=top_banner&utm_medium=R&utm_term=get_custom_essay_sample&utm_content=fast-signup';
} else {
    $ahref = 'https://essays.paragraphica.com/?login-first=1&utm_source=paragraphica.com&utm_campaign=top_banner&utm_medium=R&utm_term=get_custom_essay_sample&utm_content=login-first';
}
//    set params for CTA

    $title = 'Let us write you a custom essay sample';
    $text  = 'for only $13.90/page';
    $button_name = 'Get your custom essay sample';
    $button_name_2 = 'Get your essay';
    $cta_type = 'CTA';
    $cta_postition = 'top banner';
    $btn_ga = 'Get custom essay sample';

//    output CTA
    ?>
<div class="sub_header-cta clearfix head-cta-wrap" <?php if(is_single() || is_category()) {} else {echo 'style="visibility: hidden; opacity: 0;"';} ?> >
    <div class="sub_header-cta-close hidden-sm hidden-xs" id="banner-close">
        <img src="<?php echo get_template_directory_uri(); ?>/images/x.svg" alt="close">
    </div>
    
</div>
