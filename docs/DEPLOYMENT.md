# Deployment

## Production Checklist

Before deploying to production, ensure:

1. **Environment Configuration**
   ```bash
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=<generated-key>
   APP_URL=https://your-domain.com
   ```

2. **Database**
   ```bash
   php artisan migrate --force
   ```

3. **Cache**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

4. **Build Frontend**
   ```bash
   bun run build
   ```

5. **Storage Link**
   ```bash
   php artisan storage:link
   ```

6. **Queue Worker**
   ```bash
   php artisan queue:work --sleep=3 --tries=3
   ```

7. **Scheduler**
   ```bash
   * * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
   ```

## Laravel Cloud

The fastest way to deploy is [Laravel Cloud](https://cloud.laravel.com/).

## Docker (Laravel Sail)

```bash
# Start containers
./vendor/bin/sail up -d

# Build assets
./vendor/bin/sail npm run build

# Run migrations
./vendor/bin/sail artisan migrate --force
```

## Environment Variables

All sensitive configuration should be set via environment variables, not committed to the repository.

### Required for Production

| Variable | Description |
|----------|-------------|
| `APP_KEY` | Encryption key |
| `APP_URL` | Production URL |
| `DB_*` | Database credentials |
| `MAIL_*` | Mail configuration |

### Optional

| Variable | Description |
|----------|-------------|
| `REDIS_*` | Redis configuration (for cache/queue) |
| `AWS_*` | S3 storage configuration |
| `MAIL_MAILER` | Mail driver (ses, postmark, smtp) |

## Security Notes

- Never commit `.env` to version control
- Use HTTPS in production
- Set `APP_DEBUG=false`
- Use strong `APP_KEY`
- Configure proper session cookies (`secure`, `http_only`, `same_site`)
- Set up rate limiting for auth routes
