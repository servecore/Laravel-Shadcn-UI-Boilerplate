---
paths:
  - 'app/Http/Controllers/Rbac/**'
---

# Rbac

## Permission CRUD: manage-permissions guard, kebab-case names, self protection
Permission catalog is its own resource: routes guarded by `permission:manage-permissions` (seeded, granted to admin), view at pages/rbac/permissions. Permission names must be kebab-case `[a-z0-9]+(-[a-z0-9]+)*` so the roles matrix grouping (action-resource) works. Deleting `manage-permissions` itself is blocked (self-protection), mirroring the admin-role guard. Permission/Role route keys are encrypted via HasEncryptedRouteKey.
