---
paths:
  - 'resources/views/pages/rbac/**'
---

# Pages Rbac

## Roles permission matrix: dynamic action columns, direct DOM state sync
Roles permission matrix: action columns are derived from the data (`RoleController` builds `actionColumns` from unique `before('-')` actions), never a hardcoded 5-set, so permissions like `export-invoices` stay assignable. Matrix features: `#permission-search` filters `.permission-group` sections, per-resource Check all/Clear buttons set state directly. JS must set checkbox state via DOM attributes (data-state, aria-checked, [x-ref=indicator] hidden class) — never simulate `.click()` (too slow with many permissions).
