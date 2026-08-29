# Getting Started

## Prerequisites

- PHP 8.2+
- Composer
- Bun (or Node.js & NPM)
- SQLite (default) or MySQL/PostgreSQL

## Installation

### 1. Clone the Repository

```bash
git clone <your-repo-url>
cd <project-name>
```

### 2. Install Backend Dependencies

```bash
composer install
```

### 3. Install Frontend Dependencies

```bash
bun install
```

### 4. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Database Setup

```bash
# SQLite (default)
touch database/database.sqlite

# Run migrations
php artisan migrate

# Seed a test user
php artisan db:seed
```

### 6. Start Development

```bash
# All-in-one (server, queue, logs, vite)
composer run dev

# Or manually:
php artisan serve      # Terminal 1
bun run dev            # Terminal 2
```

## Accessing the Application

| URL | Description |
|-----|-------------|
| `http://localhost:8000/demo/login` | Login page |
| `http://localhost:8000/demo/register` | Registration page |
| `http://localhost:8000/demo` | Dashboard (requires login) |
| `http://localhost:8000/demo/users` | User management |
| `http://localhost:8000/demo/settings` | Settings page |

### Default Test User

- **Email:** `test@example.com`
- **Password:** `password`

## Switching Database

To use MySQL instead of SQLite, update `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=
```

Then run `php artisan migrate`.
