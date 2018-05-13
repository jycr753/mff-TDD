<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Mail\PleaseConfirmYourEmail;
use Illuminate\Auth\Events\Registered;
use App\User;

class UserRegistrationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function confirmation_email_is_sent_upon_registration()
    {
        Mail::fake();

        $user = create('App\User');

        event(new Registered($user));

        Mail::assertSent(PleaseConfirmYourEmail::class);
    }

    /** @test */
    public function user_can_confirm_email_address()
    {
        $user = create('App\User');

        $this->assertFalse($user->confirmed);

        // Let the user confim their account
        $response = $this->get('/register/confirm?token=' . $user->confirmation_token);

        $this->assertTrue($user->fresh()->confirmed);

        $response->assertRedirect('/dashboard');

    }
}
