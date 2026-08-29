# Configuration

## Environment Variables

### Application

| Variable | Default | Description |
|----------|---------|-------------|
| `APP_NAME` | `Laravel` | Application name |
| `APP_ENV` | `local` | Environment (local, production, testing) |
| `APP_KEY` | — | Encryption key (generate with `php artisan key:generate`) |
| `APP_DEBUG` | `true` | Debug mode |
| `APP_URL` | `http://localhost` | Application URL |

### Database

| Variable | Default | Description |
|----------|---------|-------------|
| `DB_CONNECTION` | `sqlite` | Database driver (sqlite, mysql, pgsql) |
| `DB_HOST` | `127.0.0.1` | Database host |
| `DB_PORT` | `3306` | Database port |
| `DB_DATABASE` | — | Database name |
| `DB_USERNAME` | — | Database username |
| `DB_PASSWORD` | — | Database password |

### Session

| Variable | Default | Description |
|----------|---------|-------------|
| `SESSION_DRIVER` | `database` | Session driver (database, file, redis, array) |
| `SESSION_LIFETIME` | `120` | Session lifetime in minutes |
| `SESSION_ENCRYPT` | `false` | Encrypt session data |
| `SESSION_DOMAIN` | `null` | Session cookie domain |

### Cache & Queue

| Variable | Default | Description |
|----------|---------|-------------|
| `CACHE_STORE` | `database` | Cache driver (database, file, redis, array) |
| `QUEUE_CONNECTION` | `database` | Queue driver (database, sync, redis) |

### Mail

| Variable | Default | Description |
|----------|---------|-------------|
| `MAIL_MAILER` | `log` | Mail driver (smtp, log, array, ses, postmark) |
| `MAIL_HOST` | `127.0.0.1` | SMTP host |
| `MAIL_PORT` | `2525` | SMTP port |
| `MAIL_USERNAME` | `null` | SMTP username |
| `MAIL_PASSWORD` | `null` | SMTP password |
| `MAIL_FROM_ADDRESS` | `hello@example.com` | From address |
| `MAIL_FROM_NAME` | `${APP_NAME}` | From name |

### Frontend

| Variable | Default | Description |
|----------|---------|-------------|
| `VITE_APP_NAME` | `${APP_NAME}` | App name for frontend |
| `VITE_PORT` | `5333` | Vite dev server port |

## Configuration Files

All Laravel configuration files are in `config/` and follow standard Laravel conventions. See the [Laravel documentation](https://laravel.com/docs/configuration) for details.
