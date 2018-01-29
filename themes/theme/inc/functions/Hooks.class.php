<?php

namespace theme;

class Hooks {
	public static function init() {
        add_action('email_banner',      array(__CLASS__, 'email_banner_func'));
        add_action('fixed_banner',      array(__CLASS__, 'fixed_banner_func'));
        add_action('nocopy_popup',      array(__CLASS__, 'nocopy_popup_func'));
        add_action('nocopy_alt_popup',  array(__CLASS__, 'nocopy_alt_popup_func'));
        add_action('nocopy_check_popup',array(__CLASS__, 'nocopy_check_popup_func'));
        add_action('signup_popup',      array(__CLASS__, 'signup_popup_func'));
        add_action('exit_popup',        array(__CLASS__, 'exit_popup_func'));
        add_action('exit_popup_membership',        array(__CLASS__, 'exit_popup_membership_func'));
        add_action('chat_popup',        array(__CLASS__, 'chat_popup_func'));
        add_action('category_order',    array(__CLASS__, 'category_order_func'));
        add_action('search_order',      array(__CLASS__, 'search_order_func'));
        add_action('checker_popup',     array(__CLASS__, 'checker_popup_func'));
    }

	public static function email_banner_func() {
        if(is_404() || is_page(['50353', 'profile']) || !empty($_GET['level'])) return false;
        echo strtr(file_get_contents(__DIR__ . '/../parts/footer/cta/banner-email_form.html'),
            array(
                '#title#' => '<span>Can’t wait to take that assignment burden</span><span> off</span><span>your shoulders?</span>',
                '#description#' => 'Let us know what it is and we will show you how it can be done!',
                '#ico-angle-down#' => \theme\Icon::get_icon('angle-down'),
                '#link_text#' => 'Send'
            )
        );
    }

	public static function fixed_banner_func() {
        if(is_page(['50353', 'profile']) || !empty($_GET['level'])) return false;
        echo  strtr(file_get_contents(__DIR__ . '/../parts/footer/cta/banner-fixed.html'),
            array(
                '#text#'        => 'Haven\'t found the Essay You Want?',
                '#url#'         => 'http://essays.businessays.net/order?utm_source=businessays.net&utm_campaign=footer&utm_medium=R&utm_term=get_your_custom_essay_sample&utm_content=order',
                '#link_title#'  => 'Get your custom essay sample',
                '#price#'       => 'For Only $13.9/page'
            )
        );
    }

	public static function nocopy_popup_func() {
        echo  strtr(file_get_contents(__DIR__ . '/../parts/footer/popups/nocopy-popup.html'),
            array(
                '#text#'                => 'Sorry, but copying text is forbidden on this website. If you need this or any other sample, please register',
                '#signup_href#'         => '/account/levels/',
                '#signup_value#'        => 'Signup & Access Essays',
				'#descr#'               => 'Already on Businessays?',
				'#login_value#'         => 'Login here',
                '#footer_second_text#'  => 'No, thanks. I prefer suffering on my own'
            )
        );
    }

	public static function nocopy_check_popup_func() {
        echo  strtr(file_get_contents(__DIR__ . '/../parts/footer/popups/nocopy-check-popup.html'),
            array(
                '#text#'                => 'Sorry, but copying text is forbidden on this website. If you need this or any other sample, please register',
            )
        );
    }

	public static function nocopy_alt_popup_func() {
        echo  strtr(file_get_contents(__DIR__ . '/../parts/footer/popups/nocopy-alt-popup.html'),
            array(
                '#text#'        => 'Sorry, but copying text is forbidden on this website. If you need this or any other sample register now and get a free access to all papers, carefully proofread and edited by our experts.',
                '#url#'         => '#',
                '#link_text#'   => 'Sign in / Sign up',
                '#no_thanks#'   => 'No, thanks. I prefer suffering on my own',
            )
        );
    }

	public static function signup_popup_func() {
        echo  strtr(file_get_contents(__DIR__ . '/../parts/footer/popups/signup-popup.html'),
            array(
            	'#forgot_link#'           => wp_lostpassword_url(),
                '#fb_url#'                => \theme\FBLogin::getUrl(),
                '#fb_btn#'                => 'Sign up with Facebook',
                '#wpnonce#'               => wp_create_nonce('register_user'),
                '#wpnonce_log#'           => wp_create_nonce('login_user')
            )
        );
    }

	public static function exit_popup_func() {
        echo  strtr(file_get_contents(__DIR__ . '/../parts/footer/popups/exit-popup.html'),
            array(
                '#title#'       => 'Not quite the topic you need?',
                '#descr#'       => 'We would be happy to write it',
                '#url#'         => 'http://essays.businessays.net/order?utm_source=businessays.net&utm_campaign=exit_v2&utm_medium=R&utm_term=proceed&utm_content=order',
                '#link_text#'   => 'Join and witness the magic',
                '#avantage_1#'  => 'Service Open At All Times',
                '#avantage_2#'  => 'Complete Buyer Protection',
                '#avantage_3#'  => 'Plagiarism-Free Writing'
            )
        );
    }

