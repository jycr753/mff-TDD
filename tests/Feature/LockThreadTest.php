<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LocakThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_admin_can_lock_any_thread()
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
