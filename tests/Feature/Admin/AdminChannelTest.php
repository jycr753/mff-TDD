<?php
namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use App\Models\Channel;

class AdminChannelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_access_channel_section()
    {
        $admin = create('App\Models\User');
        config(['council.admin' => [$admin->email]]);

        $this->signIn($admin)
            ->actingAs($admin)
            ->get(route('admin.channels.index'))
            ->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function a_non_admin_can_not_access_channel_section()
    {
        $user = create('App\Models\User');

        $this->signIn($user)
            ->actingAs($user)
            ->get(route('admin.channels.index'))
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->signIn($user)
            ->actingAs($user)
            ->get(route('admin.channels.create'))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function an_admin_can_create_channel()
    {
        $response = $this->createChannel(
            [
                'name' => 'php',
                'description' => 'A channel for php'
            ]
        );

        $this->get($response->headers->get('Location'))
            ->assertSee('php')
            ->assertSee('A channel for php');
    }

    /** @test */
    public function a_admin_can_edit_an_exisiting_channel()
    {
        $this->signInAdmin();

        $channel = create('App\Models\Channel');

        $updated_channel = [
            'name' => 'changed',
            'description' => 'A channel for php'
        ];

        $this->patch(
            route('admin.channels.update', ['channel' => $channel->slug]),
            $updated_channel
        );

        $this->get(route('admin.channels.index'))
            ->assertSee($updated_channel['name'])
            ->assertSee($updated_channel['description']);
    }

    /** @test */
    public function an_admin_can_marke_existing_channel_as_archived()
    {
        $this->signInAdmin();

        $channel = create('App\Models\Channel');

        $this->assertFalse($channel->archived);

        $updated_channel = [
            'name' => 'changed',
            'description' => 'A channel for php',
            'archived' => true
        ];

        $this->patch(
            route('admin.channels.update', ['channel' => $channel->slug]),
            $updated_channel
        );

        $this->assertTrue($channel->fresh()->archived);
    }

    /** @test */
    public function a_Channel_needs_a_name()
    {
        $this->createChannel(
            [
                'name' => null,
                'description' => 'A channel for php'
            ]
        )->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_channel_needs_description()
    {
        $this->createChannel(
            [
                'name' => 'php',
                'description' => null
            ]
        )->assertSessionHasErrors('description');
    }

    public function createChannel($overrides = [])
    {
        $admin = factory('App\Models\User')->create();
        config(['council.admin' => [$admin->email]]);

        $this->signIn($admin);

        $channel = make(Channel::class, $overrides);

        return $this->post('/admin/channels', $channel->toArray());

    }
}