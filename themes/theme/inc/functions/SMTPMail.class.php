<?php

namespace theme;

class SMTPMail {

    private static $user;
    private static $pass;

    public static function init($user, $pass) {
        self::$user = $user;
        self::$pass = $pass;
        add_action('phpmailer_init', array(__CLASS__, 'smtp_init'), 10, 1);
    }

    public static function smtp_init(\PHPMailer $mailer){
        $mailer->IsSMTP();
        $mailer->Host       = 'ssl://smtp.yandex.ru';
        $mailer->Port       = 465;
        $mailer->SMTPAuth   = true;
        $mailer->SMTPDebug  = 0;                // Debug mode is number 2
        $mailer->Username   = self::$user;
        $mailer->Password   = self::$pass;
        $mailer->From       = self::$user;
        $mailer->FromName   = self::getSiteName();
        $mailer->CharSet    = "utf-8";
    }

    private static function getSiteName() {
        $url = get_site_url();                  // Gt site URL
        $host = array('http://', 'https://');   // Array for replace
        $url = str_replace($host, '', $url);    // Remove https or http from url
        return ucfirst($url);                   // return name without http or https and uppercase first letter
    }

}