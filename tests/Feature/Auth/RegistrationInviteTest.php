<?php

namespace Tests\Feature;

use App\Mail\RegistrationInviteMail;
use App\Models\RegistrationInvite;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RegistrationInviteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        Role::firstOrCreate(['name' => 'user']);
    }

    public function test_visitor_can_request_a_registration_invite(): void
    {
        $response = $this->post(route('register.store'), [
            'email' => 'new@example.com',
        ]);

        $response->assertRedirect(route('register'));
        $response->assertSessionHas('invitation_email', 'new@example.com');

        $this->assertDatabaseHas('registration_invites', ['email' => 'new@example.com']);

        Mail::assertSent(RegistrationInviteMail::class, function ($mail) {
            return $mail->hasTo('new@example.com');
        });
    }

    public function test_registration_is_rejected_when_email_already_registered(): void
    {
        User::factory()->create(['email' => 'exist@example.com']);

        $this->post(route('register.store'), ['email' => 'exist@example.com'])
            ->assertSessionHasErrors('email');

        $this->assertDatabaseMissing('registration_invites', ['email' => 'exist@example.com']);
    }

    public function test_registration_requires_an_email(): void
    {
        $this->post(route('register.store'), ['email' => ''])
            ->assertSessionHasErrors('email');
    }

    public function test_registration_rejects_an_invalid_email_format(): void
    {
        $this->post(route('register.store'), ['email' => 'not-an-email'])
            ->assertSessionHasErrors('email');
    }

    public function test_completion_requires_valid_account_details(): void
    {
        $invite = RegistrationInvite::factory()->create(['email' => 'new@example.com']);

        $this->post(route('register.complete.store', $invite->token), [
            'name' => '',
            'username' => '',
            'password' => '123',
            'password_confirmation' => '456',
        ])->assertSessionHasErrors(['name', 'username', 'password']);

        $this->assertDatabaseCount('users', 0);
    }

    public function test_completion_rejects_taken_username_at_completion(): void
    {
        User::factory()->create(['username' => 'takenname']);
        $invite = RegistrationInvite::factory()->create(['email' => 'new@example.com']);

        $this->post(route('register.complete.store', $invite->token), [
            'name' => 'Jane Doe',
            'username' => 'takenname',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password',
        ])->assertSessionHasErrors('username');
    }

    public function test_registration_is_rejected_when_an_active_invite_exists(): void
    {
        RegistrationInvite::factory()->create(['email' => 'pending@example.com']);

        $this->post(route('register.store'), ['email' => 'pending@example.com'])
            ->assertSessionHasErrors('email');
    }

    public function test_valid_token_shows_completion_form(): void
    {
        $invite = RegistrationInvite::factory()->create(['email' => 'new@example.com']);

        $this->get(route('register.complete', $invite->token))
            ->assertOk()
            ->assertSee('new@example.com');
    }

    public function test_invalid_token_redirects_to_register(): void
    {
        $this->get(route('register.complete', 'invalid-token'))
            ->assertRedirect(route('register'));
    }

    public function test_expired_token_redirects_to_register(): void
    {
        $invite = RegistrationInvite::factory()->create([
            'email' => 'new@example.com',
            'expires_at' => now()->subMinute(),
        ]);

        $this->get(route('register.complete', $invite->token))
            ->assertRedirect(route('register'));
    }

    public function test_expired_token_cannot_be_used_to_complete_registration(): void
    {
        $expired = RegistrationInvite::factory()->create([
            'email' => 'victim@example.com',
            'expires_at' => now()->subSecond(),
        ]);

        $response = $this->post(route('register.complete.store', $expired->token), [
            'name' => 'Should Not Exist',
            'username' => 'shouldnotexist',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password',
        ]);

        $response->assertRedirect(route('register'));
        $this->assertDatabaseMissing('users', ['email' => 'victim@example.com']);
        $this->assertGuest();

        $this->assertDatabaseHas('registration_invites', ['id' => $expired->id]);
    }

    public function test_expired_token_is_not_reusable_once_expired(): void
    {
        $invite = RegistrationInvite::factory()->create([
            'email' => 'new@example.com',
            'expires_at' => now()->subHour(),
        ]);

        $this->post(route('register.complete.store', $invite->token), [
            'name' => 'Jane Doe',
            'username' => 'janedoe',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password',
        ])->assertRedirect(route('register'));

        $this->post(route('register.complete.store', $invite->token), [
            'name' => 'Jane Doe Again',
            'username' => 'janedoe2',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password',
        ])->assertRedirect(route('register'));

        $this->assertDatabaseMissing('users', ['email' => 'new@example.com']);
    }

    public function test_unexpired_token_cannot_be_used_to_recreate_existing_user(): void
    {
        User::factory()->create(['email' => 'exist@example.com']);
        $invite = RegistrationInvite::factory()->create([
            'email' => 'exist@example.com',
            'expires_at' => now()->addMinutes(30),
        ]);

        $this->post(route('register.complete.store', $invite->token), [
            'name' => 'Jane Doe',
            'username' => 'janedoe',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password',
        ])->assertRedirect(route('register'));

        $this->assertSame(1, User::where('email', 'exist@example.com')->count());
    }

    public function test_visitor_can_complete_registration_with_valid_token(): void
    {
        $invite = RegistrationInvite::factory()->create(['email' => 'new@example.com']);

        $response = $this->post(route('register.complete.store', $invite->token), [
            'name' => 'Jane Doe',
            'username' => 'janedoe',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password',
        ]);

        $response->assertRedirect(route('dashboard'));

        $user = User::where('email', 'new@example.com')->firstOrFail();
        $this->assertSame('Jane Doe', $user->name);
        $this->assertSame('janedoe', $user->username);
        $this->assertNotNull($user->email_verified_at);
        $this->assertTrue($user->hasRole('user'));
        $this->assertNotEquals('secret-password', $user->password);
        $this->assertTrue(Hash::check('secret-password', $user->password));
        $this->assertAuthenticatedAs($user);

        $this->assertDatabaseMissing('registration_invites', ['id' => $invite->id]);
    }

    public function test_completing_with_redeemed_token_is_rejected(): void
    {
        User::factory()->create(['email' => 'exist@example.com']);
        $invite = RegistrationInvite::factory()->create(['email' => 'exist@example.com']);

        $this->post(route('register.complete.store', $invite->token), [
            'name' => 'Jane Doe',
            'username' => 'janedoe',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password',
        ])->assertRedirect(route('register'));

        $this->assertSame(1, User::where('email', 'exist@example.com')->count());
    }
}
