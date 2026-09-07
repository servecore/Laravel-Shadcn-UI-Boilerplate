/**
 * User Create Module
 * Returns form fields for new user creation.
 */

/**
 * Get create form fields (empty values).
 * @returns {Array} Form field definitions
 */
export function getCreateFormFields() {
    return [
        { name: 'name', label: 'Name', type: 'text', value: '', required: true, placeholder: 'Enter full name' },
        { name: 'username', label: 'Username', type: 'text', value: '', required: true, placeholder: 'Enter username' },
        { name: 'email', label: 'Email', type: 'email', value: '', required: true, placeholder: 'Enter email address' },
        { name: 'password', label: 'Password', type: 'password', value: '', required: true, placeholder: 'Enter password', autocomplete: 'new-password' },
        { name: 'password_confirmation', label: 'Confirm Password', type: 'password', value: '', required: true, placeholder: 'Confirm password', autocomplete: 'new-password' },
        { name: 'role', label: 'Role', type: 'select', value: 'user', required: true, options: [{ value: 'user', label: 'User' }, { value: 'admin', label: 'Admin' }] },
        { name: 'is_active', label: 'Status', type: 'checkbox', value: true, checkboxLabel: 'Active' },
    ];
}