/**
 * Role List Module
 * Handles role list rendering, action buttons, and AJAX operations.
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
        this.modal = null;
        this.init();
    }

    init() {
        if (!this.listBody) return;

        // Event delegation for action buttons
        this.listBody.addEventListener('click', (e) => this.handleAction(e));

        // Create button
        if (this.createBtn) {
            this.createBtn.addEventListener('click', () => this.openCreateModal());
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
        const editBtn = e.target.closest('[data-action="edit"]');
        const deleteBtn = e.target.closest('[data-action="delete"]');

        if (editBtn) {
            e.preventDefault();
            this.openEditModal(editBtn.dataset.roleId);
        } else if (deleteBtn) {
            e.preventDefault();
            this.confirmDelete(deleteBtn.dataset.roleId);
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
