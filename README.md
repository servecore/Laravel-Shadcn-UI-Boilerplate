# Laravel Shadcn UI Boilerplate

A modern Laravel starter kit featuring **Shadcn UI** (Blade components), **Tailwind CSS v4**, and **Alpine.js**.

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4-38B2AC?style=for-the-badge&logo=tailwind-css)
![Alpine.js](https://img.shields.io/badge/Alpine.js-v3-8BC0D0?style=for-the-badge&logo=alpinedotjs)

## 🚀 Features

-   **Laravel 12.x**: The latest version of the PHP framework.
-   **Shadcn UI (Blade)**: Pre-built, accessible, and customizable UI components.
-   **Theme System 🌙**: Integrated Dark/Light/System mode with FOUC prevention.
-   **Tailwind CSS v4**: Using the next-generation Tailwind engine.
-   **Alpine.js**: Lightweight JavaScript framework for interactivity.
-   **100% Standalone**: No external dependencies for UI components.

## 🧩 Available Components

### Core Components
Button, Card, Avatar, Badge, Alert, Dialog, Select, Tabs, Progress, Input, Label, Checkbox, Radio, Form

### Extended Components 
| Component | Description |
|-----------|-------------|
| **Table** | Full table system with header, body, footer, row, cell |
| **Skeleton** | Loading placeholder with pulse animation |
| **Switch** | Toggle switch with Alpine.js state |
| **Textarea** | Multi-line text input |
| **Tooltip** | Hover tooltips with positioning |
| **Pagination** | Complete pagination system |
| **Dropdown** | Dropdown menu with items, checkboxes, radio groups |
| **Scroll Area** | Custom scrollbar container |
| **Toggle** | Toggle button component |
| **Button Group** | Grouped buttons with separators |
| **Sidebar** | Full-featured collapsible sidebar (see below) |

### 🎯 Sidebar Component
A complete sidebar navigation system with:
- ✅ Collapsible (toggle button + keyboard shortcut ⌘+B)
- ✅ Cookie persistence for state
- ✅ Multi-level navigation (3+ levels)
- ✅ Tooltip on hover when collapsed
- ✅ Group labels (Platform, Settings, etc.)
- ✅ Mobile responsive (offcanvas)
- ✅ Active state highlighting

## 🛠️ Installation

```bash
# Clone repository
git clone https://github.com/servecore/laravel-shadcn-project.git
cd laravel-shadcn-project

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Run development server
npm run dev          # Terminal 1
php artisan serve    # Terminal 2
```

## 🔧 CLI Commands

Manage your components with built-in Artisan commands:

```bash
# List available components
php artisan shadcn:add

# Add specific component(s)
php artisan shadcn:add Button Card

# Remove component(s)
php artisan shadcn:remove Button
```

## 📁 Project Structure

```
app/
├── Console/Commands/Shadcn/    # CLI commands
├── View/
│   ├── Components/             # Blade component classes
│   │   ├── Accordion/
│   │   ├── Button/
│   │   ├── Card/
│   │   └── ...
│   └── Concerns/               # Shared traits
│       ├── HasID.php
│       └── SharesData.php
resources/
├── views/components/           # Blade templates
├── js/components/              # Alpine.js logic
└── css/app.css                 # Tailwind config
```

## 📖 Demo Pages

| URL | Description |
|-----|-------------|
| `/` | All basic components preview |
| `/sidebar-demo` | Sidebar with all features |

## 🎨 Usage Examples

### Theme Toggle
```html
<head>
    <x-theme-script />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <x-theme-toggle />
</body>
```

### Sidebar Layout
```html
<x-sidebar.provider :defaultOpen="true" collapsible="icon">
    <x-sidebar.sidebar collapsible="icon">
        <x-sidebar.header>Logo</x-sidebar.header>
        <x-sidebar.content>
            <x-sidebar.group>
                <x-sidebar.group-label>Menu</x-sidebar.group-label>
                <x-sidebar.menu>
                    <x-sidebar.menu-item>
                        <x-sidebar.menu-button :active="true" tooltip="Dashboard">
                            <x-slot:icon><!-- SVG --></x-slot:icon>
                            Dashboard
                        </x-sidebar.menu-button>
                    </x-sidebar.menu-item>
                </x-sidebar.menu>
            </x-sidebar.group>
        </x-sidebar.content>
    </x-sidebar.sidebar>
    <x-sidebar.inset>
        <x-sidebar.trigger />
        <!-- Main content -->
    </x-sidebar.inset>
</x-sidebar.provider>
```

### Table
```html
<x-table.table>
    <x-table.header>
        <x-table.row>
            <x-table.head>Name</x-table.head>
            <x-table.head>Email</x-table.head>
        </x-table.row>
    </x-table.header>
    <x-table.body>
        <x-table.row>
            <x-table.cell>John Doe</x-table.cell>
            <x-table.cell>john@example.com</x-table.cell>
        </x-table.row>
    </x-table.body>
</x-table.table>
```

## 📂 Tech Stack

-   **Backend**: Laravel Framework 12.x
-   **Frontend**: Blade Templates + Alpine.js
-   **Styling**: Tailwind CSS v4.0+
-   **Bundler**: Vite 7.x

## 📄 License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
