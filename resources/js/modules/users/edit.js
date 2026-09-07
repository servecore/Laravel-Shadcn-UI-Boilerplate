/**
 * User Edit Module
 * Fetches user data for editing via AJAX.
 */
import { userRoutes } from './routes.js';
import { http } from '../../lib/http.js';
import { toast } from '../../lib/toast.js';

/**
 * Fetch user data by ID.
 * @param {string|number} userId - User ID
 * @returns {Promise<Object>} User data
 */
export async function fetchUser(userId) {
    try {
        const response = await http.get(userRoutes.edit(userId));
        return response.data.user || response.data;
    } catch (error) {
        toast.error('Failed to load user data');
        throw error;
    }
}

/**
 * Get edit form fields with pre-filled values.
 * @param {Object} user - User data object
 * @returns {Array} Form field definitions
 */
export function getEditFormFields(user) {
    return [
        { name: 'name', label: 'Name', type: 'text', value: user.name || '', required: true, placeholder: 'Enter full name' },
        { name: 'username', label: 'Username', type: 'text', value: user.username || '', required: true, placeholder: 'Enter username', disabled: true },
        { name: 'email', label: 'Email', type: 'email', value: user.email || '', required: true, placeholder: 'Enter email address' },
        { name: 'password', label: 'New Password', type: 'password', value: '', required: false, placeholder: 'Leave blank to keep current', autocomplete: 'new-password' },
        { name: 'password_confirmation', label: 'Confirm Password', type: 'password', value: '', required: false, placeholder: 'Confirm new password', autocomplete: 'new-password' },
        { name: 'role', label: 'Role', type: 'select', value: user.role || 'user', required: true, options: [{ value: 'user', label: 'User' }, { value: 'admin', label: 'Admin' }] },
        { name: 'is_active', label: 'Status', type: 'checkbox', value: user.is_active ?? true, checkboxLabel: 'Active' },
    ];
}