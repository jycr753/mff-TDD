<?php

namespace Tests\Feature\Forum;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_has_a_profile()
    {
        $user = create('App\Models\User');

        $this->get('/profiles/' . $user->name)
            ->assertSee($user->name);
    }

    /** @test */
    public function profiles_display_all_threads_created_by_the_associated_user()
    {
        $this->signIn();

        $user = create('App\Models\User');

        $thread = create('App\Models\Thread', ['user_id' => auth()->id()]);

        $this->get('/profiles/' . auth()->user()->name)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
