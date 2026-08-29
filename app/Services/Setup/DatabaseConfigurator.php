<?php

namespace App\Services\Setup;

use Illuminate\Http\Request;

/**
 * Builds database configuration arrays from request input or validated data.
 */
class DatabaseConfigurator
{
    /**
     * Build a database config array from raw request input (for connection testing).
     */
    public function buildFromRequest(Request $request, string $driver): array
    {
        if ($driver === 'sqlite') {
            return $this->buildSqliteConfig($request->input('sqlite_path'));
        }

        // Use raw input without defaults — caller must validate fields exist.
        return $this->buildServerConfig([
            'host' => $request->input('host'),
            'port' => $request->input('port'),
            'database' => $request->input('database'),
            'username' => $request->input('username'),
            'password' => $request->input('password', ''),
        ], $driver);
    }

    /**
     * Build a database config array from validated form data.
     */
    public function buildFromValidated(array $validated, string $driver): array
    {
        if ($driver === 'sqlite') {
            return $this->buildSqliteConfig();
        }

        return $this->buildServerConfig([
            'host' => $validated['host'] ?? '127.0.0.1',
            'port' => $validated['port'] ?? ($driver === 'mysql' ? '3306' : '5432'),
            'database' => $validated['database'] ?? '',
            'username' => $validated['username'] ?? '',
            'password' => $validated['password'] ?? '',
        ], $driver);
    }

    private function buildSqliteConfig(?string $path = null): array
    {
        $dbPath = $path ?? database_path('database.sqlite');

        if (! file_exists($dbPath)) {
            touch($dbPath);
        }

        return [
            'default' => 'sqlite',
            'connections' => [
                'sqlite' => [
                    'driver' => 'sqlite',
                    'database' => $dbPath,
                    'prefix' => '',
                    'foreign_key_constraints' => true,
                ],
            ],
        ];
    }

    private function buildServerConfig(array $params, string $driver): array
    {
        return [
            'default' => $driver,
            'connections' => [
                $driver => [
                    'driver' => $driver,
                    'host' => $params['host'],
                    'port' => $params['port'],
                    'database' => $params['database'],
                    'username' => $params['username'],
                    'password' => $params['password'],
                    'charset' => $driver === 'mysql' ? 'utf8mb4' : 'utf8',
                    'prefix' => '',
                ],
            ],
        ];
    }
}
