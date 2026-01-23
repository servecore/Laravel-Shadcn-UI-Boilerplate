# Getting Started 🚀

Welcome to the **Laravel Shadcn UI Boilerplate**. This guide will help you set up the project locally.

## Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM

## Installation

1. **Clone the Repository**
   ```bash
   git clone <repository-url>
   cd laravelshadcn-project
   ```

2. **Install Backend Dependencies**
   ```bash
   composer install
   ```

3. **Install Frontend Dependencies**
   ```bash
   npm install
   ```

4. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

## Running the Project implementation
We use a single command to run everything (Server, Queue, Vite):

```bash
composer run dev
```
*Or manually:*
```bash
php artisan serve
npm run dev
```

## Accessing Demos
Once running, visit the following URLs:

- **Dashboard:** `http://localhost:8000/demo/dashboard`
- **User Management:** `http://localhost:8000/demo/users`
- **Authentication:** `http://localhost:8000/demo/login`

## Next Steps
Check out [ARCHITECTURE.md](./ARCHITECTURE.md) to understand the project structure or [SYSTEM_RESILIENCE.md](./SYSTEM_RESILIENCE.md) to learn about the offline component registry.
