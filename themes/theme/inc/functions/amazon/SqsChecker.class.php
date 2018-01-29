<?php

namespace theme\amazon;
use Aws\Sqs\SqsClient;

/**
 * Created by PhpStorm.
 * User: sergeilevchuk
 * Date: 7/20/17
 * Time: 13:45
 */
class SqsChecker {

	private $sqsClient;
	private $sqsUrl;
	private static $_connection = null;

	public function __construct(array $arr) {
		$this->sqsUrl = $arr['url'];
		$this->sqsClient     = new SqsClient([
			'version'     => 'latest',
			'region'      => 'us-west-2',
			'credentials' => [
				'key'    => $arr['key'],
				'secret' => $arr['secret']
			]
		]);
	}

	public function run($eachCount, $msgCount) {
		for ($i = $eachCount; $i; $i--) {
			try {
				$result   = $this->sqsClient->receiveMessage([
					'QueueUrl'              => $this->sqsUrl,
					'MaxNumberOfMessages'   => $msgCount
				]);
				$messages = $result->get('Messages');
				if (is_array($messages) && $messages) {
					foreach ($messages as $message) {
						$message_body = $message['Body'];
						$emails       = $this->getBouncedEmailsFromMessage($message_body);
						foreach ($emails as $e) if (!empty($e)) $this->addBounceEmailToDB($e);
					}
					usleep(500000);
				}
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
		$this->sqsClient->purgeQueue([
			'QueueUrl' => $this->sqsUrl //'https://sqs.us-west-2.amazonaws.com/713776131248/studymoose-ses-bounce',
		]);
	}

	private static function getConnection() {
		if(is_null(self::$_connection)) {
			self::$_connection = new \wpdb('xdstudio_m', 'j89$F_aq3', 'xdstudio_m', '78.46.17.134');
			if(!empty(self::$_connection->error)) wp_die(self::$_connection->error);
		}
		return self::$_connection;
	}

	private function addBounceEmailToDB($email) {
		return $this->getConnection()->query("
			INSERT INTO `amazon_bounce`(`email`) 
			VALUES ('{$email}')
		");
	}

	public static function checkBouncedEmail($email) {
		return self::getConnection()->get_row("
			SELECT `id` 
			FROM `amazon_bounce`
			WHERE `email` = '{$email}'
		");
	}

//	private function addEmailToFile($email) {
//		$filename = get_template_directory() . '/bounce.yml';
//		$somecontent = "{$email}\n";
//		if (is_writable($filename)) {
//			if ( !$handle = fopen($filename, 'a')) exit;
//			if (fwrite($handle, $somecontent) === false) exit;
//			fclose($handle);
//		}
//	}
	private function getBouncedEmailsFromMessage($message) {
		$bounced_emails   = [];
		$error            = null;
		$sqs_notification = json_decode($message);

		if ($sqs_notification instanceof \stdClass) {
			$sqs_message_json = $sqs_notification->Message;
			$sqs_message      = json_decode($sqs_message_json);

			if ($sqs_message instanceof \stdClass) {
				if (property_exists($sqs_message, 'notificationType')
				    && $sqs_message->notificationType == 'Bounce'
				) {
					if (property_exists($sqs_message, 'bounce')) {
						$bounced_recipients = $sqs_message->bounce->bouncedRecipients;

						if (is_array($bounced_recipients)) {
							foreach ($bounced_recipients as $recipient) {
								$bounced_emails[] = $recipient->emailAddress;
							}
						} else {
							$error = 'Property "bounce" has data not in array format!';
						}
					} else {
						$error = 'Property "bounce" not found in message!';
					}
				}
			} else {
				$error = 'Message hasn\'t json format (Bounce check)!';
			}
		} else {
			$error = 'Notification hasn\'t json format (Bounce check)!';
		}

		if ($error) {
			throw new \Exception('Amazon SQS message error (Bounce check). ' . $error . ' Message source: ' . print_r($message, true));
		}

		return $bounced_emails;
	}

}