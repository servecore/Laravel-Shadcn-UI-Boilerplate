<?php

namespace App\Console\Commands\Shadcn;

class RemoveComponentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shadcn:remove { components* : Components to remove. } { --force : Skip confirmation. }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove Shadcn UI components from your project. (Standalone version)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info('🗑️  Shadcn UI Component Remover (Standalone)');
        $this->newLine();

        $components = $this->components();

        if (empty($components)) {
            $this->warn('No components found to remove.');
            return self::SUCCESS;
        }

        foreach ($components as $component) {
            $this->removeComponent($component);
        }

        $this->newLine();
        $this->info('✅ Done!');

        return self::SUCCESS;
    }

    /**
     * Remove a component from the project.
     *
     * @param array{name: string, path: string, view: string} $component
     *
     * @return void
     */
    protected function removeComponent(array $component): void
    {
        $name = $component['name'];

        if ($this->componentDoesNotExist($component)) {
            $this->line("  ⏭️  Not found: {$name}");
            return;
        }

        if (!$this->option('force')) {
            if (!$this->confirm("Are you sure you want to remove {$name} component?")) {
                $this->line("  ⏭️  Skipped: {$name}");
                return;
            }
        }

        // Remove PHP class files
        $classPath = base_path(self::CLASS_PATH . "/{$name}");
        if ($this->fs->exists($classPath)) {
            $this->fs->deleteDirectory($classPath);
            $this->line("  ✓ Removed: app/View/Components/{$name}");
        }

        // Remove Blade views
        $viewPath = base_path(self::VIEW_PATH . "/{$component['view']}");
        if ($this->fs->exists($viewPath)) {
            $this->fs->deleteDirectory($viewPath);
            $this->line("  ✓ Removed: resources/views/components/{$component['view']}");
        }

        // Remove JS file if exists
        $jsFile = base_path(self::JS_PATH . "/{$component['view']}.js");
        if ($this->fs->exists($jsFile)) {
            $this->fs->delete($jsFile);
            $this->line("  ✓ Removed: resources/js/components/{$component['view']}.js");
        }

        $this->info("  ✅ Removed: {$name}");
    }
}
