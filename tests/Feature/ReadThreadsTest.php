<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Models\Thread');
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $response = $this->get('/threads');

        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @teast */
    public function a_user_can_view_single_thread()
    {
        $this->get('/threads/' . $this->thread->id)
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create('App\Models\Channel');

        $threadInChannel = create('App\Models\Thread', ['channel_id' => $channel->id]);

        $threadNotInChannel = create('App\Models\Thread');

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create('App\Models\User', ['name' => 'JohnDoe']));

        $threadByJhone = create('App\Models\Thread', ['user_id' => auth()->id()]);
        $threadNotByJhon = create('App\Models\Thread');

        $this->get('threads?by=JohnDoe')
            ->assertSee($threadByJhone->title)
            ->assertDontSee($threadNotByJhon->title);
    }

    /** @test */
    public function a_use_can_filter_thread_by_popularity()
    {
        /*
         * Given that we have 3 threads
         * with 2 replies, 3 replies, 0 replies
         * when I filter all threads by popularity
         * Then I shoudl see the most replies to least replies order.
         * */
        $threadsWithTwoReplies = create('App\Models\Thread');
        create('App\Models\Reply', ['thread_id' => $threadsWithTwoReplies->id], 2);

        $threadsWithThreeReplies = create('App\Models\Thread');
        create('App\Models\Reply', ['thread_id' => $threadsWithThreeReplies->id], 3);

        $threadsWithZeroReplies = $this->thread;

        $response = $this->getJson('threads?popular=1')->json();

        $this->assertEquals([3, 2, 0], array_column($response['data'], 'replies_count'));
    }

    /** @test */
    public function a_user_can_filter_threads_that_are_unanswered()
    {
        $thread = create('App\Models\Thread');
        create('App\Models\Reply', ['thread_id' => $thread->id]);

        $response = $this->getJson('threads?unanswered=1')->json();

        $this->assertCount(1, $response['data']);
    }

    /** @test */
    public function a_user_can_request_all_replies_to_a_given_thread()
    {
        $thread = create('App\Models\Thread');
        create('App\Models\Reply', ['thread_id' => $thread->id], 2);

        $response = $this->getJson($thread->path() . '/replies')->json();

        $this->assertCount(2, $response['data']);
        $this->assertEquals(2, $response['total']);
    }
}
