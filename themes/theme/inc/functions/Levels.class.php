<?php

namespace theme;

use theme\amazon\MailSender;

class Levels extends Mail {

	public static function addDownloadSample() {
		add_action('wp_ajax_download_sample',        [__CLASS__, 'downloadSampleCallback']);
		add_action('wp_ajax_nopriv_download_sample', [__CLASS__, 'downloadSampleCallback']);
	}

	public static function downloadSampleCallback() {
		if (!Cfg::getConfig('is_pro')) die(new Alert('You have not permission', false, $_REQUEST['redirect_to']));

		$user    = get_userdata(get_current_user_id());
		$post    = get_post((int)$_REQUEST['id']);
		$image   = self::getImage();
		$button  = self::getButton($user->data->user_email);
		$content = strtr(file_get_contents(get_template_directory() . '/inc/parts/mail/SecondEmail.html'),
			array(
				'#image#'   => $image,
				'#button#'  => $button,
				'#email#'   => $user->data->user_email,
				'#title#'   => $post->post_title,
				'#text#'    => wpautop($post->post_content)
			)
		);

		if (MailSender::send($user->data->user_email, 'Your sample from Businessays.net', $content)) {
			die(new Alert('Success send email to: ' . $user->data->user_email, true, $_REQUEST['redirect_to']));
		} else {
			die(new Alert('Email sending error, try again.', false, $_REQUEST['redirect_to']));
		}
	}

    public static function getDays($levels, $i) {
        if ($levels[$i]->cycle_period === 'Month') : $days = 30 * $levels[$i]->cycle_number; // 30 days in mouth * cycle
        elseif ($levels[4]->cycle_period === 'Day') : $days = 1 * $levels[$i]->cycle_number; // 1 day in day * cycle
        else : $days = 0;
        endif;
        return $days / 30; // Price for mouth 30 days
    }

}