    public static  function exit_popup_membership_func() {
        $levels = pmpro_getAllLevels(false, true);
        if(count($levels) > 3) :
            $month = $levels[4]->initial_payment / Levels::getDays($levels, 4);
            $name = Core::convertLevelTitle($levels[4]->name);
            $shortcode = do_shortcode($levels[4]->description);
            $payment = Core::spannedPrice($levels[4]->initial_payment, 'false', false);
            // TODO_S: HTML to template file!!!
            $content = <<<HTML
            <div class="trial">
        <h2><span>Make</span><span>a trial</span><span>run!</span></h2>
        <div class="trial__description">
          {$shortcode}
        </div>
        <div class="trial__banner">
            <div class="trial__left-col">
                <div class="trial__title">{$name}</div>
                <div class="trial__access">{$levels[4]->confirmation}</div>
            </div>
            <div class="trial__middle-col">
                <div class="trial__price">{$payment}</div>
                <div class="trial__price-refinement">{$month} / month</div>
            </div>
            <div class="trial__right-col"><a class="button custom" href="/account/checkout/?level={$levels[4]->id}">Buy now</a>
                <div class="trial__no-limit">No download limit</div>
            </div>
        </div>
    </div>
HTML;

        echo  strtr(file_get_contents(__DIR__ . '/../parts/footer/popups/exit-popup_membership.html'),
            array(
                '#content#'       => $content,
            )
        );
        endif;
    }

	public static function chat_popup_func() {
        if(is_page(['50353', 'profile']) || !empty($_GET['level'])) return false;
        echo  strtr(file_get_contents(__DIR__ . '/../parts/footer/cta/chat.html'),
            array(
                '#name#'        => 'Emily from Businessays',
                '#text#'        => 'Hi there, would you like to get such a paper? How about receiving a customized one? Check it out',
                '#url#'         => 'http://essays.businessays.net/order?utm_source=businessays.net&utm_campaign=20_second&utm_medium=R&utm_term=receiving_a_customized_one&utm_content=order',
                '#link_text#'   => 'https://goo.gl/chNgQy',
            )
        );
    }

	public static function category_order_func() {
        $ctaTitle = !ClientCountry::checkBan() ? 'on <em>"' . single_cat_title('', false) . '"</em>' : '';
        $url = 'http://essays.businessays.net/order?utm_source=businessays.net&utm_campaign=category_page&utm_medium=R&utm_term=order_now&utm_content=order';
        $text = 'Need essay sample ' . $ctaTitle . '? We will write a custom essay sample specifically for you for only <b>$13.90/page</b>';
        $button = 'Proceed';
        if (single_term_title("", false) === 'Flashcards') {
            $url = 'http://essays.businessays.net/order?utm_source=businessays.net&utm_campaign=flashcard&utm_medium=R&utm_term=order_now&utm_content=order';
            $text = 'Get full access to all ' . $ctaTitle . ' and many more!';
            $button = 'Subscribe Now';
        } elseif (is_category('qa')) {
            $url = 'http://essays.businessays.net/order?utm_source=businessays.net&utm_campaign=qa&utm_medium=R&utm_term=order_now&utm_content=order';
            $text = 'Get full access to all ' . $ctaTitle . ' and many more!';
            $button = 'Subscribe Now';
        }
		echo strtr(file_get_contents(__DIR__ . '/../parts/archive/category-order.html'),
            array(
                '#text#'        => $text,
                '#url#'         => $url,
                '#link_text#'   => $button
            )
        );
    }

    public static function search_order_func() {
        echo strtr(file_get_contents(__DIR__ . '/../parts/search/search-order.html'),
            array(
                '#text#'        => 'Need essay sample on <em>"' . get_search_query() . '"</em>? We will write a custom essay sample specifically for you for only <b>$13.90/page</b>',
                '#url#'         => 'http://essays.businessays.net/order?utm_source=businessays.net&utm_campaign=search_page&utm_medium=R&utm_term=order_now&utm_content=order',
                '#link_text#'   => 'Proceed'
            )
        );
    }

    public static function checker_popup_func() {
        echo strtr(file_get_contents(__DIR__ . '/../parts/footer/popups/checker-popup.html'),
            array(
	            '#text#'                => 'Sorry, but the plagiarism-checker is available only for our clients. If you are willing to try this option or any other available, please register',
	            '#signup_href#'         => '/account/levels/',
	            '#signup_value#'        => 'Signup & Check',
	            '#descr#'               => 'Already on Businessays?',
	            '#login_value#'         => 'Login here',
	            '#footer_second_text#'  => 'No, thanks. I prefer suffering on my own'
            )
        );
    }

}