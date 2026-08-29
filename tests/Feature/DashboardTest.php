<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_access_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    public function test_guest_cannot_access_dashboard(): void
    {
        $response = $this->get(route('dashboard'));

        // Auth middleware blocks unauthenticated access
        $this->assertNotTrue($response->isOk());
    }

    public function test_dashboard_shows_user_name(): void
    {
        $user = User::factory()->create(['name' => 'John Doe']);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSee('John Doe');
    }
}
