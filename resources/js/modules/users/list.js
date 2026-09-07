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

        // Listen for custom events from other modules
        window.addEventListener('user:created', () => this.reload());
        window.addEventListener('user:updated', () => this.reload());
        window.addEventListener('user:deleted', () => this.reload());
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
            onSubmit: (formData) => this.store(formData),
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
                    onSubmit: (formData) => this.update(userId, formData),
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
            onConfirm: () => this.destroy(userId),
        });
        this.modal.open();
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

/**
 * Store user (called from modal onSubmit).
 */
export async function storeUser(formData) {
    try {
        const response = await http.post(userRoutes.store, formData);
        toast.success('User created successfully');
        window.dispatchEvent(new CustomEvent('user:created'));
        return response;
    } catch (error) {
        if (error.errors) {
            throw error;
        }
        throw error;
    }
}

/**
 * Update user.
 */
export async function updateUser(userId, formData) {
    try {
        const response = await http.post(userRoutes.update(userId), formData);
        toast.success('User updated successfully');
        window.dispatchEvent(new CustomEvent('user:updated'));
        return response;
    } catch (error) {
        if (error.errors) {
            throw error;
        }
        throw error;
    }
}

/**
 * Delete user.
 */
export async function destroyUser(userId) {
    try {
        const response = await http.post(userRoutes.destroy(userId), {});
        toast.success('User deleted successfully');
        window.dispatchEvent(new CustomEvent('user:deleted'));
        return response;
    } catch (error) {
        throw error;
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



