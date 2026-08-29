<?php

namespace App\Http\Controllers;

use App\Http\Requests\Setup\SetupAdminRequest;
use App\Http\Requests\Setup\SetupAppConfigRequest;
use App\Http\Requests\Setup\SetupDatabaseRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class SetupWizardController extends Controller
{
    /**
     * Marker file to detect if setup is complete.
     */
    private const SETUP_MARKER = '.setup-complete';

    /**
     * Check if the application has been set up.
     */
    public static function isSetup(): bool
    {
        return file_exists(base_path(self::SETUP_MARKER));
    }

    /**
     * Mark setup as complete.
     */
    private function markSetupComplete(): void
    {
        file_put_contents(base_path(self::SETUP_MARKER), json_encode([
            'completed_at' => now()->toIso8601String(),
            'version' => '1.0.0',
        ]));
    }

    /**
     * Step 1: Welcome & Environment Check.
     */
    public function step1(): View
    {
        $checks = $this->runEnvironmentChecks();

        return view('setup.step1', [
            'checks' => $checks,
            'allPassed' => collect($checks)->every(fn (array $check) => $check['passed']),
        ]);
    }

    /**
     * Step 2: Application Configuration.
     */
    public function step2(): View|RedirectResponse
    {
        if (! $this->checksPassed()) {
            return redirect()->route('setup.step1');
        }

        return view('setup.step2', [
            'appName' => config('app.name', 'Laravel'),
            'appUrl' => config('app.url', 'http://localhost'),
            'timezone' => config('app.timezone', 'UTC'),
            'locale' => config('app.locale', 'en'),
        ]);
    }

    /**
     * Save Application Configuration.
     */
    public function saveAppConfig(SetupAppConfigRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $this->updateEnvFile([
            'APP_NAME' => $validated['app_name'],
            'APP_URL' => $validated['app_url'],
            'APP_TIMEZONE' => $validated['timezone'],
            'APP_LOCALE' => $validated['locale'],
            'APP_DEBUG' => $validated['debug_mode'] ? 'true' : 'false',
        ]);

        return redirect()->route('setup.step3');
    }

    /**
     * Step 3: Database Configuration.
     */
    public function step3(): View|RedirectResponse
    {
        return view('setup.step3', [
            'currentDriver' => config('database.default'),
            'databases' => [
                'sqlite' => [
                    'name' => 'SQLite',
                    'description' => 'File-based database, perfect for development',
                    'icon' => 'database',
                ],
                'mysql' => [
                    'name' => 'MySQL',
                    'description' => 'Popular open-source relational database',
                    'icon' => 'server',
                ],
                'pgsql' => [
                    'name' => 'PostgreSQL',
                    'description' => 'Advanced open-source relational database',
                    'icon' => 'server',
                ],
            ],
        ]);
    }

    /**
     * Test database connection.
     */
    public function testConnection(Request $request): JsonResponse
    {
        $driver = $request->input('driver', 'sqlite');

        try {
            $config = $this->buildDatabaseConfig($request, $driver);
            $this->updateDatabaseConfig($driver, $config);

            Artisan::call('config:clear');

            $connection = Schema::getConnection();
            $connection->getPdo();

            return response()->json([
                'success' => true,
                'message' => 'Database connection successful!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Connection failed: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Save Database Configuration.
     */
    public function saveDatabaseConfig(SetupDatabaseRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $driver = $validated['driver'];

        $config = $this->buildDatabaseConfigFromValidated($validated, $driver);
        $this->updateDatabaseConfig($driver, $config);

        try {
            Artisan::call('migrate', [
                '--force' => true,
                '--no-interaction' => true,
            ]);

            $this->setSessionFlag('setup_migrated', true);
        } catch (\Exception $e) {
            return back()->withErrors([
                'database' => 'Migration failed: '.$e->getMessage(),
            ]);
        }

        return redirect()->route('setup.step4');
    }

    /**
     * Step 4: Create Admin Account.
     */
    public function step4(): View|RedirectResponse
    {
        if (! $this->setSessionFlag('setup_migrated', true)) {
            return redirect()->route('setup.step3');
        }

        return view('setup.step4');
    }

    /**
     * Create Admin Account & Complete Setup.
     */
    public function complete(SetupAdminRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            $user = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'email_verified_at' => now(),
                'password' => Hash::make($validated['password']),
                'is_active' => true,
                'created_by' => 'Setup Wizard',
            ]);

            if (class_exists(Mail::class) && config('mail.default')) {
                Auth::login($user);
            } else {
                Auth::login($user);
            }

            $this->markSetupComplete();

            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');

            return redirect()->route('dashboard')
                ->with('success', 'Application setup completed successfully!');
        } catch (\Exception $e) {
            return back()->withErrors([
                'admin' => 'Failed to create admin account: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Run environment requirement checks.
     *
     * @return array<string, array{label: string, passed: bool, message: string}>
     */
    private function runEnvironmentChecks(): array
    {
        $checks = [];

        // PHP Version
        $checks['php_version'] = [
            'label' => 'PHP Version (≥ 8.2)',
            'passed' => version_compare(PHP_VERSION, '8.2.0', '>='),
            'message' => 'PHP '.PHP_VERSION,
        ];

        // Required PHP Extensions
        $requiredExtensions = ['mbstring', 'openssl', 'pdo', 'tokenizer', 'xml', 'curl', 'json', 'bcmath', 'fileinfo'];
        foreach ($requiredExtensions as $ext) {
            $checks["ext_{$ext}"] = [
                'label' => "Extension: {$ext}",
                'passed' => extension_loaded($ext),
                'message' => extension_loaded($ext) ? 'Installed' : 'Missing',
            ];
        }

        // Database extension based on configured driver
        $driver = config('database.default');
        $dbExtensions = [
            'sqlite' => 'pdo_sqlite',
            'mysql' => 'pdo_mysql',
            'pgsql' => 'pdo_pgsql',
        ];
        $requiredDbExt = $dbExtensions[$driver] ?? 'pdo_sqlite';
        $checks['db_extension'] = [
            'label' => "Database Driver: {$requiredDbExt}",
            'passed' => extension_loaded($requiredDbExt),
            'message' => extension_loaded($requiredDbExt) ? 'Installed' : 'Missing',
        ];

        // Storage writable
        $checks['storage'] = [
            'label' => 'Storage directory writable',
            'passed' => is_writable(storage_path()) && is_writable(storage_path('logs')),
            'message' => is_writable(storage_path()) ? 'Writable' : 'Not writable',
        ];

        // Bootstrap cache writable
        $checks['cache'] = [
            'label' => 'Bootstrap cache writable',
            'passed' => is_writable(base_path('bootstrap/cache')),
            'message' => is_writable(base_path('bootstrap/cache')) ? 'Writable' : 'Not writable',
        ];

        // .env file exists
        $checks['env_file'] = [
            'label' => '.env file exists',
            'passed' => file_exists(base_path('.env')),
            'message' => file_exists(base_path('.env')) ? 'Exists' : 'Missing — run cp .env.example .env',
        ];

        // APP_KEY
        $checks['app_key'] = [
            'label' => 'Application key set',
            'passed' => (bool) config('app.key'),
            'message' => config('app.key') ? 'Set' : 'Not set — run php artisan key:generate',
        ];

        return $checks;
    }

    /**
     * Check if environment checks passed (for step guards).
     */
    private function checksPassed(): bool
    {
        return $this->runEnvironmentChecks()['php_version']['passed']
            && $this->runEnvironmentChecks()['storage']['passed']
            && $this->runEnvironmentChecks()['cache']['passed']
            && $this->runEnvironmentChecks()['env_file']['passed'];
    }

    /**
     * Build database config array from request.
     */
    private function buildDatabaseConfig(Request $request, string $driver): array
    {
        $config = ['default' => $driver, 'connections' => [$driver => []]];

        if ($driver === 'sqlite') {
            $dbPath = $request->input('sqlite_path', database_path('database.sqlite'));

            if (! file_exists($dbPath)) {
                touch($dbPath);
            }

            $config['connections'][$driver] = [
                'driver' => 'sqlite',
                'database' => $dbPath,
                'prefix' => '',
                'foreign_key_constraints' => true,
            ];
        } else {
            $config['connections'][$driver] = [
                'driver' => $driver,
                'host' => $request->input('host', '127.0.0.1'),
                'port' => $request->input('port', $driver === 'mysql' ? '3306' : '5432'),
                'database' => $request->input('database', ''),
                'username' => $request->input('username', ''),
                'password' => $request->input('password', ''),
                'charset' => $driver === 'mysql' ? 'utf8mb4' : 'utf8',
                'prefix' => '',
            ];
        }

        return $config;
    }

    /**
     * Build database config from validated request.
     */
    private function buildDatabaseConfigFromValidated(array $validated, string $driver): array
    {
        $config = ['default' => $driver, 'connections' => [$driver => []]];

        if ($driver === 'sqlite') {
            $dbPath = database_path('database.sqlite');

            if (! file_exists($dbPath)) {
                touch($dbPath);
            }

            $config['connections'][$driver] = [
                'driver' => 'sqlite',
                'database' => $dbPath,
                'prefix' => '',
                'foreign_key_constraints' => true,
            ];
        } else {
            $config['connections'][$driver] = [
                'driver' => $driver,
                'host' => $validated['host'] ?? '127.0.0.1',
                'port' => $validated['port'] ?? ($driver === 'mysql' ? '3306' : '5432'),
                'database' => $validated['database'] ?? '',
                'username' => $validated['username'] ?? '',
                'password' => $validated['password'] ?? '',
                'charset' => $driver === 'mysql' ? 'utf8mb4' : 'utf8',
                'prefix' => '',
            ];
        }

        return $config;
    }

    /**
     * Update .env and config with database settings.
     */
    private function updateDatabaseConfig(string $driver, array $config): void
    {
        $envVars = [
            'DB_CONNECTION' => $driver,
        ];

        if ($driver !== 'sqlite') {
            $connection = $config['connections'][$driver];
            $envVars['DB_HOST'] = $connection['host'];
            $envVars['DB_PORT'] = $connection['port'];
            $envVars['DB_DATABASE'] = $connection['database'];
            $envVars['DB_USERNAME'] = $connection['username'];
            $envVars['DB_PASSWORD'] = $connection['password'];
        } else {
            $envVars['DB_DATABASE'] = $config['connections']['sqlite']['database'];
        }

        $this->updateEnvFile($envVars);
    }

    /**
     * Update .env file with given key-value pairs.
     */
    private function updateEnvFile(array $values): void
    {
        $envPath = base_path('.env');

        if (! file_exists($envPath)) {
            return;
        }

        $envContent = file_get_contents($envPath);

        foreach ($values as $key => $value) {
            $escapedValue = str_replace('"', '\\"', $value);

            if (preg_match("/^{$key}=.*/m", $envContent)) {
                $envContent = preg_replace("/^{$key}=.*/m", "{$key}=\"{$escapedValue}\"", $envContent);
            } else {
                $envContent .= "\n{$key}=\"{$escapedValue}\"";
            }
        }

        file_put_contents($envPath, $envContent);
    }

    /**
     * Set a session flag for wizard state tracking.
     */
    private function setSessionFlag(string $key, mixed $value): bool
    {
        session()->put($key, $value);

        return true;
    }
}
