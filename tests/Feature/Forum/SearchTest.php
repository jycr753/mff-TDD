<?php
namespace Tests\Feature\Forum;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Thread;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_search_thread()
    {
        config(['scout.driver' => 'algolia']);

        $search = 'foobar';

        create('App\Models\Thread', [], 2);
        create('App\Models\Thread', ['body' => "A thread with the {$search} term"], 2);

        do {
            sleep(1);
            $results = $this->getJson("/threads/search?q={$search}")->json()['data'];
        } while (empty($results));

        $this->assertCount(2, $results);

        Thread::latest()->take(4)->unsearchable();
    }
}
