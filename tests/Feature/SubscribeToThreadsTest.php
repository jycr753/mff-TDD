<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_subscribe_to_thread()
    {
        // Given that user is singed in
        $this->signIn();

        // Given that we have a thread
        $thread = create('App\Thread');

        // User subscribes to the thread
        $this->post($thread->path() . '/subscriptions');

        // Then, each time a new reply is left ..
        $thread->addReply(
            [
                'user_id' => auth()->id(),
                'body' => 'Some reply here'
            ]
        );

        // A notification is sent
        //$this->assertCount(1, auth()->user()->notifications);
    }
}
