<?php
/**
 * Created by PhpStorm.
 * User: sergeilevchuk
 * Date: 29.06.17
 * Time: 14:59
 */

namespace theme;


class EssaysUpload {

	private static $_uploader = null;

	private function __construct() {}
	protected function __clone() {}

	static public function getUploader() {
		if(is_null(self::$_uploader)) {
			self::$_uploader = new self();
		}
		return self::$_uploader;
	}

	public function init() {
		add_action('delete_attachment', array($this, 'remove_uploaded_essays'));
		add_action('admin_menu',        array($this, 'add_uploaded_essays_settings'));

		add_action('wp_ajax_nopriv_upload_form',    array($this, 'upload_form_callback'));
		add_action('wp_ajax_upload_form',           array($this, 'upload_form_callback'));

		add_action('wp_ajax_nopriv_remove_post',    array($this, 'remove_post_callback'));
		add_action('wp_ajax_remove_post',           array($this, 'remove_post_callback'));
	}

	/**
	 * @BOOSTA Callback function for wp_ajax
	 * @action upload_form
	 */
	public function upload_form_callback() {
		$this::checkNonce($_POST['_wpnonce'], 'upload_form');
		$this::checkEmpty($_POST);
//
		$valid = new Validation();
		if (!$valid->validName($_POST['name'])) {
			wp_redirect('/essay-upload/');
			exit;
		}
		if (!$valid->validEmail($_POST['email'])) {
			wp_redirect('/essay-upload/');
			exit;
		}
		if ($_FILES['files']['error']) {
			new Alert('Wrong file format', false);
			wp_redirect('/essay-upload/');
			exit;
		}
		foreach ($_FILES as $file) {
			$file = wp_handle_upload($file, array('test_form' => false));
		}
		$message = htmlentities($_POST['message']);
		$content = "Name: {$_POST['name']}\r\nEmail: {$_POST['email']}\r\n\Message: \r\n{$message}";
		$attach_id  = wp_insert_attachment(array(
			'guid'           => $file['url'],
			'post_mime_type' => $file['type'],
			'post_title'     => preg_replace('/\.[^.]+$/', '', basename($file['file'])),
			'post_content'   => $content,
			'post_status'    => 'inherit'
		));
		$ids = get_option('uploaded_essays');
		if ($ids === '') {
			update_option('uploaded_essays', $attach_id);
		} else {
			$ids = explode(',', $ids);
			array_push($ids, $attach_id);
			update_option('uploaded_essays', implode(',',$ids));
		}
		new Alert('Thank you for your essay.', true);
		wp_redirect('/essay-upload/');
		exit;
	}

	public function remove_post_callback() {
		$this::checkNonce($_REQUEST['_wpnonce'], 'remove_post');
		wp_delete_attachment($_REQUEST['id']);
		wp_redirect(admin_url('admin.php?page=uploaded_essays'));
	}

	/**
	 * @BOOSTA Hook for remove essays id from options
	 */
	public function remove_uploaded_essays($post_id){
		$ids = get_option('uploaded_essays');
		$ids = explode(',', $ids);
		$search = array_search($post_id, $ids);
		if (!$search) return $post_id;

		unset($ids[$search]);
		update_option('uploaded_essays', implode(',',$ids));
	}

	public function add_uploaded_essays_settings() {
		add_menu_page(
			'Uploaded Essays',
			'Uploaded essays',
			'manage_options',
			'uploaded_essays',
			array(
				$this,
				'uploaded_essays_settings_page'
			)
		);
	}

	/**
	 * @BOOSTA Settings page
	 */
	public function  uploaded_essays_settings_page() {
		$essays = $this->getEssays();
		$i = 0;
		echo '<table class="wp-list-table widefat fixed striped tags" style="max-width: 800px;margin: 0 auto;">';
		echo '<thead><tr><td>File name:</td><td>Description:</td><td style="text-align: center">Buttons:</td></tr></thead>';
		echo '<tbody>';
		foreach ($essays as $essay) {
			if (!$essay) continue;
			$removeUrl = admin_url('admin-ajax.php?action=remove_post&_wpnonce=' . wp_create_nonce('remove_post') . '&id=' . $essay->ID);
			$content = apply_filters('the_content', $essay->post_content);
			echo <<<HTML
			<tr>
				<th>{$essay->post_title}</th>
				<th>{$content}</th>
				<th style="text-align: center"><a class="button button-primary button-large" href="{$essay->guid}">Download</a><a class="button button-danger button-large" href="{$removeUrl}">Remove</a></th>
			</tr>
HTML;
			$i++;
		}
		echo '</tbody>';
		echo '</table>';
	}

	/**
	 * @BOOSTA Get posts by id
	 */
	private function getEssays() {
		$ids = get_option('uploaded_essays');
		$ids = explode(',', $ids);
		foreach ($ids as $id) {
			$imgs[] = get_post($id);
		}

		return $imgs;
	}

	private function checkNonce($nonce, $action) {
		if(!wp_verify_nonce($nonce, $action)) {
			new Alert('Session is failed', false);
			wp_redirect('/essay-upload/');
			exit;
		}
	}

	private function checkEmpty($request) {
		$keys = array_keys($request);
		foreach ($keys as $key) if ($request[$key] === '') {
			new Alert(ucfirst($key) . ' is empty', false);
			wp_redirect('/essay-upload/');
			exit;
		}
	}

}