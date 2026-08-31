<?php

namespace App\Services\Setup;

use Illuminate\Support\Str;

/**
 * Reads and writes key-value pairs in the .env file.
 */
class EnvFileManager
{
    /**
     * Update the .env file with the given key-value pairs.
     *
     * Matches both active and commented-out lines (e.g. "# DB_HOST=...").
     * Commented lines are uncommented and overwritten to prevent duplicates.
     */
    public function update(array $values): void
    {
        $envPath = base_path('.env');

        if (! file_exists($envPath)) {
            return;
        }

        $content = file_get_contents($envPath);

        foreach ($values as $key => $value) {
            $escaped = str_replace('"', '\\"', $value);
            $replacement = "{$key}=\"{$escaped}\"";

            // Match active "KEY=..." OR commented-out "# KEY=..." or "#KEY=..."
            $pattern = '/^[#\\s]*'.preg_quote($key, '/').'=.*/m';

            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, $replacement, $content);
            } else {
                $content .= "\n{$replacement}";
            }
        }

        file_put_contents($envPath, $content);
    }

    /**
     * Generate and set APP_KEY if not already set.
     *
     * Adopted from InstallerErag's EnvironmentManager.
     */
    public function generateAppKey(): void
    {
        if (config('setup.auto_generate_app_key', true)) {
            $envPath = base_path('.env');

            if (file_exists($envPath)) {
                $content = file_get_contents($envPath);

                // Only generate if APP_KEY is empty or not set
                if (preg_match('/^APP_KEY=.+$/m', $content) === 0 || preg_match('/^APP_KEY=$/m', $content) === 1) {
                    $key = 'base64:'.base64_encode(Str::random(32));
                    $this->update(['APP_KEY' => $key]);
                }
            }
        }
    }

    /**
     * Strip all DB_* lines (including commented-out) from the .env file.
     *
     * This prevents duplicate entries when switching drivers
     * (e.g. pgsql DB_HOST at top, then mysql DB_HOST appended at bottom).
     */
    private function stripDatabaseEntries(string $content): string
    {
        return preg_replace('/^[#\\s]*DB_(?:CONNECTION|HOST|PORT|DATABASE|USERNAME|PASSWORD)=.*/m', '', $content);
    }

    /**
     * Update the .env file with database connection settings.
     *
     * Removes ALL existing DB_* entries first, then writes the new ones as a clean block.
     */
    public function updateDatabaseConfig(string $driver, array $connectionConfig): void
    {
        $envPath = base_path('.env');

        if (! file_exists($envPath)) {
            return;
        }

        $content = file_get_contents($envPath);

        // Strip every existing DB_* line (commented or active) to avoid duplicates
        $content = $this->stripDatabaseEntries($content);

        // Build the new DB block
        $lines = [
            "DB_CONNECTION=\"{$driver}\"",
        ];

        if ($driver === 'sqlite') {
            // Use forward slashes for .env to avoid backslash escape issues on Windows
            $dbPath = $connectionConfig['database'] ?? database_path('database.sqlite');
            $dbPath = str_replace('\\', '/', $dbPath);
            $lines[] = 'DB_DATABASE="'.$dbPath.'"';
            $lines[] = '# DB_HOST=';
            $lines[] = '# DB_PORT=';
            $lines[] = '# DB_USERNAME=';
            $lines[] = '# DB_PASSWORD=';
        } else {
            $lines[] = 'DB_HOST="'.($connectionConfig['host'] ?? '127.0.0.1').'"';
            $lines[] = 'DB_PORT="'.($connectionConfig['port'] ?? ($driver === 'mysql' ? '3306' : '5432')).'"';
            $lines[] = 'DB_DATABASE="'.($connectionConfig['database'] ?? '').'"';
            $lines[] = 'DB_USERNAME="'.($connectionConfig['username'] ?? '').'"';
            $lines[] = 'DB_PASSWORD="'.($connectionConfig['password'] ?? '').'"';
        }

        $dbBlock = implode("\n", $lines);

        // Find the DB section: insert after LOG_LEVEL or APP_MAINTENANCE line, before SESSION_*
        if (preg_match('/^(LOG_LEVEL=.*)/m', $content, $match)) {
            $insertAfter = $match[1];
            $content = str_replace($insertAfter, $insertAfter."\n\n".$dbBlock, $content);
        } else {
            // Fallback: append before SESSION_DRIVER if it exists
            if (preg_match('/^(SESSION_DRIVER=.*)/m', $content, $match)) {
                $content = str_replace($match[1], $dbBlock."\n\n".$match[1], $content);
            } else {
                $content .= "\n\n".$dbBlock;
            }
        }

        // Clean up excessive blank lines (3+ consecutive → 2)
        $content = preg_replace('/\n{3,}/', "\n\n", $content);

        file_put_contents($envPath, $content);
    }
}
