<?php

namespace App\Console\Commands\Setup;

use App\Services\Setup\SetupState;
use Illuminate\Console\Command;

class SetupResetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:reset {--force : Skip the confirmation prompt}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove setup completion markers so the setup wizard runs again on next visit';

    public function __construct(private readonly SetupState $setupState)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (! $this->setupState->isSetup()) {
            $this->error('Setup has not been completed yet.');

            return self::FAILURE;
        }

        if ($this->laravel->environment('production') && ! $this->option('force')) {
            $this->error('Refusing to reset setup in production. Use --force to override.');

            return self::FAILURE;
        }

        if (! $this->option('force') && ! $this->confirm(
            'This will remove the setup marker. The setup wizard will appear on the next page visit. Continue?'
        )) {
            return self::SUCCESS;
        }

        $this->setupState->reset();

        $this->info('Setup marker removed. The setup wizard will appear on next visit.');

        $this->newLine();
        $this->warn('Note: If you also want a clean database, run:');

        $this->line('  php artisan migrate:fresh --seed');

        return self::SUCCESS;
    }
}
