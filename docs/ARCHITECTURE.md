# Architecture & Design Patterns

## 1. Application Architecture

This project follows a **flat Blade component architecture** optimized for Laravel with Shadcn UI.

```
┌──────────────────────────────────────────────────────┐
│                     ROUTES                           │
│  web.php → Controllers (Auth, Dashboard)             │
│           → Middleware (auth, guest, csrf)            │
├──────────────────────────────────────────────────────┤
│                   CONTROLLERS                        │
│  Auth/ → Login, Register, Password, Verify, Profile  │
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

## 2. Component System

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

## 3. Theme System

- **Tech:** Alpine.js + Tailwind CSS v4 CSS variables
- **Files:** `resources/js/theme.js`, `resources/js/init-theme.js`
- **Modes:** Light / Dark / System
- **Persistence:** localStorage
- **FOUC Prevention:** Inline `<script>` in `<head>` via `<x-theme-script />`

## 4. Directory Structure

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

## 5. Routing

### Route Groups

```
/ (GET)                    → Component preview page
/demo/login (GET/POST)     → Authentication (guest)
/demo/register (GET/POST)  → Registration (guest)
/demo/forgot-password      → Password reset request (guest)
/demo/reset-password       → Password reset form (guest)
/demo (GET)                → Dashboard (auth)
/demo/users/*              → User management (auth)
/demo/logout (POST)        → Logout (auth)
```

### Middleware Stack

- `web` → Session, CSRF, etc.
- `auth` → Requires authenticated user
- `guest` → Requires unauthenticated user
- `signed` → Requires valid signature (email verification)
- `throttle` → Rate limiting (email verification resend)

## 6. Database

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

## 7. Security

- CSRF protection via `PreventRequestForgery` middleware
- Password hashing via bcrypt (User model cast)
- Session-based authentication
- `httpOnly` cookies
- `SameSite=lax` cookie policy
- XSS protection via proper output escaping
- Rate limiting on email verification resend
