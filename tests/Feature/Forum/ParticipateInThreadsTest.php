<?php
namespace Tests\Feature\Forum;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Exception;

class ParticipateInThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_user_may_not_add_replies()
    {
        $this->withExceptionHandling()
            ->post('/threads/some-channel/1/replies', [])
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn();

        $thread = create('App\Models\Thread');

        $reply = make('App\Models\Reply');
        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $thread->fresh()->replies_count);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Models\Thread');

        $reply = make('App\Models\Reply', ['body' => null]);

        $this->json('post', $thread->path() . '/replies', $reply->toArray())
            ->assertStatus(422);

    }

    /** @test */
    public function unauthorized_users_cannot_delete_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Models\Reply');

        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('/login');

        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function auth_user_can_delete_replies()
    {
        $this->signIn();

        $reply = create('App\Models\Reply', ['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertEquals(0, $reply->thread->fresh()->replies_count);
    }

    /** @test */
    public function auth_users_can_update_reply()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $reply = create('App\Models\Reply', ['user_id' => auth()->id()]);

        $updateReply = 'You been changed, fool.';

        $this->patch("/replies/{$reply->id}", ['body' => $updateReply]);

        $this->assertDatabaseHas(
            'replies',
            [
                'id' => $reply->id,
                'body' => $updateReply
            ]
        );
    }

    /** @test */
    public function unauthorized_users_cannot_update_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Models\Reply');

        $this->patch("/replies/{$reply->id}")
            ->assertRedirect('/login');

        $this->signIn()
            ->patch("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function replies_that_contain_spam_may_not_be_created()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $thread = create('App\Models\Thread');

        $reply = make(
            'App\Models\Reply',
            [
                'body' => 'yahoo customer support'
            ]
        );

        $this->json('post', $thread->path() . '/replies', $reply->toArray())
            ->assertStatus(422);
    }

    /** @test */
    public function a_user_can_post_once_per_5_min()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $thread = create('App\Models\Thread');
        $reply = make('App\Models\Reply');

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(201);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(429);
    }
}
