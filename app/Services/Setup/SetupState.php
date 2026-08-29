<?php

namespace App\Services\Setup;

/**
 * Manages the setup wizard's completion state.
 *
 * Uses a marker file on disk for persistent state and session flags
 * for transient step guards.
 */
class SetupState
{
    private const SETUP_MARKER = '.setup-complete';

    /**
     * Check if the application setup is complete.
     */
    public function isSetup(): bool
    {
        return file_exists(base_path(self::SETUP_MARKER));
    }

    /**
     * Mark setup as complete by writing the marker file.
     */
    public function markComplete(): void
    {
        file_put_contents(base_path(self::SETUP_MARKER), json_encode([
            'completed_at' => now()->toIso8601String(),
            'version' => '1.0.0',
        ]));
    }

    /**
     * Set a session flag for wizard step tracking.
     *
     * Returns true so callers can use it in guard expressions.
     */
    public function setFlag(string $key, mixed $value): bool
    {
        session()->put($key, $value);

        return true;
    }

    /**
     * Get a session flag value.
     */
    public function getFlag(string $key, mixed $default = null): mixed
    {
        return session($key, $default);
    }
}
