<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $permission = Permission::firstOrCreate(['name' => 'manage-users']);
        $role = Role::firstOrCreate(['name' => 'admin']);
        $role->givePermissionTo($permission);

        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
    }

    public function test_user_with_permission_can_view_users_index(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('users.index'));

        $response->assertOk();
        $response->assertSee('Users');
    }

    public function test_user_without_permission_cannot_view_users_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('users.index'));

        $response->assertForbidden();
    }

    public function test_admin_can_update_user_password(): void
    {
        $target = User::factory()->create();

        $response = $this->actingAs($this->admin)
            ->put(route('users.update', $target), [
                'name' => $target->name,
                'username' => $target->username,
                'email' => $target->email,
                'password' => 'new-secret-password',
                'password_confirmation' => 'new-secret-password',
            ]);

        $response->assertRedirect(route('users.index'));

        $this->assertTrue(
            Hash::check('new-secret-password', $target->fresh()->password)
        );
    }

    public function test_admin_can_update_user_without_changing_password(): void
    {
        $target = User::factory()->create(['password' => bcrypt('original-password')]);

        $response = $this->actingAs($this->admin)
            ->put(route('users.update', $target), [
                'name' => 'Updated Name',
                'username' => $target->username,
                'email' => $target->email,
                'password' => '',
            ]);

        $response->assertRedirect(route('users.index'));

        $this->assertTrue(
            Hash::check('original-password', $target->fresh()->password)
        );
    }

    public function test_password_requires_confirmation(): void
    {
        $target = User::factory()->create();

        $response = $this->actingAs($this->admin)
            ->put(route('users.update', $target), [
                'name' => $target->name,
                'username' => $target->username,
                'email' => $target->email,
                'password' => 'new-secret-password',
                'password_confirmation' => 'different-password',
            ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_admin_can_create_user(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('users.store'), [
                'name' => 'Jane Doe',
                'username' => 'jane',
                'email' => 'jane@example.com',
                'password' => 'secret-password',
                'password_confirmation' => 'secret-password',
            ]);

        $response->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'username' => 'jane',
            'email' => 'jane@example.com',
        ]);
    }

    public function test_create_user_rejects_duplicate_username(): void
    {
        User::factory()->create(['username' => 'taken']);

        $response = $this->actingAs($this->admin)
            ->post(route('users.store'), [
                'name' => 'Jane Doe',
                'username' => 'taken',
                'email' => 'jane@example.com',
                'password' => 'secret-password',
                'password_confirmation' => 'secret-password',
            ]);

        $response->assertSessionHasErrors('username');

        $this->assertDatabaseMissing('users', ['email' => 'jane@example.com']);
    }

    public function test_create_user_requires_password(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('users.store'), [
                'name' => 'Jane Doe',
                'username' => 'jane',
                'email' => 'jane@example.com',
                'password' => '',
                'password_confirmation' => '',
            ]);

        $response->assertSessionHasErrors('password');

        $this->assertDatabaseMissing('users', ['email' => 'jane@example.com']);
    }

    public function test_users_index_displays_assigned_roles(): void
    {
        Role::firstOrCreate(['name' => 'editor']);

        $target = User::factory()->create();
        $target->assignRole('editor');

        $response = $this->actingAs($this->admin)
            ->get(route('users.index'));

        $response->assertOk();
        $response->assertSee('admin');
        $response->assertSee('editor');
    }

    public function test_users_index_filters_by_search_and_status(): void
    {
        User::factory()->create(['name' => 'Alice Alpha', 'username' => 'alice', 'is_active' => true]);
        User::factory()->create(['name' => 'Bob Beta', 'username' => 'bob', 'is_active' => false]);

        $response = $this->actingAs($this->admin)
            ->get(route('users.index', ['search' => 'alpha']));

        $response->assertOk();
        $response->assertSee('Alice Alpha');
        $response->assertDontSee('Bob Beta');

        $response = $this->actingAs($this->admin)
            ->get(route('users.index', ['status' => 'inactive']));

        $response->assertSee('Bob Beta');
        $response->assertDontSee('Alice Alpha');
    }

    public function test_admin_can_toggle_user_active_status(): void
    {
        $target = User::factory()->create(['is_active' => true]);

        $this->actingAs($this->admin)
            ->putJson(route('users.update', $target), [
                'name' => $target->name,
                'username' => $target->username,
                'email' => $target->email,
                'is_active' => false,
            ])
            ->assertOk();

        $this->assertFalse($target->fresh()->is_active);

        $this->actingAs($this->admin)
            ->putJson(route('users.update', $target), [
                'name' => $target->name,
                'username' => $target->username,
                'email' => $target->email,
                'is_active' => true,
            ])
            ->assertOk();

        $this->assertTrue($target->fresh()->is_active);
    }

    public function test_admin_can_create_inactive_user(): void
    {
        $response = $this->actingAs($this->admin)
            ->postJson(route('users.store'), [
                'name' => 'Jane Doe',
                'username' => 'jane',
                'email' => 'jane@example.com',
                'password' => 'secret-password',
                'password_confirmation' => 'secret-password',
                'is_active' => false,
            ]);

        $response->assertCreated();

        $this->assertDatabaseHas('users', [
            'username' => 'jane',
            'is_active' => false,
        ]);
    }

    public function test_user_cannot_deactivate_own_account(): void
    {
        $response = $this->actingAs($this->admin)
            ->putJson(route('users.update', $this->admin), [
                'name' => $this->admin->name,
                'username' => $this->admin->username,
                'email' => $this->admin->email,
                'is_active' => false,
            ]);

        $response->assertStatus(422);

        $this->assertTrue($this->admin->fresh()->is_active);
    }

    public function test_user_cannot_delete_own_account(): void
    {
        $response = $this->actingAs($this->admin)
            ->delete(route('users.destroy', $this->admin));

        $response->assertSessionHasErrors('user');

        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    public function test_admin_can_delete_another_user(): void
    {
        $target = User::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete(route('users.destroy', $target));

        $response->assertRedirect(route('users.index'));

        $this->assertSoftDeleted('users', ['id' => $target->id]);
    }
}
