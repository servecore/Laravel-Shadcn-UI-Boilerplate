# Architecture & Design Patterns 🏗️

This project follows a modular, scalable architecture optimized for Laravel & Shadcn UI.

## 1. Directory Structure
We moved away from the flat `views` folder to a domain-driven `pages` structure.

```text
resources/views/
├── components/         # Reusable Shadcn UI Blade Components
├── layouts/
│   ├── app.blade.php   # Master Layout
│   └── partials/       # Layout fragments (Sidebar, Header, etc.)
└── pages/              # Single-Page-Application style View organization
    ├── dashboard/      # Dashboard feature views
    ├── users/          # User Management feature views
    └── settings/       # Settings feature views
```

## 2. Modular Sidebar
The sidebar logic is decoupled from the main layout to improve maintainability.
- **Location:** `resources/views/layouts/partials/sidebar/`
- **Files:**
  - `sidebar-menu.blade.php`: Main entry point.
  - `sidebar-menu-projects.blade.php`: Example of **Multi-level (2-depth)** menu.
  - `sidebar-menu-reports.blade.php`: Example of **Multi-level (3-depth)** menu.

## 3. DRY Table Implementation 🧹
Tables in this project are optimized for minimal code repetition.

### The "Compact" Pattern
Instead of repeating classes on every cell, we use Tailwind arbitrary variants on the parent container.

**Example Usage:**
```blade
<x-table.table class="[&_td]:!p-1 [&_th]:!px-1 [&_th]:!h-8">
    <!-- All child cells/headers automatically get compact padding -->
    ...
</x-table.table>
```

## 4. Theme System 🌗
- **Tech:** Alpine.js + Tailwind CSS v4 variables.
- **File:** `resources/js/theme.js`
- **Features:**
  - Light / Dark / System mode.
  - Persists preference in `localStorage`.
  - Zero-flash on load (script injected in head).
