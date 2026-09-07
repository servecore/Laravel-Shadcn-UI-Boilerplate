/**
 * User module routes - single source of truth for all user CRUD endpoints.
 * Import this in other user modules to avoid hardcoded URLs.
 */
export const userRoutes = {
    index: '/users',
    store: '/users',
    edit: (id) => `/users/${id}/edit`,
    update: (id) => `/users/${id}`,
    destroy: (id) => `/users/${id}`,
};
