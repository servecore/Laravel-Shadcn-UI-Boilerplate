/**
 * User Store Module
 * Handles form submission for creating new users via AJAX.
 */
import { userRoutes } from './routes.js';
import { http } from '../../lib/http.js';
import { toast } from '../../lib/toast.js';

/**
 * Submit new user data to server.
 * @param {FormData} formData - Form data from create modal
 * @returns {Promise<void>}
 */
export async function storeUser(formData) {
    try {
        const response = await http.post(userRoutes.store, formData);
        toast.success(response.data?.message || 'User created successfully');
        window.dispatchEvent(new CustomEvent('user:created'));
    } catch (error) {
        handleStoreError(error);
        throw error;
    }
}

/**
 * Handle store error responses.
 * @param {Error} error - Axios error object
 */
function handleStoreError(error) {
    if (error.response?.status === 422) {
        const errors = error.response.data.errors;
        const firstError = Object.values(errors)[0]?.[0] || 'Validation failed';
        toast.error(firstError);
    } else if (error.response?.status === 403) {
        toast.error('You do not have permission to create users');
    } else {
        toast.error(error.response?.data?.message || 'Failed to create user');
    }
}