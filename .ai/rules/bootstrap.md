---
paths:
  - bootstrap/app.php
---

# Bootstrap

## Register Spatie middleware aliases manually
spatie/laravel-permission does NOT auto-register its middleware aliases on Laravel 13. Add `role`, `permission`, `role_or_permission` aliases in bootstrap/app.php ->withMiddleware()->alias([...]) or route middleware `permission:...` fails with "Target class [permission] does not exist".
