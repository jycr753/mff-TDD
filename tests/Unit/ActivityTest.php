<?php

namespace Tests\Feature;

use App\Activity;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_records_activity_when_a_thread_is_created()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->assertDatabaseHas('activities', [
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread',
            'type' => 'created_thread'
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test */
    public function it_records_activity_when_a_reply_is_created()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->assertEquals(2, Activity::count());
    }

    /** @test */
    public function if_fetches_a_feed_for_any_user()
    {
        /**
         * Given we have a thread
         * And another thread from a week a ago
         * When we fetch their feed
         * Then, if should be returned in the proper format.
         */
        $this->signIn();

        create('App\Thread', ['user_id' => auth()->id()], 2);
        /*create('App\Thread', [
            'user_id' => auth()->id(),
            'created_at' => Carbon::now()->subWeek()
        ]);*/

        auth()
            ->user()
            ->activity()
            ->first()
            ->update([
                'created_at' => Carbon::now()->subWeek()
            ]);

        $feed = Activity::feed(auth()->user(), 50);

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    }
}
