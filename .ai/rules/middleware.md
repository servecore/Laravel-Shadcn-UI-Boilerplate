---
paths:
  - app/Http/Middleware/RedirectIfNotSetup.php
  - 'app/Http/Middleware/**'
---

# Middleware

## Setup wizard 403: gate /setup/* with the `setup` middleware
`SetupState::isSetup()` reads the `.setup-complete` marker file in the project root, and the setup FormRequests (`authorize()`) return `!isSetup()` → a POST to `/setup/*` yields an unlogged 403 once setup is complete. The `/setup` route group MUST include the `setup` middleware (alongside `guest`) so the wizard redirects to `/dashboard` instead of rendering/accepting after completion. Tests that stub `SetupState` must never create/delete the real `.setup-complete` file (it lives in `base_path`) — bind a subclass stub via `app()->instance()` instead.

## EnsureUserIsActive middleware guards all authenticated routes
EnsureUserIsActive (alias 'active') dipasang pada semua route ter-autentikasi (grup ['auth','active'] di routes/web.php). User dengan is_active=false di-logout; web → redirect ke login dengan session error; AJAX (expectsJson) → 403 JSON. Jangan lupa alias 'active' terdaftar di bootstrap/app.php.
