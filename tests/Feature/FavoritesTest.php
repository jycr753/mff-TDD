<?php

namespace Tests\Feature;

use App\Favorite;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guest_can_not_favorite_anything()
    {
        $this->withExceptionHandling()
            ->post('/replies/1/favorites')
                ->assertRedirect('/login');

    }

    /** @test */
    public function a_auth_user_can_favor_any_reply()
    {
        /**
         * If I post favorate
         * It should be pssbile to save it to db
         * '/replies/id/favorites'
         */
        $this->signIn();

        $reply = create('App\Reply'); //It also creates Thread in teh process

        $this->post('replies/'.$reply->id.'/favorites');

        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function a_auth_user_can_unfavor_any_reply()
    {
        $this->signIn();

        $reply = create('App\Reply'); //It also creates Thread in teh process

        $reply->favorite();

        //$this->post('replies/'.$reply->id.'/favorites'); //Thanks to the above, this is redundent
        //$this->assertCount(1, $reply->favorites);

        $this->delete('replies/'.$reply->id.'/favorites');

        $this->assertCount(0, $reply->favorites);
    }

    /** @test */
    public function an_auth_user_may_favor_replies_once()
    {
        $this->signIn();

        $reply = create('App\Reply'); //It also creates Thread in teh process

        try {
            $this->post('replies/'.$reply->id.'/favorites');
            $this->post('replies/'.$reply->id.'/favorites');
        } catch (\Exception $e) {
            $this->fail('duplicate');
        }

        $this->assertCount(1, $reply->favorites);
    }
}
