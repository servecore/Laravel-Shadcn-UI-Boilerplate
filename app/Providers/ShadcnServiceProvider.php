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
     * The path to the cached component alias manifest.
     *
     * @var string
     */
    private const CACHE_PATH = 'bootstrap/cache/components.php';

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
     * Uses a cached manifest at bootstrap/cache/components.php so the
     * filesystem is not scanned and every component class is not autoloaded on
     * each request. Run `php artisan shadcn:cache` to rebuild the manifest
     * after adding or removing components (e.g. during deployment).
     *
     * In the local environment the manifest is rebuilt from disk on every
     * request, so newly created components are registered immediately without
     * needing to run the cache command manually.
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
     * In local development the cache is intentionally ignored so components
     * added or removed while developing are always picked up right away.
     *
     * @return array<string, string>
     */
    protected function loadCachedAliases(): array
    {
        $cachePath = base_path(self::CACHE_PATH);

        if ($this->app->environment('local') || ! file_exists($cachePath)) {
            return $this->buildComponentAliases();
        }

        return require $cachePath;
    }

    /**
     * Scan app/View/Components and build the alias => class mapping.
     *
     * CompileAsChild is skipped here because it is registered explicitly in
     * registerCompileAsChild(). PHP files without a loadable class are skipped,
     * and aliases are sorted so the generated manifest is deterministic.
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

            if ($alias === 'compile-as-child' || ! class_exists($class)) {
                continue;
            }

            $aliases[$alias] = $class;
        }

        ksort($aliases);

        return $aliases;
    }

    /**
     * Write the component alias map to the cache file.
     *
     * @param  array<string, string>  $aliases
     */
    public static function writeCache(array $aliases): void
    {
        $cachePath = base_path(self::CACHE_PATH);

        File::ensureDirectoryExists(dirname($cachePath));
        File::put($cachePath, "<?php\n\nreturn ".var_export($aliases, true).";\n");
    }

    /**
     * Clear the cached component aliases.
     */
    public static function clearCache(): void
    {
        $cachePath = base_path(self::CACHE_PATH);

        if (file_exists($cachePath)) {
            File::delete($cachePath);
        }
    }
}
