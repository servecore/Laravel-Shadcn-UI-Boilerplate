/**
 * User Destroy Module
 * Handles user deletion via AJAX.
 */
import { userRoutes } from './routes.js';
import { http } from '../../lib/http.js';
import { toast } from '../../lib/toast.js';

/**
 * Delete a user by ID.
 * @param {string|number} userId - User ID
 * @returns {Promise<void>}
 */
export async function destroyUser(userId) {
    try {
        const response = await http.delete(userRoutes.destroy(userId));
        toast.success(response.data?.message || 'User deleted successfully');
        window.dispatchEvent(new CustomEvent('user:deleted'));
    } catch (error) {
        handleDestroyError(error);
        throw error;
    }
}

/**
 * Handle destroy error responses.
 * @param {Error} error - Axios error object
 */
function handleDestroyError(error) {
    if (error.response?.status === 403) {
        toast.error('You do not have permission to delete this user');
    } else if (error.response?.status === 404) {
        toast.error('User not found');
    } else {
        toast.error(error.response?.data?.message || 'Failed to delete user');
    }
}