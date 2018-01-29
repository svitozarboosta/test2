<?php
/*
 * Template Name: Paypal page
 */

// Parse URL (Get GET param)
$query_str = parse_url(home_url($_SERVER['REQUEST_URI']), PHP_URL_QUERY);
parse_str($query_str, $get);

// Die functions if bad GET request
if (!isset($get['success'], $get['paymentId'], $get['PayerID'])) die();
if ((bool) $get['success'] === false) die();

// Set use for this script
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use theme\PayPal;

PayPal::setPayPal();
$paypal = PayPal::getPayPal();

$paymentId  = $get['paymentId'];
$PayerID    = $get['PayerID'];

$excute = new PaymentExecution();
$excute->setPayerId($PayerID);

$payment = Payment::get($paymentId, $paypal);

try {
	$result = $payment->execute($excute, $paypal);
} catch (Exception $e) {
	die($e->getMessage());
}

$data = json_decode(base64_decode($get['hashdata']));

if (empty($data)) die();
$post = get_post($data->post_ID);

$cats = get_the_category($data->post_ID);
$cat_str = '';
foreach ($cats as $cat) {
	$cat_str .= $cat->name;
	if (next($cats)) $cat_str .= ', ';
}

$content = strtr(file_get_contents(get_template_directory() . '/inc/parts/mail/SecondEmail.html'),
	array(
		'#email#'   => $data->email,
		'#title#'   => $post->post_title,
		'#text#'    => apply_filters('the_content', $post->post_content)
	)
);
if (!\theme\amazon\MailSender::send($data->email, 'Your essay', $content)) {
	$text = "Email: {$data->email}\r\nPostID: {$data->post_ID}";
	\theme\amazon\MailSender::send('andrey.palyvoda@boosta.co', 'Error payment from businessays', $text);
	die('Error sending message. We contact with you.');
}
//$sender = new \CronMail\classes\Posts();
//$sender->insertMessage($data->email, 'Your request for a FREE creative essay sample from BusinEssays!', $content, 0);

/* --- Start page --- */
get_header(); ?>
<script>
    ga('ec:addProduct', {
        'id': '<?= $data->post_ID; ?>',
        'name': '<?= $post->post_title; ?>',
        'category': '<?= $cat_str; ?>',
        'brand': 'sample',
        'price': '0.99',
        'quantity': 1
    });
    ga('ec:setAction', 'purchase', {
        'id': '<?= $result->getId(); ?>',
        'affiliation': '<?= $data->email; ?>',
        'revenue': '0.99',
        'tax': '0',
        'shipping': '0'
    });
    ga('send', 'pageview', '/fast-delivery');
</script>
<div class="single">
    <div class="container">
        <main>
            <h2>Thank for your payment!</h2>
            <h4>Check your email now!</h4>
            <p>We send your sample to <strong><?= $data->email; ?></strong></p>
        </main>
    </div>
</div>
<?php get_template_part('inc/parts/home/home', 'categories'); // Include categories section with container ?>
<?php get_footer(); ?>