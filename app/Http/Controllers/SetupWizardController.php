<?php

namespace App\Http\Controllers;

use App\Http\Requests\Setup\SetupAdminRequest;
use App\Http\Requests\Setup\SetupAppConfigRequest;
use App\Http\Requests\Setup\SetupDatabaseRequest;
use App\Models\User;
use App\Services\Setup\DatabaseConfigurator;
use App\Services\Setup\EnvFileManager;
use App\Services\Setup\EnvironmentChecker;
use App\Services\Setup\PermissionChecker;
use App\Services\Setup\SetupState;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

use function collect;

class SetupWizardController extends Controller
{
    public function __construct(
        private readonly SetupState $state,
        private readonly EnvironmentChecker $envChecker,
        private readonly EnvFileManager $envFile,
        private readonly DatabaseConfigurator $dbConfig,
        private readonly PermissionChecker $permissionChecker,
    ) {}

    /**
     * Check if the application has been set up.
     *
     * Static wrapper used by RedirectIfNotSetup middleware.
     */
    public static function isSetup(): bool
    {
        return app(SetupState::class)->isSetup();
    }

    // ---------------------------------------------------------------
    // Step 1: Environment Check
    // ---------------------------------------------------------------

    public function step1(): View
    {
        $checks = $this->envChecker->run();

        return view('setup.step1', [
            'checks' => $checks,
            'allPassed' => collect($checks)->every(fn (array $check) => $check['passed']),
        ]);
    }

    // ---------------------------------------------------------------
    // Step 2: Application Configuration
    // ---------------------------------------------------------------

    public function step2(): View|RedirectResponse
    {
        if (! $this->envChecker->criticalChecksPassed()) {
            return redirect()->route('setup.step1');
        }

        return view('setup.step2', [
            'appName' => config('app.name', 'Laravel'),
            'appUrl' => config('app.url', 'http://localhost'),
            'timezone' => config('app.timezone', 'UTC'),
            'locale' => config('app.locale', 'en'),
        ]);
    }

    public function saveAppConfig(SetupAppConfigRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $this->envFile->update([
            'APP_NAME' => $validated['app_name'],
            'APP_URL' => $validated['app_url'],
            'APP_TIMEZONE' => $validated['timezone'],
            'APP_LOCALE' => $validated['locale'],
            'APP_DEBUG' => $validated['debug_mode'] ? 'true' : 'false',
        ]);

        // Auto-generate APP_KEY if not set (adopted from InstallerErag)
        $this->envFile->generateAppKey();

        return redirect()->route('setup.step3');
    }

    // ---------------------------------------------------------------
    // Step 3: Database Configuration
    // ---------------------------------------------------------------

    public function step3(): View
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

