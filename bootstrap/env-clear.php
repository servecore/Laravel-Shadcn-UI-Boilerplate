<?php

/**
 * Clear conflicting Windows system environment variables
 * so Laravel's .env file can take effect.
 *
 * Laravel uses Dotenv::safeLoad() which never overwrites
 * existing system env vars. If another project set these
 * at the Windows system level, they leak into this project.
 */
$conflictingKeys = [
    'APP_KEY',
    'APP_ENV',
    'APP_DEBUG',
    'APP_URL',
    'DB_CONNECTION',
    'DB_HOST',
    'DB_PORT',
    'DB_DATABASE',
    'DB_USERNAME',
    'DB_PASSWORD',
    'SESSION_DRIVER',
    'CACHE_STORE',
    'QUEUE_CONNECTION',
];

foreach ($conflictingKeys as $key) {
    $value = getenv($key);
    if ($value !== false) {
        putenv($key);
        unset($_ENV[$key], $_SERVER[$key]);
    }
}
