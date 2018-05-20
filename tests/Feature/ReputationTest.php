<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReputationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_earn_points_when_they_create_thread()
    {
        $thread = create('App\Thread');

        $this->assertEquals(10, $thread->creator->reputation);
    }

    /** @test */
    public function a_user_earns_point_when_reply_to_thread()
    {
        $thread = create('App\Thread');

        $reply = $thread->addReply(
            [
                'user_id' => create('App\User')->id,
                'body' => 'Hear is a reply'
            ]
        );

        $this->assertEquals(2, $reply->owner->reputation);
    }

    /** @test */
    public function a_user_earns_points_when_their_reply_is_marked_as_best()
    {
        $thread = create('App\Thread');

        $reply = $thread->addReply(
            [
                'user_id' => create('App\User')->id,
                'body' => 'Hear is a reply'
            ]
        );

        $thread->markBestReply($reply);

        $this->assertEquals(52, $reply->owner->reputation);
    }

    /** @test */
    // public function a_user_earn_ponts_when_their_reply_liked()
    // {
    //     $thread = create('App\Thread');

    //     $reply = $thread->addReply(
    //         [
    //             'user_id' => create('App\User')->id,
    //             'body' => 'Hear is a reply'
    //         ]
    //     );

    //     $this->assertEquals(6, $reply->owner->reputation);
    // }
}
