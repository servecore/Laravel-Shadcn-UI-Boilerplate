<?php

namespace App\Http\View\Creators;

use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

/**
 * Builds the frontend app-config payload shared with layouts.app.
 *
 * Keeps Blade clean: the layout only renders json_encode($appConfig).
 * Route names come from config/js-routes.php; settings from the Setting model.
 *
 * Laravel dispatches View::creator() to the create() method
 * (see Illuminate\View\Concerns\ManagesEvents::buildClassEventCallback).
 */
class AppConfigCreator
{
    public function create(View $view): void
    {
        $view->with('appConfig', [
            'baseUrl' => url('/'),
            'locale' => app()->getLocale(),
            'theme' => [
                'default' => \App\Models\Setting::get('theme.default', 'system'),
            ],
            'routes' => $this->resolveRoutes(),
        ]);
    }

    /**
     * Resolve configured route names to URLs.
     *
     * @return array<string, string>
     */
    private function resolveRoutes(): array
    {
        $routes = [];

        foreach (config('js-routes', []) as $routesByEntity) {
            foreach ($routesByEntity as $name) {
                if (Route::has($name)) {
                    $routes[$name] = route($name);
                }
            }
        }

        return $routes;
    }
}
