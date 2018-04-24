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

        $this->thread = create('App\Thread');
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @teast */
    public function a_user_can_view_single_thread()
    {
        $this->get('/threads/'. $this->thread->id)
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_replies_to_a_thread()
    {
        $reply = create('App\Reply', [
            'thread_id' => $this->thread->id
        ]);

        $this->get('/threads/'.$this->thread->channel.'/'.$this->thread->id)
            ->assertSee($reply->body);
    }
}
