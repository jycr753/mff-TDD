<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MenthionUsersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function mentioned_users_in_a_reply_are_notified()
    {
        // Given that we have a user
        $Jain = create('App\User', ['name' => 'JainDoe']);

        // We sing him in
        $this->signIn($Jain);

        // create another user
        $Tommy = create('App\User', ['name' => 'TommyDoe']);

        // create a thread by Jain
        $thread = create('App\Thread');

        // Make a reply by Jain to @tommy
        $reply = make(
            'App\Reply',
            [
                'body' => '@TommyDoe look at this.'
            ]
        );

        // submit the reply
        $this->json('post', $thread->path() . '/replies', $reply->toArray());

        //check the notification of Tommy
        $this->assertCount(1, $Tommy->notifications);


    }
}