<?php

namespace Tests\Unit\Forum;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Carbon\Carbon;

class ReplyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_has_an_owner()
    {
        $reply = create('App\Models\Reply');

        $this->assertInstanceOf('App\Models\User', $reply->owner);
    }

    /** @test */
    public function a_reply_knows_if_it_was_just_published()
    {
        $reply = create('App\Models\Reply');

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    /** @test */
    public function it_can_detect_all_mentioned_users_in_the_body()
    {
        $reply = new \App\Models\Reply(
            [
                'body' => '@JaneDoe wants to talk to @JhonDoe'
            ]
        );

        $this->assertEquals(['JaneDoe', 'JhonDoe'], $reply->mentionedUsers());
    }

    /** @test */
    public function it_wraps_mentioned_usernames_in_the_body_within_anchor_tags()
    {
        $reply = new \App\Models\Reply(
            [
                'body' => 'Hello @Tanvir.'
            ]
        );

        $this->assertEquals(
            'Hello <a href="/profiles/Tanvir">@Tanvir</a>.',
            $reply->body
        );
    }

    /** @test */
    public function it_know_if_it_is_best_reply()
    {
        $reply = create('App\Models\Reply');

        $this->assertFalse($reply->isBest());

        $reply->thread->update(['best_reply_id' => $reply->id]);

        $this->assertTrue($reply->fresh()->isBest());
    }

    /** @test */
    public function a_replies_body_is_sanatize_automatically()
    {
        // Given we have thread
        $reply = make('App\Models\Reply', ['body' => '<script>alert("bad")</script><p>This is ok</p>']);

        $this->assertEquals("<p>This is ok</p>", $reply->body);
    }
}
