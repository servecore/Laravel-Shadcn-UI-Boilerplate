/**
 * Entity Module Registry
 *
 * Single Source of Truth (SOT) — all entity modules register here.
 * app.js reads this map to auto-load only modules needed by the current page.
 *
 * To add a new entity (e.g. Products):
 *   1. Create resources/js/modules/products/list.js
 *   2. Add entry here: products: () => import('./products/list.js'),
 *   3. Add data-entity="products" to the page container in Blade
 *   4. Done — no changes needed in app.js
 */
export const entityRegistry = {
    users: () => import('./users/list.js'),
    roles: () => import('./rbac/list.js'),
    permissions: () => import('./rbac/permissions.js'),
    // products: () => import('./products/list.js'),
    // posts:    () => import('./posts/list.js'),
};

/**
 * Resolve a module loader for a given entity name.
 * @param {string} entity
 * @returns {Function|undefined}
 */
export function getEntityModule(entity) {
    return entityRegistry[entity];
}

