<?php 
namespace Tests\Unit\Billing;

use App\Billing\PaymentFailedException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StripePaymentGatewayTest extends TestCase
{
	/** @test */
	function charges_with_a_valid_payment_token_are_successful()
	{
		$paymentGateway = new StripePaymentGateway;

		\Stripe\Stripe::setApiKey(config('services.stripe.secret'));

		$token = \Stripe\Token::create([
		  'card' => [
		    'number' => '4242424242424242',
		    'exp_month' => 1,
		    'exp_year' => date('Y') + 1,
		    'cvc' => '123'
		  ]
		])->id;

		$paymentGateway->charge(2500, $token);
	}
}