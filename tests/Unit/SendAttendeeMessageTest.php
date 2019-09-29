<?php

namespace Tests\Unit;

use App\Order;
use App\Ticket;
use App\Concert;
use Tests\TestCase;
use App\AttendeeMessage;
use App\Jobs\SendAttendeeMessage;
use App\Mail\AttendeeMessageEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SendAttendeeMessageTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_sends_the_message_to_all_concert_attendees()
    {
        Mail::fake();
        $concert = factory(Concert::class)->create();
        $concert->publish();
        $otherConcert = factory(Concert::class)->create();
        $otherConcert->publish();
        $message = AttendeeMessage::create([
            'concert_id' => $concert->id,
            'subject' => 'My subject',
            'message' => 'My message'
        ]);
        
        $orderA = factory(Order::class)->create(['email' =>"orderA@example.com"]);
        $tickets = factory(Ticket::class, 1)->create(['concert_id' => $concert->id]);
        $orderA->tickets()->saveMany($tickets);

        $otherOrder = factory(Order::class)->create(['email' =>"otherOrder@example.com"]);
        $otherTickets = factory(Ticket::class, 1)->create(['concert_id' => $otherConcert->id]);
        $otherOrder->tickets()->saveMany($otherTickets);
        
        SendAttendeeMessage::dispatch($message);

        Mail::assertSent(AttendeeMessageEmail::class, function ($mail) use ($message) {
            return $mail->hasTo("orderA@example.com")
                && $mail->attendeeMessage->is($message);
        });

        Mail::assertNotSent(AttendeeMessageEmail::class, function ($mail) {
            return $mail->hasTo("otherOrder@example.com");
        });
    }
}
