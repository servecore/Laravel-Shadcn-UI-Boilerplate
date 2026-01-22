<?php

namespace App\Console\Commands\Shadcn;

class AddComponentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shadcn:add { components* : Components to add. } { --force : Overwrites existing components. }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Shadcn UI components to your project. (Standalone version)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('📦 Shadcn UI Component Manager (Standalone)');
        $this->newLine();

        $components = $this->components();

        if (empty($components)) {
            $this->warn('No components found to add.');

            return self::SUCCESS;
        }

        foreach ($components as $component) {
            $this->addComponent($component);
        }

        $this->newLine();
        $this->info('✅ Done! Don\'t forget to register your components in AppServiceProvider if needed.');

        return self::SUCCESS;
    }

    /**
     * Add a component to the project.
     *
     * @param  array{name: string, path: string, view: string}  $component
     */
    protected function addComponent(array $component): void
    {
        $name = $component['name'];

        if ($this->componentExists($component) && ! $this->option('force')) {
            if (! $this->confirm("{$name} component already exists. Do you want to overwrite it?")) {
                $this->line("  ⏭️  Skipped: {$name}");

                return;
            }
        }

        // Create directories
        $classPath = base_path(self::CLASS_PATH."/{$name}");
        $viewPath = base_path(self::VIEW_PATH."/{$component['view']}");
        $jsPath = base_path(self::JS_PATH);

        $this->fs->ensureDirectoryExists($classPath);
        $this->fs->ensureDirectoryExists($viewPath);

        // Copy PHP class files
        if ($this->fs->exists($component['path'])) {
            foreach ($this->fs->files($component['path']) as $file) {
                $content = $this->fs->get($file->getPathname());
                $this->fs->put("{$classPath}/{$file->getBasename()}", $content);
            }
            $this->line("  ✓ Class files: app/View/Components/{$name}");
        }

        // Copy Blade views
        $sourceViewPath = base_path(self::VIEW_PATH."/{$component['view']}");
        if ($this->fs->exists($sourceViewPath)) {
            $this->line("  ✓ Blade views: resources/views/components/{$component['view']}");
        }

        // Copy JS file if exists
        $jsFile = base_path(self::JS_PATH."/{$component['view']}.js");
        if ($this->fs->exists($jsFile)) {
            $this->line("  ✓ JS file: resources/js/components/{$component['view']}.js");
        }

        $this->info("  ✅ Added: {$name}");
    }
}
