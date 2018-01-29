<?php
/**
 * Created by PhpStorm.
 * User: sergeilevchuk
 * Date: 7/17/17
 * Time: 09:59
 */

namespace theme;


class Validation {

	public function validName($name) {
		if (!preg_match('#^[a-zA-Z\s]{4,36}$#', $name)) {
			new Alert('Wrong name format', false);
			return false;
		}
		return true;
	}

	public function validEmail($email) {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			new Alert('Wrong email format', false);
			return false;
		}
		return true;
	}

}