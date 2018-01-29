<?php

namespace theme\amazon;

/**
 * Created by PhpStorm.
 * User: sergeilevchuk
 * Date: 7/14/17
 * Time: 12:02
 */
class MXCheck {
	var $timeout = 10;

	function execute ($email = "") {
		$host = substr (strstr ($email, '@'), 1);
		$host .= ".";

		if (getmxrr ($host, $mxhosts[0], $mxhosts[1]) == true)  array_multisort ($mxhosts[1], $mxhosts[0]);
		else {
			$mxhosts[0] = $host;
			$mxhosts[1] = 10;
		}

		$port = 25;
		$localhost = $_SERVER['HTTP_HOST'];
		$sender = 'info@' . $localhost;

		$result = false;
		$id = 0;
		while (!$result && $id < count ($mxhosts[0])) {
			if (function_exists ("fsockopen")) {
				if ($connection = fsockopen ($mxhosts[0][$id], $port, $errno, $error, $this->timeout)) {
					fputs ($connection,"HELO $localhost\r\n");
					$data = fgets ($connection,1024);
					$response = substr ($data,0,1);
					if ($response == '2') {
						fputs ($connection,"MAIL FROM:<$sender>\r\n");
						$data = fgets($connection,1024);
						$response = substr ($data,0,1);
						if ($response == '2')  {
							fputs ($connection,"RCPT TO:<$email>\r\n");
							$data = fgets($connection,1024);
							$response = substr ($data,0,1);
							if ($response == '2')  {
								fputs ($connection,"data\r\n");
								$data = fgets($connection,1024);
								$response = substr ($data,0,1);
								if ($response == '2')  {
									$result = true;
								}
						}
					}
				}
				fputs ($connection,"QUIT\r\n");
				fclose ($connection);
				if ($result) return true;
			}
		}
		else  break;
			$id++;
		}
		return false;
	}
}