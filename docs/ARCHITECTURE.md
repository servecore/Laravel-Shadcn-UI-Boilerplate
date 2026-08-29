# Architecture & Design Patterns

## 1. Application Architecture

This project follows a **flat Blade component architecture** optimized for Laravel with Shadcn UI.

```
┌──────────────────────────────────────────────────────┐
│                     ROUTES                           │
│  web.php → Controllers (Auth, Dashboard, Setup)      │
│           → Middleware (auth, guest, csrf, setup)     │
├──────────────────────────────────────────────────────┤
│                   MIDDLEWARE                         │
│  RedirectIfNotSetup → Redirects to /setup if needed  │
│  PreventRequestForgery → CSRF protection             │
├──────────────────────────────────────────────────────┤
│                   CONTROLLERS                        │
│  Auth/ → Login, Register, Password, Verify, Profile  │
│  Setup/ → 4-step installation wizard                 │
│  Dashboard → Index                                   │
├──────────────────────────────────────────────────────┤
│              BLADE COMPONENTS                        │
│  PHP Classes → Blade Templates → Alpine.js Logic     │
│  (60 files)    (126 files)       (6 files)          │
├──────────────────────────────────────────────────────┤
│                 INFRASTRUCTURE                       │
│  ShadcnServiceProvider → Auto-registry               │
│  CompileAsChild → Attribute compiler                 │
│  HasID / SharesData → Traits                         │
└──────────────────────────────────────────────────────┘
```

## 2. Setup Wizard

### Flow

```
User opens app
     ↓
┌─ .setup-complete exists? ─┐
│                            │
YES                          NO
│                            │
↓                            ↓
Normal app flow         /setup wizard
                              │
                    ┌─────────┼─────────┐
                    │         │         │
                 Step 1    Step 2    Step 3
                 Welcome   Config    Database
                    │         │         │
                    └─────────┼─────────┘
                              │
                         Step 4
                         Admin
                              │
                              ↓
                        .setup-complete created
                        Auto-login → Dashboard
```

### Components

| Component | File | Purpose |
|-----------|------|---------|
| Controller | `SetupWizardController.php` | Handles all 4 wizard steps |
| Middleware | `RedirectIfNotSetup.php` | Checks `.setup-complete` marker |
| Form Requests | `Setup/*.php` | Validation for each step |
| Views | `resources/views/setup/` | 4 step views + layout |

### Marker File

`.setup-complete` (JSON) marks setup as done:
```json
{
    "completed_at": "2026-08-29T04:00:00+00:00",
    "version": "1.0.0"
}
```

To re-run wizard: `rm .setup-complete`

## 3. Component System

### Component Lifecycle

1. **PHP Class** (`app/View/Components/`) — Handles props, theming, data sharing
2. **Blade Template** (`resources/views/components/`) — Renders HTML with Tailwind classes
3. **Alpine.js Logic** (`resources/js/components/`) — Client-side interactivity (6 components)

### Component Registration

`ShadcnServiceProvider` auto-scans `app/View/Components/` and registers each component with a kebab-case alias:

```php
// In Blade templates:
<x-button variant="primary">Click me</x-button>
<x-card>
    <x-card-header>
        <x-card-title>Title</x-card-title>
    </x-card-header>
</x-card>
```

### Data Sharing Pattern

Parent components share data with children via the `SharesData` trait:

```php
// Accordion.php
use SharesData;

public function render(): View
{
    $this->share(
        views: ['components.accordion.accordion-item', ...],
        callback: fn (array $data, View $view) => [
            'type' => $this->type,
            'orientation' => $this->orientation,
        ]
    );

    return $this->view('components.accordion.accordion');
}
```

### CompileAsChild Pattern

The `CompileAsChild` component enables the "asChild" pattern — passing attributes from parent to child:

```blade
@if ($asChild)
    <x-compile-as-child :$slot :$attributes />
@else
    <button {{ $attributes }}>{{ $slot }}</button>
@endif
```

## 4. Theme System

- **Tech:** Alpine.js + Tailwind CSS v4 CSS variables
- **Files:** `resources/js/theme.js`, `resources/js/init-theme.js`
- **Modes:** Light / Dark / System
- **Persistence:** localStorage
- **FOUC Prevention:** Inline `<script>` in `<head>` via `<x-theme-script />`

## 5. Directory Structure

### Core Directories

| Path | Purpose |
|------|---------|
| `app/Console/Commands/Shadcn/` | Component management CLI |
| `app/Http/Controllers/Auth/` | Authentication controllers |
| `app/View/Components/` | 60 PHP component classes |
| `app/View/Concerns/` | Shared traits |
| `resources/views/components/` | 126 Blade component templates |
| `resources/js/components/` | 6 Alpine.js component scripts |
| `resources/shadcn-stubs/` | Offline component registry |

### Layout System

| File | Purpose |
|------|---------|
| `layouts/app.blade.php` | Main authenticated layout (sidebar + header) |
| `layouts/guest.blade.php` | Guest layout for auth pages |
| `layouts/partials/sidebar/` | Sidebar header, menu, footer |

## 6. Routing

### Setup Wizard Routes

```
/setup (GET)                → Environment check
/setup/step-2 (GET)         → App configuration form
/setup/step-2 (POST)        → Save app config
/setup/step-3 (GET)         → Database configuration form
/setup/step-3 (POST)        → Save database config + migrate
/setup/test-connection (POST) → Test database connection
/setup/step-4 (GET)         → Admin account form
/setup/complete (POST)      → Create admin + finish setup
```

### Application Routes

```
/ (GET)                    → Component preview page
/login (GET/POST)          → Authentication (guest)
/register (GET/POST)       → Registration (guest)
/forgot-password           → Password reset request (guest)
/reset-password            → Password reset form (guest)
/dashboard (GET)           → Dashboard (auth)
/users/*                   → User management (auth)
/logout (POST)             → Logout (auth)
```

### Middleware Stack

- `web` → Session, CSRF, etc.
- `setup` → Redirects to `/setup` if `.setup-complete` marker is missing
- `auth` → Requires authenticated user
- `guest` → Requires unauthenticated user
- `signed` → Requires valid signature (email verification)
- `throttle` → Rate limiting (email verification resend)

## 7. Database

### Default Tables

- `users` — User accounts
- `password_reset_tokens` — Password reset tokens
- `sessions` — Database sessions
- `cache` / `cache_locks` — Database cache
- `jobs` / `job_batches` / `failed_jobs` — Queue infrastructure

### Configuration

- **Default DB:** SQLite (switchable via `.env`)
- **Session Driver:** Database
- **Cache Store:** Database
- **Queue Driver:** Database

## 8. Security

- CSRF protection via `PreventRequestForgery` middleware
- Password hashing via bcrypt (User model cast)
- Session-based authentication
- `httpOnly` cookies
- `SameSite=lax` cookie policy
- XSS protection via proper output escaping
- Rate limiting on email verification resend
