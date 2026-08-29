# Laravel Shadcn UI Starter Kit

A modern **Laravel starter kit** featuring **Shadcn UI** (Blade components), **Tailwind CSS v4**, and **Alpine.js**. Designed as a reusable foundation for building Laravel applications.

![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4-38B2AC?style=for-the-badge&logo=tailwind-css)
![Alpine.js](https://img.shields.io/badge/Alpine.js-v3-8BC0D0?style=for-the-badge&logo=alpinedotjs)

## Features

- **Laravel 13.x** — Latest PHP framework
- **Shadcn UI (Blade)** — 31 accessible, customizable UI components
- **Theme System** — Dark/Light/System mode with FOUC prevention
- **Tailwind CSS v4** — Next-generation Tailwind engine
- **Alpine.js** — Lightweight client-side interactivity
- **Setup Wizard** — Browser-based installation for app config, database, and admin account
- **Authentication** — Login, register, logout, password reset, email verification
- **Component Management CLI** — Add, remove, repair components via Artisan
- **100% Standalone** — No external dependencies for UI components

## Quick Start

```bash
# Clone repository
git clone <your-repo-url>
cd <project-name>

# Install dependencies
composer install
bun install

# Environment setup
cp .env.example .env
php artisan key:generate

# Run development server
composer run dev
# OR manually:
# php artisan serve (Terminal 1)
# bun run dev (Terminal 2)
```

Open `http://localhost:8000` in your browser. The **setup wizard** will guide you through:

1. ✅ Environment check
2. ⚙️ App configuration (name, URL, timezone)
3. 🗄️ Database setup (SQLite/MySQL/PostgreSQL)
4. 👤 Admin account creation

After setup, you'll be logged in and redirected to the dashboard.

## Architecture

```
app/
├── Console/Commands/Shadcn/    # Component management CLI
├── Http/
│   ├── Controllers/
│   │   ├── Auth/               # Authentication controllers
│   │   ├── DashboardController.php
│   │   └── SetupWizardController.php
│   ├── Middleware/
│   │   └── RedirectIfNotSetup.php
│   └── Requests/
│       ├── Auth/               # Form request validation
│       └── Setup/              # Setup wizard validation
├── Models/User.php             # User model (UUID primary key)
├── Providers/                  # Service providers
├── View/
│   ├── Components/             # Blade component classes (60 files)
│   └── Concerns/               # Shared traits (HasID, SharesData)
resources/
├── views/
│   ├── auth/                   # Login, register, password views
│   ├── components/             # Blade templates (126 files)
│   ├── layouts/                # App & Guest layouts
│   ├── pages/                  # Dashboard, Users, Settings
│   └── setup/                  # Setup wizard views (4 steps)
├── js/components/              # Alpine.js logic (6 files)
├── css/app.css                 # Tailwind v4 config
└── shadcn-stubs/               # Offline component registry
routes/
└── web.php                     # Routes with auth + setup middleware
tests/
└── Feature/                    # Auth, dashboard, wizard tests
```

## Available Components

### Core Components
Button, Card, Avatar, Badge, Alert, Dialog, Select, Tabs, Progress, Input, Label, Checkbox, Radio, Textarea

### Extended Components
| Component | Description |
|-----------|-------------|
| **Table** | Full table system with header, body, footer, row, cell |
| **Skeleton** | Loading placeholder with pulse animation |
| **Switch** | Toggle switch with Alpine.js state |
| **Tooltip** | Hover tooltips with positioning |
| **Pagination** | Complete pagination system |
| **Dropdown** | Dropdown menu with items, shortcuts |
| **Scroll Area** | Custom scrollbar container |
| **Toggle** | Toggle button component |
| **Button Group** | Grouped buttons with separators |
| **Sidebar** | Full-featured collapsible sidebar |
| **Toast** | Event-driven notification system |

## CLI Commands

```bash
# Add components from local registry
php artisan shadcn:add Button Card

# Remove components
php artisan shadcn:remove Button

# Repair system files (ShadcnServiceProvider, etc.)
php artisan shadcn:repair
```

## Testing

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run specific test
php artisan test --filter=LoginTest
```

## Tech Stack

| Layer | Technology | Version |
|-------|-----------|---------|
| Backend | Laravel | 13.x |
| PHP | PHP | 8.2+ |
| CSS | Tailwind CSS | v4.0+ |
| JavaScript | Alpine.js | v3.x |
| Build | Vite | 7.x |
| Package Mgr | Bun | Latest |

## Documentation

- [Architecture](docs/ARCHITECTURE.md)
- [Getting Started](docs/GETTING_STARTED.md)
- [System Resilience](docs/SYSTEM_RESILIENCE.md)
- [Configuration](docs/CONFIGURATION.md)
- [Testing](docs/TESTING.md)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
