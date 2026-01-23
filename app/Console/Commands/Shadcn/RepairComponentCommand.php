<?php

namespace App\Console\Commands\Shadcn;

class RepairComponentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shadcn:repair {--force : Overwrite existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Repair Shadcn UI system files (e.g. ServiceProvider) from local stubs.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🛠️  Shadcn UI System Repair');
        $this->newLine();

        $filesToRepair = [
            'ShadcnServiceProvider.php' => [
                'source' => 'resources/shadcn-stubs/ShadcnServiceProvider.php',
                'dest' => 'app/Providers/ShadcnServiceProvider.php'
            ]
        ];

        foreach ($filesToRepair as $name => $paths) {
            $source = base_path($paths['source']);
            $dest = base_path($paths['dest']);

            if (!$this->fs->exists($source)) {
                $this->error("  ❌ Missing stub for: {$name} (Cannot repair)");
                continue;
            }

            if ($this->fs->exists($dest) && !$this->option('force')) {
                $this->line("  ✓ Exists: {$name}");
                continue;
            }

            $this->fs->copy($source, $dest);
            $this->info("  ✅ Restored: {$name}");
        }

        $this->ensureProviderRegistered();

        $this->newLine();
        $this->info('Repair process completed.');

        return self::SUCCESS;
    }

    /**
     * Ensure the ServiceProvider is registered in bootstrap/providers.php
     */
    protected function ensureProviderRegistered(): void
    {
        $providersPath = base_path('bootstrap/providers.php');

        if (!$this->fs->exists($providersPath)) {
            $this->warn('  ⚠️  bootstrap/providers.php not found. Cannot register ServiceProvider.');
            return;
        }

        $content = $this->fs->get($providersPath);
        $providerClass = 'App\Providers\ShadcnServiceProvider::class';

        // Check if provider is already registered (handling potential trailing commas or whitespace)
        if (preg_match('/' . preg_quote($providerClass, '/') . '/', $content)) {
            $this->line("  ✓ Registered: ShadcnServiceProvider");
            return;
        }

        // Insert before the closing bracket
        $newContent = str_replace(
            '];',
            "    {$providerClass},\n];",
            $content
        );

        $this->fs->put($providersPath, $newContent);
        $this->info("  ✅ Registered: ShadcnServiceProvider");
    }
}
