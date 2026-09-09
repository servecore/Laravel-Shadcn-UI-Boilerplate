/**
 * Role List Module
 * Handles role list rendering, rolu selection, permission matrix, and CRUD operations.
 * Works with server-rendered list as fallback (progressive enhancement).
 */
import { roleRoutes } from './routes.js';
import { http } from '../../lib/http.js';
import { toast } from '../../lib/toast.js';
import { AppModal } from '../../components/modal.js';

export class RoleList {
    constructor() {
        this.listBody = document.querySelector('#list-roles');
        this.createBtn = document.querySelector('#btn-create-role');
        this.selectedRoleNameEl = document.querySelector('#selected-role-name');
        this.selectedRoleIdInput = document.querySelector('#selected-role-id');
        this.deleteSelectedBtn = document.querySelector('#btn-delete-selected-role');
        this.savePermissionsBtn = document.querySelector('[data-action="save-permissions"]');
        this.cancelPermissionsBtn = document.querySelector('[data-action="cancel"]');
        this.modal = null;
        this.selectedRoleId = this.selectedRoleIdInput?.value ?? null;
        this.selectedRoleName = this.selectedRoleNameEl?.textContent?.trim() ?? null;
        this.init();
    }

    init() {
        if (!this.listBody) return;

        // Event delegation for role list actions
        this.listBody.addEventListener('click', (e) => this.handleAction(e));

        // Create button
        if (this.createBtn) {
            this.createBtn.addEventListener('click', () => this.openCreateModal());
        }

        // Permission save / cancel
        if (this.savePermissionsBtn) {
            this.savePermissionsBtn.addEventListener('click', () => this.savePermissions());
        }
        if (this.cancelPermissionsBtn) {
            this.cancelPermissionsBtn.addEventListener('click', () => this.cancelPermissions());
        }
    }

    async reload() {
        try {
            const container = document.querySelector('[data-entity="roles"]');
            const fetchUrl = container?.dataset.fetchUrl || roleRoutes.index;
            const response = await http.get(fetchUrl);
            const html = typeof response.data === 'string' ? response.data : '';
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newBody = doc.querySelector('#list-roles');
            if (newBody && this.listBody) {
                this.listBody.innerHTML = newBody.innerHTML;
            }
        } catch {
            // Silent fail — keep existing list
        }
    }

    handleAction(e) {
        const item = e.target.closest('[data-action="select"]');
        const editBtn = e.target.closest('[data-action="edit"]');
        const deleteBtn = e.target.closest('[data-action="delete"]');

        if (editBtn) {
            e.preventDefault();
            this.openEditModal(editBtn.dataset.roleId);
        } else if (deleteBtn) {
            e.preventDefault();
            this.confirmDelete(deleteBtn.dataset.roleId);
        } else if (item) {
            e.preventDefault();
            this.selectRole(item);
        }
    }

    selectRole(item) {
        const roleId = item.dataset.roleId;
        const roleName = item.dataset.roleName;

        this.selectedRoleId = roleId;
        this.selectedRoleName = roleName;

        if (this.selectedRoleNameEl) {
            this.selectedRoleNameEl.textContent = roleName;
        }
        if (this.selectedRoleIdInput) {
            this.selectedRoleIdInput.value = roleId;
        }
        if (this.deleteSelectedBtn) {
            this.deleteSelectedBtn.setAttribute('data-role-id', roleId);
        }

        // Visual selection
        this.listBody.querySelectorAll('[data-action="select"]').forEach((el) => {
            el.classList.toggle('bg-muted', el === item);
        });

        // Load permissions for the selected role
        this.loadPermissions(roleId);
    }

    async loadPermissions(roleId) {
        try {
            const response = await http.get(roleRoutes.edit(roleId));
            const role = response.data.role || response.data;
            const permissionIds = (role.permissions || []).map((id) => String(id));
            this.applyPermissionState(permissionIds);
        } catch {
            toast.error('Failed to load role permissions');
        }
    }

    applyPermissionState(checkedIds) {
        // Checkboxes live in the permission panel, not the list body.
        document.querySelectorAll('[data-permission-id]').forEach((box) => {
            const checked = checkedIds.includes(box.dataset.permissionId);
            this.setCheckboxState(box, checked);
        });
    }

