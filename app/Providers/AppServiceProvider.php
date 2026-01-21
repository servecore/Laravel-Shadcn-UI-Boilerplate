<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Bjnstnkvc\ShadcnUi\ShadcnUiServiceProvider;


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
         ShadcnUiServiceProvider::components();
         $this->registerComponentAliases();
    }

    /**
     * Register component aliases from app/View/Components.
     */
    protected function registerComponentAliases(): void
    {
        $componentsPath = app_path('View/Components');

        if (!is_dir($componentsPath)) {
            return;
        }

        $files = \Illuminate\Support\Facades\File::allFiles($componentsPath);

        foreach ($files as $file) {
            $relativePath = $file->getRelativePathname();
            $class = 'App\\View\\Components\\' . str_replace(['/', '.php'], ['\\', ''], $relativePath);

            if (!class_exists($class)) {
                continue;
            }

            $name = $file->getFilenameWithoutExtension();
            $alias = \Illuminate\Support\Str::kebab($name);

            \Illuminate\Support\Facades\Blade::component($alias, $class);
        }
    }
}
