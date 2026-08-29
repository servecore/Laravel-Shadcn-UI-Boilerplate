<?php

namespace App\Console\Commands\Shadcn;

use App\Providers\ShadcnServiceProvider;
use Illuminate\Console\Command;

class CacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shadcn:cache {--clear : Only clear the component cache without rebuilding it. }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build or clear the cached Shadcn UI component aliases.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if ($this->option('clear')) {
            ShadcnServiceProvider::clearCache();
            $this->info('✅ Shadcn component cache cleared.');

            return self::SUCCESS;
        }

        ShadcnServiceProvider::clearCache();
        $aliases = ShadcnServiceProvider::buildComponentAliases();
        ShadcnServiceProvider::writeCache($aliases);

        $this->info('✅ Shadcn component cache rebuilt with '.count($aliases).' components.');

        return self::SUCCESS;
    }
}
