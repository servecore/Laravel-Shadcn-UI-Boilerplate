<?php

namespace App\Services\Setup;

/**
 * Checks whether the server environment meets the application's requirements.
 */
class EnvironmentChecker
{
    /**
     * Run all environment requirement checks.
     *
     * @return array<string, array{label: string, passed: bool, message: string}>
     */
    public function run(): array
    {
        $checks = [];

        $checks['php_version'] = $this->checkPhpVersion();
        $checks = array_merge($checks, $this->checkExtensions());
        $checks['db_extension'] = $this->checkDatabaseDriver();
        $checks['storage'] = $this->checkStorageWritable();
        $checks['cache'] = $this->checkCacheWritable();
        $checks['env_file'] = $this->checkEnvFile();
        $checks['app_key'] = $this->checkAppKey();

        return $checks;
    }

    /**
     * Determine if the critical environment checks pass.
     *
     * Used as a step guard to prevent advancing the wizard
     * when the environment is not ready.
     */
    public function criticalChecksPassed(): bool
    {
        $checks = $this->run();

        return $checks['php_version']['passed']
            && $checks['storage']['passed']
            && $checks['cache']['passed']
            && $checks['env_file']['passed'];
    }

    private function checkPhpVersion(): array
    {
        return [
            'label' => 'PHP Version (≥ 8.2)',
            'passed' => version_compare(PHP_VERSION, '8.2.0', '>='),
            'message' => 'PHP '.PHP_VERSION,
        ];
    }

    /**
     * @return array<string, array{label: string, passed: bool, message: string}>
     */
    private function checkExtensions(): array
    {
        $required = ['mbstring', 'openssl', 'pdo', 'tokenizer', 'xml', 'curl', 'json', 'bcmath', 'fileinfo'];
        $checks = [];

        foreach ($required as $ext) {
            $loaded = extension_loaded($ext);
            $checks["ext_{$ext}"] = [
                'label' => "Extension: {$ext}",
                'passed' => $loaded,
                'message' => $loaded ? 'Installed' : 'Missing',
            ];
        }

        return $checks;
    }

    private function checkDatabaseDriver(): array
    {
        $driver = config('database.default');
        $map = [
            'sqlite' => 'pdo_sqlite',
            'mysql' => 'pdo_mysql',
            'pgsql' => 'pdo_pgsql',
        ];
        $required = $map[$driver] ?? 'pdo_sqlite';
        $loaded = extension_loaded($required);

        return [
            'label' => "Database Driver: {$required}",
            'passed' => $loaded,
            'message' => $loaded ? 'Installed' : 'Missing',
        ];
    }

    private function checkStorageWritable(): array
    {
        $writable = is_writable(storage_path()) && is_writable(storage_path('logs'));

        return [
            'label' => 'Storage directory writable',
            'passed' => $writable,
            'message' => $writable ? 'Writable' : 'Not writable',
        ];
    }

    private function checkCacheWritable(): array
    {
        $writable = is_writable(base_path('bootstrap/cache'));

        return [
            'label' => 'Bootstrap cache writable',
            'passed' => $writable,
            'message' => $writable ? 'Writable' : 'Not writable',
        ];
    }

    private function checkEnvFile(): array
    {
        $exists = file_exists(base_path('.env'));

        return [
            'label' => '.env file exists',
            'passed' => $exists,
            'message' => $exists ? 'Exists' : 'Missing — run cp .env.example .env',
        ];
    }

    private function checkAppKey(): array
    {
        $set = (bool) config('app.key');

        return [
            'label' => 'Application key set',
            'passed' => $set,
            'message' => $set ? 'Set' : 'Not set — run php artisan key:generate',
        ];
    }
}
