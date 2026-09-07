<?php

namespace Tests\Feature\Setup;

use App\Services\Setup\EnvFileManager;
use Tests\TestCase;

class EnvFileManagerTest extends TestCase
{
    private EnvFileManager $manager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->manager = new EnvFileManager;
    }

    public function test_update_creates_key_if_not_exists(): void
    {
        $envPath = base_path('.env');
        $backup = file_get_contents($envPath);

        try {
            $testKey = 'TEST_INSTALLER_'.uniqid();
            $this->manager->update([$testKey => 'test-value']);

            $content = file_get_contents($envPath);
            $this->assertStringContainsString("{$testKey}=\"test-value\"", $content);
        } finally {
            file_put_contents($envPath, $backup);
        }
    }

    public function test_update_replaces_existing_key(): void
    {
        $envPath = base_path('.env');
        $backup = file_get_contents($envPath);

        try {
            // First set
            $this->manager->update(['TEST_REPLACE' => 'old-value']);

            // Then replace
            $this->manager->update(['TEST_REPLACE' => 'new-value']);

            $content = file_get_contents($envPath);
            $this->assertStringContainsString('TEST_REPLACE="new-value"', $content);
            $this->assertStringNotContainsString('TEST_REPLACE="old-value"', $content);
        } finally {
            file_put_contents($envPath, $backup);
        }
    }

    public function test_generate_app_key_does_not_overwrite_existing(): void
    {
        $envPath = base_path('.env');
        $backup = file_get_contents($envPath);

        try {
            // Set a known key first
            $this->manager->update(['APP_KEY' => 'base64:existing-key']);

            // Try to generate
            $this->manager->generateAppKey();

            $content = file_get_contents($envPath);
            $this->assertStringContainsString('APP_KEY="base64:existing-key"', $content);
        } finally {
            file_put_contents($envPath, $backup);
        }
    }

    public function test_generate_app_key_creates_key_when_empty(): void
    {
        $envPath = base_path('.env');
        $backup = file_get_contents($envPath);

        try {
            // Remove APP_KEY
            $content = file_get_contents($envPath);
            $content = preg_replace('/^APP_KEY=.*/m', 'APP_KEY=', $content);
            file_put_contents($envPath, $content, LOCK_EX);

            $this->manager->generateAppKey();

            $content = file_get_contents($envPath);
            $this->assertMatchesRegularExpression('/^APP_KEY="base64:.+"$/m', $content);
        } finally {
            file_put_contents($envPath, $backup);
        }
    }

    public function test_update_escapes_quotes_backslashes_and_newlines(): void
    {
        $envPath = base_path('.env');
        $backup = file_get_contents($envPath);

        try {
            $this->manager->update(['TEST_ESCAPE' => "a\"b\nc\\d"]);

            $content = file_get_contents($envPath);
            $this->assertStringContainsString('TEST_ESCAPE="a\"b\nc\\\\d"', $content);
        } finally {
            file_put_contents($envPath, $backup);
        }
    }

    public function test_update_does_not_inject_new_env_lines(): void
    {
        $envPath = base_path('.env');
        $backup = file_get_contents($envPath);

        try {
            $evilValue = "legit\n#INJECTED_KEY=1";
            $this->manager->update(['TEST_INJECT' => $evilValue]);

            $content = file_get_contents($envPath);

            // The whole value stays on one line inside quotes — no standalone
            // comment/injection line is ever created.
            $this->assertStringNotContainsString("\n#INJECTED_KEY=1", $content);
            $this->assertStringContainsString('TEST_INJECT="legit\n#INJECTED_KEY=1"', $content);
        } finally {
            file_put_contents($envPath, $backup);
        }
    }
}
