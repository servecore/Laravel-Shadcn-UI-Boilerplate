---
paths:
  - routes/web.php
---

# Routes

## Setup routes stay registered, locked by middleware; not yet a package
Keep setup wizard routes (`/setup/*`) registered but locked behind the `setup` + `guest` middleware — they redirect to /dashboard once `.setup-complete` exists rather than being deleted. Decision: do NOT extract the wizard as a package yet (only one consuming project / it's a starter kit); treat it as starter-kit code until 2+ projects share the pattern.

## Settings routes & nav gated by manage-settings permission
Settings routes (settings + settings.update) di-gate permission:manage-settings. Admin diberikan permission ini lewat RolePermissionSeeder. Semua entri UI Settings (dropdown sidebar-footer & tombol dashboard Quick Actions) dibungkus @can('manage-settings'). User tanpa permission → error 403 (halaman error tema sudah ada).
