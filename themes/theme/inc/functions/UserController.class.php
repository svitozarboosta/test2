<?php

namespace theme;

use theme\amazon\MailSender;

class UserController extends Profile {

    public static function init() {
        add_action('wp_ajax_register_user',             array(__CLASS__, 'getRequest'));
        add_action('wp_ajax_nopriv_register_user',      array(__CLASS__, 'getRequest'));

        add_action('wp_ajax_fb_register_user',          array(__CLASS__, 'getFbRequest'));
        add_action('wp_ajax_nopriv_fb_register_user',   array(__CLASS__, 'getFbRequest'));

        add_action('wp_ajax_login_user',                array(__CLASS__, 'loginUser'));
        add_action('wp_ajax_nopriv_login_user',         array(__CLASS__, 'loginUser'));

	    add_action('wp_ajax_update_profile',            array(__CLASS__, 'updateProfile'));
	    add_action('wp_ajax_nopriv_update_profile',     array(__CLASS__, 'updateProfile'));
    }

    public static function getRequest() {
        if(check_ajax_referer($_REQUEST['action']) !== 1 || wp_verify_nonce($_REQUEST['_wpnonce'], $_REQUEST['action']) !== 1) exit('Error!');
        if(isset($_POST['email']) && preg_match("/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/", $_POST['email']))
            self::register_user(strtolower($_POST['email']));
        else {
        	if (isset($_POST['_redirect_to'])) new Alert('Wrong email format', false, $_POST['_redirect_to']);
        	exit('Wrong email format');
        }
    }

    public static function getFbRequest() {
        if(check_ajax_referer($_REQUEST['action']) !== 1 || wp_verify_nonce($_REQUEST['_wpnonce'], $_REQUEST['action']) !== 1) exit('Error!');

        require(__DIR__ . '/Facebook/autoload.php');
        $helper = FBLogin::$fb->getRedirectLoginHelper();
	    if (isset($_GET['state'])) {
		    $helper->getPersistentDataHandler()->set('state', $_GET['state']);
	    }
        
        try {
            $accessToken = $helper->getAccessToken();
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (! isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        $_SESSION['fb_access_token'] = (string) $accessToken->getValue();
        $response = FBLogin::$fb->get('/me?fields=name,email', $_SESSION['fb_access_token']);
        $user = $response->getGraphUser();
        $wp_user = get_user_by('email', $user->getEmail());
        if(!$wp_user) self::register_user($user->getEmail(), true);

        wp_set_current_user($wp_user->ID);
        wp_set_auth_cookie($wp_user->ID);
        update_user_meta($wp_user->ID, 'show_admin_bar_front', 'false');
        wp_redirect('/account/');

    }

    public static function register_user($email, $fb = false) {
        $user_login = strtolower(preg_replace('/[^\w\d\s]*/', '', stristr($email, '@', true)));
        $password = wp_generate_password(12, false);
        $id = wp_create_user($user_login . '_' . rand(00, 99), $password, $email);
        if(!is_wp_error($id)) {
            $content = "Login: {$email}\r\nPassword: {$password}";
            if (MailSender::send($email, 'Your password form Businessays.net ', $content)) {
	            self::setCookieToUserLogin($id);
	            if ($fb) {
	            	wp_redirect(home_url() . '/account/');
	            } else {
		            if ($_POST['_redirect_to']) new Alert('Check your email', true, $_POST['_redirect_to']);
		            wp_send_json_success(home_url() . '/account/levels/');
	            }
                exit;
            } else {
	            wp_delete_user($id);
	            if ($fb) {
		            wp_redirect('/');
	            } else {
		            if ($_POST['_redirect_to']) new Alert('Fail sending password. Try again', false, $_POST['_redirect_to']);
		            wp_send_json('Fail sending password. Try again.');
	            }
            }

        } else {
            foreach($id->errors as $error => $val) {
	            if ($_POST['_redirect_to']) new Alert($val[0], false, $_POST['_redirect_to']);
	            echo $val[0];
            }
        }
        exit;
    }

    public static function loginUser() {
	    if(check_ajax_referer($_REQUEST['action']) !== 1 || wp_verify_nonce($_REQUEST['_wpnonce'], $_REQUEST['action']) !== 1) exit('Error!');

	    $user = array();
	    $user['user_login'] = $_POST['log'];
	    $user['user_password'] = $_POST['pwd'];
	    $user['remember'] = false;

	    $user = wp_signon($user, false);

	    if (is_wp_error($user)) {
		    if ($_POST['_redirect_to']) new Alert('Wrong email or password.', false, $_POST['_redirect_to']);
		    wp_send_json_error('Wrong email or password.');
	    }
	    wp_send_json_success('/levels/');
    }

    public static function updateProfile() {
	    if(check_ajax_referer($_REQUEST['action']) !== 1 || wp_verify_nonce($_REQUEST['_wpnonce'], $_REQUEST['action']) !== 1) exit('Error!');

	    if (
	    	self::checkPassword($_POST['pwd'])
	        &&
		    self::updateUserName($_POST['name'])
	    	&&
		    self::updatePassword($_POST['new_pwd'], $_POST['new_pwd_replay'])
	    ) {
		    if ($_POST['_redirect_to']) new Alert('Profile updated.', true, $_POST['_redirect_to']);
		    wp_send_json_success('Profile updated.');
	    }

	    exit;
    }

	private function setCookieToUserLogin($id) {
		wp_set_current_user($id);
		wp_set_auth_cookie($id);
		update_user_meta($id, 'show_admin_bar_front', 'false');
	}

}