<?php

namespace theme\amazon;

/**
 * Created by PhpStorm.
 * User: sergeilevchuk
 * Date: 7/12/17
 * Time: 08:57
 */
class MailSender {

	private static $client;
	private static $email;

	public static function send($email, $subject, $message) {

		$request                                    = array();
		$request['Source']                          = self::$email;
		$request['Destination']['ToAddresses']      = array($email);
		$request['Message']['Subject']['Data']      = $subject;
		$request['Message']['Body']['Text']['Data'] = $message;
		$request['Message']['Body']['Html']['Data'] = $message;

		try {
			$result = self::$client->sendEmail($request);
			return $result->get('MessageId');
		} catch (\Exception $e) {
			return false;
		}
	}

	public function __construct() {
		self::$client = \Aws\Ses\SesClient::factory(array(
			'version'     => 'latest',
			'region'      => 'us-west-2',
			'credentials' => [
				'key'    => 'AKIAJGMKB5KSL6NBTF3A',
				'secret' => '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'
			]
		));

	}

	public function setSender($email) {
		self::$email = $email;
	}
}
