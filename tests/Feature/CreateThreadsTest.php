<?php

namespace Tests\Feature;

use App\Activity;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guest_may_not_create_threads()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');
    }

    /** @test */
    public function auth_user_must_verify_email()
    {
        $this->publishThread(['body' => 'test body'])
            ->assertRedirect('/threads')
            ->assertSessionHas('flash', 'You must verify email!');
    }

    /** @test */
    public function an_authenticated_user_can_create_new_form_threads()
    {
        $this->signIn();

        $thread = make('App\Thread');

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])->assertStatus(422);
    }

    /** @test */
    public function a_thread_requires_body()
    {
        $this->publishThread(['body' => null])->assertStatus(422);
    }

    /** @test */
    public function a_thread_requires_valid_channel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])->assertStatus(422);
        $this->publishThread(['channel_id' => 888])->assertStatus(422);
    }


    /** @test */
    public function unauthorized_can_not_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $this->delete($thread->path())->assertRedirect('/login');

        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
    }

    /** @test */
    public function authorized_can_delete_threads()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertEquals(0, Activity::count());
    }

    protected function publishThread($overrides)
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->json('post', '/threads', $thread->toArray());
    }
}
