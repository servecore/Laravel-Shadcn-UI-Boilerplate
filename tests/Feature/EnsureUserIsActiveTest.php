<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnsureUserIsActiveTest extends TestCase
{
    use RefreshDatabase;

    public function test_inactive_user_is_redirected_to_login(): void
    {
        $user = User::factory()->create(['is_active' => false]);

        $response = $this->actingAs($user)
            ->get(route('dashboard'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_inactive_user_gets_json_forbidden_on_ajax_request(): void
    {
        $user = User::factory()->create(['is_active' => false]);

        $response = $this->actingAs($user)
            ->getJson(route('dashboard'));

        $response->assertStatus(403);
        $response->assertJson(['message' => 'Your account has been deactivated.']);
        $this->assertGuest();
    }

    public function test_active_user_can_access_dashboard(): void
    {
        $user = User::factory()->create(['is_active' => true]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk();
    }
}
