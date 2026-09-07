<?php

namespace App\Console\Commands\Setup;

use App\Services\Setup\SetupState;
use Illuminate\Console\Command;

class SetupStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display the current setup wizard status';

    public function __construct(private readonly SetupState $setupState)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $completed = $this->setupState->isSetup();

        if (! $completed) {
            $this->warn('Setup: NOT completed');

            $this->line('The setup wizard will appear on the next page visit.');

            return self::SUCCESS;
        }

        $this->info('Setup: Completed');

        $info = $this->setupState->getCompletionInfo();

        if ($info !== null) {
            $this->table(['Field', 'Value'], [
                ['Completed at', $info['completed_at'] ?? 'Unknown'],
                ['Version', $info['version'] ?? 'Unknown'],
                ['Installed by', $info['installed_by'] ?? 'Unknown'],
            ]);
        }

        $this->newLine();
        $this->line('To reset, run:');

        $this->line('  php artisan setup:reset');

        return self::SUCCESS;
    }
}
