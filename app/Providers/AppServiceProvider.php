<?php

namespace App\Providers;

use App\Http\Controllers\SetupWizardController;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->forceFileSessionDuringSetup();
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
