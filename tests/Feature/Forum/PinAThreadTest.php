<?php
namespace Tests\Feature\Forum;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Thread;
use App\Models\Channel;

class PinAThreadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_pin_a_threads()
    {
        $this->signInAdmin();

        $thread = create('App\Models\Thread', ['user_id' => auth()->id()]);

        $this->post(route('pinned-threads.store', $thread));

        $this->assertTrue($thread->fresh()->pinned);
    }

    /** @test */
    public function admin_can_unpin_threads()
    {
        $this->signInAdmin();

        $thread = create('App\Models\Thread', ['pinned' => true]);

        $this->delete(route('pinned-threads.destroy', $thread));

        $this->assertFalse($thread->fresh()->pinned);
    }

    /** @test */
    public function pinned_threads_are_listed_first()
    {
        $this->signInAdmin();

        $thread = create(Thread::class, [], 3);
        $ids = $thread->pluck('id');

        $this->getJson(
            route('threads')
        )->assertJson(
            [
                'data' => [
                    ['id' => $ids[0]],
                    ['id' => $ids[1]],
                    ['id' => $ids[2]],
                ]
            ]
        );

        $this->post(route('pinned-threads.store', $thread->last()));

        $this->getJson(
            route('threads')
        )->assertJson(
            [
                'data' => [
                    ['id' => $ids[2]],
                    ['id' => $ids[0]],
                    ['id' => $ids[1]],
                ]
            ]
        );
    }
}