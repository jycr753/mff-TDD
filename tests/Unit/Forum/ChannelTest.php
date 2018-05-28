<?php

namespace Tests\Unit\Forum;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_channel_consists_of_threads()
    {
        $channel = create('App\Models\Channel');

        $thread = create('App\Models\Thread', ['channel_id' => $channel->id]);

        $this->assertTrue($channel->threads->contains($thread));
    }

    /** @test */
    public function a_channel_can_be_archavice()
    {
        $channel = create('App\Models\Channel');

        $this->assertFalse($channel->archived);

        $channel->archived();

        $this->assertTrue($channel->archived);
    }
}
