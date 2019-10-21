<?php

namespace Tests\Feature;

use Mockery;
use App\User;
use App\Concert;
use Tests\TestCase;
use App\Facades\TicketCode;
use App\Billing\PaymentGateway;
use App\Billing\FakePaymentGateway;
use App\Mail\OrderConfirmationEmail;
use Illuminate\Support\Facades\Mail;
use App\Facades\OrderConfirmationNumber;
use App\OrderConfirmationNumberGenerator;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PurchaseTicketsTest extends TestCase
{
   
    use DatabaseMigrations;

    protected function setUp() :void 
    {
        parent::setUp();
        $this->paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }

    protected function orderTickets($concert, $params)
    {
        $savedRequest = $this->app['request'];
        $this->response = $this->json('POST', "/concerts/{$concert->id}/orders", $params); 
        $this->app['request'] = $savedRequest;
    }

    protected function assertValidationError($field)
    {
        $this->response->assertStatus(422);
        $this->assertArrayHasKey($field, $this->response->decodeResponseJson()['errors']);
    }

    /** @test */
    function customer_can_purchase_tickets_to_a_published_concert()
    {
        Mail::fake();
        OrderConfirmationNumber::shouldReceive('generate')->andReturn('ORDERCONFIRMATION1234');
        TicketCode::shouldReceive('generateFor')->andReturn('TICKETCODE1', 'TICKETCODE2', 'TICKETCODE3');

        $user = factory(User::class)->create(['stripe_account_id' => 'test_account_1234']);
        // Arrange
        // Create a concert
        $concert = factory(Concert::class)->create([
            'user_id' => $user->id,
            'ticket_price' => 3250, 
            'ticket_quantity' => 3
        ]);
        $concert->publish();

        // Act
        // Purchase concert tickets

        $this->orderTickets($concert, [
            'email' => 'cindy@example.com',
            'ticket_quantity' => 3,
            'payment_token' => $this->paymentGateway->getValidTestToken()
        ]); 

        $this->response->assertStatus(201);

        $this->response->assertJson([
            'email' => 'cindy@example.com',
            'amount' => 9750,
            'tickets'               => [
                ['code' => 'TICKETCODE1'],
                ['code' => 'TICKETCODE2'],
                ['code' => 'TICKETCODE3']
            ]
        ]);

        // Assert
        // Make sure the customer was charged the correct amount
        $this->assertEquals(9750, $this->paymentGateway->totalChargesFor('test_account_1234'));

        // Make sure that an order exists for this customer
        $this->assertTrue($concert->hasOrderFor('cindy@example.com'));
        $order = $concert->ordersFor('cindy@example.com')->first();
        $this->assertEquals(3, $order->ticketQuantity());
        Mail::assertSent(OrderConfirmationEmail::class, function ($email) use ($order) {
            return $email->hasTo('cindy@example.com') && $order->id = $email->order->id;
        });
    }

    /** @test */
    function cannot_perchase_more_tickets_than_remain()
    {
        $concert = factory(Concert::class)->states('published')->create()->addTickets(50);

        $this->orderTickets($concert, [
            'email' => 'cindy@example.com',
            'ticket_quantity' => 51,
            'payment_token' => $this->paymentGateway->getValidTestToken()
        ]); 

        $this->response->assertStatus(422);
        $this->assertFalse($concert->hasOrderFor('cindy@example.com'));   
        $this->assertEquals(0, $this->paymentGateway->totalCharges());    
        $this->assertEquals(50, $concert->ticketsRemaining());   
    }

    /** @test */
    function cannot_purchase_tickets_another_customer_is_already_trying_to_purchase()
    {
        $concert = factory(Concert::class)->states('published')->create(['ticket_price' => 1200])->addTickets(3);

        $this->paymentGateway->beforeFirstCharge(function ($paymentGateway) use ($concert) {
            $this->orderTickets($concert, [
            'email' => 'personB@example.com',
            'ticket_quantity' => 1,
            'payment_token' => $this->paymentGateway->getValidTestToken()
            ]); 

            $this->response->assertStatus(422);
            $this->assertFalse($concert->hasOrderFor('personB@example.com'));   
            $this->assertEquals(0, $this->paymentGateway->totalCharges());
        });

        $this->orderTickets($concert, [
            'email' => 'personA@example.com',
            'ticket_quantity' => 3,
            'payment_token' => $this->paymentGateway->getValidTestToken()
        ]); 

        $this->assertEquals(3600, $this->paymentGateway->totalCharges());
        $this->assertTrue($concert->hasOrderFor('personA@example.com'));   
        $this->assertEquals(3, $concert->ordersFor('personA@example.com')->first()->ticketQuantity());
    }

    /** @test */
    function email_is_required_to_perchase_tickets()
    {
        $concert = factory(Concert::class)->states('published')->create();

        $this->orderTickets($concert, [
            'ticket_quantity' => 3,
            'payment_token' => $this->paymentGateway->getValidTestToken()
        ]);

        $this->assertValidationError('email');
        //dd($response->decodeResponseJson());
    }

    /** @test */
    function email_must_be_valid_to_perchase_tickets() 
    {
        $concert = factory(Concert::class)->states('published')->create();

        $this->orderTickets($concert, [
            'email' => 'abc.com',
            'ticket_quantity' => 3,
            'payment_token' => $this->paymentGateway->getValidTestToken()
        ]);

        $this->assertValidationError('email');
    }

    /** @test */
    function ticket_quantity_is_required_to_perchase_tickets() 
    {
        $concert = factory(Concert::class)->states('published')->create();

        $this->orderTickets($concert, [
            'email' => 'cindy@example.com',
            'payment_token' => $this->paymentGateway->getValidTestToken()
        ]);

        $this->assertValidationError('ticket_quantity');
    }

    /** @test */
    function ticket_quantity_must_be_at_least_1_to_purchase_tickets() 
    {
        $concert = factory(Concert::class)->states('published')->create();

        $this->orderTickets($concert, [
            'email' => 'cindy@example.com',
            'ticket_quantity' => 0,
            'payment_token' => $this->paymentGateway->getValidTestToken()
        ]);

        $this->assertValidationError('ticket_quantity');
    }

    /** @test */
    function payment_token_is_required() 
    {
        $concert = factory(Concert::class)->states('published')->create();

        $this->orderTickets($concert, [
            'email' => 'cindy@example.com',
            'ticket_quantity' => 3
        ]);

        $this->assertValidationError('payment_token');
    }

    /** @test */
    function cannot_purchase_tickets_to_an_unpublished_concert()
    {
        $concert = factory(Concert::class)->states('unpublished')->create(['ticket_quantity' => 3]);

        $this->orderTickets($concert, [
            'email' => 'cindy@example.com',
            'ticket_quantity' => 3,
            'payment_token' => $this->paymentGateway->getValidTestToken()
        ]);

        $this->response->assertStatus(404);
        $this->assertFalse($concert->hasOrderFor('cindy@example.com'));
        $this->assertEquals(0, $this->paymentGateway->totalCharges());
    }

    /** @test */
    function an_order_is_not_created_if_payment_fails()
    {
        $concert = factory(Concert::class)->states('published')->create(['ticket_price' => 3250])->addTickets(3);

        $this->orderTickets($concert, [
            'email' => 'cindy@example.com',
            'ticket_quantity' => 3,
            'payment_token' => 'fake_token'
        ]);   

        $this->response->assertStatus(422); 
        $this->assertFalse($concert->hasOrderFor('cindy@example.com'));   
        $this->assertEquals(3, $concert->ticketsRemaining());
    }
}
 