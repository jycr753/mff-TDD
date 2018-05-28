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
        $user = factory('App\Models\User')->create();

        config(['council.admin' => [$user->email]]);

        $this->signIn($user);

        $thread = create('App\Models\Thread', ['user_id' => auth()->id()]);

        $this->post(route('pinned-threads.store', $thread));

        $this->assertTrue($thread->fresh()->pinned);
    }

    /** @test */
    public function admin_can_unpin_threads()
    {
        $user = factory('App\Models\User')->create();

        config(['council.admin' => [$user->email]]);

        $this->signIn($user);

        $thread = create('App\Models\Thread', ['pinned' => true]);

        $this->delete(route('pinned-threads.destroy', $thread));

        $this->assertFalse($thread->fresh()->pinned);
    }

    /** @test */
    public function pinned_threads_are_listed_first()
    {
        $channel = create(
            Channel::class,
            [
                'name' => 'PHP',
                'slug' => 'php'
            ]
        );

        create(Thread::class, ['channel_id' => $channel->id]);
        create(Thread::class, ['channel_id' => $channel->id]);

        $threadToPin = create(Thread::class, ['channel_id' => $channel->id]);

        $user = factory('App\Models\User')->create();

        config(['council.admin' => [$user->email]]);

        $this->signIn($user);

        $response = $this->getJson(route('threads'));

        $response->assertJson(
            [
                'data' => [
                    ['id' => '1'],
                    ['id' => '2'],
                    ['id' => '3'],
                ]
            ]
        );

        $this->post(route('pinned-threads.store', $threadToPin));

        $response = $this->getJson(route('threads'));

        $response->assertJson(
            [
                'data' => [
                    ['id' => '3'],
                    ['id' => '1'],
                    ['id' => '2'],
                ]
            ]
        );
    }
}