# Laravel Shadcn UI Boilerplate

A modern Laravel starter kit featuring **Shadcn UI** (Blade components), **Tailwind CSS v4**, and **Alpine.js**.

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4-38B2AC?style=for-the-badge&logo=tailwind-css)
![Alpine.js](https://img.shields.io/badge/Alpine.js-v3-8BC0D0?style=for-the-badge&logo=alpinedotjs)

## 🚀 Features

-   **Laravel 12.x**: The latest version of the PHP framework.
-   **Shadcn UI (Blade)**: Pre-built, accessible, and customizable UI components.
    -   *Includes custom Blade implementations for:* **Dialog**, **Select**, **Tabs**, and **Progress**.
-   **Theme System 🌙**: Integrated Dark/Light/System mode with FOUC prevention.
-   **Button Loading**: Built-in loading state support (`<x-button loading="true" />`).
-   **Tailwind CSS v4**: Using the next-generation Tailwind engine with `@tailwindcss/vite`.
-   **Alpine.js**: Lightweight JavaScript framework for interactivity.
-   **Auto-Aliasing Fix**: Custom `AppServiceProvider` logic to automatically register Shadcn components.
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

## 📖 Usage Guide

### Theme System (Dark Mode)
This boilerplate comes with a flicker-free Theme System out of the box.

1.  **Setup**: Add the initialization script in your main layout `<head>`:
    ```html
    <head>
        ...
        <x-theme-script /> <!-- Inject blocking script to prevent FOUC -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    ```

2.  **Toggle Button**: Place the toggle component anywhere (e.g., Navbar):
    ```html
    <x-theme-toggle />
    ```

### Button Loading State
The button component supports a `loading` prop that automatically disables the button and shows a spinner:
```html
<x-button loading="true">
    Please Wait...
</x-button>
```

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

#### 2. Dependencies
Some components require extra packages which are already pre-configured in `package.json`:
-   **Carousel**: Requires `embla-carousel-autoplay` and `embla-carousel`.

## 📂 Tech Stack

-   **Backend**: Laravel Framework 12.x
-   **Frontend**: Blade Templates + Alpine.js
-   **Styling**: Tailwind CSS v4.0+
-   **Bundler**: Vite 6.x

## 📄 License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
