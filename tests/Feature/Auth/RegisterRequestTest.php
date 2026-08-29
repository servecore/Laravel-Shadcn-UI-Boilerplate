<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_name_is_required(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_name_must_not_exceed_255_characters(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => str_repeat('a', 256),
            'username' => 'longname256',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_name_with_255_characters_is_valid(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => str_repeat('a', 255),
            'username' => 'longname',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_email_is_required(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_email_must_be_valid_format(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'not-an-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_email_must_be_unique(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        $response = $this->post(route('register.store'), [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'taken@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_password_is_required(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_password_must_be_confirmed(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different-password',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_password_confirmation_must_match(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));
    }

    public function test_password_must_meet_default_requirements(): void
    {
        // Too short
        $response = $this->post(route('register.store'), [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => '123',
            'password_confirmation' => '123',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_valid_registration_creates_user(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'New User',
            'username' => 'newuser',
            'email' => 'new@example.com',
            'password' => 'secure-password-123',
            'password_confirmation' => 'secure-password-123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('users', [
            'name' => 'New User',
            'username' => 'newuser',
            'email' => 'new@example.com',
        ]);
        $this->assertAuthenticated();
    }

    public function test_registered_user_is_automatically_logged_in(): void
    {
        $this->post(route('register.store'), [
            'name' => 'Auto Login User',
            'username' => 'autologin',
            'email' => 'auto@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertAuthenticated();
    }

    public function test_password_is_hashed_in_database(): void
    {
        $this->post(route('register.store'), [
            'name' => 'Hash Test',
            'username' => 'hashtest',
            'email' => 'hash@example.com',
            'password' => 'my-secure-password',
            'password_confirmation' => 'my-secure-password',
        ]);

        $user = User::where('email', 'hash@example.com')->first();
        $this->assertNotEquals('my-secure-password', $user->password);
        $this->assertTrue(Hash::check('my-secure-password', $user->password));
    }

    public function test_guest_can_access_registration_form(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertSee('Create an account');
    }

    public function test_authenticated_user_cannot_access_registration_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('register'));

        $response->assertRedirect();
    }
}
