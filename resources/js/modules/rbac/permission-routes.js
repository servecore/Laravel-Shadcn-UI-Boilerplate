/**
 * Permission module routes - single source of truth for all permission CRUD endpoints.
 * Import this in other permission modules to avoid hardcoded URLs.
 */

export const permissionRoutes = {
    index: '/permissions',
    store: '/permissions',
    edit: (id) => `/permissions/${id}/edit`,
    update: (id) => `/permissions/${id}`,
    destroy: (id) => `/permissions/${id}`,
};