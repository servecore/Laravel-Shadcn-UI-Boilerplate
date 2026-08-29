<?php

namespace App\Providers;

use App\View\Components\Compiler\CompileAsChild;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
     * Uses a cached manifest at bootstrap/cache/components.php to avoid
     * scanning the filesystem and autoloading every component class on
     * every request. Run `php artisan shadcn:cache` to rebuild after
     * adding or removing components.
     */
    protected function registerComponentAliases(): void
    {
        $aliases = $this->loadCachedAliases();

        foreach ($aliases as $alias => $class) {
            Blade::component($alias, $class);
        }
    }

    /**
     * Load the component alias map from cache, or build it on first run.
     *
     * @return array<string, string>
     */
    protected function loadCachedAliases(): array
    {
        $cachePath = base_path('bootstrap/cache/components.php');

        if (file_exists($cachePath)) {
            return require $cachePath;
        }

        $aliases = $this->buildComponentAliases();

        $this->writeCache($aliases);

        return $aliases;
    }

    /**
     * Scan app/View/Components and build the alias => class mapping.
     *
     * @return array<string, string>
     */
    public static function buildComponentAliases(): array
    {
        $componentsPath = app_path('View/Components');

        if (! is_dir($componentsPath)) {
            return [];
        }

        $aliases = [];

        foreach (File::allFiles($componentsPath) as $file) {
            $relativePath = $file->getRelativePathname();
            $class = 'App\\View\\Components\\'.str_replace(['/', '.php'], ['\\', ''], $relativePath);
            $name = $file->getFilenameWithoutExtension();
            $alias = Str::kebab($name);

            $aliases[$alias] = $class;
        }

        return $aliases;
    }

    /**
     * Write the component alias map to the cache file.
     *
     * @param  array<string, string>  $aliases
     */
    public static function writeCache(array $aliases): void
    {
        $cachePath = base_path('bootstrap/cache/components.php');

        File::put($cachePath, "<?php\n\nreturn ".var_export($aliases, true).";\n");
    }

    /**
     * Clear the cached component aliases.
     */
    public static function clearCache(): void
    {
        $cachePath = base_path('bootstrap/cache/components.php');

        if (file_exists($cachePath)) {
            File::delete($cachePath);
        }
    }
}
