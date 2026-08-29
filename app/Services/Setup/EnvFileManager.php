<?php

namespace App\Services\Setup;

/**
 * Reads and writes key-value pairs in the .env file.
 */
class EnvFileManager
{
    /**
     * Update the .env file with the given key-value pairs.
     *
     * If a key already exists, its value is replaced.
     * Otherwise the key-value pair is appended.
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

            if (preg_match("/^{$key}=.*/m", $content)) {
                $content = preg_replace("/^{$key}=.*/m", "{$key}=\"{$escaped}\"", $content);
            } else {
                $content .= "\n{$key}=\"{$escaped}\"";
            }
        }

        file_put_contents($envPath, $content);
    }

    /**
     * Update the .env file with database connection settings.
     */
    public function updateDatabaseConfig(string $driver, array $connectionConfig): void
    {
        $envVars = ['DB_CONNECTION' => $driver];

        if ($driver !== 'sqlite') {
            $envVars['DB_HOST'] = $connectionConfig['host'] ?? '127.0.0.1';
            $envVars['DB_PORT'] = (string) ($connectionConfig['port'] ?? ($driver === 'mysql' ? '3306' : '5432'));
            $envVars['DB_DATABASE'] = $connectionConfig['database'] ?? '';
            $envVars['DB_USERNAME'] = $connectionConfig['username'] ?? '';
            $envVars['DB_PASSWORD'] = $connectionConfig['password'] ?? '';
        } else {
            $envVars['DB_DATABASE'] = $connectionConfig['database'] ?? database_path('database.sqlite');
            // Clear server DB vars so they don't leak from a previous config
            $envVars['DB_HOST'] = '';
            $envVars['DB_PORT'] = '';
            $envVars['DB_USERNAME'] = '';
            $envVars['DB_PASSWORD'] = '';
        }

        $this->update($envVars);
    }
}
