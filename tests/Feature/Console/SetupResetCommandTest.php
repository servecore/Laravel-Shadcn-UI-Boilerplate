<?php

namespace Tests\Feature\Console;

use App\Services\Setup\SetupState;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class SetupResetCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @var SetupState&MockObject */
    private $setupState;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setupState = $this->createMock(SetupState::class);
        $this->app->instance(SetupState::class, $this->setupState);
    }

    public function test_reset_fails_when_setup_not_completed(): void
    {
        $this->setupState->method('isSetup')->willReturn(false);
        $this->setupState->expects($this->never())->method('reset');

        $this->artisan('setup:reset')
            ->expectsOutputToContain('not been completed')
            ->assertExitCode(1);
    }

    public function test_reset_removes_marker_and_succeeds(): void
    {
        $this->setupState->method('isSetup')->willReturn(true);
        $this->setupState->expects($this->once())->method('reset');

        $this->artisan('setup:reset --force')
            ->expectsOutputToContain('Setup marker removed')
            ->assertExitCode(0);
    }

    public function test_reset_aborts_when_confirmation_declined(): void
    {
        $this->setupState->method('isSetup')->willReturn(true);
        $this->setupState->expects($this->never())->method('reset');

        $this->artisan('setup:reset')
            ->expectsQuestion(
                'This will remove the setup marker. The setup wizard will appear on the next page visit. Continue?',
                false
            )
            ->assertExitCode(0);
    }

    public function test_reset_refuses_in_production_without_force(): void
    {
        $this->app['env'] = 'production';

        $this->setupState->method('isSetup')->willReturn(true);
        $this->setupState->expects($this->never())->method('reset');

        $this->artisan('setup:reset')
            ->expectsOutputToContain('Refusing to reset setup in production')
            ->assertExitCode(1);
    }

    public function test_reset_allowed_in_production_with_force(): void
    {
        $this->app['env'] = 'production';

        $this->setupState->method('isSetup')->willReturn(true);
        $this->setupState->expects($this->once())->method('reset');

        $this->artisan('setup:reset --force')
            ->expectsOutputToContain('Setup marker removed')
            ->assertExitCode(0);
    }

    public function test_status_reports_setup_not_completed(): void
    {
        $this->setupState->method('isSetup')->willReturn(false);

        $this->artisan('setup:status')
            ->expectsOutputToContain('Setup: NOT completed')
            ->assertExitCode(0);
    }

    public function test_status_prints_completion_info(): void
    {
        $this->setupState->method('isSetup')->willReturn(true);
        $this->setupState->method('getCompletionInfo')->willReturn([
            'completed_at' => '2026-01-01T00:00:00+00:00',
            'version' => '1.2.3',
            'installed_by' => 'Admin User',
        ]);

        $this->artisan('setup:status')
            ->expectsOutputToContain('Setup: Completed')
            ->expectsOutputToContain('2026-01-01T00:00:00+00:00')
            ->expectsOutputToContain('Admin User')
            ->assertExitCode(0);
    }
}
