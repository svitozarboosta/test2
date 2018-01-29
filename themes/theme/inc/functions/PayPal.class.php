<?php
namespace theme;

require __DIR__  . '/vendor/autoload.php';

use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PayPal {

	private static $paypal;

	public static function getPayPal() {
		return self::$paypal;
	}

	public static function setPayPal() {
		$paypal = new ApiContext(
			new OAuthTokenCredential(
				'AaFVaA4u-_WD_upRz9gwoUbCtyAO7RA8lYC7PMPeFfNTZ6cVk9sB6VCijMnDjCtCYVij8lfrUxM3rZI5',
				'EOpPd4nTHdDbdWNxPzeRg15tO7pc8tn-nb02wFpk_TuVWtUhJKoul0lQVUHzGcwNkMoIgfQow_AP2o9D'
			)
		);

		$paypal->setConfig(array(
			'mode' => 'live'
		));

		self::$paypal = $paypal;
	}
	public static function getPayPalUrl($email, $post_ID, $topic) {
		self::setPayPal();

		$JSONData['email']  = $email;
		$JSONData['post_ID']  = $post_ID;
		$JSONData = base64_encode(json_encode($JSONData));

		$payer = new Payer();
		$payer->setPaymentMethod('paypal');

		$item = new Item();
		$item->setName($topic)
		     ->setCurrency('USD')
		     ->setQuantity(1)
		     ->setPrice(0.99);

		$itemList = new itemList();
		$itemList->setItems([$item]);

		$details = new Details();
		$details->setShipping(0.00)
		        ->setSubtotal(0.99);

		$amount = new Amount();
		$amount->setCurrency('USD')
		       ->setTotal(0.99)
		       ->setDetails($details);

		$transaction = new Transaction();
		$transaction->setAmount($amount)
		            ->setItemList($itemList)
		            ->setDescription('Fast delivery essay sample: ')
		            ->setInvoiceNumber(uniqid());

		$redurectUrls = new RedirectUrls();
		$redurectUrls->setReturnUrl(home_url('/paypal?success=true&hashdata=' . $JSONData))
		             ->setCancelUrl(home_url('/paypal?success=false'));

		$payment = new Payment();
		$payment->setIntent('sale')
		        ->setPayer($payer)
		        ->setRedirectUrls($redurectUrls)
		        ->setTransactions([$transaction]);
		try {
			$payment->create(self::getPayPal());
		}
		catch (Exception $e) {
			die($e);
		}

		$appLink = $payment->getApprovalLink();
		return $appLink;
	}
}
