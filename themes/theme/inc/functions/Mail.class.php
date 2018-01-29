<?php

namespace theme;

use CronMail\classes\Posts;
use theme\amazon\MailSender;
use theme\amazon\MXCheck;
use theme\amazon\SqsChecker;

class Mail {

    private static $messages;

    public static function init() {
        add_action('wp_ajax_nopriv_contact_form',   array(__CLASS__, 'contact_form_callback'));
        add_action('wp_ajax_contact_form',          array(__CLASS__, 'contact_form_callback'));

        add_action('wp_ajax_nopriv_send_essay',     array(__CLASS__, 'send_essay_callback'));
        add_action('wp_ajax_send_essay',            array(__CLASS__, 'send_essay_callback'));
    }

    public static function contact_form_callback() {
        self::checkNonce($_POST['_wpnonce'], 'contact_form');
        self::validateData($_POST);
        self::sendEmail($_POST);
        wp_die();
    }

    public static function send_essay_callback() {
        self::checkNonce($_POST['_wpnonce'], 'send_essay');
        self::validateData($_POST);

//         Check bounce email
	    if (!is_null(SqsChecker::checkBouncedEmail($_POST['email']))) wp_send_json_error('Email is bounced');

	    // Check Mail MX
//	    $mCheck = new MXCheck();
//        if (!$mCheck->execute($_POST['email'])) wp_send_json_error('Email not isset.');

        $post = get_post((int)$_POST['post_ID']);
        self::insertEmailToBase($_POST['email'], $post->post_title);
        $image      = self::getImage();
        $button     = self::getButton($_POST['email']);

	    $paypal_link = PayPal::getPayPalUrl($_POST['email'], (int)$_POST['post_ID'], $post->post_title);
		$paypal_btn = self::getPaypalButton($paypal_link);

	    $content = strtr(file_get_contents(get_template_directory() . '/inc/parts/mail/FirstEmail.html'),
            array(
                '#image#'       => $image,
                '#button#'      => $button,
                '#paypal_btn#'  => $paypal_btn
            )
        );
	    // Send first email
	    MailSender::send($_POST['email'], 'Your request for a FREE creative essay sample from BusinEssays!', $content);

//	    $sender->insertMessage($_POST['email'], 'Your request for a FREE creative essay sample from BusinEssays!', $content, 0);
        $content = strtr(file_get_contents(get_template_directory() . '/inc/parts/mail/SecondEmail.html'),
            array(
                '#image#'   => $image,
                '#button#'  => $button,
                '#email#'   => $_POST['email'],
                '#title#'   => $post->post_title,
                '#text#'    => wpautop($post->post_content)
            )
        );
        $sender = new Posts();
	    $sender->insertMessage($_POST['email'], 'Your request for a FREE creative essay sample from BusinEssays!', $content, 24 * 60);
        $content = strtr(file_get_contents(get_template_directory() . '/inc/parts/mail/ThirdEmail.html'),
            array(
                '#image#'   => $image,
                '#email#'   => $_POST['email']
            )
        );
	    $sender->insertMessage($_POST['email'], 'I\'m sure you need Help!', $content, 24 * 60 + 15);
        wp_send_json_success('Check your email.');
    }

    public static function checkNonce($nonce, $action) {
        if(!wp_verify_nonce($nonce, $action)) {
            wp_send_json_error(__('Not verificated nonce.', 'theme'));
            wp_die();
        }
    }

	public static function validateData($request) {
        $keys = array_keys($request);
        foreach($keys as $key) if($request[$key] === '') self::$messages[] = sprintf(__('Please enter: %s', 'theme'), __(ucfirst($key), 'theme'));
        if(self::$messages != null) {
            wp_send_json_error(implode('<br>', self::$messages));
            wp_die();
        } else if (!preg_match("/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/", $request['email'])) {
            wp_send_json_error(__('Wrong email format', 'theme'));
            wp_die();
        }
    }

    private static function sendEmail($data, $files = '') {
        $message = "Name: {$data['name']}\nEmail: {$data['email']}\nMessage:\n{$data['message']}";
        if(wp_mail(Cfg::getConfig('email_user'), $data['subject'], $message, '', $files)) empty($files) ? wp_send_json_success(__('Thank you for email', 'theme')) : wp_redirect('/essay-upload/?success');
        else wp_send_json_error(__('Send email failed', 'theme'));
    }

    private static function insertEmailToBase($email, $title) {
        $mysqli         = new \mysqli(
            Cfg::getConfig('sql_host'),
            Cfg::getConfig('sql_user'),
            Cfg::getConfig('sql_password'),
            Cfg::getConfig('sql_base')
        );
        $esc_mail       = mysqli_real_escape_string($mysqli, strtolower($email));
        if($mysqli->connect_errno) echo "Can't connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;

        $mysqli->query(
            sprintf(
                'INSERT IGNORE INTO emails_base SET email = "%s"',
                $esc_mail
            )
        );

        if($mysqli->insert_id) {
            $mysqli->query(
                sprintf(
                    'INSERT INTO emails_data (`date`, `email_id`, `topic`, `site`) VALUES ("%s", "%s", "%s", "businessays.net")',
                    date("d-m-Y H:i:s"),
                    $mysqli->insert_id,
                    $title
                )
            );
        } else {
            $email_id = $mysqli->query(
                sprintf(
                    'SELECT id FROM `emails_base` WHERE `email` LIKE "%s"',
                    $esc_mail
                )
            );
            $email_id = $email_id->fetch_assoc();
            $mysqli->query(
                sprintf(
                    'INSERT INTO emails_data (`date`, `email_id`, `topic`, `site`) VALUES ("%s", "%s", "%s", "businessays.net")',
                    date("d-m-Y H:i:s"),
                    $email_id['id'],
                    $title
                )
            );
        }

        $mysqli->close();
    }


	protected static function getImage() {
        return strtr(file_get_contents(get_template_directory() . '/inc/parts/mail/Image.html'),
            array(
                '#cid1#'    => rand(1200000000, 129999999),
                '#cid2#'    => rand(1400000000, 149999999)
            )
        );
    }

    protected static function getButton($email) {
        return strtr(file_get_contents(get_template_directory() . '/inc/parts/mail/Button.html'),
            array(
                '#email#' => $email
            )
        );
    }

    private static function getPaypalButton($href) {
	    return strtr(file_get_contents(get_template_directory() . '/inc/parts/mail/PaypalButton.html'),
		    array(
			    '#paypal_btn#'  => $href
		    )
	    );
    }

}