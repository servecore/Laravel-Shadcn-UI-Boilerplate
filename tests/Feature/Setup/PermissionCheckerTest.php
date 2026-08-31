<?php

namespace Tests\Feature\Setup;

use App\Services\Setup\PermissionChecker;
use Tests\TestCase;

class PermissionCheckerTest extends TestCase
{
    private PermissionChecker $checker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->checker = new PermissionChecker;
    }

    public function test_check_returns_results_for_valid_folders(): void
    {
        $results = $this->checker->check([
            'storage/' => '775',
            'bootstrap/cache/' => '775',
        ]);

        $this->assertArrayHasKey('permissions', $results);
        $this->assertArrayHasKey('errors', $results);
        $this->assertCount(2, $results['permissions']);
    }

    public function test_check_detects_writable_folders(): void
    {
        $results = $this->checker->check([
            'storage/' => '775',
        ]);

        // storage/ should be writable in test environment
        $this->assertTrue($results['permissions'][0]['is_set']);
    }

    public function test_check_detects_nonexistent_folders(): void
    {
        $results = $this->checker->check([
            'nonexistent-folder-'.uniqid() => '775',
        ]);

        $this->assertTrue($results['errors']);
        $this->assertFalse($results['permissions'][0]['is_set']);
        $this->assertEquals('0000', $results['permissions'][0]['current']);
    }

    public function test_run_returns_formatted_results(): void
    {
        $results = $this->checker->run();

        $this->assertIsArray($results);
        $this->assertNotEmpty($results);

        foreach ($results as $result) {
            $this->assertArrayHasKey('label', $result);
            $this->assertArrayHasKey('passed', $result);
            $this->assertArrayHasKey('message', $result);
            $this->assertArrayHasKey('folder', $result);
            $this->assertArrayHasKey('required', $result);
            $this->assertArrayHasKey('current', $result);
        }
    }

    public function test_run_uses_config_permissions(): void
    {
        config(['setup.permissions' => [
            'storage/' => '775',
        ]]);

        $results = $this->checker->run();

        $this->assertCount(1, $results);
        $this->assertEquals('Permission: storage/', $results[0]['label']);
    }
}
