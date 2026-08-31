<?php

namespace Tests\Feature\Setup;

use App\Services\Setup\EnvironmentChecker;
use Tests\TestCase;

class EnvironmentCheckerTest extends TestCase
{
    private EnvironmentChecker $checker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->checker = app(EnvironmentChecker::class);
    }

    public function test_run_returns_all_required_checks(): void
    {
        $checks = $this->checker->run();

        $this->assertArrayHasKey('php_version', $checks);
        $this->assertArrayHasKey('storage', $checks);
        $this->assertArrayHasKey('cache', $checks);
        $this->assertArrayHasKey('env_file', $checks);
        $this->assertArrayHasKey('app_key', $checks);
    }

    public function test_run_includes_extension_checks(): void
    {
        $checks = $this->checker->run();

        // Should have at least some extension checks
        $extensionChecks = array_filter($checks, fn ($key) => str_starts_with($key, 'ext_'), ARRAY_FILTER_USE_KEY);
        $this->assertNotEmpty($extensionChecks);
    }

    public function test_run_includes_permission_checks(): void
    {
        $checks = $this->checker->run();

        // Should have permission checks from config
        $permissionChecks = array_filter($checks, fn ($key) => str_starts_with($key, 'perm_'), ARRAY_FILTER_USE_KEY);
        $this->assertNotEmpty($permissionChecks);
    }

    public function test_critical_checks_passed_returns_boolean(): void
    {
        $result = $this->checker->criticalChecksPassed();

        $this->assertIsBool($result);
    }

    public function test_php_version_check_uses_config(): void
    {
        config(['setup.core.minPhpVersion' => '8.0.0']);

        $checks = $this->checker->run();

        // Current PHP should pass against 8.0.0
        $this->assertTrue($checks['php_version']['passed']);
    }

    public function test_extensions_check_uses_config(): void
    {
        config(['setup.requirements.php' => ['json', 'mbstring']]);

        $checks = $this->checker->run();

        // Should only have 2 extension checks
        $extensionChecks = array_filter($checks, fn ($key) => str_starts_with($key, 'ext_'), ARRAY_FILTER_USE_KEY);
        $this->assertCount(2, $extensionChecks);
    }
}
