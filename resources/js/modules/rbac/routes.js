/**
 * Role module routes - single source of truth for all Role CRUD endpoints.
 * Import this in other Role modules to avoid hardcoded URLs.
 */

export const roleRoutes = {
    index: '/roles',
    store: '/roles',
    edit: (id) => `/roles/${id}/edit`,
    update: (id) => `/roles/${id}`,
    destroy: (id) => `/roles/${id}`,
};