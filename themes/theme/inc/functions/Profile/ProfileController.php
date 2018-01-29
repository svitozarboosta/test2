<?php
/**
 * Created by PhpStorm.
 * User: sergeilevchuk
 * Date: 16.06.17
 * Time: 12:00
 */

namespace theme\Profile;

require_once(__DIR__ . '/ProfileModel.php');

class ProfileController {

	public function checkMembershipLevel() {
		if (wp_get_current_user()->data->membership_level !== null) {
			return true;
		}
		return false;
	}

	public function getLevels() {
		return pmpro_getMembershipLevelsForUser();
	}

	public function getLastLevel() {
		$levels = $this->getLevels();
		return end($levels);
	}

	public function getLevelEndDate() {
		$level = $this->getLastLevel();
		if ($level->enddate) {
			$date = new \DateTime();
			$date->setTimestamp($level->enddate);
		}

		return isset($date) ? $date->format('Y.m.d:h:i:s') : false;
	}

	public function getInvoices() {
		$model = new ProfileModel();
		return $model->getInvoices();
	}

	public function getUserEmail() {
		return wp_get_current_user()->data->user_email;
	}

	public function getUserName() {
		return wp_get_current_user()->data->display_name;
	}

	public function checkPassword($pass) {
		if (!wp_check_password($pass, wp_get_current_user()->data->user_pass)) {
			wp_send_json_error('Password is not current');
		}
		return wp_check_password($pass, wp_get_current_user()->data->user_pass);
	}

	public function updatePassword($pwd, $pwd_replay) {
		if ($pwd === '' && $pwd_replay === '') {
			return true;
		}

		if ($pwd !== $pwd_replay) {
			wp_send_json_error('Passwords do not match');
		}

		wp_set_password($pwd, get_current_user_id());
		return true;
	}

	public function updateUserName($name) {
		if ($name === wp_get_current_user()->data->display_name) {
			return true;
		}

		return wp_update_user(array(
			'ID'            => get_current_user_id(),
			'display_name'  => $name
		));

	}

}