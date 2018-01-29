<?php

/**
 * Created by PhpStorm.
 * User: sergeilevchuk
 * Date: 7/14/17
 * Time: 18:01
 */
namespace theme;

class Alert {

	public function __construct($message, $status = true, $redirect_to = false) {
		@session_start();
		$this->setDataToSession($status, $message);
		if ($redirect_to) wp_redirect($redirect_to);
	}

	private function setDataToSession($status, $message) {
		$_SESSION['callback'] = [
			'success'   => $status,
			'data'      => $message
		];
	}

	public static function show() {
		if (isset($_SESSION['callback'])) {
			printf('<div id="theme-alert" class="alert alert-%1$s">%2$s</div>',
				($_SESSION['callback']['success'] ? 'success' : 'danger'),
				$_SESSION['callback']['data']
			);
			unset($_SESSION['callback']);
		}
	}

}