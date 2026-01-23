<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\View\Components\Compiler\CompileAsChild;

class ShadcnServiceProvider extends ServiceProvider
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
        $this->registerCompileAsChild();
        $this->registerComponentAliases();
    }

    /**
     * Register the CompileAsChild component.
     */
    protected function registerCompileAsChild(): void
    {
        Blade::component('compile-as-child', CompileAsChild::class);
    }

    /**
     * Auto-register all Blade component aliases from app/View/Components.
     * 
     * This method scans the components directory and registers each component
     * with a kebab-case alias for easy usage in Blade templates.
     */
    protected function registerComponentAliases(): void
    {
        $componentsPath = app_path('View/Components');

        if (!is_dir($componentsPath)) {
            return;
        }

        $files = File::allFiles($componentsPath);

        foreach ($files as $file) {
            $relativePath = $file->getRelativePathname();
            $class = 'App\\View\\Components\\' . str_replace(['/', '.php'], ['\\', ''], $relativePath);

            if (!class_exists($class)) {
                continue;
            }

            $name = $file->getFilenameWithoutExtension();
            $alias = Str::kebab($name);

            Blade::component($alias, $class);
        }
    }
}
