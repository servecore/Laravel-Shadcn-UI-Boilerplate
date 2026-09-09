<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $permission = Permission::firstOrCreate(['name' => 'manage-roles']);
        $role = Role::firstOrCreate(['name' => 'admin']);
        $role->givePermissionTo($permission);

        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
    }

    public function test_admin_can_view_roles_index(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('roles.index'));

        $response->assertOk();
        $response->assertSee('Add Role');
    }

    public function test_user_without_permission_cannot_view_roles_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('roles.index'));

        $response->assertForbidden();
    }

    public function test_admin_can_create_role(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('roles.store'), [
                'name' => 'editor',
            ]);

        $response->assertRedirect(route('roles.index'));

        $this->assertDatabaseHas('roles', [
            'name' => 'editor',
            'guard_name' => config('auth.defaults.guard'),
        ]);
    }

    public function test_admin_can_store_role_and_get_json(): void
    {
        $response = $this->actingAs($this->admin)
            ->postJson(route('roles.store'), [
                'name' => 'editor',
            ]);

        $response->assertCreated()
            ->assertJsonPath('message', 'Role created successfully.');

        $this->assertDatabaseHas('roles', [
            'name' => 'editor',
            'guard_name' => config('auth.defaults.guard'),
        ]);
    }

    public function test_store_role_rejects_duplicate_name(): void
    {
        Role::firstOrCreate(['name' => 'editor']);

        $response = $this->actingAs($this->admin)
            ->post(route('roles.store'), [
                'name' => 'editor',
            ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_store_role_requires_name(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('roles.store'), [
                'name' => '',
            ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_admin_can_view_role_json_for_edit_modal(): void
    {
        $role = Role::firstOrCreate(['name' => 'editor']);

        $response = $this->actingAs($this->admin)
            ->getJson(route('roles.edit', $role));

        $response->assertOk()
            ->assertJsonPath('role.name', 'editor')
            ->assertJsonPath('role.guard_name', config('auth.defaults.guard'));
    }

    public function test_admin_can_update_role(): void
    {
        $role = Role::firstOrCreate(['name' => 'editor']);

        $response = $this->actingAs($this->admin)
            ->put(route('roles.update', $role), [
                'name' => 'writer',
            ]);

        $response->assertRedirect(route('roles.index'));

        $this->assertDatabaseHas('roles', [
            'name' => 'writer',
        ]);

        $this->assertDatabaseMissing('roles', [
            'name' => 'editor',
        ]);
    }

    public function test_admin_can_update_role_via_json(): void
    {
        $role = Role::firstOrCreate(['name' => 'editor']);

        $response = $this->actingAs($this->admin)
            ->putJson(route('roles.update', $role), [
                'name' => 'writer',
            ]);

        $response->assertOk()
            ->assertJsonPath('message', 'Role updated successfully.')
            ->assertJsonPath('role.name', 'writer');
    }

    public function test_admin_can_delete_non_admin_role(): void
    {
        $role = Role::firstOrCreate(['name' => 'editor']);

        $response = $this->actingAs($this->admin)
            ->delete(route('roles.destroy', $role));

        $response->assertRedirect(route('roles.index'));

        $this->assertDatabaseMissing('roles', [
            'name' => 'editor',
        ]);
    }

    public function test_admin_cannot_delete_admin_role(): void
    {
        $response = $this->actingAs($this->admin)
            ->delete(route('roles.destroy', Role::firstOrCreate(['name' => 'admin'])));

        $response->assertSessionHasErrors('role');

        $this->assertDatabaseHas('roles', ['name' => 'admin']);
    }
}
