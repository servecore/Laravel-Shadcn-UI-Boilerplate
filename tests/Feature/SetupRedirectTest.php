<?php

namespace Tests\Feature;

use App\Http\Middleware\RedirectIfNotSetup;
use App\Services\Setup\SetupState;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SetupRedirectTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withMiddleware(RedirectIfNotSetup::class);
    }

    public function test_wizard_is_reachable_when_setup_is_not_complete(): void
    {
        $this->bindSetupState(false);

        $this->get(route('setup.step2'))
            ->assertOk();
    }

    public function test_wizard_redirects_when_setup_is_complete(): void
    {
        $this->bindSetupState(true);

        $this->get(route('setup.step2'))
            ->assertRedirect(route('dashboard'));
    }

    /**
     * Bind a stub SetupState so tests never touch the real marker file.
     */
    private function bindSetupState(bool $isSetup): void
    {
        $stub = new class($isSetup) extends SetupState
        {
            public function __construct(private readonly bool $setup) {}

            public function isSetup(): bool
            {
                return $this->setup;
            }
        };

        $this->app->instance(SetupState::class, $stub);
    }
}
