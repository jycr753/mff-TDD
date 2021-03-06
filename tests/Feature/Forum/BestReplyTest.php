<?php
namespace Tests\Feature\Forum;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class BestReplyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_thread_creator_may_mark_any_reply_as_the_best_reply()
    {
        $this->signIn();

        $thread = create('App\Models\Thread', ['user_id' => auth()->id()]);

        $replies = create('App\Models\Reply', ['thread_id' => $thread->id], 2);

        $this->assertFalse($replies[1]->isbest());

        $response = $this->postJson(route('best-replies.store', [$replies[1]->id]));

        $this->assertTrue($replies[1]->fresh()->isbest());
    }

    /** @test */
    public function only_thread_creator_may_mark_reply_as_best()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Models\Thread', ['user_id' => auth()->id()]);

        $replies = create('App\Models\Reply', ['thread_id' => $thread->id], 2);

        $this->signIn(create('App\Models\User'));

        $this->postJson(
            route('best-replies.store', [$replies[1]->id])
        )->assertStatus(403);

        $this->assertFalse($replies[1]->fresh()->isbest());
    }

    /** @test */
    public function if_best_reply_is_deleted_then_the_thread_is_properly_updated()
    {
        $this->signIn();

        $reply = create('App\Models\Reply', ['user_id' => auth()->id()]);

        $reply->thread->markBestReply($reply);

        $this->deleteJson(route('replies.destroy', $reply));

        $this->assertNull($reply->thread->fresh()->best_reply_id);
    }
}