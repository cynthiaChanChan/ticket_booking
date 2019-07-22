<?php 
namespace App\Billing;

use App\Billing\Charge;
use App\Billing\PaymentFailedException;
use Stripe\Error\InvalidRequest;

class StripePaymentGateway implements PaymentGateway
{
	const TEST_CARD_NUMBER = '4242424242424242';

	private $apiKey;

	public function __construct($apiKey)
	{
		$this->apiKey = $apiKey;
	}

	public function charge($amount, $token)
	{
		try {
			$stripeCharge = \Stripe\Charge::create([
				'amount' => $amount,
				'currency' => 'usd',
				'source' => $token
			], ['api_key' => $this->apiKey]);

			return new Charge([
				'amount' => $stripeCharge['amount'],
				'card_last_four' => $stripeCharge['source']['last4']
			]);
		} catch(InvalidRequest $e) {
			throw new PaymentFailedException;
		}		
	}

	public function getValidTestToken($cardNumber = self::TEST_CARD_NUMBER)
	{
		return \Stripe\Token::create([
		  'card' => [
		    'number' => $cardNumber,
		    'exp_month' => 1,
		    'exp_year' => date('Y') + 1,
		    'cvc' => '123'
		  ]
		], ['api_key' => $this->apiKey])->id;
	}

	public function newChargesDuring($callback)
	{
		$latestCharge = $this->lastCharge();
		$callback($this);
		return $this->newChargesSince($latestCharge)->map(function($stripeCharge) {
			return new Charge([
				'amount' => $stripeCharge['amount'],
				'card_last_four' => $stripeCharge['source']['last4']
			]);
		});
	}

	private function lastCharge()
	{
		return \Stripe\Charge::all(
			['limit' => 1],
			['api_key' => $this->apiKey]
		)['data'][0];
	}

	private function newChargesSince($Charge=null)
	{
		$newCharges = \Stripe\Charge::all(
			[
				'ending_before' => $Charge ? $Charge->id : null
			],
			['api_key' => $this->apiKey]
		)['data'];

		return collect($newCharges);
	}
}