<?php

namespace Tests\Feature\Setup;

use App\Http\Middleware\RedirectIfNotSetup;
use App\Models\User;
use App\Services\Setup\EnvFileManager;
use App\Services\Setup\SetupState;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SetupCompleteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withMiddleware(RedirectIfNotSetup::class);
        $this->withMiddleware(StartSession::class);
        $this->bindSetupState(false);
        $this->fakeEnvFileManager();
    }

    public function test_complete_keeps_admin_logged_in_after_session_driver_switch(): void
    {
        $response = $this->post(route('setup.complete'), [
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('dashboard'));

        // The session store used by the request carries the ID that the browser
        // cookie will present. A matching row must exist in the sessions table
        // (with the auth payload) so the admin is not logged out when the
        // session driver swaps from file to database on the next request.
        $sessionId = app('session.store')->getId();

        $session = DB::table('sessions')->where('id', $sessionId)->first();

        $this->assertNotNull($session, 'Session was not persisted to the database driver.');

        $adminId = User::where('email', 'admin@example.com')->value('id');
        $this->assertSame($adminId, $session->user_id);
        $this->assertStringContainsString('login_', base64_decode($session->payload));
    }

    public function test_complete_assigns_admin_role(): void
    {
        $this->post(route('setup.complete'), [
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('dashboard'));

        $admin = User::where('email', 'admin@example.com')->first();

        $this->assertTrue($admin->hasRole('admin'));
        $this->assertTrue($admin->hasPermissionTo('manage users'));
    }

    public function test_save_app_config_rejects_injection_characters_in_app_name(): void
    {
        $this->post(route('setup.save-app-config'), [
            'app_name' => "MyApp\nDB_HOST=evil",
            'app_url' => 'https://example.com',
            'timezone' => 'UTC',
            'locale' => 'en',
            'debug_mode' => false,
        ])->assertSessionHasErrors('app_name');

        $this->assertSame([], app(EnvFileManager::class)->updates);
    }

    public function test_save_app_config_accepts_valid_app_name(): void
    {
        $this->post(route('setup.save-app-config'), [
            'app_name' => 'My Laravel App',
            'app_url' => 'https://example.com',
            'timezone' => 'UTC',
            'locale' => 'en',
            'debug_mode' => false,
        ])->assertRedirect(route('setup.step3'));

        /** @var EnvFileManager $envFile */
        $envFile = app(EnvFileManager::class);
        $this->assertSame('My Laravel App', $envFile->updates['APP_NAME'] ?? null);
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

    /**
     * Replace EnvFileManager with a recording stub so tests never write .env.
     */
    private function fakeEnvFileManager(): void
    {
        $fake = new class extends EnvFileManager
        {
            public array $updates = [];

            public function update(array $values): void
            {
                $this->updates = array_merge($this->updates, $values);
            }

            public function generateAppKey(): void {}
        };

        $this->app->instance(EnvFileManager::class, $fake);
    }
}
