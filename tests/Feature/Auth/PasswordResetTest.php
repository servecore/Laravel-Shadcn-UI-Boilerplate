<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_password_form_is_displayed(): void
    {
        $response = $this->get(route('forgot-password'));

        $response->assertStatus(200);
        $response->assertSee('Forgot password');
        $response->assertSee('Send reset link');
    }

    public function test_email_is_required_for_password_reset(): void
    {
        $response = $this->post(route('forgot-password.store'), [
            'email' => '',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_email_must_be_valid_format(): void
    {
        $response = $this->post(route('forgot-password.store'), [
            'email' => 'not-an-email',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_valid_email_returns_response(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('forgot-password.store'), [
            'email' => $user->email,
        ]);

        // Should not return validation errors
        $response->assertSessionHasNoErrors('email');
    }

    public function test_nonexistent_email_returns_response(): void
    {
        // Laravel intentionally returns same response for security
        $response = $this->post(route('forgot-password.store'), [
            'email' => 'nonexistent@example.com',
        ]);

        // Should not leak whether email exists
        $this->assertTrue(
            $response->isOk() || $response->getStatusCode() === 302
        );
    }

    public function test_guest_can_access_forgot_password_form(): void
    {
        $response = $this->get(route('forgot-password'));

        $response->assertStatus(200);
    }

    public function test_authenticated_user_is_redirected_from_forgot_password(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('forgot-password'));

        // Auth users are redirected by guest middleware
        $response->assertRedirect();
    }

    public function test_reset_password_form_is_displayed(): void
    {
        $response = $this->get(route('password.reset', [
            'token' => 'fake-token',
            'email' => 'test@example.com',
        ]));

        $response->assertStatus(200);
        $response->assertSee('Set new password');
    }

    public function test_reset_password_requires_token(): void
    {
        $response = $this->post(route('password.store'), [
            'token' => '',
            'email' => 'test@example.com',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertSessionHasErrors('token');
    }

    public function test_reset_password_requires_email(): void
    {
        $response = $this->post(route('password.store'), [
            'token' => 'fake-token',
            'email' => '',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_reset_password_requires_password(): void
    {
        $response = $this->post(route('password.store'), [
            'token' => 'fake-token',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_reset_password_requires_password_confirmation(): void
    {
        $response = $this->post(route('password.store'), [
            'token' => 'fake-token',
            'email' => 'test@example.com',
            'password' => 'new-password',
            'password_confirmation' => 'different-password',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_reset_password_email_must_be_valid_format(): void
    {
        $response = $this->post(route('password.store'), [
            'token' => 'fake-token',
            'email' => 'not-an-email',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertSessionHasErrors('email');
    }
}
