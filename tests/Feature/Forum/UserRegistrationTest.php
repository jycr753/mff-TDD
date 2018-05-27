<?php
namespace Tests\Feature\Forum;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Mail\PleaseConfirmYourEmail;
use Illuminate\Auth\Events\Registered;
use App\Models\User;

class UserRegistrationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function confirmation_email_is_sent_upon_registration()
    {
        Mail::fake();

        $user = create('App\Models\User');

        event(new Registered($user));

        Mail::assertQueued(PleaseConfirmYourEmail::class);
    }

    /** @test */
    public function user_can_confirm_email_address()
    {
        Mail::fake();

        $user = factory('App\Models\User')->states('unconfirmed')->create();

        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);

        $response = $this->get(
            route(
                'confirm.register',
                ['token' => $user->confirmation_token]
            )
        )->assertRedirect('/dashboard');

        $this->assertTrue($user->fresh()->confirmed);
        $this->assertNull($user->fresh()->confirmation_token);
    }

    /** @test */
    public function confirm_invalid_token()
    {
        $this->get(route('confirm.register', ['token' => 'invalid']))
            ->assertSessionHas('flash', 'Unknown token.');

    }
}
