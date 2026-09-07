<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_settings_page_renders_with_default_preferences(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('settings'))
            ->assertOk()
            ->assertSee('Communication emails');
    }

    public function test_preferences_persist_on_the_user_record(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put(route('settings.update'), [
                'comm_emails' => '0',
                'marketing_emails' => '1',
                'social_emails' => '0',
            ])
            ->assertSessionHas('status');

        $this->assertSame([
            'comm_emails' => false,
            'marketing_emails' => true,
            'social_emails' => false,
            'security_emails' => true,
        ], $user->fresh()->preferences);
    }

    public function test_preferences_survive_session_switch(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put(route('settings.update'), ['marketing_emails' => '1']);

        // Simulate logout/login: preferences must come from the user record,
        // never from a cleared session.
       Auth::logout();
        $this->actingAs($user->fresh());

        $this->assertSame(true, $user->fresh()->preferences['marketing_emails']);

        $this->get(route('settings'))
            ->assertOk();
    }
}
