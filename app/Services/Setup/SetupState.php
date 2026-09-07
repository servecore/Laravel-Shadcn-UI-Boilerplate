<?php

namespace App\Services\Setup;

/**
 * Manages the setup wizard's completion state.
 *
 * Uses a marker file on disk for persistent state and a state file
 * for wizard step tracking. Session-based flags are avoided because
 * APP_KEY generation during the wizard invalidates the session cookie,
 * causing lost state between requests.
 */
class SetupState
{
    private const SETUP_MARKER = '.setup-complete';

    private const STATE_FILE = '.setup-state';

    /**
     * Check if the application setup is complete.
     */
    public function isSetup(): bool
    {
        return file_exists(base_path(self::SETUP_MARKER));
    }

    /**
     * Mark setup as complete by writing the marker file with timestamp.
     *
     * Includes installed_by for audit trail (adopted from InstallerErag).
     */
    public function markComplete(): void
    {
        $data = [
            'completed_at' => now()->toIso8601String(),
            'version' => '1.0.0',
            'installed_by' => auth()->user()?->name ?? 'Unknown',
        ];

        file_put_contents(
            base_path(self::SETUP_MARKER),
            json_encode($data, JSON_PRETTY_PRINT)
        );

        // Clean up state file after setup is complete.
        $this->clearState();
    }

    /**
     * Get setup completion info from the marker file.
     */
    public function getCompletionInfo(): ?array
    {
        if (! $this->isSetup()) {
            return null;
        }

        $content = file_get_contents(base_path(self::SETUP_MARKER));
        $data = json_decode($content, true);

        return is_array($data) ? $data : null;
    }

    /**
     * Set a wizard state flag, persisted to a file on disk.
     *
     * File-based state is used instead of session because APP_KEY
     * generation during setup invalidates session cookies, causing
     * state loss between requests.
     *
     * Returns true so callers can use it in guard expressions.
     */
    public function setFlag(string $key, mixed $value): bool
    {
        $state = $this->loadState();
        $state[$key] = $value;
        $this->saveState($state);

        return true;
    }

    /**
     * Get a wizard state flag value.
     */
    public function getFlag(string $key, mixed $default = null): mixed
    {
        $state = $this->loadState();

        return $state[$key] ?? $default;
    }

    /**
     * Load state from the state file.
     */
    private function loadState(): array
    {
        $path = base_path(self::STATE_FILE);

        if (! file_exists($path)) {
            return [];
        }

        $content = file_get_contents($path);
        $data = json_decode($content, true);

        return is_array($data) ? $data : [];
    }

    /**
     * Save state to the state file.
     */
    private function saveState(array $state): void
    {
        file_put_contents(
            base_path(self::STATE_FILE),
            json_encode($state, JSON_PRETTY_PRINT)
        );
    }

    /**
     * Remove the state file.
     */
    private function clearState(): void
    {
        $path = base_path(self::STATE_FILE);

        if (file_exists($path)) {
            unlink($path);
        }
    }

    /**
     * Remove the setup marker and state files so the wizard becomes accessible again.
     */
    public function reset(): void
    {
        $markerPath = base_path(self::SETUP_MARKER);

        if (file_exists($markerPath)) {
            unlink($markerPath);
        }

        $this->clearState();
    }
}
