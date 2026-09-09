<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $permission = Permission::firstOrCreate(['name' => 'manage-permissions']);
        $role = Role::firstOrCreate(['name' => 'admin']);
        $role->givePermissionTo($permission);

        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
    }

    public function test_admin_can_view_permissions_index(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('permissions.index'));

        $response->assertOk();
        $response->assertSee('Add Permission');
    }

    public function test_user_without_permission_cannot_view_permissions_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('permissions.index'));

        $response->assertForbidden();
    }

    public function test_permissions_index_filters_by_search(): void
    {
        Permission::firstOrCreate(['name' => 'view-reports']);
        Permission::firstOrCreate(['name' => 'export-invoices']);

        $response = $this->actingAs($this->admin)
            ->get(route('permissions.index', ['search' => 'reports']));

        $response->assertOk();
        $response->assertSee('view-reports');
        $response->assertDontSee('export-invoices');
    }

    public function test_admin_can_create_permission(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('permissions.store'), [
                'name' => 'view-reports',
            ]);

        $response->assertRedirect(route('permissions.index'));

        $this->assertDatabaseHas('permissions', [
            'name' => 'view-reports',
            'guard_name' => config('auth.defaults.guard'),
        ]);
    }

    public function test_admin_can_store_permission_and_get_json(): void
    {
        $response = $this->actingAs($this->admin)
            ->postJson(route('permissions.store'), [
                'name' => 'view-reports',
            ]);

        $response->assertCreated()
            ->assertJsonPath('message', 'Permission created successfully.');

        $this->assertDatabaseHas('permissions', [
            'name' => 'view-reports',
            'guard_name' => config('auth.defaults.guard'),
        ]);
    }

    public function test_store_permission_rejects_duplicate_name(): void
    {
        Permission::firstOrCreate(['name' => 'view-reports']);

        $response = $this->actingAs($this->admin)
            ->post(route('permissions.store'), [
                'name' => 'view-reports',
            ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_store_permission_rejects_invalid_name_format(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('permissions.store'), [
                'name' => 'View Reports',
            ]);

        $response->assertSessionHasErrors('name');

        $this->assertDatabaseMissing('permissions', [
            'name' => 'View Reports',
        ]);
    }

    public function test_store_permission_requires_name(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('permissions.store'), [
                'name' => '',
            ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_admin_can_view_permission_json_for_edit_modal(): void
    {
        $permission = Permission::firstOrCreate(['name' => 'view-reports']);

        $response = $this->actingAs($this->admin)
            ->getJson(route('permissions.edit', $permission));

        $response->assertOk()
            ->assertJsonPath('permission.name', 'view-reports')
            ->assertJsonPath('permission.guard_name', config('auth.defaults.guard'));
    }

    public function test_admin_can_update_permission(): void
    {
        $permission = Permission::firstOrCreate(['name' => 'view-reports']);

        $response = $this->actingAs($this->admin)
            ->put(route('permissions.update', $permission), [
                'name' => 'view-analytics',
            ]);

        $response->assertRedirect(route('permissions.index'));

        $this->assertDatabaseHas('permissions', [
            'name' => 'view-analytics',
        ]);

        $this->assertDatabaseMissing('permissions', [
            'name' => 'view-reports',
        ]);
    }

    public function test_admin_can_update_permission_via_json(): void
    {
        $permission = Permission::firstOrCreate(['name' => 'view-reports']);

        $response = $this->actingAs($this->admin)
            ->putJson(route('permissions.update', $permission), [
                'name' => 'view-analytics',
            ]);

        $response->assertOk()
            ->assertJsonPath('message', 'Permission updated successfully.')
            ->assertJsonPath('permission.name', 'view-analytics');
    }

    public function test_admin_can_update_permission_without_changing_name(): void
    {
        $permission = Permission::firstOrCreate(['name' => 'view-reports']);

        $response = $this->actingAs($this->admin)
            ->put(route('permissions.update', $permission), [
                'name' => 'view-reports',
            ]);

        $response->assertRedirect(route('permissions.index'));

        $this->assertDatabaseHas('permissions', [
            'name' => 'view-reports',
        ]);
    }

    public function test_admin_can_delete_non_protected_permission(): void
    {
        $permission = Permission::firstOrCreate(['name' => 'view-reports']);

        $response = $this->actingAs($this->admin)
            ->delete(route('permissions.destroy', $permission));

        $response->assertRedirect(route('permissions.index'));

        $this->assertDatabaseMissing('permissions', [
            'name' => 'view-reports',
        ]);
    }

    public function test_admin_can_delete_permission_via_json(): void
    {
        $permission = Permission::firstOrCreate(['name' => 'view-reports']);

        $response = $this->actingAs($this->admin)
            ->deleteJson(route('permissions.destroy', $permission));

        $response->assertOk()
            ->assertJsonPath('message', 'Permission deleted successfully.');
    }

    public function test_admin_cannot_delete_manage_permissions_permission(): void
    {
        $response = $this->actingAs($this->admin)
            ->delete(route('permissions.destroy', Permission::firstOrCreate(['name' => 'manage-permissions'])));

        $response->assertSessionHasErrors('permission');

        $this->assertDatabaseHas('permissions', [
            'name' => 'manage-permissions',
        ]);
    }

    public function test_deleting_permission_removes_it_from_roles(): void
    {
        $permission = Permission::firstOrCreate(['name' => 'view-reports']);
        $role = Role::firstOrCreate(['name' => 'reporter']);
        $role->givePermissionTo($permission);

        $this->actingAs($this->admin)
            ->delete(route('permissions.destroy', $permission));

        $this->assertDatabaseMissing('role_has_permissions', [
            'permission_id' => $permission->id,
            'role_id' => $role->id,
        ]);

        $this->assertFalse($role->permissions()->where('permissions.id', $permission->id)->exists());
    }
}