    setCheckboxState(box, checked) {
        const isChecked = box.dataset.state === 'checked';
        if (checked && !isChecked) {
            box.click();
        } else if (!checked && isChecked) {
            box.click();
        }
    }

    savePermissions() {
        if (!this.selectedRoleId) {
            toast.error('Select a role first');
            return;
        }

        const permissionIds = Array.from(
            document.querySelectorAll('[data-permission-id][data-state="checked"]'),
        ).map((box) => box.dataset.permissionId);

        const btn = this.savePermissionsBtn;
        const originalLabel = btn?.innerHTML;
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = 'Saving...';
        }

        http.put(roleRoutes.update(this.selectedRoleId), {
            name: this.selectedRoleName,
            permissions: permissionIds,
        })
            .then((response) => {
                toast.success(response.data?.message || 'Permissions updated successfully');
                this.loadPermissions(this.selectedRoleId);
            })
            .catch((error) => {
                toast.error(error.message || 'Failed to update permissions');
            })
            .finally(() => {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = originalLabel;
                }
            });
    }

    cancelPermissions() {
        if (this.selectedRoleId) {
            this.loadPermissions(this.selectedRoleId);
        }
    }

    openCreateModal() {
        this.modal = new AppModal({
            title: 'Create Role',
            size: 'md',
            formAction: roleRoutes.store,
            method: 'POST',
            fields: this.getFormFields(),
            onSubmit: (formData) => this.storeRole(formData),
        });
        this.modal.open();
    }

    openEditModal(roleId) {
        http.get(roleRoutes.edit(roleId))
            .then((response) => {
                const role = response.data.role || response.data;
                this.modal = new AppModal({
                    title: 'Edit Role',
                    size: 'md',
                    formAction: roleRoutes.update(roleId),
                    method: 'PUT',
                    fields: this.getFormFields(role),
                    onSubmit: (formData) => this.updateRole(roleId, formData),
                });
                this.modal.open();
            })
            .catch(() => toast.error('Failed to load role data'));
    }

    confirmDelete(roleId) {
        this.modal = new AppModal({
            title: 'Delete Role',
            message: 'Are you sure you want to delete this role? This action cannot be undone.',
            confirmText: 'Delete',
            cancelText: 'Cancel',
            variant: 'destructive',
            onConfirm: () => this.destroyRole(roleId),
        });
        this.modal.open();
    }

    getFormFields(role = null) {
        return [
            { name: 'name', label: 'Name', type: 'text', value: role?.name ?? '', required: true, placeholder: 'e.g. editor' },
        ];
    }

    async storeRole(formData) {
        this.modal?.setLoading(true);
        try {
            const response = await http.post(roleRoutes.store, formData);
            toast.success(response.data?.message || 'Role created successfully');
            this.modal?.close();
            this.reload();
            return response;
        } catch (error) {
            this.modal?.setLoading(false);
            if (error.errors) {
                this.modal?.showErrors(error.errors);
            } else {
                toast.error(error.message || 'Failed to create role');
            }
            throw error;
        }
    }

    async updateRole(roleId, formData) {
        this.modal?.setLoading(true);
        try {
            const response = await http.put(roleRoutes.update(roleId), formData);
            toast.success(response.data?.message || 'Role updated successfully');
            this.modal?.close();
            this.reload();
            return response;
        } catch (error) {
            this.modal?.setLoading(false);
            if (error.errors) {
                this.modal?.showErrors(error.errors);
            } else {
                toast.error(error.message || 'Failed to update role');
            }
            throw error;
        }
    }

    async destroyRole(roleId) {
        this.modal?.setLoading(true);
        try {
            const response = await http.delete(roleRoutes.destroy(roleId));
            toast.success(response.data?.message || 'Role deleted successfully');
            this.modal?.close();
            this.reload();
            return response;
        } catch (error) {
            this.modal?.setLoading(false);
            toast.error(error.message || 'Failed to delete role');
            throw error;
        }
    }
}

// Auto-initialize when module is loaded on a page that declares this entity.
// app.js dynamically imports this module only when [data-entity="roles"] exists.
// Vite module scripts are deferred, so the DOM is already parsed.
if (document.querySelector('[data-entity="roles"]')) {
    new RoleList();
}
