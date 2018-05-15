<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function a_thread_requires_title_and_body_to_be_updated()
    {
        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->patch(
            $thread->path(),
            [
                'title' => 'Some title'
            ]
        )->assertSessionHasErrors('body');

        $this->patch(
            $thread->path(),
            [
                'body' => 'Some body'
            ]
        )->assertSessionHasErrors('title');
    }

    /** @test */
    public function unauthorize_user_may_not_update_thread()
    {
        $thread = create('App\Thread', ['user_id' => create('App\User')->id]);

        $this->patch(
            $thread->path(),
            []
        )->assertStatus(403);
    }

    /** @test */
    public function a_thread_can_be_updated_by_its_creator()
    {
        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->patch(
            $thread->path(),
            [
                'title' => 'Changed',
                'body' => 'Changed body'
            ]
        );

        tap(
            $thread->fresh(),
            function ($thread) {
                $this->assertEquals('Changed', $thread->fresh()->title);
                $this->assertEquals('Changed body', $thread->fresh()->body);
            }
        );
    }
}
