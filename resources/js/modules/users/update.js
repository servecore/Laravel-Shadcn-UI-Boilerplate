/**
 * User Update Module
 * Handles form submission for updating users via AJAX.
 */
import { userRoutes } from './routes.js';
import { http } from '../../lib/http.js';
import { toast } from '../../lib/toast.js';

/**
 * Submit updated user data to server.
 * @param {string|number} userId - User ID
 * @param {FormData} formData - Form data from edit modal
 * @returns {Promise<void>}
 */
export async function updateUser(userId, formData) {
    // Remove empty password fields for update
    if (!formData.get('password')) {
        formData.delete('password');
        formData.delete('password_confirmation');
    }

    try {
        const response = await http.post(userRoutes.update(userId), formData);
        toast.success(response.data?.message || 'User updated successfully');
        window.dispatchEvent(new CustomEvent('user:updated'));
    } catch (error) {
        handleUpdateError(error);
        throw error;
    }
}

/**
 * Handle update error responses.
 * @param {Error} error - Axios error object
 */
function handleUpdateError(error) {
    if (error.response?.status === 422) {
        const errors = error.response.data.errors;
        const firstError = Object.values(errors)[0]?.[0] || 'Validation failed';
        toast.error(firstError);
    } else if (error.response?.status === 403) {
        toast.error('You do not have permission to update this user');
    } else {
        toast.error(error.response?.data?.message || 'Failed to update user');
    }
}