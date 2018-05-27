<?php
namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use App\Models\User;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_access_administrator_section()
    {
        $admin = create('App\Models\User');
        config(['council.admin' => [$admin->email]]);

        $this->signIn($admin);

        $this->actingAs($admin)
            ->get('/admin')
            ->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function a_non_admin_can_access_administrator_section()
    {
        $user = create('App\Models\User');

        $this->signIn($user);

        $this->actingAs($user)
            ->get('/admin')
            ->assertStatus(Response::HTTP_FORBIDDEN);

    }
}