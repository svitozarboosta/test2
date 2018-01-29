<?php

namespace theme;

class PlagiarismUploader extends ContentRepository {

	protected $_file;
	protected $_type;
	protected $_name;
	private $_content;

	const KEY = 'sLUUIxthu69JRJD';

	public function getRequest() {
		if (isset($_FILES['file']) || !empty($_FILES['file'])) $this->getRequestFile();
		if (isset($_POST['text'])  || !empty($_POST['text'])) $this->getRequestText();
		http_response_code(403);
	}

	public function getRequestText() {
		if (!isset($_POST['text']) || empty($_POST['text'])) die('No text');

		$this->_content = wp_strip_all_tags(trim($_POST['text']));
		$this->_name = substr($this->_content, 0, 15) . '...';

		$this->sendResult();
	}

	public function getRequestFile() {
		if (!isset($_FILES['file']) || empty($_FILES['file'])) die('No file');
		$this->_type = $this->checkFileType($_FILES['file']['name']);
		$this->_name = $_FILES['file']['name'];
		$this->_file = wp_handle_upload($_FILES['file'], ['test_form' => false]);
		$this->_content = wp_strip_all_tags(trim($this->getContent()));

		$this->sendResult();
	}

	private function sendResult() {
		// Check content encoding
		if (!mb_detect_encoding($this->_content)) $this->_error('Invalid file encoding');

		$this->addPost(); // insert post to base & upload
		$result = $this->getPlagiarismData();

		if (!$this->checkApiResponse($result)) $this->_error('Text is too short');

		die($result);
	}

	private function _error($message) {
		wp_send_json([
			'success'   => 0,
			'error'     => $message
		]);
	}

	private function checkApiResponse($response) {
		$checkResult = json_decode($response);
		return $checkResult->error_code === 403 ? false : true;
	}

	private function checkFileType($file) {
		$types = ['pdf', 'doc', 'docx', 'txt'];
		$type = pathinfo($file, PATHINFO_EXTENSION);
		if (in_array($type, $types) === false) $this->_error('Wrong file format');

		return $type;
	}

	private function addPost() {
		$cat = get_category_by_slug('plagiarism-checker-category');
		$args = [
			'post_title'    => rand(000000,999999) . ' - ' . $this->_name,
			'post_content'  => wp_slash($this->_content),
			'post_status'   => 'private',
			'post_author'   => 1,
			'post_category' => [$cat->term_id]
		];
		if (!empty($this->_file)) {
			$args['meta_input'] = [
				'download_link' => $this->_file['url']
			];
		}

		$postID = wp_insert_post($args, true);
		return $postID;
	}

	private function getPlagiarismData() {
		/*
		 * Function from plagiarism checker plugin
		 * OLD:
		 * $plagiarism = new \PlagiatChecker();
		 * return $plagiarism->checkTextByAjax($this->_content);
		 */
		$params = [
			'text'  => $this->_content,
			'key'   => self::KEY
		];

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		curl_setopt($curl, CURLOPT_URL, 'https://content-watch.ru/public/api/');
		$response = trim(curl_exec($curl));
		curl_close($curl);

		return $response;
	}

}