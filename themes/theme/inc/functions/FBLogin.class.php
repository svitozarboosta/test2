<?php

namespace theme;
require(__DIR__ . '/Facebook/autoload.php');
class FBLogin {

    private static $url;
    public static $fb;

    public static function init($fb) {
        self::$fb = $fb;
        $helper = self::$fb->getRedirectLoginHelper();
        $permissions = ['email']; // Optional permissions
        self::$url = $helper->getLoginUrl(admin_url('/admin-ajax.php') . "?action=fb_register_user&_wpnonce=" . wp_create_nonce('fb_register_user') , $permissions);

    }

    public static function getUrl() {
        return self::$url;
    }

}
