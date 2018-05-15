<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LocakThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function non_admin_may_not_lock_thread()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->post(route('locked-threads.store', $thread))->assertStatus(403);

        $this->assertFalse($thread->fresh()->locked);
    }

    /** @test */
    public function admin_can_lock_thread()
    {
        $this->signIn(factory('App\User')->states('administrator')->create());

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->post(route('locked-threads.store', $thread));

        $this->assertTrue($thread->fresh()->locked);
    }

    /** @test */
    public function admin_can_unlock_thread()
    {
        $this->signIn(factory('App\User')->states('administrator')->create());

        $thread = create('App\Thread', ['user_id' => auth()->id(), 'locked' => true]);

        $this->delete(route('locked-threads.destroy', $thread));

        $this->assertFalse($thread->fresh()->locked);
    }

    /** @test */
    public function once_locked_a_thread_may_not_receive_new_reply()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $thread->lock();

        $this->post(
            $thread->path() . '/replies',
            [
                'body' => 'dummy body',
                'user_id' => auth()->id()
            ]
        )->assertStatus(422);
    }
}