    public function testConnection(Request $request): JsonResponse
    {
        try {
            $driver = $request->input('driver');

            // Reject if driver is missing or not supported
            if (! in_array($driver, ['sqlite', 'mysql', 'pgsql'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid database driver selected.',
                ]);
            }

            // Validate required fields for server databases
            if (in_array($driver, ['mysql', 'pgsql'])) {
                $validator = Validator::make($request->all(), [
                    'host' => ['required', 'string'],
                    'port' => ['required', 'integer', 'min:1', 'max:65535'],
                    'database' => ['required', 'string'],
                    'username' => ['required', 'string'],
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Please fill in all required fields: '.implode(', ', array_keys($validator->errors()->toArray())),
                    ]);
                }
            }

            $config = $this->dbConfig->buildFromRequest($request, $driver);
            $conn = $config['connections'][$driver];

            // Test with a direct PDO connection (5s timeout)
            $pdo = $this->createTestPdo($driver, $conn);

            // Check if database already has tables (reinstall scenario)
            $existingTables = $this->checkExistingTables($pdo, $driver);
            $pdo = null; // Close connection

            if ($existingTables > 0) {
                return response()->json([
                    'success' => true,
                    'message' => "Connection successful! Database already has {$existingTables} table(s). Running migration will add missing tables and update existing ones.",
                    'has_data' => true,
                    'table_count' => $existingTables,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Connection successful! Database is empty and ready for setup.',
                'has_data' => false,
                'table_count' => 0,
            ]);
        } catch (\PDOException $e) {
            Log::error('Database test connection failed', [
                'driver' => $driver ?? 'unknown',
                'host' => $conn['host'] ?? 'unknown',
                'port' => $conn['port'] ?? 'unknown',
                'database' => $conn['database'] ?? 'unknown',
                'username' => $conn['username'] ?? 'unknown',
                'password_empty' => empty($conn['password'] ?? ''),
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Connection failed: '.$this->humanizePdoError($e),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Check how many tables exist in the database.
     */
    private function checkExistingTables(\PDO $pdo, string $driver): int
    {
        $sql = match ($driver) {
            'mysql' => 'SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_type = "BASE TABLE"',
            'pgsql' => "SELECT COUNT(*) FROM information_schema.tables WHERE table_catalog = current_database() AND table_schema = 'public' AND table_type = 'BASE TABLE'",
            'sqlite' => "SELECT COUNT(*) FROM sqlite_master WHERE type = 'table' AND name NOT LIKE 'sqlite_%'",
        };

        $stmt = $pdo->query($sql);

        return (int) $stmt->fetchColumn();
    }

    /**
     * Create a PDO connection for testing with a timeout.
     */
    private function createTestPdo(string $driver, array $config): \PDO
    {
        $timeout = 5; // seconds

        if ($driver === 'sqlite') {
            return new \PDO('sqlite:'.$config['database'], null, null, [
                \PDO::ATTR_TIMEOUT => $timeout,
            ]);
        }

        $dsn = "$driver:host={$config['host']};port={$config['port']};dbname={$config['database']}";
        $options = [
            \PDO::ATTR_TIMEOUT => $timeout,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        ];

        return new \PDO($dsn, $config['username'], $config['password'] ?? '', $options);
    }

    /**
     * Convert PDO exception to a user-friendly message.
     */
    private function humanizePdoError(\PDOException $e): string
    {
        $msg = $e->getMessage();
        $code = $e->getCode();

        // Common PDO error patterns
        if (str_contains($msg, 'SQLSTATE[HY000]') && str_contains($msg, '2002')) {
            return 'Could not connect to database server. Check host and port.';
        }

        if (str_contains($msg, 'SQLSTATE[HY000]') && str_contains($msg, '1045')) {
            return 'Access denied. Check username and password.';
        }

        if (str_contains($msg, 'SQLSTATE[HY000]') && str_contains($msg, '1049')) {
            return 'Unknown database. Check database name.';
        }

        if (str_contains($msg, 'SQLSTATE[08006]')) {
            // PostgreSQL 08006 covers multiple failure types — differentiate them.
            if (str_contains($msg, 'no password supplied') || str_contains($msg, 'password authentication failed')) {
                return 'Authentication failed. Check username and password.';
            }

            if (str_contains($msg, 'does not exist') || str_contains($msg, 'tidak ada')) {
                return 'Database not found. Check database name.';
            }

            return 'Could not connect to PostgreSQL server. Check host, port, and ensure PostgreSQL is running.';
        }

        if (str_contains($msg, 'SQLSTATE[08001]') || str_contains($msg, 'SQLSTATE[08004]')) {
            return 'Connection rejected. Check host, port, and credentials.';
        }

        // Fallback: strip SQLSTATE prefix for readability
        $msg = preg_replace('/SQLSTATE\[[\w]+\]:\s*/', '', $msg);

        return $msg;
    }

    public function saveDatabaseConfig(SetupDatabaseRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $driver = $validated['driver'];

        $config = $this->dbConfig->buildFromValidated($validated, $driver);
        $connConfig = $config['connections'][$driver];

        // Test connection FIRST before writing .env.
        // Prevents leaving .env in a broken state if connection fails.
        if ($driver !== 'sqlite') {
            try {
                $pdo = $this->createTestPdo($driver, $connConfig);
                $existingTables = $this->checkExistingTables($pdo, $driver);
                $pdo = null;
            } catch (\PDOException $e) {
                Log::error('Database save config failed', [
                    'driver' => $driver,
                    'host' => $connConfig['host'] ?? 'unknown',
                    'port' => $connConfig['port'] ?? 'unknown',
                    'database' => $connConfig['database'] ?? 'unknown',
                    'username' => $connConfig['username'] ?? 'unknown',
                    'password_empty' => empty($connConfig['password'] ?? ''),
                    'error_code' => $e->getCode(),
                    'error_message' => $e->getMessage(),
                ]);

                return back()->withErrors([
                    'database' => 'Connection failed: '.$this->humanizePdoError($e),
                ]);
            }
        }

        $this->envFile->updateDatabaseConfig($driver, $connConfig);

        try {
            // Override runtime config so the rest of this request uses the NEW database.
            config([
                'database.default' => $driver,
                'database.connections.'.$driver => $connConfig,
            ]);

            DB::purge($driver);

            // Use Migrator directly instead of Artisan::call('migrate').
            // Artisan::call() crashes the `artisan serve` built-in PHP web server
            // when invoked from within a request handler — the server resets the
            // TCP connection (curl errno 56 / NS_ERROR_NET_EMPTY_RESPONSE).
            // The Migrator runs the same migration logic without CLI bootstrapping.
            $migrator = app('migrator');
            $path = database_path('migrations');
            $migrator->usingConnection($driver, function () use ($migrator, $path) {
                $migrator->run($path);
            });

            $this->state->setFlag('setup_migrated', true);
        } catch (\Throwable $e) {
            Log::error('Database migration failed', [
                'driver' => $driver,
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return back()->withErrors([
                'database' => 'Migration failed: '.$e->getMessage(),
            ]);
        }

        return redirect()->route('setup.step4');
    }

    // ---------------------------------------------------------------
    // Step 4: Admin Account
    // ---------------------------------------------------------------

    public function step4(): View|RedirectResponse
    {
        if (! $this->state->getFlag('setup_migrated')) {
            return redirect()->route('setup.step3');
        }

        return view('setup.step4');
    }

    public function complete(SetupAdminRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            $user = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'email_verified_at' => now(),
                'password' => $validated['password'],
                'is_active' => true,
                'created_by' => 'Setup Wizard',
            ]);

            // Ensure the admin role and its permissions exist, then assign them
            // to the newly created admin account. (The setup wizard only runs
            // migrations, not seeders, so the role tree is created here.)
            (new RolePermissionSeeder)->run();
            $user->assignRole('admin');

            Auth::login($user);

            $this->state->markComplete();

            // Switch session/cache/queue to database after the admin is logged in.
            // Doing this mid-wizard would wipe the session flags (setup_migrated)
            // needed to reach step 4, so it's deferred until setup is fully done.
            $this->envFile->update([
                'CACHE_STORE' => 'database',
                'SESSION_DRIVER' => 'database',
                'QUEUE_CONNECTION' => 'database',
            ]);

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
}
