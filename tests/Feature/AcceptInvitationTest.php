<?php

namespace Tests\Feature;

use App\User;
use App\Invitation;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AcceptInvitationTest extends TestCase
{
     use RefreshDatabase;

     /** @test */
     function viewing_an_unused_invitation()
     {
          $invitation = factory(Invitation::class)->create([
               'code' => 'TESTCODE1234',
               'user_id' => null
          ]);

          $response = $this->get('invitations/TESTCODE1234');

          $response->assertStatus(200);

          $response->assertViewIs('invitations.show');

          $this->assertTrue($response->original->getData()['invitation']->is($invitation));
     }

     /** @test */
     function viewing_a_used_invitation()
     {
          $invitation = factory(Invitation::class)->create([
               'code' => 'TESTCODE1234',
               'user_id' => factory(User::class)->create()->id
          ]);

          $response = $this->get('invitations/TESTCODE1234');
          $response->assertStatus(404);
     }

     /** @test */
     public function viewing_a_invitation_that_does_not_exist()
     {
          $response = $this->get('invitations/TESTCODE1234');

          $response->assertStatus(404);
     }

     /** @test */
     public function registering_with_a_valid_invitation_code()
     {
          $invitation = factory(Invitation::class)->create([
               'code' => 'TESTCODE1234',
               'user_id' => null
          ]);

          $response = $this->post('register', [
               'email' => 'me@example.com',
               'password' => 'secret',
               'invitation_code' => 'TESTCODE1234'
          ]);

          $response->assertRedirect('backstage/concerts');

          $this->assertEquals(1, User::count());

          $user = User::first();

          $this->assertAuthenticatedAs($user);
          $this->assertEquals('me@example.com', $user->email);
          $this->assertTrue(Hash::check('secret', $user->password));
          $this->assertTrue($invitation->fresh()->user->is($user));
     }

   /** @test */
   public function registering_with_a_used_invitation_code() 
     {
          $invitation = factory(Invitation::class)->create([
               'code' => 'TESTCODE1234',
               'user_id' => factory(User::class)->create()->id
          ]);

          $this->assertEquals(1, User::count());

          $response = $this->post('register', [
               'email' => 'me@example.com',
               'password' => 'secret',
               'invitation_code' => 'TESTCODE1234'
          ]);

          $this->assertEquals(1, User::count());

          $response->assertStatus(404);
     }

   /** @test */
     public function registering_with_an_invitation_code_that_does_not_exist()
     {
          $response = $this->post('register', [
               'email' => 'me@example.com',
               'password' => 'secret',
               'invitation_code' => 'TESTCODE1234'
          ]);

          $response->assertStatus(404);
          $this->assertEquals(0, User::count());
     }

    /** @test */
     public function an_email_is_required()
     {
          $invitation = factory(Invitation::class)->create([
               'code' => 'TESTCODE1234',
               'user_id' => null
          ]);

          $response = $this->from('invitations/TESTCODE1234')->post('register', [
               'email' => '',
               'password' => 'secret',
               'invitation_code' => 'TESTCODE1234'
          ]);

          $response->assertRedirect('invitations/TESTCODE1234');
          $response->assertSessionHasErrors('email');
          $this->assertEquals(0, User::count());

     }

     /** @test */
     public function email_must_be_a_valid_email_address()
     {
          $invitation = factory(Invitation::class)->create([
               'code' => 'TESTCODE1234',
               'user_id' => null
          ]);

          $response = $this->from('invitations/TESTCODE1234')->post('register', [
               'email' => 'invalid.email.com',
               'password' => 'secret',
               'invitation_code' => 'TESTCODE1234'
          ]);

          $response->assertRedirect('invitations/TESTCODE1234');
          $response->assertSessionHasErrors('email');
          $this->assertEquals(0, User::count());
     }

     /** @test */
     public function email_must_be_unique()
     {
          $existingUser = factory(User::class)->create(['email' => 'me@example.com']);

          $invitation = factory(Invitation::class)->create([
               'code' => 'TESTCODE1234',
               'user_id' => null
          ]);

          $this->assertEquals(1, User::count());

          $response = $this->from('invitations/TESTCODE1234')->post('register', [
               'email' => 'me@example.com',
               'password' => 'secret',
               'invitation_code' => 'TESTCODE1234'
          ]);

          $response->assertRedirect('invitations/TESTCODE1234');
          $response->assertSessionHasErrors('email');
          $this->assertEquals(1, User::count());

     }

     /** @test */
     public function password_is_required()
     {
          $invitation = factory(Invitation::class)->create([
               'code' => 'TESTCODE1234',
               'user_id' => null
          ]);

          $response = $this->from('invitations/TESTCODE1234')->post('register', [
               'email' => 'me@example.com',
               'password' => '',
               'invitation_code' => 'TESTCODE1234'
          ]);

          $response->assertRedirect('invitations/TESTCODE1234');
          $response->assertSessionHasErrors('password');
          $this->assertEquals(0, User::count());

     }
}
