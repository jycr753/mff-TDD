<?php
namespace Tests\Feature\Forum;

use Illuminate\Support\Facades\Redis;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Libraries\Trending;

class TrendingThreadTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->trending = new Trending();

        $this->trending->reset();
    }

    /** @test */
    public function it_increments_a_threads_score_each_time_it_is_read()
    {
        $this->assertEmpty($this->trending->get());
        
        // Given that we have a thread
        $thread = create('App\Models\Thread');

        $this->call('GET', $thread->path());

        $trending = $this->trending->get();

        $this->assertCount(1, $trending);

        $this->assertEquals($thread->title, $trending[0]->title);
    }
}