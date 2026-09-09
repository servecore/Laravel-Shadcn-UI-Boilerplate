/**
 * Role Create Module
 * Returns form fields for new Role creation.
 */

/**
 * Get create form fields (empty values).
 * @returns {Array} Form field definitions
 */
export function getCreateFormFields() {
    return [
        { name: 'name', label: 'Name', type: 'text', value: '', required: true, placeholder: 'Enter role name' },
        { name: 'guard_name', label: 'Guard Name', type: 'text', value: '', required: true, placeholder: 'Enter guard name' },
       
    ];
}