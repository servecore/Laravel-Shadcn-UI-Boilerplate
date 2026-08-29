<?php

namespace App\Http\Controllers;

use App\Http\Requests\Setup\SetupAdminRequest;
use App\Http\Requests\Setup\SetupAppConfigRequest;
use App\Http\Requests\Setup\SetupDatabaseRequest;
use App\Models\User;
use App\Services\Setup\DatabaseConfigurator;
use App\Services\Setup\EnvFileManager;
use App\Services\Setup\EnvironmentChecker;
use App\Services\Setup\SetupState;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class SetupWizardController extends Controller
{
    public function __construct(
        private readonly SetupState $state,
        private readonly EnvironmentChecker $envChecker,
        private readonly EnvFileManager $envFile,
        private readonly DatabaseConfigurator $dbConfig,
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
        $driver = $request->input('driver', 'sqlite');

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

        try {
            $config = $this->dbConfig->buildFromRequest($request, $driver);

            // Override runtime config only (do NOT write .env) so the test stays read-only.
            config([
                'database.default' => $driver,
                'database.connections.'.$driver => $config['connections'][$driver],
            ]);

            DB::purge($driver);

            DB::connection($driver)->getPdo();

            return response()->json([
                'success' => true,
                'message' => 'Database connection successful!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Connection failed: '.$this->sanitizeErrorMessage($e->getMessage()),
            ]);
        }
    }

    /**
     * Sanitize error message to remove sensitive connection details.
     */
    private function sanitizeErrorMessage(string $message): string
    {
        $message = preg_replace('/SQLSTATE\[[\w]+\]:\s*/', '', $message);
        $message = preg_replace('/\d+ [\w\s]+:\s*/', '', $message);

        return $message;
    }

    public function saveDatabaseConfig(SetupDatabaseRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $driver = $validated['driver'];

        $config = $this->dbConfig->buildFromValidated($validated, $driver);
        $this->envFile->updateDatabaseConfig($driver, $config['connections'][$driver]);

        try {
            // Override runtime config so migrate runs against the NEW database.
            config([
                'database.default' => $driver,
                'database.connections.'.$driver => $config['connections'][$driver],
            ]);

            DB::purge($driver);

            Artisan::call('migrate', [
                '--force' => true,
                '--no-interaction' => true,
            ]);

            $this->state->setFlag('setup_migrated', true);

            // Defer env updates for session/cache/queue until after the response
            // is sent. Changing SESSION_DRIVER mid-request breaks the current session.
            app()->terminating(function () {
                $this->envFile->update([
                    'CACHE_STORE' => 'database',
                    'SESSION_DRIVER' => 'database',
                    'QUEUE_CONNECTION' => 'database',
                ]);

                Artisan::call('config:clear');
            });
        } catch (\Exception $e) {
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

            Auth::login($user);

            $this->state->markComplete();

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
