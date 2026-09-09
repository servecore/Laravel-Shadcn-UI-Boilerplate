/**
 * Permission List Module
 * Handles permission table rendering, action buttons, and AJAX operations.
 * Works with server-rendered table as fallback (progressive enhancement).
 */
import { permissionRoutes } from './permission-routes.js';
import { http } from '../../lib/http.js';
import { toast } from '../../lib/toast.js';
import { AppModal } from '../../components/modal.js';

export class PermissionList {
    constructor() {
        this.tableBody = document.querySelector('#permissions-table-body');
        this.createBtn = document.querySelector('#btn-create-permission');
        this.modal = null;
        this.init();
    }

    init() {
        if (!this.tableBody) return;

        // Event delegation for action buttons
        this.tableBody.addEventListener('click', (e) => this.handleAction(e));

        // Create button
        if (this.createBtn) {
            this.createBtn.addEventListener('click', () => this.openCreateModal());
        }
    }

    async reload() {
        try {
            const container = document.querySelector('[data-entity="permissions"]');
            const fetchUrl = container?.dataset.fetchUrl || permissionRoutes.index;
            const response = await http.get(fetchUrl);
            const html = typeof response.data === 'string' ? response.data : '';
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newBody = doc.querySelector('#permissions-table-body');
            if (newBody && this.tableBody) {
                this.tableBody.innerHTML = newBody.innerHTML;
            }
        } catch {
            // Silent fail — keep existing table
        }
    }

    handleAction(e) {
        const editBtn = e.target.closest('[data-action="edit"]');
        const deleteBtn = e.target.closest('[data-action="delete"]');

        if (editBtn) {
            e.preventDefault();
            this.openEditModal(editBtn.dataset.permissionId);
        } else if (deleteBtn) {
            e.preventDefault();
            this.confirmDelete(deleteBtn.dataset.permissionId);
        }
    }

    openCreateModal() {
        this.modal = new AppModal({
            title: 'Create Permission',
            size: 'md',
            formAction: permissionRoutes.store,
            method: 'POST',
            fields: this.getFormFields(),
            onSubmit: (formData) => this.storePermission(formData),
        });
        this.modal.open();
    }

    openEditModal(permissionId) {
        http.get(permissionRoutes.edit(permissionId))
            .then((response) => {
                const permission = response.data.permission || response.data;
                this.modal = new AppModal({
                    title: 'Edit Permission',
                    size: 'md',
                    formAction: permissionRoutes.update(permissionId),
                    method: 'PUT',
                    fields: this.getFormFields(permission),
                    onSubmit: (formData) => this.updatePermission(permissionId, formData),
                });
                this.modal.open();
            })
            .catch(() => toast.error('Failed to load permission data'));
    }

    confirmDelete(permissionId) {
        this.modal = new AppModal({
            title: 'Delete Permission',
            message: 'Are you sure you want to delete this permission? This action cannot be undone.',
            confirmText: 'Delete',
            cancelText: 'Cancel',
            variant: 'destructive',
            onConfirm: () => this.destroyPermission(permissionId),
        });
        this.modal.open();
    }

    getFormFields(permission = null) {
        return [
            { name: 'name', label: 'Name', type: 'text', value: permission?.name ?? '', required: true, placeholder: 'e.g. view-reports' },
        ];
    }

    async storePermission(formData) {
        this.modal?.setLoading(true);
        try {
            const response = await http.post(permissionRoutes.store, formData);
            toast.success(response.data?.message || 'Permission created successfully');
            this.modal?.close();
            this.reload();
            return response;
        } catch (error) {
            this.modal?.setLoading(false);
            if (error.errors) {
                this.modal?.showErrors(error.errors);
            } else {
                toast.error(error.message || 'Failed to create permission');
            }
            throw error;
        }
    }

    async updatePermission(permissionId, formData) {
        this.modal?.setLoading(true);
        try {
            const response = await http.put(permissionRoutes.update(permissionId), formData);
            toast.success(response.data?.message || 'Permission updated successfully');
            this.modal?.close();
            this.reload();
            return response;
        } catch (error) {
            this.modal?.setLoading(false);
            if (error.errors) {
                this.modal?.showErrors(error.errors);
            } else {
                toast.error(error.message || 'Failed to update permission');
            }
            throw error;
        }
    }

    async destroyPermission(permissionId) {
        this.modal?.setLoading(true);
        try {
            const response = await http.delete(permissionRoutes.destroy(permissionId));
            toast.success(response.data?.message || 'Permission deleted successfully');
            this.modal?.close();
            this.reload();
            return response;
        } catch (error) {
            this.modal?.setLoading(false);
            toast.error(error.message || 'Failed to delete permission');
            throw error;
        }
    }

}

// Auto-initialize when module is loaded on a page that declares this entity.
// app.js dynamically imports this module only when [data-entity="permissions"] exists.
// Vite module scripts are deferred, so the DOM is already parsed.
const ENTITY = 'permissions';

if (document.querySelector(`[data-entity="${ENTITY}"]`)) {
    new PermissionList();
}