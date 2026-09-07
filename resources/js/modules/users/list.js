/**
 * User List Module
 * Handles user table rendering, action buttons, and AJAX operations.
 * Works with server-rendered table as fallback (progressive enhancement).
 */
import { userRoutes } from './routes.js';
import { http } from '../../lib/http.js';
import { toast } from '../../lib/toast.js';
import { AppModal } from '../../components/modal.js';

export class UserList {
    constructor() {
        this.tableBody = document.querySelector('#users-table-body');
        this.createBtn = document.querySelector('#btn-create-user');
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
            const container = document.querySelector('[data-entity="users"]');
            const fetchUrl = container?.dataset.fetchUrl || userRoutes.index;
            const response = await http.get(fetchUrl);
            const html = typeof response.data === 'string' ? response.data : '';
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newBody = doc.querySelector('#users-table-body');
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
            this.openEditModal(editBtn.dataset.userId);
        } else if (deleteBtn) {
            e.preventDefault();
            this.confirmDelete(deleteBtn.dataset.userId);
        }
    }

    openCreateModal() {
        this.modal = new AppModal({
            title: 'Create User',
            size: 'lg',
            formAction: userRoutes.store,
            method: 'POST',
            fields: this.getFormFields(),
            onSubmit: (formData) => this.storeUser(formData),
        });
        this.modal.open();
    }

    openEditModal(userId) {
        http.get(userRoutes.edit(userId))
            .then((response) => {
                const user = response.data.user || response.data;
                this.modal = new AppModal({
                    title: 'Edit User',
                    size: 'lg',
                    formAction: userRoutes.update(userId),
                    method: 'PUT',
                    fields: this.getFormFields(user),
                    onSubmit: (formData) => this.updateUser(userId, formData),
                });
                this.modal.open();
            })
            .catch(() => toast.error('Failed to load user data'));
    }

    confirmDelete(userId) {
        this.modal = new AppModal({
            title: 'Delete User',
            message: 'Are you sure you want to delete this user? This action cannot be undone.',
            confirmText: 'Delete',
            cancelText: 'Cancel',
            variant: 'destructive',
            onConfirm: () => this.destroyUser(userId),
        });
        this.modal.open();
    }

    async storeUser(formData) {
        try {
            const response = await http.post(userRoutes.store, formData);
            toast.success(response.data?.message || 'User created successfully');
            this.modal?.close();
            this.reload();
            return response;
        } catch (error) {
            if (error.errors) {
                this.modal?.showErrors(error.errors);
            } else {
                toast.error(error.message || 'Failed to create user');
            }
            throw error;
        }
    }

    async updateUser(userId, formData) {
        try {
            const response = await http.put(userRoutes.update(userId), formData);
            toast.success(response.data?.message || 'User updated successfully');
            this.modal?.close();
            this.reload();
            return response;
        } catch (error) {
            if (error.errors) {
                this.modal?.showErrors(error.errors);
            } else {
                toast.error(error.message || 'Failed to update user');
            }
            throw error;
        }
    }

    async destroyUser(userId) {
        try {
            const response = await http.delete(userRoutes.destroy(userId));
            toast.success(response.data?.message || 'User deleted successfully');
            this.modal?.close();
            this.reload();
            return response;
        } catch (error) {
            toast.error(error.message || 'Failed to delete user');
            throw error;
        }
    }

    getFormFields(user = null) {
        const isEdit = !!user;
        return [
            { name: 'name', label: 'Name', type: 'text', value: user?.name ?? '', required: true, placeholder: 'Enter full name' },
            { name: 'username', label: 'Username', type: 'text', value: user?.username ?? '', required: true, placeholder: 'Enter username', disabled: isEdit },
            { name: 'email', label: 'Email', type: 'email', value: user?.email ?? '', required: true, placeholder: 'Enter email address' },
            { name: 'password', label: isEdit ? 'New Password' : 'Password', type: 'password', value: '', required: !isEdit, placeholder: isEdit ? 'Leave blank to keep current' : 'Enter password', autocomplete: 'new-password' },
            { name: 'password_confirmation', label: 'Confirm Password', type: 'password', value: '', required: !isEdit, placeholder: 'Confirm password', autocomplete: 'new-password' },
            { name: 'role', label: 'Role', type: 'select', value: user?.role ?? 'user', required: true, options: [{ value: 'user', label: 'User' }, { value: 'admin', label: 'Admin' }] },
            { name: 'is_active', label: 'Status', type: 'checkbox', value: user?.is_active ?? true, checkboxLabel: 'Active' },
        ];
    }
}


// Auto-initialize when module is loaded on a page that declares this entity.
// app.js dynamically imports this module only when [data-entity="users"] exists,
// so no DOM sniffing is needed here — safe to instantiate directly.
// Vite module scripts are deferred, so the DOM is already parsed.
const ENTITY = 'users';

if (document.querySelector(`[data-entity="${ENTITY}"]`)) {
    new UserList();
}



