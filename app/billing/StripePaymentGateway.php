<?php 
namespace App\Billing;

use App\Billing\PaymentFailedException;
use Stripe\Charge;
use Stripe\Error\InvalidRequest;

class StripePaymentGateway implements PaymentGateway
{
	private $apiKey;

	public function __construct($apiKey)
	{
		$this->apiKey = $apiKey;
	}

	public function charge($amount, $token)
	{
		try {
			Charge::create([
				'amount' => $amount,
				'currency' => 'usd',
				'source' => $token
			], ['api_key' => $this->apiKey]);
		} catch(InvalidRequest $e) {
			throw new PaymentFailedException;
		}		
	}

	public function getValidTestToken()
	{
		return \Stripe\Token::create([
		  'card' => [
		    'number' => '4242424242424242',
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
		$newCharges = $this->newChargesSince($latestCharge);
		return $newCharges->pluck('amount');
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