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

### 5. Start Development

```bash
# All-in-one (server, queue, logs, vite)
composer run dev

# Or manually:
php artisan serve      # Terminal 1
bun run dev            # Terminal 2
```

### 6. Run the Setup Wizard

Open your browser and navigate to `http://localhost:8000`. You will be automatically redirected to the setup wizard.

The wizard guides you through **4 steps**:

#### Step 1: Environment Check
Verifies your server meets all requirements:
- PHP version and extensions
- Writable directories (`storage/`, `bootstrap/cache/`)
- `.env` file exists
- Application key is set

#### Step 2: Application Configuration
Configure your application settings:
- **App Name** — Displayed in browser tab and throughout the app
- **App URL** — Where your application will be accessible
- **Timezone** — Default timezone for the application
- **Locale** — Default language
- **Debug Mode** — Enable/disable for development

#### Step 3: Database Setup
Choose and configure your database:

| Driver | Best For | Notes |
|--------|----------|-------|
| **SQLite** | Development | No configuration needed, file-based |
| **MySQL** | Production | Requires host, port, database, credentials |
| **PostgreSQL** | Production | Requires host, port, database, credentials |

- Click **Test Connection** to verify your database settings
- Migrations run automatically on save

#### Step 4: Create Admin Account
Create the first administrator account:
- Full name
- Username
- Email address
- Password (min 8 characters)

On completion, you'll be automatically logged in and redirected to the dashboard.

## Accessing the Application

| URL | Description |
|-----|-------------|
| `http://localhost:8000` | Setup wizard (first visit) or redirects to dashboard |
| `http://localhost:8000/login` | Login page |
| `http://localhost:8000/register` | Registration page |
| `http://localhost:8000/dashboard` | Dashboard (requires login) |
| `http://localhost:8000/users` | User management |
| `http://localhost:8000/settings` | Settings page |

## Re-running Setup Wizard

To re-run the setup wizard (e.g., for development), delete the `.setup-complete` marker file:

```bash
rm .setup-complete
```

Then visit the application URL. You'll be redirected to the setup wizard again.

## Switching Database

To switch database drivers after setup, update `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=
```

Then run:

```bash
php artisan migrate
```
