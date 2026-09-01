<?php

namespace App\Providers;

use App\Http\Controllers\SetupWizardController;
use App\Support\ToastFactory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Spatie\Permission\PermissionRegistrar;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once app_path('Support/helpers.php');
        $this->app->singleton(ToastFactory::class, fn () => new ToastFactory);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->generateAppKeyIfNeeded();
        $this->forceFileSessionDuringSetup();

        // Permissions are cached by Spatie; flush whenever the app boots so
        // role changes are picked up immediately after seeding/permission edits.
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    /**
     * Auto-generate APP_KEY if not set during setup wizard.
     *
     * Laravel 13 requires APP_KEY for session, CSRF, etc.
     * Without it, the setup wizard cannot even load.
     */
    private function generateAppKeyIfNeeded(): void
    {
        if (! SetupWizardController::isSetup() && empty(config('app.key'))) {
            $envPath = base_path('.env');

            if (file_exists($envPath)) {
                $content = file_get_contents($envPath);
                $key = 'base64:'.base64_encode(Str::random(32));

                // Replace empty APP_KEY or append if not found
                if (preg_match('/^APP_KEY=.*$/m', $content)) {
                    $content = preg_replace('/^APP_KEY=.*$/m', "APP_KEY=\"{$key}\"", $content);
                } else {
                    $content .= "\nAPP_KEY=\"{$key}\"";
                }

                file_put_contents($envPath, $content);

                // Reload config with new key
                config(['app.key' => $key]);
            }
        }
    }

    /**
     * During setup wizard, force file-based session.
     *
     * The database may not exist yet (or may have a wrong config),
     * so database session driver would crash on every request.
     */
    private function forceFileSessionDuringSetup(): void
    {
        if (! SetupWizardController::isSetup()) {
            config(['session.driver' => 'file']);
        }
    }
}
