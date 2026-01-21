# Laravel Shadcn UI Boilerplate

A modern Laravel starter kit featuring **Shadcn UI** (Blade components), **Tailwind CSS v4**, and **Alpine.js**.

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4-38B2AC?style=for-the-badge&logo=tailwind-css)
![Alpine.js](https://img.shields.io/badge/Alpine.js-v3-8BC0D0?style=for-the-badge&logo=alpinedotjs)

## 🚀 Features

-   **Laravel 12.x**: The latest version of the PHP framework.
-   **Shadcn UI (Blade)**: Pre-built, accessible, and customizable UI components using `bjnstnkvc/shadcn-ui`.
-   **Tailwind CSS v4**: Using the next-generation Tailwind engine with `@tailwindcss/vite`.
-   **Alpine.js**: Lightweight JavaScript framework for interactivity (modals, dropdowns, etc.).
-   **Auto-Aliasing Fix**: Custom `AppServiceProvider` logic to automatically register Shadcn components (fixing missing `vendor` source issues).
-   **Pre-configured Demo**: Validated components available at `/test` route.

## 🛠️ Installation

1.  **Clone the repository**
    ```bash
    git clone https://github.com/yourusername/laravel-shadcn-project.git
    cd laravel-shadcn-project
    ```

2.  **Install PHP dependencies**
    ```bash
    composer install
    ```

3.  **Install Node.js dependencies**
    ```bash
    npm install
    ```

4.  **Environment Setup**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5.  **Run Development Server**
    Start Vite and Laravel server:
    ```bash
    # Terminal 1
    npm run dev

    # Terminal 2
    php artisan serve
    ```

    Visit `http://127.0.0.1:8000/test` to see the components in action.

## 🧩 Adding Components

You can add new Shadcn components using the artisan command:

```bash
php artisan shadcn:add [component-name]
# Example:
php artisan shadcn:add card
```

### ⚠️ Important Notes

#### 1. The `Switch` Component
Classes named `Switch` are reserved in PHP. If you install the switch component, you **MUST** manually rename the class and file to avoid a crash:
-   **File**: `app/View/Components/Switch/Switch.php` -> `SwitchComponent.php`
-   **Class**: `class Switch` -> `class SwitchComponent`

#### 2. Component Aliasing
We have patched `AppServiceProvider.php` to automatically discover and register components in `app/View/Components`. You can use kebab-case tags in your blade files safely:
```html
<x-select-value /> <!-- Works automatically -->
```

## 📂 Tech Stack

-   **Backend**: Laravel Framework 12.x
-   **Frontend**: Blade Templates + Alpine.js
-   **Styling**: Tailwind CSS v4.0+
-   **Bundler**: Vite 6.x

## 📄 License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
