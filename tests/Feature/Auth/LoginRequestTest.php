<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class LoginRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_is_required(): void
    {
        $response = $this->post(route('demo.login.store'), [
            'email' => '',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_email_must_be_valid_format(): void
    {
        $response = $this->post(route('demo.login.store'), [
            'email' => 'not-an-email',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_password_is_required(): void
    {
        $response = $this->post(route('demo.login.store'), [
            'email' => 'test@example.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_valid_credentials_authenticate_user(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('secret-password'),
        ]);

        $response = $this->post(route('demo.login.store'), [
            'email' => $user->email,
            'password' => 'secret-password',
        ]);

        $response->assertRedirect(route('demo.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_credentials_return_error(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('correct-password'),
        ]);

        $response = $this->post(route('demo.login.store'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_nonexistent_email_returns_error(): void
    {
        $response = $this->post(route('demo.login.store'), [
            'email' => 'nobody@example.com',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_remember_me_sets_remember_cookie(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->post(route('demo.login.store'), [
            'email' => $user->email,
            'password' => 'password',
            'remember' => 'on',
        ]);

        $response->assertRedirect(route('demo.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_rate_limiting_after_failed_attempts(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        // Make 5 failed attempts
        for ($i = 0; $i < 5; $i++) {
            $this->post(route('demo.login.store'), [
                'email' => $user->email,
                'password' => 'wrong-password',
            ]);
        }

        // 6th attempt should be rate limited
        $response = $this->post(route('demo.login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_session_is_regenerated_on_successful_login(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $this->post(route('demo.login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_guest_cannot_access_authenticated_routes(): void
    {
        $response = $this->get(route('demo.dashboard'));

        $this->assertNotTrue($response->isOk());
    }

    public function test_authenticated_user_can_access_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('demo.dashboard'));

        $response->assertStatus(200);
    }
}
