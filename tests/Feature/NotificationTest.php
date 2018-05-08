<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use DatabaseMigrations;

    public function setup()
    {
        parent::setup();

        $this->signIn();
        $this->thread = create('App\Thread')->subscribe();
    }

    /** @test */
    public function a_notification_is_prepared_when_a_subscribed_thread_recieves_a_new_reply_that_is_not_by_current_user()
    {
        $this->assertCount(0, auth()->user()->notifications);

        // Then, each time a new reply is left ..
        $this->thread->addReply(
            [
                'user_id' => auth()->id(),
                'body' => 'Some reply here'
            ]
        );

        // No notification is sent because its the current user
        $this->assertCount(0, auth()->user()->fresh()->notifications);

        // Anoterh user replied
        $this->thread->addReply(
            [
                'user_id' => create('App\User')->id,
                'body' => 'Some reply here'
            ]
        );

        // A notification is sent
        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /** @test */
    public function a_user_can_fetch_unread_notifications()
    {
        create(DatabaseNotification::class);

        $this->assertCount(
            1,
            $this->getJson("/profiles/" . auth()->user()->name . "/notifications")->json()
        );
    }

    /** @test */
    public function a_user_can_mark_a_notification_as_read()
    {
        create(DatabaseNotification::class);

        tap(
            auth()->user(),
            function ($user) {
                $this->assertCount(1, $user->unreadNotifications);

                $this->delete("/profiles/{$user->name}/notifications/" . $user->unreadNotifications->first()->id);

                $this->assertCount(0, $user->fresh()->unreadNotifications);
            }
        );



    }
}
