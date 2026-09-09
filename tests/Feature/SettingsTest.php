<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $permission = Permission::firstOrCreate(['name' => 'manage-settings']);
        $role = Role::firstOrCreate(['name' => 'admin']);
        $role->givePermissionTo($permission);

        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
    }

    public function test_settings_page_renders_with_default_preferences(): void
    {
        $this->actingAs($this->admin)
            ->get(route('settings'))
            ->assertOk()
            ->assertSee('Communication emails');
    }

    public function test_user_without_permission_cannot_access_settings(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('settings'))
            ->assertForbidden();
    }

    public function test_preferences_persist_on_the_user_record(): void
    {
        $this->actingAs($this->admin)
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
        ], $this->admin->fresh()->preferences);
    }

    public function test_preferences_survive_session_switch(): void
    {
        $this->actingAs($this->admin)
            ->put(route('settings.update'), ['marketing_emails' => '1']);

        // Simulate logout/login: preferences must come from the user record,
        // never from a cleared session.
        Auth::logout();
        $this->actingAs($this->admin->fresh());

        $this->assertSame(true, $this->admin->fresh()->preferences['marketing_emails']);

        $this->get(route('settings'))
            ->assertOk();
    }
}
