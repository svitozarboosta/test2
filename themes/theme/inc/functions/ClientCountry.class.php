<?php

namespace theme;


abstract class ClientCountry {

	private static $bannedCountries = ['UA', 'RU', 'KZ', 'BY', 'A1', 'A2'];

	public static function checkBan() {
		if (isset($_SERVER["HTTP_CF_IPCOUNTRY"])) {
			$userCountry = $_SERVER["HTTP_CF_IPCOUNTRY"]; // Cloud flare
		} else {
			$userCountry = geoip_country_code_by_name($_SERVER['REMOTE_ADDR']);
		}

		// For Developer mode & Dev server
		if (WP_DEBUG === true) {
			return false;
		}

		// true if banned
		return in_array($userCountry, self::$bannedCountries);
	}
}