<?php

namespace Tests\Feature\Forum;

use App\Models\Activity;
use App\Rules\Recaptcha;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Tests\TestCase;
use App\Models\Thread;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations, MockeryPHPUnitIntegration;

    public function setUp()
    {
        parent::setUp();

        app()->singleton(
            Recaptcha::class,
            function () {
                return \Mockery::mock(
                    Recaptcha::class,
                    function ($m) {
                        $m->shouldReceive('passes')->andReturn(true);
                    }
                );
            }
        );
    }

    /**
     * Create thread
     *
     * @param array $overrides
     * @return void
     */
    protected function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Models\Thread', $overrides);

        return $this->post(route('threads'), $thread->toArray() + ['g-recaptcha-response' => 'token']);
    }

    /** @test */
    public function guests_may_not_create_threads()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect(route('login'));

        $this->post(route('threads'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function new_users_must_first_confirm_their_email_address_before_creating_threads()
    {
        $user = factory('App\Models\User')->states('unconfirmed')->create();

        $this->signIn($user);

        $thread = make('App\Models\Thread');

        $this->post(route('threads'), $thread->toArray())
            ->assertRedirect(route('threads'))
            ->assertSessionHas('flash', 'You must verify email!');
    }

    /** @test */
    public function a_user_can_create_new_forum_threads()
    {
        $response = $this->publishThread(['title' => 'Some Title', 'body' => 'Some body.']);

        $this->get($response->headers->get('Location'))
            ->assertSee('Some Title')
            ->assertSee('Some body.');
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_recaptcha_verification()
    {
        unset(app()[Recaptcha::class]);

        $this->publishThread(['g-recaptcha-response' => 'test'])
            ->assertSessionHasErrors('g-recaptcha-response');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        factory('App\Models\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function a_thread_requires_a_unique_slug()
    {
        $this->signIn();

        $thread = create('App\Models\Thread', ['title' => 'news thread one']);

        $this->assertEquals($thread->fresh()->slug, 'news-thread-one');

        $this->post(route('threads'), $thread->toArray() + ['g-recaptcha-response' => 'token']);
        $this->assertTrue(Thread::whereSlug('news-thread-one-2')->exists());

        $this->post('/threads', $thread->toArray() + ['g-recaptcha-response' => 'token']);
        $this->assertTrue(Thread::whereSlug('news-thread-one-3')->exists());

        $this->post('/threads', $thread->toArray() + ['g-recaptcha-response' => 'token']);
        $this->assertTrue(Thread::whereSlug('news-thread-one-4')->exists());
    }

    /** @test */
    public function a_thread_with_a_title_that_ends_in_a_number_should_generate_the_proper_slug()
    {
        $this->signIn();

        $thread = create('App\Models\Thread', ['title' => 'Sum Title 24']);
        $this->assertEquals($thread->fresh()->slug, 'sum-title-24');

        $this->post('/threads', $thread->toArray() + ['g-recaptcha-response' => 'token']);
        $this->assertTrue(Thread::whereSlug('sum-title-24-2')->exists());

        $this->post('/threads', $thread->toArray() + ['g-recaptcha-response' => 'token']);
        $this->assertTrue(Thread::whereSlug('sum-title-24-3')->exists());

        $this->post('/threads', $thread->toArray() + ['g-recaptcha-response' => 'token']);
        $this->assertTrue(Thread::whereSlug('sum-title-24-4')->exists());
    }

    /** @test */
    public function unauthorized_users_may_not_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Models\Thread');

        $this->delete($thread->path())->assertRedirect('/login');

        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_threads()
    {
        $this->signIn();

        $thread = create('App\Models\Thread', ['user_id' => auth()->id()]);
        $reply = create('App\Models\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertEquals(0, Activity::count());
    }
}
