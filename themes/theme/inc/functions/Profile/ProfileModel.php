<?php

namespace theme\Profile;


class ProfileModel {

	public function getInvoices($limit = 10, $offest = 0) {
		global $wpdb;
		$userID = get_current_user_id();
		return $wpdb->get_results("
			SELECT *, UNIX_TIMESTAMP(timestamp) as timestamp 
			FROM $wpdb->pmpro_membership_orders WHERE user_id = '$userID' 
			AND status 
			NOT IN('refunded', 'review', 'token', 'error') 
			ORDER BY timestamp DESC LIMIT $offest, $limit
		");
	}

}